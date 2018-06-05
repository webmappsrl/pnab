<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ACA_ACF_Column_Media extends ACA_ACF_Column {

	public function register_settings() {
		$this->register_settings_by_type( 'Media' );
	}

	public function get_formatted_id( $id ) {
		return $id;
	}

}
