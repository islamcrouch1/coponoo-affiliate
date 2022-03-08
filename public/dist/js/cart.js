$(document).ready(function(){



    $('.btn1').on('click' , function(){

        $("#phone_hide").val($(".iti__selected-dial-code").html());

        $(this).closest('form').submit();

        $(".btn").attr("disabled", true);

    });


    $('.search-form-a').on('click' , function(e){


        e.preventDefault();

        $("#search-form").submit()

    });





    $('.add-fav').on('click' , function(e){



        e.preventDefault();



        var url = $(this).data('url');

        var fav = '.fav-' + $(this).data('id');

        console.log(url);
        console.log(fav);


        $.ajax({
            url: url,
            method: 'GET',
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {


                if(data == 1){

                    $(fav).removeClass('far');
                    $(fav).addClass('fas');
                    console.log('added');
                    $("#fav-icon").text(parseInt($("#fav-icon").text()) + 1);

                }

                if(data == 2){

                    $(fav).addClass('far');
                    $(fav).removeClass('fas');
                    console.log('deleted');
                    $("#fav-icon").text(parseInt($("#fav-icon").text()) - 1);

                }



            }
        });




    });










    $('body').on('click', '.disabled', function(e) {

        e.preventDefault();

    });//end of disabled


    $('#checkall').change(function () {
        $('input:checkbox').prop('checked',this.checked);
    });

    $('input:checkbox').change(function () {
     if ($('input:checked').length == $('input:checkbox').length){
      $('#checkall').prop('checked',true);
     }
     else {
      $('#checkall').prop('checked',false);
     }
    });


    $( "#select-button" ).click(function() {
        $( "#select-form" ).submit();
      });


    // $("input[type=radio].color-select:first").attr('checked', true);


    $('input[type=number].product-price').change(function(){



        var min = $(this).data('min');

        var max = $(this).data('max');

        var price = $(this).val() ;

        var id = $(this).data('id');

        var span = '#aff_comm' + id;

        var alarm = '.alarm-' + id ;

        var locale = $(this).data('locale');




        if(price < min){


            $(this).val(min);

            $(span).html(0);

            if(locale == 'ar'){
                $(alarm).html("يجب أن يكون سعر البيع من " + min + " إلى " +  max)
            }else{
                $(alarm).html("Selling price must be between" + min + " to " +  max)
            }

            $(alarm).css('display', 'block');



        }else if(price > max){

            $(alarm).css('display', 'none');


            $(this).val(max);

            $(span).html(max - min);

            if(locale == 'ar'){
                $(alarm).html("يجب أن يكون سعر البيع من " + min + " إلى " +  max)
            }else{
                $(alarm).html("Selling price must be between" + min + " to " +  max)
            }

            $(alarm).css('display', 'block');



        }else{


            $(alarm).css('display', 'none');


            $(span).html(price - min);


        }




    });

    $('input[type=radio].color-select').change(function(){

        var id = $(this).data('id');

        var color = $(this).data('color');

        var label = '.p-' + id + '-' + color;

        var labl = '.labl-size1-' + id;

        var image = '#image-' + $(this).data('image');

        var url = $(this).data('url');

        var img = '#pruduct-image' + id;

        console.log(image);

        $('.product-image-thumb').removeClass('active');
        $(image).addClass("active");
        $(img).attr('src' , url);




        $(labl).hide();


        $(label).show();




    });


    $('input[type=radio].stock-select').change(function(){

        var id = $(this).data('id');

        var input = '.quantity-' + id ;

        var stock = $(this).data('stock');

        var limit = $(this).data('limit');

        var stock_id = $(this).data('stock_id');

        var locale = $(this).data('locale');



        var av  = '.av-qu-' + id + '-' + stock_id;

        $(input).val(1);

        $(input).prop('max',stock);


        if(limit == 'unlimited'){
            if(locale == 'ar'){
                $(av).html('كمية غير محدودة');
            }else{
                $(av).html('Unlimited');
            }
        }else{
            $(av).html(stock);
        }




    });



    $('#send-conf').on('click' , function(e){
        e.preventDefault();

        var loader = '#loader-conf';

        var url = $(this).data('url');


        $(loader).css('display', 'inline-block');

        $("#send-conf").attr("disabled", true);





        var startMinute = 1;
        var time = startMinute * 60;


        var intervalId = setInterval(updateCountdown , 1000);




        function updateCountdown(){

        var minutes = Math.floor(time / 60);
        var seconds = time % 60 ;

        seconds < startMinute ? '0' + seconds : seconds;

        $('.counter_down').html(minutes + ':' + seconds)


        if(minutes == 0 && seconds == 0){

            $("#send-conf").attr("disabled", false);
            $('.counter_down').html('');
            clearInterval(intervalId);


        }else{
            time--;
        }


        }


        $.ajax({
            url: url,
            method: 'GET',
            processData: false,
            contentType: false,
            cache: false,
            success: function(data) {


                if(data == 1){

                    $(loader).css('display', 'none');




                }



            }
        });






    });



    $('.add-cart').on('click' , function(e){
      e.preventDefault();




      var url = $(this).data('url');


      var product_country = $(this).data('product_country');
      var user_country = $(this).data('user_country');




    //   console.log(product_country);
    //   console.log(user_country);


      var method = $(this).data('method');

      var loader = $(this).data('product');
      var locale = $(this).data('locale');

      var cartbtn = $(this).data('cart');

      var productid = $(this).data('productid');

      var vendorPrice = $(this).data('price');

      var productType = $(this).data('type');

      console.log(productType);

      loader = '#' + loader;

      cartbtn = '#'  + cartbtn;

      var id = $(this).data('productid');

      productid = '#content-' + productid ;

      var selected = 'stock-select-' + id ;

     var stock =  $("input[type='radio'][name=" + selected + "]:checked").val();

     var stock_id = $("input[type='radio'][name=" + selected + "]:checked").data('stock_id');

     var alarm = '.alarm-' + id ;


     var alarm_success = '.alarm-success-' + id ;

     var stock_input = '.quantity-' + id ;

     var max = parseInt($("input[type='radio'][name=" + selected + "]:checked").data('stock'));

     var stock_value = parseInt($(stock_input).val());

     var price = '.price-' + id ;

     var max_price = parseInt($(price).attr('max'));
     var min_price = parseInt($(price).attr('min'));

     var price_value = parseInt($(price).val());


     console.log(max);
     console.log(stock_value);


     $(alarm_success).css('display', 'none');


     if(!stock){


        if(locale == 'ar'){
            $(alarm).html("يرجى تحديد المقاس واللون")
        }else{
            $(alarm).html("Please Select Size And Color")
        }

        $(alarm).css('display', 'block');

     }else{
        $(alarm).css('display', 'none');


        if(stock_value <= 0) {
            if(locale == 'ar'){
                $(alarm).html("يرجى ادخال كمية أكبر من الصفر")
            }else{
                $(alarm).html("Please enter an amount greater than zero")
            }

            $(alarm).css('display', 'block');
        }else{

            $(alarm).css('display', 'none');

            if(stock_value > max){

                if(locale == 'ar'){
                    $(alarm).html("لا يمكنك طلب كمية أكبر من " + max + " قطعة من هذا المنتج")
                }else{
                    $(alarm).html("You cannot order a quantity greater than " + max + " from this product")
                }

                $(alarm).css('display', 'block');

            }else{

                $(alarm).css('display', 'none');

                if (price_value < min_price || price_value > max_price) {

                    if(locale == 'ar'){
                        $(alarm).html("يجب أن يكون سعر البيع من " + min_price + " إلى " +  max_price)
                    }else{
                        $(alarm).html("Selling price must be between" + min_price + " to " +  max_price)
                    }

                    $(alarm).css('display', 'block');

                    }else{

                        $(alarm).css('display', 'none');


                                $(loader).css('display', 'inline-block');

                                var formData = new FormData();
                                formData.append('product_id' , id);
                                formData.append('stock_id' , stock_id);
                                formData.append('stock' , stock_value );
                                formData.append('price' , price_value );
                                formData.append('vendor_price' , vendorPrice );
                                formData.append('product_type' , productType );

                                $.ajax({
                                    url: url,
                                    data: formData,
                                    method: 'POST',
                                    processData: false,
                                    contentType: false,
                                    cache: false,
                                    success: function(data) {

                                        if(data == 1){



                                        $(loader).css('display', 'none');

                                        if(locale == 'ar'){
                                            $(alarm_success).html("تم إضافة المنتج في السلة بنجاح")
                                        }else{
                                            $(alarm_success).html("Product added to the cart successfully")
                                        }

                                        $(alarm_success).css('display', 'block');

                                        $(productid).empty();
                                        $(productid).append(data);
                                        $("#lblCartCount").text(parseInt($("#lblCartCount").text()) + 1);

                                        }else if(data == 0){

                                            $(loader).css('display', 'none');

                                            if(locale == 'ar'){
                                                $(alarm).html("المقاس واللون المحدد موجود بالفعل في سلة المشتريات")
                                            }else{
                                                $(alarm).html("The specified size and color is already in the cart")
                                            }

                                            $(alarm).css('display', 'block');

                                        }else if(data == 2){

                                            $(loader).css('display', 'none');

                                            if(locale == 'ar'){
                                                $(alarm).html("الكمية المطلوبة غير متاحه حاليا")
                                            }else{
                                                $(alarm).html("The requested quantity not available")
                                            }

                                            $(alarm).css('display', 'block');
                                        }else if(data == 3){
                                            $(loader).css('display', 'none');

                                            if(locale == 'ar'){
                                                $(alarm).html("السعر المطلوب غير مناسب يجب ان يتراوح السعر المدخل بين الحد الادنى والحد الاقصى للسعر ")
                                            }else{
                                                $(alarm).html("The requested price is not suitable. The entered price must be between a minimum and a maximum price")
                                            }

                                            $(alarm).css('display', 'block');
                                        }else if(data == 4){
                                            $(loader).css('display', 'none');

                                            if(locale == 'ar'){
                                                $(alarm).html("تم تحديث سعر هذا المنتج .. يرجى إعادة تحميل الصفحة لمعرفة السعر الحالى للمنتج ")
                                            }else{
                                                $(alarm).html("The price of this product has been updated.. Please reload the page to see the current price of the product")
                                            }

                                            $(alarm).css('display', 'block');
                                        }




                                    }
                                })



                    }
            }
        }

     }





  });


  $('body').on('keyup change', '.product-quantity', function() {

    var quantity = Number($(this).val()); //2

    var stock = $(this).data('stock');

    if ( quantity > stock){

        $('#exampleModalCenter1').modal({
            keyboard: false
          });

          $('.available-quantity').empty();
          $('.available-quantity').html(stock);

          $(this).val(stock);

    }else {

        var unitPrice = parseFloat($(this).data('price')); //150
        $(this).closest('tr').find('.product-price').html((quantity * unitPrice).toFixed(2));
        calculateTotal();
    }



});//end of product quantity change


$('body').on('keyup change', '.product-quantity-stock', function() {

    var quantity = Number($(this).val()); //2

    var stock = $(this).data('stock');

    var price = $(this).data('price');

    var quant = document.getElementsByName('quantity[]');

    var all_quan = 0;

    for (var i = 0; i < quant.length; i++) {
        all_quan += parseInt(quant[i].value);
    }

    console.log(all_quan)

    var total = '#total_order';

    if ( quantity > stock){

          $(this).val(stock);

    }else if (quantity < 0 ) {

        $(this).val(0);


    }else{
        $(total).html(all_quan * price);
    }

});//end of product quantity change



$('.order-products').on('click', function(e) {

    e.preventDefault();



    var url = $(this).data('url');

    var method = $(this).data('method');

    var loader = $(this).data('loader');

    console.log(loader);

    loader = '#' + loader;

    console.log(loader);


    $(loader).css('display', 'flex');



    $.ajax({
        url: url,
        method: method,
        success: function(data) {


            $('#exampleModalCenter2').modal({
                keyboard: false
              });

            $(loader).css('display', 'none');
            $('#order-product-list').empty();
            $('#order-product-list').append(data);

        }
    })

});//end of order products click


$(".img").change(function() {

    if (this.files && this.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
    $('.img-prev').attr('src', e.target.result);
    }

    reader.readAsDataURL(this.files[0]); // convert to base64 string
    }

    });

    $('body').on('keyup change', '.used_balance1', function() {


        var used_balance = Number($(this).val());

        var wallet_balance = $(this).data('wallet_balance');

        if(used_balance > wallet_balance){

            $('#balance_alert').modal({
                keyboard: false
            });

            $('.available-quantity').empty();
            $('.available-quantity').html(wallet_balance);

            $(this).val(wallet_balance);


        }

        if(used_balance < 0 ){

            $(this).val(0);
        }


        calculateTotal();





    });//end of product quantity change






});
