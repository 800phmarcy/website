<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

       <title><?php echo $pageTitle; ?></title>


    <!-- Mobile viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://staging.800pharmacy.ae/demo/assets/css/components/bootstrap.min.css">
    <link rel="stylesheet" href="https://staging.800pharmacy.ae/demo/assets/css/components/flexslider.min.css">
    <link rel="stylesheet" href="https://staging.800pharmacy.ae/demo/assets/css/components/slick.min.css">
    <link rel="stylesheet" href="https://staging.800pharmacy.ae/demo/assets/css/components/normalize.min.css">
    <link rel="stylesheet" href="https://staging.800pharmacy.ae/demo/assets/css/components/animate.min.css">
      <link rel="stylesheet" href="https://staging.800pharmacy.ae/demo/assets/css/header.css">
    <link rel="stylesheet" href="https://staging.800pharmacy.ae/demo/assets/css/main.css">
      <link rel="stylesheet" href="https://staging.800pharmacy.ae/demo/assets/css/account.css">
      <link rel="stylesheet" href="https://staging.800pharmacy.ae/demo/assets/css/checkout.css">
    <link rel="stylesheet" href="https://staging.800pharmacy.ae/demo/assets/css/responsive.css">
        <link rel="stylesheet" href="https://staging.800pharmacy.ae/demo/assets/css/responsive-md.css">
            <link rel="stylesheet" href="https://staging.800pharmacy.ae/demo/assets/css/responsive-sm.css">
     <link rel="stylesheet" href="https://staging.800pharmacy.ae/demo/assets/css/intlTelInput.css">


    <link rel="shortcut icon" href="https://staging.800pharmacy.ae/demo/assets/images/800Fav.png" />

    <script src="https://staging.800pharmacy.ae/demo/assets/js/components/jquery-3.4.1.min.js"></script>
    <script src="https://staging.800pharmacy.ae/demo/assets/js/components/jquery.flexslider-min.js"></script>
    <script src="https://staging.800pharmacy.ae/demo/assets/js/components/bootstrap.min.js"></script>
    <script src="https://staging.800pharmacy.ae/demo/assets/js/components/slick.min.js"></script>
    <script src="https://staging.800pharmacy.ae/demo/assets/js/components/wow.min.js"></script>
    <script src="https://staging.800pharmacy.ae/demo/assets/js/components/notify.js"></script>
    <script src="https://staging.800pharmacy.ae/demo/assets/js/components/notify.min.js"></script>
    <script src="https://staging.800pharmacy.ae/demo/assets/js/components/jquery.flexslider-min.js"></script>


    <script src="https://mediclinic.800pharmacy.ae/panel/theme/js/intlTelInput.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.14.0/jquery.validate.min.js"></script>
 <script src="<?php echo(JS.'main.js'); ?>"></script>


</head>


<body>

    <header class="header">

        <div class="header-top">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                    <div class="header-top-inner">
                        <div class="header-top-left">

                            <div class="header-top-languages">
                                <ul class="header-top-lang-items">
                                    <li class="header-top-lang-selected-item"><img class="language-icon" src="<?php echo(IMAGES.'english-flag.svg'); ?>" />ENG<img class="lang-dropdown-icon" src="<?php echo(IMAGES.'arrow-down.svg'); ?>" /></li>
                                </ul>
                            </div>

                            <div class="header-top-info">
                                <ul class="header-top-info-items">
                                    <li class="header-top-info-item">24/7 Delivery</li>
                                    <li class="header-top-info-item-call"><img class="info-dropdown-icon" src="<?php echo(IMAGES.'phone-call.svg'); ?>" />800 724 76229</li>
                                </ul>
                            </div>

                        </div>
                    <?php if(!$this->session->userdata('isUserLoggedIn')){?>
                        <div class="header-top-right">
                            <a class="header-top-right-link" href="<?php echo site_url(getUrl(array("c" => "login", "m" => "index"))); ?>">
                            Create an account
                        </a>
                        </div>

                    <?php }?>
                    </div>
                </div>

                </div>
            </div>

        </div> <!-- header-top -->

        <div class="header-main">

            <div class="container">
                <div class="row">

                   <a href="<?php echo site_url(getUrl(array("c" => "home", "m" => "index"))); ?>"> <img  src="<?php echo(IMAGES.'menu-icon.svg'); ?>" class="header-main-menu-icon"/>
                    <img  class="header-main-logo" src="<?php echo(IMAGES.'logo.svg'); ?>"/></a>
                    <input type="text" name="search" class="header-main-search">
                    <a class="btn-upload-prescription" href="<?php echo site_url(getUrl(array("c" => "prescription", "m" => "index"))); ?>">Upload Prescription<img class="lang-dropdown-icon" src="<?php echo(IMAGES.'upload-prescription.svg'); ?>" /></a>

                    <div class="header-main-dropdown">

                        <?php if($this->session->userdata('isUserLoggedIn')){?>

                        <button class="header-main-dropdown-btn">My Account<img class="lang-dropdown-icon" src="<?php echo(IMAGES.'arrow-down.svg'); ?>" /></button>

                        <div class="header-main-dropdown-content">
                            <a href="<?php echo site_url(getUrl(array("c" => "account", "m" => "index"))); ?>"><img class="dropdown-icon" src="<?php echo(IMAGES.'my-profile.svg'); ?>" />My Profile</a>
                            <a href="<?php echo site_url(getUrl(array("c" => "orders", "m" => "index"))); ?>"><img class="dropdown-icon" src="<?php echo(IMAGES.'my-orders.svg'); ?>" />My Orders</a>
                            <a href="<?php echo site_url(getUrl(array("c" => "wishlist", "m" => "index"))); ?>"><img class="dropdown-icon" src="<?php echo(IMAGES.'wishlist.svg'); ?>" />My Wishlist</a>
                            <a href="<?php echo site_url(getUrl(array("c" => "notification", "m" => "index"))); ?>"><img class="dropdown-icon" src="<?php echo(IMAGES.'notifications.svg'); ?>" />Notifications</a>
                            <a href="#"><img class="dropdown-icon" src="<?php echo(IMAGES.'live-support.svg'); ?>" />Live Support</a>
                            <a href="<?php echo site_url(getUrl(array("c" => "SuggestProduct", "m" => "index"))); ?>"
                             class="suggest-product"><img class="dropdown-icon" src="<?php echo(IMAGES.'suggest-product.svg'); ?>"  />Suggest a Product</a>
                            <a href="<?php echo site_url(getUrl(array("c" => "login", "m" => "logout"))); ?>"><img class="dropdown-icon" src="<?php echo(IMAGES.'log-out.svg'); ?>" />Log Out</a>
                        </div>

                        <?php }else {?>

                        <button class="header-main-dropdown-btn">Login<img class="lang-dropdown-icon" src="<?php echo(IMAGES.'arrow-down.svg'); ?>" /></button>

                        <?php } ?>



                    </div>

                    <label class="vertical-line"></label>

                    <div class="header-shortcuts">
                        <a href="<?php echo site_url(getUrl(array("c" => "wishlist", "m" => "index"))); ?>"><img  class="wishlist-menu" src="<?php echo(IMAGES.'heart.svg'); ?>"/></a>
                        <img   src="<?php echo(IMAGES.'cart.svg'); ?>" class="cart-bucket"/>
                    </div>

                </div>
            </div>

        </div> <!-- header-main -->

         <img src="<?php echo(IMAGES.'added_to_cart_message.png'); ?>" id="message">

<!--          <div class="header-categories-menu">

            <div class="header-categories-menu-content">

                <div class="header-categories-menu-content-left">





                <ul class="nav navbar-nav">


                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>

                        <ul class="dropdown-menu">
                          <li class="kopie"><a href="#">Dropdown</a></li>
                            <li><a href="#">Dropdown Link 1</a></li>
                            <li class="active"><a href="#">Dropdown Link 2</a></li>
                            <li><a href="#">Dropdown Link 3</a></li>

                            <li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown Link 4</a>
                                <ul class="dropdown-menu">
                                    <li class="kopie"><a href="#">Dropdown Link 4</a></li>
                                    <li><a href="#">Dropdown Submenu Link 4.1</a></li>
                                    <li><a href="#">Dropdown Submenu Link 4.2</a></li>
                                    <li><a href="#">Dropdown Submenu Link 4.3</a></li>
                                    <li><a href="#">Dropdown Submenu Link 4.4</a></li>

                                </ul>
                            </li>

                            <li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown Link 5</a>
                                <ul class="dropdown-menu">
                                    <li class="kopie"><a href="#">Dropdown Link 5</a></li>
                                    <li><a href="#">Dropdown Submenu Link 5.1</a></li>
                                    <li><a href="#">Dropdown Submenu Link 5.2</a></li>
                                    <li><a href="#">Dropdown Submenu Link 5.3</a></li>

                                    <li class="dropdown dropdown-submenu"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown Submenu Link 5.4</a>
                                        <ul class="dropdown-menu">
                                            <li class="kopie"><a href="#">Dropdown Submenu Link 5.4</a></li>
                                            <li><a href="#">Dropdown Submenu Link 5.4.1</a></li>
                                            <li><a href="#">Dropdown Submenu Link 5.4.2</a></li>


                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                </ul>



                </div>

                <div class="header-categories-menu-content-right">
                </div>

            </div>

         </div>

 -->

            <div class="products-cart">

                <div class="products-cart-items">

                <?php foreach(__getItems('cart') as $cartProduct): ?>

                    <div class = "products-cart-item">
                            <div class="cart-item-thumb">
                                <img src="<?php echo $cartProduct['image']?>" alt="Product Image" onerror="this.src='<?php echo(IMAGES.'sample-product.svg'); ?>'" >
                            </div>

                            <div class="cart-detail">

                                <div class="product-name"><?php echo $cartProduct['name']?></div>
                                <div class="product-price"><?php echo $cartProduct['upc']?></div>
                                <div class="product-price"><?php echo $cartProduct['price_formated']?></div>
                                <a href="javascript:void(0)" class="remove-cart-item" id = "<?php echo $cartProduct['rowid']?>"><img src="<?php echo(IMAGES.'cross.svg'); ?>" /></a>

                            </div>

                        </div> <!-- Product Item -->

                   <?php endforeach ?>



                </div> <!-- Product Cart List -->

                <div class="cart-products-subtotal">


                        <p class="cart-product-subtotal-label">Sub-Total</p>
                        <p class="cart-product-subtotal-value">AED <span id="sub_total"><?php echo __cartBill()['subTotal']?></span></p>



                </div>

              <div class="cart-actions">
                    <a href="<?php echo site_url(getUrl(array("c" => "checkout", "m" => "index"))); ?>" ><button class="btn-cart-checkout">Checkout</button></a>
</div>


            </div> <!-- Customer's Products Cart -->





    </header> <!-- Header Ends Here -->

    <!-- Body Start Here -->




  <script type="text/javascript">

         var login_url = '<?php echo site_url(getUrl(array("c" => "login", "m" => "authenticateUser"))); ?>';
        var signup_url = '<?php echo site_url(getUrl(array("c" => "login", "m" => "signup"))); ?>';
        var home_url = '<?php echo site_url(getUrl(array("c" => "home", "m" => "index"))); ?>';
        var add_to_cart_url = '<?php echo site_url(getUrl(array("c" => "cart", "m" => "addToCart"))); ?>';
        var remove_from_cart_url = '<?php echo site_url(getUrl(array("c" => "cart", "m" => "removeItem"))); ?>';
        var add_to_wishlist_url = '<?php echo site_url(getUrl(array("c" => "cart", "m" => "addToWishlist"))); ?>';
        var proceed_to_checkout_url = '<?php echo site_url(getUrl(array("c" => "checkout", "m" => "proceedtocheckout"))); ?>';
        var checkout_details_url = '<?php echo site_url(getUrl(array("c" => "checkout", "m" => "details"))); ?>';
        var save_notes = '<?php echo site_url(getUrl(array("c" => "checkout", "m" => "saveNotes"))); ?>';
        var save_delivery_schedule = '<?php echo site_url(getUrl(array("c" => "checkout", "m" => "saveDeliveryTime"))); ?>';
        var savePaymentMethod = '<?php echo site_url(getUrl(array("c" => "checkout", "m" => "savePaymentMethod"))); ?>';
        var change_delivery_address_url = '<?php echo site_url(getUrl(array("c" => "checkout", "m" => "setDeliveryAddress"))); ?>';
        var submit_order_url = '<?php echo site_url(getUrl(array("c" => "checkout", "m" => "submitOrder"))); ?>';
         var order_success_url = '<?php echo site_url(getUrl(array("c" => "checkout", "m" => "ordersuccessfull"))); ?>';
    </script>
