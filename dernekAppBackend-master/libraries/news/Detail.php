<?php
/**
 * Haberler Detayı
 */
class ManageNews
{

  public function __construct($db,$news_id){
    $this->db = $db;
    $this->news_id = $news_id;
  }

  public function Control(){
    $query = $this->db->prepare("SELECT `id` FROM `news` WHERE `id` = :id AND `isDeleted` = 0");
    $query->execute([":id" => $this->news_id]);
    $data = $query->fetch();
    return $data ? true : false;
  }
  public function NewsDetail(){
    $query = $this->db->prepare("SELECT * FROM `news` WHERE `id` = :id AND `isDeleted` = 0");
    $query->execute([":id" => $this->news_id]);
    $data = $query->fetch();
    $data["author"] = self::GetAuthor($data["author"]);
    return $data;
  }

  public function GetAuthor($user_id){
    $query = $this->db->prepare("SELECT `name`,`surname` FROM `authorized_list` WHERE `id` =:id AND `isDeleted` = 0");
    $query->execute([":id" => $user_id]);
    $data = $query->fetch();
    $return = "Bilinmiyor";
    if($data){
      $return = $data["name"]." ".$data["surname"];
    }
    return $return;
  }
  public function write(){
    $data = self::NewsDetail();
    $statusActive = $data["status"] == 1 ? 'selected' : '';
    $statusPassive = $data["status"] == 0 ? 'selected' : '';
    $html = '<div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="page-title-box">
                        <h4 class="font-size-18">Haber Güncelle</h4>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Haberler</a></li>
                            <li class="breadcrumb-item active">Haber Güncelle</li>
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
                                <a class="dropdown-item" href="list-news">Haber Listesi</a>
                                <a class="dropdown-item" href="add-news">Haber Ekle</a>
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
                                        <h4 class="card-title">Haber Güncelleme Formu</h4>
                                        <p class="card-title-desc">Lütfen formu eksiksiz ve istenen bir şekilde güncelleyin.</p>
                                        <form id="addNewsForm" enctype="multipart/form-data" class="custom-validation" action="#">
                                            <div class="form-group">
                                                <label>Haber Adı</label>
                                                <input id="newsName" type="text" class="form-control" value="'.$data["title"].'" required placeholder="Haber Adı"/>
                                            </div>
                                            <div class="form-group">
                                                <label>Haber Kısa Açıklama</label>
                                                <input id="newsShortDescription" type="text" class="form-control" value="'.$data["short_description"].'" required placeholder="Haber Kısa Açıklama"/>
                                            </div>
                                            <div id="imageArea" style="">
                                           <img class="img-thumbnail" alt="200x200" width="200" src="'.$data["thumbnail"].'" data-holder-rendered="true">
                                       </div>
                                            <div class="form-group">
                                                <label>Haber Görsel</label>
                                                <input id="newsImage" onchange="return fileValidation()" type="file" class="form-control" accept="image/x-png,image/gif,image/jpeg"/>
                                            </div>
                                            <div class="form-group">
                                                <label>Haber Kategori(ler)</label>
                                                <select id="newsCategories" class="custom-select form-control" multiple required size="5">
                                                '.self::GenerateCategoriesOption($data["categories"]).'
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Haber Açıklaması</label>
                                                <textarea id="newsContent" class="form-control" placeholder="Haber Açıklaması" rows="7">'.$data["content"].'</textarea>
                                            </div>

                                            <div class="form-group">
                                                <label>Haber Durumu</label>
                                                <select id="newsStatus" class="custom-select form-control" required>
                                                <option '.$statusActive.' value="1"> Aktif</option>
                                                <option '.$statusPassive.' value="0"> Pasif</option>
                                                </select>
                                            </div>


                                            <div class="form-group">
                                                <label>Haber Yazarı</label>
                                                <input type="text" readonly class="form-control" value="'.$data["author"].'" placeholder="Haber Yazarı"/>
                                            </div>
                                            <div class="form-group">
                                                <label>Eklenme Tarihi</label>
                                                <input type="text" readonly class="form-control" value="'.date("d/m/Y H:i", $data["added_time"]).'" placeholder="Haber Eklenme Tarihi"/>
                                            </div>
                                            <div class="form-group">
                                                <label>Son Güncellenme Tarihi</label>
                                                <input type="text" id="lastUpdateTime" readonly class="form-control" value="'.date("d/m/Y H:i", $data["last_update_time"]).'" placeholder="Haber Son Güncellenme Tarihi"/>
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

  public function User()
  {
      $query = $this
          ->db
          ->prepare("SELECT * FROM `authorized_list` WHERE `email` = :email AND `password` = :password AND `isDeleted` = 0");
      $query->execute([":email" => $_SESSION["email"], ":password" => $_SESSION["password"]]);
      return $query->fetch();
  }

  public function GenerateCategoriesOption($current){
    $current = json_decode($current);
    $query = $this->db->prepare("SELECT * FROM `categories` WHERE `isDeleted` = 0 ORDER BY `category_name` ASC");
    $query->execute();
    $text = "";
    $categories = $query->fetchAll(PDO::FETCH_ASSOC);
    foreach($categories as $category){
      $has = in_array($category["id"], $current) ? "selected" : "";
      $text .= '<option '.$has.' value="'.$category["id"].'">'.$category["category_name"].'</option>';
    }
    return $text;
  }
  public function CategoryInDatabase($category_id){
    $query = $this->db->prepare("SELECT * FROM `categories` WHERE `id` = :id AND `isDeleted` = 0");
    $query->execute([":id" => $category_id]);
    $data = $query->fetch();
    return ($data) ? true : false;
  }
  public function CategoryControl($categories){
    $query = $this->db->prepare("SELECT * FROM `categories` WHERE `isDeleted` = 0 ORDER BY `category_name` ASC");
    $query->execute();
    $dbCategories = $query->fetchAll(PDO::FETCH_ASSOC);
    $categories = explode(",", $categories);
    $type = true;
    foreach($categories as $category){
      if(!self::CategoryInDatabase($category)){
        $type = false;
      }
    }
    return $type;
  }
  public function Update($post, $small_image, $big_image,$id){
    if(!isset($post["newsContent"]) || !isset($post["newsCategories"]) || !isset($post["newsShortDescription"]) || !isset($post["newsName"])){
      return ["status" => false, "message" => "Lütfen formu doldurun."];
    }
    if(strlen($post["newsContent"]) < 1 || strlen($post["newsCategories"]) < 1 || strlen($post["newsShortDescription"]) < 1 || strlen($post["newsName"]) < 1){
      return ["status" => false, "message" => "Lütfen formu doldurun."];
    }
    if(!self::CategoryControl($post["newsCategories"])){
        return ["status" => false, "message" => "Seçilen bazı kategoriler sistemde tanımsız."];
    }

    if($post["newsStatus"] != 1 && $post["newsStatus"] != 0){
      return ["status" => false, "message" => "Seçilen haber durumu sistemde tanımsız."];
    }

    $post["newsCategories"] = '['.$post["newsCategories"].']';
    $newsCategories = json_decode($post["newsCategories"]);
    $newsCategories = array_unique($newsCategories);
    $newsCategories = json_encode($newsCategories);
    $add_update = "";
    $user = self::User();
    if($small_image != "current") {
      $small_image = str_replace("../", "", $small_image);
      $add_update .= ",`thumbnail` = '$small_image'";
    }
    if($big_image != "current") {
      $big_image = str_replace("../", "", $big_image);
      $add_update .= ",`image` = '$big_image'";
    }
    $curr_time = time();
    $update = $this->db->prepare("UPDATE `news` SET
      `title` = :newsName,
      `short_description` = :newsShortDescription,
      `content` = :newsContent,
      `categories` = :newsCategories,
      `status` = :status,
      `last_update_time` = :update_time $add_update
      WHERE `id` = :id
    ");
    $update->execute([
      ":newsName" => $post["newsName"],
      ":newsShortDescription" => $post["newsShortDescription"],
      ":newsContent" => $post["newsContent"],
      ":newsCategories" => $newsCategories,
      ":status" => $post["newsStatus"],
      ":update_time" => $curr_time,
      ":id" => $id
    ]);
    return ["status" => true, "id" => $id, "time" => date("d/m/Y H:i",$curr_time)];
  }
}

?>
