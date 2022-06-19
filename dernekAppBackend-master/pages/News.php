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
     if (!$connection->AuthorizationControl("add_news"))
     {
         echo  json_encode(["status" => false, "message" => "Bu işlem için yetkiniz yok."]);
         exit;
     }
     require "../libraries/news/List.php";
     $ManageNews = new ManageNews($database);
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
     $footer_scripts[] = 'assets/js/app/list-news.js?v=36.0';
   }
   if($_GET["action"] == "add"){
     if (!$connection->AuthorizationControl("add_news"))
     {
         echo  json_encode(["status" => false, "message" => "Bu işlem için yetkiniz yok."]);
         exit;
     }
     require "../libraries/news/Add.php";
     $ManageNews = new ManageNews($database);
     $footer_scripts = [];
     $header_css = [];
     $header_css[] = 'assets/libs/sweetalert2/sweetalert2.min.css';
     $footer_scripts[] = 'assets/libs/sweetalert2/sweetalert2.min.js';
     $footer_scripts[] = 'assets/js/app/add-news.js';
     if(isset($_POST["add_action"])){
       require "../libraries/upload/Upload.php";
       $image = new Upload($_FILES['newsImage']);
       $image_name = time().uniqid();
        if ($image->uploaded){
          $image->allowed = array ( 'image/*' );
          $image->file_new_name_body = "BIG_".$image_name;
          $image->Process('../uploads/news/big/');
          if (!$image->processed){
             echo json_encode(["status" => false, "message" => "Lütfen geçerli bir resim yükleyin."]);
             exit;
          } else {
            $big_image = $image->file_dst_path . $image->file_dst_name;
          }
          $image->file_new_name_body = 'SMALL_'.$image_name;
          $image->image_convert = 'jpg';
          $image->image_resize = true;
          $image->image_ratio_crop = true;
          $image->image_x = 640;
          $image->image_y = 640;
          $image->Process('../uploads/news/small/');
          if (!$image->processed){
             echo json_encode(["status" => false, "message" => "Lütfen geçerli bir resim yükleyin."]);
             exit;
          } else {
            $small_image = $image->file_dst_path . $image->file_dst_name;
          }
        }
        $status = $ManageNews->Insert($_POST, $small_image, $big_image);
        if($status["status"] == false){
           echo json_encode($status);
        } else {
          echo json_encode(["status" => true, "message" => "Haber başarıyla eklendi"]);
          $id = $status["id"];
          $connection->WriteLog("#$id numaralı haberi oluşturdu.");
        }

       exit;
     }
   }
   if($_GET["action"] == "detail"){
     if (!$connection->AuthorizationControl("add_news"))
     {
         echo  json_encode(["status" => false, "message" => "Bu işlem için yetkiniz yok."]);
         exit;
     }
     require "../libraries/news/Detail.php";
     $footer_scripts = [];
     $header_css = [];
     $header_css[] = 'assets/libs/sweetalert2/sweetalert2.min.css';
     $footer_scripts[] = 'assets/libs/sweetalert2/sweetalert2.min.js';
     $footer_scripts[] = 'assets/js/app/detail-news.js?v=0.1';
     $explode_id = explode("?id=", $_SERVER["REQUEST_URI"]);
     $id = isset($explode_id[1]) ? $explode_id[1] : false;
     if($id === false || is_numeric($id) == false){
       echo json_encode(["status" => false, "message" => "Eksik parametreler mevcut."]);
       exit;
     }
     $ManageNews = new ManageNews($database,$id);
     if($ManageNews->Control() == false){
       echo json_encode(["status" => false, "message" => "Haber bulunamadı."]);
       exit;
     }
     if(isset($_POST["update_action"])){
       $big_image = "current";
       $small_image = "current";
       if(isset($_FILES['newsImage'])) {
         require "../libraries/upload/Upload.php";
         $image = new Upload($_FILES['newsImage']);
         $image_name = time().uniqid();
          if ($image->uploaded){
            $image->allowed = array ( 'image/*' );
            $image->file_new_name_body = "BIG_".$image_name;
            $image->Process('../uploads/news/big/');
            if (!$image->processed){
               echo json_encode(["status" => false, "message" => "Lütfen geçerli bir resim yükleyin."]);
               exit;
            } else {
              $big_image = $image->file_dst_path . $image->file_dst_name;
            }
            $image->file_new_name_body = 'SMALL_'.$image_name;
            $image->image_convert = 'jpg';
            $image->image_resize = true;
            $image->image_ratio_crop = true;
            $image->image_x = 640;
            $image->image_y = 640;
            $image->Process('../uploads/news/small/');
            if (!$image->processed){
               echo json_encode(["status" => false, "message" => "Lütfen geçerli bir resim yükleyin."]);
               exit;
            } else {
              $small_image = $image->file_dst_path . $image->file_dst_name;
            }
          }
       }

        $status = $ManageNews->Update($_POST, $small_image, $big_image,$id);
        if($status["status"] == false){
           echo json_encode($status);
        } else {
          echo json_encode(["status" => true, "message" => "Haber başarıyla güncellendi.", "time" => $status["time"]]);
          $id = $status["id"];
          $connection->WriteLog("#$id numaralı haberi güncelledi.");
        }
       exit;
     }
   }
   if($_GET["action"] == "delete"){
     require "../libraries/news/Delete.php";
     $ManageNews = new ManageNews($database);
     if (!$connection->AuthorizationControl("delete_news"))
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
     $delete_status = $ManageNews->delete($id);
     if($delete_status["status"]){
       $connection->WriteLog("#$id numaralı haberi sildi.");
     }
     echo json_encode($delete_status);

     exit;
   }

   $user = $connection->User();
   include("./include/header.php");
   echo $ManageNews->write();
   if($_GET["action"] == "list" && !$connection->AuthorizationControl("export_data")){
     $footer_scripts[] = 'assets/js/app/remove_exports.js';
   }
   ?>


                <!-- End Page-content -->
                <?php
      include("./include/footer.php");
                ?>
