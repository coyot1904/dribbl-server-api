$( document ).ready(function() {
  var base_url = $('#base_url').val();
  $('#android').click(function(){
    document.location.href=$(this).val();
  });
  //-----------------
  $('#ios').click(function(){
    document.location.href=$(this).val();
  });
  //----------------
  $('#showall').click(function(){
    document.location.href=$(this).val();
  });
  //----------------
  $('#showcategory').click(function(){
    document.location.href=$(this).val();
  });
  //----------------
  $(document).on('change' , '#sort' , function(){
    var sort = $(this).val();
    var url  = window.location.href;
    $.ajax({
      type: 'POST',
      url: base_url+"ajax/sort_url_controller",
      data: {'url' : url , 'sort' : sort},
      dataType: "text",
      success: function(response) {
        window.location.replace(response);
      }
    });
  });
  //----------------
  $(document).on('click' , '#registering' , function(){
    var number = $('#telregsiter').val();
    if($.isNumeric($('#telregsiter').val()) && number.length > 10)
    {
      $.ajax({
        type: 'POST',
        url: base_url+"ajax/register",
        data: {'number' : number },
        dataType: "text",
        beforeSend: function() {
          $('#register_info').html('درخواست ثبت نام شما در سایت کالا به کالا در حال بررسی می باشد.لطفا شگیبا باشید.');
        },
        success: function(response) {
          if(response == 1)
          {
            $('#register_info').hide();
            $('#register_error').hide();
            if($('#register_success').css('display') == 'none')
            {
              $("#register").modal('hide');
              $('#register_success').html('ثبت نام شما با موفقیت انجام شد.رمز عبور شما توسط پیامک به تلفن همراه شما ارسال شده است.');
              $('#register_success').toggle();
              $("#login").modal('show');
            }
            else
            {
              $('#register_success').html('ثبت نام شما با موفقیت انجام شد.رمز عبور شما توسط پیامک به تلفن همراه شما ارسال شده است.');
            }
          }
          else
          {
            $('#register_success').hide();
            if($('#register_error').css('display') == 'none')
            {
              $('#register_error').html(response);
              $('#register_error').toggle();
            }
            else
            {
              $('#register_error').html(response);
            }
          }
        }
      });
    }
    else {
      $('#register_success').hide();
      if($('#register_error').css('display') == 'none')
      {
        $('#register_error').html('شماره وارد شده صحیح نمی باشد. لطفا دواره تلاش کنید.');
        $('#register_error').toggle();
      }
      else
      {
        $('#register_error').html('شماره وارد شده صحیح نمی باشد. لطفا دواره تلاش کنید.');
      }
    }
  });
  //----------------
  $('#telregsiter').keyup(function(e){
    if(e.keyCode == 13)
    {
      var number = $('#telregsiter').val();
      if($.isNumeric($('#telregsiter').val()) && number.length > 10)
      {
        $.ajax({
          type: 'POST',
          url: base_url+"ajax/register",
          data: {'number' : number },
          dataType: "text",
          success: function(response) {
            if(response == 1)
            {
              $('#register_error').hide();
              if($('#register_success').css('display') == 'none')
              {
                $('#register_success').html('ثبت نام شما با موفقیت انجام شد.رمز عبور شما توسط پیامک به تلفن همراه شما ارسال شده است.');
                $('#register_success').toggle();
              }
              else
              {
                $('#register_success').html('ثبت نام شما با موفقیت انجام شد.رمز عبور شما توسط پیامک به تلفن همراه شما ارسال شده است.');
              }
            }
            else
            {
              $('#register_success').hide();
              if($('#register_error').css('display') == 'none')
              {
                $('#register_error').html(response);
                $('#register_error').toggle();
              }
              else
              {
                $('#register_error').html(response);
              }
            }
          }
        });
      }
      else {
        $('#register_success').hide();
        if($('#register_error').css('display') == 'none')
        {
          $('#register_error').html('شماره وارد شده صحیح نمی باشد. لطفا دواره تلاش کنید.');
          $('#register_error').toggle();
        }
        else
        {
          $('#register_error').html('شماره وارد شده صحیح نمی باشد. لطفا دواره تلاش کنید.');
        }
      }
    }
  });
  //----------------
  $(document).on('change' , '#cat_parent' , function(){
    var category_id = $(this).val();
    $.ajax({
      type: 'POST',
      url: base_url+"ajax/get_sub_category_mine",
      data: {'category_id' : category_id},
      dataType: "text",
      success: function(response) {
        $('#from_category_mine_product').html(response);
        $('.category_mine_product').show();
      }
    });
  });
  //----------------
  $(document).on('change' , '#upload__input1' , function(){
    var file_data = $('#upload__input1').prop("files")[0];
    var form_data = new FormData();
    form_data.append('file', file_data);
    $.ajax({
        url: base_url+'user/upload_image', // point to server-side PHP script
        dataType: 'text',  // what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(response){
            if(response == 1)
            {
              $('#error_file1').html('فایل انتخابی شما بدلیل حجم زیاد و یا مناسب نبودن آن امکان بارگزاری را ندارد.');
              $('#error_file1').show();
              $('#upload__input1').val('');
            }
            else {
              $('#image_holder_mine').append('<input type="hidden" value="'+response+'" name="myimage_mine[]"/>');
              $('#error_file1').hide();
              $('#upload__input1').val('');
            }
        }
     });
  })
  //----------------
  $(document).on('change' , '#country' , function(){
    var country_id = $(this).val();
    $.ajax({
      type: 'POST',
      url: base_url+"ajax/get_cities",
      data: {'country_id' : country_id},
      dataType: "text",
      success: function(response) {
        $('#city_mine').html(response);
        $('.city_location').show();
        $('#city').select2();
      }
    });
  });
  //----------------
  $(document).on('change' , '#city' , function(){
    var city_id = $(this).val();
    $.ajax({
      type: 'POST',
      url: base_url+"ajax/get_district",
      data: {'city_id' : city_id},
      dataType: "text",
      success: function(response) {
        $('#district_mine').html(response);
        $('.district_loction').show();
        $('#mahale').select2();
      }
    });
  });
  //----------------
  $(document).on('change' , '#cat2' , function(){
    var category_id = $(this).val();
    $.ajax({
      type: 'POST',
      url: base_url+"ajax/get_sub_category_their",
      data: {'category_id' : category_id},
      dataType: "text",
      success: function(response) {
        $('#need_category').html(response);
        $('.need_category_parent').show();
      }
    });
  });
  //----------------
  $(document).on('change' , '#upload__input2' , function(){
    var file_data = $('#upload__input2').prop("files")[0];
    var form_data = new FormData();
    form_data.append('file', file_data);
    $.ajax({
        url: base_url+'user/upload_image', // point to server-side PHP script
        dataType: 'text',  // what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(response){
            if(response == 1)
            {
              $('#error_file2').html('فایل انتخابی شما بدلیل حجم زیاد و یا مناسب نبودن آن امکان بارگزاری را ندارد.');
              $('#error_file2').show();
              $('#upload__input2').val('');
            }
            else {
              $('#image_holder_need').append('<input type="hidden" value="'+response+'" name="myimage_need[]"/>');
              $('#error_file2').hide();
              $('#upload__input2').val('');
            }
        }
     });
  });
  //----------------
  $(document).on('click' , '#login-button' , function(){
    var tel = $('#tel-login').val();
    var password = $('#pass-login').val();
    $.ajax({
      type: 'POST',
      url: base_url+"ajax/login",
      data: {'tel' : tel , 'password' : password},
      dataType: "text",
      success: function(response) {
        if(response == 1)
        {
          window.location.replace(base_url+'main/profile');
        }
        else {
          if($('#login_error').css('display') == 'none')
          {
            $('#login_error').html('اطلاعات وارد شده صحیح نمیباشد.لطفا دوباره تلاش کنید');
            $('#login_error').toggle();
          }
          else
          {
            $('#login_error').hide();
            $('#login_error').html('اطلاعات وارد شده صحیح نمیباشد.لطفا دوباره تلاش کنید');
            $('#login_error').toggle();
          }
        }
      }
    });
  });
  //----------------
  $(document).on('click' , '#forget_password' , function(){
    $("#login").modal('hide');
    $("#forget").modal('show');
  });
  //----------------
  $(document).on('click' , '#login_open' , function(){
    $("#forget").modal('hide');
    $("#login").modal('show');
  });
  //----------------
  $(document).on('click' , '#login_open_new' , function(){
    $("#register").modal('hide');
    $("#login").modal('show');
  });
  //----------------
  $(document).on('click' , '#report_modal' , function(){
    $("#report").modal('show');
  });
  //----------------
  $(document).on('click' , '#report_button' , function(){
    var report = $('#report-text').val();
    var ads_id = $('#ads_id').val();
    $.ajax({
      type: 'POST',
      url: base_url+"ajax/report",
      data: {'ads_id' : ads_id , 'report' : report},
      dataType: "text",
      success: function(response) {
        $('#report_success').html('گزارش شما با موفقیت در سیستم ثبت گردید.کارشناسان کالابه کالا گزارش را پیگیری خواهند نمود.');
        $('#report_success').show();
      }
    });
  });
  //----------------
  $(document).on('click' , '#forget-button' , function(){
    var tel = $('#tel-forget').val();
    $.ajax({
      type: 'POST',
      url: base_url+"ajax/forget",
      data: {'tel' : tel},
      dataType: "text",
      success: function(response) {
        console.log(response);
        if(response == 2)
        {
          $('#forget_error').hide();
          if($('#forget_success').css('display') == 'none')
          {
            $('#forget_success').html('بازیابی رمز عبور شما با موفقیت انجام شد. رمز عبور جدید شما توسط پیام کوتاه برای شما ارسال خواهد  شد.');
            $('#forget_success').toggle();
          }
          else
          {
            $('#forget_success').hide();
            $('#forget_success').html('بازیابی رمز عبور شما با موفقیت انجام شد. رمز عبور جدید شما توسط پیام کوتاه برای شما ارسال خواهد  شد.');
            $('#forget_success').toggle();
          }
        }
        else {
          $('#forget_success').hide();
          if($('#forget_error').css('display') == 'none')
          {
            $('#forget_error').html('اطلاعات وارد شده صحیح نمیباشد.لطفا دوباره تلاش کنید');
            $('#forget_error').toggle();
          }
          else
          {
            $('#forget_error').hide();
            $('#forget_error').html('اطلاعات وارد شده صحیح نمیباشد.لطفا دوباره تلاش کنید');
            $('#forget_error').toggle();
          }
        }
      }
    });
  });
  //----------------
  $('#pass-login').keyup(function(e){
    if(e.keyCode == 13)
    {
      var tel = $('#tel-login').val();
      var password = $('#pass-login').val();
      $.ajax({
        type: 'POST',
        url: base_url+"ajax/login",
        data: {'tel' : tel , 'password' : password},
        dataType: "text",
        success: function(response) {
          if(response == 1)
          {
            window.location.replace(base_url+'main/profile');
          }
          else {
            if($('#login_error').css('display') == 'none')
            {
              $('#login_error').html('اطلاعات وارد شده صحیح نمیباشد.لطفا دوباره تلاش کنید');
              $('#login_error').toggle();
            }
            else
            {
              $('#login_error').hide();
              $('#login_error').html('اطلاعات وارد شده صحیح نمیباشد.لطفا دوباره تلاش کنید');
              $('#login_error').toggle();
            }
          }
        }
      });
    }
  });
  //----------------
  $(document).on('click' , '#edit-profile' , function(){
    var fname = $('#fname').val();
    var lname = $('#lname').val();
    var national_card = $('#national_card').val();
    var card = $('#TextBox1').val()+"-"+$('#TextBox2').val()+"-"+$('#TextBox3').val()+"-"+$('#TextBox4').val();
    var city_id = $('#city_id').val();
    var district = $('#district').val();
    var address = $('#address').val();
    var password = $('#password').val();
    var pass2 = $('#pass2').val();
    var email = $('#email').val();
    if(password != '')
    {
      if(password == pass2)
      {
        $.ajax({
          type: 'POST',
          url: base_url+"ajax/edit_profile",
          data: {'fname' : fname , 'lname' : lname , 'national_card' : national_card , 'card_number' : card , 'city_id' : city_id , 'district' : district , 'address' : address , 'password' : password , 'email' : email},
          dataType: "text",
          success: function(response) {
            $('#profile_error').hide();
            $('#profile_success').html('اطلاعات شما با موفقیت در سیستم به روز رسانی گردید.');
            $('#profile_success').show();
            $([document.documentElement, document.body]).animate({
                scrollTop: $(".kk-title_profile").offset().top
            }, 1500);
          }
        });
      }
      else {
        $('#profile_success').hide();
        $('#profile_error').html('رمز عبور انتخابی و تکرار آن برابر نیست لطفا دوباره تلاش کنید.');
        $('#profile_error').show();
        $([document.documentElement, document.body]).animate({
            scrollTop: $(".kk-title_profile").offset().top
        }, 1500);
      }
    }
    else {
      $.ajax({
        type: 'POST',
        url: base_url+"ajax/edit_profile",
        data: {'fname' : fname , 'lname' : lname , 'national_card' : national_card , 'card_number' : card , 'city_id' : city_id , 'district' : district , 'address' : address , 'email' : email},
        dataType: "text",
        success: function(response) {
          $('#profile_error').hide();
          $('#profile_success').html('اطلاعات شما با موفقیت در سیستم به روز رسانی گردید.');
          $('#profile_success').show();
          $([document.documentElement, document.body]).animate({
              scrollTop: $(".kk-title_profile").offset().top
          }, 1500);
        }
      });
    }
  });
  //----------------
  $(document).on('click' , '.ads_model' , function(){
    var type = $(this).attr('id');
    var url  = window.location.href;
    $.ajax({
      type: 'POST',
      url: base_url+"ajax/model_url_controller",
      data: {'url' : url , 'model' : type},
      dataType: "text",
      success: function(response) {
        window.location.replace(response);
      }
    });
  });
  //----------------
  $(document).on('click' , '.gotopro' , function(){
    var link = $(this).attr('id');
    window.location.replace(link);
  });
  //----------------
  $('#application').click(function(){
    $([document.documentElement, document.body]).animate({
        scrollTop: $(".application-section").offset().top
    }, 1500);
  });
  //----------------
  $(document).on('click' , '.remove_ads' , function(){
    var id = $(this).attr('id');
    $('#ads_'+id).remove();
    $.ajax({
      type: 'POST',
      url: base_url+"ajax/remove_ads",
      data: {'id' : id},
      dataType: "text",
      success: function(response) {
        //window.location.replace();
      }
    });
  });
  //----------------
  $(document).on('click' , '.edit_ads' , function(){
    var id = $(this).attr('id');
    window.location.replace(base_url+"main/edit_profile/"+id);
  });
  //----------------
  $(document).on('click' , '#open_tiket' , function(){
    $('#new_ticket').modal('show');
  });
  //----------------
  $(document).on('click' , '#replay_message' , function(){
    var message_id = $('#message_id').val();
    var message = $('#desc_message').val();
    var ads_id = $('#ads_id').val();
    $.ajax({
      type: 'POST',
      url: base_url+"ajax/replay_message",
      data: {'message_id' : message_id , 'message' : message , 'ads_id' : ads_id},
      dataType: "text",
      success: function(response) {
        $('#message_success').html('پیام شما با موفقیت ارسال گردید.کارشناسان ما در اسرع وقت با شما در تماس خواهند بود.');
        $('#message_success').toggle();
      }
    });
  });
  //----------------
  $(document).on('click' , '.category_search' , function(){
    var id = $(this).attr('id');
    var value = $('#cate_name_holder'+id).val();
    $('#cate_id').val(id);
    $('#cate_nameha').val(value);
    $('#cat').modal('hide');
  });
  //----------------
  $(document).on('click' , '.city_search' , function(){
    var id = $(this).attr('id');
    var value = $('#city_name_holder'+id).val();
    $('#city_id').val(id);
    $('#city_nameha').val(value);
    $('#city').modal('hide');
  });
  //----------------
  $(document).on('click' , '.upload__del1' , function(){
    var id = $(this).attr('id');
    $.ajax({
      type: 'POST',
      url: base_url+"ajax/delete_images",
      data: {'id' : id },
      dataType: "text",
      success: function(response) {
        $('#image_mine_'+id).remove();
        $('#image_srouce_need'+id).remove();
      }
    });
  });
  //----------------
});
