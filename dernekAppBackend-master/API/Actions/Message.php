<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
include("../APIManager.php");
$api = new APIManager;
$data = [];
$data["type"] = isset($_POST["type"]) ? $_POST["type"] : null;
$data["subject"] = isset($_POST["subject"]) ? $_POST["subject"] : null;
$data["message"] = isset($_POST["message"]) ? $_POST["message"] : null;
$data = json_encode($data);

$controller = $api->StartAPI($data);
if($controller["type"]){
  $data = json_decode($data);
  /*
    Data içeriği: subject, message, image
    koşullar:
    subject en az 5 en fazla 50 karakter
    message: en az 10 en fazla 1000 karakter
  */
  $data->image = null;
  if(isset($_FILES["image"])){
    require "../../libraries/upload/Upload.php";
    $image = new Upload($_FILES['image']);
    $image_name = time().uniqid();
     if ($image->uploaded){
       $image->allowed = array ( 'image/*' );
       $image->file_new_name_body = "MESSAGE_".$image_name;
       $image->Process('../../uploads/messages/big/');
       if (!$image->processed){
          echo json_encode($api->returnVeriable(false,"Lütfen geçerli bir resim dosyası yükleyin."));
          exit;
       } else {
         $data->image = $image->file_dst_path . $image->file_dst_name;
       }

     }
  }
  $data->image = ($data->image != null) ? str_replace("../../", "", $data->image) : null;

  if(!isset($data->subject) || !isset($data->message)){
      echo json_encode($api->returnVeriable(false,"Eksik parametreler mevcut."));
      exit;
  }


  if(strlen($data->subject) < 5 || strlen($data->subject) > 256){
    echo json_encode($api->returnVeriable(false,"Lütfen en az 5 en fazla 256 karakterden oluşan bir konu girin."));
    exit;
  }

  if(strlen($data->message) < 10 || strlen($data->message) > 1000){
    echo json_encode($api->returnVeriable(false,"Lütfen en az 10 en fazla 1000 karakterden oluşan bir mesaj girin."));
    exit;
  }

  echo json_encode($api->FinishAPI($data, "MESSAGE"));
  exit;
} else {
  echo json_encode($controller);
  exit;
}

 ?>
