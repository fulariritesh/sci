<?php
$pageSize = $_POST['pageSize'];
$pageNumber = $_POST['pageNumber'];

$limit = (int)$pageSize;
$offset = ($pageNumber -1) * $pageSize;


$args = array(
    'role' => 'subscriber',
    'number' => $limit,
    'meta_key'     => 'profession',
    'meta_value'   => array(''),
    'meta_compare' => 'NOT IN',
    'orderby'      => 'user_registered',
    'order'        => 'DESC',
    'offset'        => $offset,
);
$allUsersWithProfession = get_users($args);

if($allUsersWithProfession){

    foreach($allUsersWithProfession as $user){
        ?>

                <a href=<?php echo "/wordpress/profile/" . $user->ID ?> class="col-6 col-sm-4 col-md-3 col-lg-2">
                    <div class="card h-100">
                        <img class="card-img-top" src=<?php echo get_field('sci_user_headshot', 'user_' . $user->ID) ?> alt="Card image cap">
                        <div class="card-body">
                        <h5 class="card-title"><?php echo $user->display_name ?></h5>
                        <p class="card-text"><i class="fas fa-map-marker-alt"></i> <?php echo get_field('sci_user_location', 'user_' . $user->ID) ?></p>
                            <p>
                                <?php
                                    $termIds = get_user_meta($user->ID, 'profession',true);

                                    $professions = get_terms( array(
                                        'include' => $termIds,
                                        'hide_empty'=> false,
                                        'parent'=> 0
                                    ) );

                                    for ($x = 0; $x <= 3; $x++) {
                                            $singularTerm = get_term_meta( $professions[$x]->term_id, 'category_name_singular', true );
                                            if($singularTerm){
                                        ?>
                                            <span class="badge <?php echo 'c-' . str_replace(' ','-',strtolower($singularTerm)) ?>"><?php echo $singularTerm ?></span>
                                            
                                        <?php
                                            }
                                    }
                                    if(count($professions) > 4){
                                        ?>
                                        <span class="badge c-more">+2</span>
                                        <?php
                                    }
                                ?>
                            </p>
                        </div>
                    </div>
                </a>
            
            <?php   
    }
   
}else{
    echo 'No matching talents found.'; 
}


wp_die();

?>

