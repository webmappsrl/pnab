
						
						
						
						<h2 id="pages">Pagine</h2>
						
						
						<ul>
						<?php // Add pages you'd like to exclude in the exclude here 
						wp_list_pages( array( 'exclude' => '35511,36448,36449,36450,36452,36453,36458,36459,36456,36457,36455,36368,36391,36362,36942,35087',
						'title_li'    => '',
						'show_date'   => 'published',
        				'date_format' => $date_format
						  )
						);
						// $args = array(
						// 	'post_type' => 'page',
						// 	'fields' => 'ids',
						// 	'posts_per_page' => -1,
						//   );
						//   $qry = new WP_Query($args);
						//   var_dump($qry->posts);

						//   $pages = get_post(1214);
						//   var_dump ($pages->post_title);
						  
						//   $page_ids= get_all_page_ids();
						//   echo '<h3>My Page List :</h3>';
						// 	 foreach($page_ids as $id)
						// 	  {
						// 		  echo '<br />'.get_the_title($id).' ' .$id;
						// 	  }
						?>
						</ul>
						
						
						
						<!-- <h2 id="posts">Posts</h2> -->
						
						
						<ul>
						<?php
						// Add categories you'd like to exclude in the exclude here
						// $cats = get_categories('exclude=');
						// foreach ($cats as $cat) {
						//   echo "
						// <li>
						// <h3>".$cat->cat_name."</h3>
						
						// ";
						//   echo "
						// <ul>";
						//   query_posts('posts_per_page=-1&amp;cat='.$cat->cat_ID);
						//   while(have_posts()) {
						// 	the_post();
						// 	$category = get_the_category();
						// 	// Only display a post link once, even if it's in multiple categories
						// 	if ($category[0]->cat_ID == $cat->cat_ID) {
						// 	  echo '
						// <li><a href="'.get_permalink().'">'.get_the_title().'</a></li>
						
						// ';
						// 	}
						//   }
						//   echo "</ul>
						
						// ";
						//   echo "</li>
						
						// ";
						// }
						?>
						</ul>