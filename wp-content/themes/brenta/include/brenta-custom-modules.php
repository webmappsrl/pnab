<?php

class Brenta_Fullwidth_Highlights extends ET_Builder_Module {
	function init() {
		$this->name       = esc_html__( 'Brenta Fullwidth Highlights', 'et_builder' );
		$this->slug       = 'et_pb_brenta_fullwidth_highlights';
		$this->fb_support = TRUE;
		$this->fullwidth  = TRUE;

		// need to use global settings from the slider module
		$this->global_settings_slug = 'et_pb_blog';

		$this->whitelisted_fields = array(
			'title',
			'fullwidth',
			'type',
			'include_categories',
			'posts_number',
			'show_title',
			'show_date',
			'background_layout',
			'auto',
			'auto_speed',
			'hover_icon',
			'hover_overlay_color',
			'zoom_icon_color',
			'admin_label',
			'module_id',
			'module_class',
		);

		$this->main_css_element = '%%order_class%%';

		$this->advanced_options = array(
			'fonts'      => array(
				'title'   => array(
					'label' => esc_html__( 'Title', 'et_builder' ),
					'css'   => array(
						'main'      => "{$this->main_css_element} h3",
						'important' => 'all',
					),
				),
				'caption' => array(
					'label' => esc_html__( 'Meta', 'et_builder' ),
					'css'   => array(
						'main' => "{$this->main_css_element} .post-meta, {$this->main_css_element} .post-meta a",
					),
				),
			),
			'background' => array(
				'settings' => array(
					'color' => 'alpha',
				),
			),
			'border'     => array(
				'css' => array(
					'main' => "{$this->main_css_element} .et_pb_portfolio_item",
				),
			),
		);

		$this->custom_css_options = array(
			'portfolio_title'      => array(
				'label'    => esc_html__( 'Blog Title', 'et_builder' ),
				'selector' => '> h2',
			),
			'portfolio_item'       => array(
				'label'    => esc_html__( 'Blog Item', 'et_builder' ),
				'selector' => '.et_pb_portfolio_item',
			),
			'portfolio_overlay'    => array(
				'label'    => esc_html__( 'Item Overlay', 'et_builder' ),
				'selector' => 'span.et_overlay',
			),
			'portfolio_item_title' => array(
				'label'    => esc_html__( 'Item Title', 'et_builder' ),
				'selector' => '.meta h3',
			),
			'portfolio_meta'       => array(
				'label'    => esc_html__( 'Meta', 'et_builder' ),
				'selector' => '.meta p',
			),
			'portfolio_arrows'     => array(
				'label'    => esc_html__( 'Navigation Arrows', 'et_builder' ),
				'selector' => '.et-pb-slider-arrows a',
			),
		);

		$this->fields_defaults = array(
			'fullwidth'         => array( 'off' ),
			'show_title'        => array( 'on' ),
			'show_date'         => array( 'off' ),
			'background_layout' => array( 'light' ),
			'auto'              => array( 'off' ),
			'auto_speed'        => array( '7000' ),
		);
	}

	function get_fields() {
	    $types = array();
		foreach ( get_post_types( array('public' => true ), 'names' ) as $post_type ) {
			$types[$post_type] = $post_type;
		}

		$fields = array(
			'title'               => array(
				'label'           => esc_html__( 'Blog Title', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Title displayed above the blog.', 'et_builder' ),
			),
			'type'  => array(
				'label'           => esc_html__( 'Post type', 'et_builder' ),
				'type'            => 'select',
				'option_category' => 'basic_option',
				'options'         => $types,
				'description'     => esc_html__( 'Post type dysplayed', 'et_builder' ),

            ),
			'fullwidth'           => array(
				'label'           => esc_html__( 'Layout', 'et_builder' ),
				'type'            => 'select',
				'option_category' => 'layout',
				'options'         => array(
					'on'  => esc_html__( 'Carousel', 'et_builder' ),
					'off' => esc_html__( 'Grid', 'et_builder' ),
				),
				'affects'         => array(
					'auto',
				),
				'description'     => esc_html__( 'Choose your desired Blog layout style.', 'et_builder' ),
			),
			'include_categories'  => array(
				'label'            => esc_html__( 'Include Categories', 'et_builder' ),
				'renderer'         => 'et_builder_include_categories_option',
				'option_category'  => 'basic_option',
				'description'      => esc_html__( 'Select the categories that you would like to include in the feed.', 'et_builder' ),
				'computed_affects' => array(
					'__post',
				),
				'taxonomy_name'    => 'project_category',
			),
			'posts_number'        => array(
				'label'            => esc_html__( 'Posts Number', 'et_builder' ),
				'type'             => 'text',
				'option_category'  => 'configuration',
				'description'      => esc_html__( 'Control how many projects are displayed. Leave blank or use 0 to not limit the amount.', 'et_builder' ),
				'computed_affects' => array(
					'__post',
				),
			),
			'show_title'          => array(
				'label'           => esc_html__( 'Show Title', 'et_builder' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'description'     => esc_html__( 'Turn project titles on or off.', 'et_builder' ),
			),
			'show_date'           => array(
				'label'           => esc_html__( 'Show Date', 'et_builder' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'description'     => esc_html__( 'Turn the date display on or off.', 'et_builder' ),
			),
			'background_layout'   => array(
				'label'           => esc_html__( 'Text Color', 'et_builder' ),
				'type'            => 'select',
				'option_category' => 'color_option',
				'options'         => array(
					'light' => esc_html__( 'Dark', 'et_builder' ),
					'dark'  => esc_html__( 'Light', 'et_builder' ),
				),
				'description'     => esc_html__( 'Here you can choose whether your text should be light or dark. If you are working with a dark background, then your text should be light. If your background is light, then your text should be set to dark.', 'et_builder' ),
			),
			'auto'                => array(
				'label'           => esc_html__( 'Automatic Carousel Rotation', 'et_builder' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'off' => esc_html__( 'Off', 'et_builder' ),
					'on'  => esc_html__( 'On', 'et_builder' ),
				),
				'affects'         => array(
					'auto_speed',
				),
				'depends_show_if' => 'on',
				'description'     => esc_html__( 'If you the carousel layout option is chosen and you would like the carousel to slide automatically, without the visitor having to click the next button, enable this option and then adjust the rotation speed below if desired.', 'et_builder' ),
			),
			'auto_speed'          => array(
				'label'           => esc_html__( 'Automatic Carousel Rotation Speed (in ms)', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'depends_default' => TRUE,
				'description'     => esc_html__( "Here you can designate how fast the carousel rotates, if 'Automatic Carousel Rotation' option is enabled above. The higher the number the longer the pause between each rotation. (Ex. 1000 = 1 sec)", 'et_builder' ),
			),
			'zoom_icon_color'     => array(
				'label'        => esc_html__( 'Zoom Icon Color', 'et_builder' ),
				'type'         => 'color',
				'custom_color' => TRUE,
				'tab_slug'     => 'advanced',
			),
			'hover_overlay_color' => array(
				'label'        => esc_html__( 'Hover Overlay Color', 'et_builder' ),
				'type'         => 'color-alpha',
				'custom_color' => TRUE,
				'tab_slug'     => 'advanced',
			),
			'hover_icon'          => array(
				'label'               => esc_html__( 'Hover Icon Picker', 'et_builder' ),
				'type'                => 'text',
				'option_category'     => 'configuration',
				'class'               => array( 'et-pb-font-icon' ),
				'renderer'            => 'et_pb_get_font_icon_list',
				'renderer_with_field' => TRUE,
				'tab_slug'            => 'advanced',
			),
			'disabled_on'         => array(
				'label'           => esc_html__( 'Disable on', 'et_builder' ),
				'type'            => 'multiple_checkboxes',
				'options'         => array(
					'phone'   => esc_html__( 'Phone', 'et_builder' ),
					'tablet'  => esc_html__( 'Tablet', 'et_builder' ),
					'desktop' => esc_html__( 'Desktop', 'et_builder' ),
				),
				'additional_att'  => 'disable_on',
				'option_category' => 'configuration',
				'description'     => esc_html__( 'This will disable the module on selected devices', 'et_builder' ),
			),
			'admin_label'         => array(
				'label'       => esc_html__( 'Admin Label', 'et_builder' ),
				'type'        => 'text',
				'description' => esc_html__( 'This will change the label of the module in the builder for easy identification.', 'et_builder' ),
			),
			'module_id'           => array(
				'label'           => esc_html__( 'CSS ID', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'tab_slug'        => 'custom_css',
				'option_class'    => 'et_pb_custom_css_regular',
			),
			'module_class'        => array(
				'label'           => esc_html__( 'CSS Class', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'tab_slug'        => 'custom_css',
				'option_class'    => 'et_pb_custom_css_regular',
			),
			'__projects'          => array(
				'type'                => 'computed',
				'computed_callback'   => array(
					'Brenta_Fullwidth_Highlights',
					'get_portfolio_item'
				),
				'computed_depends_on' => array(
					'posts_number',
					'include_categories',
				),
			),
		);

		return $fields;
	}

	/**
	 * Get portfolio objects for portfolio module
	 *
	 * @param array  arguments that affect et_pb_portfolio query
	 * @param array  passed conditional tag for update process
	 * @param array  passed current page params
	 *
	 * @return array portfolio item data
	 */
	static function get_portfolio_item( $args = array(), $conditional_tags = array(), $current_page = array() ) {
		$defaults = array(
			'posts_number'       => '',
			'include_categories' => '',
		);

		$args = wp_parse_args( $args, $defaults );

		$query_args = array(
		    'post_type' => $args['post_type'],
			'post_status' => 'publish',
		);

		if ( $args['post_type'] == 'highlights') {
			$query_args['meta_key'] = 'ordine';
			$query_args['orderby'] = 'meta_value';
			$query_args['order'] = 'ASC';
        }

		if ( is_numeric( $args['posts_number'] ) && $args['posts_number'] > 0 ) {
			$query_args['posts_per_page'] = $args['posts_number'];
		} else {
			$query_args['nopaging'] = TRUE;
		}

		if ( '' !== $args['include_categories'] ) {
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'category',
					'field'    => 'id',
					'terms'    => explode( ',', $args['include_categories'] ),
					'operator' => 'IN'
				)
			);
		}

		// Get portfolio query
		$query = new WP_Query( $query_args );

		// Format portfolio output, add supplementary data
		$width  = (int) apply_filters( 'et_pb_portfolio_image_width', 510 );
		$height = (int) apply_filters( 'et_pb_portfolio_image_height', 382 );

		if ( $query->post_count > 0 ) {
			$post_index = 0;
			while ( $query->have_posts() ) {
				$query->the_post();

				// Get thumbnail
				$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), array(
					$width,
					$height
				) );

				if ( isset( $thumbnail[2] ) && isset( $thumbnail[1] ) ) {
					$orientation = ( $thumbnail[2] > $thumbnail[1] ) ? 'portrait' : 'landscape';
				} else {
					$orientation = FALSE;
				}

				// Append value to query post
				$query->posts[ $post_index ]->post_permalink             = get_permalink();
				$query->posts[ $post_index ]->post_thumbnail             = isset( $thumbnail[0] ) ? $thumbnail[0] : FALSE;
				$query->posts[ $post_index ]->post_thumbnail_orientation = $orientation;
				$query->posts[ $post_index ]->post_date_readable         = get_the_date();
				$query->posts[ $post_index ]->post_class_name            = get_post_class( 'et_pb_portfolio_item et_pb_grid_item ' );

				$post_index ++;
			}
		}

		wp_reset_postdata();

		return $query;
	}

	function shortcode_callback( $atts, $content = NULL, $function_name ) {
		$title               = $this->shortcode_atts['title'];
		$type                = $atts['type'];
		$module_id           = $this->shortcode_atts['module_id'];
		$module_class        = $this->shortcode_atts['module_class'];
		$fullwidth           = $this->shortcode_atts['fullwidth'];
		$include_categories  = $this->shortcode_atts['include_categories'];
		$posts_number        = $this->shortcode_atts['posts_number'];
		$show_title          = $this->shortcode_atts['show_title'];
		$show_date           = $this->shortcode_atts['show_date'];
		$background_layout   = $this->shortcode_atts['background_layout'];
		$auto                = $this->shortcode_atts['auto'];
		$auto_speed          = $this->shortcode_atts['auto_speed'];
		$zoom_icon_color     = $this->shortcode_atts['zoom_icon_color'];
		$hover_overlay_color = $this->shortcode_atts['hover_overlay_color'];
		$hover_icon          = $this->shortcode_atts['hover_icon'];

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

		if ( '' !== $zoom_icon_color ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% .et_overlay:before',
				'declaration' => sprintf(
					'color: %1$s !important;',
					esc_html( $zoom_icon_color )
				),
			) );
		}

		if ( '' !== $hover_overlay_color ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% .et_overlay',
				'declaration' => sprintf(
					'background-color: %1$s;
					border-color: %1$s;',
					esc_html( $hover_overlay_color )
				),
			) );
		}

		$args = array();


		if ( is_numeric( $posts_number ) && $posts_number > 0 ) {
			$args['posts_per_page'] = $posts_number;
		} else {
			$args['nopaging'] = TRUE;
		}

		if ( '' !== $include_categories ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'category',
					'field'    => 'id',
					'terms'    => explode( ',', $include_categories ),
					'operator' => 'IN'
				)
			);
		}

		if (empty($type)){
		    $type = 'post';
        }
		$projects = self::get_portfolio_item( array(
			'post_type'         => $type,
			'posts_number'       => $posts_number,
			'include_categories' => $include_categories,
		) );

		ob_start();
		if ( $projects->post_count > 0 ) {
			while ( $projects->have_posts() ) {
				$projects->the_post();
				?>
                <div
                    id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_portfolio_item et_pb_grid_item ' ); ?>>
					<?php
					$thumb = '';

					$width = 510;
					$width = (int) apply_filters( 'et_pb_portfolio_image_width', $width );

					$height = 382;
					$height = (int) apply_filters( 'et_pb_portfolio_image_height', $height );



					if ( $type == 'highlights' ){
						$related_item = get_field('contenuto_collegato');
						list( $thumb_src, $thumb_width, $thumb_height ) = wp_get_attachment_image_src( get_post_thumbnail_id( $related_item[0]->ID ), array( $width, $height )  );
					} else {
						list( $thumb_src, $thumb_width, $thumb_height ) = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), array( $width, $height ) );
                    }
					$orientation = ( $thumb_height > $thumb_width ) ? 'portrait' : 'landscape';

					if ( '' !== $thumb_src ) : ?>
                        <div
                            class="et_pb_portfolio_image <?php echo esc_attr( $orientation ); ?>">
                            <img src="<?php echo esc_url( $thumb_src ); ?>"
                                 alt="<?php echo esc_attr( get_the_title() ); ?>"/>
                            <div class="meta">
                                <?php if ( $type == 'highlights' && !empty($related_item) ) : ?>
                                    <a href="<?php echo get_permalink( $related_item[0]->ID ); ?>">
                                <?php else : ?>
                                    <a href="<?php esc_url( the_permalink() ); ?>">
                                <?php endif; ?>
									<?php
									$data_icon = '' !== $hover_icon
										? sprintf(
											' data-icon="%1$s"',
											esc_attr( et_pb_process_font_icon( $hover_icon ) )
										)
										: '';

									printf( '<span class="et_overlay%1$s"%2$s></span>',
										( '' !== $hover_icon ? ' et_pb_inline_icon' : '' ),
										$data_icon
									);
									?>
									<?php if ( 'on' === $show_title ) :
                                        if ( $type == 'highlights' && !empty($related_item) ) : ?>
                                            <h3><?php echo $related_item[0]->post_title; ?></h3>
                                       <?php else : ?>
                                        <h3><?php the_title(); ?></h3>
									<?php endif; endif; ?>


                                    <p class="post-meta">
										<?php
										$post_terms = wp_get_post_terms( get_the_ID(), 'category', array( "fields" => "names" ) );
										if ( ! empty( $post_terms ) ) {
											echo implode( ' / ', $post_terms );
										}
										if ( $type == 'highlights' && !empty($related_item) ){
										    $related_type = $related_item[0]->post_type;
										    switch ($related_type) {
                                                case 'post':
	                                                $related_type = 'news';
	                                                break;
                                                case 'project':
	                                                $related_type = 'proposta';
	                                                break;
                                            }
										    echo $related_type;
                                        }
										?>
                                    </p>

                                </a>
                            </div>
                        </div>
					<?php endif; ?>
                </div>
				<?php
			}
		}

		wp_reset_postdata();

		$posts = ob_get_clean();

		$class = " et_pb_module et_pb_bg_layout_{$background_layout}";

		$output = sprintf(
			'<div%4$s class="et_pb_fullwidth_portfolio %1$s%3$s%5$s" data-auto-rotate="%6$s" data-auto-rotate-speed="%7$s">
				%8$s
				<div class="et_pb_portfolio_items clearfix" data-portfolio-columns="">
					%2$s
				</div><!-- .et_pb_portfolio_items -->
			</div> <!-- .et_pb_fullwidth_portfolio -->',
			( 'on' === $fullwidth ? 'et_pb_fullwidth_portfolio_carousel' : 'et_pb_fullwidth_portfolio_grid clearfix' ),
			$posts,
			esc_attr( $class ),
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
			( '' !== $auto && in_array( $auto, array(
				'on',
				'off'
			) ) ? esc_attr( $auto ) : 'off' ),
			( '' !== $auto_speed && is_numeric( $auto_speed ) ? esc_attr( $auto_speed ) : '7000' ),
			( '' !== $title ? sprintf( '<h2>%s</h2>', esc_html( $title ) ) : '' )
		);

		return $output;
	}
}

new Brenta_Fullwidth_Highlights;


class ET_Builder_Module_Custom_Filterable_Portfolio extends ET_Builder_Module {
	function init() {
		$this->name       = esc_html__( 'Custom Filterable Portfolio', 'et_builder' );
		$this->slug       = 'et_pb_custom_filterable_portfolio';
		$this->fb_support = TRUE;

		$this->whitelisted_fields = array(
			'fullwidth',
			'posts_number',
			'include_categories',
			'show_title',
			'show_categories',
			'show_pagination',
			'background_layout',
			'admin_label',
			'module_id',
			'module_class',
			'hover_icon',
			'zoom_icon_color',
			'hover_overlay_color',
		);

		$this->fields_defaults = array(
			'fullwidth'         => array( 'on' ),
			'posts_number'      => array( 10, 'add_default_setting' ),
			'show_title'        => array( 'on' ),
			'show_categories'   => array( 'on' ),
			'show_pagination'   => array( 'on' ),
			'background_layout' => array( 'light' ),
		);

		$this->main_css_element   = '%%order_class%%.et_pb_filterable_portfolio';
		$this->advanced_options   = array(
			'fonts'      => array(
				'title'   => array(
					'label' => esc_html__( 'Title', 'et_builder' ),
					'css'   => array(
						'main'        => "{$this->main_css_element} h2",
						'plugin_main' => "{$this->main_css_element} h2, {$this->main_css_element} h2 a",
						'important'   => 'all',
					),
				),
				'caption' => array(
					'label' => esc_html__( 'Meta', 'et_builder' ),
					'css'   => array(
						'main' => "{$this->main_css_element} .post-meta, {$this->main_css_element} .post-meta a",
					),
				),
				'filter'  => array(
					'label' => esc_html__( 'Filter', 'et_builder' ),
					'css'   => array(
						'main'        => "{$this->main_css_element} .et_pb_portfolio_filter",
						'plugin_main' => "{$this->main_css_element} .et_pb_portfolio_filter, {$this->main_css_element} .et_pb_portfolio_filter a",
						'color'       => "{$this->main_css_element} .et_pb_portfolio_filter a",
					),
				),
			),
			'background' => array(
				'settings' => array(
					'color' => 'alpha',
				),
			),
			'border'     => array(
				'css' => array(
					'main' => "{$this->main_css_element} .et_pb_portfolio_item",
				),
			),
		);
		$this->custom_css_options = array(
			'portfolio_filters'           => array(
				'label'                    => esc_html__( 'Portfolio Filters', 'et_builder' ),
				'selector'                 => '.et_pb_filterable_portfolio .et_pb_portfolio_filters',
				'no_space_before_selector' => TRUE,
			),
			'active_portfolio_filter'     => array(
				'label'                    => esc_html__( 'Active Portfolio Filter', 'et_builder' ),
				'selector'                 => '.et_pb_filterable_portfolio .et_pb_portfolio_filters li a.active',
				'no_space_before_selector' => TRUE,
			),
			'portfolio_image'             => array(
				'label'    => esc_html__( 'Portfolio Image', 'et_builder' ),
				'selector' => '.et_portfolio_image',
			),
			'overlay'                     => array(
				'label'    => esc_html__( 'Overlay', 'et_builder' ),
				'selector' => '.et_overlay',
			),
			'overlay_icon'                => array(
				'label'    => esc_html__( 'Overlay Icon', 'et_builder' ),
				'selector' => '.et_overlay:before',
			),
			'portfolio_title'             => array(
				'label'    => esc_html__( 'Portfolio Title', 'et_builder' ),
				'selector' => '.et_pb_portfolio_item h2',
			),
			'portfolio_post_meta'         => array(
				'label'    => esc_html__( 'Portfolio Post Meta', 'et_builder' ),
				'selector' => '.et_pb_portfolio_item .post-meta',
			),
			'portfolio_pagination'        => array(
				'label'    => esc_html__( 'Portfolio Pagination', 'et_builder' ),
				'selector' => '.et_pb_portofolio_pagination',
			),
			'portfolio_pagination_active' => array(
				'label'    => esc_html__( 'Pagination Active Page', 'et_builder' ),
				'selector' => '.et_pb_portofolio_pagination a.active',
			),
		);
	}

	function get_fields() {
		$fields = array(
			'fullwidth'           => array(
				'label'            => esc_html__( 'Layout', 'et_builder' ),
				'type'             => 'select',
				'option_category'  => 'layout',
				'options'          => array(
					'on'  => esc_html__( 'Fullwidth', 'et_builder' ),
					'off' => esc_html__( 'Grid', 'et_builder' ),
				),
				'affects'          => array(
					'hover_icon',
					'zoom_icon_color',
					'hover_overlay_color',
				),
				'description'      => esc_html__( 'Choose your desired portfolio layout style.', 'et_builder' ),
				'computed_affects' => array(
					'__projects',
				),
			),
			'posts_number'        => array(
				'label'            => esc_html__( 'Posts Number', 'et_builder' ),
				'type'             => 'text',
				'option_category'  => 'configuration',
				'description'      => esc_html__( 'Define the number of projects that should be displayed per page.', 'et_builder' ),
				'computed_affects' => array(
					'__projects',
				),
			),
			'include_categories'  => array(
				'label'            => esc_html__( 'Include Categories', 'et_builder' ),
				'renderer'         => 'et_builder_include_categories_option',
				'option_category'  => 'basic_option',
				'description'      => esc_html__( 'Select the categories that you would like to include in the feed.', 'et_builder' ),
				'computed_affects' => array(
					'__project_terms',
					'__projects',
				),
				'taxonomy_name'    => 'project_category',
			),
			'show_title'          => array(
				'label'           => esc_html__( 'Show Title', 'et_builder' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'description'     => esc_html__( 'Turn project titles on or off.', 'et_builder' ),
			),
			'show_categories'     => array(
				'label'           => esc_html__( 'Show Categories', 'et_builder' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'description'     => esc_html__( 'Turn the category links on or off.', 'et_builder' ),
			),
			'show_pagination'     => array(
				'label'           => esc_html__( 'Show Pagination', 'et_builder' ),
				'type'            => 'yes_no_button',
				'option_category' => 'configuration',
				'options'         => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'description'     => esc_html__( 'Enable or disable pagination for this feed.', 'et_builder' ),
			),
			'background_layout'   => array(
				'label'           => esc_html__( 'Text Color', 'et_builder' ),
				'type'            => 'select',
				'option_category' => 'color_option',
				'options'         => array(
					'light' => esc_html__( 'Dark', 'et_builder' ),
					'dark'  => esc_html__( 'Light', 'et_builder' ),
				),
				'description'     => esc_html__( 'Here you can choose whether your text should be light or dark. If you are working with a dark background, then your text should be light. If your background is light, then your text should be set to dark.', 'et_builder' ),
			),
			'hover_icon'          => array(
				'label'               => esc_html__( 'Hover Icon Picker', 'et_builder' ),
				'type'                => 'text',
				'option_category'     => 'configuration',
				'class'               => array( 'et-pb-font-icon' ),
				'renderer'            => 'et_pb_get_font_icon_list',
				'renderer_with_field' => TRUE,
				'depends_show_if'     => 'off',
				'tab_slug'            => 'advanced',
			),
			'zoom_icon_color'     => array(
				'label'           => esc_html__( 'Zoom Icon Color', 'et_builder' ),
				'type'            => 'color',
				'custom_color'    => TRUE,
				'depends_show_if' => 'off',
				'tab_slug'        => 'advanced',
			),
			'hover_overlay_color' => array(
				'label'           => esc_html__( 'Hover Overlay Color', 'et_builder' ),
				'type'            => 'color-alpha',
				'custom_color'    => TRUE,
				'depends_show_if' => 'off',
				'tab_slug'        => 'advanced',
			),
			'__project_terms'     => array(
				'type'                => 'computed',
				'computed_callback'   => array(
					'ET_Builder_Module_Custom_Filterable_Portfolio',
					'get_portfolio_terms'
				),
				'computed_depends_on' => array(
					'include_categories',
				),
			),
			'__projects'          => array(
				'type'                => 'computed',
				'computed_callback'   => array(
					'ET_Builder_Module_Custom_Filterable_Portfolio',
					'get_portfolio_item'
				),
				'computed_depends_on' => array(
					'show_pagination',
					'posts_number',
					'include_categories',
					'fullwidth',
				),
			),
			'disabled_on'         => array(
				'label'           => esc_html__( 'Disable on', 'et_builder' ),
				'type'            => 'multiple_checkboxes',
				'options'         => array(
					'phone'   => esc_html__( 'Phone', 'et_builder' ),
					'tablet'  => esc_html__( 'Tablet', 'et_builder' ),
					'desktop' => esc_html__( 'Desktop', 'et_builder' ),
				),
				'additional_att'  => 'disable_on',
				'option_category' => 'configuration',
				'description'     => esc_html__( 'This will disable the module on selected devices', 'et_builder' ),
			),
			'admin_label'         => array(
				'label'       => esc_html__( 'Admin Label', 'et_builder' ),
				'type'        => 'text',
				'description' => esc_html__( 'This will change the label of the module in the builder for easy identification.', 'et_builder' ),
			),
			'module_id'           => array(
				'label'           => esc_html__( 'CSS ID', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'tab_slug'        => 'custom_css',
				'option_class'    => 'et_pb_custom_css_regular',
			),
			'module_class'        => array(
				'label'           => esc_html__( 'CSS Class', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'tab_slug'        => 'custom_css',
				'option_class'    => 'et_pb_custom_css_regular',
			),
		);

		return $fields;
	}

	static function get_portfolio_item( $args = array(), $conditional_tags = array(), $current_page = array() ) {
		global $et_fb_processing_shortcode_object;

		$global_processing_original_value = $et_fb_processing_shortcode_object;

		$defaults = array(
			'show_pagination'    => 'on',
			'posts_number'       => '10',
			'include_categories' => '',
			'fullwidth'          => 'on',
            'orderby'           => 'rand',
            'order'             => 'ASC',
		);

		$args = wp_parse_args( $args, $defaults );

		if ( 'on' === $args['show_pagination'] ) {
			$query_args['nopaging'] = TRUE;
		} else {
			$query_args['posts_per_page'] = (int) $args['posts_number'];
		}

		if ( '' !== $args['include_categories'] ) {
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'project_category',
					'field'    => 'id',
					'terms'    => explode( ',', $args['include_categories'] ),
					'operator' => 'IN',
				)
			);
		}

		$default_query_args = array(
			'post_type'   => 'project',
			'post_status' => 'publish',
            'orderby'     => 'rand',
		);

		$query_args = wp_parse_args( $query_args, $default_query_args );

		// Get portfolio query
		$query = new WP_Query( $query_args );

		// Format portfolio output, and add supplementary data
		$width     = 'on' === $args['fullwidth'] ? 1080 : 400;
		$width     = (int) apply_filters( 'et_pb_portfolio_image_width', $width );
		$height    = 'on' === $args['fullwidth'] ? 9999 : 284;
		$height    = (int) apply_filters( 'et_pb_portfolio_image_height', $height );
		$classtext = 'on' === $args['fullwidth'] ? 'et_pb_post_main_image' : '';
		$titletext = get_the_title();

		// Loop portfolio item and add supplementary data
		if ( $query->have_posts() ) {
			$post_index = 0;
			while ( $query->have_posts() ) {
				$query->the_post();

				$categories = array();

				$category_classes = array( 'et_pb_portfolio_item' );

				if ( 'on' !== $args['fullwidth'] ) {
					$category_classes[] = 'et_pb_grid_item';
				}

				$categories_object = get_the_terms( get_the_ID(), 'project_category' );
				if ( ! empty( $categories_object ) ) {
					foreach ( $categories_object as $category ) {
						// Update category classes which will be used for post_class
						$category_classes[] = 'project_category_' . urldecode( $category->slug );

						// Push category data
						$categories[] = array(
							'id'        => $category->term_id,
							'slug'      => $category->slug,
							'label'     => $category->name,
							'permalink' => get_term_link( $category ),
						);
					}
				}

				// need to disable processnig to make sure get_thumbnail() doesn't generate errors
				$et_fb_processing_shortcode_object = FALSE;

				// Get thumbnail
				$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, FALSE, 'Blogimage' );

				$et_fb_processing_shortcode_object = $global_processing_original_value;

				// Append value to query post
				$query->posts[ $post_index ]->post_permalink  = get_permalink();
				$query->posts[ $post_index ]->post_thumbnail  = print_thumbnail( $thumbnail['thumb'], $thumbnail['use_timthumb'], $titletext, $width, $height, '', FALSE, TRUE );
				$query->posts[ $post_index ]->post_categories = $categories;
				$query->posts[ $post_index ]->post_class_name = array_merge( get_post_class( '', get_the_ID() ), $category_classes );

				// Append category classes
				$category_classes = implode( ' ', $category_classes );

				$post_index ++;
			}
		}

		wp_reset_postdata();

		return $query;
	}

	static function get_portfolio_terms( $args = array(), $conditional_tags = array(), $current_page = array() ) {
		$portfolio = self::get_portfolio_item( $args, $conditional_tags, $current_page );

		$terms = array();

		if ( ! empty( $portfolio->posts ) ) {
			foreach ( $portfolio->posts as $post ) {
				if ( ! empty( $post->post_categories ) ) {
					foreach ( $post->post_categories as $category ) {
						$terms[ $category['slug'] ] = $category;
					}
				}
			}
		}

		return $terms;
	}

	function shortcode_callback( $atts, $content = NULL, $function_name ) {
		$module_id           = $this->shortcode_atts['module_id'];
		$module_class        = $this->shortcode_atts['module_class'];
		$fullwidth           = $this->shortcode_atts['fullwidth'];
		$posts_number        = $this->shortcode_atts['posts_number'];
		$include_categories  = $this->shortcode_atts['include_categories'];
		$show_title          = $this->shortcode_atts['show_title'];
		$show_categories     = $this->shortcode_atts['show_categories'];
		$show_pagination     = $this->shortcode_atts['show_pagination'];
		$background_layout   = $this->shortcode_atts['background_layout'];
		$hover_icon          = $this->shortcode_atts['hover_icon'];
		$zoom_icon_color     = $this->shortcode_atts['zoom_icon_color'];
		$hover_overlay_color = $this->shortcode_atts['hover_overlay_color'];

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

		wp_enqueue_script( 'hashchange' );

		if ( '' !== $zoom_icon_color ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% .et_overlay:before',
				'declaration' => sprintf(
					'color: %1$s !important;',
					esc_html( $zoom_icon_color )
				),
			) );
		}

		if ( '' !== $hover_overlay_color ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% .et_overlay',
				'declaration' => sprintf(
					'background-color: %1$s;
					border-color: %1$s;',
					esc_html( $hover_overlay_color )
				),
			) );
		}

		$projects = self::get_portfolio_item( array(
			'show_pagination'    => $show_pagination,
			'posts_number'       => $posts_number,
			'include_categories' => $include_categories,
			'fullwidth'          => $fullwidth,
		) );

		$categories_included = array();
		ob_start();
		$c = 1; ?>
		<?php
        echo '<div class="brenta-facet categories"><span class="line"></span><span>'. __('Chi', 'brenta') .'</span><span class="line"></span>' . facetwp_display( 'facet', 'categories' ) . '</div>';
        echo '<div class="brenta-facet types"><span class="line"></span><span>'. __('Cosa', 'brenta') .'</span><span class="line"></span>' . facetwp_display( 'facet', 'activity' ) . '</div>';
        echo '<div class="brenta-facet seasons"><span class="line"></span><span>'. __('Dove', 'brenta') .'</span><span class="line"></span>' . facetwp_display( 'facet', 'location' ) . '</div>';
        echo '<div class="brenta-facet seasons"><span class="line"></span><span>'. __('Quando', 'brenta') .'</span><span class="line"></span>' . facetwp_display( 'facet', 'seasons' ) . '</div>';
		?>
        <div class="facetwp-template">
			<?php
			if ( $projects->post_count > 0 ) {
				while ( $projects->have_posts() ) {
					$projects->the_post();

					$category_classes = array();
					$categories       = get_the_terms( get_the_ID(), 'project_category' );
					if ( $categories ) {
						foreach ( $categories as $category ) {
							$category_classes[]    = 'project_category_' . urldecode( $category->slug );
							$categories_included[] = $category->term_id;
						}
					}

					$category_classes = implode( ' ', $category_classes );

					$main_post_class = sprintf(
						'et_pb_portfolio_item%1$s %2$s',
						( 'on' !== $fullwidth ? ' custom_grid_item' : '' ),
						$category_classes
					);

					?>
					<?php

					?>
                    <div
                        id="post-<?php the_ID(); ?>" <?php post_class( $main_post_class ); ?>
                        style="background-image: url('<?php echo get_the_post_thumbnail_url( get_the_ID(), 'portfolio-size' ); ?>')">

						<?php //echo  get_the_post_thumbnail( get_the_ID(), 'portfolio-custom-size'  );?>


						<?php if ( 'on' === $show_title ) : ?>
                            <h2>
                                <a href="<?php esc_url( the_permalink() ); ?>"><?php the_title(); ?></a>
                            </h2>
						<?php endif; ?>

						<?php if ( 'on' === $show_categories ) : ?>
                            <p class="post-meta"><?php echo get_the_term_list( get_the_ID(), 'project_category', '', ', ' ); ?></p>
						<?php endif; ?>

                    </div><!-- .et_pb_portfolio_item -->
					<?php $c ++;
				}
			} ?>
        </div>
		<?php

		wp_reset_postdata();

		$posts = ob_get_clean();

		$categories_included = explode( ',', $include_categories );
		$terms_args          = array(
			'include' => $categories_included,
			'orderby' => 'name',
			'order'   => 'ASC',
		);
		$terms               = get_terms( 'project_category', $terms_args );

		$category_filters = '<ul class="clearfix">';
		$category_filters .= sprintf( '<li class="et_pb_portfolio_filter et_pb_portfolio_filter_all"><a href="#" class="active" data-category-slug="all">%1$s</a></li>',
			esc_html__( 'All', 'et_builder' )
		);
		foreach ( $terms as $term ) {
			$category_filters .= sprintf( '<li class="et_pb_portfolio_filter"><a href="#" data-category-slug="%1$s">%2$s</a></li>',
				esc_attr( urldecode( $term->slug ) ),
				esc_html( $term->name )
			);
		}
		$category_filters .= '</ul>';

		$class = " et_pb_module et_pb_bg_layout_{$background_layout}";

		$output = sprintf(
			'<div%5$s class="et_pb_filterable_portfolio et_pb_portfolio %1$s%4$s%6$s" data-posts-number="%7$d"%10$s>
				<div class="et_pb_portfolio_filters clearfix"></div><!-- .et_pb_portfolio_filters -->

				<div class="et_pb_portfolio_items_wrapper %8$s">
					<div class="et_pb_portfolio_items">%3$s</div><!-- .et_pb_portfolio_items -->
				</div>
				%9$s
			</div> <!-- .et_pb_filterable_portfolio -->',
			( 'on' === $fullwidth ? 'et_pb_filterable_portfolio_fullwidth' : 'et_pb_filterable_portfolio_grid clearfix' ),
			$category_filters,
			$posts,
			esc_attr( $class ),
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
			esc_attr( $posts_number ),
			( 'on' === $show_pagination ? '' : 'no_pagination' ),
			( 'on' === $show_pagination ? '<div class="et_pb_portofolio_pagination"></div>' : '' ),
			is_rtl() ? ' data-rtl="true"' : ''
		);

		return $output;
    }
}

new ET_Builder_Module_Custom_Filterable_Portfolio;