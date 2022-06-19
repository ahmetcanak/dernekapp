<?php
/**
 * Yetki Grubu Silme İşlemi
 */
class ManageAuthorize
{

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function delete($id)
    {
        return self::Control($id);
    }
    public function RemoveAuthFromUsers($id){
      $query = $this->db->prepare("UPDATE `authorized_list` SET `authorize_id` = 0 WHERE `isDeleted` = 0 AND `authorize_id` = :id");
      $query->execute([":id" => $id]);
    }

    public function Control($id)
    {
      if($id == 1 || $id == 2){
        return ["status" => false, "message" => "Bu yetki grubu kaldırılamaz veya düzenlenemez."];
      }
        $query = $this
            ->db
            ->prepare("SELECT `id` FROM `authorize_list` WHERE `id`=:id AND `isDeleted` = 0");
        $query->execute([":id" => $id]);
        $count = $query->rowCount();
        if ($count > 0)
        {
            $query = $this
                ->db
                ->prepare("UPDATE `authorize_list` SET `isDeleted` = 1 WHERE `id` =:id");
            $query->execute([":id" => $id]);
            self::RemoveAuthFromUsers($id);
            return ["status" => true, "message" => "$id numaralı yetki grubu başarıyla kaldırıldı."];
        }
        else
        {
            return ["status" => false, "message" => "Yetki grubu bulunamadı."];
        }
    }

}

?>
