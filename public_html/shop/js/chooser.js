/*
 * Copyright (c) 2013 Patric Gutersohn
 * http://www.ladensia.com
 *
 */

/*
 *
 *   Do not edit the bellow lines
 *
 */
$(document).ready(function () { 

	$('.create').click(function () {
		var loc = window.location.pathname;
		var dir = loc.substring(0, loc.lastIndexOf('/')); 
		var url = $(location).attr('protocol') + '//' + $(location).attr('host') + dir; 

		showLoading();

        var xmlRequest = $.ajax({
            type: "POST",
            url: url + "/save.php", //here you can set your domain
            data: {
                plans: 			$('.plans').val(),
                planm: 			$('.planm').val(),
                planl: 			$('.planl').val(),
                planxl: 		$('.planxl').val(),
                planxxl: 		$('.planxxl').val()
            }
        }).success(function (response) {
                $('#msg').attr('style', 'background: none');
                $('#msg').text('File generate');
                $("html, body").animate({ scrollTop: 0 }, 600);
        });
    });



});

function showLoading() {
    $('#msg').attr('style', 'display: block');
    $("html, body").animate({ scrollTop: 0 }, 600);
}
