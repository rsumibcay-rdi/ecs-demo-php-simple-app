<?php
namespace MBB\Fields;

class Oembed extends Base {
	public function register_fields() {
		$fields = [
			'std' => true,
		];
		$this->basic = array_slice( $this->basic, 0, 3, true ) + $fields + array_slice( $this->basic, 3, null, true );
	}
}
