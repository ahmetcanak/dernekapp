<!doctype html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>Yönetim Paneli | Dernek App</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <!-- PAGE CSS -->
        <?php foreach($header_css as $css){ ?>
        <link href="<?php echo $css; ?>" rel="stylesheet" type="text/css" />
        <?php } ?>
        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />

        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

    </head>

    <body data-sidebar="dark">

        <!-- Begin page -->
        <div id="layout-wrapper">

            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <a href="dashboard" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="assets/images/logo.svg" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="assets/images/logo-dark.png" alt="" height="17">
                                </span>
                            </a>

                            <a href="dashboard" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="assets/images/logo-sm.png" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="assets/images/logo-light.png" alt="" height="18">
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                            <i class="mdi mdi-menu"></i>
                        </button>

                        <div class="d-none d-sm-block">
                            <div class="dropdown pt-3 d-inline-block">
                                <a class="btn btn-light dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Hızlı İşlem <i class="mdi mdi-chevron-down"></i>
                                    </a>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                  <?php if ($connection->AuthorizationControl("add_user")){ ?>
                                    <a class="dropdown-item" href="add-user">Kullanıcı Ekle</a>
                                    <a class="dropdown-item" href="list-users">Kayıtlı Kullanıcılar</a>
                                  <?php } ?>
                                  <?php if ($connection->AuthorizationControl("send_notification")){ ?>
                                    <a class="dropdown-item" href="send-notification">Bildirim Gönder</a>
                                  <?php } ?>
                                    <div class="dropdown-divider"></div>
                                  <?php if ($connection->AuthorizationControl("add_auth_user")){ ?>
                                    <a class="dropdown-item" href="add-authorized-user">Yetkili Kullanıcı Ekle</a>
                                    <a class="dropdown-item" href="list-authorized-users">Yetkili Kullanıcılar</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex">
                          <!-- App Search-->




                        <div class="dropdown d-none d-lg-inline-block">
                            <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                                <i class="mdi mdi-fullscreen"></i>
                            </button>
                        </div>



                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="assets/images/user-image.png"
                                    alt="Header Avatar">
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <!-- item-->
                                <a class="dropdown-item" href="profile"><i class="mdi mdi-account-circle font-size-17 align-middle mr-1"></i> Profilim</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="logout"><i class="bx bx-power-off font-size-17 align-middle mr-1 text-danger"></i> Çıkış</a>
                            </div>
                        </div>

                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                                <i class="mdi mdi-settings-outline"></i>
                            </button>
                        </div>

                    </div>
                </div>
            </header>

            <!-- ========== Left Sidebar Start ========== -->
            <div class="vertical-menu">

                <div data-simplebar class="h-100">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li class="menu-title">Genel</li>

                            <li>
                                <a href="dashboard" class="waves-effect">
                                    <i class="ti-home"></i>
                                    <span>Anasayfa</span>
                                </a>
                            </li>
<?php if ($connection->AuthorizationControl("add_news")){ ?>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ti-receipt"></i>
                                    <span>Haberler</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="add-news">Haber Ekle</a></li>
                                    <li><a href="list-news">Haber Listesi</a></li>
                                </ul>
                            </li>
<?php } ?>
<?php if ($connection->AuthorizationControl("add_category")){ ?>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ti-bookmark-alt"></i>
                                    <span>Haber Kategorileri</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="add-category">Kategori Ekle</a></li>
                                    <li><a href="list-categories">Kategori Listesi</a></li>
                                </ul>
                            </li>
<?php } ?>
                            <li class="menu-title">İdarİ</li>
<?php if ($connection->AuthorizationControl("read_messages")){ ?>
                            <li>
                                <a href="messages" class="waves-effect">
                                    <i class="ti-email"></i>
                                    <span>Mesajlar</span>
                                </a>
                            </li>
<?php } ?>
<?php if ($connection->AuthorizationControl("send_notification")){ ?>
                            <li>
                                <a href="send-notification" class="waves-effect">
                                    <i class="mdi mdi-bell-outline"></i>
                                    <span>Bildirim Gönder</span>
                                </a>
                            </li>
                            <li>
                                <a href="notification-logs" class="waves-effect">
                                    <i class="mdi mdi-bell-outline"></i>
                                    <span>Bildirim Kayıtları</span>
                                </a>
                            </li>
<?php } ?>
<?php if ($connection->AuthorizationControl("show_logs")){ ?>
                            <li>
                                <a href="logs" class="waves-effect">
                                    <i class="ti-agenda"></i>
                                    <span>İşlem Kayıtları</span>
                                </a>
                            </li>
<?php } ?>
<?php if ($connection->AuthorizationControl("add_auth")){ ?>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ti-package"></i>
                                    <span>Yetkilendirme</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="add-auth">Yetki Grubu Ekle</a></li>
                                    <li><a href="list-auth">Yetki Grubu Listesi</a></li>
                                </ul>
                            </li>
<?php } ?>
                            <li class="menu-title">Ekstra</li>
<?php if ($connection->AuthorizationControl("add_user")){ ?>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ti-user"></i>
                                    <span> Kullanıcılar </span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="add-user">Kullanıcı Ekle</a></li>
                                    <li><a href="list-users">Kullanıcı Listesi</a></li>
                                </ul>
                            </li>
<?php } ?>

<?php if ($connection->AuthorizationControl("add_auth_user")){ ?>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ti-stamp"></i>
                                    <span> Yetkili Kullanıcılar </span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="add-authorized-user">Yetkili Kullanıcı Ekle</a></li>
                                    <li><a href="list-authorized-users">Yetkili Kullanıcı Listesi</a></li>
                                </ul>
                            </li>
<?php } ?>


                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
                        <div class="main-content">
            <!-- Left Sidebar End -->
