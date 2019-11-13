<?php
namespace MBB\Fields;

class Textarea extends Base {
    public function register_fields() {
        $fields = [
			'std' => ['type' => 'textarea'],
		];
		$this->basic = array_slice( $this->basic, 0, 3, true ) + $fields + array_slice( $this->basic, 3, null, true );

		$this->appearance['rows_columns'] = [
			'type' => 'custom',
		];
		unset( $this->appearance['size'] );
    }
}
