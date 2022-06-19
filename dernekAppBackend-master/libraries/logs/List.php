<?php
/**
 * İşlem kayıtlarını Listeleme İşlemi
 */
class ManageLogs
{

  public function __construct($db){
    $this->db = $db;
  }
  public function write(){
    $html = '<div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row align-items-center">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <h4 class="font-size-18">İşlem Kayıtlarını Listele</h4>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item active"><a href="javascript: void(0);">İşlem Kayıtları</a></li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">İşlem Kayıtları</h4>
                            <p class="card-title-desc">Kayıtlar getiriliyor..</p>
                            <div id="progressbar" class="progress mb-4">
                                                <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                            <table id="list-logs"  class="table table-striped table-bordered dt-responsive nowrap responsive" style="border-collapse: collapse; border-spacing: 0; width:100%; display:none;">
                                <thead>
                                <tr>
                                    <th>#No</th>
                                    <th>Yapılan İşlem</th>
                                    <th>İşlem Tarihi</th>
                                </tr>
                                </thead>


                                <tbody>';
        $logs = self::GetLogs();
        foreach($logs as $log){
          $html .= self::ListLogs($log);
        }

      $html .= '
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->



        </div> <!-- container-fluid -->
    </div>';
    return $html;
  }

  public function ListLogs($logs){
    $authName = self::GetAuthorizedUserData("name", $logs["log_user_id"]);
    $authName = ($authName["status"]) == true ? $authName["data"] : "Bilinmiyor";
    $authSurName = self::GetAuthorizedUserData("surname", $logs["log_user_id"]);
    $authSurName = ($authSurName["status"]) == true ? $authSurName["data"] : "Bilinmiyor";
    $replace = $authName . " " . $authSurName . " (#" . $logs["log_user_id"] . ")";
    $logs["log_text"] = str_replace("{USER_INFO}", $replace, $logs["log_text"]);
    return '<tr>
        <td>'.$logs["id"].'</td>
        <td>'.$logs["log_text"].'</td>
        <td>'.date("d/m/Y H:i", $logs["log_date"]).'</td>
        </tr>';
  }

  public function GetLogs(){
    $logs = $this
        ->db
        ->prepare("SELECT * FROM `logs` ORDER BY `id` DESC");
    $logs->execute();
    $logs = $logs->fetchAll(PDO::FETCH_ASSOC);
    return $logs;
  }

  public function GetAuthorizedUserData($column, $user_id)
  {
      $query = $this
          ->db
          ->prepare("SELECT `$column` FROM `authorized_list` WHERE `id`= :user_id");
      $query->execute([":user_id" => $user_id]);
      $data = $query->fetch();
      return ($data) ? ["status" => true, "data" => $data[$column]] : ["status" => false];
  }
  /*public function GenerateLogs()
  {
      $logs = $this
          ->db
          ->prepare("SELECT * FROM `logs` ORDER BY `id` DESC LIMIT");
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
  }*/


}

?>
