<?php
/**
 * Haberler Detayı
 */
class ManageNewsCategories
{

  public function __construct($db,$category_id){
    $this->db = $db;
    $this->category_id = $category_id;
  }

  public function Control(){
    $query = $this->db->prepare("SELECT `id` FROM `categories` WHERE `id` = :id AND `isDeleted` = 0");
    $query->execute([":id" => $this->category_id]);
    $data = $query->fetch();
    return $data ? true : false;
  }
  public function CategoryDetail(){
    $query = $this->db->prepare("SELECT * FROM `categories` WHERE `id` = :id AND `isDeleted` = 0");
    $query->execute([":id" => $this->category_id]);
    $data = $query->fetch();
    return $data;
  }


  public function write(){
    $data = self::CategoryDetail();
    $html = '<div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <div class="page-title-box">
                        <h4 class="font-size-18">Kategori Güncelle</h4>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Haberler</a></li>
                            <li class="breadcrumb-item active">Kategori Güncelle</li>
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
                                <a class="dropdown-item" href="list-categories">Kategori Listesi</a>
                                <a class="dropdown-item" href="add-category">Kategori Ekle</a>
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
                                        <h4 class="card-title">Kategori Güncelleme Formu</h4>
                                        <p class="card-title-desc">Lütfen formu eksiksiz ve istenen bir şekilde güncelleyin.</p>
                                        <form id="addCategoryForm" enctype="multipart/form-data" class="custom-validation" action="#">
                                            <div class="form-group">
                                                <label>Kategori Adı</label>
                                                <input id="categoryName" type="text" class="form-control" value="'.$data["category_name"].'" required placeholder="Kategori Adı"/>
                                            </div>

                                            <div class="form-group">
                                                <label>Eklenme Tarihi</label>
                                                <input type="text" readonly class="form-control" value="'.date("d/m/Y H:i", $data["added_time"]).'" placeholder="Kategori Eklenme Tarihi"/>
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


  public function CategoryInDatabase($category_name){
    $query = $this->db->prepare("SELECT * FROM `categories` WHERE `category_name` = :category_name AND `isDeleted` = 0");
    $query->execute([":category_name" => $category_name]);
    $data = $query->fetch();
    return ($data) ? true : false;
  }

  public function Update($post,$id){
    if(!isset($post["categoryName"])){
      return ["status" => false, "message" => "Lütfen formu doldurun."];
    }
    $data = self::CategoryDetail();
    if($data["category_name"] != $post["categoryName"]){
      if(self::CategoryInDatabase($post["categoryName"])){
          return ["status" => false, "message" => "Aynı isimde zaten bir kategori mevcut."];
      }
    }

    $update = $this->db->prepare("UPDATE `categories` SET
      `category_name` = :categoryName
      WHERE `id` = :id
    ");
    $update->execute([
      ":categoryName" => $post["categoryName"],
      ":id" => $id
    ]);
    return ["status" => true, "id" => $id];
  }
}

?>
