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
						<h2 class="topPageTitle">دوستان من</h2>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-4 text-left">
						<div class="headerIcons">
							<a href="#" class="headerIcon refreshIcon"><span class="backBtn"></span></a>
						</div>
						<div class="headerIcons">
							<a href="<?php echo base_url()?>index.php/main/shop/<?php echo $token?>" class="headerIcon coinIcon"><span class="coinText"><?php echo $user_data[0]['coin'];?></span><span class="coin"></span></a>
						</div>
					</div>
				</div>
			</header>

			<div class="searchBox clearfix">
				<input type="text" name="" id="friendName" class="searchInput" placeholder="جستجو نام کاربری دوستان">
				<div class="searchBtn">
					<input type="submit" value="" id="findFriends" class="searchSubmit">
				</div>
			</div>

			<div class="profileBtns mb100">
				<a href="javascript:void(0)" id="invCode" class="profileBtn"><span class="refCode">refCode!$#</span><img src="<?php echo base_url()?>interface/images/refcode.png" alt=""></a>
			</div>
      <div id="friendBox">
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
  							<a href="javascript:void(0)" class="friendBtn"><img src="<?php echo base_url()?>interface/images/addfriend.png" alt=""></a>
  						</div>
  						<div class="col-md-6 col-sm-6 col-xs-6">
  							<a href="<?php echo base_url()?>index.php/main/play/<?php echo $token;?>" class="friendBtn"><img src="<?php echo base_url()?>interface/images/friendlygame.png" alt=""></a>
  						</div>
  					</div>
  				</div>
  			</div>
      <?php }?>
      </div>
		</div>
	</div>

  <?php $this->load->view('/main/inc/nav.inc.php');?>

	<?php $this->load->view('/main/inc/end.inc.php');?>
