<?php
   require "../libraries/main/Main.php";
   require "../libraries/database/Management.php";
   $connection = new ManageConnection($database);
   if(!$connection->HasConnection()){
     sleep(1);
     header("Location: ./login");
     exit;
   }
   if(!isset($_GET["action"])){
     sleep(1);
     header("Location: ./dashboard");
     exit;
   }
   if($_GET["action"] != "list" && $_GET["action"] != "add" && $_GET["action"] != "detail" && $_GET["action"] != "delete"){
     sleep(1);
     header("Location: ./dashboard");
     exit;
   }
   if($_GET["action"] == "list")
   {
     if (!$connection->AuthorizationControl("add_auth_user"))
     {
         echo  json_encode(["status" => false, "message" => "Bu işlem için yetkiniz yok."]);
         exit;
     }
     require "../libraries/authorized-users/List.php";
     $ManageAuthorizedUsers = new ManageAuthorizedUsers($database);
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
     $footer_scripts[] = 'assets/js/app/list-auth-users.js?v=34.0';
   }
   if($_GET["action"] == "add"){
     if (!$connection->AuthorizationControl("add_auth_user"))
     {
         echo  json_encode(["status" => false, "message" => "Bu işlem için yetkiniz yok."]);
         exit;
     }
     require "../libraries/authorized-users/Add.php";
     $ManageAuthorizedUsers = new ManageAuthorizedUsers($database);
     $footer_scripts = [];
     $header_css = [];
     $header_css[] = 'assets/libs/sweetalert2/sweetalert2.min.css';
     $footer_scripts[] = 'assets/libs/sweetalert2/sweetalert2.min.js';
     $footer_scripts[] = 'assets/js/app/add-auth-user.js';
     if(isset($_POST["add_action"])){

        $status = $ManageAuthorizedUsers->Insert($_POST);
        if($status["status"] == false){
           echo json_encode($status);
        } else {
          echo json_encode(["status" => true, "message" => "Yetkili başarıyla eklendi"]);
          $id = $status["id"];
          $connection->WriteLog("#$id numaralı yetkiliyi oluşturdu.");
        }

       exit;
     }
   }
   if($_GET["action"] == "detail"){
     if (!$connection->AuthorizationControl("add_auth_user"))
     {
         echo  json_encode(["status" => false, "message" => "Bu işlem için yetkiniz yok."]);
         exit;
     }
     require "../libraries/authorized-users/Detail.php";
     $footer_scripts = [];
     $header_css = [];
     $header_css[] = 'assets/libs/sweetalert2/sweetalert2.min.css';
     $footer_scripts[] = 'assets/libs/sweetalert2/sweetalert2.min.js';
     $footer_scripts[] = 'assets/js/app/detail-auth-user.js?v=0.1';
     $explode_id = explode("?id=", $_SERVER["REQUEST_URI"]);
     $id = isset($explode_id[1]) ? $explode_id[1] : false;
     if($id === false || is_numeric($id) == false){
       echo json_encode(["status" => false, "message" => "Eksik parametreler mevcut."]);
       exit;
     }
     $ManageAuthorizedUsers = new ManageAuthorizedUsers($database,$id);
     if($ManageAuthorizedUsers->Control() == false){
       echo json_encode(["status" => false, "message" => "Yetkili bulunamadı."]);
       exit;
     }
     if(isset($_POST["update_action"])){
        $status = $ManageAuthorizedUsers->Update($_POST);
        if($status["status"] == false){
           echo json_encode($status);
        } else {
          echo json_encode(["status" => true, "message" => "Yetkili başarıyla güncellendi."]);
          $id = $status["id"];
          $connection->WriteLog("#$id numaralı yetkiliyi güncelledi.");
        }
       exit;
     }
   }
   if($_GET["action"] == "delete"){
     require "../libraries/authorized-users/Delete.php";
     $ManageAuthorizedUsers = new ManageAuthorizedUsers($database);
     if (!$connection->AuthorizationControl("delete_auth_user"))
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
     $delete_status = $ManageAuthorizedUsers->delete($id);
     if($delete_status["status"]){
       $connection->WriteLog("#$id numaralı yetkiliyi sildi.");
     }
     echo json_encode($delete_status);

     exit;
   }

   $user = $connection->User();
   include("./include/header.php");
   echo $ManageAuthorizedUsers->write();

   if($_GET["action"] == "list" && !$connection->AuthorizationControl("export_data")){
     $footer_scripts[] = 'assets/js/app/remove_exports.js';
   }
   ?>


                <!-- End Page-content -->
                <?php
      include("./include/footer.php");
                ?>
