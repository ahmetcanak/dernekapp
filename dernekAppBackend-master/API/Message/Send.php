<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
/**
 * Message sender
 */
class GenerateMessage
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



  public function SendMessage($data, $decoded){
    if(!isset($decoded->phone_number) || !isset($decoded->password)){
      return ["type" => false, "message" => "Authorization içersinde bazı parametreler tanımsız."];
    }
    $control = self::Control($decoded->phone_number, $decoded->password);
    if($control["status"] == false){
      return ["type" => false, "message" => "Telefon numarası veya şifre hatalı. Lütfen tekrar giriş yapın."];
    }
    
    //$account_data = self::GetUserData($control["user_id"]);
    $query = $this->db->prepare("INSERT INTO `messages` (`id`, `user_id`, `subject`, `message_text`, `message_images`, `sended_time`, `status`, `isDeleted`) VALUES
     (NULL, :user_id, :subject, :message, :image, :sended_time, '0', '0')");
     $query->execute([":user_id" => $control["user_id"],
      ":subject" => $data->subject,
      ":message" => $data->message,
      ":image" => $data->image,
      ":sended_time" => time()]);
    //$account_data = array_values();
      return ["type" => true, "message" => "Mesaj başarıyla gönderildi."];
  }

}



 ?>
