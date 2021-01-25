<?php
/* Template Name: Social Links Page */
include('page_ids.php');

$ig_error = $fb_error = $tw_error = $yt_error = NULL;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST['submit'])){
        if($_POST['submit'] == 'save'){

            if(!empty($_POST["instagram"])){
                $ig_url = sanitize_text_field($_POST["instagram"]);
                if (!preg_match("/(?:(?:http|https):\/\/)?(?:www\.)?(?:instagram\.com|instagr\.am)\/([A-Za-z0-9-_\.]+)/im",$ig_url)) {
                    unset($_SESSION['user_social_links']['instagram']);
                    $ig_error = true;
                }else{
                    unset($ig_error);
                    $_SESSION['user_social_links']['instagram'] =  $ig_url;
                }
            }

            if(!empty($_POST["facebook"])){
                $fb_url = sanitize_text_field($_POST["facebook"]);
                if (!preg_match("/(?:http:\/\/)?(?:www\.)?facebook\.com\/(?:(?:\w)*#!\/)?(?:pages\/)?(?:[\w\-]*\/)*([\w\-]*)/",$fb_url)) {
                    unset($_SESSION['user_social_links']['facebook']);
                    $fb_error = true;
                }else{
                    $_SESSION['user_social_links']['facebook'] =  $fb_url;
                }
            }

            if(!empty($_POST["twitter"])){
                $tw_url = sanitize_text_field($_POST["twitter"]);
                if (!preg_match("/http(?:s)?:\/\/(?:www\.)?twitter\.com\/([a-zA-Z0-9_]+)/",$tw_url)) {
                    unset($_SESSION['user_social_links']['twitter']);
                    $tw_error = true;
                }else{
                    $_SESSION['user_social_links']['twitter'] =  $tw_url;
                }
            }

            if(!empty($_POST["youtube"])){
                $yt_url = sanitize_text_field($_POST["youtube"]);
                if (!preg_match("/((http|https):\/\/)?(www\.)?youtube\.com\/(channel|user)\/[a-zA-Z0-9\-]+/",$yt_url)) {
                    unset($_SESSION['user_social_links']['youtube']);
                    $yt_error = true;
                }else{
                    $_SESSION['user_social_links']['youtube'] =  $yt_url;
                }
            }

        }else{

            unset($_SESSION['user_social_links']['instagram']);
            unset($_SESSION['user_social_links']['facebook']);
            unset($_SESSION['user_social_links']['twitter']);
            unset($_SESSION['user_social_links']['youtube']);
        }
    }

    if(!( $ig_error || $fb_error || $tw_error || $yt_error )){
        wp_redirect( get_page_link(  $signup_page )); exit;
    }
} 

get_header();

?>
    <section class="social-links d-flex justify-content-center py-5">
    <div class="card col-11 col-md-10 col-lg-8 col-xl-6 px-md-5">
        <div class="card-body">

        <h4 class="text-center font-weight-bold py-4">
            Social links & Websites
        </h4>

        <h6 class="text-center">
            Make sure each profile is set to public so it can be viewed
        </h6>

        <form action="" method="post">

            <div class="form-group mt-4">
                <div>
                    <img
                    src="https://img.icons8.com/fluent/30/000000/instagram-new.png"
                    />
                    Instagram
                </div>
                <p class="url-eg">https://instagram.com/username</p>
                <input
                    id="instagram"
                    name="instagram"
                    value="<?php echo ($_SESSION['user_social_links']['instagram']) ? $_SESSION['user_social_links']['instagram'] : ""; ?>"
                    class="form-control <?php echo ($ig_error) ? "is-invalid" : ""; ?>"
                    type="text"
                    placeholder="Username"
                />
                <div class="invalid-feedback">please enter valid url</div>
            </div>

            <div class="form-group mt-4">
                <div>
                    <img
                    src="https://img.icons8.com/color/30/000000/facebook.png"
                    />
                    Facebook
                </div>
                <p class="url-eg">https://facebook.com/profile-or-page-url</p>
                <input
                    id="facebook"
                    name="facebook"
                    value="<?php echo ($_SESSION['user_social_links']['facebook']) ? $_SESSION['user_social_links']['facebook'] : ""; ?>"
                    class="form-control <?php echo ($fb_error) ? "is-invalid" : ""; ?>"
                    type="text"
                    placeholder="Profile or page url"
                />
                <div class="invalid-feedback">please enter valid url</div>
            </div>

            <div class="form-group mt-4">
                <div>
                    <img
                    src="https://img.icons8.com/color/30/000000/twitter-squared.png"
                    />
                    Twitter
                </div>
                <p class="url-eg">https://twitter.com/username</p>
                <input
                    id="twitter"
                    name="twitter"
                    value="<?php echo ($_SESSION['user_social_links']['twitter']) ? $_SESSION['user_social_links']['twitter'] : ""; ?>"
                    class="form-control <?php echo ($tw_error) ? "is-invalid" : ""; ?>"
                    type="text"
                    placeholder="Username"
                />
                <div class="invalid-feedback">please enter valid url</div>
            </div>

            <div class="form-group mt-4">
                <div>
                    <img
                    src="https://img.icons8.com/color/30/000000/youtube-play.png"
                    />Youtube
                </div>
                <p class="url-eg">https://youtube.com/channel-or-user-url</p>
                <input
                    id="youtube"
                    name="youtube"
                    value="<?php echo ($_SESSION['user_social_links']['youtube']) ? $_SESSION['user_social_links']['youtube'] : ""; ?>"
                    class="form-control <?php echo ($yt_error) ? "is-invalid" : ""; ?>"
                    type="text"
                    placeholder="Channel or user url"
                />
                <div class="invalid-feedback">please enter valid url</div>
            </div>

            <button type="submit" value="save" name="submit" class="btn btn-signup-gen btn-block btn-lg">
            Save
            </button>
            <button type="submit" value="skip" name="submit" class="btn btn-social-skp btn-block btn-lg">
            Skip for now
            </button>
            
        </form>
        </div>
    </div>
    </section>


<?php
get_sidebar();
get_footer();
?>
