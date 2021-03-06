<?php

namespace ACA\ACF\Field;

use ACA\ACF\Editing;
use ACA\ACF\Field;
use ACA\ACF\Filtering;
use ACA\ACF\Formattable;
use ACA\ACF\Search;
use ACA\ACF\Sorting;
use ACP;

class Taxonomy extends Field
	implements Formattable {

	public function __construct( $column ) {
		parent::__construct( $column );

		// Checkbox and Multi select are stored serialized
		$this->column->set_serialized( in_array( $this->get( 'field_type' ), array( 'checkbox', 'multi_select' ) ) );
	}

	public function get_value( $id ) {
		$term_ids = parent::get_value( $id );

		$values = array();

		foreach ( ac_helper()->taxonomy->get_terms_by_ids( $term_ids, $this->get( 'taxonomy' ) ) as $term ) {
			$values[] = $this->get_term_link( $term );
		}

		return implode( ', ', $values );
	}

	public function get_term_link( $term ) {
		return ac_helper()->html->link( get_edit_term_link( $term->term_id, $term->taxonomy ), $term->name );
	}

	public function format( $term_id ) {
		$term = get_term( $term_id );

		return $this->get_term_link( $term );
	}

	public function filtering() {
		return new Filtering\Taxonomy( $this->column );
	}

	public function editing() {
		return new Editing\Taxonomy( $this->column );
	}

	public function search() {
		if ( $this->is_serialized() ) {
			return new Search\Taxonomies( $this->get_meta_key(), $this->get_meta_type(), $this->get( 'taxonomy' ) );
		}

		return new Search\Taxonomy( $this->get_meta_key(), $this->get_meta_type(), $this->get( 'taxonomy' ) );
	}

	public function sorting() {
		if ( $this->get( 'multiple' ) ) {
			return new ACP\Sorting\Model\Value( $this->column );
		}

		return new Sorting( $this->column );
	}

	public function export() {
		return new ACP\Export\Model\StrippedValue( $this->column );
	}

}