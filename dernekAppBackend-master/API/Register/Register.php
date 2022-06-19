<?php
/**
 * Register database actions.
 */
class RegisterAccount
{

  public function __construct($db)
  {
      $this->db = $db;
  }
  public function Control($phone){
    $control = $this->db->prepare("SELECT `id` FROM `users` WHERE `phone_number` = :phone_number AND `isDeleted` = 0");
    $control->execute([
      ":phone_number" => $phone
    ]);
    return ($control->rowCount() > 0) ? false : true;
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
  public function Create($data){
    if(self::Control($data->phone_number) == false){
      return ["type" => false, "message" => "Girdiğiniz telefon numarası ile zaten bir hesap oluşturulmuş."];
    }
    $insert = $this->db->prepare("INSERT INTO `users` (`id`, `phone_number`, `password`, `register_date`, `register_ip`,
    `last_join_time`, `last_join_ip`) VALUES
    (NULL, :phone_number, :password, :curr_time, :user_ip, :curr_time, :user_ip)");
    $insert->execute([
      ":phone_number" => $data->phone_number,
      ":password" => md5(sha1($data->password)),
      ":curr_time" => time(),
      ":user_ip" => self::GetUserIP()
    ]);

    $user_id = $this->db->lastInsertId();

    $insert_profile = $this->db->prepare("INSERT INTO `profile_data` (`id`, `user_id`, `name`, `surname`) VALUES
    (NULL, :user_id, :name, :surname)");
    $insert_profile->execute([
      ":user_id" => $user_id,
      ":name" => $data->name,
      ":surname" => $data->surname
    ]);

    return ["type" => true, "message" => "Başarıyla kayıt oldunuz. Lütfen bekleyin.."];
  }

}



 ?>
