<?php
/**
 * Template Name: Press
 *
 * Renders press clippings from stuff/press.json.
 * Create a page with the slug "press" and choose the "Press" template.
 *
 * @package WordPress
 */
get_header();

$clippings = json_decode( file_get_contents( get_stylesheet_directory() . '/stuff/press.json' ), true );
if ( ! is_array( $clippings ) ) $clippings = array();
usort( $clippings, function( $a, $b ) {
    return strcmp( isset($b['date']) ? $b['date'] : '', isset($a['date']) ? $a['date'] : '' );
} );
?>
	<div id="content" class="not_front press" >
		<div class="inner">
			<h1>Press</h1>
			<p class="press-intro">Nice things people have said and written.</p>

			<?php foreach ( $clippings as $clip ) :
				$title  = isset( $clip['title'] ) ? $clip['title'] : 'Untitled';
				$outlet = isset( $clip['outlet'] ) ? $clip['outlet'] : '';
				$url    = isset( $clip['url'] ) ? $clip['url'] : '';
				$date   = isset( $clip['date'] ) ? $clip['date'] : '';
				$quote  = isset( $clip['quote'] ) ? $clip['quote'] : '';
				$nice_date = $date ? date( 'F j, Y', strtotime( $date ) ) : '';
			?>
			<div class="press-item">
				<h2><a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $title ); ?></a></h2>
				<p class="press-outlet">
					<?php if ( $outlet ) : ?><span class="press-outlet-name"><?php echo esc_html( $outlet ); ?></span><?php endif; ?>
					<?php if ( $outlet && $nice_date ) : ?> &middot; <?php endif; ?>
					<?php if ( $nice_date ) echo esc_html( $nice_date ); ?>
				</p>
				<?php if ( $quote ) : ?><p class="press-quote">&ldquo;<?php echo esc_html( $quote ); ?>&rdquo;</p><?php endif; ?>
			</div>
			<?php endforeach; ?>
		</div>
	</div><!-- #content -->

<?php get_footer(); ?>
