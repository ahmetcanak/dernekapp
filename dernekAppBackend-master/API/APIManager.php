<?php

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../libraries/decoder/BeforeValidException.php';
include_once '../../libraries/decoder/ExpiredException.php';
include_once '../../libraries/decoder/SignatureInvalidException.php';
include_once '../../libraries/decoder/JWT.php';
use \Firebase\JWT\JWT;
  /**
   *
   */
  class APIManager
  {
    public function __construct(){
      $this->key = "NdZ$+c!M9&;x_]L.";
    }

    public function StartAPI($data){
      if(self::JSONController($data) == false){
        return self::returnVeriable(false,"Eksik parametreler mevcut.");
      }
      //Olur da başka kontroller eklenirse ...
      return self::returnVeriable(true);
    }

    public function JSONController($str){
     $json = json_decode($str);
     return $json && $str != $json;
    }

    public function returnVeriable($type,$message = null, $data = []){
      return ($type == false) ? ["type" => $type, "message" => $message] : ["type" => $type, "message" => $message, "data" => $data];
    }

    public function FinishAPI($data, $type){
      include("../../libraries/database/Management.php");
      if($type == "REGISTER"){
        include("Register/Register.php");
        $register = new RegisterAccount($database);
        $status = $register->Create($data);
        if($status["type"]){
          $status["data"]["key"] = self::GenerateToken($data);
        }
          return $status;
      } else if($type == "LOGIN"){
        include("Login/Login.php");
        $login = new LoginAccount($database);
        $status = $login->Login($data);
        if($status["type"]){
          $status["data"]["key"] = self::GenerateToken($data);
        }
        return $status;
      } else if($type == "NEWS"){
        if(!self::APIConnectionControl()){
          return self::returnVeriable(false,"Kimlik doğrulaması gerekli.");
        }
        $headers = apache_request_headers();
        $key = $headers['Authorization'];
        $decoded = self::DecodeToken($key);
        if(!$decoded["status"]){
          return self::returnVeriable(false, $decoded["message"]);
        }
        if($data->type == "list"){
          include("News/List.php");
          $news = new GenerateNews($database);
          return $news->GetNews($data,$decoded["decoded"]);
        } else if($data->type == "detail"){
          include("News/Detail.php");
          $news = new NewsInformation($database);
          return $news->GetNewsInformation($data,$decoded["decoded"]);
        } else {
          return self::returnVeriable(false,"Eksik parametreler mevcut.");
        }
      } else if($type == "PROFILE"){
        if(!self::APIConnectionControl()){
          return self::returnVeriable(false,"Kimlik doğrulaması gerekli.");
        }
        $headers = apache_request_headers();
        $key = $headers['Authorization'];
        $decoded = self::DecodeToken($key);
        if(!$decoded["status"]){
          return self::returnVeriable(false, $decoded["message"]);
        }
        if($data->type == "information"){
          include("Profile/Information.php");
          $news = new GetProfile($database);
          return $news->GetUserInformation($data,$decoded["decoded"]);
        } else if($data->type == "update"){
          include("Profile/Update.php");
          $news = new UpdateProfile($database);
          $return = $news->UpdateAction($data,$decoded["decoded"]);
          if($return["type"]){
            //GenerateToken
            $newKey = self::GenerateTokenWithOutCrypt($return);
            return ["type" => true, "message" => "Profil bilgileri başarıyla güncellendi", "data" => ["key" => $newKey]];
          } else {
            return $return;
          }
        } else {
          return self::returnVeriable(false,"Eksik parametreler mevcut.");
        }
      } else if($type == "MESSAGE"){
        if(!self::APIConnectionControl()){
          return self::returnVeriable(false,"Kimlik doğrulaması gerekli.");
        }
        $headers = apache_request_headers();
        $key = $headers['Authorization'];
        $decoded = self::DecodeToken($key);
        if(!$decoded["status"]){
          return self::returnVeriable(false, $decoded["message"]);
        }
        if($data->type == "send"){
          include("Message/Send.php");
          $news = new GenerateMessage($database);
          return $news->SendMessage($data,$decoded["decoded"]);
        } else {
          return self::returnVeriable(false,"Eksik parametreler mevcut.");
        }
      } else if($type == "NOTIFICATIONS"){
        if(!self::APIConnectionControl()){
          return self::returnVeriable(false,"Kimlik doğrulaması gerekli.");
        }
        $headers = apache_request_headers();
        $key = $headers['Authorization'];
        $decoded = self::DecodeToken($key);
        if(!$decoded["status"]){
          return self::returnVeriable(false, $decoded["message"]);
        }
        if($data->type == "list"){
          include("Notifications/List.php");
          $news = new GenerateNotifications($database);
          return $news->GetLogs($data,$decoded["decoded"]);
        } else {
          return self::returnVeriable(false,"Eksik parametreler mevcut.");
        }
      }
    }
    public function GenerateToken($data){
      $token = [
           "phone_number" => $data->phone_number,
           "password" => md5(sha1($data->password))
    ];
    $jwt = JWT::encode($token, $this->key);
    return $jwt;
    }

    public function GenerateTokenWithOutCrypt($data){
      $token = [
           "phone_number" => $data["phone_number"],
           "password" => $data["password"]
    ];
    $jwt = JWT::encode($token, $this->key);
    return $jwt;
    }

    public function DecodeToken($data){
      try {
        $decoded = JWT::decode($data, $this->key, array('HS256'));
        return ["status" => true, "decoded" => $decoded];
    } catch (Exception $e){
        return ["status" => false, "message" => $e->getMessage()];
}
    }
    public function APIConnectionControl(){
      $headers = apache_request_headers();
      if (!isset($headers['Authorization'])) {
    header('HTTP/1.0 401 Unauthorized');
    return false;
  } else {
    return true;
  }

    }
  }

 ?>
