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
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <style type="text/css">
    #banner .carousel-item {
      height: 660px;
    }

    #banner .content {
      height: 100%;
      display: flex;
      align-items: center;
      color: white;
    }
  </style>
	<link rel="profile" href="https://gmpg.org/xfn/11">
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri() ?>/dist/main.css" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'showcase' ); ?></a>
    <header>
      <section class="container-fluid topbar navbar navbar-expand-sm">
        <div class="container">
        <div class="col">
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
            <li class="nav-item hide-search-bar pl-4 pt-2">
              <form class="tb-search-bg px-3">
                <input class="tb-search-bg searchBox " type="" placeholder="search..." />
                <i class="tb-icon1 fa fa-search"></i>
              </form>
            </li>
          </ul>
        </div>
        <div class="">
          <ul class="tb-right navbar-nav">
            <!-- <li class="nav-item">
              <a class="nav-link tb-text" href=""><i class="tb-icon1 fas fa-phone pr-2"></i>+91 65194 62646</a>
            </li> -->
            <li class="nav-item dropdown">
              <a
                class="nav-link tb-text dropdown-toggle"
                href="#"
                id="navbarDropdown"
                role="button"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
                ><i class="tb-icon1 fas fa-globe pr-2"></i>
                EN
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">lang0</a>
                <a class="dropdown-item" href="#">lang1</a>
                <a class="dropdown-item" href="#">lang2</a>
              </div>
            </li>
          </ul>
        </div>
      </div>
      </section>
      <div class="container-fluid headerbar">
        <div class="container">
          <nav class="navbar navbar-expand-lg px-0">
            <button
              class="navbar-toggler"
              type="button"
              data-toggle="collapse"
              data-target="#navcollpse"
              aria-controls="navcollpse"
              aria-expanded="false"
              aria-label="Toggle navigation"
            >
              <span class="fa fa-bars"></span>
            </button>
            <div class="col-4 logo px-0">
              <?php the_custom_logo(); ?>
            </div>
            <div class="collapse navbar-collapse" id="navcollpse">
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
            <div class="navbar-btn">
              <button
                class="btn btn-signIn"
                type="button"
                data-toggle="collapse"
                aria-controls=""
                aria-expanded="false"
                aria-label="Sign in button"
              >
                Log in
              </button>
              <button
                class="btn btn-join"
                type="button"
                data-toggle="collapse"
                aria-controls=""
                aria-expanded="false"
                aria-label="Join button"
              >
               Sign up
              </button>
            </div>
            <div class="overlay"></div>
          </nav>
        </div>
      </div>
    </header>