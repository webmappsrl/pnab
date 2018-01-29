<?php global $post;
if ( $post->post_type == 'poi' ) {
	$terms = get_the_terms( $post->ID, 'webmapp_category' );
}
if ( empty( $terms ) || ! containsTerm( $terms, 'strutture-qp' ) ): ?>
    <div
        class="footer-banner et_pb_section  et_pb_section_4 et_pb_with_background et_section_regular">
        <div
            class=" et_pb_row banner_footer et_pb_row_3 et_pb_row_fullwidth">
            <div
                class="banner et_pb_column et_pb_column_2_3  et_pb_column_3">
                <div
                    class="et_pb_module et-waypoint et_pb_image et_pb_animation_fade_in et_pb_image_0 et_always_center_on_mobile et-animated">
					<?php // WP_Query arguments
					$args = [
						'post_type'      => [ 'poi' ],
						'post_status'    => [ 'publish' ],
						'posts_per_page' => '1',
						'orderby'        => 'rand',
						'tax_query'      => [
							[
								'taxonomy' => 'webmapp_category',
								'field'    => 'slug',
								'terms'    => 'strutture-qp',
							],
						],
					];

					// The Query
					$query = new WP_Query( $args );

					// The Loop
					if ( $query->have_posts() ) {
						while ( $query->have_posts() ) {
							$query->the_post();

							$link = get_field( 'link_banner' );

							if ( get_field( 'immagine_banner' ) ) {
								$image = get_field( 'immagine_banner' );
							} else {
								$image = [
									'url' => '/wp-content/themes/brenta/img/banner.jpg',
									'alt' => '',
								];
							}

							if ( $link ) {
								$link_url    = $link['url'];
								$link_target = $link['target'];
							} else {
								$link_url    = get_the_permalink();
								$link_target = '';
							}
							if ( get_field( 'titolo_banner' ) ) {
								$title = get_field( 'titolo_banner' );
							} else {
								$title = get_the_title();
							}
							if ( get_field( 'sottotitolo_banner' ) ) {
								$subtitle = get_field( 'sottotitolo_banner' );
							} ?>

                            <h1><a href="<?php echo $link_url; ?>"
                                   target="<?php echo $link_target; ?>"><?php echo $title; ?></a>
                            </h1>
							<?php if ( $subtitle ) { ?>
                                <h2><a href="<?php echo $link_url; ?>"
                                       target="<?php echo $link_target; ?>"><?php echo $subtitle; ?></a>
                                </h2>
							<?php } ?>

                            <a href="/marchio-di-qualita/ospitalita-qualita-parco/"
                               class="logo_banner">
                                <img
                                    src="/wp-content/themes/brenta/img/banner-label.png"
                                    alt="logo qualità parco">
                            </a>

                            <a href="<?php echo $link_url; ?>"
                               target="<?php echo $link_target; ?>">
								<?php if ( $image ) { ?>
                                    <img src="<?php echo $image['url']; ?>"
                                         alt="<?php echo $image['alt']; ?>">
								<?php } else { ?>
                                    <img
                                        src="/wp-content/themes/brenta/img/banner.jpg"
                                        alt="">
								<?php } ?>
                            </a>
							<?php
						}
					} else { ?>
                        <a href="/marchio-di-qualita/ospitalita-qualita-parco/"
                           class="logo_banner"><img
                                src="/wp-content/themes/brenta/img/banner-label.png"
                                alt="logo qualità parco"></a>
                        <a href="#banner"><img
                                src="/wp-content/themes/brenta/img/banner.jpg"
                                alt=""></a>
						<?php
					}
					// Restore original Post Data
					wp_reset_postdata(); ?>
                </div>
            </div> <!-- .et_pb_column -->
            <div
                class="newsletter et_pb_column et_pb_column_1_3  et_pb_column_4">
                <div
                    class="et_pb_text et_pb_module et_pb_bg_layout_light et_pb_text_align_left  et_pb_text_1">
                    <h3><i class="fa fa-envelope-open-o"
                           aria-hidden="true"></i>
                        NEWSLETTER</h3>
                    <p><input
                            style="width: 98%; height: 46px; border: none; background: white; font-size: 20px;"
                            type="text"></p>
                    <p><?php echo __( 'Iscriviti per essere sempre aggiornato sulle novità e le
                    iniziative del Parco! Non ti disturberemo con più di una
                    email ogni 2 settimane ?', 'brenta' ); ?></p>

                </div> <!-- .et_pb_text -->
            </div> <!-- .et_pb_column -->

        </div> <!-- .et_pb_row -->

    </div>
	<?php
endif;
if ( 'on' == et_get_option( 'divi_back_to_top', 'false' ) ) : ?>

    <span class="et_pb_scroll_top et-pb-icon"></span>

<?php endif;
?>

<?php
if ( ! is_page_template( 'page-template-blank.php' ) ) : ?>

    <footer id="main-footer">
        <div class="container">
            <img src="/wp-content/themes/brenta/img/logo_footer.png"
                 class="footer_img">

			<?php get_sidebar( 'footer' ); ?>


			<?php if ( has_nav_menu( 'footer-menu' ) ) : ?>

                <div id="et-footer-nav">
                    <div class="">
						<?php
						wp_nav_menu( [
							'theme_location' => 'footer-menu',
							'depth'          => '1',
							'menu_class'     => 'bottom-nav',
							'container'      => '',
							'fallback_cb'    => '',
						] );
						?>
                    </div>
                </div> <!-- #et-footer-nav -->

			<?php endif; ?>
			<?php if ( has_nav_menu( 'footer-menu' ) ) : ?>

                <div id="br-footer-nav">
                    <div class="">
						<?php
						wp_nav_menu( [
							'menu'        => 'footer',
							'depth'       => '1',
							'menu_class'  => 'bottom-nav',
							'container'   => '',
							'fallback_cb' => '',
						] );
						?>
                    </div>
                </div> <!-- #et-footer-nav -->

			<?php endif; ?>


            <div id="footer-bottom">
                <div class="">
					<?php
					if ( FALSE !== et_get_option( 'show_footer_social_icons', TRUE ) ) { ?>
                        <ul class="et-social-icons">
                            <li class="et-social-icon et-social-email">
                                <a href="#" class="">
                                    <i class="fa fa-envelope-open-o"
                                       aria-hidden="true"></i>
                                </a>
                            </li>
							<?php if ( 'on' === et_get_option( 'divi_show_facebook_icon', 'on' ) ) : ?>
                                <li class="et-social-icon et-social-facebook">
                                    <a href="<?php echo esc_url( et_get_option( 'divi_facebook_url', '#' ) ); ?>"
                                       class="">
                                        <i class="fa fa-facebook"
                                           aria-hidden="true"></i>
                                    </a>
                                </li>
							<?php endif; ?>
                            <li class="et-social-icon et-social-instagram">
                                <a href="https://www.instagram.com/parcoadamellobrenta/"
                                   class="">
                                    <i class="fa fa-instagram"
                                       aria-hidden="true"></i>
                                </a>
                            </li>


                        </ul>
					<?php }

					//echo et_get_footer_credits();
					?>
                    <div id="footer-info">
                        <p>email info@pnab.it • P.E.C. info@pec.pnab.it |
                            Sede Amministrativa Via Nazionale, 24 38080
                            Strembo (TN) Tel. 0465 80 66 66 - Fax 0465 80 66
                            99 | P.IVA 01300650221 - C.F. 95006040224.
                        </p>
                        <p>I testi e le foto, dove non specificato, sono del
                            Parco Naturale Adamello Brenta. È vietato
                            qualsiasi uso non autorizzato.
                        </p>
                    </div>
                </div>    <!-- .container -->
            </div>
        </div>
    </footer> <!-- #main-footer -->
    </div> <!-- #et-main-area -->

<?php endif; // ! is_page_template( 'page-template-blank.php' ) ?>

</div> <!-- #page-container -->

<?php wp_footer(); ?>
</body>
</html>