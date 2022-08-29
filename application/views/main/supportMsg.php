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
						<h2 class="topPageTitle">پیام پشتیبانی</h2>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-4 text-left">
						<div class="headerIcons">
							<a href="#" class="headerIcon refreshIcon"><span class="backBtn"></span></a>
						</div>
					</div>
				</div>
			</header>

			<div class="aboutBox sendmsgBox">
				<div>
					<select name="category" id="categorySupport">
						<option value="1">خرید سکه</option>
						<option value="2">پشتیبانی</option>
            <option value="3">بازی آنلاین</option>
            <option value="4">خطا در بازی</option>
					</select>
					<textarea name="" id="supportMsgData" cols="30" rows="10" placeholder="پیام خود را بنویسید"></textarea>
					<input type="submit" value="ثبت اطلاعات" id="sendSupportMessage">
				</div>
			</div>

		</div>
	</div>

  <?php $this->load->view('/main/inc/nav.inc.php');?>

	<?php $this->load->view('/main/inc/end.inc.php');?>
