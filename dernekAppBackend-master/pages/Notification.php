<?php
   require "../libraries/main/Main.php";
   require "../libraries/database/Management.php";
   $connection = new ManageConnection($database);
   if(!$connection->HasConnection()){
     sleep(1);
     header("Location: ./login");
     exit;
   }

   if (!$connection->AuthorizationControl("send_notification"))
   {
       echo json_encode(["status" => false, "message" => "Bu işlem için yetkiniz yok."]);
       exit;
   }

   if(!isset($_GET["action"])){
     sleep(1);
     header("Location: ./dashboard");
     exit;
   }
   if($_GET["action"] != "send" && $_GET["action"] != "list" && $_GET["action"] != "delete"){
     sleep(1);
     header("Location: ./dashboard");
     exit;
   }
     if($_GET["action"] == "send"){
       require "../libraries/notifications/Send.php";
       $footer_scripts = [];
       $header_css = [];
       $header_css[] = 'assets/libs/sweetalert2/sweetalert2.min.css';
       $header_css[] = 'assets/css/multi-select.css';
       $footer_scripts[] = 'assets/libs/sweetalert2/sweetalert2.min.js';
      $footer_scripts[] = 'assets/js/app/multi-select.js?v=0.1';
       $footer_scripts[] = 'assets/js/app/send-notification.js?v=0.1';
       $ManageNotifications = new ManageNotifications($database);
       if(isset($_POST["send_action"])){
         $image_file = '';
         if(isset($_FILES["NotificationImage"])){
           require "../libraries/upload/Upload.php";
           $image = new Upload($_FILES['NotificationImage']);
           $image_name = time().uniqid();
            if ($image->uploaded){
              $image->allowed = array ( 'image/*' );
              $image->file_new_name_body = $image_name;
              $image->Process('../uploads/notifications/');
              if (!$image->processed){
                 echo json_encode(["status" => false, "message" => "Lütfen geçerli bir resim yükleyin."]);
                 exit;
              } else {
                $image_file = $image->file_dst_path . $image->file_dst_name;
              }
            }
         }
          $status = $ManageNotifications->Send($_POST, $image_file);
          if($status["status"] == false){
             echo json_encode($status);
          } else {
            echo json_encode(["status" => true, "message" => "Bildirim ilgili kullanıcılara gönderildi."]);
            $id = $status["id"];
            $connection->WriteLog("#$id numaralı bildirimi gönderdi.");
          }
         exit;
       }
     }

     if($_GET["action"] == "delete"){
       require "../libraries/notifications/Delete.php";
       $ManageNotifications = new ManageNotifications($database);
       if (!$connection->AuthorizationControl("delete_notification"))
       {
           echo  json_encode(["status" => false, "message" => "Bu işlem için yetkiniz yok."]);
           exit;
       }
       $explode_id = explode("?id=", $_SERVER["REQUEST_URI"]);
       $id = isset($explode_id[1]) ? $explode_id[1] : false;
       if($id === false || is_numeric($id) == false){
         echo json_encode(["status" => false, "message" => "Eksik parametreler mevcut."]);
         exit;
       }
       $delete_status = $ManageNotifications->delete($id);
       if($delete_status["status"]){
         $connection->WriteLog("#$id numaralı bildirimi sildi.");
       }
       echo json_encode($delete_status);

       exit;
     }

     if($_GET["action"] == "list"){
       require "../libraries/notifications/List.php";
       $ManageNotifications = new ManageNotifications($database);
       $footer_scripts = [];
       $header_css = [];
       $header_css[] =  'assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css';
       $header_css[] =  'assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css';
       $header_css[] = 'assets/libs/sweetalert2/sweetalert2.min.css';
       $footer_scripts[] = 'assets/libs/datatables.net/js/jquery.dataTables.min.js';
       $footer_scripts[] = 'assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js';
       $footer_scripts[] = 'assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js';
       $footer_scripts[] = 'assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js';
       $footer_scripts[] = 'assets/libs/jszip/jszip.min.js';
       $footer_scripts[] = 'assets/libs/pdfmake/build/pdfmake.min.js';
       $footer_scripts[] = 'assets/libs/pdfmake/build/vfs_fonts.js';
       $footer_scripts[] = 'assets/libs/datatables.net-buttons/js/buttons.html5.min.js';
       $footer_scripts[] = 'assets/libs/datatables.net-buttons/js/buttons.print.min.js';
       $footer_scripts[] = 'assets/libs/datatables.net-buttons/js/buttons.colVis.min.js';
       $footer_scripts[] = 'assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js';
       $footer_scripts[] = 'assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js';
       $footer_scripts[] = 'assets/libs/sweetalert2/sweetalert2.min.js';
       $footer_scripts[] = 'assets/js/app/notification-logs.js?v=15.0';
     }


   $user = $connection->User();
   include("./include/header.php");
   echo $ManageNotifications->write();
   if(!$connection->AuthorizationControl("export_data")){
     $footer_scripts[] = 'assets/js/app/remove_exports.js';
   }
   ?>


                <!-- End Page-content -->
                <?php
      include("./include/footer.php");
                ?>
