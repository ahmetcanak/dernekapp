<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
/**
 *  bağlantı sağlaması ve include için.
 */
class ManageConnection
{

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function Connection($email = null, $password = null)
    {
        return self::LocalConnection($email, $password);
    }

    public function HasConnection()
    {
        if (isset($_SESSION["email"]) && isset($_SESSION["password"]))
        {
            $query = $this
                ->db
                ->prepare("SELECT * FROM `authorized_list` WHERE `email` = :email AND `password` = :password AND `isDeleted` = 0");
            $query->execute([":email" => $_SESSION["email"], ":password" => $_SESSION["password"]]);

            return ($query->rowCount() > 0) ? true : false;
        }
        return false;
    }

    public function LocalConnection($email, $password)
    {
        if ($email == null || $password == null)
        {
            session_destroy();
            return false;
        }
        $query = $this
            ->db
            ->prepare("SELECT * FROM `authorized_list` WHERE `email` = :email AND `password` = :password AND `isDeleted` = 0");
        $query->execute([":email" => $email, ":password" => md5(sha1($password)) ]);
        if ($query->rowCount() > 0)
        {
            $_SESSION["email"] = $email;
            $_SESSION["password"] = md5(sha1($password));
            return true;
        }
        else
        {
            session_destroy();
            return false;
        }
    }

    public function User()
    {
        $query = $this
            ->db
            ->prepare("SELECT * FROM `authorized_list` WHERE `email` = :email AND `password` = :password AND `isDeleted` = 0");
        $query->execute([":email" => $_SESSION["email"], ":password" => $_SESSION["password"]]);
        return $query->fetch();
    }

    public function CountTable($table_name)
    {
        $query = $this
            ->db
            ->prepare("SELECT `id` FROM `$table_name` WHERE `isDeleted` = 0");
        $query->execute();
        return $query->rowCount();
    }
    public function GetAuthorizedUserData($column, $user_id)
    {
        $query = $this
            ->db
            ->prepare("SELECT `$column` FROM `authorized_list` WHERE `id`= :user_id AND `isDeleted` = 0");
        $query->execute([":user_id" => $user_id]);
        $data = $query->fetch();
        return ($data) ? ["status" => true, "data" => $data[$column]] : ["status" => false];
    }
    public function GenerateLogs($count = 5)
    {
        $logs = $this
            ->db
            ->prepare("SELECT * FROM `logs` ORDER BY `id` DESC LIMIT $count");
        $logs->execute();
        $logs = $logs->fetchAll(PDO::FETCH_ASSOC);
        $text = "";
        foreach ($logs as $log)
        {
            $authName = self::GetAuthorizedUserData("name", $log["log_user_id"]);
            $authName = ($authName["status"]) == true ? $authName["data"] : "Bilinmiyor";
            $authSurName = self::GetAuthorizedUserData("surname", $log["log_user_id"]);
            $authSurName = ($authSurName["status"]) == true ? $authSurName["data"] : "Bilinmiyor";
            $replace = $authName . " " . $authSurName . " (#" . $log["log_user_id"] . ")";
            $log["log_text"] = str_replace("{USER_INFO}", $replace, $log["log_text"]);
            $text .= '<li class="feed-item">
          <div class="feed-item-list">
              <span class="date">' . date("d/m/Y H:i", $log["log_date"]) . '</span>
              <span class="activity-text">' . $log["log_text"] . '</span>
          </div>
      </li>';
        }
        return $text;
    }

    public function WriteLog($text)
    {
        $user_data = self::User();
        $text = "{USER_INFO}, " . $text;
        $insert = $this
            ->db
            ->prepare("INSERT INTO `logs` (`id`, `log_date`, `log_text`, `log_user_id`) VALUES (NULL, :log_time, :log_text, :user_id)");
        $insert->execute([":log_time" => time() , ":log_text" => $text, ":user_id" => $user_data["id"]]);
    }

    public function Logout()
    {
        if (self::HasConnection())
        {
            self::WriteLog("çıkış yaptı.");
        }
        session_destroy();
    }

    public function AuthorizationControl($action)
    {
        $user_data = self::User();
        $authorize_id = $user_data["authorize_id"];
        return self::AuthListControl($authorize_id, $action);
    }

    public function AuthListControl($auth_id, $action)
    {
        $query = $this
            ->db
            ->prepare("SELECT `$action` FROM `authorize_list` WHERE `id` = :id AND `isDeleted` = 0");
        $query->execute(["id" => $auth_id]);
        $data = $query->fetch();
        return ($data[$action]) == 1 ? true : false;
    }


}

?>
