<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
include("../APIManager.php");
$api = new APIManager;
$data = file_get_contents('php://input');
$controller = $api->StartAPI($data);
if($controller["type"]){
  $data = json_decode($data);
  /*
    Data içeriği: password, phone_number
    koşullar:
    phone_number 10 haneli int
    password: en az 5 en fazla 256
  */
  if(!isset($data->password) || !isset($data->phone_number)){
      echo json_encode($api->returnVeriable(false,"Eksik parametreler mevcut."));
      exit;
  }


  if(strlen($data->password) < 5 || strlen($data->password) > 256 || strlen($data->phone_number) != 10 || !is_numeric($data->phone_number)){
    echo json_encode($api->returnVeriable(false,"Giriş başarısız."));
    exit;
  }

  echo json_encode($api->FinishAPI($data, "LOGIN"));
  exit;
} else {
  echo json_encode($controller);
  exit;
}

 ?>
