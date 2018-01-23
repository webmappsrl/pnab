<?php
/*
Template Name: Registration
*/

acf_form_head();

get_header();
?>

    <div id="main-content">
        <div class="container">
            <div id="content-area" class="clearfix">
                <?php the_content(); ?>
				<?php

				acf_form( [
					'post_id'      => 'new_post',
					'new_post'		=> array(
						'post_type'		=> 'imprese',
						'post_status'	=> 'pending'
					),
                    'field_groups' => array(
                        'group_5a5882d72ed62',
                        'group_5a5883220de1f',
                        'group_5a5885a30da4e',
                        'group_5a58976a176db',
                        'group_categorie_specializzate',
                        'group_5a5890680290a',

                    ),
                    'post_content' => false,
                    'post_title' => false,
					'updated_message' => 'Dati impresa inviati',
					'submit_value'	=> 'Invia'
				] );

				?>
            </div>
        </div>
    </div>

<?php get_footer(); ?>