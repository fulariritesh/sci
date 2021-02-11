<?php
/* Template Name: Reset Password Page */

get_header();

?>

<section class="reg-bg container-fluid py-5">
    <div class="row">
        <div class="card col-11 col-md-8 col-lg-6 col-xl-4 shadow-sm mx-auto">
        <div class="card-body">
            <h4 class="text-center font-weight-bold py-4">
            <?php
                if(isset($_GET["updated"])){
                    if( $_GET["updated"] == 'checkemail'){
                        echo 'Reset link sent!';
                    }
                }elseif(isset($_GET["act"])){
                    if($_GET["act"] == 'reset_password'){
                        echo 'Reset your password';
                    }
                }
                else{
                    echo 'Forgot Your Password?';
                }
            ?> 
            
            </h4>
            <p class="text-center pb-3">
            <?php
                if(isset($_GET["updated"])){
                    if( $_GET["updated"] == 'checkemail'){
                        echo 'We have sent you a password reset link to your e-mail. Please check your inbox.';
                    }
                }elseif(isset($_GET["act"])){
                    if($_GET["act"] == 'reset_password'){
                        echo 'For a strong password, try to use a combination of text, numbers and symbols. Also, make sure your password is at least 8-10 characters long.';
                    }
                }else{
                    echo 'Enter your registered email address below and we will send you a link that you can follow to reset </br>your password.';
                }
            ?>    
            </p>
            <?php 
				echo do_shortcode('[ultimatemember_password]');
			?>        
            <p class="text-center mt-4">
                Not a member? <a href="<?php echo get_page_link(get_page_by_path('signup')); ?>">Sign up</a>
            </p>
        </div>
        </div>
    </div>
</section>

<?php
get_sidebar();
get_footer();
?>