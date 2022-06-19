<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
/**
 * Login database control and generate key actions.
 */
class GenerateNotifications
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
    return ($control->rowCount() > 0) ? true : false;
  }


  public function EditLogs($logs){
    $new_logs = [];
    $generalSettings = self::GetGeneralSettings();
    foreach($logs as $log){
      $log["sended_time"] = date("d/m/Y H:i", $log["sended_time"]);
      $log["id"] = (int)$log["id"];
      $log["image"] = $log["image"] != null ? $generalSettings["url"].$log["image"] : null;
      $new_logs[] = $log;
    }
    return $new_logs;
  }

  public function GetGeneralSettings(){
    $query = $this->db->prepare("SELECT * FROM `settings` WHERE `id` = :id");
    $query->execute(["id" => 1]);
    $data = $query->fetch();
    return $data;
  }


  public function GetLogs($data, $decoded){
    $grouped = false;
    if(!isset($decoded->phone_number) || !isset($decoded->password)){
      return ["type" => false, "message" => "Authorization içersinde bazı parametreler tanımsız."];
    }
    if(self::Control($decoded->phone_number, $decoded->password) == false){
      return ["type" => false, "message" => "Telefon numarası veya şifre hatalı. Lütfen tekrar giriş yapın."];
    }

    $All = $this->db->prepare("SELECT `id`, `title`, `text`, `image`, `sended_time` FROM `notifications` WHERE `isDeleted` = 0 ORDER BY `id` DESC LIMIT 50");
    $All->execute();
    $All = $All->fetchAll(PDO::FETCH_ASSOC);
    $All = self::EditLogs($All);
      return ["type" => true, "message" => "Son 50 bildirim gösteriliyor.", "data" => $All];
  }

}



 ?>
