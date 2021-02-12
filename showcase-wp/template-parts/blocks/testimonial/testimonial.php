<?php

/**
 * Testimonial Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */
?>
<?php 
$testimonials_count = get_fields()['testimonials'];
?>
<section class="container-fluid talent-block">
    <div class="container newjoinees text-center">
        <h4>Our Newest Members Have This To Say</h4>
        <h1>Members Speak</h1>
		<div class="splide slider_testimonials">
			<div class="splide__track">
				<ul class="splide__list">
		            <?php if (have_rows('testimonials')): ?>    
						<?php while (have_rows('testimonials')): the_row(); ?>
							<li class="splide__slide">
						        <div class="col-sm-12 newjoineescard">
						            <div class="row box-shadow">
						                <div class="col-4 imgdiv">
						                    <img class="img-fluid" src="<?php echo get_the_post_thumbnail_url(get_sub_field('testimonial')->ID); ?>" loading="lazy" />
						                </div>
						                <div class="col-8 text-center p-3 pt-5">
						                    <div class="secondaryCircle">
						                        <i class="fa fa-quote-left" aria-hidden="true"></i>
						                    </div>
						                    <p><?php echo wp_trim_words( get_sub_field('testimonial')->post_content, 22, "..." ); ?></p>
						                    <p class="text-secondary"><?php echo get_sub_field('testimonial')->post_title; ?></p>
						                </div>
						            </div>
						        </div>
							</li>
						<?php endwhile; ?>
		            <?php endif; ?>

				</ul>
			</div>
		</div>
    </div>
</section>