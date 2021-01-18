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
<?php if (have_rows('brand_images')): ?>    
<div class="brands-container">
<?php if (is_admin()) : ?>
    <style type="text/css">
        .carousel-inner {
            display: flex;
        }
        #brands_carousel img {
            max-width: 150px;
            display: inline-block;
            margin-right: 10px;
        }
        [href="#brands_carousel"]{
            display: none;
        }
    </style>
<?php endif;?>
<?php while (have_rows('brand_images')): the_row(); ?>
    <div class="brands <?php #echo get_row_index() == 1 ? 'active' : ''; ?>">
        <div class="d-block w-100">
            <div class="image text-center">
                <img src="<?php echo get_sub_field('image'); ?>">
            </div>
        </div>
    </div>  
<?php endwhile; ?>
</div> 
<?php else: ?>
    <h2>Add brands here</h2>
<?php endif;?>