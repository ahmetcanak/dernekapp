<?php
/**
 * Haberleri Silme İşlemi
 */
class ManageNews
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
            ->prepare("SELECT `id` FROM `news` WHERE `id`=:id AND `isDeleted` = 0");
        $query->execute([":id" => $id]);
        $count = $query->rowCount();
        if ($count > 0)
        {
            $query = $this
                ->db
                ->prepare("UPDATE `news`  SET  `isDeleted` = 1 WHERE `id` =:id");
            $query->execute([":id" => $id]);
            return ["status" => true, "message" => "$id numaralı haber başarıyla kaldırıldı."];
        }
        else
        {
            return ["status" => false, "message" => "Haber bulunamadı."];
        }
    }

}

?>
