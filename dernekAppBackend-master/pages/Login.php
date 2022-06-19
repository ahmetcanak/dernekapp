<?php
   require "../libraries/main/Main.php";
   require "../libraries/database/Management.php";
   $connection = new ManageConnection($database);
   if(!empty($_POST)){
   	if(!isset($_POST["email"]) || !isset($_POST["password"])){
   		echo json_encode(["status" => false, "message" => "Eksik parametreler mevcut."]);
   		exit;
   	}

   	if(strlen($_POST["email"]) < 2 || strlen($_POST["password"]) < 5){
   		echo json_encode(["status" => false, "message" => "E-Posta adresi veya şifre hatalı."]);
   		exit;
   	}

   	if (filter_var($_POST["email"], FILTER_VALIDATE_EMAIL) == false) {
   		echo json_encode(["status" => false, "message" => "Lütfen geçerli bir E-Posta adresi girin."]);
   		exit;
   	}

   	if($connection->Connection($_POST["email"],$_POST["password"])){
   		echo json_encode(["status" => true, "message" => "Giriş başarılı. Yönlendiriliyorsunuz.."]);
			$connection->WriteLog("giriş yaptı.");
   		exit;
   	} else {
   		echo json_encode(["status" => false, "message" => "E-Posta adresi veya şifre hatalı."]);
   		exit;
   	}

   }

   if($connection->HasConnection()){
   	sleep(1);
   	header("Location: ./dashboard");
   	exit;
   }
   ?>
<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8" />
      <title>Giriş Yap  | Yönetim Paneli</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta content="E&B Software" name="description" />
      <meta content="E&B Software" name="author" />
      <!-- App favicon -->
      <link rel="shortcut icon" href="assets/images/favicon.ico">
      <!-- Bootstrap Css -->
      <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
      <!-- Icons Css -->
      <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
      <!-- App Css-->
      <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
   </head>
   <body>
      <div class="account-pages my-5 pt-5">
         <div class="container">
            <div class="row justify-content-center">
               <div class="col-md-8 col-lg-6 col-xl-5">
                  <div class="card overflow-hidden">
                     <div class="bg-primary">
                        <div class="text-primary text-center p-4">
                           <h5 class="text-white font-size-20">Hoşgeldiniz,</h5>
                           <p class="text-white-50">devam etmek için giriş yapın.</p>
                           <a href="index.html" class="logo logo-admin">
                           <img src="assets/images/logo-sm.png" height="24" alt="logo">
                           </a>
                        </div>
                     </div>
                     <div class="card-body p-4">
                        <div class="p-3">
                           <form class="form-horizontal mt-4" id="loginForm" method="POST" action="#">
                              <div class="form-group">
                                 <label for="email">E-Posta</label>
                                 <input type="email" class="form-control" required="true" id="email" placeholder="example@domain.tld">
                              </div>
                              <div class="form-group">
                                 <label for="password">Şifre</label>
                                 <input type="password" class="form-control" required="true" id="password" placeholder="******">
                              </div>
                              <div class="form-group row">
                                 <div class="col-sm-12 text-right">
                                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Giriş Yap</button>
                                 </div>
                              </div>
                           </form>
                        </div>
                        <div style="display:none;" id="resultArea">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- JAVASCRIPT -->
      <script src="assets/libs/jquery/jquery.min.js"></script>
      <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="assets/libs/metismenu/metisMenu.min.js"></script>
      <script src="assets/libs/simplebar/simplebar.min.js"></script>
      <script src="assets/libs/node-waves/waves.min.js"></script>
      <script src="assets/js/app.js"></script>
      <script src="assets/js/app/login.js?v=0.0.1"></script>
   </body>
</html>
