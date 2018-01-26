<?php

add_action( 'wp_enqueue_scripts', 'Divi_parent_theme_enqueue_styles' );

function Divi_parent_theme_enqueue_styles() {
    wp_enqueue_style( 'Divi-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'brenta-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( 'Divi-style' )
    );

	wp_enqueue_script('brenta_functions', get_stylesheet_directory_uri() . '/js/functions.js', array('jquery'), '.1' , true);
	wp_localize_script( 'brenta_functions', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}

function DS_Custom_Modules(){
	if(class_exists("ET_Builder_Module")){
		include("ds-custom-modules.php");
		include("brenta-custom-portfolio.php");
	}
}

function Prep_DS_Custom_Modules(){
	global $pagenow;

	$is_admin = is_admin();
	$action_hook = $is_admin ? 'wp_loaded' : 'wp';
	$required_admin_pages = array( 'edit.php', 'post.php', 'post-new.php', 'admin.php', 'customize.php', 'edit-tags.php', 'admin-ajax.php', 'export.php' ); // list of admin pages where we need to load builder files
	$specific_filter_pages = array( 'edit.php', 'admin.php', 'edit-tags.php' );
	$is_edit_library_page = 'edit.php' === $pagenow && isset( $_GET['post_type'] ) && 'et_pb_layout' === $_GET['post_type'];
	$is_role_editor_page = 'admin.php' === $pagenow && isset( $_GET['page'] ) && 'et_divi_role_editor' === $_GET['page'];
	$is_import_page = 'admin.php' === $pagenow && isset( $_GET['import'] ) && 'wordpress' === $_GET['import'];
	$is_edit_layout_category_page = 'edit-tags.php' === $pagenow && isset( $_GET['taxonomy'] ) && 'layout_category' === $_GET['taxonomy'];

	if ( ! $is_admin || ( $is_admin && in_array( $pagenow, $required_admin_pages ) && ( ! in_array( $pagenow, $specific_filter_pages ) || $is_edit_library_page || $is_role_editor_page || $is_edit_layout_category_page || $is_import_page ) ) ) {
		add_action($action_hook, 'DS_Custom_Modules', 9789);
	}
}
Prep_DS_Custom_Modules();

add_image_size( 'portfolio-size', 800, 400, true );

if ( ! function_exists( 'activity_taxonomy' ) ) {

// Register Custom Taxonomy
	function activity_taxonomy() {

		$labels = array(
			'name'                       => _x( 'Activities', 'Taxonomy General Name', 'brenta' ),
			'singular_name'              => _x( 'Activity', 'Taxonomy Singular Name', 'brenta' ),
			'menu_name'                  => __( 'Activity', 'brenta' ),
			'all_items'                  => __( 'All Activities', 'brenta' ),
			'parent_item'                => __( 'Parent Activity', 'brenta' ),
			'parent_item_colon'          => __( 'Parent Activity:', 'brenta' ),
			'new_item_name'              => __( 'New Activity Name', 'brenta' ),
			'add_new_item'               => __( 'Add New Activity', 'brenta' ),
			'edit_item'                  => __( 'Edit Activity', 'brenta' ),
			'update_item'                => __( 'Update Activity', 'brenta' ),
			'view_item'                  => __( 'View Activity', 'brenta' ),
			'separate_items_with_commas' => __( 'Separate activities with commas', 'brenta' ),
			'add_or_remove_items'        => __( 'Add or remove activities', 'brenta' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'brenta' ),
			'popular_items'              => __( 'Popular activities', 'brenta' ),
			'search_items'               => __( 'Search activities', 'brenta' ),
			'not_found'                  => __( 'Not Found', 'brenta' ),
			'no_terms'                   => __( 'No Types', 'brenta' ),
			'items_list'                 => __( 'Types list', 'brenta' ),
			'items_list_navigation'      => __( 'Types list navigation', 'brenta' ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => false,
			'show_in_rest'               => true,
		);
		register_taxonomy( 'activity', array( 'project' ), $args );

	}
	add_action( 'init', 'activity_taxonomy', 0 );

}

if ( ! function_exists( 'season_taxonomy' ) ) {

// Register Custom Taxonomy
	function season_taxonomy() {

		$labels = array(
			'name'                       => _x( 'Seasons', 'Taxonomy General Name', 'brenta' ),
			'singular_name'              => _x( 'Season', 'Taxonomy Singular Name', 'brenta' ),
			'menu_name'                  => __( 'Season', 'brenta' ),
			'all_items'                  => __( 'All Seasons', 'brenta' ),
			'parent_item'                => __( 'Parent Season', 'brenta' ),
			'parent_item_colon'          => __( 'Parent Season:', 'brenta' ),
			'new_item_name'              => __( 'New Season Name', 'brenta' ),
			'add_new_item'               => __( 'Add New Season', 'brenta' ),
			'edit_item'                  => __( 'Edit Season', 'brenta' ),
			'update_item'                => __( 'Update Season', 'brenta' ),
			'view_item'                  => __( 'View Season', 'brenta' ),
			'separate_items_with_commas' => __( 'Separate Seasons with commas', 'brenta' ),
			'add_or_remove_items'        => __( 'Add or remove seasons', 'brenta' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'brenta' ),
			'popular_items'              => __( 'Popular seasons', 'brenta' ),
			'search_items'               => __( 'Search seasons', 'brenta' ),
			'not_found'                  => __( 'Not Found', 'brenta' ),
			'no_terms'                   => __( 'No Seasons', 'brenta' ),
			'items_list'                 => __( 'Seasons list', 'brenta' ),
			'items_list_navigation'      => __( 'Seasons list navigation', 'brenta' ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => false,
			'show_in_rest'               => true,
		);
		register_taxonomy( 'season', array( 'project' ), $args );

	}
	add_action( 'init', 'season_taxonomy', 0 );

}

add_filter( 'facetwp_facet_orderby', function( $orderby, $facet ) {
	if ( 'seasons' == $facet['name'] ) {
		// to sort by raw value, use "f.facet_value" instead
		$orderby = 'FIELD(f.facet_display_value, "primavera", "estate", "autunno", "inverno")';
	}

	if ( 'categories' == $facet['name'] ) {
		// to sort by raw value, use "f.facet_value" instead
		$orderby = 'FIELD(f.facet_display_value, "adulti", "bambini", "passeggino", "pioggia")';
	}

	if ( 'activity' == $facet['name'] ) {
		// to sort by raw value, use "f.facet_value" instead
		$orderby = 'FIELD(f.facet_display_value, "flora", "fauna", "geologia", "paesaggio", "trekking", "bike")';
	}

	return $orderby;
}, 10, 2 );


function et_divi_get_top_nav_items() {
	$items = new stdClass;

	$items->phone_number = et_get_option( 'phone_number' );

	$items->email = et_get_option( 'header_email' );

	$items->contact_info_defined = $items->phone_number || $items->email;

	$items->show_header_social_icons = et_get_option( 'show_header_social_icons', false );

	$items->secondary_nav = wp_nav_menu( array(
		'theme_location' => 'secondary-menu',
		'container'      => '',
		'fallback_cb'    => '',
		'menu_id'        => 'et-secondary-nav',
		'echo'           => false,
		'after'          => '<i class="fa fa-circle" aria-hidden="true"></i>'
 	) );

	$items->top_info_defined = $items->contact_info_defined || $items->show_header_social_icons || $items->secondary_nav;

	$items->two_info_panels = $items->contact_info_defined && ( $items->show_header_social_icons || $items->secondary_nav );

	return $items;
}


if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'photogallery', 350, 240, true ); // (ritagliata)
}

if( function_exists('acf_add_local_field_group') ):

	acf_add_local_field_group(array (
		'key' => 'group_59c51564c822d',
		'title' => 'Banner',
		'fields' => array (
			array (
				'key' => 'field_59c5156d3da4e',
				'label' => 'Immagine Banner',
				'name' => 'immagine_banner',
				'type' => 'image',
				'instructions' => 'Inserire un\'immagine preferibilmente con una proporzione di 790 x 220 px. Dpi max 150. Formato .jpeg, .jpg o .png',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'return_format' => 'array',
				'preview_size' => 'thumbnail',
				'library' => 'uploadedTo',
				'min_width' => 790,
				'min_height' => 220,
				'max_width' => '',
				'max_height' => '',
				'max_size' => '',
				'mime_types' => 'jpeg, jpg, png',
			),
			array (
				'key' => 'field_59c51fa73d6e2',
				'label' => 'Titolo Banner',
				'name' => 'titolo_banner',
				'type' => 'text',
				'instructions' => 'Titolo da mettere sul banner. Es: "Hotel Gianna"',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
			array (
				'key' => 'field_59c51fb83d6e3',
				'label' => 'Sottotitolo banner',
				'name' => 'sottotitolo_banner',
				'type' => 'text',
				'instructions' => 'Sottotitolo da mettere sul banner',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
			array (
				'key' => 'field_59c516053da4f',
				'label' => 'Link Banner',
				'name' => 'link_banner',
				'type' => 'link',
				'instructions' => 'Inserire qui link a cui rimanderà il banner inserito sopra.',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'return_format' => 'array',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'poi',
				),
				array (
					'param' => 'post_taxonomy',
					'operator' => '==',
					'value' => 'webmapp_category:strutture-qp',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => '',
	));

  acf_add_local_field_group(array (
    'key' => 'group_59e7294acad94',
    'title' => 'News',
    'fields' => array (
      array (
        'key' => 'field_59e729ad82ac6',
        'label' => 'Subtitle',
        'name' => 'subtitle',
        'type' => 'text',
        'value' => NULL,
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array (
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
      ),
      array (
        'key' => 'field_59e7295582ac5',
        'label' => 'Media Gallery',
        'name' => 'media_gallery',
        'type' => 'gallery',
        'value' => NULL,
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array (
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'min' => '',
        'max' => '',
        'insert' => 'append',
        'library' => 'all',
        'min_width' => '',
        'min_height' => '',
        'min_size' => '',
        'max_width' => '',
        'max_height' => '',
        'max_size' => '',
        'mime_types' => 'png, jpg, jpeg',
      ),
    ),
    'location' => array (
      array (
        array (
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'post',
        ),
      ),
    ),
    'menu_order' => 0,
    'position' => 'acf_after_title',
    'style' => 'seamless',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => 1,
    'description' => '',
  ));

  acf_add_local_field_group(array(
    'key' => 'group_5a0c5670cef57',
    'title' => 'Prenotazione',
    'fields' => array(
      array(
        'key' => 'field_5a0c5677c231a',
        'label' => 'Prenotabile',
        'name' => 'prenotabile',
        'type' => 'true_false',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'message' => '',
        'default_value' => 0,
        'ui' => 0,
        'ui_on_text' => '',
        'ui_off_text' => '',
      ),
      array(
        'key' => 'field_5a0c56abc231b',
        'label' => 'Mail prenotazione',
        'name' => 'mail_prenotazione',
        'type' => 'email',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
      ),
    ),
    'location' => array(
      array(
        array(
          'param' => 'post_type',
          'operator' => '==',
          'value' => 'poi',
        ),
      ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => 1,
    'description' => '',
  ));

endif;

function my_cache_lifetime( $seconds ) {
  return 86400; // one day
}
add_filter( 'facetwp_cache_lifetime', 'my_cache_lifetime' );

add_action('acf/save_post', 'register_impresa');

function register_impresa( $post_id ) {

	$b = 0;

	if( get_post_type($post_id) !== 'imprese' ) {
		return;
	}

	if( is_admin() ) {
		return;
	}

	// vars
	$impresa = $_POST['acf']['field_5a58832d56687'];
	$name = $_POST['acf']['field_5a5882e44a26d'];
	$lastname = $_POST['acf']['field_5a5882ee4a26e'];
	$pec = $_POST['acf']['field_5a5883ee56693'];
	$username = $_POST['acf']['field_5a5890970d639'];
	$password = $_POST['acf']['field_5a5890a00d63a'];

	$update_impresa = array(
		'ID'           => $post_id,
		'post_title'   => $impresa
	);

	wp_update_post( $update_impresa );

	setcookie('brenta_user', $username, time() + (86400 * 30), "/"); // 86400 = 1 day
	setcookie('brenta_password', $password, time() + (86400 * 30), "/"); // 86400 = 1 day

	// email data
	$to = get_option('admin_email');
	$headers = 'From: ' . $name . ' ' . $lastname . ' <' . $pec . '>' . "\r\n";
	$subject = 'Iscrizone impresa: '. $impresa;
	$body = 'L\'impresa ' . $impresa . ' è stata registrata da ' . $name . ' ' . $lastname . '- email: ' . $pec;


	// send email
	wp_mail($to, $subject, $body, $headers );

	$url = get_home_url(null, 'impresa');
	wp_redirect( get_home_url() );
	exit;
}

add_action( 'wp_ajax_brenta_login_action', 'brenta_login_action' );
add_action( 'wp_ajax_nopriv_brenta_login_action', 'brenta_login_action' );

function brenta_login_action(){

	$user = $_POST['user'];
	$password = $_POST['password'];

	$args = [
		'numberposts'	=> 1,
		'post_status' => array('pending', 'publish'),
		'post_type'		=> 'imprese',
		'meta_query'     => [
			'relation' => 'AND',
			[
				'key'     => 'username',
				'value'   => $user,
				'compare' => '=',
			],
			[
				'key'     => 'password',
				'value'   => $password,
				'compare' => '=',
			],
		],
	];
	$the_query = new WP_Query( $args );

	if ( $the_query->have_posts() ) {
		setcookie('brenta_user', $user, time() + (86400 * 30), "/"); // 86400 = 1 day
		setcookie('brenta_password', $password, time() + (86400 * 30), "/"); // 86400 = 1 day
		$response = 'true';
	} else {
		$response = 'le credenziali inserite non corrispondono a nessuna impresa';
	}

	echo $response;
	wp_die();

}

add_filter('acf/validate_value/name=ripeti_password', 'my_acf_validate_value', 10, 4);

function my_acf_validate_value( $valid, $value, $field, $input ){

	if (!$valid) {
		return $valid;
	}
	// field key of the field you want to validate against
	$password_field = 'field_5a5890a00d63a';
	if ($value != $_POST['acf'][$password_field]) {
		$valid = 'La password non coincide';
	}
	return $valid;

}