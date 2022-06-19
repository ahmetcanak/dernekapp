<?php
/**
 * Kullanıcı Detayı
 */
class ManageUsers
{

  public function __construct($db,$user_id){
    $this->db = $db;
    $this->user_id = $user_id;
  }

  public function Control(){
    $query = $this->db->prepare("SELECT `id` FROM `users` WHERE `id` = :id AND `isDeleted` = 0");
    $query->execute([":id" => $this->user_id]);
    $data = $query->fetch();
    return $data ? true : false;
  }
  public function UserDetail(){
    $query = $this->db->prepare("SELECT * FROM `users` WHERE `id` = :id AND `isDeleted` = 0");
    $query->execute([":id" => $this->user_id]);
    $data = $query->fetch();
    $data["profile_data"] = self::GetProfileData();
    return $data;
  }

  public function GetChildrens(){
    $query = $this->db->prepare("SELECT * FROM `children_list` WHERE `parent_id` = :id AND `isDeleted` = 0");
    $query->execute([":id" => $this->user_id]);
    $data = $query->fetchAll(PDO::FETCH_ASSOC);
    return $data;
  }


  public function GetProfileData(){
    $query = $this->db->prepare("SELECT * FROM `profile_data` WHERE `user_id` =:id AND `isDeleted` = 0");
    $query->execute([":id" => $this->user_id]);
    $data = $query->fetch();
    $data["children_list"] = self::GetChildrens();
    return $data;
  }
  public function GenerateEducationOptions($current){
    $text = '';
    $text .= '<option value="İlkokul" '.($current == "İlkokul" ? "selected" : "").'>İlkokul</option>';
    $text .= '<option value="Ortaokul" '.($current == "Ortaokul" ? "selected" : "").'>Ortaokul</option>';
    $text .= '<option value="Lise" '.($current == "Lise" ? "selected" : "").'>Lise</option>';
    $text .= '<option value="Ön Lisans" '.($current == "Ön Lisans" ? "selected" : "").'>Ön Lisans</option>';
    $text .= '<option value="Lisans" '.($current == "Lisans" ? "selected" : "").'>Lisans</option>';
    $text .= '<option value="Yüksek Lisans" '.($current == "Yüksek Lisans" ? "selected" : "").'>Yüksek Lisans</option>';
    $text .= '<option value="Doktora" '.($current == "Doktora" ? "selected" : "").'>Doktora</option>';

    return $text;
  }


  public function GenerateBloodGroupOptions($current){
    $text = '';
    $text .= '<option value="Bilinmiyor" '.($current == "Bilinmiyor" ? "selected" : "").'>Bilinmiyor</option>';
    $text .= '<option value="0-" '.($current == "0-" ? "selected" : "").'>0-</option>';
    $text .= '<option value="0+" '.($current == "0+" ? "selected" : "").'>0+</option>';
    $text .= '<option value="A-" '.($current == "A-" ? "selected" : "").'>A-</option>';
    $text .= '<option value="A+" '.($current == "A+" ? "selected" : "").'>A+</option>';
    $text .= '<option value="B-" '.($current == "B-" ? "selected" : "").'>B-</option>';
    $text .= '<option value="B+" '.($current == "B+" ? "selected" : "").'>B+</option>';
    $text .= '<option value="AB-" '.($current == "AB-" ? "selected" : "").'>AB-</option>';
    $text .= '<option value="AB+" '.($current == "AB+" ? "selected" : "").'>AB+</option>';

    return $text;
  }
  public function GenerateChildrenForm($children){
    $text = '';
    $i = 0;
    foreach($children as  $child){
      $text .= '
<div class="card childAppend">
   <div class="card-header">
       <span style="color:red; cursor:pointer;" class="removeChild"> [X] Çocuğu Kaldır </span>
   </div>
   <div class="card-body">
   <div class="form-group">
       <label>Adı</label>
       <input name="children['.$i.'][\'name\']" type="text" class="form-control" value="'.$child["name"].'" required placeholder="Adı"/>
   </div>
   <div class="form-group">
       <label>Soyadı</label>
       <input name="children['.$i.'][\'surname\']" type="text" class="form-control" value="'.$child["surname"].'" required placeholder="Soyadı"/>
   </div>
   <div class="form-group">
       <label>Doğum Tarihi</label>
       <input name="children['.$i.'][\'birth_date\']" value="'.date("Y-m-d", $child["birth_date"]).'"  type="date" class="form-control" />
   </div>
   <div class="form-group">
       <label>Medeni Durumu</label>
       <input name="children['.$i.'][\'marital_status\']" type="text" class="form-control" value="'.$child["marital_status"].'" required placeholder="Medeni Durumu"/>
   </div>
   <div class="form-group">
       <label>Mesleği</label>
       <input name="children['.$i.'][\'job\']" type="text" required class="form-control" value="'.$child["job"].'" required placeholder="Mesleği"/>
   </div>
   <div class="form-group">
       <label>Eğitim Durumu</label>
       <select required name="children['.$i.'][\'education_status\']" class="form-control">
       '.self::GenerateEducationOptions($child["education_status"]).'
       </select>
   </div>
       <div class="form-group">
           <label>Kan Grubu</label>
           <select required name="children['.$i.'][\'blood_group\']" class="form-control">
               '.self::GenerateBloodGroupOptions($child["blood_group"]).'
           </select>
       </div>
       <div class="form-group">
           <label>Telefon Numarası</label>
           <input name="children['.$i.'][\'phone_number\']" value="'.$child["phone_number"].'"  oninput="this.value = this.value.replace(/[^0-9.]/g, \'\').replace(/(\..*)\./g, \'$1\');" type="text" class="form-control" minlength="10" maxlength="10" required placeholder="Telefon Numarası (Başında 0 olmadan, bitişik)" />
       </div>
   </div>
</div>';
$i++;
    }

    return $text;
  }

  public function UserPhone(){
    $query = $this->db->prepare("SELECT `phone_number` FROM `users` WHERE `id` = :id AND `isDeleted` = 0");
    $query->execute([":id" => $this->user_id]);
    $data = $query->fetch();
    return $data["phone_number"];
  }

  public function write(){
    $data = self::UserDetail();
    $html = '<div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="page-title-box">
                        <h4 class="font-size-18">Kullanıcı Güncelle</h4>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Kullanıcılar</a></li>
                            <li class="breadcrumb-item active">Kullanıcı Güncelle</li>
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
                                <a class="dropdown-item" href="list-users">Kullanıcı Listesi</a>
                                <a class="dropdown-item" href="add-user">Kullanıcı Ekle</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Kullanıcı Güncelleme Formu</h4>
                                        <p class="card-title-desc">Lütfen formu eksiksiz ve istenen bir şekilde güncelleyin.</p>
                                        <form id="updateUserForm" enctype="multipart/form-data" class="custom-validation" action="#">
                                            <div class="form-group">
                                                <label>Adı</label>
                                                <input name="name" type="text" class="form-control" value="'.$data["profile_data"]["name"].'" required placeholder="Adı"/>
                                            </div>
                                            <div class="form-group">
                                                <label>Soyadı</label>
                                                <input name="surname" type="text" class="form-control" value="'.$data["profile_data"]["surname"].'" required placeholder="Soyadı"/>
                                            </div>
                                            <div class="form-group">
                                                <label>Telefon Numarası</label>
                                                <input name="phone_number" value="'.$data["phone_number"].'"  oninput="this.value = this.value.replace(/[^0-9.]/g, \'\').replace(/(\..*)\./g, \'$1\');" type="text" class="form-control" minlength="10" maxlength="10" required placeholder="Telefon Numarası (Başında 0 olmadan, bitişik)" />
                                            </div>
                                            <div class="form-group">
                                                <label>Yeni Şifre</label>
                                                <input name="password" id="password" minlength="5" maxlength="256" type="text" class="form-control" placeholder="Yeni Şifre (güncellenmesini istemiyorsanız boş bırakın)" />
                                            </div>
                                            <div class="form-group" style="display:none;" id="passwordAgainArea">
                                                <label>Tekrar Yeni Şifre</label>
                                                <input id="passwordAgain" minlength="5" maxlength="256" type="text" class="form-control" placeholder="Tekrar Yeni Şifre" />
                                            </div>
                                            <div class="form-group">
                                                <label>TC Kimlik Numarası</label>
                                                <input name="tc_id" value="'.$data["profile_data"]["tc_id"].'"  oninput="this.value = this.value.replace(/[^0-9.]/g, \'\').replace(/(\..*)\./g, \'$1\');" type="text" class="form-control" minlength="11" maxlength="11" required placeholder="TC Kimlik Numarası" />
                                            </div>
                                            <div class="form-group">
                                                <label>E-Posta Adresi</label>
                                                <input name="email" value="'.$data["profile_data"]["email"].'"  type="text" class="form-control" placeholder="E-Posta Adresi" />
                                            </div>
                                            <div class="form-group">
                                                <label>Doğum Tarihi</label>
                                                <input name="birth_date" value="'.date("Y-m-d", $data["profile_data"]["birth_date"]).'"  type="date" class="form-control" />
                                            </div>
                                            <div class="form-group">
                                                <label>Eğitim Durumu</label>
                                                <select name="education_status" class="form-control">
                                                '.self::GenerateEducationOptions($data["profile_data"]["education_status"]).'
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Kan Grubu</label>
                                                <select name="blood_group" class="form-control">
                                                '.self::GenerateBloodGroupOptions($data["profile_data"]["blood_group"]).'
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Meslek</label>
                                                <input name="job" value="'.$data["profile_data"]["job"].'"   type="text" class="form-control" placeholder="Meslek" />
                                            </div>
                                            <div class="form-group">
                                                <label>Baba Adı</label>
                                                <input name="father_name" value="'.$data["profile_data"]["father_name"].'"   type="text" class="form-control" placeholder="Baba Adı" />
                                            </div>
                                            <div class="form-group">
                                                <label>Anne Adı</label>
                                                <input name="mother_name" value="'.$data["profile_data"]["mother_name"].'"   type="text" class="form-control" placeholder="Anne Adı" />
                                            </div>
                                            <div class="form-group">
                                                <label>Anne\'nin Babasının Adı</label>
                                                <input name="mothers_father_name" value="'.$data["profile_data"]["mothers_father_name"].'"   type="text" class="form-control" placeholder="Anne\'nin Babasının Adı" />
                                            </div>
                                            <div class="form-group">
                                                <label>Köydeki Lakabı</label>
                                                <input name="village_nickname" value="'.$data["profile_data"]["village_nickname"].'" required  type="text" class="form-control" placeholder="Köydeki Lakabı" />
                                            </div>

                                            <div class="form-group">
                                                <label>Köydeki Mahallesi</label>
                                                <input name="village_neighborhood" value="'.$data["profile_data"]["village_neighborhood"].'" required  type="text" class="form-control" placeholder="Köydeki Mahallesi" />
                                            </div>

                                            <div class="form-group">
                                                <label>İş Telefonu</label>
                                                <input name="job_phone" value="'.$data["profile_data"]["job_phone"].'"  oninput="this.value = this.value.replace(/[^0-9.]/g, \'\').replace(/(\..*)\./g, \'$1\');" type="text" class="form-control" placeholder="İş Telefonu" />
                                            </div>

                                            <div class="form-group">
                                                <label>İş Adresi</label>
                                                <textarea name="job_address" placeholder="İş Adresi" class="form-control">'.$data["profile_data"]["job_address"].'</textarea>
                                            </div>

                                            <div class="form-group">
                                                <label>Ev Telefonu</label>
                                                <input name="home_phone" value="'.$data["profile_data"]["home_phone"].'"  oninput="this.value = this.value.replace(/[^0-9.]/g, \'\').replace(/(\..*)\./g, \'$1\');" type="text" class="form-control" placeholder="Ev Telefonu" />
                                            </div>

                                            <div class="form-group">
                                                <label>Ev Adresi</label>
                                                <textarea name="home_address" placeholder="Ev Adresi" class="form-control">'.$data["profile_data"]["home_address"].'</textarea>
                                            </div>

                                            <div class="form-group">
                                                <label>Eşinin Adı</label>
                                                <input name="spouse_name" value="'.$data["profile_data"]["spouse_name"].'"   type="text" class="form-control" placeholder="Eşinin Adı" />
                                            </div>

                                            <div class="form-group">
                                                <label>Eşinin Kan Grubu</label>
                                                <select name="spouse_blood_group" class="form-control">
                                                '.self::GenerateBloodGroupOptions($data["profile_data"]["spouse_blood_group"]).'
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label>Eşi\'nin Babasının Adı</label>
                                                <input name="spouse_father" value="'.$data["profile_data"]["spouse_father"].'"   type="text" class="form-control" placeholder="Eşi\'nin Babasının Adı" />
                                            </div>
                                            <div class="form-group">
                                                <label>Çocuk Bilgileri</label>
                                                <div id="chilrenArea">
                                                  '.self::GenerateChildrenForm($data["profile_data"]["children_list"]).'
                                                  </div>
                                                </div>
                                                <hr />
                                                <button id="AddNewChild" type="button" class="btn btn-secondary btn-sm btn-block waves-effect">Çocuk Ekle</button>
                                                <hr />
                                                <br />
                                            <div class="form-group">
                                                <label>Kayıt IP Adresi</label>
                                                <input type="text" readonly class="form-control" value="'.$data["register_ip"].'" placeholder="Kayıt IP Adresi"/>
                                            </div>
                                            <div class="form-group">
                                                <label>Kayıt Tarihi</label>
                                                <input type="text" readonly class="form-control" value="'.date("d/m/Y H:i", $data["register_date"]).'" placeholder="Kayıt Tarihi"/>
                                            </div>
                                            <div class="form-group">
                                                <label>Son IP Adresi</label>
                                                <input type="text" readonly class="form-control" value="'.$data["last_join_ip"].'" placeholder="Son IP Adresi"/>
                                            </div>
                                            <div class="form-group">
                                                <label>Son Giriş Tarihi</label>
                                                <input type="text" readonly class="form-control" value="'.date("d/m/Y H:i", $data["last_join_time"]).'" placeholder="Son Giriş Tarihi"/>
                                            </div>
                                            <div class="form-group mb-0">
                                                <div>
                                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
                                                        Güncelle
                                                    </button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->



        </div> <!-- container-fluid -->
    </div>';
    return $html;
  }

  public function ControlAnotherNumber($phone){
      $control = $this->db->prepare("SELECT `id` FROM `users` WHERE `phone_number` = :phone_number AND `isDeleted` = 0");
      $control->execute([
        ":phone_number" => $phone
      ]);
      $data = $control->fetch();
    return ($data) ? true : false;
  }

  public function User()
  {
      $query = $this
          ->db
          ->prepare("SELECT * FROM `authorized_list` WHERE `email` = :email AND `password` = :password AND `isDeleted` = 0");
      $query->execute([":email" => $_SESSION["email"], ":password" => $_SESSION["password"]]);
      return $query->fetch();
  }


  public function Update($data, $children){
    $data = json_decode(json_encode($data), FALSE);
    if(!isset($data->name) || strlen($data->name) < 2 || strlen($data->name) > 64){
      return ["status"=>false, "message" => "Lütfen adınızı girin."];
    }

    if(!isset($data->surname) || strlen($data->surname) < 2 || strlen($data->surname) > 64){
      return ["status"=>false, "message" => "Lütfen soyadınızı girin."];
    }

    if(!isset($data->phone_number) ||strlen($data->phone_number) != 10 || !is_numeric($data->phone_number)){
      return ["status"=>false, "message" => "Lütfen telefon numaranızı kontrol edin."];
    }

    if(!isset($data->village_nickname) || strlen(ltrim(rtrim($data->village_nickname))) == 0){
      return ["status"=>false, "message" => "Lütfen köydeki lakabınızı girin."];
    }

    if(!isset($data->village_neighborhood) || strlen($data->village_neighborhood) == 0){
      return ["status"=>false, "message" => "Lütfen köydeki mahallenizi girin."];
      exit;
    }

    if(!isset($data->tc_id) || strlen($data->tc_id) != 11 || !is_numeric($data->tc_id)){
      return ["status"=>false, "message" => "Lütfen geçerli bir TC kimlik numarası girin."];
      exit;
    }

     if(!isset($data->education_status) || $data->education_status != "İlkokul" &&
        $data->education_status != "Ortaokul" &&
        $data->education_status != "Lise" &&
        $data->education_status != "Ön Lisans" &&
        $data->education_status != "Lisans" &&
        $data->education_status != "Yüksek Lisans" &&
        $data->education_status != "Doktora"){
          return ["status"=>false, "message" => "Geçersiz tahsil değeri."];
          exit;
        }

        if(!isset($data->blood_group) || $data->blood_group != "Bilinmiyor" &&
           $data->blood_group != "0-" &&
           $data->blood_group != "0+" &&
           $data->blood_group != "A-" &&
           $data->blood_group != "A+" &&
           $data->blood_group != "B-" &&
           $data->blood_group != "B+" &&
           $data->blood_group != "AB-" &&
           $data->blood_group != "AB+"){
             return ["status"=>false, "message" => "Geçersiz kan grubu değeri."];
             exit;
           }
    if($data->phone_number != self::UserPhone()){
      if(self::ControlAnotherNumber($data->phone_number)){
        return ["status" => false, "message" => "Girmiş olduğunuz telefon numarası başka bir kullanıcı tarafından kullanılıyor."];
      }

    }
    $data->birth_date = isset($data->birth_date) && $data->birth_date != "" ? $data->birth_date : null;
    $data->email = isset($data->email) && $data->email != "" ? $data->email : null;
    $data->job = isset($data->job) && $data->job != "" ? $data->job : null;
    $data->father_name = isset($data->father_name) && $data->father_name != "" ? $data->father_name : null;
    $data->mother_name = isset($data->mother_name) && $data->mother_name != "" ? $data->mother_name : null;
    $data->mothers_father_name = isset($data->mothers_father_name) && $data->mothers_father_name != "" ? $data->mothers_father_name : null;
    $data->home_address = isset($data->home_address) && $data->home_address != "" ? $data->home_address : null;
    $data->job_address = isset($data->job_address) && $data->job_address != "" ? $data->job_address : null;
    $data->job_phone = isset($data->job_phone) && $data->job_phone != "" ? $data->job_phone : null;
    $data->home_phone = isset($data->home_phone) && $data->home_phone != "" ? $data->home_phone : null;
    $data->spouse_blood_group = isset($data->spouse_blood_group) && $data->spouse_blood_group != "" ? $data->spouse_blood_group : null;
    $data->spouse_name = isset($data->spouse_name) && $data->spouse_name != "" ? $data->spouse_name : null;
    $data->spouse_father = isset($data->spouse_father) && $data->spouse_father != ""  ?  $data->spouse_father : null;

    if($data->birth_date != null){
      $data->birth_date = implode("-", array_reverse(explode("/", $data->birth_date)));
      $data->birth_date = strtotime($data->birth_date);
    }

    if($data->email != null){
      if(!filter_var($data->email, FILTER_VALIDATE_EMAIL)){
        return ["status" => false, "message" => "Lütfen geçerli bir E-Posta adresi girin."];
      }
    }

    foreach($children as $child){
      $child = json_decode(json_encode($child), FALSE);
      if(!isset($child->name) || !isset($child->surname) || !isset($child->birth_date) || !isset($child->marital_status)
      || !isset($child->job) || !isset($child->blood_group) || !isset($child->education_status) || !isset($child->phone_number)
      || ltrim(rtrim($child->name)) == "" || ltrim(rtrim($child->surname)) == "" || ltrim(rtrim($child->marital_status)) == ""
      || ltrim(rtrim($child->job)) == ""){
        return ["status" => false, "message" => "Lütfen çocuklar listesinde tüm formu doldurun."];
      }
      if(strlen($child->phone_number) != 10 || !is_numeric($child->phone_number)){
        return ["status" => false, "message" => "Lütfen çocuklar listesinde girilen telefon numarasını kontrol edin."];
      }
    }
    if($data->password != "") {
      if(strlen($data->password) < 5){
          return ["status" => false, "message" => "Lütfen en az 5 haneden oluşan bir şifre seçin."];
      }
      $updateUserPass = $this->db->prepare("UPDATE `users` SET `password` = :password WHERE `id` = :id AND `isDeleted` = 0");
      $updateUserPass->execute([":password" => md5(sha1($data->password)), ":id" => $this->user_id]);
    }


    $updateUserPhone = $this->db->prepare("UPDATE `users` SET `phone_number` = :phone_number WHERE `id` = :id AND `isDeleted` = 0");
    $updateUserPhone->execute([":phone_number" => $data->phone_number, ":id" => $this->user_id]);

    $deleteChilds = $this->db->prepare("UPDATE `children_list` SET `isDeleted` = :isDeleted WHERE `parent_id` = :parent_id");
    $deleteChilds->execute([":isDeleted"=> 1, ":parent_id" => $this->user_id]);

    foreach($children as $child){
      $child = json_decode(json_encode($child), FALSE);
      $child->birth_date = implode("-", array_reverse(explode("/", $child->birth_date)));
      $child->birth_date = strtotime($child->birth_date);
      $insertChild = $this->db->prepare("INSERT INTO `children_list` (`id`, `parent_id`, `name`, `surname`, `birth_date`, `marital_status`,
         `job`, `blood_group`, `education_status`, `phone_number`, `isDeleted`) VALUES (NULL,
        :parent_id, :name, :surname, :birth_date, :marital_status, :job, :blood_group, :education_status, :phone_number, :isDeleted)");
        $insertChild->execute([
          ":parent_id" => $this->user_id,
          ":name" => $child->name,
          ":surname" => $child->surname,
          ":birth_date" => $child->birth_date,
          ":marital_status" => $child->marital_status,
          ":job" => $child->job,
          ":blood_group" => $child->blood_group,
          ":education_status" => $child->education_status,
          ":phone_number" => $child->phone_number,
          ":isDeleted" => 0
        ]);
      }
      $update = $this->db->prepare("UPDATE `profile_data` SET
        `tc_id` = :tc_id,
        `email` = :email,
        `name` = :name,
        `surname` = :surname,
        `birth_date` = :birth_date,
        `education_status` = :education_status,
        `job` = :job,
        `blood_group` = :blood_group,
        `father_name` = :father_name,
        `mother_name` = :mother_name,
        `mothers_father_name` = :mothers_father_name,
        `village_nickname` = :village_nickname,
        `village_neighborhood` = :village_neighborhood,
        `home_address` = :home_address,
        `job_address` = :job_address,
        `job_phone` = :job_phone,
        `home_phone` = :home_phone,
        `spouse_name` = :spouse_name,
        `spouse_blood_group` = :spouse_blood_group,
        `spouse_father` = :spouse_father
        WHERE `user_id` = :user_id
      ");

      $update->execute([
        ":tc_id" => $data->tc_id,
        ":email" => $data->email,
        ":name" => $data->name,
        ":surname" => $data->surname,
        ":birth_date" => $data->birth_date,
        ":education_status" => $data->education_status,
        ":job" => $data->job,
        ":blood_group" => $data->blood_group,
        ":father_name" => $data->father_name,
        ":mother_name" => $data->mother_name,
        ":mothers_father_name" => $data->mothers_father_name,
        ":village_nickname" => $data->village_nickname,
        ":village_neighborhood" => $data->village_neighborhood,
        ":home_address" => $data->home_address,
        ":job_address" => $data->job_address,
        ":job_phone" => $data->job_phone,
        ":home_phone" => $data->home_phone,
        ":spouse_blood_group" => $data->spouse_blood_group,
        ":spouse_name" => $data->spouse_name,
        ":spouse_father" => $data->spouse_father,
        ":user_id" => $this->user_id
      ]);
    return ["status" => true, "id" => $this->user_id];
  }
}

?>
