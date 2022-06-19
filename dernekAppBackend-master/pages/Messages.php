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
   if($_GET["action"] != "list" && $_GET["action"] != "detail" && $_GET["action"] != "delete"){
     sleep(1);
     header("Location: ./dashboard");
     exit;
   }
   if($_GET["action"] == "list")
   {
     if (!$connection->AuthorizationControl("read_messages"))
     {
         echo  json_encode(["status" => false, "message" => "Bu işlem için yetkiniz yok."]);
         exit;
     }
     
     require "../libraries/messages/List.php";
     $ManageMessages = new ManageMessages($database);
     if (!$connection->AuthorizationControl("read_messages"))
     {
         echo  json_encode(["status" => false, "message" => "Bu işlem için yetkiniz yok."]);
         exit;
     }
     $footer_scripts = [];
     $header_css = [];
     $header_css[] = 'assets/libs/sweetalert2/sweetalert2.min.css';
     $footer_scripts[] = 'assets/libs/sweetalert2/sweetalert2.min.js';
     $footer_scripts[] = 'assets/js/app/messages.js';
   }
   if($_GET["action"] == "detail"){
     if (!$connection->AuthorizationControl("read_messages"))
     {
         echo  json_encode(["status" => false, "message" => "Bu işlem için yetkiniz yok."]);
         exit;
     }
     require "../libraries/messages/Detail.php";
     $footer_scripts = [];
     $header_css = [];
     $header_css[] = 'assets/libs/sweetalert2/sweetalert2.min.css';
     $footer_scripts[] = 'assets/libs/sweetalert2/sweetalert2.min.js';
     $footer_scripts[] = 'assets/js/app/read-message.js?v=2.0';
     $explode_id = explode("?id=", $_SERVER["REQUEST_URI"]);
     $id = isset($explode_id[1]) ? $explode_id[1] : false;
     if($id === false || is_numeric($id) == false){
       echo json_encode(["status" => false, "message" => "Eksik parametreler mevcut."]);
       exit;
     }
     $ManageMessages = new ManageMessages($database,$id);
     if($ManageMessages->Control() == false){
       echo json_encode(["status" => false, "message" => "Mesaj bulunamadı."]);
       exit;
     }
     if(!$ManageMessages->Readed()){
       $connection->WriteLog("#$id numaralı mesajı okudu.");
     }
   }
   if($_GET["action"] == "delete"){
     require "../libraries/messages/Delete.php";
     $ManageMessages = new ManageMessages($database);
     if (!$connection->AuthorizationControl("delete_messages"))
     {
         echo  json_encode(["status" => false, "message" => "Bu işlem için yetkiniz yok."]);
         exit;
     }
     $explode_id = explode("?ids=", $_SERVER["REQUEST_URI"]);
     $ids = isset($explode_id[1]) ? $explode_id[1] : false;
     if($ids === false){
       echo json_encode(["status" => false, "message" => "Eksik parametreler mevcut."]);
       exit;
     }
     $ids = explode(",",$ids);
     $delete_status = $ManageMessages->delete($ids);
     if($delete_status["status"]){
       foreach($delete_status["deleted_list"] as $id){
         $connection->WriteLog("#$id numaralı mesajı sildi.");
       }
     }
     echo json_encode($delete_status);

     exit;
   }

   $user = $connection->User();
   include("./include/header.php");
   echo $ManageMessages->write();
   ?>


                <!-- End Page-content -->
                <?php
      include("./include/footer.php");
                ?>
