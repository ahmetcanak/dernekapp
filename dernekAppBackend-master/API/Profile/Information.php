<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
/**
 * Profile information Manager
 */
class GetProfile
{

  public function __construct($db)
  {
      $this->db = $db;
  }
  public function Control($phone, $password){
      $control = $this->db->prepare("SELECT `id` FROM `users` WHERE `phone_number` = :phone_number AND `password` = :password AND `isDeleted` = 0");
      $control->execute([
        ":phone_number" => $phone,
        ":password" => $password
      ]);
      $data = $control->fetch();
    return ($data) ? ["status" => true, "user_id" => $data["id"]] : ["status" => false];
  }


  public function GetUserData($user_id){
    $control = $this->db->prepare("SELECT `users`.`phone_number`,
      `profile_data`.*  FROM `users` AS `users`
      LEFT JOIN `profile_data` AS `profile_data`
      ON `users`.`id` = `profile_data`.`user_id` WHERE `users`.`id` = :user_id");
    $control->execute([
      ":user_id" => $user_id
    ]);
    $data = $control->fetch();
    return ($data) ? $data : false;
  }

  public function GetChilds($user_id){
    $query = $this->db->prepare("SELECT `name`, `surname`, `birth_date`, `marital_status`, `job`, `blood_group`, `education_status`, `phone_number`
    FROM `children_list` WHERE `parent_id` =:parent_id AND `isDeleted` = 0");
    $query->execute([":parent_id" => $user_id]);
    $data = $query->fetchAll(PDO::FETCH_ASSOC);
    $edited_data = [];
    foreach($data as $q){
      $a = [];
      $a["name"] = $q["name"];
      $a["surname"] = $q["surname"];
      $a["birth_date"] = date("d/m/Y", $q["birth_date"]);
      $a["marital_status"] = $q["marital_status"];
      $a["job"] = $q["job"];
      $a["blood_group"] = $q["blood_group"];
      $a["education_status"] = $q["education_status"];
      $a["phone_number"] = $q["phone_number"];
      $edited_data[] = $a;
    }
    return $edited_data;
  }

  public function GetUserInformation($data, $decoded){
    if(!isset($decoded->phone_number) || !isset($decoded->password)){
      return ["type" => false, "message" => "Authorization içersinde bazı parametreler tanımsız."];
    }
    $control = self::Control($decoded->phone_number, $decoded->password);
    if($control["status"] == false){
      return ["type" => false, "message" => "Telefon numarası veya şifre hatalı. Lütfen tekrar giriş yapın."];
    }
    $account_data = self::GetUserData($control["user_id"]);
    $account_data["birth_date"] = date("d/m/Y", $account_data["birth_date"]);
    unset($account_data["id"]);
    $account_data["childs"] = self::GetChilds($control["user_id"]);
    //$account_data = array_values();
      return ["type" => true, "message" => "Profil bilgileri listeleniyor.", "data" => $account_data];
  }

}



 ?>
