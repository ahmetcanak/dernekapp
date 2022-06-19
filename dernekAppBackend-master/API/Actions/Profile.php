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
    Data içeriği: type = information
    koşullar:
    type string (information veya update)

    eğer update ise:
    şayet gelen değer boşssa veya değişken gelmiyorsa null olarak güncellenir. zorunlu gelmesi gerekenler belirtilmiştir.
    işlem bitince key oluşturulur. bu keyi diğer key ile dğeiştirmen gerekecek. telefon numarası değişmesezse key aynı kalacak ve yine de key dönecek.
    formda telefon numarasını disable bırakıp işlem yaptırabilirsin.
    eğer numara değişirse kontrol ediyor varsa hata yoksa keyi de güncelliyor.
    `tc_id` = :tc_id, (zorunlu)
    `email` = :email, (zorunlu değil. giriş yapılırsa email formatı zorunlu girilmezse np)
    `name` = :name, (zorunlu)
    `surname` = :surname, (zorunlu)
    `birth_date` = :birth_date,
    `education_status` = :education_status, (zorunlu) (select ile gönder min İlkokul)
    `job` = :job,
    `blood_group` = :blood_group, (zorunlu) (select ile)
    `father_name` = :father_name,
    `mother_name` = :mother_name,
    `mothers_father_name` = :mothers_father_name,
    `village_nickname` = :village_nickname, (zorunlu)
    `village_neighborhood` = :village_neighborhood, (zorunlu)
    `home_address` = :home_address,
    `job_address` = :job_address,
    `job_phone` = :job_phone,
    `home_phone` = :home_phone,
    `spouse_name` = :spouse_name,
    `spouse_blood_group` = :spouse_blood_group,
    `spouse_father` = :spouse_father

  */
  if(!isset($data->type)){
      echo json_encode($api->returnVeriable(false,"Eksik parametreler mevcut."));
      exit;
  }

  if($data->type != "update" && $data->type != "information"){
      echo json_encode($api->returnVeriable(false,"Parametre değeri hatalı."));
      exit;
  } else if($data->type == "update"){
    if(!isset($data->name) || strlen($data->name) < 2 || strlen($data->name) > 64){
      echo json_encode($api->returnVeriable(false,"Lütfen adınızı girin."));
      exit;
    }

    if(!isset($data->surname) || strlen($data->surname) < 2 || strlen($data->surname) > 64){
      echo json_encode($api->returnVeriable(false,"Lütfen soyadınızı girin."));
      exit;
    }

    if(!isset($data->phone_number) ||strlen($data->phone_number) != 10 || !is_numeric($data->phone_number)){
      echo json_encode($api->returnVeriable(false,"Lütfen telefon numaranızı kontrol edin."));
      exit;
    }

    if(!isset($data->village_nickname) || strlen($data->village_nickname) == 0){
      echo json_encode($api->returnVeriable(false,"Lütfen köydeki lakabınızı girin."));
      exit;
    }

    if(!isset($data->village_neighborhood) || strlen($data->village_neighborhood) == 0){
      echo json_encode($api->returnVeriable(false,"Lütfen köydeki mahallenizi girin."));
      exit;
    }

    if(!isset($data->tc_id) || strlen($data->tc_id) != 11 || !is_numeric($data->tc_id)){
      echo json_encode($api->returnVeriable(false,"Lütfen geçerli bir TC kimlik numarası girin."));
      exit;
    }

     if(!isset($data->education_status) || $data->education_status != "İlkokul" &&
        $data->education_status != "Ortaokul" &&
        $data->education_status != "Lise" &&
        $data->education_status != "Ön Lisans" &&
        $data->education_status != "Lisans" &&
        $data->education_status != "Yüksek Lisans" &&
        $data->education_status != "Doktora"){
          echo json_encode($api->returnVeriable(false,"Geçersiz tahsil değeri."));
          exit;
        }

        if(!isset($data->blood_group) || $data->blood_group != "Bilinmiyor" &&
           $data->blood_group != "0-" &&
           $data->blood_group != "0+" &&
           $data->blood_group != "A-" &&
           $data->blood_group != "A+" &&
           $data->blood_group != "B-" &&
           $data->blood_group != "B+" &&
           $data->blood_group != "AB-" &&
           $data->blood_group != "AB+"){
             echo json_encode($api->returnVeriable(false,"Geçersiz kan grubu değeri."));
             exit;
           }

  }

  echo json_encode($api->FinishAPI($data, "PROFILE"));
  exit;
} else {
  echo json_encode($controller);
  exit;
}

 ?>
