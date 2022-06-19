var i = 0,
    interVal = null;
$(".progress-bar").css("width", "10%");
$(".progress-bar").attr("aria-valuenow", "10");

function move() {
    if (i == 0) {
        i = 11;
        var element = $(".progress-bar");
        var width = 11;
        interVal = setInterval(frame, 5);

        function frame() {
            if (width >= 100) {
                clearInterval(interVal);
                hideProgressBar();
                i = 0;
            } else {
                width++;
                $(element).css("width", width + "%");
                $(element).attr("aria-valuenow", width);
            }
        }
    }
}

function hideProgressBar() {
    clearInterval(interVal);
    $(".progress-bar").css("width", "100%");
    $(".progress-bar").attr("aria-valuenow", "100");
    setTimeout(function() {
        $("#progressbar").fadeOut("slow");
    }, 300)
}
move();

$(document).ready(function() {
    $('.card-title-desc').text("Kullanıcılar getirildi, listeleniyor...");
    setTimeout(function() {
        $('#list-users').show();
        $('#list-users').DataTable({
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'Tümü']
            ],
            buttons: [{
                    extend: 'collection',
                    text: 'Dışarıya Aktar',
                    buttons: [{
                            extend: 'copy',
                            text: 'Kopyala',
                            exportOptions: {
                                columns: ':not(.notexport)'
                            }
                        },
                        {
                            extend: 'excel',
                            title: 'Kullanıcı Listesi',
                            exportOptions: {
                                columns: ':not(.notexport)'
                            }
                        },
                        {
                            extend: 'csv',
                            title: 'Kullanıcı Listesi',
                            exportOptions: {
                                columns: ':not(.notexport)'
                            }
                        },
                        {
                            extend: 'pdf',
                            title: 'Kullanıcı Listesi',
                            exportOptions: {
                                columns: ':not(.notexport)'
                            }
                        },
                    ]
                }
            ],
            order: [
                [0, 'desc']
            ],
            columnDefs: [{
                targets: 5,
                orderable: false
            }, {
               "targets": [ 6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24],
               "visible": false,
               "searchable": false
            }],
            processing: true,
            responsive: true,
            language: {
                lengthMenu: "Sayfada  _MENU_  kayıt göster.",
                zeroRecords: "Herhangi bir kullanıcı bulunamadı.",
                info: "_PAGES_ sayfa arasında _PAGE_. sayfa gösteriliyor.",
                infoEmpty: "Kullanıcı bulunamadı.",
                infoFiltered: "(_MAX_ kullanıcı arasında)",
                search: "Ara:",
                paginate: {
                    first: "İlk",
                    last: "Son",
                    next: "Sonraki",
                    previous: "Önceki"
                }
            }
        }).buttons().container().appendTo("#list-users_wrapper .col-md-6:eq(0)");
        $('.card-title-desc').text("Aşağıda listelenen kullanıcıları isterseniz silebilir, düzenleyebilir veya belirtilen formatlarda çıktı olarak dosya halinde alabilirsiniz.");
        //hideProgressBar();
    }, 400);

    $(document).on("click", ".DeleteUser", function(e) {
        e.preventDefault();
        var t = $(this).parent().parent().parent().parent();
        var user_id = $(t).attr("kullanici_tr_id");
        var usersTable = $('#list-users').DataTable();
        Swal.fire({
            title: 'Emin misiniz?',
            text: "Seçtiğiniz kullanıcı (no: " + user_id + ") silinecektir, bu işlem geri alınamaz!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Evet, eminim!',
            cancelButtonText: 'İptal'
        }).then((result) => {
            if (result.value) {
                var url = 'delete-user?id=' + user_id;
                $.ajax({
                    method: "GET",
                    url: url,
                    success: function(response) {
                        var title, type;
                        var returned = JSON.parse(response);
                        if (returned["status"]) {
                            title = "Başarılı";
                            type = "success";
                            usersTable.row(t).remove().draw();
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
