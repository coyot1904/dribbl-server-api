<?php $this->load->view('/main/inc/head.inc.php');?>
	<input type="hidden" id="base_url" value="<?php echo base_url()?>"/>
	<input type="hidden" id="token" value="<?php echo $token;?>"/>
	<input type="hidden" id="liveStatus" value="<?php echo $showLive;?>"/>
	<input type="hidden" id="heart" value="<?php echo $user_data[0]['heart'];?>"/>
  <div class="appContainer clearfix">
		<div class="centerBox">
			<header class="homeHeader">
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-6 text-right ">
						<a href="#" class="homeLogo"><img src="<?php echo base_url()?>interface/images/homelogo.png" alt=""></a>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-6 text-left">
						<div class="headerIcons">
							<a href="javascript:void(0)" class="headerIcon scoreIcon gotoleader"><img src="<?php echo base_url()?>interface/images/score.png" alt=""></a>
							<a href="javascript:void(0)" class="headerIcon refreshIcon refreshData"><img src="<?php echo base_url()?>interface/images/refresh.png" alt=""></a>
						</div>
					</div>
				</div>
			</header>

			<div class="userInfo">
				<div class="userImage">
					<a href="javascript:void(0)" class="gotosetting"><img src="https://dribbl.ir/v2/assets/profile/<?php echo $user_data[0]['image'];?>" alt=""></a>
				</div>
				<div class="userLeft">
					<div class="userCenter">
						<h3 class="userTitle"><?php echo @$user_data[0]['fname'];?> <?php echo @$user_data[0]['lname'];?></h3>
						<div class="scoreCup">
							<div class="scoreCupImage"><img src="<?php echo base_url()?>interface/images/scoreCup.png" alt=""></div>
							<div class="scoreCupText">
								<div class="scoreCupTitle"><?php echo @$user_data[0]['leageData']['level'];?></div>
								<div class="scoreCupNum"><?php echo @$user_data[0]['all'];?> نفر در رقابت با شما</div>
							</div>
						</div>
					</div>
					<div class="userScore">
						<div class="userScoreNumber"><?php echo $user_data[0]['score'];?> امتیاز<span class="starIcon"></span></div>
						<div class="userCoin"><?php echo $user_data[0]['coin'];?><span class="coinIcon"></span></div>
					</div>
				</div>
			</div>
			<a href="javascript:void(0)" class="totalScore gotoleader">
				<div class="rightText">
					رتبه کل شما
				</div>
				<span class="leftNum">
					<div class="bigNum"><?php echo $user_data[0]['mylevel'];?></div>
					<span class="totalNum">از <?php echo $user_data[0]['all'];?> نفر</span>
				</span>
			</a>
			<a href="javascript:void(0)" class="ligueScore gotoleader">
				<div class="rightText">
					رتبه در لیگ
				</div>
				<span class="leftNum">
					<div class="bigNum"><?php echo $user_data[0]['poistion'];?></div>
					<span class="totalNum">از <?php echo $user_data[0]['leage_pos'];?> نفر</span>
				</span>
			</a>
			<div class="startLiveGame" id="gotolive">
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-6 text-right">
						<div class="text">تا بازی آنلاین بعدی</div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-6 text-left">
						    <div class="countdown_dashboard" id="countdown1" data-year="<?php echo $date[0];?>" data-month="<?php echo $date[1];?>" data-day="<?php echo $date[2];?>" data-hour="<?php echo $hour[0];?>" data-min="<?php echo $hour[1];?>" data-sec="<?php echo $hour[2];?>">
								<div class="dash hours_dash fade">
									<div class="digit">0</div>
									<div class="digit">0</div>
									<div class="timetext">ساعت</div>
								</div>
								<span>:</span>
								<div class="dash minutes_dash fade">
									<div class="digit">0</div>
									<div class="digit">0</div>
									<div class="timetext">دقیقه</div>
								</div>
								<span>:</span>
								<div class="dash seconds_dash fade">
									<div class="digit">0</div>
									<div class="digit">0</div>
									<div class="timetext">ثانیه</div>
								</div>
						    </div>
					</div>
				</div>
			</div>
			<a href="javascript:void(0)" class="startgame"><span class="startText">شروع بازی</span></a>


			<h3 class="lastGame"><span>آخرین مسابقات</span></h3>
			<div class="matchBoxes">
        <?php for($i=0;$i<count($history);$i++){?>
				   <div class="matchBox" id="<?php echo $history[$i]['id']?>">
      					<div class="matchBoxUser">
      						<img src="https://dribbl.ir/v2/assets/profile/<?php echo $history[$i]['user_a_image']?>" alt="">
      						<h4 class="matchBoxUserTitle"><?php echo $history[$i]['user_a_name']?></h4>
      					</div>
      					<div class="matchBoxUser">
      						<img src="https://dribbl.ir/v2/assets/profile/<?php echo $history[$i]['user_b_image']?>" alt="">
      						<h4 class="matchBoxUserTitle"><?php echo $history[$i]['user_b_name']?></h4>
      					</div>
      					<div class="matchBoxAction">
      						<?php echo $history[$i]['message']?>
      					</div>
      					<div class="matchBoxTime">
      						<?php echo $history[$i]['havij']?>
      					</div>
			     </div>
        <?php }?>
			</div>
		</div>
	</div>

	<?php $this->load->view('/main/inc/nav.inc.php');?>

	<?php $this->load->view('/main/inc/end.inc.php');?>
