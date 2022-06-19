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
    Data içeriği: type = list, id = null, start, length, category_ids
    koşullar:
    type string (all veya detail)
    id: type detail olmak koşuluyla integer haricinde sabiti null
    start: type all olmak koşuluyla integer haricinde sabiti null
    length: type all olmak koşuluyla integer haricinde sabiti null
    category_ids: type all olmak koşuluyla array. veri gönderilmeyebilir. gönderilmezse tüm kategoriler çıkar.

    örneğin: domain/path/API/News
    body:
    {
    type:"list",
    "start": 0,
    length: 10
  }
  return: {
  "haber_listesi"..
}
##########
body:
{
type:"detail",
id: 14
}

return: {
"haber_detayi"..
}
  */
  if(!isset($data->type)){
      echo json_encode($api->returnVeriable(false,"Eksik parametreler mevcut."));
      exit;
  }

  if($data->type == "detail"){
    if(!isset($data->id) || !is_int($data->id)){
      echo json_encode($api->returnVeriable(false,"Haber ID'si tanımsız."));
      exit;
    }
  } else if($data->type == "list"){
    if(!isset($data->start) || !is_int($data->start) || !isset($data->length) || !is_int($data->length)){
      echo json_encode($api->returnVeriable(false,"Başlangıç ve uzunluk değerleri eksik."));
      exit;
    }
  } else {
    echo json_encode($api->returnVeriable(false,"Parametre değeri hatalı."));
    exit;
  }

  echo json_encode($api->FinishAPI($data, "NEWS"));
  exit;
} else {
  echo json_encode($controller);
  exit;
}

 ?>
