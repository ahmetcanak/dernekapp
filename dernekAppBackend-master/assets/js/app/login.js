function ValidateEmail(inputText) {
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    return (inputText.match(mailformat)) ? true : false;
}

function openMessage(type, text) {
    var area = $("#resultArea");
    var status = (type) ? "Başarılı!" : "Hata!";
    var css = (type) ? "success" : "danger";
    var inHTML = '<strong>' + status + '</strong> ' + text;
    var html = '<div class="alert alert-' + css + ' bg-' + css + ' text-white border-0" role="alert">' + inHTML + '</div>';
    $(area).hide();
    $(area).html(html);
    $(area).fadeIn("slow");
}


$(function() {

    $("#loginForm").on("submit", function(e) {
        e.preventDefault();
        const email = $("#email").val();
        const password = $("#password").val();

        /*if (ValidateEmail(email) == false) {
            openMessage(false, "Lütfen geçerli bir E-Posta adresi girin.");
            return false;
        }*/

        if (password.length < 5) {
            openMessage(false, "E-Posta adresi veya şifre hatalı.");
            return false;
        }
        $.ajax({
            method: "POST",
            url: "login",
            data: {
                email: email,
                password: password
            },
            success: function(response) {
                var data = JSON.parse(response);
                openMessage(data.status, data.message);
                if (data.status) {
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }
            }
        });

    });
});
