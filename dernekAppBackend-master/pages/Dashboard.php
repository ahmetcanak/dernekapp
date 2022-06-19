<?php
   require "../libraries/main/Main.php";
   require "../libraries/database/Management.php";
   $connection = new ManageConnection($database);
   if(!$connection->HasConnection()){
     sleep(1);
     header("Location: ./login");
     exit;
   }
   $user = $connection->User();
   $header_css = [];
   include("./include/header.php");
   ?>


                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row align-items-center">
                            <div class="col-sm-12">
                                <div class="page-title-box">
                                    <h4 class="font-size-18">Anasayfa</h4>
                                    <ol class="breadcrumb mb-0">
                                        <li class="breadcrumb-item active">Merhaba, <?php echo $user["name"]." ".$user["surname"];?>. Bu sayfada genel durum hakkında bilgi alabilirsin.</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
          <?php if ($connection->AuthorizationControl("show_statistics")){ ?>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card mini-stat bg-primary text-white">
                                    <div class="card-body">
                                        <div class="mb-4">
                                            <div class="float-left mini-stat-img mr-4">
                                                <img src="assets/images/services-icon/02.png" alt="" >
                                            </div>
                                            <h5 class="font-size-16 text-uppercase mt-0 text-white-50">Haberler</h5>
                                            <h4 class="font-weight-medium font-size-24"><?php echo number_format($connection->CountTable("news"), 0,",","."); ?></h4>
                                        </div>
                                        <div class="pt-2">
                                            <div class="float-right">
                                                <a href="list-news" class="text-white-50"><i class="mdi mdi-arrow-right h5"></i></a>
                                            </div>

                                            <p class="text-white-50 mb-0 mt-1">Tümünü Gör</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="card mini-stat bg-primary text-white">
                                    <div class="card-body">
                                        <div class="mb-4">
                                            <div class="float-left mini-stat-img mr-4">
                                                <img src="assets/images/services-icon/01.png" alt="" >
                                            </div>
                                            <h5 class="font-size-16 text-uppercase mt-0 text-white-50">Kullanıcılar</h5>
                                            <h4 class="font-weight-medium font-size-24"><?php echo number_format($connection->CountTable("users"), 0,",","."); ?></h4>
                                        </div>
                                        <div class="pt-2">
                                            <div class="float-right">
                                                <a href="list-users" class="text-white-50"><i class="mdi mdi-arrow-right h5"></i></a>
                                            </div>

                                            <p class="text-white-50 mb-0 mt-1">Tümünü Gör</p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-xl-3 col-md-6">
                                <div class="card mini-stat bg-primary text-white">
                                    <div class="card-body">
                                        <div class="mb-4">
                                            <div class="float-left mini-stat-img mr-4">
                                                <img src="assets/images/services-icon/03.png" alt="" >
                                            </div>
                                            <h5 class="font-size-16 text-uppercase mt-0 text-white-50">Mesajlar</h5>
                                            <h4 class="font-weight-medium font-size-24"><?php echo number_format($connection->CountTable("messages"), 0,",","."); ?></h4>
                                        </div>
                                        <div class="pt-2">
                                            <div class="float-right">
                                                <a href="messages" class="text-white-50"><i class="mdi mdi-arrow-right h5"></i></a>
                                            </div>

                                            <p class="text-white-50 mb-0 mt-1">Tümünü Gör</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="card mini-stat bg-primary text-white">
                                    <div class="card-body">
                                        <div class="mb-4">
                                            <div class="float-left mini-stat-img mr-4">
                                                <img src="assets/images/services-icon/04.png" alt="" >
                                            </div>
                                            <h5 class="font-size-16 text-uppercase mt-0 text-white-50">Yetkililer</h5>
                                            <h4 class="font-weight-medium font-size-24"><?php echo number_format($connection->CountTable("authorized_list"), 0,",","."); ?></h4>
                                        </div>
                                        <div class="pt-2">
                                            <div class="float-right">
                                                <a href="list-authorized-users" class="text-white-50"><i class="mdi mdi-arrow-right h5"></i></a>
                                            </div>

                                            <p class="text-white-50 mb-0 mt-1">Tümünü Gör</p>
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>
                      <?php } ?>
            <?php  if ($connection->AuthorizationControl("show_logs"))
             { ?>
                        <div class="row">

                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Son 5 İşlem Kaydı</h4>
                                        <ol class="activity-feed">
                                            <?php echo $connection->GenerateLogs(5); ?>
                                        </ol>
                                        <div class="text-center">
                                            <a href="logs" class="btn btn-primary">Tümünü Gör</a>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                      <?php } ?>
<?php if ($connection->AuthorizationControl("show_statistics")){ ?>
                        <div class="row">
                                    <div class="col-md-4">
                                        <div class="card bg-primary">
                                            <div class="card-body">
                                                <div class="text-center text-white py-4">
                                                    <h5 class="mt-0 mb-4 text-white-50 font-size-16">Toplam Kategori</h5>
                                                    <h1><?php echo number_format($connection->CountTable("categories"), 0,",","."); ?></h1>
                                                    <p class="font-size-14 pt-1">Kategori</p>
                                                    <p class="text-white-50 mb-0"><a href="list-categories" class="text-white">Tümünü Gör</a></p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>


                                            <div class="col-md-4">
                                                <div class="card bg-primary">
                                                    <div class="card-body">
                                                        <div class="text-center text-white py-4">
                                                            <h5 class="mt-0 mb-4 text-white-50 font-size-16">Toplam Yetki Grubu</h5>
                                                            <h1><?php echo number_format($connection->CountTable("authorize_list"), 0,",","."); ?></h1>
                                                            <p class="font-size-14 pt-1">Grup</p>
                                                            <p class="text-white-50 mb-0"><a href="auth-list" class="text-white">Tümünü Gör</a></p>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                                    <div class="col-md-4">
                                                        <div class="card bg-primary">
                                                            <div class="card-body">
                                                                <div class="text-center text-white py-4">
                                                                    <h5 class="mt-0 mb-4 text-white-50 font-size-16">Toplam İşlem Kaydı</h5>
                                                                    <h1><?php echo number_format($connection->CountTable("logs"), 0,",","."); ?></h1>
                                                                    <p class="font-size-14 pt-1">Kayıt</p>
                                                                    <p class="text-white-50 mb-0"><a href="logs" class="text-white">Tümünü Gör</a></p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>


                                                        </div>
                        <!-- end row -->
<?php } ?>







                        <!-- end row -->



                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
                <?php
                $footer_scripts = [];
                include("./include/footer.php");
                ?>
