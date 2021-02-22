<?php
/*
Template Name: Sitewide Search
*/

$referer = wp_get_referer();

if(!$referer){
    wp_safe_redirect(site_url()); 
    exit;
} 

if($referer == site_url() . '/sitewide-search' && $_POST["search"]==""){
    $_POST["search"] = "not found";
}

if(!(isset($_POST["search"]) && $_POST["search"]!="")){
    wp_safe_redirect(wp_get_referer()); 
    exit;
}

get_header(); 
$search_string = str_replace(' ', '@@@', $_POST["search"]);
?>

<div class="container resultlisting my-4" data-text=<?php echo $search_string ?>>
    
    <div class="row py-3" id="searching">
        <h5>Searching...</h5>
    </div>


    <div class="row py-3 displayList">
        
    </div>
    
</div>

<?php get_sidebar();
get_footer();
?>