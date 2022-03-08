$(document).ready(function(){




    var locale = $('.noty-nav').data('local');

    let id = $('.noty_id').data('id');



    console.log(id);


    // Subscribe to the channel we specified in our Laravel Event
    var channel = pusher.subscribe('new-notification');
    // Bind a function to a Event (the full Laravel class)
    channel.bind('notification-event', function (data) {

        console.log(data.status);

        if(id == data.user_id){
            var count = $('.badge-accent').html();
            $('.badge-accent').html(parseInt(count) + 1);


        var data =    `<a href="`+data.url+`" class="dropdown-item unread noty"
            data-url="`+data.change_status+`"
            >
            <div class="media">
              <img src="http://coponoo.com/storage/images/icon.png" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                    `+((data.status == 0) ? '<span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>' : '<span class="float-right text-sm text-success"><i class="fas fa-star"></i></span>') +`
                </h3>
                <p class="text-sm"><strong class="text-black-100" style="`+((locale == 'ar') ? 'text-align: right;' : '')+`">`+((locale == 'ar') ? data.title_ar : data.title_en)+`</strong>
                </p>
                <p class="text-sm"><span class="text-black-70" style="`+((locale == 'ar') ? 'text-align: right;' : '')+`">`+((locale == 'ar') ? data.body_ar : data.body_en)+`</span>

                </p>


                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i>`+data.date+`</p>
              </div>
            </div>
          </a>
          <div class="dropdown-divider"></div>`;

            // var data = `<a href="`+data.url+`"
            // class="list-group-item list-group-item-action unread noty"
            // data-url="`+data.change_status+`">
            //     <span class="d-flex align-items-center mb-1">

            //         <small class="text-black-50">`+data.date+`</small>


            //         <span class="`+((locale == 'ar') ? 'mr-auto' : 'ml-auto') +` unread-indicator bg-accent"></span>


            //     </span>
            //     <span class="d-flex">
            //         <span class="avatar avatar-xs mr-2">
            //             <img src="`+data.user_image+`"
            //                 alt="people"
            //                 class="avatar-img rounded-circle">
            //         </span>
            //         <span class="flex d-flex flex-column">
            //             <strong class="text-black-100" style="`+((locale == 'ar') ? 'text-align: right;' : '')+`">`+((locale == 'ar') ? data.title_ar : data.title_en)+`</strong>
            //             <span class="text-black-70" style="`+((locale == 'ar') ? 'text-align: right;' : '')+`">`+((locale == 'ar') ? data.body_ar : data.body_en)+`</span>
            //         </span>
            //     </span>
            // </a>`;

            $('.noty-list').prepend(data);
        }






    });



        $(document).on('click', '.noty', function (e) {



            e.preventDefault();




            let url = $(this).data('url');

            let link_target = $(this).attr('href');


            console.log(url)

            $.ajax({
                url: url,
                method: 'GET',
                success: function(data) {


                    window.location.href = link_target;

                }
            });//end of ajax call


        });//end of on click fav icon





});
