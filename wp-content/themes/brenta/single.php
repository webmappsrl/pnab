<?php

get_header();

$show_default_title = get_post_meta(get_the_ID(), '_et_pb_show_title', TRUE);

$is_page_builder_used = et_pb_is_pagebuilder_used(get_the_ID());

?>

    <div id="main-content">

        <div id="content-area" class="clearfix">

          <?php while (have_posts()) : the_post(); ?>
            <?php if (et_get_option('divi_integration_single_top') <> '' && et_get_option('divi_integrate_singletop_enable') == 'on') {
              echo(et_get_option('divi_integration_single_top'));
            } ?>

            <?php
            $et_pb_has_comments_module = has_shortcode(get_the_content(), 'et_pb_comments');
            $additional_class          = $et_pb_has_comments_module ? ' et_pb_no_comments_section' : '';
            ?>

              <article
                  id="post-<?php the_ID(); ?>" <?php post_class('et_pb_post' . $additional_class); ?>>
                  <div class="container">
                    <?php
                    if (function_exists('yoast_breadcrumb')) {
                      yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
                    }
                    ?>
                      <div class="et_post_meta_wrapper">
                          <div class="single-left text">
                            <h1 class="entry-title"><?php the_title(); ?> </h1>
                          </div>
                          <div class="single-right">
                              <span class="entry-date"><?php echo get_the_date('d.m.Y'); ?></span>
                          </div>
                          <?php if(get_field('subtitle')) { ?>
                            <h3 class="subtitle"><?php the_field('subtitle'); ?></h3>
                          <?php }?>
                      </div>
                  </div>
                <?php
                $thumb     = '';
                $width     = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );
                $height    = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
                $classtext = 'et_featured_image';
                $titletext = get_the_title();
                $thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, FALSE, 'Blogimage' );
                $thumb     = $thumbnail["thumb"];
                ?>
                  <div class="brenta-thumb" style="background-image: url('<?php print $thumb; ?>');"></div>
                  <div class="container the_content">
                      <div class="single-left text">
                        <?php
                        do_action('et_before_content');

                        the_content();

                        wp_link_pages([
                          'before' => '<div class="page-links">' . esc_html__('Pages:', 'Divi'),
                          'after'  => '</div>',
                        ]);
                        ?>
                      </div>
                      <div class="et_post_meta_wrapper">
                        <?php if (et_get_option('divi_integration_single_bottom') <> '' && et_get_option('divi_integrate_singlebottom_enable') == 'on') {
                          echo(et_get_option('divi_integration_single_bottom'));
                        } ?>
                      </div> <!-- .et_post_meta_wrapper -->
                  </div>
                <?php  $images = get_field('media_gallery');
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


        </div> <!-- #content-area -->

    </div> <!-- #main-content -->

<?php get_footer(); ?>