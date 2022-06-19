<?php
/**
 * Yetki Grubu Oluşturma
 */
class ManageAuthorize
{

  public function __construct($db){
    $this->db = $db;
  }
  private function GenerateSelect($text,$name){
    return '<div class="form-group">
               <label>'.$text.'</label>
                  <select class="form-control" name= "'.$name.'">
                  <option value="0">Hayır</option>
                  <option value="1">Evet</option>
                  </select>
                    </div>';

  }
  public function write(){
    $html = '<div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="page-title-box">
                        <h4 class="font-size-18">Yeni Yetki Grubu Oluştur</h4>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Yetkilendirme</a></li>
                            <li class="breadcrumb-item active">Yetki Grubu Ekle</li>
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
                                <a class="dropdown-item" href="list-auth">Yetki Grubu Listesi</a>
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
                                        <h4 class="card-title">Yetki Grubu Oluşturma Formu</h4>
                                        <p class="card-title-desc">Lütfen formu eksiksiz ve istenen bir şekilde doldurun.</p>
                                        <form id="addAuthForm" enctype="multipart/form-data" class="custom-validation" action="#">
                                            <div class="form-group">
                                                <label>Yetki Grubu Adı</label>
                                                <input name="authorize_name" type="text" class="form-control" required placeholder="Yetki Grubu Adı"/>
                                            </div>
                                            '.self::GenerateSelect("Verileri Dışarıya Aktarabilir", "export_data").'
                                            '.self::GenerateSelect("Bildirim Gönderebilir", "send_notification").'
                                            '.self::GenerateSelect("Bildirim Silebilir", "delete_notification").'
                                            '.self::GenerateSelect("İşlem Kayıtlarını Görebilir", "show_logs").'
                                            '.self::GenerateSelect("İstatistikleri Görüntüleyebilir", "show_statistics").'
                                            '.self::GenerateSelect("Haber Ekleyebilir, Listeleyebilir ve Düzenleyebilir", "add_news").'
                                            '.self::GenerateSelect("Haber Silebilir", "delete_news").'
                                            '.self::GenerateSelect("Kullanıcı Ekleyebilir, Listeleyebilir ve Düzenleyebilir", "add_user").'
                                            '.self::GenerateSelect("Kullanıcı Silebilir", "delete_user").'
                                            '.self::GenerateSelect("Kategori Ekleyebilir, Listeleyebilir ve Düzenleyebilir", "add_category").'
                                            '.self::GenerateSelect("Kategori Silebilir", "delete_category").'
                                            '.self::GenerateSelect("Mesaj Listeyebilir ve Okuyabilir", "read_messages").'
                                            '.self::GenerateSelect("Mesaj Silebilir", "delete_messages").'
                                            '.self::GenerateSelect("Yetki Grubu Ekleyebilir, Listeleyebilir ve Düzenleyebilir", "add_auth").'
                                            '.self::GenerateSelect("Yetki Grubu Silebilir", "delete_auth").'
                                            '.self::GenerateSelect("Yetkili Kullanıcı Ekleyebilir, Listeleyebilir ve Düzenleyebilir", "add_auth_user").'
                                            '.self::GenerateSelect("Yetkili Kullanıcı Silebilir", "delete_auth_user").'
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


  public function AuthInDatabase($authorize_name){
    $query = $this->db->prepare("SELECT `id` FROM `authorize_list` WHERE `authorize_name` = :authorize_name AND `isDeleted` = 0");
    $query->execute([":authorize_name" => $authorize_name]);
    $data = $query->fetch();
    return ($data) ? true : false;
  }

  public function Insert($post){
    if(!isset($post["authorize_name"])){
      return ["status" => false, "message" => "Lütfen yetki grubu adı girin."];
    }

    if(self::AuthInDatabase($post["authorize_name"])){
        return ["status" => false, "message" => "Aynı isimde bir yetki grubu zaten mevcut."];
    }


    $insert = $this->db->prepare("INSERT INTO `authorize_list` (`id`, `authorize_name`, `export_data`, `send_notification`, `show_logs`, `show_statistics`,
     `delete_notification`, `add_news`, `delete_news`, `add_user`, `delete_user`, `add_category`, `delete_category`, `read_messages`, `delete_messages`, `add_auth`,
     `delete_auth`, `add_auth_user`, `delete_auth_user`, `added_time`, `isDeleted`)
     VALUES (NULL, :authorize_name, :export_data, :send_notification, :show_logs, :show_statistics, :delete_notification, :add_news,
       :delete_news, :add_user, :delete_user, :add_category, :delete_category, :read_messages, :delete_messages,
       :add_auth, :delete_auth, :add_auth_user, :delete_auth_user, :added_time, :deleted)");
    $insert->execute([
      ":authorize_name" => $post["authorize_name"],
      ":export_data" => $post["export_data"],
      ":send_notification" => $post["send_notification"],
      ":show_logs" => $post["show_logs"],
      ":show_statistics" => $post["show_statistics"],
      ":delete_notification" => $post["delete_notification"],
      ":add_news" => $post["add_news"],
      ":delete_news" => $post["delete_news"],
      ":add_user" => $post["add_user"],
      ":delete_user" => $post["delete_user"],
      ":add_category" => $post["add_category"],
      ":delete_category" => $post["delete_category"],
      ":read_messages" => $post["read_messages"],
      ":delete_messages" => $post["delete_messages"],
      ":add_auth" => $post["add_auth"],
      ":delete_auth" => $post["delete_auth"],
      ":add_auth_user" => $post["add_auth_user"],
      ":delete_auth_user" => $post["delete_auth_user"],
      ":added_time" => time(),
      ":deleted" => 0
    ]);
    return ["status" => true, "id" => $this->db->lastInsertId()];
  }
}

?>
