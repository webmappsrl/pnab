<?php

include_once "include/highlights.php";

add_action( 'wp_enqueue_scripts', 'Divi_parent_theme_enqueue_styles' );

function Divi_parent_theme_enqueue_styles() {
	wp_enqueue_style( 'divi-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'brenta-style', get_stylesheet_directory_uri() . '/style.css', [ 'divi-style' ], '.1' );

	wp_enqueue_script( 'brenta_functions', get_stylesheet_directory_uri() . '/js/functions.js', [ 'jquery' ], '.1', TRUE );
	wp_localize_script( 'brenta_functions', 'ajax_object', [ 'ajax_url' => admin_url( 'admin-ajax.php' ) ] );

	if( is_front_page() || is_home() ) {
		wp_enqueue_script( 'owl_carousel_js', get_stylesheet_directory_uri() . '/js/owl.carousel.min.js', [ 'jquery' ], '2.3.4', TRUE );
		wp_enqueue_style( 'owl_carousel_css', get_stylesheet_directory_uri() . '/css/owl.carousel.min.css', [ 'brenta-style' ], '2.3.4' );
		wp_enqueue_style( 'owl_carousel_theme_css', get_stylesheet_directory_uri() . '/css/owl.theme.default.css', [ 'owl_carousel_css' ], '2.3.4' );
	}
}

function DS_Custom_Modules() {
	if ( class_exists( "ET_Builder_Module" ) ) {
		include( "include/brenta-custom-modules.php" );
		include( "include/brenta-custom-portfolio.php" );
	}
}

function Prep_DS_Custom_Modules() {
	global $pagenow;

	$is_admin                     = is_admin();
	$action_hook                  = $is_admin ? 'wp_loaded' : 'wp';
	$required_admin_pages         = [
		'edit.php',
		'post.php',
		'post-new.php',
		'admin.php',
		'customize.php',
		'edit-tags.php',
		'admin-ajax.php',
		'export.php',
	]; // list of admin pages where we need to load builder files
	$specific_filter_pages        = [
		'edit.php',
		'admin.php',
		'edit-tags.php',
	];
	$is_edit_library_page         = 'edit.php' === $pagenow && isset( $_GET['post_type'] ) && 'et_pb_layout' === $_GET['post_type'];
	$is_role_editor_page          = 'admin.php' === $pagenow && isset( $_GET['page'] ) && 'et_divi_role_editor' === $_GET['page'];
	$is_import_page               = 'admin.php' === $pagenow && isset( $_GET['import'] ) && 'wordpress' === $_GET['import'];
	$is_edit_layout_category_page = 'edit-tags.php' === $pagenow && isset( $_GET['taxonomy'] ) && 'layout_category' === $_GET['taxonomy'];

	if ( ! $is_admin || ( $is_admin && in_array( $pagenow, $required_admin_pages ) && ( ! in_array( $pagenow, $specific_filter_pages ) || $is_edit_library_page || $is_role_editor_page || $is_edit_layout_category_page || $is_import_page ) ) ) {
		add_action( $action_hook, 'DS_Custom_Modules', 9789 );
	}
}

Prep_DS_Custom_Modules();

add_image_size( 'portfolio-size', 800, 400, TRUE );

if ( ! function_exists( 'attivita_taxonomy' ) ) {

	// Register Custom Taxonomy
	function attivita_taxonomy() {

		$labels = [
			'name'                       => _x( 'attivita', 'Taxonomy General Name', 'brenta' ),
			'singular_name'              => _x( 'attivita', 'Taxonomy Singular Name', 'brenta' ),
			'menu_name'                  => __( 'attivita', 'brenta' ),
			'all_items'                  => __( 'All attivita', 'brenta' ),
			'parent_item'                => __( 'Parent attivita', 'brenta' ),
			'parent_item_colon'          => __( 'Parent attivita:', 'brenta' ),
			'new_item_name'              => __( 'New attivita Name', 'brenta' ),
			'add_new_item'               => __( 'Add New attivita', 'brenta' ),
			'edit_item'                  => __( 'Edit attivita', 'brenta' ),
			'update_item'                => __( 'Update attivita', 'brenta' ),
			'view_item'                  => __( 'View attivita', 'brenta' ),
			'separate_items_with_commas' => __( 'Separate attivita with commas', 'brenta' ),
			'add_or_remove_items'        => __( 'Add or remove attivita', 'brenta' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'brenta' ),
			'popular_items'              => __( 'Popular attivita', 'brenta' ),
			'search_items'               => __( 'Search attivita', 'brenta' ),
			'not_found'                  => __( 'Not Found', 'brenta' ),
			'no_terms'                   => __( 'No Types', 'brenta' ),
			'items_list'                 => __( 'Types list', 'brenta' ),
			'items_list_navigation'      => __( 'Types list navigation', 'brenta' ),
		];
		$args   = [
			'labels'            => $labels,
			'hierarchical'      => TRUE,
			'public'            => TRUE,
			'show_ui'           => TRUE,
			'show_admin_column' => TRUE,
			'show_in_nav_menus' => TRUE,
			'show_tagcloud'     => FALSE,
			'show_in_rest'      => TRUE,
		];
		register_taxonomy( 'attivita', [ 'project' ], $args );

	}

	add_action( 'init', 'attivita_taxonomy', 0 );

}

if ( ! function_exists( 'season_taxonomy' ) ) {

	// Register Custom Taxonomy
	function season_taxonomy() {

		$labels = [
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
		];
		$args   = [
			'labels'            => $labels,
			'hierarchical'      => TRUE,
			'public'            => TRUE,
			'show_ui'           => TRUE,
			'show_admin_column' => TRUE,
			'show_in_nav_menus' => TRUE,
			'show_tagcloud'     => FALSE,
			'show_in_rest'      => TRUE,
		];
		register_taxonomy( 'season', [ 'project' ], $args );

	}

	add_action( 'init', 'season_taxonomy', 0 );

}

if ( ! function_exists( 'location_taxonomy' ) ) {

	// Register Custom Taxonomy
	function location_taxonomy() {

		$labels = [
			'name'                       => _x( 'Location', 'Taxonomy General Name', 'brenta' ),
			'singular_name'              => _x( 'Location', 'Taxonomy Singular Name', 'brenta' ),
			'menu_name'                  => __( 'Location', 'brenta' ),
			'all_items'                  => __( 'All Locations', 'brenta' ),
			'parent_item'                => __( 'Parent Location', 'brenta' ),
			'parent_item_colon'          => __( 'Parent Location:', 'brenta' ),
			'new_item_name'              => __( 'New Location Name', 'brenta' ),
			'add_new_item'               => __( 'Add New Location', 'brenta' ),
			'edit_item'                  => __( 'Edit Location', 'brenta' ),
			'update_item'                => __( 'Update Location', 'brenta' ),
			'view_item'                  => __( 'View Location', 'brenta' ),
			'separate_items_with_commas' => __( 'Separate Locations with commas', 'brenta' ),
			'add_or_remove_items'        => __( 'Add or remove Locations', 'brenta' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'brenta' ),
			'popular_items'              => __( 'Popular Locations', 'brenta' ),
			'search_items'               => __( 'Search Locations', 'brenta' ),
			'not_found'                  => __( 'Not Found', 'brenta' ),
			'no_terms'                   => __( 'No Locations', 'brenta' ),
			'items_list'                 => __( 'Locations list', 'brenta' ),
			'items_list_navigation'      => __( 'Locations list navigation', 'brenta' ),
		];
		$args   = [
			'labels'            => $labels,
			'hierarchical'      => TRUE,
			'public'            => TRUE,
			'show_ui'           => TRUE,
			'show_admin_column' => TRUE,
			'show_in_nav_menus' => TRUE,
			'show_tagcloud'     => FALSE,
			'show_in_rest'      => TRUE,
		];
		register_taxonomy( 'location', [ 'project' ], $args );

	}

	add_action( 'init', 'location_taxonomy', 0 );

}


add_filter( 'facetwp_facet_orderby', function ( $orderby, $facet ) {
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
		$orderby = 'FIELD(f.facet_display_value, "flora", "fauna", "geologia", "paesaggio", "trekking")';
		// $orderby = 'FIELD(f.facet_display_value, "flora", "natura", "paesaggio", "trekking")';
	}

	return $orderby;
}, 10, 2 );

add_filter( 'facetwp_facet_render_args', function( $args ) {
	if ( 'activity' == $args['facet']['name'] ) {
		
		$t = array(
				'flora' ,
				'natura' ,
				'paesaggio' ,
				'trekking'
		);

		$values = array();
		if ( ! empty( $args['values'] ) ) {
				foreach ( $args['values'] as $key => $val ) {
						$facet_value = $val['facet_value'];
						if ( in_array($facet_value,$t) ) {
							array_push ($values, $val);
						}
				}
				$args['values'] = $values;
		}

	}
	return $args;
});



function et_divi_get_top_nav_items() {
	$items = new stdClass;

	$items->phone_number = et_get_option( 'phone_number' );

	$items->email = et_get_option( 'header_email' );

	$items->contact_info_defined = $items->phone_number || $items->email;

	$items->show_header_social_icons = et_get_option( 'show_header_social_icons', FALSE );

	$items->secondary_nav = wp_nav_menu( [
		'theme_location' => 'secondary-menu',
		'container'      => '',
		'fallback_cb'    => '',
		'menu_id'        => 'et-secondary-nav',
		'echo'           => FALSE,
		'after'          => '<i class="fa fa-circle" aria-hidden="true"></i>',
	] );

	$items->top_info_defined = $items->contact_info_defined || $items->show_header_social_icons || $items->secondary_nav;

	$items->two_info_panels = $items->contact_info_defined && ( $items->show_header_social_icons || $items->secondary_nav );

	return $items;
}


if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'photogallery', 350, 240, TRUE ); // (ritagliata)
}

if ( function_exists( 'acf_add_local_field_group' ) ):

	acf_add_local_field_group( [
		'key'                   => 'group_59c51564c822d',
		'title'                 => 'Banner',
		'fields'                => [
			[
				'key'               => 'field_59c5156d3da4e',
				'label'             => 'Immagine Banner',
				'name'              => 'immagine_banner',
				'type'              => 'image',
				'instructions'      => 'Inserire un\'immagine preferibilmente con una proporzione di 790 x 220 px. Dpi max 150. Formato .jpeg, .jpg o .png',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => [
					'width' => '',
					'class' => '',
					'id'    => '',
				],
				'return_format'     => 'array',
				'preview_size'      => 'thumbnail',
				'library'           => 'uploadedTo',
				'min_width'         => 790,
				'min_height'        => 220,
				'max_width'         => '',
				'max_height'        => '',
				'max_size'          => '',
				'mime_types'        => 'jpeg, jpg, png',
			],
			[
				'key'               => 'field_59c51fa73d6e2',
				'label'             => 'Titolo Banner',
				'name'              => 'titolo_banner',
				'type'              => 'text',
				'instructions'      => 'Titolo da mettere sul banner. Es: "Hotel Gianna"',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => [
					'width' => '',
					'class' => '',
					'id'    => '',
				],
				'default_value'     => '',
				'placeholder'       => '',
				'prepend'           => '',
				'append'            => '',
				'maxlength'         => '',
			],
			[
				'key'               => 'field_59c51fb83d6e3',
				'label'             => 'Sottotitolo banner',
				'name'              => 'sottotitolo_banner',
				'type'              => 'text',
				'instructions'      => 'Sottotitolo da mettere sul banner',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => [
					'width' => '',
					'class' => '',
					'id'    => '',
				],
				'default_value'     => '',
				'placeholder'       => '',
				'prepend'           => '',
				'append'            => '',
				'maxlength'         => '',
			],
			[
				'key'               => 'field_59c516053da4f',
				'label'             => 'Link Banner',
				'name'              => 'link_banner',
				'type'              => 'link',
				'instructions'      => 'Inserire qui link a cui rimanderà il banner inserito sopra.',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => [
					'width' => '',
					'class' => '',
					'id'    => '',
				],
				'return_format'     => 'array',
			],
			[
				'key' => 'field_5ab3cc078041e',
				'label' => 'Mostra in banner',
				'name' => 'mostra_in_banner',
				'type' => 'true_false',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'message' => 'Selezione se vuoi mostrare il banner nel footer',
				'default_value' => 0,
				'ui' => 0,
				'ui_on_text' => '',
				'ui_off_text' => '',
			],
		],
		'location'              => [
			[
				[
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'poi',
				]
				// [
				// 	'param'    => 'post_taxonomy',
				// 	'operator' => '==',
				// 	'value'    => 'webmapp_category:marchio-qualita-parco',
				// ],
			],
		],
		'menu_order'            => 0,
		'position'              => 'normal',
		'style'                 => 'default',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen'        => '',
		'active'                => 1,
		'description'           => '',
	] );

	acf_add_local_field_group( [
		'key'                   => 'group_59e7294acad94',
		'title'                 => 'News',
		'fields'                => [
			[
				'key'               => 'field_59e729ad82ac6',
				'label'             => 'Subtitle',
				'name'              => 'subtitle',
				'type'              => 'text',
				'value'             => NULL,
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => [
					'width' => '',
					'class' => '',
					'id'    => '',
				],
				'default_value'     => '',
				'placeholder'       => '',
				'prepend'           => '',
				'append'            => '',
				'maxlength'         => '',
			],
			[
				'key'               => 'field_59e7295582ac5',
				'label'             => 'Media Gallery',
				'name'              => 'media_gallery',
				'type'              => 'gallery',
				'value'             => NULL,
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => [
					'width' => '',
					'class' => '',
					'id'    => '',
				],
				'min'               => '',
				'max'               => '',
				'insert'            => 'append',
				'library'           => 'all',
				'min_width'         => '',
				'min_height'        => '',
				'min_size'          => '',
				'max_width'         => '',
				'max_height'        => '',
				'max_size'          => '',
				'mime_types'        => 'png, jpg, jpeg',
			],
		],
		'location'              => [
			[
				[
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'post',
				],
			],
			[
				[
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'project',
				],
			],
		],
		'menu_order'            => 0,
		'position'              => 'acf_after_title',
		'style'                 => 'seamless',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen'        => '',
		'active'                => 1,
		'description'           => '',
	] );

	acf_add_local_field_group( [
		'key'                   => 'group_5a0c5670cef57',
		'title'                 => 'Prenotazione',
		'fields'                => [
			[
				'key'               => 'field_5a0c5677c231a',
				'label'             => 'Prenotabile',
				'name'              => 'prenotabile',
				'type'              => 'true_false',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => [
					'width' => '',
					'class' => '',
					'id'    => '',
				],
				'message'           => '',
				'default_value'     => 0,
				'ui'                => 0,
				'ui_on_text'        => '',
				'ui_off_text'       => '',
			],
			[
				'key'               => 'field_5a0c56abc231b',
				'label'             => 'Mail prenotazione',
				'name'              => 'mail_prenotazione',
				'type'              => 'email',
				'instructions'      => '',
				'required'          => 0,
				'conditional_logic' => 0,
				'wrapper'           => [
					'width' => '',
					'class' => '',
					'id'    => '',
				],
				'default_value'     => '',
				'placeholder'       => '',
				'prepend'           => '',
				'append'            => '',
			],
		],
		'location'              => [
			[
				[
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'poi',
				],
			],
		],
		'menu_order'            => 0,
		'position'              => 'normal',
		'style'                 => 'default',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen'        => '',
		'active'                => 1,
		'description'           => '',
	] );

	acf_add_local_field_group(array(
		'key' => 'group_5a83049783a15',
		'title' => 'POI Brenta',
		'fields' => array(
			array(
				'key' => 'field_5a8304a89d802',
				'label' => 'Immagine icona custom',
				'name' => 'custom_image_icon',
				'type' => 'image',
				'instructions' => 'Inserisci un file png, o a limite jpg su sfondo bianco, largo min 30 x 30px, max 150 x 150px.',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'return_format' => 'url',
				'preview_size' => 'thumbnail',
				'library' => 'all',
				'min_width' => 30,
				'min_height' => '',
				'min_size' => '',
				'max_width' => 150,
				'max_height' => '',
				'max_size' => '',
				'mime_types' => 'png, jpg',
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
		'position' => 'acf_after_title',
		'style' => 'seamless',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => '',
	));

	acf_add_local_field_group(array(
		'key' => 'group_5a830af6d6904',
		'title' => 'Brenta POI fields',
		'fields' => array(
			array(
				'key' => 'field_5a830b0c1f6a6',
				'label' => 'Fax',
				'name' => 'contact_poi_fax',
				'type' => 'number',
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
				'min' => '',
				'max' => '',
				'step' => '',
			),
			array(
				'key' => 'field_5a830b1a1f6a7',
				'label' => 'PEC',
				'name' => 'contact_poi_pec',
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
		'menu_order' => -1,
		'position' => 'normal',
		'style' => 'seamless',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => 1,
		'description' => '',
	));

	acf_add_local_field_group(array(
		'key' => 'group_5ae2fcb2317b7',
		'title' => 'Colonna destra',
		'fields' => array(
			array(
				'key' => 'field_5ae2fcbd3e4b9',
				'label' => 'Testo colonna destra',
				'name' => 'testo_colonna_destra',
				'type' => 'wysiwyg',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'tabs' => 'all',
				'toolbar' => 'full',
				'media_upload' => 0,
				'delay' => 0,
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

add_action( 'acf/save_post', 'register_impresa' );

function register_impresa( $post_id ) {


	if ( get_post_type( $post_id ) !== 'imprese' ) {
		return;
	}

	if ( is_admin() ) {
		return;
	}

	// vars
	$impresa  = $_POST['acf']['field_5a58832d56687'];
	$name     = $_POST['acf']['field_5a5882e44a26d'];
	$lastname = $_POST['acf']['field_5a5882ee4a26e'];
	$pec      = $_POST['acf']['field_5a5883ee56693'];
	$username = $_POST['acf']['field_5a5890970d639'];
	$password = $_POST['acf']['field_5a5890a00d63a'];

	$update_impresa = [
		'ID'         => $post_id,
		'post_title' => $impresa,
	];

	wp_update_post( $update_impresa );

	if( $_POST['impresa-update'] !== 'update'){
		setcookie( 'brenta_user', $username, time() + ( 86400 * 30 ), "/" ); // 86400 = 1 day
	}
	setcookie( 'brenta_password', $password, time() + ( 86400 * 30 ), "/" ); // 86400 = 1 day

	if( $_POST['impresa-update'] !== 'update') {
		// email data
		$to      = get_option( 'admin_email' );
		$headers = 'From: ' . $name . ' ' . $lastname . ' <' . $pec . '>' . "\r\n";
		$subject = 'Iscrizone impresa: ' . $impresa;
		$body    = 'L\'impresa ' . $impresa . ' è stata registrata da ' . $name . ' ' . $lastname . '- email: ' . $pec . '.<br />Vedi i dati inseriti qui: <a href="https://www.pnab.it/wp-admin/post.php?post=' . $post_id . '&action=edit">https://www.pnab.it/wp-admin/post.php?post=' . $post_id . '&action=edit</a>';
	
	add_filter( 'wp_mail_content_type', function ( $content_type ) {
		return 'text/html';
	} );
	// send email
	wp_mail( $to, $subject, $body, $headers );
	}

	brenta_create_pdf( $post_id );

	wp_redirect( get_home_url(null, '/impresa') );
	exit;
}

add_action( 'wp_ajax_brenta_login_action', 'brenta_login_action' );
add_action( 'wp_ajax_nopriv_brenta_login_action', 'brenta_login_action' );

function brenta_login_action() {

	$user     = $_POST['user'];
	$password = $_POST['password'];

	$args      = [
		'numberposts' => 1,
		'post_status' => [ 'pending', 'publish' ],
		'post_type'   => 'imprese',
		'meta_query'  => [
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
		setcookie( 'brenta_user', $user, time() + ( 86400 * 30 ), "/" ); // 86400 = 1 day
		setcookie( 'brenta_password', $password, time() + ( 86400 * 30 ), "/" ); // 86400 = 1 day
		$response = 'true';
	} else {
		$response = 'le credenziali inserite non corrispondono a nessuna impresa';
	}

	echo $response;
	wp_die();

}

add_filter( 'acf/validate_value/name=ripeti_password', 'my_acf_validate_value', 10, 4 );

function my_acf_validate_value( $valid, $value, $field, $input ) {

	if ( ! $valid ) {
		return $valid;
	}
	// field key of the field you want to validate against
	$password_field = 'field_5a5890a00d63a';
	if ( $value != $_POST['acf'][ $password_field ] ) {
		$valid = 'La password non coincide';
	}

	return $valid;

}

add_filter( 'acf/validate_value/name=username', 'my_acf_validate_username', 10, 4 );

function my_acf_validate_username( $valid, $value, $field, $input ) {

	if ( ! $valid ) {
		return $valid;
	}
	// field key of the field you want to validate against

	global $post;
	$args = array(
		'post_type' => 'imprese',  // or your post
		'post__not_in' => array($post->ID), // do not check this post
		'meta_query' => array(
			array(
				'key' => 'username',
				'value' => $value
			)
		)
	);
	$query = new WP_Query($args);
	if (count($query->posts)) {
		$valid = 'Questo username risulta già utilizzato';
	}

	return $valid;

}


function brenta_create_pdf( $impresa_id ) {

	require_once( ABSPATH . 'wp-content/plugins/tcpdf/tcpdf.php' );
	$data = get_field_objects( $impresa_id );

	$file = ABSPATH . 'wp-content/uploads/pdf-imprese/'.$impresa_id.'_'.$data['impresa']['value'].'.pdf';
	if (file_exists($file)){
		unlink($file);
	}

	$html = '';

	foreach ( $data as $key => $item ) {
		$a = 0;
		if ( empty( $item['value'] ) || $item['value'] == FALSE || $key == '_validate_email' || $key == 'ripeti_password' || $key == 'firma' || $item['type'] == 'select' ) {
			continue;
		}
		else if ( $item['type'] == 'true_false' && $item['value'] !== false ){

			$html .= '<p><strong>' . $key . '</strong> <input type="checkbox" name="'.$item['label'].'"  value="1" checked="checked"  /><br/>';
			if( isset($data[$item['name'].'_cat']) ) {
				$cat = $data[$item['name'].'_cat'];
				$value = $cat['choices'][$cat['value']];
				$html .= "<strong>" . $cat['label'] . ": </strong>" . $value . "</p>";
			}
		}
		else {
			$html .= "<p><strong>" . $item['label'] . ": </strong>" . $item['value'] . "</p>";

		}

	}



	$pdf = new TCPDF( PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, TRUE, 'UTF-8', FALSE );
	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor( 'PNAB' );
	$pdf->SetTitle( $impresa_id.'_'.$data['impresa']['value'] );
	$pdf->SetSubject( 'Dati impresa' );
	$pdf->SetKeywords( 'PDF, impresa' );

	// set default header data
	$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $data['impresa']['value'], 'www.pnab.it');

	// set header and footer fonts
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

	// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	// set margins
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

	// set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

	// set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	// ---------------------------------------------------------

	// IMPORTANT: disable font subsetting to allow users editing the document
	$pdf->setFontSubsetting(false);

	// set font
	$pdf->SetFont('helvetica', '', 10, '', false);

	// add a page
	$pdf->AddPage();
	$pdf->writeHTML($html, true, 0, true, 0);
	// reset pointer to the last page
	$pdf->lastPage();


	$pdf->Output( $file, 'F' );

}

function containsTerm( $myArray, $word ) {
	foreach ( $myArray as $element ) {
		if ( $element->slug == $word ) {
			return TRUE;
		}
	}

	return FALSE;
}

function et_builder_include_webmapp_categories_option( $args = array() ) {
	$defaults = apply_filters( 'et_builder_include_categories_defaults', array (
		'use_terms' => true,
		'term_name' => 'webmapp_category',
	) );

	$args = wp_parse_args( $args, $defaults );

	$term_args = apply_filters( 'et_builder_include_categories_option_args', array( 'hide_empty' => false, ) );

	$output = "\t" . "<% var et_pb_include_categories_temp = typeof data !== 'undefined' && typeof data.et_pb_include_categories !== 'undefined' ? data.et_pb_include_categories.split( ',' ) : []; et_pb_include_categories_temp = typeof data === 'undefined' && typeof et_pb_include_categories !== 'undefined' ? et_pb_include_categories.split( ',' ) : et_pb_include_categories_temp; %>" . "\n";

	if ( $args['use_terms'] ) {
		$cats_array = get_terms( $args['term_name'], $term_args );
	} else {
		$cats_array = get_categories( apply_filters( 'et_builder_get_categories_args', 'hide_empty=0' ) );
	}

	if ( empty( $cats_array ) ) {
		$output = '<p>' . esc_html__( "You currently don't have any projects assigned to a category.", 'et_builder' ) . '</p>';
	}

	foreach ( $cats_array as $category ) {
		$contains = sprintf(
			'<%%= _.contains( et_pb_include_categories_temp, "%1$s" ) ? checked="checked" : "" %%>',
			esc_html( $category->term_id )
		);

		if ( !empty($category->parent) ){
			$termParent = get_term($category->parent, $category->taxonomy);
			$parent_name = ' - (' . $termParent->name . ')';
		} else {
			$parent_name = '';
		}

		$output .= sprintf(
			'%4$s<label><input type="checkbox" name="et_pb_include_categories" value="%1$s"%3$s> %2$s %5$s </label><br/>',
			esc_attr( $category->term_id ),
			esc_html( $category->name ),
			$contains,
			"\n\t\t\t\t\t",
			$parent_name
		);
	}

	$output = '<div id="et_pb_include_categories">' . $output . '</div>';

	return apply_filters( 'et_builder_include_categories_option_html', $output );
}


// Single Category
add_shortcode( 'br_single_category', 'br_single_category' );

function br_single_category($atts) {

  // Attributes
  extract( shortcode_atts(
      array(
        'id' => 0,
				'last_days' => 'false',
				'orderby' => 'date'
      ), $atts )
  );

  if (empty($id)) {

    return __('You need to enter an ID for the category', 'mvafsp');

  }else{

    $mv_single_cat_id = $id;
    // Include multiverso-category.php template
    return include('include/brenta-doc-category.php');

  }

}

//***********************************************//
//             DISPLAY CATEGORY FILES            //
//***********************************************//

function br_display_catfiles($catslug, $catname = NULL, $last_days, $personal = false, $registered = false) {

  $html = '';

  if ( $personal == true ) {

    // Check current user logged
    global $current_user;
    $mv_logged = $current_user->user_login;


    // Personal Query Args
    $args = array(
      'post_type'	 =>	'multiverso',
      'post_status' => 'publish',
      'meta_key' => 'mv_user',
      'meta_value' => $mv_logged,
      'meta_compare' => '==',
      'orderby' => 'name',
      'order' => 'DESC',
      'posts_per_page' => -1,
      'tax_query' => array(
        array(
          'taxonomy' => 'multiverso-categories',
          'terms' => $catslug,
          'field' => 'slug',
          'include_children' => false
        )
      )
    );

  }elseif ( $registered == true ) {

    // Check current user logged
    global $current_user;
    $mv_logged = $current_user->user_login;


    // Personal Query Args
    $args = array(
      'post_type'	 =>	'multiverso',
      'post_status' => 'publish',
      'meta_query' => array(
        'relation' => 'OR',
        array(
          'key' => 'mv_access',
          'value' => 'registered',
          'compare' => '=='
        ),
        array(
          'key' => 'mv_access',
          'value' => 'public',
          'compare' => '=='
        ),
      ),
      'orderby' => 'name',
      'order' => 'DESC',
      'posts_per_page' => -1,
      'tax_query' => array(
        array(
          'taxonomy' => 'multiverso-categories',
          'terms' => $catslug,
          'field' => 'slug',
          'include_children' => false
        )
      )
    );

  }else{

    // Standard Query Args
    $args = array(
      'post_type'	 =>	'multiverso',
      'post_status' => 'publish',
      'orderby' => 'name',
      'order' => 'DESC',
      'posts_per_page' => -1,
      'tax_query' => array(
        array(
          'taxonomy' => 'multiverso-categories',
          'terms' => $catslug,
          'field' => 'slug',
          'include_children' => false
        )
      )
    );

  }

  if ($last_days == 'true') {
    $args['date_query'] = array(
      array(
        'after' => '-15 days',
        'column' => 'post_date',
      ),
    );
  }

  // Start Query
  $files = new WP_Query( $args  );


  // Object security Check
  if ($files) {
    $fcount = 0;
    // Loop
    while ( $files->have_posts() ) {

      // Set Post Data
      $files->the_post();

      // Check the Access for the file
      if(mv_user_can_view_file( get_the_ID() )) {

        // FCount incrementation
        $fcount++;

        // Display the File
        $html .= br_file_details_html( get_the_ID() );

      }

      // Reset Post Data
      wp_reset_postdata();

    }

    // IF Cat is empty
    if ( !$files->have_posts() || $fcount == 0 ) {

      //echo '<div class="mv-no-files">'. __('No files found in ', 'mvafsp').$catname.'</div>';

    }


  }

  // Return HTML
  return $html;

}


//***********************************************//
//               DISPLAY FILE HTML               //
//***********************************************//

// File Details (HTML)
function br_file_details_html( $fileID ) {

  $html = '';

  $mv_access = get_post_meta($fileID, 'mv_access', true);
  $mv_user = get_post_meta($fileID, 'mv_user', true);
  $mv_file_check = get_post_meta($fileID, 'mv_file', true);


  if (!empty($mv_file_check)) {


    // Switch right icon
    switch ($mv_file_check['type']) {

      case 'application/pdf':
        $icon_class = 'file-pdf';
        break;

      case 'text/plain':
        $icon_class = 'file-txt';
        break;

      case 'application/zip':
        $icon_class = 'file-zip';
        break;

      case 'application/rar':
        $icon_class = 'file-rar';
        break;

      case 'application/msword':
        $icon_class = 'file-doc';
        break;

      case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
        $icon_class = 'file-doc';
        break;

      case 'application/vnd.ms-excel':
        $icon_class = 'file-xls';
        break;

      case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
        $icon_class = 'file-xls';
        break;

      case 'application/vnd.ms-powerpoint':
        $icon_class = 'file-ppt';
        break;

      case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
        $icon_class = 'file-ppt';
        break;

      case 'image/gif':
        $icon_class = 'file-gif';
        break;

      case 'image/png':
        $icon_class = 'file-png';
        break;

      case 'image/jpeg':
        $icon_class = 'file-jpg';
        break;

      default:
        $icon_class = 'file-others';
        break;
    }

    // Filename
    $filename_ar = explode('/', $mv_file_check['file']);

    if(!empty($filename_ar[1])){

      $filename = $filename_ar[1];

      if (get_option('mv_disable_downloader') == 1) {
        $filedownload = WP_CONTENT_URL.'/'.WP_MULTIVERSO_UPLOAD_FOLDER.'/'.$filename_ar[0].'/'.$filename_ar[1];
      }else{
        $filedownload = '?upf=dl&id='.$fileID;
      }



    }else{
      $filename = $mv_file_check['file'];
      $filedownload = $mv_file_check['url'];
    }

    $html .= '
	
	<div class="file-details-wrapper">
        <div class="file-details">     
    

        <div class="file-data '.$icon_class.'">';

    if (get_option('mv_single_theme') == 1) {
      $html .= '<div class="file-name"><a href="'.get_the_permalink($fileID).'" title="'.__('View details', 'mvafsp').'">'.get_the_title($fileID).'</a> 
				 (<a href="'.$filedownload.'" target="_blank" title="'.__('Download file', 'mvafsp').'">'.$filename.'</a>)</div>';
    }else{
      $html .= '<div class="file-name">'.__('File', 'mvafsp').' <a href="'.$filedownload.'" target="_blank" title="'.__('Download file', 'mvafsp').'">'.$filename.'</a></div>';
    }
    $html .= '<div class="br-file-excerpt">'. get_the_excerpt($fileID).'</div>';
    $html .= '<ul class="file-data-list">
            	<li class="file-owner"><i class="mvico-user3" title="'.__('Owner', 'mvafsp').'"></i>'.ucfirst($mv_user).'</li>
                <li class="file-publish"><i class="mvico-calendar"></i>'.get_post_time( 'F j, Y', false,  $fileID ).'</li>
                <li class="file-access file-'.$mv_access.'"><i class="mvico-eye"></i>'.ucfirst($mv_access).'</li>
            </ul>
        </div>
		
		<div class="file-dw-button">
        <a class="mv-btn mv-btn-success" href="'.$filedownload.'" target="_blank" title="'.__('Download file', 'mvafsp').'">'.__('Download', 'mvafsp').'</a>
        </div>';

    if (get_option('mv_single_theme') == 1) {
      $html .= '<div class="file-dw-button">
        			  <a class="mv-btn mv-btn-success" href="'.get_the_permalink($fileID).'" title="'.__('Details', 'mvafsp').'">'.__('Details', 'mvafsp').'</a>
        			  </div>';
    }

    $html .= '<div class="mv-clear"></div>
		
        </div>
        </div>';



  }else{

    $html .= '
	
	<div class="file-details-wrapper">
        <div class="file-details">     
    

        <div class="file-data file-others">';

    if (get_option('mv_single_theme') == 1) {
			$html .= '<div class="file-name"><a href="'.get_the_permalink($fileID).'" title="'.__('View details', 'mvafsp').'">'.get_the_title($fileID).'</a></div>';
			//$html .= '<div class="br-file-excerpt">'. get_the_excerpt($fileID).'</div>';
			
    }else{
      $html .= __('File: none', 'mvafsp');
    }
    $html .= '<ul class="file-data-list">
            	<li class="file-owner"><i class="mvico-user3" title="'.__('Owner', 'mvafsp').'"></i>'.ucfirst($mv_user).'</li>
                <li class="file-publish"><i class="mvico-calendar"></i>'.get_post_time( 'F j, Y', false,  $fileID ).'</li>
                <li class="file-access file-'.$mv_access.'"><i class="mvico-eye"></i>'.ucfirst($mv_access).'</li>
            </ul>
        </div>';
		$html .= '<div class="file-dw-button disabled" title="'.__('No file uploaded yet', 'mvafsp').'">
        <span class="mv-btn mv-btn-success">'.__('Download', 'mvafsp').'</span>
        </div>';

    if (get_option('mv_single_theme') == 1) {
      $html .= '<div class="file-dw-button">
			<a class="mv-btn mv-btn-success" href="'.get_the_permalink($fileID).'" title="'.__('Details', 'mvafsp').'">'.__('Details', 'mvafsp').'</a>
			</div>';
    }

    $html .= '<div class="mv-clear"></div>
		
        </div>
        </div>';

  }

  // Return HTML
  return $html;

}

add_shortcode('brenta_events', 'brenta_events');

function brenta_events( $atts ){

	$output = '';

	//$events_data = json_decode(file_get_contents('https://api.webmapp.it/j/pnab.j.webmapp.it/geojson/eventi.geojson'));

	$request  = wp_remote_get( 'https://api.webmapp.it/j/pnab.j.webmapp.it/geojson/eventi.geojson' );
	$response = wp_remote_retrieve_body( $request );
	if ( 'OK' !== wp_remote_retrieve_response_message( $response ) OR 200 !== wp_remote_retrieve_response_code( $response ) ) {
		$response = json_decode(wp_remote_retrieve_body( $request ));
	}
	if (empty($response)){
		return $output;
	}


	setlocale(LC_ALL, 'it_IT');
    $output .= '<h4 class="br_event_title">Prossimi Eventi</h4><div class="br_event_row owl-carousel owl-theme">';
	foreach ($response->features as $feature){
		$date = strtotime(str_replace('/','-',$feature->properties->algo->day));
		$d = strftime('%d', $date);
		$A = strftime('%a', $date);
		$B = strftime('%B', $date);
		$output .= <<<EOT
		<div id="{$feature->properties->id}" class="brenta_events_columns">
			<div class="et_pb_blurb et_pb_module et_pb_bg_layout_light et_pb_text_align_left  et_pb_blurb_0 et_pb_blurb_position_left">
				<div class="et_pb_blurb_content">
					<div class="br_et_pb_main_date">
					<a href="#">
						<span class="br_et_date br_et_date_d">{$d}</span><span class="br_et_date br_et_date_day">{$A}</span><span class="br_et_date br_et_date_month">{$B}</span>
					</a></div>
						<div class="et_pb_blurb_container_event">
							<h4 class="et_pb_module_header"><a href="#">{$feature->properties->name}</a></h4>
							<div class="et_brenta_location">
								<a href="#" style="color:#2586a8;"><i class="fa fa-map-marker" aria-hidden="true"></i> {$feature->properties->algo->place}</a>
						</div>
					</div>
				</div> 
			</div> 
		</div> 
EOT;
	}

	$output .= '</div>';



	return $output;
}

/** changes the order of child page's title thumbs excerpt */
function custom_ccchildpage_inner_template($template) {
	
	$template = '<div class="ccchildpage {{page_class}}"><div class="ccchildpagethumbs">{{thumbnail}}</div><div class="ccchildpageinfo"><h3{{title_class}}>{{title}}</h3>{{excerpt}}</div></div>';
	return $template;
	}
	add_filter( 'ccchildpages_inner_template' ,'custom_ccchildpage_inner_template' );
	

	add_image_size( 'category_thumbs', 220, 154 ); // 220 pixels wide by 180 pixels tall, soft proportional crop mode

	add_theme_support( 'post-thumbnails', array( 'post', 'page' ) ); 
	
function webmapp_filter_post_thumbnail_html( $html ) {
    // If there is no post thumbnail,
	// Return a default image
	if (!is_single()){
    if ( '' == $html ) {
        return '<img src="http://www.pnab.it/wp-content/uploads/2019/03/logo-pnab-220x154.png" width="220px" height="154px" class="cc-child-pages-thumb wp-post-image" />';
    }}
    // Else, return the post thumbnail
    return $html;
}
add_filter( 'post_thumbnail_html', 'webmapp_filter_post_thumbnail_html' );


/**changes the breadcrumb link of POI in yoast */
add_filter( 'wpseo_breadcrumb_links', 'yoast_seo_breadcrumb_append_link' );
function yoast_seo_breadcrumb_append_link( $links ) {
	global $post;
	global $wp_taxonomies;
	global $wp_query;
	
    if ( is_singular( 'poi' ) ) {
        $breadcrumb[] = array(
            'url' => site_url( '/poi-archive/' ),
            'text' => 'POI',
        );
        array_splice( $links, 1, 1, $breadcrumb );
    }
	

	if ( is_home() || is_singular( 'post' ) || is_archive() ) {
        $breadcrumb[] = array(
            'url' => site_url( '/news-archive/' ),
            'text' => 'News',
        );
        array_splice( $links, 1, 1, $breadcrumb );
    }
    return $links;
	
}

function fwp_add_facet_labels() {
	?>
	<script>
	(function($) {
		$(document).on('facetwp-loaded', function() {
			$('.facetwp-facet').each(function() {
				var $facet = $(this);
				var facet_name = $facet.attr('data-name');
				var facet_label = FWP.settings.labels[facet_name];
	
				if ($facet.closest('.facet-wrap').length < 1) {
					$facet.wrap('<div class="facet-wrap"></div>');
					$facet.before('<h3 class="facet-label">' + facet_label + '</h3>');
				}
			});
		});
	})(jQuery);
	</script>
	<?php
	}
	//add_action( 'wp_head', 'fwp_add_facet_labels', 100 );

add_filter( 'upload_mimes', 'brenta_myme_types', 1, 1 );

function brenta_myme_types( $mime_types ) {
	$mime_types['p7m'] = 'application/pkcs7-mime';
	$mime_types['p7m'] = 'application/x-pkcs7-mime';

	return $mime_types;
}
