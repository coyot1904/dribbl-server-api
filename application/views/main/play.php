<?php $this->load->view('/main/inc/head.inc.php');?>
	<input type="hidden" id="base_url" value="<?php echo base_url()?>"/>
	<input type="hidden" id="token" value="<?php echo $token;?>"/>
	<div class="appContainer clearfix">
		<div class="centerBox">
			<header class="homeHeader">
				<div class="row">
					<div class="col-md-4 col-sm-4 col-xs-4 text-right ">
						<a href="#" class="homeLogo"><img src="<?php echo base_url()?>interface/images/homelogo.png" alt=""></a>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-4">
						<h2 class="topPageTitle">نوع بازی</h2>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-4 text-left">
						<div class="headerIcons">
							<a href="#" class="headerIcon refreshIcon"><span class="backBtn"></span></a>
						</div>
						<div class="headerIcons">
							<a href="#" class="headerIcon coinIcon"><span class="coinText"><?php echo $user_data[0]['coin']?></span><span class="coin"></span></a>
						</div>
					</div>
				</div>
			</header>

			<div class="gameTypePage">
				<div class="gameTypeTitle">نوع بازی خود را انتخاب کنید</div>
				<a href="javascript:void(0)" id="chanceGame" class="randomGameBtn"><img src="<?php echo base_url()?>interface/images/randomgame.png" alt=""></a>
				<div class="clearfloat"></div>
				<div class="friendsGame"><span class="friendsGameIcon"></span><span class="friendGameText">بازی با دوستان</span> </div>

				<div class="userList block">
					<?php for($i=0;$i<count($friends);$i++){?>
						<div class="userInfo">
						<div class="userImage">
							<a href="#"><img src="https://dribbl.ir/v2/assets/profile/<?php echo $friends[$i]['image']?>" alt=""></a>
						</div>
						<div class="userLeft">
							<div class="userCenter">
								<h3 class="userTitle"><?php echo $friends[$i]['fname']?> <?php echo $friends[$i]['lname']?></h3>
								<div class="scoreCup">
									<div class="scoreCupImage"><img src="<?php echo base_url()?>interface/images/scoreCup.png" alt=""></div>
									<div class="scoreCupText">
										<div class="scoreCupTitle"><?php echo $friends[$i]['level']?></div>
									</div>
								</div>
							</div>
							<div class="userScore">
								<div class="userCoin"><?php echo $friends[$i]['score']?><span class="coinIcon"></span></div>
							</div>
						</div>
						<div class="friendBtns friendPageBtns">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-6">
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6">
									<a href="javascript:void(0)" class="friendBtn" id="<?php echo $friends[$i]['id']?>"><img src="<?php echo base_url()?>interface/images/friendlygame.png" alt=""></a>
								</div>
							</div>
						</div>
					</div>
					<?php }?>
				</div>
			</div>
		</div>
	</div>
	<div class="popup">
		<div class="popupTop">
			<span class="closeBtn"><span class="close"></span></span>
			<img src="<?php echo base_url();?>interface/images/popup.jpg" alt="">
			<div class="popupTopTitle">محدودیت تعداد بازی</div>
		</div>
		<div class="popupContetn">
			<div class="popupText">
				محدودیت تعداد بازی شما پایان یافته است شما می توانید با خرج کردن سکه به بازی بیشتر بپردازید
			</div>
			<div class="popupBtns">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12 mb25">
						<a href="#" class="popupBtn onlineBuyBtn" id="playCoinGame">50 سکه بازی بیشتر <span class="coin"></span></a>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12">
						<a href="#" class="popupBtn okBtn">انصراف</a>
					</div>
				</div>

			</div>
		</div>
	</div>
  <?php $this->load->view('/main/inc/nav.inc.php');?>

	<?php $this->load->view('/main/inc/end.inc.php');?>
