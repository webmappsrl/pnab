<?php
get_header();
?>
    <div id="main-content">

        <div id="content-area" class="clearfix">
			<?php while ( have_posts() ) : the_post(); ?>
                <article
                    id="post-<?php get_the_ID(); ?>" <?php post_class( 'et_pb_post' . $additional_class ); ?>>
                    <div class="container">
                      <?php
                      if (function_exists('yoast_breadcrumb')) {
                        yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
                      }
                      ?>
                        <div class="et_post_meta_wrapper">
                            <h1 class="entry-title"><?php the_title(); ?></h1>
							<?php
                            $pois      = get_field('n7webmap_related_poi');
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
                    <div class="single-left">
                        <div class="brenta-thumb" style="background-image: url('<?php print $thumb; ?>');"></div>
                    </div>
                    <div class="single-right">
                        <div class="iframe">
		                    <?php $geojson = get_field('n7webmap_geojson');
		                    if(!empty($geojson)):?>
                                <div id="custom-track-map" data-geojson='<?php echo json_encode($geojson); ?>'>
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
		                    <?php endif; ?>
                        </div>
                        <!-- <div class="mappa" style="background: url('/wp-content/themes/brenta/img/mappa.jpg')"> -->
                        </div>
                    </div>
                    <div class="brenta-content back-green">
                        <div class="container">
                            <div class="single-left text">
				                <?php the_content(); ?>
                            </div>
                            <div class="single-right">
                              <?php
                              if ( $pois ): ?>
                                  <ul>
                                    <?php foreach( $pois as $poi): // variable must be called $post (IMPORTANT) ?>
                                      <?php
                                      global $post;
                                      $post = $poi;
                                      setup_postdata($post); ?>
                                        <li>
                                            <div class="cont-track">
                                                <div class="thumb-track">
                                                <?php if ( has_post_thumbnail() ) {
                                                  the_post_thumbnail('thumbnail');
                                                } else {
	                                                $terms = get_the_terms(get_the_ID(), 'webmapp_category');
                                                    $icon = get_field('wm_taxonomy_icon', $terms[0]->taxonomy . '_' . $terms[0]->term_id);
	                                                echo '<span class="' . $icon .'"></span>';
                                                }?>
                                                </div>
                                                <div class="exe-track">
                                                    <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
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