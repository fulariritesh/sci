<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Showcase
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-PG5R9HB');</script>
<!-- End Google Tag Manager -->
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <style type="text/css">
    /* #banner .carousel-item {
      height: 660px;
    }

    #banner .content {
      height: 100%;
      display: flex;
      align-items: center;
      color: white;
    } */
  </style>
	<link rel="profile" href="https://gmpg.org/xfn/11">
  <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div class="wrapper hidemenu">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PG5R9HB"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php wp_body_open(); ?>
<div id="page" class="site">
    <header>
      <section class="container-fluid topbar navbar navbar-expand-sm">
        <div class="container px-0 px-lg-3">
        <div class="col-4 col-lg-8 px-0">
          <ul class="tb-left navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="#"
                ><i class="tb-icon fab fa-facebook-f"></i
              ></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href=""
                ><i class="tb-icon fab fa-twitter"></i
              ></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href=""
                ><i class="tb-icon fab fa-instagram"></i
              ></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href=""
                ><i class="tb-icon fab fa-youtube"></i
              ></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href=""
                ><i class="tb-icon fab fa-linkedin"></i
              ></a>
            </li>
            <li class="nav-item pl-4 pt-2 d-none d-lg-block">
              <form class="tb-search-bg px-3">
                <input class="tb-search-bg searchBox " type="" placeholder="search..." />
                <i class="tb-icon1 fa fa-search"></i>
              </form>
            </li>
          </ul>
        </div>
        <div class="col-8 col-lg-4 px-0 ">
          <ul class="contactinfo text-right pl-0">
            <!-- <li class=""> -->
              <!-- <a class="nav-link tb-text" href=""> -->
              <!-- <i class="tb-icon1 fas fa-phone-alt pr-2"></i>+91 65194 62646 -->
              <!-- </a> -->
            <!-- </li> -->
            <?php
              $sci_helpline_number = get_field('sci_helpline_number', 'option');
              if($sci_helpline_number){
                ?>
                <li class="pr-0">
                <a href="tel:<?php echo $sci_helpline_number; ?>" class="text-white">
                  <i class="tb-icon1 fas fa-phone-alt pr-2"></i><?php echo $sci_helpline_number; ?>
                </a>
                </li>
                <?php
              }
            ?>
            <li class=" pr-0">
              <!-- <a
                class="nav-link tb-text dropdown-toggle"
                href="#"
                id="navbarDropdown"
                role="button"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
                > -->
                <i class="tb-icon1 fas fa-globe pr-2"></i>
                EN
              <!-- </a> -->
              <!-- <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">lang0</a>
                <a class="dropdown-item" href="#">lang1</a>
                <a class="dropdown-item" href="#">lang2</a>
              </div> -->
            </li>
          </ul>
        </div>
      </div>
      </section>
      <div class="container-fluid headerbar">
        <div class="container px-0">
          <nav class="navbar navbar-expand-md px-0">
           
            <div class="col-7 col-md-4 col-lg-3 logo px-0 px-lg-3 text-nowrap pr-3">
              <button class="navbar-toggler px-0" type="button"
                data-toggle="collapse"
                data-target="#navcollpse"
                aria-controls="navcollpse"
                aria-expanded="false"
                aria-label="Toggle navigation" >
                <span class="fa fa-bars"></span>
              </button>
              <?php the_custom_logo(); ?>
            </div>
            <div class="collapse navbar-collapse pl-lg-5 main-menu" id="navcollpse">
              <div class="col-12 d-md-none mobilemenu-header px-0">
                  <?php the_custom_logo(); ?>
              </div>
             
              <div class="pt-4 px-3 d-clock d-md-none pb-4">
                <form class="tb-search-bg px-3">
                  <input class="tb-search-bg searchBox " type="text" placeholder="search..." />
                  <i class="tb-icon1 fa fa-search"></i>
                </form>
              </div>
              
              <?php
                wp_nav_menu(
                  array(
                    'theme_location' => 'menu-header',
                    'menu_id'        => 'primary-menu',
                    'menu_class'  => 'navbar-nav justify-content-md-center',
                    'walker'    => new WP_Bootstrap_Navwalker
                  )
                );
              ?>
            </div>

            <div class="col-5 col-md-3 px-0">

              <?php if(!is_user_logged_in()): ?>
              <!-- When user not signed in -->
              <div class="navbar-btn float-right">
                <a href="<?php echo get_page_link(get_page_by_path('login')); ?>" class="btn btn-signIn" type="button" >
                  Log in
                </a>
                <!-- Signup will automatically redirect to category subcategory --> 
                <a href="<?php echo get_page_link(get_page_by_path('signup')); ?>" class="btn btn-join" type="button">
                  Sign up
                </a>
              </div>
              <!-- not signed in end -->
              <?php else: 
                $my_account_id = get_current_user_id();
                $my_account = get_userdata($my_account_id);
              ?>
              <!-- When Signed in -->
              <div class="dropdown loginuser-DD float-right">
                <button class="btn btn-add dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user-circle usericon1"></i> <?php echo ($my_account->first_name) ? $my_account->first_name : 'My Account'; ?>
                </button>
                <div class="dropdown-menu dropdown-menu-right pb-3" aria-labelledby="dropdownMenuButton">
                  <div class="pt-5 pb-4 px-3">
                  <h2><i class="fas fa-user-circle usericon-dd"></i> <?php echo ($my_account->first_name) ? $my_account->first_name : 'My Account'; ?></h2>
                  <h5><?php echo $my_account->user_email; ?></h5>                  
                  </div>
                  <hr/>
                  <a class="dropdown-item" href="<?php echo get_page_link(get_page_by_path('change-password')); ?>"><i class="fas fa-unlock-alt"></i> Reset Password</a>
                  <hr>
                  <a class="dropdown-item" href="<?php echo get_page_link(get_page_by_path('edit-profile')); ?>"><i class="fas fa-cube"></i> Manage Profile</a>
                  <hr>
                  <?php               
                    $visibility = get_field('profile_visibility_status', 'user_' . $my_account_id);
                  ?>
                  <a id="my_account_profile_visibility_btn" class="dropdown-item" data-toggle="modal" data-target="#my_account_toggle_profile_visibility_modal" href="">
                    <i class="fas fa-eye<?php echo ($visibility === true) ? '-slash' : ''; ?>"></i>
                    <?php echo ($visibility === true) ? 'Hide ' : 'Show '; ?>My Profile
                  </a>
                  <hr>
                  <a class="dropdown-item" href="<?php echo get_page_link(get_page_by_path('logout')); ?>"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
              </div>
              <!-- Signed in end-->
              <?php endif; ?>
            </div>
            <!-- <div class="overlay"></div> -->
          </nav>
        </div>
      </div>
    </header>

<!-- Ask for password when toggling profile visibility -->
<div class="modal fade" id="my_account_toggle_profile_visibility_modal" tabindex="-1" aria-labelledby="my_account_toggle_profile_visibility" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <div class="col-9 ">
          <h5 class="modal-title text-lg-center">Change Profile Visibility</h5>
        </div>
        <div class="col-3 ">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      <div class="modal-body">         
          <div class="row">
            <div class="col-10 mx-auto px-0">
              <label class="col-12">Please enter your password</label>
              <div class="col-12">
                <input type="password" class="form-control" />
              </div>
            </div>
          </div>
          <div class=" text-center py-2">
            <button class="btn btn-md btn-popup-cancel" data-dismiss="modal">Cancel</button>
            <button id="hideshowprofilesave_submit" class="btn btn-md btn-popup-save px-4">Save</button>
          </div>

          <div id="hideshowprofileWrapper"></div>
      </div>
    </div>
  </div>
</div>