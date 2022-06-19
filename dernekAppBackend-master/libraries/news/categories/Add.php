<?php
/**
 * Haber Kategorisi Oluşturma
 */
class ManageNewsCategories
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
                        <h4 class="font-size-18">Yeni Kategori Oluştur</h4>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Haberler</a></li>
                            <li class="breadcrumb-item active">Yeni Kategori Oluştur</li>
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
                                        <h4 class="card-title">Kategori Oluşturma Formu</h4>
                                        <p class="card-title-desc">Lütfen formu eksiksiz ve istenen bir şekilde doldurun.</p>
                                        <form id="addCategoryForm" enctype="multipart/form-data" class="custom-validation" action="#">
                                            <div class="form-group">
                                                <label>Kategori Adı</label>
                                                <input id="categoryName" type="text" class="form-control" required placeholder="Kategori Adı"/>
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


  public function CategoryInDatabase($category_name){
    $query = $this->db->prepare("SELECT `id` FROM `categories` WHERE `category_name` = :category_name AND `isDeleted` = 0");
    $query->execute([":category_name" => $category_name]);
    $data = $query->fetch();
    return ($data) ? true : false;
  }

  public function Insert($post){
    if(!isset($post["categoryName"])){
      return ["status" => false, "message" => "Lütfen formu doldurun."];
    }

    if(self::CategoryInDatabase($post["categoryName"])){
        return ["status" => false, "message" => "Aynı isimde bir kategori zaten mevcut."];
    }


    $insert = $this->db->prepare("INSERT INTO `categories` (`id`, `category_name`, `added_time`)
    VALUES (NULL, :categoryName, :insert_time)");
    $insert->execute([
      ":categoryName" => $post["categoryName"],
      ":insert_time" => time()
    ]);
    return ["status" => true, "id" => $this->db->lastInsertId()];
  }
}

?>
