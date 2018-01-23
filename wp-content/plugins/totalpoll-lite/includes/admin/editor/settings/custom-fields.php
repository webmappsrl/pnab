<?php
if ( defined( 'ABSPATH' ) === false ) :
	exit;
endif; // Shhh
?>
<div class="totalpoll-tab-content settings-tab-content containables-container settings-custom-fields" data-tp-tab-content="custom-fields">

	<?php do_action( 'totalpoll/actions/admin/editor/settings/custom-fields/before', $fields, $this->poll ); ?>

	<ul class="containables-types">
		<li>
			<button class="button" type="button" disabled><?php _e( 'Text', TP_TD ); ?><?php $this->pro_only(); ?></button>
		</li>
		<li>
			<button class="button" type="button" disabled><?php _e( 'Text area', TP_TD ); ?><?php $this->pro_only(); ?></button>
		</li>
		<li>
			<button class="button" type="button" disabled><?php _e( 'Select', TP_TD ); ?><?php $this->pro_only(); ?></button>
		</li>
		<li>
			<button class="button" type="button" disabled><?php _e( 'Checkbox', TP_TD ); ?><?php $this->pro_only(); ?></button>
		</li>
		<li>
			<button class="button" type="button" disabled><?php _e( 'Radio', TP_TD ); ?><?php $this->pro_only(); ?></button>
		</li>
		<?php do_action( 'totalpoll/actions/admin/editor/settings/custom-fields/types', $fields, $this->poll ); ?>
	</ul>

	<?php do_action( 'totalpoll/actions/admin/editor/settings/custom-fields/after', $fields, $this->poll ); ?>

</div>