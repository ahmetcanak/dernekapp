<?php
/**
 * Yetkili Listeleme İşlemi
 */
class ManageAuthorizedUsers
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
                        <h4 class="font-size-18">Yetkilileri Listele</h4>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Yetkili Kullanıcılar</a></li>
                            <li class="breadcrumb-item active">Yetkili Listesi</li>
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
                                <a class="dropdown-item" href="add-auth-user">Yetkili Ekle</a>
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
                            <p class="card-title-desc">Yetkililer getiriliyor..</p>
                            <div id="progressbar" class="progress mb-4">
                                                <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                            <table id="list-auth"  class="table table-striped table-bordered dt-responsive nowrap responsive" style="border-collapse: collapse; border-spacing: 0; width:100%; display:none;">
                                <thead>
                                <tr>
                                    <th>#No</th>
                                    <th>Yetkili Adı</th>
                                    <th>Yetkili Soyadı</th>
                                    <th>Yetkili E-Posta</th>
                                    <th>Yetki Grubu</th>
                                    <th>Oluşturulma Tarihi</th>
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
        <td>'.$auth["name"].'</td>
        <td>'.$auth["surname"].'</td>
        <td>'.$auth["email"].'</td>
        <td>'.$auth["group"].'</td>
        <td>'.$auth["added_time"].'</td>
        <td> <div class="btn-group" role="group">
                                                <button id="btnGroupVerticalDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    İşlemler
                                                    <i class="mdi mdi-chevron-down"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">
                                                    '.($auth["email"] != $_SESSION["email"] ? '<a class="dropdown-item DeleteAuth" href="#">Sil</a>' : '').'
                                                    '.($auth["email"] != $_SESSION["email"] ? '<a class="dropdown-item" target="_blank" href="edit-authorized-user?id='.$auth["id"].'">Düzenle</a>' : '' ).'
                                                </div>
                                            </div></td>
    </tr>';
  }

  public function GetAuths(){
    $auths = $this->db->prepare("SELECT * FROM `authorized_list` WHERE `isDeleted` = 0 ORDER BY `id` DESC ");
      $auths->execute();
      $auths = $auths->fetchAll(PDO::FETCH_ASSOC);
      $auths  = self::EditAuths($auths);
      return $auths;
  }
  public function GroupName($auth_id){
    $query = $this->db->prepare("SELECT `authorize_name` FROM `authorize_list` WHERE `id` = :auth_id AND `isDeleted` = 0");
    $query->execute([":auth_id" => $auth_id]);
    $data = $query->fetch();
    return $data["authorize_name"];
  }

  public function EditAuths($auths){
    $new_auths = [];
    foreach($auths as $auth){
      $auth["added_time"] = date("d/m/Y H:i", $auth["added_time"]);
      $auth["id"] = (int)$auth["id"];
      $auth["group"] = self::GroupName($auth["authorize_id"]);
      $new_auths[] = $auth;
    }
    return $new_auths;
  }


}

?>
