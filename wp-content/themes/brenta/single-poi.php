<?php
get_header();
?>
    <div id="main-content">

        <div id="content-area" class="clearfix">
			<?php while ( have_posts() ) : the_post();
    				$terms = get_the_terms(get_the_ID(), 'webmapp_category');
    				$icon = get_field( 'wm_taxonomy_icon', 'webmapp_category_' . $terms[0]->term_id );;
    				$color = get_field( 'wm_taxonomy_color', 'webmapp_category_' . $terms[0]->term_id );
			?>

                <article
                    id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post' . $additional_class ); ?>>
                    <div class="container">
	                    <?php
	                    if (function_exists('yoast_breadcrumb')) {
		                    yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
	                    }
	                    ?>
                        <div class="et_post_meta_wrapper">
                            <h1 class="entry-title">
                                <?php
                                $custom_image_icon = get_field( 'custom_image_icon' );
                                if ( ! empty( $custom_image_icon ) ): ?>
                                    <img src="<?php echo $custom_image_icon; ?>"
                                         width="40" height="40"/>
                                <?php elseif ( empty( $terms ) && empty( $custom_image_icon ) ):
                                    echo '<span class="green wm-icon-pin"></span>';
                                else :
	                                foreach ( $terms as $term ) {
		                                $icon_class = get_field( 'wm_taxonomy_icon', 'webmapp_category_' . $term->term_id );
		                                $icon_color = get_field( 'wm_taxonomy_color', 'webmapp_category_' . $term->term_id );
		                                echo '<span style="color:' . $icon_color . '" class="' . $icon_class . '"></span>';
	                                }
                                endif; ?>

                                <?php the_title(); ?>
								<?php if ( get_field( 'addr:city' ) ): ?>
                                - <?php the_field( 'addr:city' ); ?></h1>
							<?php else : ?>
                                </h1>
							<?php endif;

							$thumb     = '';
							$width     = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );
							$height    = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
							$classtext = 'et_featured_image';
							$titletext = get_the_title();
							$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, FALSE, 'Blogimage' );
							$thumb     = $thumbnail["thumb"];
							?>

                        </div> <!-- .et_post_meta_wrapper -->


                        <div class="entry-content green">
							<?php the_excerpt(); ?>
                        </div> <!-- .entry-content -->
                    </div>
                    <div class="single-left text">
                        <div class="brenta-thumb" style="background-image: url('<?php print $thumb; ?>');"></div>
                    </div>
                    <div class="single-right">
                        <div class="iframe">
                            <?php $indirizzo = get_field('n7webmap_coord');
                            if(!empty($indirizzo)):?>
                                <div id="custom-poi-map" data-icon="<?php echo $icon; ?>" data-icon-color="<?php echo $color; ?>" data-lat="<?php echo $indirizzo['lat']; ?>" data-lng="<?php echo $indirizzo['lng']; ?>" data-id="<?php echo get_the_ID(); ?>"></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="back-green">
                        <div class="container clearfix">
                            <div class="single-left text">
				                <?php the_content(); ?>
                            </div>
                            <div class="single-right">
                                <?php if(get_field('testo_colonna_destra')) :
                                    the_field('testo_colonna_destra'); ?>
                                    <hr />
                                <?php endif; ?>
                                <?php if(get_field('contact:phone')): ?>
                                <p><span class="title-acqua"><i class="fa fa-phone"
                                      aria-hidden="true"></i> <?php echo __( 'Tel', 'brenta' ) ?></span>  <?php the_field('contact:phone');  ?>
                                </p>
                                <hr />
                                <?php endif; ?>
	                            <?php if(get_field('contact_poi_fax')): ?>
                                    <p><span class="title-acqua"><i class="fa fa-fax"
                                                                    aria-hidden="true"></i> <?php echo __( 'Fax', 'brenta' ) ?></span>  <?php the_field('contact_poi_fax');  ?>
                                    </p>
                                    <hr />
	                            <?php endif; ?>
	                            <?php if(get_field('contact:email')): ?>
                                    <p><span class="title-acqua"><i class="fa fa-envelope" aria-hidden="true" style="font-size:16px;vertical-align: baseline;"></i> <?php echo __( 'Mail', 'brenta' ) ?></span>  <?php the_field('contact:email');  ?>
                                    </p>
                                    <hr />
	                            <?php endif; ?>
	                            <?php if(get_field('contact_poi_pec')): ?>
                                    <p><span class="title-acqua"><i class="fa fa-envelope" aria-hidden="true" style="font-size:16px;vertical-align: baseline;"></i> <?php echo __( 'PEC', 'brenta' ) ?></span>  <?php the_field('contact_poi_pec');  ?>
                                    </p>
                                    <hr />
	                            <?php endif; ?>
	                            <?php if(get_field('n7webmap_rpt_related_url')): ?>
                                    <p><span class="title-acqua"><i class="fa fa-globe" aria-hidden="true" style="font-size:16px;vertical-align: baseline;"></i> <?php echo __( 'Siti WEB', 'brenta' ) ?></span>
                                    <hr />
		                            <?php while( have_rows('n7webmap_rpt_related_url') ): the_row();
		                            $url = get_sub_field('net7webmap_related_url'); ?>
                                        <p class="web">
                                            <a href="<?php echo $url; ?>" target="_blank"><?php echo $url;  ?></a>
                                        </p>
		                            <?php endwhile; ?>
                                    </p>
                                    <hr />
	                            <?php endif; ?>
                                <?php if(get_field('opening_hours')): ?>
                                    <p><span class="title-acqua"><i class="fa fa-clock-o"
                                                                    aria-hidden="true"></i> <?php echo __( 'Orari apertura', 'brenta' ); ?></span>
                                    </p>
                                    <hr />
                                    <p class="details">
	                                    <?php the_field('opening_hours');  ?>
                                    </p>
                                    <hr />
                                <?php endif; ?>
	                            <?php if( get_field('addr:street') || get_field('addr:housenumber') || get_field('addr:postcode') || get_field('addr:city') ): ?>
                                    <p><span class="title-acqua"><i class="fa fa-map-marker" aria-hidden="true"></i> <?php echo __( 'Indirizzo', 'brenta' ); ?></span>
                                    </p>
                                    <hr />
                                    <p class="details">
			                            <?php the_field('addr:street');  ?> <?php the_field('addr:housenumber');  ?>
			                            <?php the_field('addr:postcode');  ?> <?php the_field('addr:city');  ?>
                                    </p>
	                            <?php endif; ?>
	                            <?php if(get_field('capacity')): ?>
                                    <hr />
                                    <p><span class="title-acqua">
                                            <i class="fa fa-users" aria-hidden="true"></i> <?php echo __( 'Posti disponibili', 'brenta' ); ?></span>
                                    </p>
                                    <hr />
                                    <p class="details">
			                            <?php the_field('capacity');  ?>
                                    </p>
	                            <?php endif;
	                            $prenotable = get_field('prenotabile');
	                            if ($prenotable){ ?>
                                    <a class="booking-button et_pb_button et_pb_custom_button_icon  et_pb_button_0 et_pb_module et_pb_bg_layout_light" data-icon="5" href="#">
                                        Richiedi una prenotazione</a>
	                            <?php echo '<div id="modal-form"><i class="fa fa-times booking-close-button" aria-hidden="true"></i><div class="container">' . do_shortcode('[contact-form-7 id="1244" title="Prenotazione"]') . '</div></div>'; ?>
                                    <script>
                                      (function($) {

                                        $('.booking-button').on('click', function(e) {
                                          e.preventDefault();
                                          $('#modal-form').fadeToggle();
                                        })
                                        $('.booking-close-button').on('click', function(e) {
                                          e.preventDefault();
                                          $('#modal-form').fadeOut();
                                        })


                                      })( jQuery );</script>
	                            <?php } ?>
                            </div>
                        </div>
                    </div>

                    <?php  $images = get_field('n7webmap_track_media_gallery');
                    if( $images ): ?>
                        <div class="container photogallery">
                            <div class="et_pb_gallery_items et_post_gallery">
                                <?php foreach( $images as $image ): ?>
                                    <div class="et_pb_gallery_item et_pb_grid_item et_pb_bg_layout_light">
                                        <div class="et_pb_gallery_image">
                                            <a href="<?php echo $image['url']; ?>" class="">
                                                <img src="<?php echo $image['sizes']['photogallery']; ?>" alt="<?php echo $image['alt']; ?>" />
                                            </a>
                                            <p><?php echo $image['caption']; ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </article> <!-- .et_pb_post -->

			<?php endwhile; ?>


			<?php //get_sidebar(); ?>
        </div> <!-- #content-area -->
    </div> <!-- #main-content -->

<?php get_footer(); ?>