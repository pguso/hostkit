/**
 * User: Patric
 * Date: 28.06.13
 * Time: 20:27
 */
$(document).ready(function () {

    //console.log($('.box-order form').attr('style') == 'display: none;')

    $('.show, .hide').click(function () {
        $(this).parent('h1').parent('div').find('form').toggle();
        $(this).parent('h1').parent('div').find('section').toggle();
        $(this).parent('h1').attr('style', '');

        if ($(this).parent('h1').find('span').attr('class') == 'show') {
            $(this).parent('h1').find('span').removeClass();
            $(this).parent('h1').find('span').addClass('hide');
        } else {
            $(this).parent('h1').find('span').removeClass();
            $(this).parent('h1').find('span').addClass('show');
        }

        if ($('.box-order form').attr('style') == 'display: none;' || $('.box-order section').attr('style') == 'display: none;') {
            $('.box-order form').parent('div').find('h1').attr('style', 'border-bottom: none; border-radius: 3px');
            $('.box-order table').parent('div').find('h1').attr('style', 'border-bottom: none; border-radius: 3px');
        } else {
            $('.box-order form').parent('div').find('h1').attr('style', '');
            $('.box-order table').parent('div').find('h1').attr('style', '');
        }

        //console.log($(this).parent('h1').find('span').attr('class') == 'show');
    });

    /* choosedomain.php **************************************************************/
    $('#regdomain, #transferdomain').click(function () {

        $('.bootstrap-select').show();
        $('.tld').remove();
        $('.dot').remove();
        $('#registerdomain .btn-inverse').attr('id', 'checkdomain');
        $('#checkdomain').text(' ');
        $('#checkdomain').append('<span class="icon-white icon-search"></span> Check Domain');

        $("#checkdomain").data('domain', 'register');
    });

    $('#owndomain').click(function () {

        $('.bootstrap-select').hide();
        $('.tld').remove();
        $('.dot').remove();

        $('<label class="dot">.</label><input type="text" name="tld" class="tld" placeholder="com" style="width: 60px; height: 55px; padding: 0 0 0 10px" />').insertAfter('.domain');
        $('#checkdomain').text('Continue');
        $('#registerdomain .btn-inverse').attr('id', 'continue');

        $("#checkdomain").data('domain', 'continue');
    });

    $('#checkdomain').click(function () {

        var domainname = $('.domain').val();

        if ($('#checkdomain').length !== 0) {
            if ($('.domain').val() != '' && domainname.match(/^[a-zA-Z0-9]+/) != null) {
                $('.box-order-content').css('opacity', '0.5');
                $('.box-order-content').append('<div class="loader"></div>');

                var tld = '';

                if($('.tld').length > 0) {
                    tld = $('.tld').val();
                } else {
                    tld = $('.tld-input').val()
                }

                $('.box-result').hide();

                if (domainname.match(/^[a-zA-Z0-9]+/) != null) {
                    var selected = $("#checkdomain").data('domain');

                    if (selected == 'register') {
                        $.ajax({
                            type: "POST",
                            url: "/check/domain",
                            data: {
                                mode: selected,
                                domain: $('.domain').val(),
                                tld: tld
                            },
                            success: function (result) {
                                $('.box-order-content').css('opacity', '1');
                                $('.loader').remove();
                                $('.result').empty();

                                result = $.parseJSON(result);

                                if (selected == 'register') {

                                    if (result.resultcode == 100) {
                                        $('.result').append('<span class="icon-ok"></span> ' + result.domain + ' is still available<span class="price">' + result.price + '<span class="small">/ Year</span></span> <a href="" class="btn btn-success fltr addtocart" onclick="return false">Add to cart</a>');
                                    } else if (result.resultcode == 300) {
                                        $('.result').append('<span class="icon-remove"></span> ' + result.domain + '</span><a href="" class="btn btn-warning fltr try" onclick="return false;">Try again</a>');
                                    } else {
                                        $('.result').append('<span class="icon-remove"></span> ' + 'This domain ending is currently unavailable.' + '</span><a href="" class="btn btn-warning fltr try" onclick="return false;">Try again</a>');
                                    }

                                    $('.box-result').show();
                                } else if (selected == 'transfer') {
                                    if (result != "This domain doesn't has an owner.") {
                                        $('.result').append('<span class="icon-ok"></span>Transfer <span class="text-info">' + result.domain + '</span>' + ' to us<span class="price">' + result.price + '<span class="small">/ Year</span></span><a href="" class="btn btn-inverse fltr addtocart" onclick="return false">Add to cart</a>');
                                    } else {
                                        $('.result').append('<span class="icon-remove"></span> ' + result.domain + '</span><a href="" class="btn btn-warning fltr try" onclick="return false;">Try again</a>');
                                    }

                                    $('.box-result').show();
                                }
                            }
                        });
                    } else {
						$.ajax({
							type: "POST",
							url: "/session/data",
							data: {
								mode: 'owndomain',
								domainname: $('.domain').val(),
								tld: $('.tld').val()
							},
							success: function (result) {
								$(location).attr('href', '/cart/package');
							}
						});
                    }
                } else {
                    $('.domainerr').remove();
                    $('#registerdomain').prepend('<span style="color: red;" class="domainerr">Please input a valid domainname.</span>');
                }
            } else {
                $('.domainerr').remove();
                $('#registerdomain').prepend('<div style="color: red; dislay: block; margin: 0 0 5px 20px" class="domainerr">Please input a valid domainname.</div>');
            }
        }
    });

    $('body').on('keypress', '.domain', function () {
        $('.domainerr').remove();
    });

    $('body').on('keypress', '.tld-input', function () {
        $('.domainerr').remove();
    });

    $('input:radio').change(function () {
        $('.box-result').hide();
    });

    $('body').on('click', '.try', function () {
        $('.box-order').scrollTop();
        $('.domain').val('');
        $(".domain").focus();
    });

    if ($('.selectpicker').length != 0) {
        $('.selectpicker').selectpicker();
    }

    $('body').on('click', '.addtocart', function () {

        var tld = '';

        if($('.tld').length > 0) {
            tld = $('.tld').val();
        } else {
            tld = $('.tld-input').val();
        }

        $.ajax({
            type: "POST",
            url: "/session/data",
            data: {
                mode: 'register',
                domainname: $('.domain').val(),
                tld: tld
            },
            success: function (result) {
                $(location).attr('href', '/cart/package');
            }
        });
    });

    $('body').on('click', '#continue', function () {

        var domainname = $('.domain').val();

        if ($('.domain').val() != '' && $('.tld-input').val() != '') {
            if (domainname.match(/^[a-zA-Z0-9]+/) != null) {
                $.ajax({
                    type: "POST",
                    url: "actions.php",
                    data: {
                        mode: 'owndomain',
                        domainname: $('.domain').val(),
                        tld: $('.tld-input').val()
                    },
                    success: function (result) {
                        $('#one').hide();
                        $('#two').css('display', 'block');
                    }
                });
            } else {
                $('.domainerr').remove();
                $('#registerdomain').prepend('<div style="color: red; dislay: block; margin: 0 0 5px 20px" class="domainerr">Please input a domainname and tld.</div>');
            }
        } else {
            $('.domainerr').remove();
            $('#registerdomain').prepend('<div style="color: red; dislay: block; margin: 0 0 5px 20px" class="domainerr">Please input a valid domainname and tld.</div>');
        }
    });

    /* radio button styling */
    var d = document;
    var safari = (navigator.userAgent.toLowerCase().indexOf('safari') != -1) ? true : false;
    var gebtn = function (parEl, child) {
        return parEl.getElementsByTagName(child);
    };
    onload = function () {

        var body = gebtn(d, 'body')[0];
        body.className = body.className && body.className != '' ? body.className + ' has-js' : 'has-js';

        if (!d.getElementById || !d.createTextNode) return;
        var ls = gebtn(d, 'label');
        for (var i = 0; i < ls.length; i++) {
            var l = ls[i];
            if (l.className.indexOf('label_') == -1) continue;
            var inp = gebtn(l, 'input')[0];
            if (l.className == 'label_check') {
                l.className = (safari && inp.checked == true || inp.checked) ? 'label_check c_on' : 'label_check c_off';
                l.onclick = check_it;
            }
            ;
            if (l.className == 'label_radio') {
                l.className = (safari && inp.checked == true || inp.checked) ? 'label_radio r_on' : 'label_radio r_off';
                l.onclick = turn_radio;
            }
        }

    }
    var check_it = function () {
        var inp = gebtn(this, 'input')[0];
        if (this.className == 'label_check c_off' || (!safari && inp.checked)) {
            this.className = 'label_check c_on';
            if (safari) inp.click();
        } else {
            this.className = 'label_check c_off';
            if (safari) inp.click();
        }
    }
    var turn_radio = function () {
        var inp = gebtn(this, 'input')[0];
        if (this.className == 'label_radio r_off' || inp.checked) {
            var ls = gebtn(this.parentNode, 'label');
            for (var i = 0; i < ls.length; i++) {
                var l = ls[i];
                if (l.className.indexOf('label_radio') == -1)  continue;
                l.className = 'label_radio r_off';
            }
            this.className = 'label_radio r_on';
            if (safari) inp.click();
        } else {
            this.className = 'label_radio r_off';
            if (safari) inp.click();
        }
    }

    /* password strength ***********************/
    if ($('.password').length != 0) {
        $('.password').password_strength();
    }

    //checkout show endprices
    if ($('#total').length > 0) {
        var price = 0;
        var vatPrice = 0;
        var vat = 0;
        var total = 0;

        var response = $.ajax({
            url: "/vat",
            async: false
        }).responseText;

        if($.isNumeric(vat)) {
           vat = response;
        }

        if ($('.table-pricing tbody tr td:last-child').length > 1) {
            $('.table-pricing tbody tr td:last-child').each(function (index, value) {
                $('#subTotal').empty();
                $('#tax').empty();
                $('#total').empty();

                var text = $(this).text().replace('$', '');
                price = parseFloat(text) + price;
                vatPrice = price / 100 * vat;console.log(vat);
                total = (vatPrice + price);

                $('#subTotal').append('Subtotal: <span>$' + price.toFixed(2) + '</span>');
                $('#tax').append('Tax: <span>$' + vatPrice.toFixed(2) + '</span>');
                $('#total').append('Total Amount: <span>$' + total.toFixed(2) + '</span>');
            });
        } else {
            var text = $('.table-pricing tbody tr td:last-child').text();

            price = parseFloat(text.replace('$', ''));
            vatPrice = price / 100 * vat;
            total = (vatPrice + price);

            $('#subTotal').append('Subtotal: <span>$' + price.toFixed(2) + '</span>');
            $('#tax').append('Tax: <span>$' + vatPrice.toFixed(2) + '</span>');
            $('#total').append('Total Amount: <span>$' + total.toFixed(2) + '</span>');
        }
    }

    if($('#client_agb').length > 0) {
        $('#client_agb').parent().parent().find('label').append('<a class="popup-with-zoom-anim" href="#termsandconditions"><span class="fa fa-info-circle" style="color: #666"></span>f</a>');
    }

    $('.popup-with-zoom-anim').magnificPopup({
          type: 'inline',

          fixedContentPos: false,
          fixedBgPos: true,

          overflowY: 'auto',

          closeBtnInside: true,
          preloader: false,
          
          midClick: true,
          removalDelay: 300,
          mainClass: 'my-mfp-zoom-in'
        });

});