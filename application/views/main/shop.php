<?php $this->load->view('/main/inc/head.inc.php');?>
	<input type="hidden" id="base_url" value="<?php echo base_url()?>"/>
	<input type="hidden" id="token" value="<?php echo $token;?>"/>
  <input type="hidden" id="user_id" value="<?php echo $user_data[0]['id'];?>"/>
	<div class="appContainer clearfix" style="background-image: url('<?php echo base_url()?>interface/images/shophead.jpg')">
		<div class="centerBox">
			<header class="homeHeader">
				<div class="row">
					<div class="col-md-4 col-sm-4 col-xs-4 text-right ">
						<a href="#" class="homeLogo"><img src="<?php echo base_url()?>interface/images/homelogo.png" alt=""></a>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-4">
						<h2 class="topPageTitle storetopPageTitle">فروشگاه</h2>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-4 text-left">
						<div class="headerIcons">
							<a href="#" class="headerIcon refreshIcon"><span class="backBtn"></span></a>
						</div>
					</div>
				</div>
			</header>

		</div>
		<div class="storeTop">
			<div class="centerBox">
				<div class="row">
					<div class="col-md-7 col-sm-7 col-xs-7">
						<div class="selectprofileImages">
							<div class="selectprofileImage" id="changeImage1">
								<img src="https://dribbl.ir/v2/assets/profile/useri1.png" alt="">
								<div class="selectprofileImageCoin">
									0
									<span class="coin"></span>
								</div>
							</div>
							<div class="selectprofileImage" id="changeImage2">
								<img src="https://dribbl.ir/v2/assets/profile/useri2.png" alt="">
								<div class="selectprofileImageCoin">
									50
									<span class="coin"></span>
								</div>
							</div>
							<div class="selectprofileImage" id="changeImage3">
								<img src="https://dribbl.ir/v2/assets/profile/useri3.png" alt="">
								<div class="selectprofileImageCoin">
									55
									<span class="coin"></span>
								</div>
							</div>
							<div class="selectprofileImage" id="changeImage4">
								<img src="https://dribbl.ir/v2/assets/profile/useri4.png" alt="">
								<div class="selectprofileImageCoin">
									0
									<span class="coin"></span>
								</div>
							</div>
							<div class="selectprofileImage" id="changeImage5">
								<img src="https://dribbl.ir/v2/assets/profile/useri5.png" alt="">
								<div class="selectprofileImageCoin">
									50
									<span class="coin"></span>
								</div>
							</div>
							<div class="selectprofileImage" id="changeImage6">
								<img src="https://dribbl.ir/v2/assets/profile/useri6.png" alt="">
								<div class="selectprofileImageCoin">
									55
									<span class="coin"></span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-5 col-sm-5 col-xs-5">
						<div class="storeProfileImage">
							<img src="https://dribbl.ir/v2/assets/profile/<?php echo $user_data[0]['image'];?>" alt="">
						</div>
						<div class="storeProfileTitle">
							پروفایل فعلی
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="storeCenter">
			<div class="centerBox">
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-6 text-right">
						<div class="storeSectionTitle">
							سکه فروشی
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-6 text-left">
						<div class="headerIcons">
							<a href="#" class="headerIcon coinIcon storeCoinIcon"><span class="coinText"><?php echo $user_data[0]['coin'];?></span><span class="coin"></span></a>
						</div>
					</div>
				</div>
				<div class="storeText">
					برای خرید سکه روی بسته مورد نظر لمس کنید تا به درگاه وصل شوید
				</div>

				<div class="buyCashBoxes">
					<a href="javascript:void(0)" class="buyCashBox" id="coinshop1">
						<div class="buyCashBoxImage"><img src="<?php echo base_url()?>interface/images/cashbox1.png" alt=""></div>
						<h3 class="buyCashBoxTitle">10000 سکه</h3>
						<div class="buyCashBoxPrice">50000 تومان</div>
						<div class="buyCashBoxPurchase">خرید</div>
					</a>
					<a href="javascript:void(0)" class="buyCashBox red" id="coinshop2">
						<span class="off">%25</span>
						<div class="buyCashBoxImage"><img src="<?php echo base_url()?>interface/images/cashbox2.png" alt=""></div>
						<h3 class="buyCashBoxTitle">1000 سکه</h3>
						<div class="buyCashBoxPrice">8000 تومان</div>
						<div class="buyCashBoxPurchase">خرید</div>
					</a>
					<a href="javascript:void(0)" class="buyCashBox" id="coinshop3">
						<div class="buyCashBoxImage"><img src="<?php echo base_url()?>interface/images/cashbox3.png" alt=""></div>
						<h3 class="buyCashBoxTitle">100 سکه</h3>
						<div class="buyCashBoxPrice">1000 تومان</div>
						<div class="buyCashBoxPurchase">خرید</div>
					</a>
				</div>

			</div>
		</div>
		<div class="storeCenter storeBottom">
			<div class="centerBox">
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-6 text-right">
						<div class="storeSectionTitle">
							بیمارستان
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-6 text-left">
						<div class="headerIcons">
							<a href="#" class="headerIcon coinIcon storeCoinIcon"><span class="coinText"><?php echo $user_data[0]['heart'];?></span><span class="heart"></span></a>
						</div>
					</div>
				</div>
				<div class="storeText storeHeartText">
					برای خرید جان روی بسته مورد نظر لمس کنید تا به درگاه وصل شوید
				</div>

				<div class="buyCashBoxes">
					<a href="javascript:void(0)" class="buyCashBox" id="heartShop1">
						<div class="buyCashBoxImage"><img src="<?php echo base_url()?>interface/images/heart3.png" alt=""></div>
						<h3 class="buyCashBoxTitle">100 جان</h3>
						<div class="buyCashBoxPrice">50000 تومان</div>
						<div class="buyCashBoxPurchase">خرید</div>
					</a>
					<a href="javascript:void(0)" class="buyCashBox" id="heartShop2">
						<div class="buyCashBoxImage"><img src="<?php echo base_url()?>interface/images/heart1.png" alt=""></div>
						<h3 class="buyCashBoxTitle">10 جان</h3>
						<div class="buyCashBoxPrice">8000 تومان</div>
						<div class="buyCashBoxPurchase">خرید</div>
					</a>
					<a href="javascript:void(0)" class="buyCashBox" id="heartShop3">
						<div class="buyCashBoxImage"><img src="<?php echo base_url()?>interface/images/heart2.png" alt=""></div>
						<h3 class="buyCashBoxTitle">1 جان</h3>
						<div class="buyCashBoxPrice">1000 تومان</div>
						<div class="buyCashBoxPurchase">خرید</div>
					</a>
				</div>
			</div>
		</div>
	</div>

  <?php $this->load->view('/main/inc/nav.inc.php');?>

	<?php $this->load->view('/main/inc/end.inc.php');?>
