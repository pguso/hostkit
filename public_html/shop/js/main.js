$(document).ready(function () {

    if ($('.form-control').length > 0) {

        var heading = $('.form-control').data('heading');

        if (heading != 'undefined') {

            $.each($('*[data-heading="h5"]'), function () {
                $(this).hide();
                var label_text = $(this).parent().prev().text();
                $(this).parent().prev().parent().prepend('<h5>' + label_text + ' »</h5>');
                $(this).parent().prev().remove();
            });

        }

        var label = $('.form-control').data('label');

        if (label != 'undefined') {
            $('*[data-label="agb"]').parent().parent().css({'width': '550px', 'margin': '35px 0 0 110px'});
            $('*[data-label="agb"]').parent().prev().css({'width': '515px', 'color': '#666', 'float': 'right', 'text-align': 'left'});
            $('*[data-label="agb"]').parent().css({'width': '30px', 'margin': '-2px 0 0 0'});
        }
    }

    if ($('#client_billing_cycle').length > 0) {

        $.each($('#client_billing_cycle option'), function (index, value) {

            if ($(this).text().contains("Discount")) {
                $(this).css('color', 'green');
            }
        });
    }

    $('.faq-list').on('click', 'li', function () {

        var target = '/faq/detail/' + $(this).data('faq-question');

        $.ajax({
                   type: "POST",
                   url: target,
                   success: function (result) {
                       $('.panel-body').empty();

                       $('.panel-title').text(result.data.question);
                       $('.panel-body').append(result.data.answer);
                   }
               });
    })

    $('#faq-filter li').click( function() {

        var target = '';

        if($(this).data('faq-category-filter') == 0) {
            target = '/faq/all';
        } else {
            target = '/faq/category/' + $(this).data('faq-category-filter');
        }

        $.ajax({
                   type: "POST",
                   url: target,
                   success: function (result) {
                       $('.panel-body').empty();
                       $('.faq-list').empty();

                       $('.panel-title').text(result.data.question);
                       $('.panel-body').append(result.data.answer);

                       $.each(result.data.faqList, function(index, value) {
                           $('.faq-list').append('<li class="list-group-item" data-faq-question="' + this.id + '">' + this.question + '</li>')
                       })
                   }
               });

    })

    $('#client_package').change( function() {

        var id = $(this).val();
        var target =

        $.ajax({
                   type: "POST",
                   url: target,
                   success: function (result) {
                       $('.panel-body').empty();
                       $('.faq-list').empty();

                       $('.panel-title').text(result.data.question);
                       $('.panel-body').append(result.data.answer);

                       $.each(result.data.faqList, function(index, value) {
                           $('.faq-list').append('<li class="list-group-item" data-faq-question="' + this.id + '">' + this.question + '</li>')
                       })
                   }
               });
    });

    var inputElement = $("form").find("[data-append='@']");
	var inputElementDot = $("form").find("[data-append='dot']");

    $("form").find("[data-append='@']").wrap('<div class="input-group">').parent().append('<span class="input-group-addon">@' + $(inputElement).data("domain") + '</span>');
    $("form").find("[data-prepend='http']").wrap('<div class="input-group">').parent().prepend('<span class="input-group-addon">http://</span>');
	$("form").find("[data-append='dot']").wrap('<div class="input-group">').parent().append('<span class="input-group-addon">.' + $(inputElementDot).data("domain") + '</span>');

//client/invoice/pdf/69
    $('.download-invoice').click( function() {

        var id = $(this).data('invoice');
        var target = '/client/invoice/pdf/' + id;

        window.location=target;
    });

    $('.download-order-invoice').click( function() {

        var id = $(this).data('invoice');
        var target = '/client/invoice/order/pdf/' + id;

        window.location=target;
    });


});
