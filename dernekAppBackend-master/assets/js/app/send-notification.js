var generateSwal;

generateSwal = function(title,text,type){
  Swal.fire(
      title,
      text,
      type
  );
}

function fileValidation(){
  var fileInput = document.getElementById('NotificationImage');
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

$(document).ready(function(){
/*
  $('#userList').multiSelect({
  selectableFooter: "<div class='custom-header'>Kullanıcı Listesi</div>",
  selectionFooter: "<div class='custom-header'>Seçilen Kullanıcılar</div>",
  selectableHeader: "<input type='text' class='form-control' autocomplete='off' placeholder='Kullanıcı Listesinde Ara'>",
 selectionHeader: "<input type='text' class='form-control' autocomplete='off' placeholder='Seçilen Kullanıcılarda Ara'>",
 afterInit: function(ms){
   var that = this,
       $selectableSearch = that.$selectableUl.prev(),
       $selectionSearch = that.$selectionUl.prev(),
       selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
       selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

   that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
   .on('keydown', function(e){
     if (e.which === 40){
       that.$selectableUl.focus();
       return false;
     }
   });

   that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
   .on('keydown', function(e){
     if (e.which == 40){
       that.$selectionUl.focus();
       return false;
     }
   });
 },
 afterSelect: function(){
   this.qs1.cache();
   this.qs2.cache();
 },
 afterDeselect: function(){
   this.qs1.cache();
   this.qs2.cache();
 }
});
*/
  $("#sendNotification").on('submit', function(e){
        e.preventDefault();
        var files = $('#NotificationImage')[0].files[0];
        var fd = new FormData(this);
        fd.append('NotificationImage',files);
        fd.append('send_action', 1);
       $.ajax({
           url: 'send-notification',
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
                 $("#NotificationImage").val("")
                 $("#imageArea").hide();
                 $("#sendNotification")[0].reset();
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
