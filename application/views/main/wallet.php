<?php $this->load->view('/main/inc/head.inc.php');?>
	<input type="hidden" id="base_url" value="<?php echo base_url()?>"/>
	<input type="hidden" id="token" value="<?php echo $token;?>"/>
	<div class="appContainer appContainer2 clearfix" style="background-image: url('<?php echo base_url()?>interface/images/wallet.png');">
		<div class="centerBox">
			<header class="homeHeader">
				<div class="row">
					<div class="col-md-4 col-sm-4 col-xs-4 text-right ">
						<a href="#" class="homeLogo"><img src="<?php echo base_url()?>interface/images/homelogo.png" alt=""></a>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-4">
						<h2 class="topPageTitle storetopPageTitle">کیف پول</h2>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-4 text-left">
						<div class="headerIcons">
							<a href="javascript:void(0)" class="headerIcon refreshIcon"><span class="backBtn"></span></a>
						</div>
					</div>
				</div>
			</header>
			<div class="topWallet">
				<div class="balance">
					<?php echo $user_data[0]['money']?> تومان
				</div>
				<div class="balanceText">
					موجودی کیف پول جوایز
				</div>
				<a href="javascript:void(0)" class="withdrawBtn" id="requestMoney">درخواست برداشت وجه</a>
			</div>

			<div class="buyCoinText">
				با کمک موجودی کیف پول می توانید از<br> فروشگاه دریبل جون و سکه بخرید
			</div>
			<a href="<?php echo base_url()?>index.php/main/shop" class="gotoshopBtn">ورود به فروشگاه</a>

			<h3 class="withdrawHistoryTitle"><span>سوابق برداشت</span></h3>

			<table class="table">
				<tr>
				    <th>کد پیگیری</th>
				    <th>مبلغ برداشت</th>
				    <th>وضعیت</th>
				  </tr>
          <?php for($i=0;$i<count($list);$i++){?>
				  <tr>
				    <td><?php echo $list[$i]['id']?></td>
				    <td><span class="green"><?php echo $list[$i]['price']?> تومان</span></td>
				    <td><span class="orange"><?php echo $list[$i]['status']?></span></td>
				  </tr>
        <?php }?>
			</table>

		</div>
	</div>
  <?php $this->load->view('/main/inc/nav.inc.php');?>

	<?php $this->load->view('/main/inc/end.inc.php');?>
