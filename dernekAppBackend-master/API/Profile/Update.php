<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
/**
 * Profile information Manager
 */
class UpdateProfile
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
  public function ControlAnotherNumber($phone){
      $control = $this->db->prepare("SELECT `id` FROM `users` WHERE `phone_number` = :phone_number AND `isDeleted` = 0");
      $control->execute([
        ":phone_number" => $phone
      ]);
      $data = $control->fetch();
    return ($data) ? true : false;
  }

  public function UpdateAction($data, $decoded){
    if(!isset($decoded->phone_number) || !isset($decoded->password)){
      return ["type" => false, "message" => "Authorization içersinde bazı parametreler tanımsız."];
    }
    $control = self::Control($decoded->phone_number, $decoded->password);
    if($control["status"] == false){
      return ["type" => false, "message" => "Telefon numarası veya şifre hatalı. Lütfen tekrar giriş yapın."];
    }
    if($data->phone_number != $decoded->phone_number){
      //Dbde arat. yoksa güncelle.
      if(self::ControlAnotherNumber($data->phone_number)){
        return ["type" => false, "message" => "Girmiş olduğunuz telefon numarası başka bir kullanıcı tarafından kullanılıyor."];
      }

      $updateUser = $this->db->prepare("UPDATE `users` SET `phone_number` = :phone_number WHERE `id` = :id AND `isDeleted` = 0");
      $updateUser->execute([":phone_number" => $data->phone_number, ":id" => $control["user_id"]]);

    }
    //$control["user_id"]

    $data->birth_date = isset($data->birth_date) && $data->birth_date != "" ? $data->birth_date : null;
    $data->email = isset($data->email) && $data->email != "" ? $data->email : null;
    $data->job = isset($data->job) && $data->job != "" ? $data->job : null;
    $data->father_name = isset($data->father_name) && $data->father_name != "" ? $data->father_name : null;
    $data->mother_name = isset($data->mother_name) && $data->mother_name != "" ? $data->mother_name : null;
    $data->mothers_father_name = isset($data->mothers_father_name) && $data->mothers_father_name != "" ? $data->mothers_father_name : null;
    $data->home_address = isset($data->home_address) && $data->home_address != "" ? $data->home_address : null;
    $data->job_address = isset($data->job_address) && $data->job_address != "" ? $data->job_address : null;
    $data->job_phone = isset($data->job_phone) && $data->job_phone != "" ? $data->job_phone : null;
    $data->home_phone = isset($data->home_phone) && $data->home_phone != "" ? $data->home_phone : null;
    $data->spouse_blood_group = isset($data->spouse_blood_group) && $data->spouse_blood_group != "" ? $data->spouse_blood_group : null;
    $data->spouse_name = isset($data->spouse_name) && $data->spouse_name != "" ? $data->spouse_name : null;
    $data->spouse_father = isset($data->spouse_father) && $data->spouse_father != ""  ?  $data->spouse_father : null;

    if($data->birth_date != null){
      $data->birth_date = implode("-", array_reverse(explode("/", $data->birth_date)));
      $data->birth_date = strtotime($data->birth_date);
    }

    if($data->email != null){
      if(!filter_var($data->email, FILTER_VALIDATE_EMAIL)){
        return ["type" => false, "message" => "Lütfen geçerli bir E-Posta adresi girin."];
      }
    }

    if(!isset($data->childrens) || is_array($data->childrens) == false){
      return ["type" => false, "message" => "Çocuk verileri geçerli formatta gönderilmemiş."];
    }



    for($i = 0; $i < count($data->childrens); $i++){
      $child = $data->childrens[$i];
      if(!isset($child->name) || !isset($child->surname) || !isset($child->birth_date) || !isset($child->marital_status)
      || !isset($child->job) || !isset($child->blood_group) || !isset($child->education_status) || !isset($child->phone_number)
      || ltrim(rtrim($child->name)) == "" || ltrim(rtrim($child->surname)) == "" || ltrim(rtrim($child->marital_status)) == ""
      || ltrim(rtrim($child->job)) == ""){
        return ["type" => false, "message" => "Lütfen çocuklar listesinde tüm formu doldurun."];
      }
      if(strlen($child->phone_number) != 10 || !is_numeric($child->phone_number)){
        return ["type" => false, "message" => "Lütfen çocuklar listesinde girilen telefon numarasını kontrol edin."];
      }
    }
    $deleteChilds = $this->db->prepare("UPDATE `children_list` SET `isDeleted` = :isDeleted WHERE `parent_id` = :parent_id");
    $deleteChilds->execute([":isDeleted"=> 1, ":parent_id" => $control["user_id"]]);

    for($i = 0; $i < count($data->childrens); $i++){
      $child = $data->childrens[$i];
      $child->birth_date = implode("-", array_reverse(explode("/", $child->birth_date)));
      $child->birth_date = strtotime($child->birth_date);
      $insertChild = $this->db->prepare("INSERT INTO `children_list` (`id`, `parent_id`, `name`, `surname`, `birth_date`, `marital_status`,
         `job`, `blood_group`, `education_status`, `phone_number`, `isDeleted`) VALUES (NULL,
        :parent_id, :name, :surname, :birth_date, :marital_status, :job, :blood_group, :education_status, :phone_number, :isDeleted)");
        $insertChild->execute([
          ":parent_id" => $control["user_id"],
          ":name" => $child->name,
          ":surname" => $child->surname,
          ":birth_date" => $child->birth_date,
          ":marital_status" => $child->marital_status,
          ":job" => $child->job,
          ":blood_group" => $child->blood_group,
          ":education_status" => $child->education_status,
          ":phone_number" => $child->phone_number,
          ":isDeleted" => 0
        ]);
    }


    $update = $this->db->prepare("UPDATE `profile_data` SET
      `tc_id` = :tc_id,
      `email` = :email,
      `name` = :name,
      `surname` = :surname,
      `birth_date` = :birth_date,
      `education_status` = :education_status,
      `job` = :job,
      `blood_group` = :blood_group,
      `father_name` = :father_name,
      `mother_name` = :mother_name,
      `mothers_father_name` = :mothers_father_name,
      `village_nickname` = :village_nickname,
      `village_neighborhood` = :village_neighborhood,
      `home_address` = :home_address,
      `job_address` = :job_address,
      `job_phone` = :job_phone,
      `home_phone` = :home_phone,
      `spouse_name` = :spouse_name,
      `spouse_blood_group` = :spouse_blood_group,
      `spouse_father` = :spouse_father
      WHERE `user_id` = :user_id
    ");

    $update->execute([
      ":tc_id" => $data->tc_id,
      ":email" => $data->email,
      ":name" => $data->name,
      ":surname" => $data->surname,
      ":birth_date" => $data->birth_date,
      ":education_status" => $data->education_status,
      ":job" => $data->job,
      ":blood_group" => $data->blood_group,
      ":father_name" => $data->father_name,
      ":mother_name" => $data->mother_name,
      ":mothers_father_name" => $data->mothers_father_name,
      ":village_nickname" => $data->village_nickname,
      ":village_neighborhood" => $data->village_neighborhood,
      ":home_address" => $data->home_address,
      ":job_address" => $data->job_address,
      ":job_phone" => $data->job_phone,
      ":home_phone" => $data->home_phone,
      ":spouse_blood_group" => $data->spouse_blood_group,
      ":spouse_name" => $data->spouse_name,
      ":spouse_father" => $data->spouse_father,
      ":user_id" => $control["user_id"]
    ]);
      return ["type" => true, "message" => "Profil başarıyla güncellendi.", "phone_number" => $data->phone_number, "password" => $decoded->password];
  }

}



 ?>
