<?php
/**
 * The template file for post title.
 *
 * @package    Meta Box
 * @subpackage MB Frontend Submission
 */

$title = $data->post_id ? get_post_field( 'post_title', $data->post_id ) : '';
$name  = ! empty( $data->config['label_title'] ) ? $data->config['label_title'] : esc_html__( 'Title', 'rwmb-frontend-submission' );

$field = apply_filters(
	'rwmb_frontend_post_title',
	array(
		'type' => 'text',
		'name' => $name,
		'id'   => 'post_title',
		'std'  => $title,
	)
);
$field = RWMB_Field::call( 'normalize', $field );
RWMB_Field::call( $field, 'admin_enqueue_scripts' );
RWMB_Field::call( 'show', $field, false, $data->post_id );
