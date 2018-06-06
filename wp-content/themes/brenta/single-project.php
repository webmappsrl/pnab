<?php
get_header();
global $post;

$routes = get_field( 'related_route' );
if ( empty( $routes ) ) {
	$routes = [];
}
$tracks = get_field( 'related_tracks' );
if ( empty( $tracks ) ) {
	$tracks = [];
}
$pois = get_field( 'related_poi' );
if ( empty( $pois ) ) {
	$pois = [];
}
$related = array_merge_recursive( $routes, $tracks, $pois );
?>
    <div id="main-content">

        <div id="content-area" class="clearfix">
			<?php while ( have_posts() ) : the_post(); ?>
                <article
                    id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post' . $additional_class ); ?>>
                    <div class="container">
						<?php
						if ( function_exists( 'yoast_breadcrumb' ) ) {
							yoast_breadcrumb( '<p id="breadcrumbs">', '</p>' );
						}
						?>
                        <div class="et_post_meta_wrapper">
                            <h1 class="entry-title"><?php the_title(); ?></h1>
                            <div class="categories facetwp-facet facetwp-facet-activity facetwp-type-radio">
		                        <?php
		                        $args       = [];
		                        $activities = wp_get_post_terms( get_the_ID(), 'attivita', $args );
		                        $seasons    = wp_get_post_terms( get_the_ID(), 'season', $args );
		                        $locations    = wp_get_post_terms( get_the_ID(), 'location', $args );
		                        $categories = wp_get_post_terms( get_the_ID(), 'project_category', $args );

		                        foreach ( $activities as $activity ) {
			                        echo '<div class="facetwp-radio checked" data-value="' . $activity->slug . '">' . $activity->name . '</div>';
		                        }
		                        foreach ( $locations as $location ) {
			                        echo '<div class="facetwp-radio checked" data-value="' . $location->slug . '">' . $location->name . '</div>';
		                        }
		                        foreach ( $seasons as $season ) {
			                        echo '<div class="facetwp-radio checked" data-value="' . $season->slug . '">' . $season->name . '</div>';
		                        }
		                        foreach ( $categories as $category ) {
			                        echo '<div class="facetwp-radio checked" data-value="' . $category->slug . '">' . $category->name . '</div>';
		                        }
		                        ?>
                            </div>
							<?php if ( get_field( 'subtitle' ) ) { ?>
                                <h3 class="subtitle"><?php the_field( 'subtitle' ); ?></h3>
							<?php } ?>
							<?php
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
							<?php

							if ( count( $related ) == 1 ) {
								echo $related[0]->post_excerpt;
							} else {
								the_excerpt();
							}
							?>
                        </div> <!-- .entry-content -->
                    </div>
                    <div class="single-left">
                        <div class="brenta-thumb"
                             style="background-image: url('<?php print $thumb; ?>');"></div>
                    </div>
                    <div class="single-right">
						<?php if ( count( $related ) == 1 ): ?>
                            <div class="iframe">
								<?php
								if ( get_post_type( $related[0]->ID ) == 'poi' ) {
									$indirizzo = get_field( 'n7webmap_coord', $related[0]->ID );
									$terms = get_the_terms($related[0]->ID, 'webmapp_category');
									$icon = get_field( 'wm_taxonomy_icon', 'webmapp_category_' . $terms[0]->term_id );;
									$color = get_field( 'wm_taxonomy_color', 'webmapp_category_' . $terms[0]->term_id );
									if ( ! empty( $indirizzo ) ):?>
                                        <div id="custom-poi-map"
                                             data-icon="<?php echo $icon; ?>"
                                             data-icon-color="<?php echo $color; ?>"
                                             data-lat="<?php echo $indirizzo['lat']; ?>"
                                             data-lng="<?php echo $indirizzo['lng']; ?>"></div>
									<?php endif;
								}
								if ( get_post_type( $related[0]->ID ) == 'track' ) {
									$geojson = get_field( 'n7webmap_geojson', $related[0]->ID );
									if ( ! empty( $geojson ) ):?>
                                        <div id="custom-track-map"
                                             data-geojson='<?php echo json_encode( $geojson ); ?>'></div>
									<?php endif;
								} ?>

                            </div>
						<?php else :
                            foreach($related as $rel){
						        if ( $rel->post_type == 'track' ){
							        $geojson = get_field( 'n7webmap_geojson', $rel->ID );
							        if ( ! empty( $geojson ) ):?>
                                        <div id="custom-track-map"
                                             data-geojson='<?php echo json_encode( $geojson ); ?>'>
	                                        <?php
	                                        if (!empty($pois)):
		                                        foreach( $pois as $poi):
			                                        $indirizzo = get_field('n7webmap_coord', $poi->ID);
			                                        if (!empty($indirizzo)) :
				                                        ?>
                                                        <div id="related_poi_<?php echo $poi->ID; ?>" class="related_poi" data-title="<?php echo $poi->post_title; ?>" data-lat="<?php echo $indirizzo['lat']; ?>" data-lng="<?php echo $indirizzo['lng'];?>"></div>
			                                        <?php endif;
		                                        endforeach;
	                                        endif;
	                                        ?>
                                        </div>
							        <?php endif;
                                break;
                                }
                            }
						endif; ?>
                    </div>
                    <div class="brenta-content">
                        <div class="container">
							<?php
							if ( count( $related ) == 1 ) :
                                setup_postdata($related[0]);
								echo '<div class="text" style="margin-top: 40px">' . get_the_content() . '</div>';
								wp_reset_postdata();
							else : ?>
                                <div class="single-left text">
									<?php the_content(); ?>
                                </div>
                                <div class="single-right">
									<?php
									if ( $routes ):?>
                                        <h4>ITINERARI</h4>
                                        <ul>
											<?php foreach ( $routes as $route ): // variable must be called $post (IMPORTANT) ?>
												<?php
												$post = $route;
												setup_postdata( $post ); ?>

                                                <li>
                                                    <div class="cont-track">
                                                        <div
                                                            class="thumb-track">
															<?php if ( has_post_thumbnail() ) {
																the_post_thumbnail( 'thumbnail' );
															} ?>
                                                        </div>
                                                        <div class="exe-track">
                                                            <h4>
                                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                            </h4>
                                                            <span><?php the_excerpt(); ?></span>
                                                        </div>
                                                    </div>
                                                </li>
											<?php endforeach; ?>
                                        </ul>

										<?php
										wp_reset_postdata();
									endif;
									?>
									<?php
									if ( $tracks ): ?>
                                        <h4>PERCORSI</h4>
                                        <ul>
											<?php foreach ( $tracks as $track ): // variable must be called $post (IMPORTANT) ?>
												<?php
												$post = $track;
												setup_postdata( $post ); ?>

                                                <li>
                                                    <div class="cont-track">
                                                        <div
                                                            class="thumb-track">
															<?php if ( has_post_thumbnail() ) {
																the_post_thumbnail( 'thumbnail' );
															} ?>
                                                        </div>
                                                        <div class="exe-track">
                                                            <h4>
                                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                            </h4>
                                                            <span><?php the_excerpt(); ?></span>
                                                        </div>
                                                    </div>
                                                </li>
											<?php endforeach; ?>
                                        </ul>

										<?php
										wp_reset_postdata();
									endif;
									?>
									<?php
									if ( $pois ): ?>
                                        <h4>PUNTI DI INTERESSE</h4>
                                        <ul>
											<?php foreach ( $pois as $poi ): // variable must be called $post (IMPORTANT) ?>
												<?php

												$post = $poi;
												setup_postdata( $post ); ?>

                                                <li>
                                                    <div class="cont-track">
                                                        <div
                                                            class="thumb-track">
															<?php if ( has_post_thumbnail() ) {
																the_post_thumbnail( 'thumbnail' );
															} ?>
                                                        </div>
                                                        <div class="exe-track">
                                                            <h4>
                                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                            </h4>
                                                            <span><?php the_excerpt(); ?></span>
                                                        </div>
                                                    </div>
                                                </li>
											<?php endforeach; ?>
                                        </ul>

										<?php
										wp_reset_postdata();
									endif;
									?>
                                </div>
							<?php endif; ?>
                        </div>
                    </div>
					<?php
					if ( count( $related ) == 1 ) {
						$images = get_field( 'n7webmap_track_media_gallery', $related[0]->ID );
					} else {
						$images = get_field( 'media_gallery' );
					}
					if ( $images ): ?>
                        <div class="container photogallery">
                            <div
                                class="et_pb_gallery_items et_post_gallery">
								<?php foreach ( $images as $image ): ?>
                                    <div
                                        class="et_pb_gallery_item et_pb_grid_item et_pb_bg_layout_light">
                                        <div class="et_pb_gallery_image">
                                            <a href="<?php echo $image['url']; ?>"
                                               class="">
                                                <img
                                                    src="<?php echo $image['sizes']['photogallery']; ?>"
                                                    alt="<?php echo $image['alt']; ?>"/>
                                            </a>
                                            <p><?php echo $image['caption']; ?></p>
                                        </div>
                                    </div>
								<?php endforeach; ?>
                            </div>
                        </div>
					<?php endif;
					?>
                </article> <!-- .et_pb_post -->

			<?php endwhile; ?>


			<?php //get_sidebar(); ?>
        </div> <!-- #content-area -->
    </div> <!-- #main-content -->

<?php get_footer(); ?>