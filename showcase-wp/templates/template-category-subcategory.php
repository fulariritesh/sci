<?php
/* Template Name: Category Subcategory Page */

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
            wp_redirect(get_page_link(get_page_by_path('social-links'))); exit;
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
            Select your skillset and specialised skills 
            </h4>

            <?php
           
                $categories = get_terms( array(
                    'taxonomy' => 'jobs',
                    'hide_empty' => false,
                    'parent' => 0
                ));

                if(!empty($categories)){

                    foreach( $categories as $category ) {
                        
                        if(isset($_SESSION['user_profession'])){
                            $user_selected_category = in_array($category->term_id,$_SESSION['user_profession']);
                        }else{
                            $user_selected_category = false;
                        }
                        ?>
   
                            <div class="category-subcategory accordion-group mb-3 card">
       
                                <!-- MAIN CATEGORY -->
                                <div class="row card-header p-2 category-accordion <?php echo ($user_selected_category) ? 'selected' : ''; ?>"> 

                                    <div class="btn-group-toggle col-1" data-toggle="buttons">
                                        <label class="btn btn-details-cat-subcat pr-1 <?php echo ($user_selected_category) ? 'active' : ''; ?>" >
                                            <input class="main-category-checkbox" <?php echo ($user_selected_category) ? 'checked' : ''; ?> type="checkbox" value="<?php echo $category->term_id; ?>" name="profession[]"  />    
                                        <label>
                                    </div>

                                    <div class="col-2">
                                        <svg class="icon">
                                            <use xlink:href="<?php echo wp_get_attachment_url(get_field('category_svg', $category, false)).'#'.$category->slug;  ?>" />
                                        </svg>                               
                                    </div>

                                    <div class="col-7 col-md-7"> 
                                        <p class="text-uppercase text-center pt-2"><?php echo get_term_meta($category->term_id,'category_name',true); ?></p>                 
                                    </div>  
                                    
                                    <div 
                            <div
                                    <div 
                                        class="col-1 <?php echo ($user_selected_category) ? '' : 'collapsed'; ?>"
                                        type="button"
                                        id="heading<?php echo $category->term_id; ?>"
                                        data-toggle="collapse"
                                        data-target="#collapse<?php echo $category->term_id; ?>"
                                        aria-expanded="<?php echo ($user_selected_category) ? 'true' : 'false'; ?>"
                                        aria-controls="collapse<?php echo $category->term_id; ?>"  
                                aria-controls="collapse<?php echo $category->term_id; ?>"
                                        aria-controls="collapse<?php echo $category->term_id; ?>"  
                                    >
                                        <p class="pt-2"><i class="fa fa-angle-down" aria-hidden="true"></i></p>
                                    </div>
                        
                                </div>
                               
                                <!-- SUB CATEGORY -->
                                <div id="collapse<?php echo $category->term_id; ?>" class="collapse <?php echo ($user_selected_category) ? 'show' : ''; ?>" aria-labelledby="heading<?php echo $category->name; ?>">
                                    <div class="accordion-inner card-body">
                                        <div class="btn-group-toggle" data-toggle="buttons">
                                            <?php

                                            $subcategories = get_terms( array(
                                                'taxonomy' => 'jobs',
                                                'hide_empty' => false,
                                                'parent' => $category->term_id
                                            ));
                                            if(!empty($subcategories)){
                                                foreach( $subcategories as $subcategory ) {
                                                
                                                    if(isset($_SESSION['user_profession'])){
                                                        $user_selected_subcategory = in_array($subcategory->term_id,$_SESSION['user_profession']);
                                                    }else{
                                                        $user_selected_subcategory = false;
                                                    }
                                                    ?>
                                                    <!-- SUB CATEGORY -->
                                                    <label class="btn btn-details-cat-subcat mb-1 <?php echo ($user_selected_subcategory) ? 'active' : ''; ?>">
                                                        <input <?php echo ($user_selected_category) ? '' : 'disabled'; ?> class="sub-category-checkbox" <?php echo ($user_selected_subcategory) ? 'checked' : ''; ?> type="checkbox" value="<?php echo $subcategory->term_id; ?>" name="profession[]"  /> <?php echo $subcategory->name; ?>
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

            <?php echo ($profession_error) ? '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert">&times;</button>Please select a category!</div>' : ''; ?>

            <button 
                type="submit" 
            type="submit" 
                type="submit" 
                name="submit" 
            name="submit" 
                name="submit" 
                value="save" 
            value="save" 
                value="save" 
                class="btn btn-block btn-details-nxt py-3 mt-4 mb-3"
            >
                Continue
            </button>  

        </div>
    </form>
</section>

<?php
get_sidebar();
get_footer();
?>
