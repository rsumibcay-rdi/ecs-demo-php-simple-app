<?php
namespace MBB\Fields;

class Number extends Base {
	public function register_fields() {
		$fields = [
			'std'    => true,
			'minmax' => ['type' => 'custom'],
		];
		$this->basic = array_slice( $this->basic, 0, 3, true ) + $fields + array_slice( $this->basic, 3, null, true );

		unset( $this->appearance['placeholder'] );
	}
}
