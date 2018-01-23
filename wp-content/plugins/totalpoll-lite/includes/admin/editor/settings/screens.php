<?php
if ( defined( 'ABSPATH' ) === false ) :
	exit;
endif; // Shhh
?>
<div class="totalpoll-tab-content settings-tab-content settings-screens" data-tp-tab-content="screens">

	<?php do_action( 'totalpoll/actions/admin/editor/settings/screens/before', $screens, $this->poll ); ?>

	<div class="settings-item">

		<div class="settings-field">
			<label>
				<input type="checkbox" disabled>
				<?php _e( 'Before voting', TP_TD ); ?><?php $this->pro_only(); ?>
			</label>
		</div>

		<?php do_action( 'totalpoll/actions/admin/editor/settings/screens/before-voting', $screens, $this->poll ); ?>

	</div>

	<div class="settings-item">

		<div class="settings-field">
			<label>
				<input type="checkbox" disabled>
				<?php _e( 'After voting', TP_TD ); ?><?php $this->pro_only(); ?>
			</label>
		</div>

		<?php do_action( 'totalpoll/actions/admin/editor/settings/screens/after-voting', $screens, $this->poll ); ?>

	</div>

	<?php do_action( 'totalpoll/actions/admin/editor/settings/screens/after', $screens, $this->poll ); ?>

</div>