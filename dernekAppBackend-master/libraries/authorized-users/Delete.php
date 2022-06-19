<?php
/**
 * Yetkili Silme İşlemi
 */
class ManageAuthorizedUsers
{

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function delete($id)
    {
        return self::Control($id);
    }


    public function Control($id)
    {
        $query = $this
            ->db
            ->prepare("SELECT `id`, `email` FROM `authorized_list` WHERE `id`=:id AND `isDeleted` = 0");
        $query->execute([":id" => $id]);
        $data = $query->fetch();
        if ($data)
        {
          if($data["email"] == $_SESSION["email"]){
            return ["status" => false, "message" => "Kendini silemezsin."];
          }
            $query = $this
                ->db
                ->prepare("UPDATE `authorized_list` SET `isDeleted` = 1 WHERE `id` =:id");
            $query->execute([":id" => $id]);
            return ["status" => true, "message" => "$id numaralı yetkili başarıyla kaldırıldı."];
        }
        else
        {
            return ["status" => false, "message" => "Yetkili bulunamadı."];
        }
    }

}

?>
