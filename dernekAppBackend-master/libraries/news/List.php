<?php
/**
 * Haberleri Listeleme İşlemi
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
                        <h4 class="font-size-18">Haberleri Listele</h4>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Haberler</a></li>
                            <li class="breadcrumb-item active">Haber Listesi</li>
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
                                <a class="dropdown-item" href="add-news">Haber Ekle</a>
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

                            <h4 class="card-title">Haber Listesi</h4>
                            <p class="card-title-desc">Haberler getiriliyor..</p>
                            <div id="progressbar" class="progress mb-4">
                                                <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                            <table id="list-news"  class="table table-striped table-bordered dt-responsive nowrap responsive" style="border-collapse: collapse; border-spacing: 0; width:100%; display:none;">
                                <thead>
                                <tr>
                                    <th>#No</th>
                                    <th>Haber Adı</th>
                                    <th class="notexport">Haber Görseli</th>
                                    <th>Kategoriler</th>
                                    <th>Eklenme Tarihi</th>
                                    <th>Durumu</th>
                                    <th>Oluşturan</th>
                                    <th class="notexport">İşlemler</th>
                                </tr>
                                </thead>


                                <tbody>';
        $news = self::GetNews();
        $generalSettings = self::GetGeneralSettings();
        foreach($news as $new){
          $html .= self::ListNews($new, $generalSettings["url"]);
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

  public function ListNews($news, $url){
    $author = self::GetAuthor($news["author"]);
    return '<tr haber_tr_id="'.$news["id"].'">
        <td>'.$news["id"].'</td>
        <td>'.$news["title"].'</td>
        <td><a target="_blank" href="'.$url.$news["thumbnail"].'">Görüntüle</a></td>
        <td>'.$news["categories"].'</td>
        <td>'.$news["added_time"].'</td>
        <td>'.$news["status"].'</td>
        <td>'.$author.'</td>
        <td> <div class="btn-group" role="group">
                                                <button id="btnGroupVerticalDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    İşlemler
                                                    <i class="mdi mdi-chevron-down"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="btnGroupVerticalDrop1">
                                                    <a class="dropdown-item DeleteNews" href="#">Sil</a>
                                                    <a class="dropdown-item" target="_blank" href="edit-news?id='.$news["id"].'">Düzenle</a>
                                                </div>
                                            </div></td>
    </tr>';
  }
  public function GetGeneralSettings(){
    $query = $this->db->prepare("SELECT * FROM `settings` WHERE `id` = :id");
    $query->execute(["id" => 1]);
    $data = $query->fetch();
    return $data;
  }
  public function GetNews(){
    $news = $this->db->prepare("SELECT `id`, `title`, `short_description`, `thumbnail`, `categories`,  `added_time`, `status`, `author` FROM `news` WHERE `isDeleted` = 0 ORDER BY `id` DESC ");
      $news->execute();
      $news = $news->fetchAll(PDO::FETCH_ASSOC);
      $news  = self::EditNews($news);
      return $news;
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
  public function EditNews($news){
    $new_news = [];
    foreach($news as $new){
      $new_categories = '';
      $new["added_time"] = date("d/m/Y H:i", $new["added_time"]);
      $new["id"] = (int)$new["id"];
      $new["status"] = ($new["status"] == 1) ? "Aktif" : "Pasif";
      foreach(json_decode($new["categories"]) as $arr){
        $data = self::GetCategoryName($arr);
        if($data["status"]){
          $new_categories .= $data["category_name"].", ";
        }
      }
      $new_categories = substr($new_categories, 0, -2);
      $new["categories"] = $new_categories;
      $new_news[] = $new;
    }
    return $new_news;
  }

  public function GetCategoryName($category_id){
    $control = $this->db->prepare("SELECT * FROM `categories` WHERE `id` = :category_id AND `isDeleted` = 0");
    $control->execute([
      ":category_id" => $category_id
    ]);
    $data = $control->fetch();
    return ($data) ? ["status" => true, "category_name" => $data["category_name"]] : ["status" => false];
  }

}

?>
