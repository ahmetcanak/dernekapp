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
    Data içeriği: type = list
  */
  if(!isset($data->type)){
      echo json_encode($api->returnVeriable(false,"Eksik parametreler mevcut."));
      exit;
  }

 if($data->type != "list"){
    echo json_encode($api->returnVeriable(false,"Parametre değeri hatalı."));
    exit;
  }

  echo json_encode($api->FinishAPI($data, "NOTIFICATIONS"));
  exit;
} else {
  echo json_encode($controller);
  exit;
}

 ?>
