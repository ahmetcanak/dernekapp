<?php
/**
 * Haber Kategorileri Listeleme İşlemi
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
                        <h4 class="font-size-18">Kategorileri Listele</h4>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Kategoriler</a></li>
                            <li class="breadcrumb-item active">Kategori Listesi</li>
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
                                <a class="dropdown-item" href="add-category">Kategori Ekle</a>
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

                            <h4 class="card-title">Kategori Listesi</h4>
                            <p class="card-title-desc">Kategoriler getiriliyor..</p>
                            <div id="progressbar" class="progress mb-4">
                                                <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                            <table id="list-categories"  class="table table-striped table-bordered dt-responsive nowrap responsive" style="border-collapse: collapse; border-spacing: 0; width:100%; display:none;">
                                <thead>
                                <tr>
                                    <th>#No</th>
                                    <th>Kategori Adı</th>
                                    <th>Haber Sayısı</th>
                                    <th>Eklenme Tarihi</th>
                                    <th class="notexport">İşlemler</th>
                                </tr>
                                </thead>


                                <tbody>';
        $categories = self::GetCategories();
        foreach($categories as $category){
          $html .= self::ListCategories($category);
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

  public function ListCategories($category){
    return '<tr kategori_tr_id="'.$category["id"].'">
        <td>'.$category["id"].'</td>
        <td>'.$category["category_name"].'</td>
        <td>'.$category["news_count"].'</td>
        <td>'.$category["added_time"].'</td>
        <td> <div class="btn-group" role="group">
                                                <button id="btnGroupVerticalDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    İşlemler
                                                    <i class="mdi mdi-chevron-down"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">
                                                    <a class="dropdown-item DeleteCategory" href="#">Sil</a>
                                                    <a class="dropdown-item" target="_blank" href="edit-category?id='.$category["id"].'">Düzenle</a>
                                                </div>
                                            </div></td>
    </tr>';
  }

  public function GetCategories(){
    $categories = $this->db->prepare("SELECT * FROM `categories` WHERE `isDeleted` = 0 ORDER BY `id` DESC ");
      $categories->execute();
      $categories = $categories->fetchAll(PDO::FETCH_ASSOC);
      $categories  = self::EditCategories($categories);
      return $categories;
  }
  public function GetNewsCount($category_id){
    $count = 0;
    $query = $this->db->prepare("SELECT `categories` FROM `news` WHERE `isDeleted` = 0");
    $query->execute();
    $news = $query->fetchAll(PDO::FETCH_ASSOC);
    foreach($news as $n){
      $arr = json_decode($n["categories"]);
      if(in_array($category_id,$arr)){
        $count++;
      }
    }
    return $count;
  }
  public function EditCategories($categories){
    $new_categories = [];
    foreach($categories as $category){
      $category["added_time"] = date("d/m/Y H:i", $category["added_time"]);
      $category["id"] = (int)$category["id"];
      $category["news_count"] = self::GetNewsCount($category["id"]);
      $new_categories[] = $category;
    }
    return $new_categories;
  }


}

?>
