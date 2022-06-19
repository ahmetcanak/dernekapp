<?php
/**
 * Haberler Oluşturma
 */
class ManageUsers
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
                        <h4 class="font-size-18">Yeni Kullanıcı Oluştur</h4>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Haberler</a></li>
                            <li class="breadcrumb-item active">Yeni Kullanıcı Oluştur</li>
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
                                <a class="dropdown-item" href="list-users">Kullanıcı Listesi</a>
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
                                        <h4 class="card-title">Kullanıcı Oluşturma Formu</h4>
                                        <p class="card-title-desc">Lütfen formu eksiksiz ve istenen bir şekilde doldurun.</p>
                                        <form id="addUserForm" enctype="multipart/form-data" class="custom-validation" action="#">
                                        <div class="form-group">
                                            <label>Telefon Numarası</label>
                                            <input id="phone_number" oninput="this.value = this.value.replace(/[^0-9.]/g, \'\').replace(/(\..*)\./g, \'$1\');" type="text" class="form-control" minlength="10" maxlength="10" required placeholder="Telefon Numarası (Başında 0 olmadan, bitişik)"/>
                                        </div>
                                        <div class="form-group">
                                            <label>Şifre</label>
                                            <input id="password" type="password" class="form-control" minlength="5" maxlength="256" required placeholder="Şifre"/>
                                        </div>
                                        <div class="form-group">
                                            <label>Tekrar Şifre</label>
                                            <input id="passwordAgain" type="password" class="form-control" minlength="5" maxlength="256" required placeholder="Şifre"/>
                                        </div>
                                            <div class="form-group">
                                                <label>Adı</label>
                                                <input id="name" type="text" minlength = "3" class="form-control" required placeholder="Adı"/>
                                            </div>
                                            <div class="form-group">
                                                <label>Soyadı</label>
                                                <input id="surname" type="text" minlength = "3" class="form-control" required placeholder="Soyadı"/>
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

  public function Control($phone){
    $control = $this->db->prepare("SELECT `id` FROM `users` WHERE `phone_number` = :phone_number AND `isDeleted` = 0");
    $control->execute([
      ":phone_number" => $phone
    ]);
    return ($control->rowCount() > 0) ? false : true;
  }

  public function GetUserIP()
  {
    // Get real visitor IP behind CloudFlare network
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
              $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
              $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}
  public function Insert($data){

    if(!isset($data["name"]) || !isset($data["surname"]) || !isset($data["password"]) || !isset($data["phone_number"])){
        return ["status"=>false, "message"=> "Eksik parametreler mevcut."];
    }

    if(strlen($data["name"]) < 2 || strlen($data["name"]) > 64){
      return ["status"=>false, "message"=> "Lütfen geçerli bir isim girin."];
    }

    if(strlen($data["surname"]) < 2 || strlen($data["surname"]) > 64){
      return ["status"=>false, "message"=> "Lütfen geçerli bir soyisim girin."];
    }

    if(strlen($data["password"]) < 5){
      return ["status"=>false, "message"=> "Lütfen en az 5 haneden oluşan bir şifre seçin."];
    }

    if(strlen($data["password"]) > 256){
      return ["status"=>false, "message"=> "Sence de şifre biraz uzun değil mi?"];
    }

    if(strlen($data["phone_number"]) != 10 || !is_numeric($data["phone_number"])){
      return  ["status"=>false, "message"=> "Lütfen telefon numarasını kontrol edin. (Başında 0 olmadan bitişik bir şekilde yazın)"];
    }


    if(self::Control($data["phone_number"]) == false){
      return ["status" => false, "message" => "Girdiğiniz telefon numarası ile zaten bir hesap oluşturulmuş."];
    }
    $insert = $this->db->prepare("INSERT INTO `users` (`id`, `phone_number`, `password`, `register_date`, `register_ip`,
    `last_join_time`, `last_join_ip`) VALUES
    (NULL, :phone_number, :password, :curr_time, :user_ip, :curr_time, :user_ip)");
    $insert->execute([
      ":phone_number" => $data["phone_number"],
      ":password" => md5(sha1($data["password"])),
      ":curr_time" => time(),
      ":user_ip" => self::GetUserIP()
    ]);

    $user_id = $this->db->lastInsertId();

    $insert_profile = $this->db->prepare("INSERT INTO `profile_data` (`id`, `user_id`, `name`, `surname`) VALUES
    (NULL, :user_id, :name, :surname)");
    $insert_profile->execute([
      ":user_id" => $user_id,
      ":name" => $data["name"],
      ":surname" => $data["surname"]
    ]);

    return ["status" => true, "id" => $user_id];
  }
}

?>
