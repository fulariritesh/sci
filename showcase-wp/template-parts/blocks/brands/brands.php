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
<div class="brands">
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
<style type="text/css">
        .carousel-inner {
            display: flex;
            justify-content: center;
        }
        .carousel-inner .brands {
            max-width: 250px;
            margin-left: 20px;
            margin-right: 20px;
        }
</style>
    <div id="brands_carousel" class="slide brands_carousel col-sm-12">

        <div class="carousel-inner">
            <?php while (have_rows('brand_images')): the_row(); ?>
                <div class="brands <?php echo get_row_index() == 1 ? 'active' : ''; ?>">
                    <div class="d-block w-100">
                        <div class="image">
                            <img src="<?php echo get_sub_field('image'); ?>">
                        </div>
                    </div>
                </div>  
            <?php endwhile; ?>
        </div>
          <a class="carousel-control-prev" href="#brands_carousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#brands_carousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
    </div>
</div> 
<?php else: ?>
    <h2>Add brands here</h2>
<?php endif;?>