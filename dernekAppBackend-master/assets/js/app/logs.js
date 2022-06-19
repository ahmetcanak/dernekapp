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
    $('.card-title-desc').text("Kayıtlar getirildi, listeleniyor...");
    setTimeout(function() {
        $('#list-logs').show();
        $('#list-logs').DataTable({
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
                            title: 'İşlem Kayıtları',
                            exportOptions: {
                                columns: ':not(.notexport)'
                            }
                        },
                        {
                            extend: 'csv',
                            title: 'İşlem Kayıtları',
                            exportOptions: {
                                columns: ':not(.notexport)'
                            }
                        },
                        {
                            extend: 'pdf',
                            title: 'İşlem Kayıtları',
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
            processing: true,
            responsive: true,
            language: {
                lengthMenu: "Sayfada  _MENU_  kayıt göster.",
                zeroRecords: "Herhangi bir kayıt bulunamadı.",
                info: "_PAGES_ sayfa arasında _PAGE_. sayfa gösteriliyor.",
                infoEmpty: "Kayıt bulunamadı.",
                infoFiltered: "(_MAX_ kayıt arasında)",
                search: "Ara:",
                paginate: {
                    first: "İlk",
                    last: "Son",
                    next: "Sonraki",
                    previous: "Önceki"
                }
            }
        }).buttons().container().appendTo("#list-logs_wrapper .col-md-6:eq(0)");
        $('.card-title-desc').text("Aşağıda listelenen kayıtları inceleyebilir veya belirtilen formatlarda çıktı olarak dosya halinde alabilirsiniz.");
        //hideProgressBar();
    }, 400);
});
