<?php
/*
Template Name: Impresa
*/

acf_form_head();

get_header();
?>

    <div id="main-content">
        <div class="container">
            <div id="content-area" class="clearfix">
		        <?php

		        if ( ! empty( $_COOKIE['brenta_user'] ) && ! empty( $_COOKIE['brenta_password'] ) ) {
			        $args = [
				        'numberposts'	=> 1,
                        'post_status' => array('pending', 'publish'),
				        'post_type'		=> 'imprese',
				        'meta_query'     => [
					        'relation' => 'AND',
					        [
						        'key'     => 'username',
						        'value'   =>  $_COOKIE['brenta_user'],
						        'compare' => '=',
					        ],
					        [
						        'key'     => 'password',
						        'value'   => $_COOKIE['brenta_password'],
						        'compare' => '=',
					        ],
				        ],
			        ];
			        $the_query = new WP_Query( $args );

			        if ( $the_query->have_posts() ) {

				        while ( $the_query->have_posts() ) {
					        $the_query->the_post();

					        acf_form( [
						        'post_id'         => get_the_ID(),
						        'new_post'        => [
							        'post_type'   => 'imprese',
							        'post_status' => 'pending',
						        ],
						        'field_groups'    => [
							        'group_5a5882d72ed62',
							        'group_5a5883220de1f',
							        'group_5a5885a30da4e',
							        'group_5a58976a176db',
							        'group_categorie_specializzate',
							        'group_5a5890680290a',

						        ],
						        'post_content'    => FALSE,
						        'post_title'      => FALSE,
						        'updated_message' => 'Modifiche inviate',
						        'submit_value'    => 'Modifica',
					        ] );

				        }
				        /* Restore original Post Data */
				        wp_reset_postdata();
			        } else {
				        echo '<p>nessuna impresa trovata</p>';
			        }

		        } else { ?>
			        <?php the_content(); ?>

                    <form id="brenta_login" action="#" method="post" name="brenta_login">
                        <input id="user" type="text" placeholder="username" name="user"/>
                        <input id="password" placeholder="password" type="password" name="password"/>
                        <input id="login" type="submit" value="Login">
                    </form>
                    <img id="brenta_loader" src="<?php echo get_stylesheet_directory_uri(); ?>/img/loader.gif">
		        <?php }
		        ?>

            </div>
        </div>
    </div>

<?php get_footer(); ?>