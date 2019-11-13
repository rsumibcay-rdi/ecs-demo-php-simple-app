<?php

function zen_do_form_things( $submission, $form ) {
	/*
	$form contains the full markup of the form itself
	$submission is an object with the following attributes:
		id           - the submission id/count (?)
		form_id      - self-explanatory
		data         - array of form values indexed by input name
		ip_address   - the IP of the submitter (presumably?)
		user_agent   - submitter's user-agent string (disabled below)
		referer_url  - seems to be the full url of the page the form was on
		submitted_at - timestamp in the format "yyy-mm-dd hh:mm:ss"
	*/
	if (isset($submission->data['hubspot_form_id'])){
		return zen_post_form_to_hubspot($submission);
	}
}
add_action('hf_form_success', 'zen_do_form_things', 10, 2);

add_filter('hf_validate_form_request_size', 'just_take_it');
function just_take_it($size){
	return false;
}

function logging($e, $f, $d){
	error_log($e);
}
add_action('hf_form_error', 'logging', 10, 3);

// https://developers.hubspot.com/docs/methods/forms/submit_form
function zen_post_form_to_hubspot($submission){
	$hubid = '2378677'; // this is your account ID, prominent everywhere in Hubspot

	$hs_form_id = esc_attr($submission->data['hubspot_form_id']);
	unset($submission->data['hubspot_form_id']);

	$tier = cyber_quiz_result_tier_getter($submission->data['page_id'], $submission->data['module_key'], $submission->data['score']);
	unset($submission->data['page_id'], $submission->data['module_key']);
	// data['tier'] needs to refer to the correct hubspot field ID
	$submission->data['survey_tags'] = $tier['result_tier'];

	$hs_context = array();
	if (isset($submission->ip_address)){
		$hs_context['ipAddress'] = $submission->ip_address;
	}
	if (isset($submission->referer_url)){
		$hs_context['pageUrl'] = $submission->referer_url;
	}
	if (isset($_COOKIE['hubspotutk'])){
		$hs_context['hutk'] = $_COOKIE['hubspotutk'];
	}

	// sanitize and populate the form fields
	$payload = '';
	foreach ($submission->data as $key => $value){
		$payload .= esc_attr($key).'=' . urlencode(trim($value)).'&';
	}
	$payload .= 'hs_context=' . urlencode(json_encode($hs_context));
	// error_log(json_encode($payload));

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
	curl_setopt($ch, CURLOPT_URL, 'https://forms.hubspot.com/uploads/form/v2/'.$hubid.'/'.$hs_form_id);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/x-www-form-urlencoded'
	));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response = curl_exec($ch);
	$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	// error_log($status_code . ' ' . $response);
}
add_action('hf_process_form', function( $form, $submission) {
	$submission->user_agent = '';
}, 10, 2 );

add_action( 'wp_ajax_quiz_results', 'cyber_quiz_result_getter_ajax' );
add_action( 'wp_ajax_nopriv_quiz_results', 'cyber_quiz_result_getter_ajax' );
function cyber_quiz_result_getter_ajax() {
	if (!isset($_POST['survey_score']) || !isset($_POST['pageId'])) {
		cyber_quiz_results_error();
	}

	echo '<li class="results">'.cyber_quiz_result_getter($_POST['pageId'], $_POST['moduleKey'], (int)$_POST['survey_score']).'</li>';
	wp_die(); // this is required to terminate immediately and return a proper response
}
function cyber_quiz_result_getter($page_id, $module_key, $score = 0) {
	$the_result = cyber_quiz_result_tier_getter($page_id, $module_key, $score);

	$_results = '<p class="h2">Your CyberGRX Score is: <span id="score">'. $score. '%</span></p>'.
	'<article class="result_copy">'. $the_result['result_copy']. '</article>';

	return $_results;
}

function cyber_quiz_result_tier_getter($page_id, $module_key, $score = 0){
	$results = acf_repeater($page_id, base64_decode($module_key).'results', array('minimum_score', 'result_tier', 'result_copy'));
	$the_result;

	// loop through results
	foreach ((array)$results as $result){
		if (!isset($result['minimum_score'])) { $result['minimum_score'] = 0; }
		if ( (int)$result['minimum_score'] <= $score){
			$the_result = $result;
		}
	}

	return $the_result;
}
function cyber_quiz_results_error(){
	echo 'Uh oh.';
	wp_die();
}

// longhand is long
function acf_repeater($id, $repeater, $keys = array(), $flat = false){
	$array = array();
	if ($flat && is_array($keys)){$flat = false;}
	if ($field = get_post_meta($id, $repeater, true)){
		for ($i=0; $i < $field; $i++) {
			$_array = array();
			$prefix = $repeater.'_'.$i.'_';
			foreach ((array)$keys as $key){
				$value = get_post_meta($id, $prefix.$key, true);
				if ($value){
					if ($flat){
						$_array = $value;
					} else {
						$_array[$key] = $value;
					}
				}
			}
			if ($_array){
				$array[] = $_array;
			}
		}
	}
	return $array;
}
