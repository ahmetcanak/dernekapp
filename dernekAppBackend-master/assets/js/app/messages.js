$(document).ready(function(){
      $("#checkAll").on("click",function(){
    var status = $(this).attr("toggle") == 0 ? true : false;
    $(".selectMessage").prop("checked",status);
    if(status)
      $(this).attr("toggle", 1);
    else
      $(this).attr("toggle",0);
});


$("#deleteSelected").on("click", function(e) {
    e.preventDefault();
    var deleted = [];
     $('.selectMessage').each(function() {
       if($(this).is(':checked')){
         var message_id = $(this).parent().parent().parent().attr("message_id");
         deleted.push(message_id);
       }
     });
     if(deleted.length == 0){
       Swal.fire(
           "Başarısız",
           "Lütfen en az 1 tane mesaj seçin.",
           "error"
       );
       return;
     }
    Swal.fire({
        title: 'Emin misiniz?',
        text: "Seçtiğiniz mesajları silmek istediğinizden emin misiniz? Bu işlem geri alınamaz!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Evet, eminim!',
        cancelButtonText: 'İptal'
    }).then((result) => {
        if (result.value) {
            var url = 'delete-messages?ids=' + deleted.join(',');
            $.ajax({
                method: "GET",
                url: url,
                success: function(response) {
                    var title, type;
                    var returned = JSON.parse(response);
                    if (returned["status"]) {
                        title = "Başarılı";
                        type = "success";
                        for(var i = 0; i < returned["deleted_list"].length; i++){
                          $('li[message_id="'+returned["deleted_list"][i]+'"]').remove();
                        }
                    } else {
                        title = "Başarısız";
                        type = "error";
                    }
                    Swal.fire(
                        title,
                        returned["message"],
                        type
                    );
                }
            });

        }
    });
});


});
