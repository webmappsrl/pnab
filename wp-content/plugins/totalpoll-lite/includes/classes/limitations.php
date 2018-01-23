<?php
if ( defined( 'ABSPATH' ) === false ) :
	exit;
endif; // Shhh

if ( ! class_exists( 'TP_Limitations' ) ) :

	/**
	 * Limitations Class
	 *
	 * @package TotalPoll/Classes/Limitations
	 * @since   3.0.0
	 */
	class TP_Limitations {
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
		 * @var object Limitations settings.
		 * @access protected
		 * @since  3.0.0
		 */
		protected $limitations = array();
		/**
		 * @var object Limitations items.
		 * @access protected
		 * @since  3.0.0
		 */
		public $bag = null;

		/**
		 * Limitations constructor.
		 *
		 * @param object $poll    Poll object.
		 * @param object $request Request object.
		 *
		 * @since 3.0.0
		 */
		public function __construct( $poll, $request ) {
			if ( $poll instanceof TotalPoll::$classes['poll']['class'] ):
				$this->poll        = $poll;
				$this->limitations = $this->poll->settings( 'limitations' );
			endif;

			if ( $request instanceof TotalPoll::$classes['request']['class'] ):
				$this->request = $request;
			endif;
		}

		/**
		 * Run limitations.
		 *
		 * @param bool|false $purge Purge cached items.
		 *
		 * @since 3.0.0
		 * @return array Errors.
		 */
		public function run( $purge = false ) {
			if ( $this->bag === null || $purge !== false ):
				$this->bag = new WP_Error();
				$this->is_valid_cookies();
				$this->is_valid_ip();
				$this->is_valid_selection();
				$this->is_valid_results();
			endif;

			return (array) $this->bag->get_error_messages();
		}

		/**
		 * Apply limitations.
		 *
		 * @since 3.0.0
		 * @return void.
		 */
		public function apply() {
			$this->apply_cookies();
			$this->apply_ip();
		}

		/**
		 * Get errors.
		 *
		 * @since 3.0.0
		 * @return array Errors.
		 */
		public function errors() {
			if ( $this->bag instanceof WP_Error ) {
				return (array) $this->bag->get_error_messages();
			}

			return array();
		}

		/**
		 * Check cookies validity.
		 *
		 * @since 3.0.0
		 * @return bool Validity.
		 */
		public function is_valid_cookies() {
			if ( ! empty( $this->limitations['cookies']['enabled'] ) ):

				$cookie_key = 'tpc_' . $this->limitations['unique_id'];

				if ( ! empty( $_COOKIE[ $cookie_key ] ) ):
					$this->poll->skip_to( 'results' );
					$this->bag->add(
						'cookies',
						__( 'You cannot vote again in this poll.', TP_TD )
					);

					return false;
				endif;

			endif;

			return true;
		}

		/**
		 * Check IP validity.
		 *
		 * @since 3.0.0
		 * @return bool Validity.
		 */
		public function is_valid_ip() {
			if ( ! empty( $this->limitations['ip']['enabled'] ) ):

				$ip_cookie_key = 'tpic_' . $this->limitations['unique_id'];
				$ip_exists     = ! empty( $_COOKIE[ $ip_cookie_key ] );


				if ( ! $ip_exists && $this->request && $this->request->type === 'vote' ):
					$ip_key    = 'tpip_' . $this->request->ip . '_' . $this->limitations['unique_id'];
					$ip_exists = (bool) get_transient( $ip_key );

					if ( $ip_exists ):
						$this->apply_ip();
					endif;
				endif;

				if ( $ip_exists === true ):
					$this->poll->skip_to( 'results' );
					$this->bag->add(
						'ip',
						__( 'You cannot vote again in this poll.', TP_TD )
					);

					return false;
				endif;

			endif;

			return true;
		}


		/**
		 * Check selection validity.
		 *
		 * @since 3.0.0
		 * @return bool Validity.
		 */
		public function is_valid_selection() {
			if ( $this->request && $this->request->type === 'vote' ):
				$minimum = isset( $this->limitations['selection']['minimum'] ) ? abs( $this->limitations['selection']['minimum'] ) : 1;
				$maximum = isset( $this->limitations['selection']['maximum'] ) ? abs( $this->limitations['selection']['maximum'] ) : 1;

				if ( count( $this->request->choices ) < $minimum ):
					$this->bag->add(
						'minimum',
						sprintf(
							_n( 'You have to vote for at least one choice.', 'You have to vote for at least %d choices.', $minimum, TP_TD ),
							$minimum
						)
					);

					return false;
				endif;

				if ( $maximum !== 0 && count( $this->request->choices ) > $maximum ):
					$this->bag->add(
						'maximum',
						sprintf(
							_n( 'You cannot vote for more than one choice.', 'You cannot vote for more than %d choices.', $maximum, TP_TD ),
							$maximum
						)
					);

					return false;
				endif;
			endif;

			return true;

		}

		/**
		 * Check results viewing validity.
		 *
		 * @since 3.0.0
		 * @return bool Validity.
		 */
		public function is_valid_results() {
			if ( ! empty( $this->limitations['results']['require_vote']['enabled'] ) && $this->request && $this->request->type === 'results' ):

				$cookie_key = 'tpc_' . $this->limitations['unique_id'];
				if ( empty( $_COOKIE[ $cookie_key ] ) ):
					$this->poll->skip_to( 'vote' );
					$this->bag->add(
						'require_vote',
						__( 'You cannot see results before voting.', TP_TD )
					);

					return false;
				endif;

			endif;

			return true;

		}

		/**
		 * Apply cookies
		 *
		 * @since 3.0.0
		 * @return void
		 */
		public function apply_cookies() {
			if ( ! empty( $this->limitations['cookies']['enabled'] ) ):

				$cookie_key = 'tpc_' . $this->limitations['unique_id'];

				if ( $this->request && $this->request->type === 'vote' && empty( $_COOKIE[ $cookie_key ] ) && count( $this->request->choices ) !== 0 ):
					$cookie_timeout_minutes = isset( $this->limitations['cookies']['timeout'] ) ? (int) $this->limitations['cookies']['timeout'] : 1440;
					setcookie( $cookie_key, true, time() + ( MINUTE_IN_SECONDS * $cookie_timeout_minutes ), COOKIEPATH, COOKIE_DOMAIN );
				endif;

			endif;

		}

		/**
		 * Apply IP
		 *
		 * @since 3.0.0
		 * @return void
		 */
		public function apply_ip() {
			if ( ! empty( $this->limitations['ip']['enabled'] ) ):

				$ip_cookie_key = 'tpic_' . $this->limitations['unique_id'];
				$ip_exists     = ! empty( $_COOKIE[ $ip_cookie_key ] );

				if ( ! $ip_exists && $this->request && $this->request->type === 'vote' ):
					$ip_key    = 'tpip_' . $this->request->ip . '_' . $this->limitations['unique_id'];
					$ip_exists = (bool) get_transient( $ip_key );

					if ( $ip_exists || count( $this->request->choices ) !== 0 ):
						$ip_timeout_minutes = isset( $this->limitations['ip']['timeout'] ) ? (int) $this->limitations['ip']['timeout'] : 1440;
						set_transient( $ip_key, true, time() + ( MINUTE_IN_SECONDS * $ip_timeout_minutes ) );
						setcookie( $ip_cookie_key, true, time() + ( MINUTE_IN_SECONDS * $ip_timeout_minutes ), COOKIEPATH, COOKIE_DOMAIN );
					endif;
				endif;

			endif;
		}
	}


endif;