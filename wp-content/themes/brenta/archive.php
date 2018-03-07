<?php get_header(); ?>

    <div id="et-main-area">
        <div id="main-content">
            <div class="entry-content">
                <div
                    id="et_pb_section et_pb_section_0 et_section_regular et_pb_section_first"
                    style="padding-top: 215px;">
                    <div class="et_pb_row et_pb_row_1">
                        <div
                            class="et_pb_column et_pb_column_4_4  et_pb_column_1 et_pb_css_mix_blend_mode_passthrough et-last-child">
                            <div
                                class="et_pb_fullwidth_portfolio et_pb_fullwidth_portfolio_grid clearfix et_pb_module et_pb_bg_layout_dark  et_pb_poi_list_0"
                                data-auto-rotate="off"
                                data-auto-rotate-speed="7000">

                                <div
                                    class="et_pb_portfolio_items clearfix columns-4"
                                    data-portfolio-columns="">
									<?php
									if ( have_posts() ) :
										while ( have_posts() ) :
											the_post();
											$post_format = et_pb_post_format(); ?>

                                        <div
                                            id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_portfolio_item' ); ?>>
											<?php
											$thumb = '';

											$width = 510;
											$width = (int) apply_filters( 'et_pb_portfolio_image_width', $width );

											$height = 382;
											$height = (int) apply_filters( 'et_pb_portfolio_image_height', $height );

											list( $thumb_src, $thumb_width, $thumb_height ) = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), [
												$width,
												$height,
											] );

											$orientation = ( $thumb_height > $thumb_width ) ? 'portrait' : 'landscape';

											if ( '' !== $thumb_src ) : ?>
                                                <div
                                                    class="et_pb_portfolio_image <?php echo esc_attr( $orientation ); ?>">
                                                    <img
                                                        src="<?php echo esc_url( $thumb_src ); ?>"
                                                        alt="<?php echo esc_attr( get_the_title() ); ?>"/>
                                                    <div class="meta">
                                                        <a href="<?php esc_url( the_permalink() ); ?>">
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

                                                            <h3><?php the_title(); ?></h3>


															<?php
															$post_type = get_post_type( get_the_ID() );
															if ( $post_type == 'post' ) {
																$post_terms = wp_get_post_terms( get_the_ID(), 'category', [ "fields" => "names" ] );
															} else {
																$post_terms = wp_get_post_terms( get_the_ID(), 'webmapp_category', [ "fields" => "names" ] );
															}

															if ( ! empty( $post_terms ) ) {
																if ( ( $key = array_search( 'Strutture Qualità Parco', $post_terms ) ) !== FALSE ) {
																	unset( $post_terms[ $key ] );
																}
																echo '<p class="post-meta">';
																echo implode( ' / ', $post_terms );
																echo '</p>';
															}
															?>
                                                            

                                                        </a>
                                                    </div>
                                                </div>
                                                </div>
											<?php endif; ?>


											<?php
										endwhile;

										if ( function_exists( 'wp_pagenavi' ) ) {
											wp_pagenavi();
										} else {
											get_template_part( 'includes/navigation', 'index' );
										}
									else :
										get_template_part( 'includes/no-results', 'index' );
									endif;
									?>
                                </div> <!-- .et_pb_portfolio_items -->
                            </div> <!-- .et_pb_fullwidth_portfolio -->
                        </div> <!-- .et_pb_column -->
                    </div> <!-- .et_pb_row -->
                </div> <!-- #et_pb_section -->
            </div> <!-- .entry-content -->
        </div> <!-- #main-content -->
    </div> <!-- #et-main-area -->

<?php get_footer(); ?>