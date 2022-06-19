<?php
/**
 * Haber Kategorisi Silme İşlemi
 */
class ManageNewsCategories
{

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function delete($id)
    {
        return self::Control($id);
    }
    public function RemoveCategoryFromNews($id){
      $query = $this->db->prepare("SELECT `id`, `categories` FROM `news` WHERE `isDeleted` = 0");
      $query->execute();
      $news = $query->fetchAll(PDO::FETCH_ASSOC);
      foreach($news as $n){
        $arr = json_decode($n["categories"]);
        if(in_array($id,$arr)){
          $index = array_search($id,$arr,true);
          unset($arr[$index]);
          $arr = array_values($arr);
          self::UpdateNews($n["id"],$arr);
        }
      }
    }

    public function UpdateNews($news_id, $new_categories){
      $query = $this->db->prepare("UPDATE `news` SET `categories` = :categories WHERE `id` = :id AND `isDeleted` = 0");
      $query->execute([
        ":id" => $news_id,
        ":categories" => json_encode($new_categories)
      ]);
    }
    public function Control($id)
    {
        $query = $this
            ->db
            ->prepare("SELECT `id` FROM `categories` WHERE `id`=:id AND `isDeleted` = 0");
        $query->execute([":id" => $id]);
        $count = $query->rowCount();
        if ($count > 0)
        {
            $query = $this
                ->db
                ->prepare("UPDATE `categories` SET `isDeleted` = 1 WHERE `id` =:id");
            $query->execute([":id" => $id]);
            self::RemoveCategoryFromNews($id);
            return ["status" => true, "message" => "$id numaralı kategori başarıyla kaldırıldı."];
        }
        else
        {
            return ["status" => false, "message" => "Kategori bulunamadı."];
        }
    }

}

?>
