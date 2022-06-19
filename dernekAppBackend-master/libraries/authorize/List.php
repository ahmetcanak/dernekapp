<?php
/**
 * Yetkileri Grubu Listeleme İşlemi
 */
class ManageAuthorize
{

  public function __construct($db){
    $this->db = $db;
  }
  public function write(){
    $html = '<div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="page-title-box">
                        <h4 class="font-size-18">Yetkileri Listele</h4>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Yetkilendirme</a></li>
                            <li class="breadcrumb-item active">Yetki Grubu Listesi</li>
                        </ol>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="float-right d-none d-md-block">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle waves-effect waves-light" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-settings mr-2"></i> Diğer İşlemler
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="add-auth">Yetki Grubu Ekle</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Yetki Grubu Listesi</h4>
                            <p class="card-title-desc">Yetki grupları getiriliyor..</p>
                            <div id="progressbar" class="progress mb-4">
                                                <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                            <table id="list-auth"  class="table table-striped table-bordered dt-responsive nowrap responsive" style="border-collapse: collapse; border-spacing: 0; width:100%; display:none;">
                                <thead>
                                <tr>
                                    <th>#No</th>
                                    <th>Yetki Adı</th>
                                    <th>Yetkili Sayısı</th>
                                    <th>Eklenme Tarihi</th>
                                    <th class="notexport">İşlemler</th>
                                </tr>
                                </thead>


                                <tbody>';
        $auths = self::GetAuths();
        foreach($auths as $auth){
          $html .= self::ListAuth($auth);
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

  public function ListAuth($auth){
    return '<tr yetki_tr_id="'.$auth["id"].'">
        <td>'.$auth["id"].'</td>
        <td>'.$auth["authorize_name"].'</td>
        <td>'.$auth["user_count"].'</td>
        <td>'.$auth["added_time"].'</td>
        <td> <div class="btn-group" role="group">
                                                <button id="btnGroupVerticalDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    İşlemler
                                                    <i class="mdi mdi-chevron-down"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">
                                                    '.($auth["id"] != 1 && $auth["id"] != 2 ? '<a class="dropdown-item DeleteAuth" href="#">Sil</a>' : '').'
                                                    '.($auth["id"] != 1 && $auth["id"] != 2 ? '<a class="dropdown-item" target="_blank" href="edit-auth?id='.$auth["id"].'">Düzenle</a>' : '' ).'
                                                </div>
                                            </div></td>
    </tr>';
  }

  public function GetAuths(){
    $auths = $this->db->prepare("SELECT * FROM `authorize_list` WHERE `isDeleted` = 0 ORDER BY `id` DESC ");
      $auths->execute();
      $auths = $auths->fetchAll(PDO::FETCH_ASSOC);
      $auths  = self::EditAuths($auths);
      return $auths;
  }
  public function GetUserCount($auth_id){
    $query = $this->db->prepare("SELECT `id` FROM `authorized_list` WHERE `authorize_id` = :auth_id AND `isDeleted` = 0");
    $query->execute([":auth_id" => $auth_id]);
    $count = $query->rowCount();
    return $count;
  }
  public function EditAuths($auths){
    $new_auths = [];
    foreach($auths as $auth){
      $auth["added_time"] = date("d/m/Y H:i", $auth["added_time"]);
      $auth["id"] = (int)$auth["id"];
      $auth["user_count"] = self::GetUserCount($auth["id"]);
      $new_auths[] = $auth;
    }
    return $new_auths;
  }


}

?>
