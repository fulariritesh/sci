<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Showcase
 */

get_header();
?>

	<main id="primary" class="site-main">

		<section class="error-404 not-found">
			<header class="page-header">
				<h1 class="page-title text-center py-5 px-2"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'showcase' ); ?></h1>
			</header><!-- .page-header -->

			<div class="page-content four-o-four">
				<h1 class="text-center mb-5">404</h1>
				<div class="text-center mb-5">
				<a class="btn btn-outline-primary btn-lg btn-xs text-center" href="<?php echo get_site_url(); ?>">Go to Homepage</a>
				</div>
			</div><!-- .page-content -->
		</section><!-- .error-404 -->

	</main><!-- #main -->

<?php
get_footer();
