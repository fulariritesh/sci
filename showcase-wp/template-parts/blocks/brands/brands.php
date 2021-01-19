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
$brands_count = get_fields()["brand_images"];
?>
<script type="text/javascript">
const brands_images = <?php echo count($brands_count); ?>;
</script>
<?php if (have_rows('brand_images')): ?>    
<section class="gfb container-fluid text-center">
    <h4>Brands that trust us</h4>
    <div class="splide slider_brands container">
        <div class="splide__track">
            <ul class="splide__list">
                <?php while (have_rows('brand_images')): the_row(); ?>
                <li class="splide__slide">
                    <img class="img-fluid" src="<?php echo get_sub_field('image'); ?>" alt="">
                </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </div>
</section>
<?php else: ?>
    <h2>Add brands here</h2>
<?php endif;?>