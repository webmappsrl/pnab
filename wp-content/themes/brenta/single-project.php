<?php
get_header();
global $post;
?>
    <div id="main-content">

        <div id="content-area" class="clearfix">
			<?php while ( have_posts() ) : the_post(); ?>
                <article
                    id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post' . $additional_class ); ?>>
                    <div class="container">
                      <?php
                      if (function_exists('yoast_breadcrumb')) {
                        yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
                      }
                      ?>
                        <div class="et_post_meta_wrapper">
                            <h1 class="entry-title"><?php the_title(); ?></h1>
                            <div class="categories facetwp-facet facetwp-facet-activity facetwp-type-radio">
                                <?php
                                $args = array();
                                $activities =  wp_get_post_terms(  get_the_ID(),'activity', $args);
                                $seasons =  wp_get_post_terms(  get_the_ID(),'season', $args);
                                $categories =  wp_get_post_terms(  get_the_ID(),'project_category', $args);

                                foreach($activities as $activity){
                                    echo '<div class="facetwp-radio checked" data-value="'. $activity->name .'">'. $activity->name .'</div>';
                                }
                                foreach($seasons as $season){
                                    echo '<div class="facetwp-radio checked" data-value="'. $season->name .'">'. $season->name .'</div>';
                                }
                                foreach($categories as $category){
                                    echo '<div class="facetwp-radio checked" data-value="'. $category->name .'">'. $category->name .'</div>';
                                }
                                ?>
                            </div>
							<?php
							$thumb     = '';
							$width     = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );
							$height    = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
							$classtext = 'et_featured_image';
							$titletext = get_the_title();
							$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, FALSE, 'Blogimage' );
							$thumb     = $thumbnail["thumb"];
                            $routes = get_field('related_route');
                            if (empty($routes)){
                                $routes = array();
                            }
                            $tracks = get_field('related_tracks');
                            if (empty($tracks)){
                                $tracks = array();
                            }
                            $pois = get_field('related_poi');
                            if (empty($pois)){
                                $pois = array();
                            }
							?>

                        </div> <!-- .et_post_meta_wrapper -->
                        <div class="entry-content green">
							<?php
                            $related = array_merge_recursive( $routes, $tracks, $pois );
                            if ( count($related) == 1 ){

                            } else {
                              the_excerpt();
                            }
                            ?>
                        </div> <!-- .entry-content -->
                    </div>
                    <div class="single-left">
                        <div class="brenta-thumb" style="background-image: url('<?php print $thumb; ?>');"></div>
                    </div>
                    <div class="single-right">
                        <div class="mappa" style="background: url('/wp-content/themes/brenta/img/mappa.jpg')">
                        </div>
                    </div>
                    <div class="brenta-content">
                        <div class="container">
                          <?php
                          if ( count($related) == 1 ) :
                            echo '<div class="text" style="margin-top: 40px">'.$related[0]->post_content.'</div>';
                          else : ?>
                            <div class="single-left text">
				               <?php the_content(); ?>
                            </div>
                            <div class="single-right">
                              <?php
                              if ( $routes ):?>
                                <h4>ITINERARI</h4>
                                  <ul>
                                    <?php foreach( $routes as $route ): // variable must be called $post (IMPORTANT) ?>
                                      <?php
                                      $post = $route;
                                      setup_postdata($post); ?>

                                        <li>
                                            <div class="cont-track">
                                                <div class="thumb-track">
                                                  <?php if ( has_post_thumbnail() ) {
                                                    the_post_thumbnail('thumbnail');
                                                  } ?>
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
                              <?php
                              if ( $tracks ): ?>
                                <h4>PERCORSI</h4>
                                  <ul>
                                    <?php foreach( $tracks as $track): // variable must be called $post (IMPORTANT) ?>
                                      <?php
                                      $post = $track;
                                      setup_postdata($post); ?>

                                        <li>
                                            <div class="cont-track">
                                                <div class="thumb-track">
                                                <?php if ( has_post_thumbnail() ) {
                                                  the_post_thumbnail('thumbnail');
                                                } ?>
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
                              <?php
                              if ( $pois ): ?>
                                <h4>PUNTI DI INTERESSE</h4>
                                  <ul>
                                    <?php foreach( $pois as $poi): // variable must be called $post (IMPORTANT) ?>
                                      <?php

                                      $post = $poi;
                                      setup_postdata($post); ?>

                                        <li>
                                            <div class="cont-track">
                                                <div class="thumb-track">
                                                  <?php if ( has_post_thumbnail() ) {
                                                    the_post_thumbnail('thumbnail');
                                                  } ?>
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
                          <?php endif; ?>
                        </div>
                    </div>
                </article> <!-- .et_pb_post -->

			<?php endwhile; ?>


			<?php //get_sidebar(); ?>
        </div> <!-- #content-area -->
    </div> <!-- #main-content -->

<?php get_footer(); ?>