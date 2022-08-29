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

			<div class="settingBtns mt50">
				<div class="settingBtn">
					<div class="row" id="makeCall">
						<div class="col-md-2 col-sm-2 col-xs-2">
							<span class="telIcon"></span>
						</div>
						<div class="col-md-8 col-sm-8 col-xs-8">
							<h3 class="settingTitle">26208991 - 021</h3>
							<h4 class="settingSubTitle">برقراری تماس با دریبل</h4>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2 text-left">
							<span class="backBtn"></span>
						</div>
					</div>
				</div>
				<div class="settingBtn">
					<div class="row" id="supportMessage">
						<div class="col-md-2 col-sm-2 col-xs-2">
							<span class="supportIcon"></span>
						</div>
						<div class="col-md-8 col-sm-8 col-xs-8">
							<h3 class="settingTitle">پیام پشتیبانی</h3>
							<h4 class="settingSubTitle">ارسال پیام پشتیبانی به اپراتور دریبل</h4>
						</div>
						<div class="col-md-2 col-sm-2 col-xs-2 text-left">
							<span class="backBtn"></span>
						</div>
					</div>
				</div>
				<div class="settingBtn">
					<div class="row" id="madness">
						<div class="col-md-2 col-sm-2 col-xs-2">
							<span class="ruleIcon"></span>
						</div>
						<div class="col-md-8 col-sm-8 col-xs-8">
							<h3 class="settingTitle">ثبت شکایات</h3>
							<h4 class="settingSubTitle">شکایت و پیشنهاد خود را ارسال کنید</h4>
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
