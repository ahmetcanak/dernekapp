var generateSwal;

generateSwal = function(title,text,type){
  Swal.fire(
      title,
      text,
      type
  );
}

$(document).ready(function(){
  var childcount = $(".childAppend").length;
  childcount = childcount + 332211;
  $("#password").on("keyup", function(){
    if($(this).val() == ""){
      $("#passwordAgainArea").fadeOut();
    } else{
      $("#passwordAgainArea").fadeIn();
    }
  });

  $(document).on("click", ".removeChild", function(e){
    e.preventDefault();
    var t = this;
    Swal.fire({
  title: 'Emin misiniz?',
  text: "Seçilen çocuk kaldırılacak! Onaylıyor musunuz?",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Evet!',
  cancelButtonText: 'Hayır!'
}).then((result) => {
  if (result.value) {
        $(t).parent().parent().remove();
  }
})

  });

  $("#AddNewChild").on("click", function(e){
    childcount++;
    e.preventDefault();
    var text = '<div class="card childAppend">'+
       '<div class="card-header">'+
           '<span style="color:red; cursor:pointer;" class="removeChild"> [X] Çocuğu Kaldır </span>'+
       '</div>'+
       '<div class="card-body">'+
       '<div class="form-group">'+
           '<label>Adı</label>'+
           '<input name="children['+childcount+'][\'name\']" type="text" class="form-control" required placeholder="Adı"/>'+
       '</div>'+
       '<div class="form-group">'+
           '<label>Soyadı</label>'+
           '<input name="children['+childcount+'][\'surname\']" type="text" class="form-control" required placeholder="Soyadı"/>'+
       '</div>'+
       '<div class="form-group">'+
           '<label>Doğum Tarihi</label>'+
           '<input name="children['+childcount+'][\'birth_date\']" type="date" class="form-control" />'+
       '</div>'+
       '<div class="form-group">'+
           '<label>Medeni Durumu</label>'+
           '<input name="children['+childcount+'][\'marital_status\']"  type="text" class="form-control" required placeholder="Medeni Durumu"/>'+
       '</div>'+
       '<div class="form-group">'+
           '<label>Mesleği</label>'+
           '<input type="text" name="children['+childcount+'][\'job\']" required class="form-control" required placeholder="Mesleği"/>'+
       '</div>'+
       '<div class="form-group">'+
           '<label>Eğitim Durumu</label>'+
           '<select name="children['+childcount+'][\'education_status\']" required class="form-control">'+
           '<option value="İlkokul">İlkokul</option>'+
           '<option value="Ortaokul">Ortaokul</option>'+
           '<option value="Lise">Lise</option>'+
           '<option value="Ön Lisans">Ön Lisans</option>'+
           '<option value="Lisans">Lisans</option>'+
           '<option value="Yüksek Lisans">Yüksek Lisans</option>'+
           '<option value="Doktora">Doktora</option>'+
           '</select>'+
       '</div>'+
           '<div class="form-group">'+
               '<label>Kan Grubu</label>'+
               '<select name="children['+childcount+'][\'blood_group\']" required class="form-control">'+
               '<option value="Bilinmiyor">Bilinmiyor</option>'+
               '<option value="0-">0-</option>'+
               '<option value="0+">0+</option>'+
               '<option value="A-">A-</option>'+
               '<option value="A+">A+</option>'+
               '<option value="B-">B-</option>'+
               '<option value="B+">B+</option>'+
               '<option value="AB-">AB-</option>'+
               '<option value="AB+">AB+</option>'+
               '</select>'+
           '</div>'+
           '<div class="form-group">'+
               '<label>Telefon Numarası</label>'+
               '<input  name="children['+childcount+'][\'phone_number\']" type="text" class="form-control newPhone" minlength="10" maxlength="10" required placeholder="Telefon Numarası (Başında 0 olmadan, bitişik)" />'+
           '</div>'+
       '</div>'+
    '</div>';
    var html = $(text);
    $("#chilrenArea").append(html);
  });

  $(document).on("input", ".newPhone", function(e){
    var value = $(this).val();
    value = value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');
    $(this).val(value);
  });

  $("#updateUserForm").on('submit', function(e){
        e.preventDefault();
        if($("#password").val() != "" && $("#passwordAgain").val() != $("#password").val()){
          generateSwal("Başarısız!","Yeni şifreler uyuşmuyor", "error");
          return false;
        }
        var FData = $("#updateUserForm").serializeArray();
        FData.push({name: 'updateAction', value: 1});
       $.ajax({
           url: window.location.href,
           type: 'POST',
           data: {
             'data' : FData
           },
           success: function(response){
                var type, text, title;
               var data = JSON.parse(response);
               if(data.status){
                 title = "Başarılı!";
                 type = "success";
               } else {
                 title = "Başarısız!";
                 type = "error";
               }
        text  = data.message;
        generateSwal(title,text,type);
           },
       });
       });
});
