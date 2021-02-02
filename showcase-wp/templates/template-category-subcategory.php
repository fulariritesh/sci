<?php
/* Template Name: Category Subcategory Page */
include('page_ids.php');

$profession_error = NULL;
$profession = NULL;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['submit'])){

        if($_POST['submit'] == 'save'){

            if(!empty($_POST['profession'])){
                $profession = $_POST['profession'];

                $cat = get_terms( array(
                    'taxonomy' => 'jobs',
                    'hide_empty' => false,
                ));

                $cat_ids = array();
                foreach( $cat as $c ) {
                    $cat_ids[] = $c->term_id;
                }
    
                if (!array_intersect($profession, $cat_ids) == $profession) {
                    $profession_error = true;
                }
            }else{
                $profession_error = true;
            }   
        }

        if(!( $profession_error )){
            $_SESSION['user_profession'] = $profession;
            wp_redirect( get_page_link( $social_links_page )); exit;
        }
    }
}


get_header();

?>

<section class="cat-subcat container-fluid py-5">
    <form action="" method="POST" class="row">
   
        <div
            class="accordion col-11 col-md-8 col-xl-6 shadow-sm mx-auto"
            id="accordion"
        >
            <h4 class="text-center font-weight-bold py-4">
            Select your main skills and specialised skills 
            </h4>

            <?php
           
                $categories = get_terms( array(
                    'taxonomy' => 'jobs',
                    'hide_empty' => false,
                    'parent' => 0
                ));

                if(!empty($categories)){

                    foreach( $categories as $category ) {

                        //var_dump(in_array($category->term_taxonomy_id,$_SESSION['user_profession']));
                        if(isset($_SESSION['user_profession'])){
                            $user_selected_category = in_array($category->term_taxonomy_id,$_SESSION['user_profession']);
                        }else{
                            $user_selected_category = false;
                        }
                            ?>
   
                            <!-- CATEGORY -->
                            <div class="accordion-group mb-3 card">
                          
                            <!-- collapsed or selected -->
                            <div
                                class="row card-header p-2 <?php echo ($user_selected_category) ? 'selected' : 'collapsed'; ?>"
                                id="heading<?php echo $category->term_taxonomy_id; ?>"
                                type="button"
                                data-toggle="collapse"
                                data-target="#collapse<?php echo $category->term_taxonomy_id; ?>"
                                aria-expanded="true"
                                aria-controls="collapse<?php echo $category->term_taxonomy_id; ?>"
                                >
                                <div class="col-3 pl-md-5">
                                    <svg class="icon">
                                        <use xlink:href="<?php echo wp_get_attachment_url(get_field('category_svg', $category, false)).'#'.$category->slug;  ?>" />
                                    </svg>                               
                                </div>
                                <div class="col-7 col-md-8">
                                    <p class="text-uppercase my-2 pt-1"><?php echo $category->name; ?></p>
                                </div>

                                <!-- disabled or '' -->
                                <input <?php echo ($user_selected_category) ? '' : 'disabled'; ?> type="hidden" name="profession[]" value="<?php echo $category->term_taxonomy_id; ?>">
                            </div>

                                <!-- collapse or collapse show -->
                                <div id="collapse<?php echo $category->term_taxonomy_id; ?>" class="collapse <?php echo ($user_selected_category) ? 'show' : ''; ?>" aria-labelledby="heading<?php echo $category->name; ?>">
                                    <div class="accordion-inner card-body">
                                        <div class="btn-group-toggle" data-toggle="buttons">
                            <?php

                            $subcategories = get_terms( array(
                                'taxonomy' => 'jobs',
                                'hide_empty' => false,
                                'parent' => $category->term_taxonomy_id
                            ));
                            if(!empty($subcategories)){
                                foreach( $subcategories as $subcategory ) {
                                    
                                    //var_dump(in_array($subcategory->term_taxonomy_id,$_SESSION['user_profession']));
                                    if(isset($_SESSION['user_profession'])){
                                        $user_selected_subcategory = in_array($subcategory->term_taxonomy_id,$_SESSION['user_profession']);
                                    }else{
                                        $user_selected_subcategory = false;
                                    }
                                    ?>
                                    <!-- SUB CATEGORY -->
                                    <label class="btn btn-details-cat-subcat mb-1 <?php echo ($user_selected_subcategory) ? 'active' : ''; ?>">
                                        <input <?php echo ($user_selected_subcategory) ? 'checked' : ''; ?> type="checkbox" value="<?php echo $subcategory->term_taxonomy_id; ?>" name="profession[]"  /> <?php echo $subcategory->name; ?>
                                    </label>

                                    <?php
                                }
                            }

                            ?>
                            <!-- CATEGORY CLOSING-->
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <?php
                        
                    }
                }
            ?>

            <?php if($profession_error){ echo '<div class="alert alert-danger" role="alert">Please select a category!</div>'; } ?>

            <button 
            type="submit" 
            name="submit" 
            value="save" 
            class="btn btn-block btn-details-nxt py-3 mt-4 mb-3">
                Continue
            </button>  

        </div>
    </form>
</section>

<?php
get_sidebar();
get_footer();
?>
<script>
    jQuery(document).ready(function () {
        jQuery(".card-header").click(function () {
        jQuery(this).toggleClass("selected");
        jQuery(this).children('input[type="hidden"]').prop('disabled', function(i, v) { return !v; });
      });
    });
</script>
