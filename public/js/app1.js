$(document).ready(function(){




    $('.btn').on('click' , function(){

    $("#phone_hide").val($(".iti__selected-dial-code").html());

    $(this).closest('form').submit();

    $(".btn").attr("disabled", true);

    });


        $("#show-pass").on('click', function(event) {
            event.preventDefault();
            if($('#show_hide_password input').attr("type") == "text"){
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').addClass( "fa-eye-slash" );
                $('#show_hide_password i').removeClass( "fa-eye" );
            }else if($('#show_hide_password input').attr("type") == "password"){
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass( "fa-eye-slash" );
                $('#show_hide_password i').addClass( "fa-eye" );
            }
        });




    var startMinute = 1;
    var time = startMinute * 60;


    setInterval(updateCountdown , 1000);




    function updateCountdown(){

    var minutes = Math.floor(time / 60);
    var seconds = time % 60 ;

    seconds < startMinute ? '0' + seconds : seconds;

    $('.counter_down').html(minutes + ':' + seconds)


    if(minutes == 0 && seconds == 0){

        $('.resend').css('pointer-events' , 'auto');


    }else{
        time--;
    }


    }



});
