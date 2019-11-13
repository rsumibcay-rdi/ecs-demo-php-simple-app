<?php
namespace MBB\Fields;

class Button extends Base {
    public function register_fields() {
		$fields = [
			'std' => ['type' => 'text', 'label' => __( 'Button text', 'meta-box-builder' )],
		];
		$this->basic = array_slice( $this->basic, 0, 3, true ) + $fields + array_slice( $this->basic, 3, null, true );

		unset( $this->appearance['size'] );
		unset( $this->appearance['placeholder'] );
    }
}
