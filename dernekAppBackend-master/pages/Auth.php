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
     if (!$connection->AuthorizationControl("add_auth"))
     {
         echo  json_encode(["status" => false, "message" => "Bu işlem için yetkiniz yok."]);
         exit;
     }
     require "../libraries/authorize/List.php";
     $ManageAuthorize = new ManageAuthorize($database);
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
     $footer_scripts[] = 'assets/js/app/list-auth.js?v=34.0';
   }
   if($_GET["action"] == "add"){
     if (!$connection->AuthorizationControl("add_auth"))
     {
         echo  json_encode(["status" => false, "message" => "Bu işlem için yetkiniz yok."]);
         exit;
     }
     require "../libraries/authorize/Add.php";
     $ManageAuthorize = new ManageAuthorize($database);
     $footer_scripts = [];
     $header_css = [];
     $header_css[] = 'assets/libs/sweetalert2/sweetalert2.min.css';
     $footer_scripts[] = 'assets/libs/sweetalert2/sweetalert2.min.js';
     $footer_scripts[] = 'assets/js/app/add-auth.js';
     if(isset($_POST["add_action"])){
        $status = $ManageAuthorize->Insert($_POST);
        if($status["status"] == false){
           echo json_encode($status);
        } else {
          echo json_encode(["status" => true, "message" => "Yetki Grubu başarıyla eklendi"]);
          $id = $status["id"];
          $connection->WriteLog("#$id numaralı yetki grubunu oluşturdu.");
        }

       exit;
     }
   }
   if($_GET["action"] == "detail"){
     if (!$connection->AuthorizationControl("add_auth"))
     {
         echo  json_encode(["status" => false, "message" => "Bu işlem için yetkiniz yok."]);
         exit;
     }
     require "../libraries/authorize/Detail.php";
     $footer_scripts = [];
     $header_css = [];
     $header_css[] = 'assets/libs/sweetalert2/sweetalert2.min.css';
     $footer_scripts[] = 'assets/libs/sweetalert2/sweetalert2.min.js';
     $footer_scripts[] = 'assets/js/app/detail-auth.js?v=0.1';
     $explode_id = explode("?id=", $_SERVER["REQUEST_URI"]);
     $id = isset($explode_id[1]) ? $explode_id[1] : false;
     if($id === false || is_numeric($id) == false){
       echo json_encode(["status" => false, "message" => "Eksik parametreler mevcut."]);
       exit;
     }
     $ManageAuthorize = new ManageAuthorize($database,$id);
     if($ManageAuthorize->Control() == false){
       echo json_encode(["status" => false, "message" => "Yetki grubu bulunamadı."]);
       exit;
     }
     if(isset($_POST["update_action"])){
        $status = $ManageAuthorize->Update($_POST);
        if($status["status"] == false){
           echo json_encode($status);
        } else {
          echo json_encode(["status" => true, "message" => "Yetki grubu başarıyla güncellendi."]);
          $id = $status["id"];
          $connection->WriteLog("#$id numaralı yetki grubunu güncelledi.");
        }
       exit;
     }
   }
   if($_GET["action"] == "delete"){
     require "../libraries/authorize/Delete.php";
     $ManageAuthorize = new ManageAuthorize($database);
     if (!$connection->AuthorizationControl("delete_auth"))
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
     $delete_status = $ManageAuthorize->delete($id);
     if($delete_status["status"]){
       $connection->WriteLog("#$id numaralı yetki grubunu sildi.");
     }
     echo json_encode($delete_status);

     exit;
   }

   $user = $connection->User();
   include("./include/header.php");
   echo $ManageAuthorize->write();

   if($_GET["action"] == "list" && !$connection->AuthorizationControl("export_data")){
     $footer_scripts[] = 'assets/js/app/remove_exports.js';
   }
   ?>


                <!-- End Page-content -->
                <?php
      include("./include/footer.php");
                ?>
