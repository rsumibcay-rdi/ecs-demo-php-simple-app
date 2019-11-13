<?php
namespace MBB\Fields;

class Taxonomy extends Base {
	public function register_fields() {
		$taxonomy = '
			<label for="{{field.id}}_taxonomy">' . esc_html__( 'Taxonomy', 'meta-box-builder' ) . '</label>
			<select ng-model="field.taxonomy" ng-change="setTerms( field )" ng-options="tax.slug as tax.name for tax in taxonomies" class="widefat" id="{{field.id}}_taxonomy"></select>';

		$default = '<label for="{{field.id}}_type" >' . esc_html__( 'Default value' ) . '</label>
			<select ng-show="field.multiple == true" ng-model="field.std" ng-options="term.term_id as term.name for term in field.terms" multiple class="widefat" id="{{field.id}}_type"></select>
			<select ng-show="field.multiple == false" ng-model="field.std" ng-options="term.term_id as term.name for term in field.terms" class="widefat" id="{{field.id}}_type"></select>';

		$toggle_all = '<label ng-show="field.field_type == \'select\' || field.field_type == \'select_advanced\' || field.field_type == \'checkbox_list\'">
			<input type="checkbox" ng-model="field.select_all_none" ng-true-value="true" ng-false-value="false"> ' . esc_html__( 'Display "Toggle All" button', 'meta-box-builder' ) . '
		</label>';

		$multiple = '<label ng-show="field.field_type == \'select\' || field.field_type == \'select_advanced\'">
			<input type="checkbox" ng-model="field.multiple" 0="ng-change" 1="toggleMultiple()" ng-true-value="true" ng-false-value="false"> ' . esc_html__( 'Allow to select multiple choices', 'meta-box-builder' ) . '
		</label>';

		$inline = '<label ng-show="field.field_type == \'radio_list\' || field.field_type == \'checkbox_list\'">
			<input type="checkbox" ng-model="field.inline" ng-true-value="true" ng-false-value="false"> ' . esc_html__( 'Display choices in a single line', 'meta-box-builder' ) . '
		</label>';

		$fields = [
			'taxonomy' => [
				'type'    => 'custom',
				'content' => $taxonomy,
			],
			'field_type'  => [
				'type' => 'custom',
			],
			'std' => [
				'type'    => 'custom',
				'content' => $default,
			],
			'select_all_none' => [
				'type'    => 'custom',
				'content' => $toggle_all,
			],
			'multiple' => [
				'type'    => 'custom',
				'content' => $multiple,
			],
			'inline' => [
				'type'    => 'custom',
				'content' => $inline,
			],
		];

		$this->basic = array_slice( $this->basic, 0, 3, true ) + $fields + array_slice( $this->basic, 3, null, true );

		$label = '<a href="https://developer.wordpress.org/reference/functions/get_terms/">' . __( 'Query arguments', 'meta-box-builder' ) . '</a>' . mbb_tooltip( __( 'Query arguments for getting taxonomy terms. Use the same arguments as get_terms().', 'meta-box-builder' ) );
		$query_args = mbb_get_attribute_content( 'key_value', 'query_args',  $label, __( '+ Add Argument', 'meta-box-builder' ) );
		$this->advanced = ['query_args' => ['type' => 'custom', 'content' => $query_args]] + $this->advanced;

		unset( $this->appearance['size'] );
	}
}
