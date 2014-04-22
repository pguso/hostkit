var body = $("body");

$(document).ready(function () {

    body.on("click", ".adduser", function () { 

        $.ajax({
            type: "POST",
            url: "adduser.php",
            data: {
                username: $('.user').val(),
                password: $('.pass').val()
            },
            success: function (result) {
                if (result == '') {
					$('.form').attr('style', 'display: block;');
					$('.adduser').attr('style', 'display: none;');
                }
            }
        });

    });
});



