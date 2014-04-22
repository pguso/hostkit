/****************************************
 * Hosting - Clientarea - Email Section
 ***************************************/
/*  Dialog Boxes */
var email, email_id;
var xmlhttp;

function setEmail(mail) {
    email = mail;
}

function setEmailId(id) {
    email_id = id;
}

$(function() {

    $.fx.speeds._default = 1000;

    $( "#dialog-confirm" ).dialog({
        autoOpen: false,
        height: 200,
        modal: true,
        position: "center",
        buttons: {
            "Löschen": function() {
                if(email != '') {
                    $.ajax({
                        url: "/client/email_del/" + email + "/"
                    })
                }

                $( this ).dialog( "close" );
                $( "#dialog-success" ).dialog( "open" );

                if(email_id >= 0) {
                    $( "#" + email_id ).hide();
                }

                setTimeout(function(){
                    $( "#dialog-success" ).dialog( "close" );
                }, 1500)
            },
            "Abbrechen": function() {
                $( this ).dialog( "close" );
            }
        }

    });

    $( ".confirm-message" ).click(function() {
        //        console.log("click funktion");
        $( "#dialog-confirm" ).dialog( "open" );
        return false;
    });

    $( "#dialog-success" ).dialog({
        autoOpen: false,
        height:140,
        modal: true

    });
});

/* edit existing email account */
function editEmail(mailadr, email_id) {
    $('.email h2 span').text('E-Mail Postfach Details ändern');
    $('#email_email').attr('value', mailadr);
    $('.control-email .add-on').css('display', 'none');
    var str = $('#' + email_id + ' .quota').text();
    var quota = parseInt(str, 10);
    $('#email_quota').attr('value', quota);
    $('#email_password label:first').text('Neues Passwort');
    $('#email_proof').attr('value', 'existing_email');
}

function scrollWin(){
    $('html,body').animate({
        scrollTop: $(".email").offset().top
    }, 800);
}
