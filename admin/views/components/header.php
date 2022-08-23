<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Mazer Admin Dashboard</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo (CSS.'bootstrap.css')?>">
    <link rel="stylesheet" href="<?php echo (VENDOR.'iconly/bold.css')?>">
    <link rel="stylesheet" href="<?php echo (VENDOR.'perfect-scrollbar/perfect-scrollbar.css')?>">
    <link rel="stylesheet" href="<?php echo (VENDOR.'bootstrap-icons/bootstrap-icons.css')?>">
      <link rel="stylesheet" href="<?php echo (CSS.'app.css')?>">
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon">
</head>

<body>
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <div class="d-flex justify-content-between">
                        <div class="logo">
                            <a href="index.html"><img src="assets/images/logo/logo.png" alt="Logo" srcset=""></a>
                        </div>
                        <div class="toggler">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">

                        <li class="sidebar-item active ">
                            <a href="<?php echo site_url(getUrl(array('c' => 'home', 'm' => 'index'))); ?>" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                          <li class="sidebar-item ">
                            <a href="<?php echo site_url(getUrl(array('c' => 'home', 'm' => 'orders'))); ?>" class='sidebar-link'>
                                <i class="bi bi-file-earmark-medical-fill"></i>
                                <span>Orders</span>
                            </a>
                        </li>

                      

                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-collection-fill"></i>
                                <span>Catalog</span>
                            </a>
                            <ul class="submenu ">
                                <li class="submenu-item ">
                                    <a href="<?php echo site_url(getUrl(array('c' => 'home', 'm' => 'categories'))); ?>">Categories</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="<?php echo site_url(getUrl(array('c' => 'home', 'm' => 'products'))); ?>">Products</a>
                                </li>
                            </ul>
                        </li>

                        <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-person-badge-fill"></i>
                                <span>Users</span>
                            </a>
                            <ul class="submenu ">
                                 <li class="submenu-item ">
                                    <a href="<?php echo site_url(getUrl(array('c' => 'home', 'm' => 'management'))); ?>">Management</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="<?php echo site_url(getUrl(array('c' => 'home', 'm' => 'customers'))); ?>">Customers</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="<?php echo site_url(getUrl(array('c' => 'home', 'm' => 'drivers'))); ?>">Drivers</a>
                                </li>
                            </ul>
                        </li>

                         <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-collection-fill"></i>
                                <span>Marketing</span>
                            </a>
                            <ul class="submenu ">
                                 <li class="submenu-item ">
                                    <a href="<?php echo site_url(getUrl(array('c' => 'promotion', 'm' => 'coupons'))); ?>">Coupons</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="<?php echo site_url(getUrl(array('c' => 'promotion', 'm' => 'discounts'))); ?>">Discounts</a>
                                </li>
                            </ul>
                        </li>


                          <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-bar-chart-fill"></i>
                                <span>Reports</span>
                            </a>
                            <ul class="submenu ">
                                 <li class="submenu-item ">
                                    <a href="<?php echo site_url(getUrl(array('c' => 'report', 'm' => 'index'))); ?>">Sales Report</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="<?php echo site_url(getUrl(array('c' => 'report', 'm' => 'stocksReport'))); ?>">Stocks Report</a>
                                </li>
                            </ul>
                        </li>

                         <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-chat-dots-fill"></i>
                                <span>Feedback</span>
                            </a>
                            <ul class="submenu ">
                                 <li class="submenu-item ">
                                    <a href="<?php echo site_url(getUrl(array('c' => 'feedback', 'm' => 'index'))); ?>">Reviews</a>
                                </li>
                            </ul>
                        </li>

                         <li class="sidebar-item  has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-collection-fill"></i>
                                <span>Settings</span>
                            </a>
                            <ul class="submenu ">
                                 <li class="submenu-item ">
                                    <a href="<?php echo site_url(getUrl(array('c' => 'setting', 'm' => 'profile'))); ?>">Profile</a>
                                </li>
                            </ul>
                        </li>

                    

                    </ul>
                </div>
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>