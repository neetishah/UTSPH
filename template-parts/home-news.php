<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package uthsp
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
		endif;

		if ( 'news' === get_post_type() ) :
			?>
			<div class="entry-meta">
				<?php
				uthsp_posted_on();
				// uthsp_posted_by();
				$categories = get_the_terms( strval(get_the_ID()), "news-type");
				if (!empty($categories)){
					Print "<br><strong>Type: </strong> ";
					foreach ($categories as $i => $cat) {
						if ($i > 0)
							echo ", ";
						echo $cat->name;
					}
				}
				Print "<div><br><hr><br></div>"	
				?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php uthsp_post_thumbnail(); ?>

	<footer class="entry-footer">
		<?php uthsp_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
