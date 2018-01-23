<?php
if ( defined( 'ABSPATH' ) === false ) :
	exit;
endif; // Shhh

if ( ! class_exists( 'TP_Fields' ) ) :

	/**
	 * Fields Class
	 *
	 * @package TotalPoll/Classes/Fields
	 * @since   3.0.0
	 */
	class TP_Fields {

		/**
		 * @var object Poll object.
		 * @access protected
		 * @since  3.0.0
		 */
		protected $poll = null;

		/**
		 * @var object Request object.
		 * @access protected
		 * @since  3.0.0
		 */
		protected $request = null;

		/**
		 * @var array Array of fields (original and raw).
		 * @access protected
		 * @since  3.0.0
		 */
		protected $raw_fields = array();

		/**
		 * @var array Array of fields objects.
		 * @access protected
		 * @since  3.0.0
		 */
		protected $fields = array();

		/**
		 * @var array Array posted fields.
		 * @access protected
		 * @since  3.0.0
		 */
		protected $posted = array();

		/**
		 * @var array Errors items.
		 * @access protected
		 * @since  3.0.0
		 */
		public $bag = false;

		/**
		 * @var array Unique fields items.
		 * @access public
		 * @since  3.0.0
		 */
		public $unique_fields = array();

		/**
		 * Fields constructor.
		 *
		 * @param object $poll    Poll object.
		 * @param object $request Request object.
		 *
		 * @since 3.0.0
		 */
		public function __construct( $poll, $request ) {
		}

		/**
		 * Run fields validations.
		 *
		 * @param bool $purge Purge cached items.
		 *
		 * @since 3.0.0
		 * @return array Errors.
		 */
		public function run() {
			return array();
		}

		/**
		 * Get errors.
		 *
		 * @since 3.0.0
		 * @return array Errors.
		 */
		public function errors() {
			return array();
		}

		/**
		 * Get fields objects.
		 *
		 * @since 3.0.0
		 * @return array Fields.
		 */
		public function all() {
			return array();
		}

		/**
		 * Get flat array of fields object ( name => value ).
		 *
		 * @since 3.0.0
		 * @return array Fields.
		 */
		public function to_array() {
			return array();
		}

		/**
		 * Getter.
		 *
		 * @param string $name Name.
		 * @param array  $args Args.
		 *
		 * @return mixed Value.
		 */
		public function __call( $name, $args ) {
			return isset( $this->{$name} ) ? $this->{$name} : false;
		}

	}


endif;