<?php
/**
 * Yetkili Detayı
 */
class ManageAuthorizedUsers
{

  public function __construct($db){
    $this->db = $db;
  }

  public function AuthDetail(){
    $query = $this->db->prepare("SELECT * FROM `authorized_list` WHERE `email` = :email AND `password` = :password AND `isDeleted` = 0");
    $query->execute([":email" => $_SESSION["email"], ":password" => $_SESSION["password"]]);
    $data = $query->fetch();
    return $data;
  }

  private function GenerateAuthorizedGroup($id){
    $query = $this->db->prepare("SELECT * FROM `authorize_list` WHERE `isDeleted` = 0");
    $query->execute();
    $list = $query->fetchAll(PDO::FETCH_ASSOC);
    $html = '';
    $html .= '<div class="form-group">
               <label>Yetki Grubu</label>
                  <select class="form-control" disabled>';
                  foreach($list as $auth){
                    $html .= '<option '.($auth["id"] == $id ? 'selected' : '').' value="'.$auth["id"].'">'.$auth["authorize_name"].'</option>';
                  }
      $html .='</select>
                    </div>';
    return $html;
  }
  public function write(){
    $data = self::AuthDetail();
    $html = '<div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row align-items-center">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <h4 class="font-size-18">Profilim</h4>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item active">Profilim</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Profil Bilgileri</h4>
                                        <form id="addAuthForm" enctype="multipart/form-data" class="custom-validation" action="#">
                                            <div class="form-group">
                                                <label>Adı</label>
                                                <input name="name" type="text" value="'.$data["name"].'" class="form-control" required placeholder="Adınız"/>
                                            </div>
                                            <div class="form-group">
                                                <label>Soyadı</label>
                                                <input name="surname" value="'.$data["surname"].'" type="text" class="form-control" required placeholder="Soyadınız"/>
                                            </div>
                                            <div class="form-group">
                                                <label>E-Posta Adresi</label>
                                                <input name="email" value="'.$data["email"].'" type="text" class="form-control" required placeholder="E-Posta Adresiniz"/>
                                            </div>
                                            <div class="form-group">
                                                <label>Yeni Şifre</label>
                                                <input name="password" type="password" class="form-control" placeholder="Yeni Şifreniz (güncellenmesini istemiyorsanız boş bırakın)"/>
                                            </div>
                                            '.self::GenerateAuthorizedGroup($data["authorize_id"]).'
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




  public function UserInDatabase($email){
    $query = $this->db->prepare("SELECT `id` FROM `authorized_list` WHERE `email` = :email AND `isDeleted` = 0");
    $query->execute([":email" => $email]);
    $data = $query->fetch();
    return ($data) ? true : false;
  }

  public function Update($post){
    $data = self::AuthDetail();
    if(!isset($post["name"])){
      return ["status" => false, "message" => "Lütfen adınızı girin."];
    }
    if(!isset($post["surname"])){
      return ["status" => false, "message" => "Lütfen soyadınızı girin."];
    }

    if(!isset($post["password"])){
      return ["status" => false, "message" => "Lütfen geçerli şifre girin."];
    }

    if(!isset($post["email"])){
      return ["status" => false, "message" => "Lütfen e-posta adresinizi girin."];
    }

    if(!filter_var($post["email"], FILTER_VALIDATE_EMAIL)){
      return ["status" => false, "message" => "Lütfen geçerli bir e-posta adresi girin."];
    }
    if($post["password"] != "" && strlen(ltrim(rtrim($post["password"]))) < 5){
      return ["status" => false, "message" => "Lütfen en az 5 karakterden oluşan bir şifre girin."];
    }


    if($post["email"] != $data["email"]){
      if(self::UserInDatabase($post["email"])){
          return ["status" => false, "message" => "Aynı e-posta adresine sahip bir kullanıcı zaten sistemde mevcut."];
      }
    }
    $post["password"] = ($post["password"] != "") ? md5(sha1($post["password"])) : $data["password"];
    $update = $this->db->prepare("UPDATE `authorized_list` SET `name` = :name, `surname` = :surname, `email` = :email, `password` = :password WHERE `id` = :id");
    $update->execute([
      ":name" => $post["name"],
      ":surname" => $post["surname"],
      ":email" => $post["email"],
      ":password" => $post["password"],
      ":id" => $data["id"]
    ]);

    $_SESSION["email"] = $post["email"];
    $_SESSION["password"] = $post["password"];

    return ["status" => true];
  }
}

?>
