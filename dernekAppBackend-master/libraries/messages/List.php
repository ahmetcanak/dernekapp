<?php
/**
 * Haberleri Listeleme İşlemi
 */
class ManageMessages
{

  public function __construct($db){
    $this->db = $db;
  }
  public function write(){
    $html = '  <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row align-items-center">
                            <div class="col-sm-12">
                                <div class="page-title-box">
                                    <h4 class="font-size-18">Mesajlar</h4>
                                    <ol class="breadcrumb mb-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Mesajlar</a></li>
                                        <li class="breadcrumb-item active">Mesajları Görüntüle</li>
                                    </ol>
                                </div>
                            </div>


                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <!-- Right Sidebar -->
                                <div class="mb-3">

                                    <div class="card">
                                        <div class="btn-toolbar p-3" role="toolbar">
                                            <div class="btn-group mo-mb-2">
                                                <button type="button" toggle="0" id="checkAll" class="btn btn-primary waves-light waves-effect"><i class="fa fa-check"></i></button>
                                                <button type="button" id="deleteSelected" class="btn btn-primary waves-light waves-effect"><i class="far fa-trash-alt"></i></button>
                                            </div>

                                        </div>
                                        <ul class="message-list">';

                    $messages = self::GetMessages();
                    foreach($messages as $message){
                      $html .= self::GenerateMessage($message);
                    }





                    $html .=    '</ul>

                                    </div> <!-- card -->



                                </div> <!-- end Col-9 -->

                            </div>

                        </div><!-- End row -->



                    </div> <!-- container-fluid -->
                </div>';
    return $html;
  }

  public function GenerateMessage($message){
    $read_status = $message["status"] == 1 ? "" : "unread";
    $author =  self::GetAuthor($message["user_id"]);
    $return = ' <li message_id="'.$message["id"].'" class="'.$read_status.'">
        <div class="col-mail col-mail-1">
            <div class="checkbox-wrapper-mail">
                <input type="checkbox" class="selectMessage" id="chk'.$message["id"].'">
                <label for="chk'.$message["id"].'" class="toggle"></label>
            </div>
            <a href="read-message?id='.$message["id"].'" class="title">'.$author.'</a>
        </div>
        <div class="col-mail col-mail-2">
            <a href="read-message?id='.$message["id"].'" class="subject"><span class="teaser">'.$message["subject"].'</span>
            </a>
            <div class="date" style="padding-left: 0px!important;">'.date("d/m/Y H:i",$message["sended_time"]).'</div>
        </div>
    </li>';
    return $return;
  }

  public function GetMessages(){
    $news = $this->db->prepare("SELECT * FROM `messages` WHERE `isDeleted` = 0 ORDER BY `id` DESC ");
      $news->execute();
      $news = $news->fetchAll(PDO::FETCH_ASSOC);
      return $news;
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



}

?>
