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
    Data içeriği: name, surname, password, phone_number
    koşullar:

    name: en az 2 en fazla 64 str
    surname: en az 2 en fazla 64 str
    password: en az 5 en fazla 256
    phone_number 10 haneli int
  */
  if(!isset($data->name) || !isset($data->surname) || !isset($data->password) || !isset($data->phone_number)){
      echo json_encode($api->returnVeriable(false,"Eksik parametreler mevcut."));
      exit;
  }

  if(strlen($data->name) < 2 || strlen($data->name) > 64){
    echo json_encode($api->returnVeriable(false,"Lütfen adınızı kontrol edin."));
    exit;
  }

  if(strlen($data->surname) < 2 || strlen($data->surname) > 64){
    echo json_encode($api->returnVeriable(false,"Lütfen soyadınızı kontrol edin."));
    exit;
  }

  if(strlen($data->password) < 5){
    echo json_encode($api->returnVeriable(false,"Lütfen en az 5 haneden oluşan bir şifre seçin."));
    exit;
  }

  if(strlen($data->password) > 256){
    echo json_encode($api->returnVeriable(false,"Sence de şifren biraz uzun değil mi?"));
    exit;
  }

  if(strlen($data->phone_number) != 10 || !is_numeric($data->phone_number)){
    echo json_encode($api->returnVeriable(false,"Lütfen telefon numaranızı kontrol edin."));
    exit;
  }
  
  echo json_encode($api->FinishAPI($data, "REGISTER"));
  exit;
} else {
  echo json_encode($controller);
  exit;
}

 ?>
