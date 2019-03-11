<?php

namespace ACA\ACF\Search;

use ACP\Search\Helper\MetaQuery\SerializedComparisonFactory;
use ACP\Search\Value;

class PostObjects extends PostObject {

	protected function get_meta_query( $operator, Value $value ) {
		$comparison = SerializedComparisonFactory::create(
			$this->get_meta_key(),
			$operator,
			$value
		);

		return $comparison();
	}

}