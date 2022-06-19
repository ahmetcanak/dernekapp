var generateSwal;


generateSwal = function(title,text,type){
  Swal.fire(
      title,
      text,
      type
  );
}

$(document).ready(function(){
  $("#addAuthForm").on('submit', function(e){
           e.preventDefault();
        var fd = new FormData(this);
       fd.append('add_action', 1);
       $.ajax({
           url: 'add-auth',
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
                 $("#addAuthForm")[0].reset();
               } else {
                 title = "Başarısız!";
                 type = "error";
               }
        text  = data.message;
        generateSwal(title,text,type);
           }
       });
       });
});
