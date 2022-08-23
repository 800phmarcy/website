<!DOCTYPE html>
<html lang="en">
  <head>
    <title>ShopMax &mdash; Colorlib e-Commerce Template</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700"> 
    <link rel="stylesheet" href="assets/fonts/icomoon/style.css">

    <link rel="stylesheet" href="<?php echo(CSS."bootstrap.min.css") ?>">
    <link rel="stylesheet" href="<?php echo(CSS."magnific-popup.css") ?>">
    <link rel="stylesheet" href="<?php echo(CSS."jquery-ui.css") ?>">
    <link rel="stylesheet" href="<?php echo(CSS."owl.carousel.min.css") ?>">
    <link rel="stylesheet" href="<?php echo(CSS."owl.theme.default.min.css") ?>">
    <link rel="stylesheet" href="<?php echo(CSS."aos.css") ?>">
    <link rel="stylesheet" href="<?php echo(CSS."style.css") ?>">
    <link rel="stylesheet" href="<?php echo(CSS."custom_style.css") ?>">

    
  </head>
  <body>
  
  <div class="site-wrap">
    

    <div class="site-navbar bg-white py-2">

      <div class="search-wrap">
        <div class="container">
          <a href="#" class="search-close js-search-close"><span class="icon-close2"></span></a>
          <form action="#" method="post">
            <input type="text" class="form-control" placeholder="Search keyword and hit enter...">
          </form>  
        </div>
      </div>

      <div class="container">
        <div class="d-flex align-items-center justify-content-between">
          <div class="logo">
            <div class="site-logo">
              <a href="<?php echo site_url(getUrl(array("c" => "home", "m" => "index"))); ?>" class="js-logo-clone">Abaya's Hub</a>
            </div>
          </div>
          <div class="main-nav d-none d-lg-block">
            <nav class="site-navigation text-right text-md-center" role="navigation">
              <ul class="site-menu js-clone-nav d-none d-lg-block">
                <li class="has-children active">
                  <a href="index.php">Shop By Styles</a>
                  <ul class="dropdown">
                    <li><a href="#">Casual Abaya</a></li>
                    <li><a href="#">Evening Abaya</a></li>
                    <li><a href="#">Embroidered Abaya</a></li>
                  <!--   <li class="has-children">
                      <a href="#">Sub Menu</a>
                      <ul class="dropdown">
                        <li><a href="#">Menu One</a></li>
                        <li><a href="#">Menu Two</a></li>
                        <li><a href="#">Menu Three</a></li>
                      </ul>
                    </li> -->
                  </ul>
                </li>
                
                <li><a href="<?php echo site_url(getUrl(array("c" => "home", "m" => "sale"))); ?>">Sale</a></li>
                <li><a href="<?php echo site_url(getUrl(array("c" => "home", "m" => "shop"))); ?>">Shop</a></li>
                <li><a href="<?php echo site_url(getUrl(array("c" => "home", "m" => "about"))); ?>">About</a></li>
                <li><a href="<?php echo site_url(getUrl(array("c" => "contact", "m" => "index"))); ?>">Contact</a></li>
              </ul>
            </nav>
          </div>
          <div class="icons">
            <a href="#" class="icons-btn d-inline-block js-search-open"><span class="icon-search"></span></a>
            <a href="<?php echo site_url(getUrl(array("c" => "wishlist", "m" => "index"))); ?>" class="icons-btn d-inline-block"><span class="icon-heart-o"></span></a>
            <a href="<?php echo site_url(getUrl(array("c" => "account", "m" => "index"))); ?>" class="icons-btn d-inline-block"><span class="icon-user-o"></span></a>
            <a href="<?php echo site_url(getUrl(array("c" => "cart", "m" => "index"))); ?>" class="icons-btn d-inline-block bag">
              <span class="icon-shopping-bag"></span>
              <span class="number">2</span>
            </a>
            <a href="#" class="site-menu-toggle js-menu-toggle ml-3 d-inline-block d-lg-none"><span class="icon-menu"></span></a>
          </div>
        </div>
      </div>
    </div>