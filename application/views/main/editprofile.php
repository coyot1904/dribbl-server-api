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
				<div class="formBox mb100">
					<input class="formInput" type="text" name="" id="fname" value="<?php echo $user_data[0]['fname']?>">
					<div class="inputInfo">نام</div>
				</div>
				<div class="formBox mb100">
					<input class="formInput" type="text" name="" id="lname" value="<?php echo $user_data[0]['lname']?>">
					<div class="inputInfo">نام خانوداگی</div>
				</div>
				<div class="formBox mb100">
					<input class="formInput" type="text" name="" id="cardNumber" value="<?php echo $user_data[0]['card']?>">
					<div class="inputInfo">شماره کارت جهت واریز جایزه ( 16رقمی )</div>
				</div>
			</div>
			<input type="submit" value="ثبت مشخصات" class="formSubmitBtn" id="editprofile">
		</div>
	</div>

	<div class="fixNav">
		<div class="fixNavIcons">
			<a href="#" class="fixNavIcon fixNavHome"></a>
		</div>
		<div class="fixNavIcons">
			<a href="#" class="fixNavIcon fixNavStore"></a>
		</div>
		<div class="fixNavIcons">
			<div class="fixNavGameContainer"><a href="#" class="fixNavIcon fixNavGame"></a> </div>
		</div>
		<div class="fixNavIcons">
			<a href="#" class="fixNavIcon fixNavSetting"></a>
		</div>
		<div class="fixNavIcons">
			<a href="#" class="fixNavIcon fixNavProfile"></a>
		</div>
	</div>
  <?php $this->load->view('/main/inc/nav.inc.php');?>

	<?php $this->load->view('/main/inc/end.inc.php');?>
