<?php
/**
 * Mesajları silme işlemi
 */
class ManageMessages
{

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function delete($ids)
    {
        return self::Control($ids);
    }

    public function Control($ids)
    {
      $deleted = [];
      foreach($ids as $id){
        $query = $this
            ->db
            ->prepare("SELECT `id` FROM `messages` WHERE `id`=:id AND `isDeleted` = 0");
        $query->execute([":id" => $id]);
        $count = $query->rowCount();
        if ($count > 0)
        {
          $deleted[] = $id;
          $query = $this
              ->db
              ->prepare("UPDATE `messages` SET `isDeleted` = 1 WHERE `id` =:id");
          $query->execute([":id" => $id]);
        }
      }
      return ["status" => true, "message" => "Seçili mesajlar başarıyla silindi.", "deleted_list" => $deleted];
    }

}

?>
