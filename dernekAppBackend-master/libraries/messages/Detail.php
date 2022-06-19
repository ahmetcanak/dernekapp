<?php
/**
 * Mesaj Detayı
 */
class ManageMessages
{

  public function __construct($db,$message_id){
    $this->db = $db;
    $this->message_id = $message_id;
  }

  public function Control(){
    $query = $this->db->prepare("SELECT `id` FROM `messages` WHERE `id` = :id AND `isDeleted` = 0");
    $query->execute([":id" => $this->message_id]);
    $data = $query->fetch();
    return $data ? true : false;
  }
  public function MessageDetail(){
    $query = $this->db->prepare("SELECT * FROM `messages` WHERE `id` = :id AND `isDeleted` = 0");
    $query->execute([":id" => $this->message_id]);
    $data = $query->fetch();
    $data["name"] = self::GetAuthor($data["user_id"]);
    $data["phone_number"] = self::GetPhoneNumber($data["user_id"]);
    return $data;
  }

  public function GetAuthor($user_id){
    $query = $this->db->prepare("SELECT `name`,`surname` FROM `profile_data` WHERE `user_id` =:id AND `isDeleted` = 0");
    $query->execute([":id" => $user_id]);
    $data = $query->fetch();
    $return = "Bilinmiyor";
    if($data){
      $return = $data["name"]." ".$data["surname"];
    }
    return $return;
  }

  public function GetPhoneNumber($user_id){
    $query = $this->db->prepare("SELECT `phone_number` FROM `users` WHERE `id` =:id AND `isDeleted` = 0");
    $query->execute([":id" => $user_id]);
    $data = $query->fetch();
    $return = "Bilinmiyor";
    if($data){
      $return = "+90 ".$data["phone_number"];
    }
    return $return;
  }
  public function Readed(){
    $query = $this->db->prepare("SELECT `status` FROM `messages` WHERE `id` = :id AND `isDeleted` = 0");
    $query->execute([":id" => $this->message_id]);
    $data = $query->fetch();
    if($data["status"] != 1){
      $query = $this->db->prepare("UPDATE `messages` SET `status` = :status WHERE `id` = :id AND `isDeleted` = 0");
      $query->execute([":status" => 1, ":id" => $this->message_id]);
      return false;
    }
    return true;
  }
  public function GenerateImage($image){
    if($image != null && $image != ""){
      return '  <hr/>
      <div class="row">
          <div class="col-xl-2 col-6">
              <div class="card">
                  <img class="card-img-top img-fluid" src="'.$image.'" alt="Mesaj Görseli">
                  <div class="py-2 text-center">
                      <a download href="'.$image.'" class="font-weight-medium">İndir</a>
                  </div>
              </div>
          </div>
      </div>';
    }
  }
  public function write(){
    $data = self::MessageDetail();
    $html = '    <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row align-items-center">
                            <div class="col-sm-12">
                                <div class="page-title-box">
                                    <h4 class="font-size-18">Mesaj Detayı</h4>
                                    <ol class="breadcrumb mb-0">
                                        <li class="breadcrumb-item"><a href="messages">Mesajlar</a></li>
                                        <li class="breadcrumb-item active">Mesaj Detayı</li>
                                    </ol>
                                </div>
                            </div>


                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">

                                <div class=" mb-3">

                                    <div class="card">
                                        <div class="btn-toolbar p-3" role="toolbar">
                                            <div class="btn-group mo-mb-2">
                                            <button type="button" id="goBack" class="btn btn-info waves-light waves-effect"><i class="fas fa-chevron-left"></i></button>
                                            <button type="button" style="margin-left:5px;" id="deleteSelected" message_id = "'.$data["id"].'" class="btn btn-primary waves-light waves-effect"><i class="far fa-trash-alt"></i></button>
                                            </div>

                                        </div>

                                        <div class="card-body">

                                            <div class="media mb-4">
                                                <img class="d-flex mr-3 rounded-circle avatar-sm" src="assets/images/user-image.png" alt="Generic placeholder image">
                                                <div class="media-body">
                                                    <h4 class="font-size-15 m-0">'.$data["name"].'</h4>
                                                    <small class="text-muted">'.$data["phone_number"].' tarafından, '.date("d/m/Y H:i", $data["sended_time"]).' tarihinde gönderildi.</small>
                                                </div>
                                            </div>

                                            <h4 class="mt-0 font-size-16">'.$data["subject"].'</h4>

                                            <p>'.$data["message_text"].'</p>

                                            '.self::GenerateImage($data["message_images"]).'
                                        </div>

                                    </div>

                                </div> <!-- end Col-9 -->

                            </div>

                        </div><!-- End row -->



                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->';
    return $html;
  }





}

?>
