<?php
error_reporting(E_ALL);
ini_set("display_errors",1);
/**
 * Login database control and generate key actions.
 */
class GenerateNews
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

  public function SearchNewsInArray($news, $id){
    $status = false;
    foreach($news as $new){
      if($new["id"] == $id){
        $status = true;
      }
    }
    return $status;
  }
  public function GroupNews($news, $categories){
    $new_news_list = [];
    foreach($news as $new){
      $new_array = json_decode($new["categories"]);
      foreach($new_array as $arr){
        if(in_array($arr, $categories)){
          if(!self::SearchNewsInArray($new_news_list,$new["id"])){
            $new_news_list[] = $new;
          }
        }
      }
    }
    return $new_news_list;
  }

  public function CountNews($news, $categories){
    $new_news_list = [];
    foreach($news as $new){
      $new_array = json_decode($new["categories"]);
      foreach($new_array as $arr){
        if(in_array($arr, $categories)){
          if(!self::SearchNewsInArray($new_news_list,$new["id"])){
            $new_news_list[] = $new;
          }
        }
      }
    }
    return $new_news_list;
  }

  public function EditNews($news){
    $new_news = [];
    $generalSettings = self::GetGeneralSettings();
    foreach($news as $new){
      $new_categories = [];
      $new["added_time"] = date("d/m/Y H:i", $new["added_time"]);
      $new["id"] = (int)$new["id"];
      $new["thumbnail"] = $generalSettings["url"].$new["thumbnail"];
      foreach(json_decode($new["categories"]) as $arr){
        $data = self::GetCategoryName($arr);
        if($data["status"]){
          $new_categories[] = ["category_id" => (int)$arr, "category_name" => $data["category_name"]];
        }
      }
      $new["categories"] = $new_categories;
      $new_news[] = $new;
    }
    return $new_news;
  }

  public function GetGeneralSettings(){
    $query = $this->db->prepare("SELECT * FROM `settings` WHERE `id` = :id");
    $query->execute(["id" => 1]);
    $data = $query->fetch();
    return $data;
  }

  public function GetCategoryName($category_id){
    $control = $this->db->prepare("SELECT * FROM `categories` WHERE `id` = :category_id AND `isDeleted` = 0");
    $control->execute([
      ":category_id" => $category_id
    ]);
    $data = $control->fetch();
    return ($data) ? ["status" => true, "category_name" => $data["category_name"]] : ["status" => false];
  }

  public function GetAllCategories(){
    $categories = $this->db->prepare("SELECT * FROM `categories` WHERE `isDeleted` = 0");
    $categories->execute();
    $categories = $categories->fetchAll(PDO::FETCH_ASSOC);
    $new_categories = [];
    foreach($categories as $category){
      $category["id"] = (int)$category["id"];
      $new_categories[] = $category;
    }
    return $new_categories;
  }
  public function GetNews($data, $decoded){
    $grouped = false;
    if(!isset($decoded->phone_number) || !isset($decoded->password)){
      return ["type" => false, "message" => "Authorization içersinde bazı parametreler tanımsız."];
    }
    if(isset($data->category_ids)){
      if(!is_array($data->category_ids)){
        return ["type" => false, "message" => "Kategori listesi array formatında olmak zorundadır."];
      }
      $grouped = true;
    } else {
      $data->category_ids = [];
    }
    if(count($data->category_ids) < 1){
      $grouped = false;
    }
    if(self::Control($decoded->phone_number, $decoded->password) == false){
      return ["type" => false, "message" => "Telefon numarası veya şifre hatalı. Lütfen tekrar giriş yapın."];
    }

    $newsCount = $this->db->prepare("SELECT `id`, `title`, `short_description`, `thumbnail`, `categories`,  `added_time` FROM `news`
      WHERE `status` = :status AND `isDeleted` = 0 ORDER BY `id` DESC");
      $newsCount->execute([
        ":status" => 1
      ]);
    $AllCount = $newsCount->fetchAll(PDO::FETCH_ASSOC);

    $start = $data->start;
    $length = $data->length;
    $end = $length+$start;
    $news = $this->db->prepare("SELECT `id`, `title`, `short_description`, `thumbnail`, `categories`,  `added_time` FROM `news`
      WHERE `status` = :status AND `isDeleted` = 0 ORDER BY `id` DESC LIMIT $start,$length");
      $news->execute([
        ":status" => 1
      ]);
      $news = $news->fetchAll(PDO::FETCH_ASSOC);
      $news = ($grouped) ? self::GroupNews($news, $data->category_ids) : $news;
      $count = ($grouped) ? count(self::CountNews($AllCount,$data->category_ids)) : count($AllCount);
      $news  = self::EditNews($news);
      return ["type" => true, "message" => "$start - $end arasındaki haberler listeleniyor.", "data" => ["total" => $count, "categories" => self::GetAllCategories(), "news" => $news]];
  }

}



 ?>
