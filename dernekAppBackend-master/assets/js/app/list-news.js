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
    $('.card-title-desc').text("Haberler getirildi, listeleniyor...");
    setTimeout(function() {
        $('#list-news').show();
        $('#list-news').DataTable({
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
                            title: 'Haber Listesi',
                            exportOptions: {
                                columns: ':not(.notexport)'
                            }
                        },
                        {
                            extend: 'csv',
                            title: 'Haber Listesi',
                            exportOptions: {
                                columns: ':not(.notexport)'
                            }
                        },
                        {
                            extend: 'pdf',
                            title: 'Haber Listesi',
                            exportOptions: {
                                columns: ':not(.notexport)'
                            }
                        },
                    ]
                }, {
                    extend: 'print',
                    text: 'Yazdır',
                    exportOptions: {
                        columns: ':not(.notexport)'
                    }
                }, {
                    extend: 'colvis',
                    text: 'Göster/Gizle'
                }

            ],
            order: [
                [0, 'desc']
            ],
            columnDefs: [{
                targets: 2,
                orderable: false
            }, {
                targets: 7,
                orderable: false
            }],
            processing: true,
            responsive: true,
            language: {
                lengthMenu: "Sayfada  _MENU_  kayıt göster.",
                zeroRecords: "Herhangi bir haber bulunamadı.",
                info: "_PAGES_ sayfa arasında _PAGE_. sayfa gösteriliyor.",
                infoEmpty: "Haber bulunamadı.",
                infoFiltered: "(_MAX_ haber arasında)",
                search: "Ara:",
                paginate: {
                    first: "İlk",
                    last: "Son",
                    next: "Sonraki",
                    previous: "Önceki"
                }
            }
        }).buttons().container().appendTo("#list-news_wrapper .col-md-6:eq(0)");
        $('.card-title-desc').text("Aşağıda listelenen haberleri isterseniz silebilir, düzenleyebilir veya belirtilen formatlarda çıktı olarak dosya halinde alabilirsiniz.");
        //hideProgressBar();
    }, 400);

    $(document).on("click", ".DeleteNews", function(e) {
        e.preventDefault();
        var t = $(this).parent().parent().parent().parent();
        var news_id = $(t).attr("haber_tr_id");
        var newsTable = $('#list-news').DataTable();
        Swal.fire({
            title: 'Emin misiniz?',
            text: "Seçtiğiniz haber (no: " + news_id + ") silinecektir, bu işlem geri alınamaz!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Evet, eminim!',
            cancelButtonText: 'İptal'
        }).then((result) => {
            if (result.value) {
                var url = 'delete-news?id=' + news_id;
                $.ajax({
                    method: "GET",
                    url: url,
                    success: function(response) {
                        var title, type;
                        var returned = JSON.parse(response);
                        if (returned["status"]) {
                            title = "Başarılı";
                            type = "success";
                            newsTable.row(t).remove().draw();
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
