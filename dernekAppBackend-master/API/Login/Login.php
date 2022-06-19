<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
/**
 * Login database control and generate key actions.
 */
class LoginAccount
{

  public function __construct($db)
  {
      $this->db = $db;
  }
  public function Control($phone, $password){
    $control = $this->db->prepare("SELECT `id` FROM `users` WHERE `phone_number` = :phone_number AND `password` = :password AND `isDeleted` = 0");
    $control->execute([
      ":phone_number" => $phone,
      ":password" => md5(sha1($password))
    ]);
    return ($control->rowCount() > 0) ? true : false;
  }

  public function GetUserIP()
  {
    // Get real visitor IP behind CloudFlare network
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
              $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
              $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}
  public function Login($data){
    if(self::Control($data->phone_number, $data->password) == false){
      return ["type" => false, "message" => "Telefon numarası veya şifre hatalı."];
    }
    $update = $this->db->prepare("UPDATE `users` SET
    `last_join_time` = :curr_time, `last_join_ip` = :user_ip WHERE `phone_number` = :phone_number AND `password` = :password AND `isDeleted` = 0");
    $update->execute([
      ":phone_number" => $data->phone_number,
      ":password" => md5(sha1($data->password)),
      ":curr_time" => time(),
      ":user_ip" => self::GetUserIP()
    ]);

    return ["type" => true, "message" => "Giriş başarılı."];
  }

}



 ?>
