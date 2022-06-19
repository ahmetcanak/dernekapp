<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
/**
 * Login database control and generate key actions.
 */
class NewsInformation
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
  public function GetGeneralSettings(){
    $query = $this->db->prepare("SELECT * FROM `settings` WHERE `id` = :id");
    $query->execute(["id" => 1]);
    $data = $query->fetch();
    return $data;
  }
  public function EditNews($news){
      $news_categories = [];
      $generalSettings = self::GetGeneralSettings();
      $news["added_time"] = date("d/m/Y H:i", $news["added_time"]);
      $news["id"] = (int)$news["id"];
      $news["content"] =  $news["content"];
      $news["thumbnail"] = $generalSettings["url"].$news["thumbnail"];
      $news["image"] = $generalSettings["url"].$news["image"];
      foreach(json_decode($news["categories"]) as $arr){
        $data = self::GetCategoryName($arr);
        if($data["status"]){
          $news_categories[] = ["category_id" => (int)$arr, "category_name" => $data["category_name"]];
        }
      }
      $news["categories"] = $news_categories;
    return $news;
  }

  public function GetCategoryName($category_id){
    $control = $this->db->prepare("SELECT * FROM `categories` WHERE `id` = :category_id AND `isDeleted` = 0");
    $control->execute([
      ":category_id" => $category_id
    ]);
    $data = $control->fetch();
    return ($data) ? ["status" => true, "category_name" => $data["category_name"]] : ["status" => false];
  }

  public function GetNewsInformation($data, $decoded){
    if(!isset($decoded->phone_number) || !isset($decoded->password)){
      return ["type" => false, "message" => "Authorization içersinde bazı parametreler tanımsız."];
    }
    if(self::Control($decoded->phone_number, $decoded->password) == false){
      return ["type" => false, "message" => "Telefon numarası veya şifre hatalı. Lütfen tekrar giriş yapın."];
    }
    $news = $this->db->prepare("SELECT `id`, `title`, `short_description`, `thumbnail`, `image`, `content`, `categories`,  `added_time` FROM `news`
      WHERE `status` = :status AND `id` = :news_id");
      $news->execute([
        ":status" => 1,
        "news_id" => $data->id
      ]);
      $news = $news->fetch();
      if(!$news){
        return ["type" => false, "message" => "Haber bulunamadı."];
      }
      $news  = self::EditNews($news);
      return ["type" => true, "message" => $data->id." kimlikli haber içeriği gösteriliyor.", "data" => $news];
  }

}



 ?>
