<?php
/**
 * Bildirim kayıtlarını Listeleme İşlemi
 */
class ManageNotifications
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
                        <h4 class="font-size-18">Bildirim Kayıtlarını Listele</h4>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item active"><a href="javascript: void(0);">Bildirim Kayıtları</a></li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Bildirim Kayıtları</h4>
                            <p class="card-title-desc">Kayıtlar getiriliyor..</p>
                            <div id="progressbar" class="progress mb-4">
                                                <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                            <table id="list-logs"  class="table table-striped table-bordered dt-responsive nowrap responsive" style="border-collapse: collapse; border-spacing: 0; width:100%; display:none;">
                                <thead>
                                <tr>
                                    <th>#No</th>
                                    <th>Bildirim Başlığı</th>
                                    <th>Bildirim İçeriği</th>
                                    <th>Bildirim Resmi</th>
                                    <th>Gönderen Kişi</th>
                                    <th>Gönderilme Tarihi</th>
                                    <th>İşlemler</th>
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
    $authName = self::GetAuthorizedUserData("name", $logs["sender"]);
    $authName = ($authName["status"]) == true ? $authName["data"] : "Bilinmiyor";
    $authSurName = self::GetAuthorizedUserData("surname", $logs["sender"]);
    $authSurName = ($authSurName["status"]) == true ? $authSurName["data"] : "Bilinmiyor";
    $sender = $authName . " " . $authSurName . " (#" . $logs["sender"] . ")";
    $logs["image"] = $logs["image"] != null ? '<a href="'.$logs["image"].'" target = "_blank">Resmi Gör</a>' : "Resim Yok";
    return '<tr bildirim_tr_id="'.$logs["id"].'"> <td>'.$logs["id"].'</td>
    <td>'.$logs["title"].'</td>
    <td>'.$logs["text"].'</td>
    <td>'.$logs["image"].'</td>
   <td>'.$sender.'</td>
    <td>'.date("d/m/Y H:i", $logs["sended_time"]).'</td>
    <td> <div class="btn-group" role="group">
                                            <button id="btnGroupVerticalDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                İşlemler
                                                <i class="mdi mdi-chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">
                                                <a class="dropdown-item DeleteNotification" href="#">Sil</a>
                                            </div>
                                        </div></td>
        </tr>';
  }

  public function GetLogs(){
    $logs = $this
        ->db
        ->prepare("SELECT * FROM `notifications` WHERE `isDeleted` = 0 ORDER BY `id` DESC");
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



}

?>
