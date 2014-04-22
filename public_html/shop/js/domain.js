$(document).ready(function () {
    $('#checkdomainstart').click(function () {

        $('#checkdomainstart').text('Loading...');
        var domainname = $('.domain').val();
        $('.result').empty();

        if ($('#checkdomainstart').length !== 0) {

            var domainPattern = /^((?:(?:(?:\w[\.\-\+]?)*)\w)+)((?:(?:(?:\w[\.\-\+]?){0,62})\w)+)\.(\w{2,6})$/;

            if ($('.domain').val() != '' && domainname.match(domainPattern) != null) {
                $('#checkdomainstart').css('opacity', '0.5');
                $('.box-order-content').append('<div class="loader"></div>');

                $('.box-result').hide();

                if (domainname.match(/^[a-zA-Z0-9]+/) != null) {

                    $.ajax({
                        type: "POST",
                        url: "/check/domain",
                        data: {
                            mode: 'register_home',
                            domainname: $('.domain').val()
                        },
                        success: function (result) {

                            result = $.parseJSON(result);

                            $('.box-order-content').css('opacity', '1');
                            $('.loader').remove();
                            $('.result').empty();console.log(result)


                                if (result.resultcode == 100) {
                                    $('.result').append('<span class="icon-ok"></span> ' + result.domain  + ' is still available for <span class="price">' + result.price + '<span class="small">/ Year</span></span><a href="" class="btn btn-success fltr addtocart" onclick="return false">Add to cart</a>');
                                } else if (result.resultcode == 300) {
                                    $('.result').append('<span class="icon-remove"></span>Sorry ' + result.domain + ' is not available.<a href="" class="btn btn-success fltr try" onclick="return false;">Try again</a>');
                                } else {
                                    $('.result').append('<span class="icon-remove"></span> ' + 'This domain ending is currently unavailable.' + '</span><a href="" class="btn btn-success fltr try" onclick="return false;">Try again</a>');
                                }

                                $('.result').show();

                        }
                    });
                } else {
                    $('.domainerr').remove();
                    $('#registerdomain').prepend('<span style="color: red;" class="domainerr">Please input a valid domainname.</span>');
                }
            } else {
                $('.domainerr').remove();
                $('.result').prepend('<div style="color: red; dislay: block; margin: 0 0 5px 20px" class="domainerr">Please input a valid domainname.</div>');
            }
        }

        $('#checkdomainstart').text('Search');
        $('#checkdomainstart').css('opacity', '1');
    });
});