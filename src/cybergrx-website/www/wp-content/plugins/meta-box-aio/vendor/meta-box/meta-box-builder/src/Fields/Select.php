<?php
namespace MBB\Fields;

class Select extends Base {
	public function register_fields() {
		$fields = [
			'options'         => ['type' => 'textarea'],
			'std'             => ['type' => 'textarea'],
			'select_all_none' => ['type' => 'checkbox'],
			'multiple'        => ['type' => 'checkbox', 'attrs' => ['ng-change', 'toggleMultiple()']],
		];
		$this->basic = array_slice( $this->basic, 0, 3, true ) + $fields + array_slice( $this->basic, 3, null, true );

		unset( $this->appearance['size'] );
	}
}
