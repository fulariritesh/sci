<?php
/* Template Name: Change Password Page */

if (!is_user_logged_in() ) {
	wp_redirect(get_page_link(get_page_by_path('login'))); exit;
} 

$current_user = wp_get_current_user();

$current_pwd = $new_pwd = $confirm_new_pwd = $verify_pwd = NULL;
$current_pwd_er = $new_pwd_er = $confirm_new_pwd_er = NULL;
$change_password_msg = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if(isset($_POST['submit'])){

        if(empty($_POST['confirm-new-password'])){
			$confirm_new_pwd_er = true;
            $change_password_msg['danger'] = 'Please confirm new password';
		}else{
			$confirm_new_pwd = sanitize_text_field( $_POST['confirm-new-password']);
		}

        if(empty($_POST['new-password'])){
			$new_pwd_er = true;
            $change_password_msg['danger'] = 'Please enter new password';
		}else{
			$new_pwd = sanitize_text_field( $_POST['new-password']);
		}

        if(empty($_POST['current-password'])){
			$current_pwd_er = true;
            $change_password_msg['danger'] = 'Please enter current password';
		}else{
			$current_pwd = sanitize_text_field( $_POST['current-password']);
		}

        if(!$current_pwd_er && !$new_pwd_er && !$confirm_new_pwd_er){

            $verify_pwd = wp_check_password( $current_pwd, $current_user->data->user_pass, $current_user->data->ID);

            if($verify_pwd){
                // echo 'VERIFIED';
                // $change_password_msg['success'] = 'Password verified';
                if ( $new_pwd == $confirm_new_pwd) {
                    wp_set_password( $new_pwd, $current_user->data->ID);
                    wp_set_auth_cookie ( $current_user->data->ID );
                    wp_set_current_user( $current_user->data->ID );
                    do_action('wp_login', $current_user->data->user_login, $current_user );
                    // echo 'Your new password is changed.';
                    $change_password_msg['success'] = 'Your new password is changed';
                } else {
                    // echo 'Your current password is correct, but the new and confirm passwords do not match.';
                    $change_password_msg['danger'] = 'New and confirm passwords do not match';
                }
            }else{
                // echo 'INCORRECT';
                $change_password_msg['danger'] = 'Current password incorrect';
            }

        }

    }
}

get_header();

?>

<section class="reg-bg container-fluid py-5">
    <div class="row">
        <div class="card col-11 col-md-8 col-lg-6 col-xl-4 shadow-sm mx-auto">
        <div class="card-body">            
            <?php 
                if(!empty($change_password_msg)){
                    foreach($change_password_msg as $status => $msg){
                        echo    '<div class="alert alert-'.$status.' alert-dismissible fade show" role="alert">
                                '.$msg.'.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>';
                    }
                }
            ?>
            <h4 class="text-center font-weight-bold py-4">Change Your Password!</h4>
            <p class="text-center pb-3">
            For a strong password, try to use a combination of text, numbers and symbols. Also, make sure your password is at least 8-10 characters long.</a>
            </p>
            <form action="" method="post">
                <div class="form-group">
                    <input
                    name="current-password"
                    type="password"
                    class="form-control"
                    placeholder="Current Password"
                    />
                </div>
                <div class="form-group">
                    <input
                    name="new-password"
                    type="password"
                    class="form-control"
                    placeholder="New Password"
                    />
                </div>
                <div class="form-group">
                    <input
                    name="confirm-new-password"
                    type="password"
                    class="form-control"
                    placeholder="Confirm New Password"
                    />
                </div>
                <button
                    type="submit"
                    name="submit"
                    class="btn btn-rp btn-block btn-lg btn-xs my-4"
                >
                    Change Password
                </button>
            </form>
        </div>
        </div>
    </div>
</section>

<?php
get_sidebar();
get_footer();
?>