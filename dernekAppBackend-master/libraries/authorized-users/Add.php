<?php
/**
 * Yetkili Oluşturma
 */
class ManageAuthorizedUsers
{

  public function __construct($db){
    $this->db = $db;
  }
  private function GenerateAuthorizedGroup(){
    $query = $this->db->prepare("SELECT * FROM `authorize_list` WHERE `isDeleted` = 0");
    $query->execute();
    $list = $query->fetchAll(PDO::FETCH_ASSOC);
    $html = '';
    $html .= '<div class="form-group">
               <label>Yetki Grubu</label>
                  <select class="form-control" name= "authorize_id">';
                  foreach($list as $auth){
                    $html .= '<option value="'.$auth["id"].'">'.$auth["authorize_name"].'</option>';
                  }
      $html .='</select>
                    </div>';
    return $html;
  }
  public function write(){
    $html = '<div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="page-title-box">
                        <h4 class="font-size-18">Yeni Yetkili Oluştur</h4>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Yetkili Kullanıcılar</a></li>
                            <li class="breadcrumb-item active">Yetkili Ekle</li>
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
                                <a class="dropdown-item" href="list-authorized-users">Yetkili Listesi</a>
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
                                        <h4 class="card-title">Yetkili Oluşturma Formu</h4>
                                        <p class="card-title-desc">Lütfen formu eksiksiz ve istenen bir şekilde doldurun.</p>
                                        <form id="addAuthForm" enctype="multipart/form-data" class="custom-validation" action="#">
                                            <div class="form-group">
                                                <label>Adı</label>
                                                <input name="name" type="text" class="form-control" required placeholder="Adı"/>
                                            </div>
                                            <div class="form-group">
                                                <label>Soyadı</label>
                                                <input name="surname" type="text" class="form-control" required placeholder="Soyadı"/>
                                            </div>
                                            <div class="form-group">
                                                <label>E-Posta Adresi</label>
                                                <input name="email" type="text" class="form-control" required placeholder="E-Posta Adresi"/>
                                            </div>
                                            <div class="form-group">
                                                <label>Şifre</label>
                                                <input name="password" type="password" class="form-control" required placeholder="Şifre"/>
                                            </div>
                                            '.self::GenerateAuthorizedGroup().'
                                            <div class="form-group mb-0">
                                                <div>
                                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
                                                        Oluştur
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


  public function AuthInDatabase($auth_id){
    $query = $this->db->prepare("SELECT `id` FROM `authorize_list` WHERE `id` = :auth_id AND `isDeleted` = 0");
    $query->execute([":auth_id" => $auth_id]);
    $data = $query->fetch();
    return ($data) ? true : false;
  }

  public function UserInDatabase($email){
    $query = $this->db->prepare("SELECT `id` FROM `authorized_list` WHERE `email` = :email AND `isDeleted` = 0");
    $query->execute([":email" => $email]);
    $data = $query->fetch();
    return ($data) ? true : false;
  }

  public function Insert($post){
    if(!isset($post["name"])){
      return ["status" => false, "message" => "Lütfen yetkili adı girin."];
    }
    if(!isset($post["surname"])){
      return ["status" => false, "message" => "Lütfen yetkili soyadı girin."];
    }

    if(!isset($post["password"])){
      return ["status" => false, "message" => "Lütfen yetkili şifresi girin."];
    }
    if(strlen(ltrim(rtrim($post["password"]))) < 5){
      return ["status" => false, "message" => "Lütfen en az 5 karakterden oluşan bir şifre girin."];
    }
    if(!isset($post["email"])){
      return ["status" => false, "message" => "Lütfen yetkili e-posta adresi girin."];
    }

    if(!filter_var($post["email"], FILTER_VALIDATE_EMAIL)){
      return ["status" => false, "message" => "Lütfen geçerli bir e-posta adresi girin."];
    }

    if(!self::AuthInDatabase($post["authorize_id"])){
        return ["status" => false, "message" => "Seçmiş olduğunuz yetki grubu bulunamadı."];
    }

    if(self::UserInDatabase($post["email"])){
        return ["status" => false, "message" => "Aynı e-posta adresine sahip bir kullanıcı zaten sistemde mevcut."];
    }


    $insert = $this->db->prepare("INSERT INTO `authorized_list` (`id`, `name`, `surname`, `email`, `password`, `added_time`, `authorize_id`, `isDeleted`)
    VALUES (NULL, :name, :surname, :email, :password, :added_time, :authorize_id, :deleted)");
    $insert->execute([
      ":email" => $post["email"],
      ":password" => md5(sha1($post["password"])),
      ":surname" => $post["surname"],
      ":name" => $post["name"],
      ":authorize_id" => $post["authorize_id"],
      ":added_time" => time(),
      ":deleted" => 0
    ]);
    return ["status" => true, "id" => $this->db->lastInsertId()];
  }
}

?>
