<?php $this->load->view('/main/inc/head.inc.php');?>
	<input type="hidden" id="base_url" value="<?php echo base_url()?>"/>
	<header></header>
	<div class="appContainer center clearfix">
		<div class="centerBox" id="loginSection">
			<a href="#" class="logo"><img src="interface/images/logo.png" alt=""></a>
			<h3 class="pageTitle m20">ورود / ثبت نام</h3>
			<div class="formContanier">
				<div class="num">۹۸+</div>
				<input type="text" class="phoneInput" id="mobile">
				<div class="phoneText"><i class="fa fa-mobile" aria-hidden="true"></i>شماره همراه </div>
			</div>
			<input class="resigterBtn m20" type="submit" value="ورود" id="login">
		</div>
		<div class="centerBox" style="display : none" id="passwordSection">
			<a href="#" class="logo"><img src="interface/images/logo.png" alt=""></a>
			<div class="alert alert-danger" style="display : none;" id="error_box"></div>
			<h3 class="pageTitle m20">ورود</h3>
			<div class="registerText">کد فعالسازی به شماره +98<label id="mobileView">9126180000</label> ارسال گردید.</div>
			<div class="phoneConfirmContainer">
				<input class="formPc" type="text" id="f1">
				<input class="formPc" type="text" id="f2">
				<input class="formPc" type="text" id="f3">
				<input class="formPc" type="text" id="f4">
			</div>
			<input class="resigterBtn m20" type="submit" value="فعال سازی" id="getMeIn">
			<a href="javascript:void(0)" class="registerReturn" id="returnLogin">شماره اشتباه است ؟ تغییر دهید</a>
		</div>
	</div>
	<?php $this->load->view('/main/inc/end.inc.php');?>
