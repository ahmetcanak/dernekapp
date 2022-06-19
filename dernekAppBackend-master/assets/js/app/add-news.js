var generateSwal;

function fileValidation(){
  var fileInput = document.getElementById('newsImage');
    var filePath = fileInput.value;
  var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
  if(!allowedExtensions.exec(filePath)){
      generateSwal('Hata!','Sadece belirtilen formatlarda dosya seçebilirsiniz; .jpeg/.jpg/.png/.gif', "error");
      fileInput.value = '';
      $("#imageArea").hide();
      return false;
  }else{
      //Image preview
      if (fileInput.files && fileInput.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e) {
             $("#imageArea").show();
              $(".img-thumbnail").attr("src", e.target.result);
          };
          reader.readAsDataURL(fileInput.files[0]);
      }
  }
}

generateSwal = function(title,text,type){
  Swal.fire(
      title,
      text,
      type
  );
}

$(document).ready(function(){

  $("#addNewsForm").on('submit', function(e){
           e.preventDefault();
        var fd = new FormData();
       var files = $('#newsImage')[0].files[0];
       var newsName = $("#newsName").val();
       var newsShortDescription = $("#newsShortDescription").val();
       var newsCategories = $("#newsCategories").val();
       var newsContent = $("#newsContent").val();
       fd.append('newsImage',files);
       fd.append('newsName', newsName);
       fd.append('newsShortDescription', newsShortDescription);
       fd.append('newsCategories', newsCategories);
       fd.append('newsContent', newsContent);
       fd.append('add_action', 1);
       $.ajax({
           url: 'add-news',
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
                 $("#imageArea").hide("");
                 $("#newsName").val("");
                 $("#newsShortDescription").val("");
                 $("#newsCategories").val("");
                 $("#newsContent").val("");
                 $("#newsImage").val("");
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
