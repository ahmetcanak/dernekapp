<?php
/**
 * Bildirim Gönderme
 */
class ManageNotifications
{

  public function __construct($db){
    $this->db = $db;
  }



  private function GenerateUsersGroup(){
    return false;
  /*  $query = $this->db->prepare("SELECT `user_id`, `name`, `surname` FROM `profile_data` WHERE `isDeleted` = 0");
    $query->execute();
    $list = $query->fetchAll(PDO::FETCH_ASSOC);
    $html = '';
    $html .= '<div class="form-group">
               <label>Kullanıcı Listesi</label>
                  <select class="form-control" id="userList">';
                  foreach($list as $user){
                    $html .= '<option value="'.$user["user_id"].'">'.$user["name"].' '.$user["surname"].'</option>';
                  }
      $html .='</select>
                    </div>';
    return $html;*/
  }
  public function write(){
    $html = '<div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row align-items-center">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <h4 class="font-size-18">Bildirim Gönder</h4>
                        <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">Bildirim Yönetimi</li>
                        <li class="breadcrumb-item active">Bildirim Gönder</li>
                        </ol>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Bildirim Gönderme Formu</h4>
                                        <form id="sendNotification" enctype="multipart/form-data" class="custom-validation" action="#">
                                            <div class="form-group">
                                                <label>Başlık</label>
                                                <input name="title" type="text" class="form-control" required placeholder="Bildirim Başlığı"/>
                                            </div>
                                            <div class="form-group">
                                                <label>Açıklama</label>
                                                <input name="text" type="text" class="form-control" required placeholder="Bildirim Açıklaması"/>
                                            </div>
                                            <div id="imageArea" style="display:none;">
                                           <img class="img-thumbnail" alt="200x200" width="200" src="assets/images/small/img-3.jpg" data-holder-rendered="true">
                                       </div>
                                            <div class="form-group">
                                                <label>Bildirim Resmi</label>
                                                <input id="NotificationImage" name="NotificationImage" onchange="return fileValidation()" type="file" class="form-control" accept="image/x-png,image/gif,image/jpeg"/>
                                            </div>
                                            '.self::GenerateUsersGroup().'
                                            <div class="form-group mb-0">
                                                <div>
                                                    <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
                                                        Gönder
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


  private function GetSender()
  {
      $query = $this
          ->db
          ->prepare("SELECT `id` FROM `authorized_list` WHERE `email` = :email AND `password` = :password");
      $query->execute([":email" => $_SESSION["email"], ":password" => $_SESSION["password"]]);
      $data = $query->fetch();
      return $data["id"];
  }

  private function GetGeneralSettings(){
    $query = $this->db->prepare("SELECT * FROM `settings` WHERE `id` = :id");
    $query->execute(["id" => 1]);
    $data = $query->fetch();
    return $data;
  }

  private function sendNotification($image,$title,$text){
    $firebase_url = 'https://fcm.googleapis.com/fcm/send';

    $fields = [
               'to' => '/topics/all',
               'notification' => ['title' => $title, 'body' => $text]
           ];

           if($image != null){
             $url = self::GetGeneralSettings();
             $url = $url["url"];
             $fields["notification"]["image"] = $url.$image;
           }
           $headers = array(
               'Authorization:key=' . 'AAAAW9NmeT4:APA91bGDLdzew_5PSZafyEO7t8zFR_OSwkDpR2_wXlJwXWys62eod93yDFOAYua8sc0JsKyjwoEH8QmvBN9hjCIrfdL9wotBu2hjIlVnjDUuz_5_sAyBnyYHlGpJ9xOEyDnA4tcl0OJt',
               'Content-Type:application/json'
           );
    $ch = curl_init();

           curl_setopt($ch, CURLOPT_URL, $firebase_url);
           curl_setopt($ch, CURLOPT_POST, true);
           curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
           curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
           curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
           curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

           $result = curl_exec($ch);

           curl_close($ch);
  }
  public function Send($post, $image_file){
    if(!isset($post["title"]) || !isset($post["text"])){
      return ["status" => false, "message" => "Lütfen formu doldurun."];
    }
    if(strlen(ltrim(rtrim($post["title"]))) < 3){
      return ["status" => false, "message" => "Lütfen en az 3 karakterden oluşan bildirim başlığı girin."];
    }
    if(strlen(ltrim(rtrim($post["text"]))) < 3){
      return ["status" => false, "message" => "Lütfen en az 3 karakterden oluşan bildirim içeriği girin."];
    }
    $image_file = ($image_file != "") ? str_replace("../", "", $image_file) : NULL;
    $insert = $this->db->prepare("INSERT INTO `notifications` (`id`, `title`, `text`, `image`, `sender`, `sended_time`) VALUES (NULL, :title, :text,  :image, :sender,  :sended_time)");
    $insert->execute([":title" => $post["title"], ":text" => $post["text"], ":image" => $image_file, ":sender"=> self::GetSender(), ":sended_time" => time()]);
    self::sendNotification($image_file,$post["title"],$post["text"]);
    return ["status" => true, "id" => $this->db->lastInsertId()];
  }
}

?>
