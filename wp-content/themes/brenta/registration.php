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
                <form id="post" class="acf-form" action="" method="post">

                    <div id="field-group-1">
                        <h4>Dati del Legale rappresentante dell'impresa:</h4>
						<?php

						acf_form( [
							'post_id'         => 'new_post',
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
							'post_id'         => 'new_post',
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
                        <h4>Dichiarazioni rese ai sensi del DPR 445/2000</h4>
                        <h6>Numero dipendenti. I consorzi di cui all'art. 36, comma 1, lettere b) e c), della L.P. 26/93 possono indicare il numero dei dipendenti delle imprese consorziate, ai sensi di quanto disposto dell'art. 35 del D.Lgs 163/2006</h6>
						<?php

						acf_form( [
							'post_id'         => 'new_post',
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
                        <h4>Attesto il possesso dei requisiti di capacità tecnico-economica nelle seguenti categorie/classifiche *</h4>
                        <h4>CATEGORIE GENERALI</h4>
						<?php
						acf_form( [
							'post_id'         => 'new_post',
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
							'post_id'         => 'new_post',
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
							'post_id'         => 'new_post',
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
                </form>
            </div>
        </div>
    </div>

<?php get_footer(); ?>