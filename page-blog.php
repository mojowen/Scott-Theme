<?php
/**
 * Template Name: Blog
 *
 * Lists recent posts. Create a page with the slug "blog"
 * and choose the "Blog" template. Single posts render via index.php.
 *
 * @package WordPress
 */
get_header();

$blog_query = new WP_Query( array(
    'post_type'           => 'post',
    'post_status'         => 'publish',
    'posts_per_page'      => 10,
    'paged'               => max( 1, get_query_var( 'paged' ) ),
    'ignore_sticky_posts' => true,
) );
?>
	<div id="content" class="not_front blog" >
		<div class="inner">
			<h1>Writing</h1>

			<?php if ( $blog_query->have_posts() ) : ?>

				<?php while ( $blog_query->have_posts() ) : $blog_query->the_post(); ?>
					<article class="blog-post">
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<div class="blog-meta"><?php echo get_the_date(); ?></div>
						<div class="blog-excerpt"><?php the_excerpt(); ?></div>
					</article>
				<?php endwhile; ?>

				<?php if ( $blog_query->max_num_pages > 1 ) : ?>
				<div class="blog-nav">
					<?php if ( get_next_posts_link( '', $blog_query->max_num_pages ) ) : ?>
						<?php next_posts_link( '&larr; Older', $blog_query->max_num_pages ); ?>
					<?php endif; ?>
					<?php if ( get_previous_posts_link() ) : ?>
						<?php previous_posts_link( 'Newer &rarr;' ); ?>
					<?php endif; ?>
				</div>
				<?php endif; ?>

				<?php wp_reset_postdata(); ?>

			<?php else : ?>
				<div class="blog-post">
					<div class="blog-excerpt">Nothing here yet.</div>
				</div>
			<?php endif; ?>
		</div>
	</div><!-- #content -->

<?php get_footer(); ?>
