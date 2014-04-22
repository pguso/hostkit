var body = $("body");

body.on("click", ".changeuser", function () {

    $.ajax({
               type: "POST",
               url: "edit.php",
               data: {
                   user_name: $('#edit_input_username').val()
               },
               success: function (result) {
                   console.log(result);
               }
           });

});

body.on("click", ".changemail", function () {

    $.ajax({
               type: "POST",
               url: "edit.php",
               data: {
                   user_email: $('#edit_input_email').val()
               },
               success: function (result) {
                   console.log(result);
               }
           });

});


$(document).ready(function () {

    body.on("click", ".addpackage", function () {

        $.ajax({
                   type: "POST",
                   url: "libraries/package.php",
                   data: {
                       name: $('.name').val(),
                       webspace: $('.webspace').val(),
                       ftp: $('.ftp').val(),
                       mysql: $('.mysql').val(),
                       email: $('.email').val(),
                       subdomains: $('.subdomains').val(),
                       bandwidth: $('.bandwidth').val()
                   },
                   success: function (result) {
                       if (result != '') {
                           $('#message').css('color', '#555');
                           $('#message').text(result);
                           $('#message').show();
                       }
                       console.log(result);
                   }
               });

    });

    $(".buy").click(function () {
        var url = "orderform.php";
        $(location).attr('href', url);
    });

    if ($("#ctable").length > 0) {
        $("#ctable").ctable();
    }

    if ($(".ctable").length > 0) {
        $(".ctable").ctable();
    }

    body.on("click", ".client_billing", function () {
        var url = "dashboard.php?page=billing";
        $(location).attr('href', url);
    });


});


