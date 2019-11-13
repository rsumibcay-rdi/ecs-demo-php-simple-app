<?php
namespace MBB\Fields;

use MBB\Attribute;

abstract class Base {
	public $basic;
	public $appearance;
	public $advanced;

	public function __construct() {
		// General tab.
		$this->basic = [
			'id'       => true,
			'name'     => true,
			'desc'     => ['type' => 'textarea'],
			'required' => ['type' => 'checkbox'],
			'clone'    => ['type' => 'custom', 'content' => mbb_get_attribute_content( 'clone' )],
		];

		// Appearance tab.
		$this->appearance = [
			'placeholder'       => true,
			'size'              => ['type' => 'number'],
			'label_description' => true,
			'before'            => ['type' => 'textarea'],
			'after'             => ['type' => 'textarea'],
			'class'             => ['label' => __( 'Custom CSS Class', 'meta-box-builder' )],
		];
		if ( mbb_is_extension_active( 'meta-box-columns' ) ) {
			$this->appearance['columns'] = ['type' => 'custom', 'content' => mbb_get_attribute_content( 'columns' )];
		}

		// Advanced tab.
		$this->advanced = [
			'custom_attributes' => [
				'type'    => 'custom',
				'content' => mbb_get_attribute_content( 'key_value', 'attrs', '', __( '+ Add Attribute', 'meta-box-builder' ) ),
			],
		];
		if ( mbb_is_extension_active( 'meta-box-conditional-logic' ) ) {
			$this->advanced['conditional_logic'] = ['type' => 'custom', 'content' => mbb_get_attribute_content( 'conditional-logic' )];
		}

		$this->register_fields();
		$this->output();
	}

	protected function register_fields() {}

	private function output() {
		?>
		<ul class="ui-tabs">
			<?php if ( $this->basic ) : ?>
				<li class="ui-tab-item {{ pane == 'general' ? 'active' : '' }}">
					<a role="button" href="#" ng-click="setActivePane('general')"><?php esc_html_e( 'General', 'meta-box-builder' ); ?></a>
				</li>
			<?php endif; ?>
			<?php if ( $this->appearance ) : ?>
				<li class="ui-tab-item {{ pane == 'appearance' ? 'active' : '' }}" ng-hide="field.type == 'hidden' || field.type == 'tab'">
					<a role="button" href="#" ng-click="setActivePane('appearance')"><?php esc_html_e( 'Appearance', 'meta-box-builder' ); ?></a>
				</li>
			<?php endif; ?>
			<?php if ( $this->advanced ) : ?>
				<li class="ui-tab-item {{ pane == 'advanced' ? 'active' : '' }}" ng-hide="field.type == 'tab'">
					<a role="button" href="#" ng-click="setActivePane('advanced')"><?php esc_html_e( 'Advanced', 'meta-box-builder' ); ?></a>
				</li>
			<?php endif; ?>
		</ul>

		<?php if ( $this->appearance ) : ?>
			<div class="ui-pane pane-general" ng-show="pane == 'general'">
				<?php $this->output_fields( $this->basic ); ?>
			</div>
		<?php endif; ?>

		<?php if ( $this->appearance ) : ?>
			<div class="ui-pane pane-appearance" ng-show="pane == 'appearance'">
				<?php $this->output_fields( $this->appearance ); ?>
			</div>
		<?php endif; ?>

		<?php if ( $this->advanced ) : ?>
			<div class="ui-pane pane-advanced" ng-show="pane == 'advanced'">
				<?php $this->output_fields( $this->advanced ); ?>
			</div>
		<?php endif; ?>
		<?php
	}

	private function output_fields( $fields ) {
		foreach ( $fields as $key => $field ) {
			if ( ! is_array( $field ) ) {
				echo '<div class="description">';
				echo Attribute::text( $key );
				echo '</div>';
				continue;
			}

			$label = isset( $field['label'] ) ? $field['label'] : null;
			$attrs = isset( $field['attrs'] ) ? $field['attrs'] : array();
			$type  = isset( $field['type'] ) ? $field['type'] : 'text';

			echo '<div class="description">';
			if ( $type === 'custom' ) {
				echo isset( $field['content'] ) ? $field['content'] : mbb_get_attribute_content( $key );
			} else {
				echo Attribute::$type( $key, $label, $attrs );
			}
			echo '</div>';
		}
	}
}
