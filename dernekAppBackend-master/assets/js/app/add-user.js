var generateSwal;

generateSwal = function(title,text,type){
  Swal.fire(
      title,
      text,
      type
  );
}

$(document).ready(function(){

  $("#addUserForm").on('submit', function(e){
           e.preventDefault();
        var fd = new FormData();
       var phone_number = $("#phone_number").val();
       var password = $("#password").val();
       var passwordAgain = $("#passwordAgain").val();
       var name = $("#name").val();
       var surname = $("#surname").val();
       fd.append('phone_number', phone_number);
       fd.append('password', password);
       fd.append('name', name);
       fd.append('surname', surname);
       fd.append('add_action', 1);
       if(password != passwordAgain){
         generateSwal("Başarısız","Şifreler uyuşmuyor.","error");
         return;
       }
       $.ajax({
           url: 'add-user',
           type: 'post',
           data: fd,
           contentType: false,
           processData: false,
           success: function(response){
                var type, text, title;
               var data = JSON.parse(response);
               if(data.status){
                 title = "Başarılı!";
                 type = "success";
                 $("#phone_number").val("");
                 $("#password").val("");
                 $("#name").val("");
                 $("#surname").val("");
                 $("#passwordAgain").val("");
               } else {
                 title = "Başarısız!";
                 type = "error";
               }
        text  = data.message;
        generateSwal(title,text,type);
           },
       });
       });
  //parsley-error
});
