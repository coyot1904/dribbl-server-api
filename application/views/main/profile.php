<?php $this->load->view('/main/inc/head.inc.php');?>
	<input type="hidden" id="base_url" value="<?php echo base_url()?>"/>
	<input type="hidden" id="token" value="<?php echo $token;?>"/>
	<div class="appContainer clearfix">
		<div class="centerBox">
			<header class="homeHeader">
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-6 text-right ">
						<a href="#" class="homeLogo"><img src="<?php echo base_url()?>interface/images/homelogo.png" alt=""></a>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-6 text-left">
						<div class="headerIcons">
							<div class="headerIcons"> <a href="#" class="headerIcon refreshIcon"><span class="backBtn"></span></a> </div>
							<a href="<?php echo base_url()?>index.php/main/profile/<?php echo $token;?>" class="headerIcon refreshIcon"><img src="<?php echo base_url()?>interface/images/refresh.png" alt=""></a>
						</div>
					</div>
				</div>
			</header>

			<div class="userInfo">
				<div class="userImage">
					<a href="<?php echo base_url()?>index.php/main/setting"><img src="https://dribbl.ir/v2/assets/profile/<?php echo $user_data[0]['image'];?>" alt=""></a>
				</div>
				<div class="userLeft">
					<div class="userCenter">
						<h3 class="userTitle"><?php echo $user_data[0]['fname'];?> <?php echo $user_data[0]['lname'];?></h3>
						<div class="scoreCup">
							<div class="scoreCupImage"><img src="<?php echo base_url()?>interface/images/scoreCup.png" alt=""></div>
							<div class="scoreCupText">
								<div class="scoreCupTitle"><?php echo $user_data[0]['leageData']['level'];?></div>
								<div class="scoreCupNum"><?php echo $user_data[0]['all'];?> نفر در رقابت با شما</div>
							</div>
						</div>
					</div>
					<div class="userScore">
						<div class="userScoreNumber"><?php echo $user_data[0]['score'];?> امتیاز<span class="starIcon"></span></div>
						<div class="userCoin"><?php echo $user_data[0]['coin'];?><span class="coinIcon"></span></div>
					</div>
				</div>
				<div class="profileWallet">
					<div class="row">
						<div class="col-md-8 col-sm-8 col-xs-8">
							<div class="profileWalletIcon">
								<span class="walletIcon"></span>
							</div>
							<div class="profileWalletText">
								<?php echo $user_data[0]['money']?> تومان
								<span>موجودی کیف پول جوایز</span>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-4">
							<a href="<?php echo base_url()?>index.php/main/wallet/<?php echo $token;?>" class="cashOutBtn">برداشت </a>
						</div>
					</div>
				</div>
			</div>
			<div class="settingBtns">
				<a class="settingBtn" href="<?php echo base_url()?>index.php/main/friends/<?php echo $token;?>">
					<div class="row">
						<div class="col-md-2 col-sm-2 col-xs-2">
							<span class="friIcon"></span>
						</div>
						<div class="col-md-8 col-sm-8 col-xs-8">
							<h3 class="settingTitle frisettingTitle">دوستان من</h3>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2 text-left">
							<span class="backBtn"></span>
						</div>
					</div>
				</a>
			</div>
			<div class="profileBtns">
				<a href="javascript:void(0)" id="invCode" class="profileBtn"><span class="refCode">refCode!$#</span><img src="<?php echo base_url()?>interface/images/refcode.png" alt=""></a>
				<a href="javascript:void(0)" class="profileBtn" id="createq"><img src="<?php echo base_url()?>interface/images/createq.png" alt=""></a>
			</div>
		</div>
		<div class="createqOverlay">
			<div id="step1">
				<div class="createqForm">
					<div class="row mb25">
						<div class="col-md-6 col-sm-6 col-xs-6">
							<span class="qIcon"></span>سوال طرح کنید
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6 text-left">
							<span class="coin"></span>
							<span class="goldText">50 سکه جایزه</span>
							<a href="#" class="backBtn overlayBackBtn"></a>
						</div>
					</div>
					<div class="qfBox">
						<textarea name="" id="quiz_message" cols="30" rows="10" placeholder="برای مثال : نام اولین مربی تیم ملی ایران چه بود ؟"></textarea>
						<div class="gfText mb25">سوال خود را بنویسید </div>
					</div>
					<div class="qfBox">
						<input type="text" name="" id="aw_1" placeholder="اینجا بنویسید">
						<span class="qfNum">اولین جواب</span>
					</div>
					<div class="qfBox">
						<input type="text" name="" id="aw_2" placeholder="اینجا بنویسید">
						<span class="qfNum">دومین جواب</span>
					</div>
					<div class="qfBox">
						<input type="text" name="" id="aw_3" placeholder="اینجا بنویسید">
						<span class="qfNum">سومین جواب</span>
					</div>
					<div class="qfBox">
						<input type="text" name="" id="aw_3" placeholder="اینجا بنویسید">
						<span class="qfNum">چهارمین جواب</span>
					</div>
					<div class="qfBox">
						<input type="text" name="" id="true_aw" placeholder="اینجا بنویسید">
						<span class="qfNum">شماره جواب درست</span>
					</div>
					<div class="qfRules">
						<input type="checkbox" name="" id="qfRule">
						<label for="qfRule">قوانین ثبت سوال را قبول دارم</label>

					</div>
				</div>
				<input type="submit" value="درخواست ثبت" class="formSubmitBtn" id="createqBtn">
			</div>
			<div id="step2">
				<div class="createqSuccess">
					<span class="bigSuccess"></span>
					<div class="bigSuccessText">
						سوال با موفقیت ارسال شد.
					</div>
					<span class="bigCoin"></span>
					<div class="bigCoinText">50 سکه جایزه بعد از تایید</div>
					<input type="submit" value="خیلی ممنون" class="formSubmitBtn createqSuccessBtn">
				</div>
			</div>
		</div>
	</div>

	<div class="backOverlay"></div>

  <?php $this->load->view('/main/inc/nav.inc.php');?>

	<?php $this->load->view('/main/inc/end.inc.php');?>
