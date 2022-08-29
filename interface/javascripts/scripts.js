$(document).ready(function() {

   if($('.btnSwtich')[0]){
        $('.btnSwtich').btnSwitch({
            Theme: 'Android'
        });
    }


    $(document).on('input', '.formPc', function (event) {
        var myLength = $(this).val().trim().length;
        if(myLength ==1){
            $(this).prev('.formPc').focus();
        }
    });
    $('.formPc').keydown(function(e) {
        if ((e.which == 8 || e.which == 46) && $(this).val() =='') {
            $(this).next('input').focus();
        }
    });

    $('.countdown_dashboard').each(function () {
        var $currentCountDown = $(this);
        $('#'+$(this).attr('id')).countDown({
            targetDate: {
                'day':      parseInt($currentCountDown.data('day')),
                'month':    parseInt($currentCountDown.data('month')),
                'year':     parseInt($currentCountDown.data('year')),
                'hour':     parseInt($currentCountDown.data('hour')),
                'min':      parseInt($currentCountDown.data('min')),
                'sec':      parseInt($currentCountDown.data('sec'))
            },
            omitWeeks: true,
            omitdays: true
        });
    });

    var userListNum = 1;
    var changeTitle = function(){
        if(userListNum === 1){
            $('.sliderTitle').text('لیگ دسته چهارم');
        }else if(userListNum === 2){
            $('.sliderTitle').text('لیگ دسته سوم');
        }else if(userListNum === 3){
            $('.sliderTitle').text('لیگ دسته دوم');
        }else if(userListNum === 4){
            $('.sliderTitle').text('لیگ دسته اول');
        }
    }
    $('.sliderNext').click(function(event) {
        userListNum++;
        $('.userList').hide();
        $('#list'+userListNum).fadeIn(500);
        if(userListNum >= 4){
            $(this).fadeOut(500);
        }else{
            $(this).fadeIn(500);
        }
        if(userListNum >= 1){
            $('.sliderPrev').fadeIn(500);
        }else{
            $('.sliderPrev').fadeOut(500);
        }
        changeTitle();
    });
    $('.sliderPrev').click(function(event) {
        userListNum--;
        $('.userList').hide();
        $('#list'+userListNum).fadeIn(500);
        if(userListNum <= 4){
            $('.sliderNext').fadeIn(500);
        }else{
            $('.sliderNext').fadeOut(500);
        }
        if(userListNum <= 1){
            $(this).fadeOut(500);
        }else{
            $(this).fadeIn(500);
        }
        changeTitle();
    });


    $('#createqBtn').click(function(event) {
        $('#step1').hide();
        $('#step2').fadeIn(500);
    });

    $('#createq').click(function(event) {
        $('.createqOverlay').addClass('active');
        $('.backOverlay').fadeIn(500);
    });
    $('.overlayBackBtn, .createqSuccessBtn').click(function(event) {
        $('.createqOverlay').removeClass('active');
        $('.backOverlay').fadeOut(500);
    });

    $('.closeBtn,.okBtn').click(function(event) {
        $('.backOverlay,.popup').fadeOut(500);

    });


    var widthRezie = function(){
         var window_width = $(window).width();
        if(window_width < 768) {
            $(".appContainer").addClass('mobilev');
        }else{
            $(".appContainer").removeClass('mobilev');
        }
    }
    widthRezie();
    $(window).resize(function() {
        var window_width = $(window).width();
        widthRezie();
    });


//--------------------------------/ End document ready
});
