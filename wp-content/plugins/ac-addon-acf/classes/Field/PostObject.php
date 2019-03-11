<?php

namespace ACA\ACF\Field;

use AC;
use AC\Collection;
use ACA\ACF\Editing;
use ACA\ACF\Field;
use ACA\ACF\Filtering;
use ACA\ACF\Search;
use ACP;

class PostObject extends Field {

	public function __construct( $column ) {
		parent::__construct( $column );

		$this->column->set_serialized( $this->column->get_acf_field_option( 'multiple' ) );
	}

	public function get_value( $id ) {
		return $this->column->get_formatted_value( new Collection( $this->get_raw_value( $id ) ) );
	}

	/**
	 * @param int $id
	 *
	 * @return array
	 */
	public function get_raw_value( $id ) {
		return array_filter( (array) parent::get_raw_value( $id ) );
	}

	public function editing() {
		return new Editing\PostObject( $this->column );
	}

	public function sorting() {
		return new ACP\Sorting\Model\Value( $this->column );
	}

	private function get_post_type() {
		return $this->column->get_acf_field_option( 'post_type' );
	}

	private function get_terms() {
		$taxonomy = $this->column->get_acf_field_option( 'taxonomy' );

		$array_terms = acf_decode_taxonomy_terms( $taxonomy );

		if ( ! $array_terms ) {
			return array();
		}

		$terms = array();
		foreach ( $array_terms as $taxonomy => $term_slugs ) {
			foreach ( $term_slugs as $term_slug ) {
				$terms[] = get_term_by( 'slug', $term_slug, $taxonomy );
			}
		}

		return array_filter( $terms );
	}

	public function search() {
		if ( $this->is_serialized() ) {
			return new Search\PostObjects( $this->get_meta_key(), $this->get_meta_type(), $this->get_post_type(), $this->get_terms() );
		}

		return new Search\PostObject( $this->get_meta_key(), $this->get_meta_type(), $this->get_post_type(), $this->get_terms() );
	}

	public function filtering() {
		return new Filtering\PostObject( $this->column );
	}

	public function export() {
		return new ACP\Export\Model\StrippedValue( $this->column );
	}

	public function get_dependent_settings() {
		return array(
			new AC\Settings\Column\Post( $this->column ),
		);
	}

}