<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Showcase
 */

get_header();

?>
<?php $obj_id = get_queried_object_id();?>
	<main id="primary" class="site-main">

			<header class="page-header">
				<?php
				the_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				
				?>
			</header><!-- .page-header -->
			<?php var_dump(get_field('profession', 'user_' . $obj_id)); ?>

					<?php if (get_field('picture', 'user_' . $obj_id)):?>
					<div class="contributor_photo">
						<img src="<?php echo get_field('picture', 'user_' . $obj_id); ?>">
					</div>
					<?php endif; ?>
	</main><!-- #main -->

<?php
get_footer();
