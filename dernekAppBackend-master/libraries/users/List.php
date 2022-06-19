<?php
/**
 * Kullanıcıları Listeleme İşlemi
 */
class ManageUsers
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
                        <h4 class="font-size-18">Kullanıcıları Listele</h4>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Kullanıcılar</a></li>
                            <li class="breadcrumb-item active">Kullanıcı Listesi</li>
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
                                <a class="dropdown-item" href="add-user">Kullanıcı Ekle</a>
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

                            <h4 class="card-title">Kullanıcı Listesi</h4>
                            <p class="card-title-desc">Kullanıcılar getiriliyor..</p>
                            <div id="progressbar" class="progress mb-4">
                                                <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                            <table id="list-users"  class="table table-striped table-bordered dt-responsive nowrap responsive" style="border-collapse: collapse; border-spacing: 0; width:100%; display:none;">
                                <thead>
                                <tr>
                                    <th>#No</th>
                                    <th>Adı</th>
                                    <th>Soyadı</th>
                                    <th>Telefon Numarası</th>
                                    <th>Kayıt Tarihi</th>
                                    <th class="notexport">İşlemler</th>
                                    '.self::GenerateTitle().'
                                </tr>
                                </thead>


                                <tbody>';
        $users = self::GetUsers();
        foreach($users as $user){
          $html .= self::ListUsers($user);
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

  public function ListUsers($users){
    return '<tr kullanici_tr_id="'.$users["id"].'">
        <td>'.$users["id"].'</td>
        <td>'.$users["name"].'</td>
        <td>'.$users["surname"].'</td>
        <td>'.$users["phone_number"].'</td>
        <td>'.$users["register_date"].'</td>
        <td> <div class="btn-group" role="group">
                                                <button id="btnGroupVerticalDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    İşlemler
                                                    <i class="mdi mdi-chevron-down"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">
                                                    <a class="dropdown-item DeleteUser" href="#">Sil</a>
                                                    <a class="dropdown-item" target="_blank" href="edit-user?id='.$users["id"].'">Düzenle</a>
                                                </div>
                                            </div></td>
        '.self::GenerateColumns($users["id"]).'
    </tr>';
  }
  public function GenerateTitle(){
    $titles = [];
    $titles[] = "TC Kimlik Numarası";
    $titles[] = "E-Posta Adresi";
    $titles[] = "Doğum Tarihi";
    $titles[] = "Tahsili";
    $titles[] = "Meslek";
    $titles[] = "Kan Grubu";
    $titles[] = "Baba Adı";
    $titles[] = "Anne Adı";
    $titles[] = "Annesinin Babasının Adı";
    $titles[] = "Köydeki Lakap";
    $titles[] = "Köydeki Mahalle";
    $titles[] = "Ev Adresi";
    $titles[] = "İş Adresi";
    $titles[] = "İş Telefonu";
    $titles[] = "Ev Telefonu";
    $titles[] = "Eşinin Adı";
    $titles[] = "Eşinin Kan Grubu";
    $titles[] = "Eşinin Babasının Adı";
    $titles[] = "Çocuk Bilgileri";
    $html = "";
    foreach($titles as $title){
      $html .= '<th style="display:none;">'.$title.'</th>';
    }
    return $html;

  }
  public function GenerateColumns($user_id){
    $query = $this->db->prepare("SELECT * FROM `profile_data` WHERE `user_id` = :user_id");
    $query->execute([
      ":user_id" => $user_id
    ]);
    $data = $query->fetch();
    $values = [];
    $html = "";
    $values[] = $data["tc_id"] != NULL ? $data["tc_id"] : "Bilgi Yok";
    $values[] = $data["email"] != NULL ? $data["email"] : "Bilgi Yok";
    $values[] = $data["birth_date"] != NULL ? date("d/m/Y", $data["birth_date"]) : "Bilgi Yok";
    $values[] = $data["education_status"] != NULL ? $data["education_status"] : "Bilgi Yok";
    $values[] = $data["job"] != NULL ? $data["job"] : "Bilgi Yok";
    $values[] = $data["blood_group"] != NULL ? $data["blood_group"] : "Bilgi Yok";
    $values[] = $data["father_name"] != NULL ? $data["father_name"] : "Bilgi Yok";
    $values[] = $data["mother_name"] != NULL ? $data["mother_name"] : "Bilgi Yok";
    $values[] = $data["mothers_father_name"] != NULL ? $data["mothers_father_name"] : "Bilgi Yok";
    $values[] = $data["village_nickname"] != NULL ? $data["village_nickname"] : "Bilgi Yok";
    $values[] = $data["village_neighborhood"] != NULL ? $data["village_neighborhood"] : "Bilgi Yok";
    $values[] = $data["home_address"] != NULL ? $data["home_address"] : "Bilgi Yok";
    $values[] = $data["job_address"] != NULL ? $data["job_address"] : "Bilgi Yok";
    $values[] = $data["job_phone"] != NULL ? $data["job_phone"] : "Bilgi Yok";
    $values[] = $data["home_phone"] != NULL ? $data["home_phone"] : "Bilgi Yok";
    $values[] = $data["spouse_name"] != NULL ? $data["spouse_name"] : "Bilgi Yok";
    $values[] = $data["spouse_blood_group"] != NULL ? $data["spouse_blood_group"] : "Bilgi Yok";
    $values[] = $data["spouse_father"] != NULL ? $data["spouse_father"] : "Bilgi Yok";
    $values[] = self::GetChilds($user_id);
    foreach($values as $value){
      $html .='<td style="display:none">'.$value.'</td>';
    }
    return $html;
  }

  public function GetChilds($user_id){
    $query = $this->db->prepare("SELECT * FROM `children_list` WHERE `parent_id` = :user_id");
    $query->execute([
      ":user_id" => $user_id
    ]);
    $data = $query->fetchAll(PDO::FETCH_ASSOC);
    $return = "Çocuk Yok";
    if($data){
      $return = "";
      foreach($data as $d){
        $d["name"] = ($d["name"] != NULL) ? $d["name"] : "Bilgi Yok";
        $d["surname"] = ($d["surname"] != NULL) ? $d["surname"] : "Bilgi Yok";
        $d["birth_date"] = ($d["birth_date"] != NULL) ? date("d/m/Y",$d["birth_date"]) : "Bilgi Yok";
        $d["marital_status"] = ($d["marital_status"] != NULL) ? $d["marital_status"] : "Bilgi Yok";
        $d["job"] = ($d["job"] != NULL) ? $d["job"] : "Bilgi Yok";
        $d["blood_group"] = ($d["blood_group"] != NULL) ? $d["blood_group"] : "Bilgi Yok";
        $d["education_status"] = ($d["education_status"] != NULL) ? $d["education_status"] : "Bilgi Yok";
        $d["phone_number"] = ($d["phone_number"] != NULL) ? $d["phone_number"] : "Bilgi Yok";
        $return .= '{Adı: '.$d["name"].', Soyadı: '.$d["surname"].', Doğum Tarihi: '.$d["birth_date"].', Medeni Hali: '.$d["marital_status"].', Meslek: '.$d["job"].', Kan Grubu: '.$d["blood_group"].', Tahsili: '.$d["education_status"].', Telefon Numarası: '.$d["phone_number"].'}';
      }
    }
      return $return;
  }
  public function GetUsers(){
    $users = $this->db->prepare("SELECT `id`, `phone_number`, `register_date` FROM `users` ORDER BY `id` DESC ");
      $users->execute();
      $users = $users->fetchAll(PDO::FETCH_ASSOC);
      $users  = self::EditUsers($users);
      return $users;
  }

  public function EditUsers($users){
    $new_users = [];
    foreach($users as $user){
      $user["register_date"] = date("d/m/Y H:i", $user["register_date"]);
      $user["id"] = (int)$user["id"];
      $user_data = self::GetNameSurname($user["id"]);
      $user["name"] = $user_data["name"];
      $user["surname"] = $user_data["surname"];
      $new_users[] = $user;
    }
    return $new_users;
  }

  public function GetNameSurname($user_id){
    $control = $this->db->prepare("SELECT `name`,`surname` FROM `profile_data` WHERE `user_id` = :user_id");
    $control->execute([
      ":user_id" => $user_id
    ]);
    $data = $control->fetch();
    return $data;
  }

}

?>
