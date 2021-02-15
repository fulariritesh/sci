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
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PG5R9HB"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php wp_body_open(); ?>
<div id="page" class="site">
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
            <?php
              $sci_helpline_number = get_field('sci_helpline_number', 'option');
              if($sci_helpline_number){
                ?>
                <li class="nav-item">
                  <a class="nav-link tb-text" href="tel:<?php echo $sci_helpline_number; ?>"><i class="tb-icon1 fas fa-phone pr-2"></i><?php echo $sci_helpline_number; ?></a>
                </li>
                <?php
              }
            ?>
            
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
              <a
				 href="/login"
                class="btn btn-signIn"
                type="button"
              >
                Log in
              </a>
              <a
				 href="/category-subcategory/"
                class="btn btn-join"
                type="button"
              >
               Sign up
              </a>
            </div>
            <div class="overlay"></div>
          </nav>
        </div>
      </div>
    </header>