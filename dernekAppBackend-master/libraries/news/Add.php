<?php
/**
 * Haberler Oluşturma
 */
class ManageNews
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
                        <h4 class="font-size-18">Yeni Haber Oluştur</h4>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Haberler</a></li>
                            <li class="breadcrumb-item active">Yeni Haber Oluştur</li>
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
                                        <h4 class="card-title">Haber Oluşturma Formu</h4>
                                        <p class="card-title-desc">Lütfen formu eksiksiz ve istenen bir şekilde doldurun.</p>
                                        <form id="addNewsForm" enctype="multipart/form-data" class="custom-validation" action="#">
                                            <div class="form-group">
                                                <label>Haber Adı</label>
                                                <input id="newsName" type="text" class="form-control" required placeholder="Haber Adı"/>
                                            </div>
                                            <div class="form-group">
                                                <label>Haber Kısa Açıklama</label>
                                                <input id="newsShortDescription" type="text" class="form-control" required placeholder="Haber Kısa Açıklama"/>
                                            </div>
                                            <div id="imageArea" style="display:none;">
                                           <img class="img-thumbnail" alt="200x200" width="200" src="assets/images/small/img-3.jpg" data-holder-rendered="true">
                                       </div>
                                            <div class="form-group">
                                                <label>Haber Görsel</label>
                                                <input id="newsImage" onchange="return fileValidation()" type="file" class="form-control" accept="image/x-png,image/gif,image/jpeg" required/>
                                            </div>
                                            <div class="form-group">
                                                <label>Haber Kategori(ler)</label>
                                                <select id="newsCategories" class="custom-select form-control" multiple required size="5">
                                                '.self::GenerateCategoriesOption().'
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Haber Açıklaması</label>
                                                <textarea id="newsContent" class="form-control" placeholder="Haber Açıklaması" rows="7"></textarea>
                                            </div>

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

  public function User()
  {
      $query = $this
          ->db
          ->prepare("SELECT * FROM `authorized_list` WHERE `email` = :email AND `password` = :password");
      $query->execute([":email" => $_SESSION["email"], ":password" => $_SESSION["password"]]);
      return $query->fetch();
  }

  public function GenerateCategoriesOption(){
    $query = $this->db->prepare("SELECT * FROM `categories` WHERE `isDeleted` = 0 ORDER BY `category_name` ASC");
    $query->execute();
    $text = "";
    $categories = $query->fetchAll(PDO::FETCH_ASSOC);
    foreach($categories as $category){
      $text .= '<option value="'.$category["id"].'">'.$category["category_name"].'</option>';
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
  public function Insert($post, $small_image, $big_image){
    if(!isset($post["newsContent"]) || !isset($post["newsCategories"]) || !isset($post["newsShortDescription"]) || !isset($post["newsName"])){
      return ["status" => false, "message" => "Lütfen formu doldurun."];
    }
    if(strlen($post["newsContent"]) < 1 || strlen($post["newsCategories"]) < 1 || strlen($post["newsShortDescription"]) < 1 || strlen($post["newsName"]) < 1){
      return ["status" => false, "message" => "Lütfen formu doldurun."];
    }
    if(!self::CategoryControl($post["newsCategories"])){
        return ["status" => false, "message" => "Seçilen bazı kategoriler sistemde tanımsız."];
    }
    $post["newsCategories"] = '['.$post["newsCategories"].']';
    $newsCategories = json_decode($post["newsCategories"]);
    $newsCategories = array_unique($newsCategories);
    $newsCategories = json_encode($newsCategories);
    $user = self::User();
    $small_image = str_replace("../", "", $small_image);
    $big_image = str_replace("../", "", $big_image);
    $insert = $this->db->prepare("INSERT INTO `news` (`id`, `title`, `short_description`, `content`, `categories`, `thumbnail`, `image`, `author`, `status`, `added_time`, `last_update_time`)
    VALUES (NULL, :newsName, :newsShortDescription, :newsContent, :newsCategories, :small_image, :big_image, :author, :status, :insert_time, :insert_time)");
    $insert->execute([
      ":newsName" => $post["newsName"],
      ":newsShortDescription" => $post["newsShortDescription"],
      ":newsContent" => $post["newsContent"],
      ":newsCategories" => $newsCategories,
      ":small_image" => $small_image,
      ":big_image" => $big_image,
      ":author" => (int)$user["id"],
      ":status" => 1,
      ":insert_time" => time()
    ]);
    return ["status" => true, "id" => $this->db->lastInsertId()];
  }
}

?>
