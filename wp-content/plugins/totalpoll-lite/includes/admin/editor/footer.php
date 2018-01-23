<?php
if ( defined( 'ABSPATH' ) === false ) :
	exit;
endif; // Shhh
?>

<div class="containables-tpls">
	<?php
	$choice           = array(
		'votes'   => 0,
		'content' => array(
			'date'    => '',
			'visible' => true,
			'label'   => '',
		),

	);
	$choice_visible   = true;
	$choice_index     = '{{index}}';
	$choice_id        = '{{id}}';
	$choice_css_class = 'active';
	?>
	<?php foreach ( array( 'text', 'image', 'video', 'audio', 'html' ) as $type ): ?>
		<script type="text/template" data-tp-containable-template="choices-<?php echo $type; ?>">
			<?php include "choices/{$type}.php"; ?>
		</script>
	<?php endforeach; ?>
	<?php do_action( 'totalpoll/actions/admin/editor/containable-templates', $this->poll ); ?>
</div>

</div>