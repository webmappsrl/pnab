<?php
if ( defined( 'ABSPATH' ) === false ) :
	exit;
endif; // Shhh

/**
 * Latest Poll Widget.
 *
 * @since   2.7.0
 * @package TotalPoll\Widgets\Latest
 */
if ( ! class_exists( 'TP_Latest_Widget' ) ):

	class TP_Latest_Widget extends WP_Widget {

		/**
		 * Register widget with WordPress.
		 *
		 * @since 2.0.0
		 */
		public function __construct() {
			parent::__construct(
				'latest-totalpoll', // Base ID
				__( 'Latest Poll - TotalPoll', TP_TD ) . ' (PRO ONLY)', // Name
				array( 'description' => __( 'Poll widget', TP_TD ), ) // Args
			);
		}

		/**
		 * Front-end display of widget.
		 *
		 * @see   WP_Widget::widget()
		 * @since 2.0.0
		 *
		 * @param array $args     Widget arguments.
		 * @param array $instance Saved values from database.
		 *
		 * @return void
		 */
		public function widget( $args, $instance ) {
		}

		/**
		 * Back-end widget form.
		 *
		 * @see WP_Widget::form()
		 *
		 * @param array $instance Previously saved values from database.
		 *
		 * @return void
		 */
		public function form( $instance ) {
			?>
			<p><?php _e( 'Available in pro version only.', TP_TD ); ?></p>
			<?php
		}

		/**
		 * Sanitize widget form values as they are saved.
		 *
		 * @see WP_Widget::update()
		 *
		 * @param array $new_instance Values just sent to be saved.
		 * @param array $old_instance Previously saved values from database.
		 *
		 * @return array Updated safe values to be saved.
		 */
		public function update( $new_instance, $old_instance ) {
			return $new_instance;
		}

	}

endif;

return 'TP_Latest_Widget';