<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package uthsp
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php
		if ( have_posts() ) :

			if ( is_home() && ! is_front_page() ) :
				?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>
				<?php
			endif;

			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
			$args = array(
				'post_type'=>'news',
				'posts_per_page' => 6,
				'paged' => $paged,
				);
				
  			query_posts($args);
			if ( have_posts())
				?><h3 style="text-align:center;"><i>Latest News</i></h3><hr><?php

			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/*
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
				get_template_part( 'template-parts/home', get_post_type() );

			endwhile;

			// start pagination
			if ($total_pages > 1){

				$current_page = max(1, get_query_var('paged'));
		
				echo paginate_links(array(
					'base' => get_pagenum_link(1) . '%_%',
					'format' => '/page/%#%',
					'current' => $current_page,
					'total' => $total_pages,
					'prev_text'    => __('« prev'),
					'next_text'    => __('next »'),
				));
			}   
			// end pagination
			wp_reset_postdata();

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
