$(document).ready(function(){

$("#goBack").on("click", function(e) {
  window.location = 'messages';
});

$("#deleteSelected").on("click", function(e) {
    e.preventDefault();
    var t = this;
    Swal.fire({
        title: 'Emin misiniz?',
        text: "Bu mesajı silmek istediğinizden emin misiniz? Bu işlem geri alınamaz!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Evet, eminim!',
        cancelButtonText: 'İptal'
    }).then((result) => {
        if (result.value) {
            var url = 'delete-messages?ids='+$(t).attr("message_id");
            $.ajax({
                method: "GET",
                url: url,
                success: function(response) {
                    var title, type;
                    var returned = JSON.parse(response);
                    if (returned["status"]) {
                        title = "Başarılı";
                        type = "success";
                        setTimeout(function(){
                          window.location = "messages";
                        },2000);
                        $(t).hide();
                        $(".card-body").hide();
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
