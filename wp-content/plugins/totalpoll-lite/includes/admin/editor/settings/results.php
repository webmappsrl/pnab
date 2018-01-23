<?php
if ( defined( 'ABSPATH' ) === false ) :
	exit;
endif; // Shhh
?>
<div class="totalpoll-tab-content settings-tab-content settings-results" data-tp-tab-content="results">

	<?php do_action( 'totalpoll/actions/admin/editor/settings/results/before', $results, $this->poll ); ?>

	<div class="settings-item">

		<div class="settings-field">
			<label>
				<input type="checkbox" name="totalpoll[settings][limitations][results][require_vote][enabled]" <?php checked( empty( $limitations['results']['require_vote']['enabled'] ), false ); ?>>
				<?php _e( 'Require vote', TP_TD ); ?>
				<span class="feature-details" title="<?php esc_attr_e( 'Results are visible only for voters.', TP_TD ); ?>">?</span>
			</label>
		</div>

	</div>

	<div class="settings-item">

		<div class="settings-field">
			<label>
				<input type="checkbox" disabled>
				<?php _e( 'Order results', TP_TD ); ?><?php $this->pro_only(); ?>
			</label>
		</div>

		<?php do_action( 'totalpoll/actions/admin/editor/settings/results/order-results', $results, $this->poll ); ?>

	</div>

	<div class="settings-item">

		<div class="settings-field">
			<label>
				<input type="checkbox" disabled>
				<?php _e( 'Hide results', TP_TD ); ?><?php $this->pro_only(); ?>
			</label>
		</div>

		<?php do_action( 'totalpoll/actions/admin/editor/settings/results/hide-results', $results, $this->poll ); ?>

	</div>

	<div class="settings-item">

		<div class="settings-field">
			<label class="settings-field-label">
				<?php _e( 'Results fragments', TP_TD ); ?>
				<span class="feature-details" title="<?php esc_attr_e( 'Which fragments (votes, percentage or both) will be visible to the visitor.', TP_TD ); ?>">?</span>
			</label>
			<label>
				<input type="checkbox" name="totalpoll[settings][results][format][votes]" value="votes" <?php checked( isset( $results['format']['votes'] ), true ); ?>>
				<?php _e( 'Votes', TP_TD ); ?>
			</label>
			&nbsp;
			<label>
				<input type="checkbox" name="totalpoll[settings][results][format][percentages]" value="percentages" <?php checked( isset( $results['format']['percentages'] ), true ); ?>>
				<?php _e( 'Percentages', TP_TD ); ?>
			</label>
		</div>

		<?php do_action( 'totalpoll/actions/admin/editor/settings/results/fragments', $results, $this->poll ); ?>

	</div>

	<?php do_action( 'totalpoll/actions/admin/editor/settings/results/after', $results, $this->poll ); ?>

</div>