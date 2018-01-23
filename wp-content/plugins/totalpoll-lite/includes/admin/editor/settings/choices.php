<?php
if ( defined( 'ABSPATH' ) === false ) :
	exit;
endif; // Shhh
?>
<div class="totalpoll-tab-content settings-tab-content settings-choices" data-tp-tab-content="choices">

	<?php do_action( 'totalpoll/actions/admin/editor/settings/choices/before', $choices, $this->poll ); ?>

	<div class="settings-item">

		<div class="settings-field">
			<label class="settings-field-label" for="totalpoll-settings-limitations-selection-minimum">
				<?php _e( 'Minimum selection', TP_TD ); ?>
				<span class="feature-details" title="<?php esc_attr_e( 'The minimum number of choices to be sent.', TP_TD ); ?>">?</span>
			</label>
			<input id="totalpoll-settings-limitations-selection-minimum" type="number" name="totalpoll[settings][limitations][selection][minimum]" min="1" step="1" class="settings-field-input widefat" value="<?php echo esc_attr( absint( $limitations['selection']['minimum'] ) ); ?>">
		</div>

		<?php do_action( 'totalpoll/actions/admin/editor/settings/choices/selection-minimum', $choices, $this->poll ); ?>

		<div class="settings-field">
			<label class="settings-field-label" for="totalpoll-settings-limitations-selection-maximum">
				<?php _e( 'Maximum selection', TP_TD ); ?>
				<span class="feature-details" title="<?php esc_attr_e( 'The maximum number of choices to be sent.', TP_TD ); ?>">?</span>
			</label>
			<input id="totalpoll-settings-limitations-selection-maximum" type="number" name="totalpoll[settings][limitations][selection][maximum]" min="0" step="1" class="settings-field-input widefat" value="<?php echo esc_attr( absint( $limitations['selection']['maximum'] ) ); ?>">

			<p class="feature-tip"><?php _e( '0 means unlimited.', TP_TD ); ?></p>
		</div>

		<?php do_action( 'totalpoll/actions/admin/editor/settings/choices/selection-maximum', $choices, $this->poll ); ?>

	</div>

	<div class="settings-item">

		<div class="settings-field">
			<label class="settings-field-label" for="totalpoll-settings-choices-pagination-per-page">
				<?php _e( 'Choices per page', TP_TD ); ?>
				<span class="feature-details" title="<?php esc_attr_e( 'Choices per page', TP_TD ); ?>">?</span><?php $this->pro_only(); ?>
			</label>
			<input id="totalpoll-settings-choices-pagination-per-page" type="number" disabled min="0" step="1" class="settings-field-input widefat" value="<?php echo esc_attr( absint( $choices['pagination']['per_page'] ) ); ?>">

			<p class="feature-tip"><?php _e( '0 means unlimited.', TP_TD ); ?></p>
		</div>

		<?php do_action( 'totalpoll/actions/admin/editor/settings/choices/pagination-per-page', $choices, $this->poll ); ?>

	</div>

	<div class="settings-item">

		<div class="settings-field">
			<label>
				<input type="checkbox" disabled>
				<?php _e( 'Order choices', TP_TD ); ?><?php $this->pro_only(); ?>
			</label>
		</div>

		<?php do_action( 'totalpoll/actions/admin/editor/settings/choices/order-choices', $choices, $this->poll ); ?>

	</div>

	<div class="settings-item">

		<div class="settings-field">
			<label>
				<input type="checkbox" disabled>
				<?php _e( 'Allow user submissions', TP_TD ); ?><?php $this->pro_only(); ?>
			</label>
		</div>

		<?php do_action( 'totalpoll/actions/admin/editor/settings/choices/allow-user-submissions', $choices, $this->poll ); ?>

	</div>

	<?php do_action( 'totalpoll/actions/admin/editor/settings/choices/after', $choices, $this->poll ); ?>

</div>