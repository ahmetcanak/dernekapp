<?php
/**
 * Kullanıcı Silme İşlemi
 */
class ManageUsers
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
            ->prepare("SELECT `id` FROM `users` WHERE `id`=:id AND `isDeleted` = 0");
        $query->execute([":id" => $id]);
        $count = $query->rowCount();
        if ($count > 0)
        {
            $query = $this
                ->db
                ->prepare("UPDATE `users`  SET  `isDeleted` = 1 WHERE `id` =:id");
            $query->execute([":id" => $id]);

            $query = $this
                ->db
                ->prepare("UPDATE `profile_data`  SET  `isDeleted` = 1 WHERE `user_id` =:id");
            $query->execute([":id" => $id]);

            $query = $this
                ->db
                ->prepare("UPDATE `children_list`  SET  `isDeleted` = 1 WHERE `parent_id` =:id");
            $query->execute([":id" => $id]);

            return ["status" => true, "message" => "$id numaralı kullanıcı başarıyla kaldırıldı."];
        }
        else
        {
            return ["status" => false, "message" => "Kullanıcı bulunamadı."];
        }
    }

}

?>
