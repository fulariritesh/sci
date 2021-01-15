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
<section class="container-fluid py-5">
    <div class="container newjoinees text-center">
        <h4>Our Newest Members Have This To Say</h4>
        <h1>Members Speak</h1>
        <div id="testimonials_carousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <?php foreach ($testimonials_count as $key => $value) : ?>
                    <li data-target="#testimonials_carousel" data-slide-to="<?php echo $key; ?>" <?php echo $key == 0 ? "class='active'"  : ""; ?>></li>
                <?php endforeach; ?>
            </ol>
            <?php if (have_rows('testimonials')): ?>    
                <div class="row">
                    <div class="carousel-inner">
                        <?php while (have_rows('testimonials')): the_row(); ?>
                            <div class="testimonial carousel-item <?php echo get_row_index() == 1 ? 'active' : ''; ?>">
                                <div class="col-sm-12 newjoineescard shadow-lg">
                                    <div class="row">
                                        <div class="col-3 imgdiv">
                                            <img src="<?php echo get_the_post_thumbnail_url(get_sub_field('testimonial')->ID); ?>" />
                                        </div>
                                        <div class="col-9 text-center p-3 pt-5">
                                            <div class="secondaryCircle">
                                                <i class="fa fa-quote-left" aria-hidden="true"></i>
                                            </div>
                                            <p><?php echo get_sub_field('testimonial')->post_content; ?></p>
                                            <p class="text-secondary"><?php echo get_sub_field('testimonial')->post_title; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            <?php else: ?>
                <h2>Add testimonials here</h2>
            <?php endif;?>
        </div>
    </div>
</section>