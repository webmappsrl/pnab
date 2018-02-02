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
					$args      = [
						'numberposts' => 1,
						'post_status' => [ 'pending', 'publish' ],
						'post_type'   => 'imprese',
						'meta_query'  => [
							'relation' => 'AND',
							[
								'key'     => 'username',
								'value'   => $_COOKIE['brenta_user'],
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

                            $impresa = get_field('impresa');
							$file_url = get_home_url().'/wp-content/uploads/pdf-imprese/'.get_the_ID().'_'.$impresa.'.pdf';
							?>

                            <p><h4>Scarica il documento: <a href="<?php echo $file_url; ?>" title="<?php echo $impresa; ?>"><?php echo $impresa.'.pdf'; ?></a></h4></p>
                            <form id="post" class="acf-form" action=""
                                  method="post">
                            <input id="impresa-update" type="hidden" name="impresa-update" value="update">
                            <div id="field-group-0">
                                <h4>Carica documento firmato</h4>
								<?php
								acf_form( [
									'post_id'         => get_the_ID(),
									'new_post'        => [
										'post_type'   => 'imprese',
										'post_status' => 'pending',
									],
									'field_groups'    => [
										'group_5a69f69ab22b8',
									],
									'post_content'    => FALSE,
									'post_title'      => FALSE,
									'updated_message' => 'Dati impresa inviati',
									'form'            => FALSE,
								] );
								?>
                            </div>
                            <div id="field-group-1">
                                Se modifichi i dati qui sotto ricordati di scaricare di nuovo il pdf e ricaricarlo firmato.
                                <h4>Dati del Legale rappresentante
                                    dell'impresa:</h4>
								<?php

								acf_form( [
									'post_id'         => get_the_ID(),
									'new_post'        => [
										'post_type'   => 'imprese',
										'post_status' => 'pending',
									],
									'field_groups'    => [
										'group_5a5882d72ed62',
									],
									'post_content'    => FALSE,
									'post_title'      => FALSE,
									'updated_message' => 'Dati impresa inviati',
									'form'            => FALSE,
								] );
								?>

                            </div>
                            <div id="field-group-2">
                                <h4>Dati dell'impresa:</h4>
								<?php

								acf_form( [
									'post_id'         => get_the_ID(),
									'new_post'        => [
										'post_type'   => 'imprese',
										'post_status' => 'pending',
									],
									'field_groups'    => [
										'group_5a5883220de1f',
									],
									'post_content'    => FALSE,
									'post_title'      => FALSE,
									'updated_message' => 'Dati impresa inviati',
									'form'            => FALSE,
								] );
								?>
                            </div>
                            <div id="field-group-3">
                                <h4>Dichiarazioni rese ai sensi del DPR
                                    445/2000</h4>
                                <h6>Numero dipendenti. I consorzi di cui
                                    all'art. 36, comma 1,
                                    lettere b) e c), della L.P. 26/93 possono
                                    indicare il numero
                                    dei dipendenti delle imprese consorziate, ai
                                    sensi di quanto
                                    disposto dell'art. 35 del D.Lgs
                                    163/2006</h6>
								<?php

								acf_form( [
									'post_id'         => get_the_ID(),
									'new_post'        => [
										'post_type'   => 'imprese',
										'post_status' => 'pending',
									],
									'field_groups'    => [
										'group_5a5885a30da4e',
									],
									'post_content'    => FALSE,
									'post_title'      => FALSE,
									'updated_message' => 'Dati impresa inviati',
									'form'            => FALSE,
								] );
								?>
                            </div>
                            <div id="field-group-3">
                                <h4>Attesto il possesso dei requisiti di
                                    capacità
                                    tecnico-economica nelle seguenti
                                    categorie/classifiche
                                    *</h4>
                                <h4>CATEGORIE GENERALI</h4>
								<?php
								acf_form( [
									'post_id'         => get_the_ID(),
									'new_post'        => [
										'post_type'   => 'imprese',
										'post_status' => 'pending',
									],
									'field_groups'    => [
										'group_5a58976a176db',
									],
									'post_content'    => FALSE,
									'post_title'      => FALSE,
									'updated_message' => 'Dati impresa inviati',
									'form'            => FALSE,
								] );
								?>
                            </div>
                            <div id="field-group-4">
                                <h4>CATEGORIE SPECIALIZZATE</h4>
								<?php
								acf_form( [
									'post_id'         => get_the_ID(),
									'new_post'        => [
										'post_type'   => 'imprese',
										'post_status' => 'pending',
									],
									'field_groups'    => [
										'group_categorie_specializzate',
									],
									'post_content'    => FALSE,
									'post_title'      => FALSE,
									'updated_message' => 'Dati impresa inviati',
									'form'            => FALSE,
								] );
								?>
                            </div>
                            <div id="field-group-5">
                                <h4>Credenziali</h4>
								<?php
								acf_form( [
									'post_id'         => get_the_ID(),
									'new_post'        => [
										'post_type'   => 'imprese',
										'post_status' => 'pending',
									],
									'field_groups'    => [
										'group_5a5890680290a',
									],
									'post_content'    => FALSE,
									'post_title'      => FALSE,
									'updated_message' => 'Dati impresa inviati',
									'form'            => FALSE,
								] );
								?>
                            </div>
                            <div class="acf-form-submit">

                                <input type="submit"
                                       class="acf-button button button-primary button-large"
                                       value="Invia">
                                <span class="acf-spinner"></span>

                            </div>
                            </form><?php
							/* Restore original Post Data */
							wp_reset_postdata();
						}
					} else {
						echo '<p>nessuna impresa trovata</p>';
					}

				} else { ?>
					<?php the_content(); ?>

                    <form id="brenta_login" action="#" method="post"
                          name="brenta_login">
                        <input id="user" type="text" placeholder="username"
                               name="user"/>
                        <input id="password" placeholder="password"
                               type="password"
                               name="password"/>
                        <input id="login" type="submit" value="Login">
                    </form>
                    <img id="brenta_loader"
                         src="<?php echo get_stylesheet_directory_uri(); ?>/img/loader.gif">
				<?php }
				?>

            </div>
        </div>
    </div>

<?php get_footer(); ?>