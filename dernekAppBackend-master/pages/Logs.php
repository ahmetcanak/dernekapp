<?php
  error_reporting(E_ALL);
  ini_set("display_errors",1);
   require "../libraries/main/Main.php";
   require "../libraries/database/Management.php";
   $connection = new ManageConnection($database);
   if(!$connection->HasConnection()){
     sleep(1);
     header("Location: ./login");
     exit;
   }
   if (!$connection->AuthorizationControl("show_logs"))
   {
       echo json_encode(["status" => false, "message" => "Bu işlem için yetkiniz yok."]);
       exit;
   }
     require "../libraries/logs/List.php";
     $ManageLogs = new ManageLogs($database);
     $footer_scripts = [];
     $header_css = [];
     $header_css[] =  'assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css';
     $header_css[] =  'assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css';
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
     $footer_scripts[] = 'assets/js/app/logs.js?v=05.0';

   $user = $connection->User();
   include("./include/header.php");
   echo $ManageLogs->write();
   if(!$connection->AuthorizationControl("export_data")){
     $footer_scripts[] = 'assets/js/app/remove_exports.js';
   }
   ?>


                <!-- End Page-content -->
                <?php
      include("./include/footer.php");
                ?>
