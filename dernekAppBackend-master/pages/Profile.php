<?php
   require "../libraries/main/Main.php";
   require "../libraries/database/Management.php";
   $connection = new ManageConnection($database);
   if(!$connection->HasConnection()){
     sleep(1);
     header("Location: ./login");
     exit;
   }

     require "../libraries/profile/Detail.php";
     $footer_scripts = [];
     $header_css = [];
     $header_css[] = 'assets/libs/sweetalert2/sweetalert2.min.css';
     $footer_scripts[] = 'assets/libs/sweetalert2/sweetalert2.min.js';
     $footer_scripts[] = 'assets/js/app/profile.js?v=0.1';
     $ManageAuthorizedUsers = new ManageAuthorizedUsers($database);
     if(isset($_POST["update_action"])){
        $status = $ManageAuthorizedUsers->Update($_POST);
        if($status["status"] == false){
           echo json_encode($status);
        } else {
          echo json_encode(["status" => true, "message" => "Profiliniz başarıyla güncellendi."]);
          $connection->WriteLog("profilini güncelledi.");
        }
       exit;
     }


   $user = $connection->User();
   include("./include/header.php");
   echo $ManageAuthorizedUsers->write();
   ?>


                <!-- End Page-content -->
                <?php
      include("./include/footer.php");
                ?>
