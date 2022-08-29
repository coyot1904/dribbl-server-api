<?php $this->load->view('/main/inc/head.inc.php');?>
	<input type="hidden" id="base_url" value="<?php echo base_url()?>"/>
	<input type="hidden" id="token" value="<?php echo $token;?>"/>
	<div class="appContainer clearfix">
		<div class="centerBox">
			<header class="homeHeader">
				<div class="row">
					<div class="col-md-4 col-sm-4 col-xs-4 text-right ">
						<a href="#" class="homeLogo"><img src="interface/images/homelogo.png" alt=""></a>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-4">
						<h2 class="topPageTitle storetopPageTitle">تنظیمات</h2>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-4 text-left">
						<div class="headerIcons">
							<a href="#" class="headerIcon refreshIcon"><span class="backBtn"></span></a>
						</div>
					</div>
				</div>
			</header>

			<div class="userInfo settingPage">
				<div class="row" id="goToEditProfile">
					<div class="col-md-8 col-sm-8 col-xs-8">
						<h3 class="settingTitle">تنظیمات کاربری</h3>
						<h4 class="settingSubTitle">مشخصات حساب شخصی و کاربری</h4>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-4 text-left">
						 <div class="editText">ویرایش</div><span class="backBtn"></span>
					</div>
				</div>
			</div>

			<div class="settingBtns">
				<div class="settingBtn">
					<div class="row" id="support">
						<div class="col-md-2 col-sm-2 col-xs-2">
							<span class="supportIcon"></span>
						</div>
						<div class="col-md-8 col-sm-8 col-xs-8">
							<h3 class="settingTitle">پشتیبانی آنلاین</h3>
							<h4 class="settingSubTitle">مشکلات و سوالات خود را مطرح کنید</h4>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2 text-left">
							<span class="backBtn"></span>
						</div>
					</div>
				</div>
				<div class="settingBtn">
					<div class="row" id="faq">
						<div class="col-md-2 col-sm-2 col-xs-2">
							<span class="faqIcon"></span>
						</div>
						<div class="col-md-8 col-sm-8 col-xs-8">
							<h3 class="settingTitle">سوالات متداول</h3>
							<h4 class="settingSubTitle">سوالات و پاسخ های از پیش نوشته</h4>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2 text-left">
							<span class="backBtn"></span>
						</div>
					</div>
				</div>
				<div class="settingBtn">
					<div class="row" id="term">
						<div class="col-md-2 col-sm-2 col-xs-2">
							<span class="ruleIcon"></span>
						</div>
						<div class="col-md-8 col-sm-8 col-xs-8">
							<h3 class="settingTitle">قوانین و مقررات</h3>
							<h4 class="settingSubTitle">مرامنامه بازیکنان برای بازی در دریبل</h4>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2 text-left">
							<span class="backBtn"></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

  <?php $this->load->view('/main/inc/nav.inc.php');?>

	<?php $this->load->view('/main/inc/end.inc.php');?>
