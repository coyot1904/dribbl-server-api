$(document).ready(function() {
  var base_url = $('#base_url').val();
  $(document).on('click' , '#login' , function(){
    var mobile = $('#mobile').val();
    var isnum = /^\d+$/.test(mobile);
    if(isnum == true)
    {
      $.ajax({
        type: 'POST',
        url: "https://dribbl.ir/v2/service/index",
        data: {'mobile' : mobile},
        dataType: "text",
        success: function(response) {
          $('#mobileView').html(mobile);
          $('#loginSection').hide();
          $('#passwordSection').show('slow');
        }
      });
    }
    else {
      alert('شماره موبایل وارد شده صحیح نمی باشد');
    }
  });
  //---------------
  $(document).on('click' , '#returnLogin' , function(){
    $('#passwordSection').hide();
    $('#loginSection').show('slow');
  });
  //---------------
  $(document).on('click' , '#getMeIn' , function(){
    var num1 = $('#f1').val();
    var num2 = $('#f2').val();
    var num3 = $('#f3').val();
    var num4 = $('#f4').val();
    var mobile = $('#mobile').val();
    var number = num4+num3+num2+num1;
    $.ajax({
      type: 'POST',
      url: "https://dribbl.ir/v2/service/login",
      data: {'mobile' : mobile , 'password' : number},
      dataType: "text",
      success: function(response) {
        var myObj = JSON.parse(response);
        if(myObj.status == 1)
        {
          $('#error_box').html('کد وارد شده صحیح نمی باشد.');
          $('#error_box').show();
        }
        else {
          window.location.replace(base_url+"index.php/main/home/"+myObj.status);
        }
      }
    });
  });
  //---------------
  $(document).on('click' , '#invCode' , function(){
    var token = $('#token').val();
    $.ajax({
      type: 'POST',
      url: "https://dribbl.ir/v2/service/get_inv_code",
      data: {'token' : token },
      dataType: "text",
      success: function(response) {
        var myObj = JSON.parse(response);
        var link = "https://dribbl.ir/live/download.php/?code="+myObj.result;
        copyToClipboard(link)
        alert('لینک دعوت در کلیپ بورد شما کپی گردید.');
      }
    });
  });
  //---------------
  function copyToClipboard(text) {
    var dummy = document.createElement("textarea");
    document.body.appendChild(dummy);
    dummy.value = text;
    dummy.select();
    document.execCommand("copy");
    document.body.removeChild(dummy);
  }
  //---------------
  $(document).on('click' , '#createqBtn' , function(){
    var token = $('#token').val();
    var quiz = $('#quiz_message').val();
    var aw_1 = $('#aw_1').val();
    var aw_2 = $('#aw_2').val();
    var aw_3 = $('#aw_3').val();
    var aw_4 = $('#aw_4').val();
    var true_aw = $('#true_aw').val();
    $.ajax({
      type: 'POST',
      url: "https://dribbl.ir/v2/service/set_quiz",
      data: {'token' : token  , 'quiz' : quiz , 'aw_1' : aw_1 , 'aw_2' : aw_2 , 'aw_3' : aw_3 , 'aw_4' : aw_4 , 'trueAw' : true_aw},
      dataType: "text",
      success: function(response) {
        //alert('سوال شما با موفقیت در سیستم درج گردید و پس از تایید مدیریت به نمایش گذاشته خواهد شد.');
      }
    });
  });
  //---------------
  $(document).on('click' , '#requestMoney' , function(){
    var token = $('#token').val();
    $.ajax({
      type: 'POST',
      url: "https://dribbl.ir/v2/service/giveMyMoney",
      data: {'token' : token},
      dataType: "text",
      success: function(response) {
        var myObj = JSON.parse(response);
        alert(response.game);
      }
    });
  });
  //---------------
  $(document).on('click' , '.refreshIcon' , function(){
    window.history.back();
  });
  //---------------
  $(document).on('click' , '#goToEditProfile' , function(){
    var token = $('#token').val();
    window.location.replace(base_url+"index.php/main/editprofile/"+token);
  });
  //---------------
  $(document).on('click' , '#editprofile' , function(){
    var token = $('#token').val();
    var fname = $('#fname').val();
    var lname = $('#lname').val();
    var card = $('#cardNumber').val();
    $.ajax({
      type: 'POST',
      url: "https://dribbl.ir/v2/service/cardChange",
      data: {'token' : token , 'fname' : fname , 'lname' : lname , 'card' : card},
      dataType: "text",
      success: function(response) {
        var myObj = JSON.parse(response);
        alert('اطلاعات با موفقیت در سیستم ویرایش گردید');
        window.location.replace(base_url+"index.php/main/editprofile/"+token);
      }
    });
  });
  //---------------
  $(document).on('click' , '#faq' , function(){
    window.location.replace("https://dribbl.ir/#dribbl11");
  });
  //---------------
  $(document).on('click' , '#term' , function(){
    window.location.replace("https://dribbl.ir/#dribbl8");
  });
  //---------------
  $(document).on('click' , '#support' , function(){
    var token = $('#token').val();
    window.location.replace(base_url+"index.php/main/support/"+token);
  });
  //---------------
  $(document).on('click' , '#coinshop1' , function(){
    var user_id = $('#user_id').val();
    window.location.replace("https://dribbl.ir/bank/index.php?user_id="+$user_id+"&amount=50000&coin=10000");
  });
  //---------------
  $(document).on('click' , '#coinshop2' , function(){
    var user_id = $('#user_id').val();
    window.location.replace("https://dribbl.ir/bank/index.php?user_id="+$user_id+"&amount=8000&coin=1000");
  });
  //---------------
  $(document).on('click' , '#coinshop3' , function(){
    var user_id = $('#user_id').val();
    window.location.replace("https://dribbl.ir/bank/index.php?user_id="+$user_id+"&amount=1000&coin=100");
  });
  //---------------
  $(document).on('click' , '#heartShop1' , function(){
    var user_id = $('#user_id').val();
    window.location.replace("https://dribbl.ir/bank/index.php?user_id="+$user_id+"&amount=50000&heart=100");
  });
  //---------------
  $(document).on('click' , '#heartShop2' , function(){
    var user_id = $('#user_id').val();
    window.location.replace("https://dribbl.ir/bank/index.php?user_id="+$user_id+"&amount=8000&heart=10");
  });
  //---------------
  $(document).on('click' , '#heartShop1' , function(){
    var user_id = $('#user_id').val();
    window.location.replace("https://dribbl.ir/bank/index.php?user_id="+$user_id+"&amount=1000&heart=1");
  });
  //---------------
  $(document).on('click' , '#changeImage1' , function(){
    var token = $('#token').val();
    $.ajax({
      type: 'POST',
      url: "https://dribbl.ir/v2/service/change_image",
      data: {'token' : token , 'count' : 1 , 'image_name' : 'useri1.png' },
      dataType: "text",
      success: function(response) {
        var myObj = JSON.parse(response);
        if(myObj.result == 1)
        {
          alert('شما به اندازه کافی سکه ندارید.');
        }
        else {
          alert('اطلاعات با موفقیت در سیستم ویرایش گردید');
          window.location.replace(base_url+"index.php/main/sop/"+token);
        }
      }
    });
  });
  //---------------
  $(document).on('click' , '#changeImage2' , function(){
    var token = $('#token').val();
    $.ajax({
      type: 'POST',
      url: "https://dribbl.ir/v2/service/change_image",
      data: {'token' : token , 'count' : 50 , 'image_name' : 'useri2.png' },
      dataType: "text",
      success: function(response) {
        var myObj = JSON.parse(response);
        if(myObj.result == 1)
        {
          alert('شما به اندازه کافی سکه ندارید.');
        }
        else {
          alert('اطلاعات با موفقیت در سیستم ویرایش گردید');
          window.location.replace(base_url+"index.php/main/sop/"+token);
        }
      }
    });
  });
  //---------------
  $(document).on('click' , '#changeImage3' , function(){
    var token = $('#token').val();
    $.ajax({
      type: 'POST',
      url: "https://dribbl.ir/v2/service/change_image",
      data: {'token' : token , 'count' : 55 , 'image_name' : 'useri3.png' },
      dataType: "text",
      success: function(response) {
        var myObj = JSON.parse(response);
        if(myObj.result == 1)
        {
          alert('شما به اندازه کافی سکه ندارید.');
        }
        else {
          alert('اطلاعات با موفقیت در سیستم ویرایش گردید');
          window.location.replace(base_url+"index.php/main/sop/"+token);
        }
      }
    });
  });
  //---------------
  $(document).on('click' , '#changeImage4' , function(){
    var token = $('#token').val();
    $.ajax({
      type: 'POST',
      url: "https://dribbl.ir/v2/service/change_image",
      data: {'token' : token , 'count' : 1 , 'image_name' : 'useri4.png' },
      dataType: "text",
      success: function(response) {
        var myObj = JSON.parse(response);
        if(myObj.result == 1)
        {
          alert('شما به اندازه کافی سکه ندارید.');
        }
        else {
          alert('اطلاعات با موفقیت در سیستم ویرایش گردید');
          window.location.replace(base_url+"index.php/main/sop/"+token);
        }
      }
    });
  });
  //---------------
  $(document).on('click' , '#changeImage5' , function(){
    var token = $('#token').val();
    $.ajax({
      type: 'POST',
      url: "https://dribbl.ir/v2/service/change_image",
      data: {'token' : token , 'count' : 50 , 'image_name' : 'useri5.png' },
      dataType: "text",
      success: function(response) {
        var myObj = JSON.parse(response);
        if(myObj.result == 1)
        {
          alert('شما به اندازه کافی سکه ندارید.');
        }
        else {
          alert('اطلاعات با موفقیت در سیستم ویرایش گردید');
          window.location.replace(base_url+"index.php/main/sop/"+token);
        }
      }
    });
  });
  //---------------
  $(document).on('click' , '#changeImage6' , function(){
    var token = $('#token').val();
    $.ajax({
      type: 'POST',
      url: "https://dribbl.ir/v2/service/change_image",
      data: {'token' : token , 'count' : 55 , 'image_name' : 'useri6.png' },
      dataType: "text",
      success: function(response) {
        var myObj = JSON.parse(response);
        if(myObj.result == 1)
        {
          alert('شما به اندازه کافی سکه ندارید.');
        }
        else {
          alert('اطلاعات با موفقیت در سیستم ویرایش گردید');
          window.location.replace(base_url+"index.php/main/sop/"+token);
        }
      }
    });
  });
  //---------------
  $(document).on('click' , '#makeCall' , function(){
    window.open('tel:02126208991');
  });
  //---------------
  $(document).on('click' , '#madness' , function(){
    window.location.replace("https://dribbl.ir/#dribbl10");
  });
  //---------------
  $(document).on('click' , '#supportMessage' , function(){
    var token = $('#token').val();
    window.location.replace(base_url+"index.php/main/supportMsg/"+token);
  });
  //---------------
  $(document).on('click' , '#sendSupportMessage' , function(){
    var token = $('#token').val();
    var category = $('#categorySupport').val();
    var message = $('#supportMsgData').val();
    $.ajax({
      type: 'POST',
      url: "https://dribbl.ir/v2/service/set_message",
      data: {'token' : token , 'message' : message , 'category' : category },
      dataType: "text",
      success: function(response) {
        alert('پیام شما با موفقیت در سیستم ثبت گردید و پس بررسی پاسخ داده خواهد شد.');
      }
    });
  });
  //---------------
  $(document).on('click' , '#findFriends' , function(){
    var token = $('#token').val();
    var username = $('#friendName').val();
    var i;
    $('#friendBox').empty();
    $.ajax({
      type: 'POST',
      url: "https://dribbl.ir/v2/service/search_user",
      data: {'token' : token , 'keyword' : username  },
      dataType: "text",
      success: function(response) {
        var myObj = JSON.parse(response);
        for (i = 0; i < myObj.length; i++) {
          $('#friendBox').append(
            '<div class="userInfo">'+
            '<div class="userImage">'+
            '<a href="#"><img src="https://dribbl.ir/v2/assets/profile/'+myObj[i].image+'" alt=""></a>'+
            '</div>'+
            '<div class="userLeft">'+
            '<div class="userCenter">'+
            '<h3 class="userTitle">'+myObj[i].fname+' '+myObj[i].lname+'</h3>'+
            '<div class="scoreCup">'+
            '<div class="scoreCupImage"><img src="'+base_url+'interface/images/scoreCup.png" alt=""></div>'+
            '<div class="scoreCupText">'+
            '<div class="scoreCupTitle">'+myObj[i].level+'</div>'+
            '</div>'+
            '</div>'+
            '</div>'+
            '<div class="userScore">'+
            '<div class="userCoin">'+myObj[i].score+'<span class="coinIcon"></span></div>'+
            '</div>'+
            '</div>'+
            '<div class="friendBtns friendPageBtns">'+
            '<div class="row">'+
            '<div class="col-md-6 col-sm-6 col-xs-6">'+
            '<a href="javascript:void(0)" class="friendBtn addFriendRequest" id="'+myObj[i].id+'"><img src="'+base_url+'interface/images/addfriend.png" alt=""></a>'+
            '</div>'+
            '<div class="col-md-6 col-sm-6 col-xs-6">'+
            '<a href="'+base_url+'index.php/main/play/'+token+'" class="friendBtn"><img src="'+base_url+'interface/images/friendlygame.png" alt=""></a>'+
            '</div>'+
            '</div>'+
            '</div>'+
            '</div>'
          );
        }
      }
    });
  });
  //---------------
  $(document).on('click' , '.addFriendRequest' , function(){
    var token = $('#token').val();
    var friend_id = $(this).attr('id');
    $.ajax({
      type: 'POST',
      url: "https://dribbl.ir/v2/service/request_friend",
      data: {'token' : token , 'user_id' : friend_id },
      dataType: "text",
      success: function(response) {
        alert('کاربر مورد نظر به لیست دوستان شما افزوده گردید.');
        window.location.replace(base_url+"index.php/main/friends/"+token);
      }
    });
  });
  //---------------
  $(document).on('click' , '#chanceGame' , function(){
    var token = $('#token').val();
    $.ajax({
      type: 'POST',
      url: base_url+"index.php/ajax/index",
      data: {'token' : token },
      dataType: "text",
      success: function(response) {
        var havij = JSON.parse(response);
        if(havij[0].status == 0)
        {
          window.location.replace(base_url+"index.php/main/pre/"+token+"/"+havij[0].game_id);
        }
        else if(havij[0].status == 1) {
          window.location.replace(base_url+"index.php/main/gameboard/"+token+"/"+havij[0].game_id);
        }
        else {
          $('.backOverlay,.popup').fadeIn(500);
        }
      }
    });
  });
  //---------------
  $(document).on('click' , '#changeCategory' , function(){
    var token = $('#token').val();
    $.ajax({
      type: 'POST',
      url: "https://dribbl.ir/v2/service/category_change",
      data: {'token' : token },
      dataType: "text",
      success: function(response) {
        var havij = JSON.parse(response);
        console.log(havij)
        if(havij.status == 1)
        {
          var game_id = $('#game_id').val();
          window.location.replace(base_url+"index.php/main/category/"+token+"/"+game_id);
        }
        else {
          alert('شما به اندازه کافی سکه ندارید');
        }
      }
    });
  });
  //---------------
  $(document).on('click' , '.setCategory' , function(){
    var token = $('#token').val();
    var category = $(this).attr('id');
    var game_id = $('#game_id').val();
    $.ajax({
      type: 'POST',
      url: base_url+"index.php/ajax/set_category",
      data: {'token' : token , 'game_id' : game_id , 'category_id' : category},
      dataType: "text",
      success: function(response) {
        var havij = JSON.parse(response);
        window.location.replace(base_url+"index.php/main/game/"+token+"/"+game_id+"/1");
      }
    });
  });
  //----------------
  $(document).on('click' , '.qBoxAnswer' , function(){
    var token = $('#token').val();
    var aw_id = $(this).attr('id');
    var game_id = $('#game_id').val();
    var status = $('#aw_'+aw_id).val();
    var quiz_id = $('#quiz_id').val();
    if(status == 1)
    {
      $(this).addClass("win");
    }
    else {
      $('.trueClass').addClass("win");
      $(this).addClass("loss");
    }
    $.ajax({
      type: 'POST',
      url: base_url+"index.php/ajax/setAwnser",
      data: {'token' : token , 'game_id' : game_id , 'quiz_id' : quiz_id , 'awnser_id' : aw_id},
      dataType: "text",
      success: function(response) {
        setTimeout(function(){
          var round = parseInt($('#round').val());
          window.location.replace(base_url+"index.php/main/round/"+token+"/"+game_id+"/"+round);
        }, 1000);
      }
    });
  });
  //----------------
  $(document).on('click' , '#goToShop' , function(){
    var token = $('#token').val();
    window.location.replace(base_url+"index.php/main/shop/"+token);
  });
  //----------------
  $(document).on('click' , '#resumeGame' , function(){
    var token = $('#token').val();
    var game_id = $('#game_id').val();
    var round = parseInt($('#round').val()) + 1;
    if(round > 3)
    {
      $.ajax({
        type: 'POST',
        url: base_url+"index.php/ajax/change_queue",
        data: {'token' : token , 'game_id' : game_id},
        dataType: "text",
        success: function(response) {
          window.location.replace(base_url+"index.php/main/gameboard/"+token+"/"+game_id);
        }
      });
    }
    else {

      window.location.replace(base_url+"index.php/main/game/"+token+"/"+game_id+"/"+round);
    }
  });
  //----------------
  $(document).on('click' , '#voteUp' , function(){
    var token = $('#token').val();
    var game_id = $('#game_id').val();
    var quiz_id = $('#quiz_id').val();
    var round = parseInt($('#round').val()) + 1;
    $.ajax({
      type: 'POST',
      url: "https://dribbl.ir/v2/service/vote_quiz",
      data: {'token' : token , 'quiz_id' : quiz_id  , 'vote' : 1},
      dataType: "text",
      success: function(response) {
        alert('رای شما با موفقیت در سیستم درج گردید.')
      }
    });
  });
  //----------------
  $(document).on('click' , '#voteDown' , function(){
    var token = $('#token').val();
    var game_id = $('#game_id').val();
    var quiz_id = $('#quiz_id').val();
    var round = parseInt($('#round').val()) + 1;
    $.ajax({
      type: 'POST',
      url: "https://dribbl.ir/v2/service/vote_quiz",
      data: {'token' : token , 'quiz_id' : quiz_id  , 'vote' : 2},
      dataType: "text",
      success: function(response) {
        alert('رای شما با موفقیت در سیستم درج گردید.')
      }
    });
  });
  //----------------
  $(document).on('click' , '#makeItEasy' , function(){
    var token = $('#token').val();
    $.ajax({
      type: 'POST',
      url: "https://dribbl.ir/v2/service/increaseCoin",
      data: {'token' : token , 'amount' : 70},
      dataType: "text",
      success: function(response) {
        var havij = JSON.parse(response);
        if(havij.result == 2)
        {
          alert('شما به اندازه کافی سکه ندارید.');
        }
        else {
          $(".falseClass:first").addClass("loss");
        }
      }
    });
  });
  //----------------
  if($('.progress')[0]){
      setTimeout(function(args) {
        var token = $('#token').val();
        var game_id = $('#game_id').val();
        var quiz_id = $('#quiz_id').val();
        var round = parseInt($('#round').val());
        var status = $('#timeStatus').val();
        if(status == 0)
        {
          $('.trueClass').addClass("yellow");
          $.ajax({
            type: 'POST',
            url: base_url+"index.php/ajax/dontAwnser",
            data: {'token' : token , 'quiz_id' : quiz_id  , 'game_id' : game_id},
            dataType: "text",
            success: function(response) {
              setTimeout(function(){
                window.location.replace(base_url+"index.php/main/round/"+token+"/"+game_id+"/"+round);
              }, 100);
            }
          });
        }
      },  5000);
  }
  //----------------
  $(document).on('click' , '#stopTime' , function(){
    var token = $('#token').val();
    $.ajax({
      type: 'POST',
      url: "https://dribbl.ir/v2/service/increaseCoin",
      data: {'token' : token , 'amount' : 50},
      dataType: "text",
      success: function(response) {
        var havij = JSON.parse(response);
        if(havij.result == 2)
        {
          alert('شما به اندازه کافی سکه ندارید.');
        }
        else {
          $('#timeStatus').val('1');
        }
      }
    });
  });
  //----------------
  $(document).on('click' , '#resumeGameOnNext' , function(){
    var game_id = $('#game_id').val();
    var token = $('#token').val();
    var round = $('#round').val();
    $.ajax({
      type: 'POST',
      url: base_url+"index.php/ajax/check_round_game",
      data: {'token' : token , 'game_id' : game_id , 'round' : round},
      dataType: "text",
      success: function(response) {
        var havij = JSON.parse(response);
        if(havij.result == 1)
        {
          window.location.replace(base_url+"index.php/main/category/"+token+"/"+game_id);
          //category
        }
        else {
          window.location.replace(base_url+"index.php/main/game/"+token+"/"+game_id+"/1");
          //game
        }
      }
    });
  });
  //----------------
  $(document).on('click' , '.matchBox' , function(){
    var game_id = $(this).attr('id');
    var token = $('#token').val();
    window.location.replace(base_url+"index.php/main/gameboard/"+token+"/"+game_id);
  });
  //----------------
  $(document).on('click' , '#playCoinGame' , function(){
    var token = $('#token').val();
    $.ajax({
      type: 'POST',
      url: base_url+"index.php/ajax/addCoinGame",
      data: {'token' : token},
      dataType: "text",
      success: function(response) {
        var havij = JSON.parse(response);
        if(havij < 0)
        {
          alert('شما به اندازه کافی سکه ندارید');
        }
        else {
          window.location.replace(base_url+"index.php/main/pre/"+token+"/"+havij[0].game_id);
        }
      }
    });
  });
  //----------------
  $(document).on('click' , '.friendBtn' , function(){
    var token = $('#token').val();
    var friend_id = $(this).attr('id');
    $.ajax({
      type: 'POST',
      url: base_url+"index.php/ajax/friend_game",
      data: {'token' : token , 'friend_id' : friend_id},
      dataType: "text",
      success: function(response) {
        var havij = JSON.parse(response);
        if(havij.game ==  -1)
        {
          alert('محدودیت بازی شما به اتمام رسیده است.');
        }
        else {
          window.location.replace(base_url+"index.php/main/pre/"+token+"/"+havij.game_id);
        }
      }
    });
  });
  //----------------
});
