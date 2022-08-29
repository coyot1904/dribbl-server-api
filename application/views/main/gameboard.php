<?php $this->load->view('/main/inc/head.inc.php');?>
	<input type="hidden" id="base_url" value="<?php echo base_url()?>"/>
	<input type="hidden" id="token" value="<?php echo $token;?>"/>
  <input type="hidden" id="game_id" value="<?php echo $game_id;?>"/>
  <input type="hidden" id="round" value="<?php echo $game_data['round'];?>"/>
	<div class="appContainer clearfix">
		<div class="centerBox">
			<header class="homeHeader">
				<div class="row">
					<div class="col-md-4 col-sm-4 col-xs-4 text-right ">
						<a href="#" class="homeLogo"><img src="<?php echo base_url()?>interface/images/homelogo.png" alt=""></a>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-4">
					</div>
					<div class="col-md-4 col-sm-4 col-xs-4 text-left">
						<div class="headerIcons">
							<a href="<?php echo base_url()?>index.php/main/home/<?php echo $token;?>" class="headerIcon refreshIcon"><span class="backBtn"></span></a>
						</div>
						<div class="headerIcons">
							<a href="#" class="headerIcon coinIcon"><span class="coinText"><?php echo $user_data[0]['coin'];?></span><span class="coin"></span></a>
						</div>
					</div>
				</div>
			</header>

			<div class="roundPage">
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-6">
						<div class="ruImage">
							<img src="https://dribbl.ir/v2/assets/profile/<?php echo $game_data['user_a_image']?>" alt="">
						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-6">
						<div class="ruImage">
							<img src="https://dribbl.ir/v2/assets/profile/<?php echo $game_data['user_b_image']?>" alt="">
						</div>
					</div>
				</div>
				<div class="roundUsers">
					<div class="row">
						<div class="col-md-4 col-sm-4 col-xs-4">
							<div class="roundUserName"><?php echo $game_data['user_a_name']?></div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-4">
							<div class="matchResult">
								<span><?php echo $game_data['user_a_ponit']?></span>
								<span><?php echo $game_data['user_b_ponit']?></span>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-4 text-left">
							<div class="roundUserName"><?php echo $game_data['user_b_name']?></div>
						</div>
					</div>
				</div>
				<div class="roundBoxes">
          <?php for($i=0;$i<count($borad);$i++){?>
  					<div class="roundBox">
  						<div class="roundBoxStar">
  							<div class="gameStars">
  								<span class="gameStar <?php echo $borad[$i]['star1']?>"></span>
  								<span class="gameStar <?php echo $borad[$i]['star2']?>"></span>
  								<span class="gameStar <?php echo $borad[$i]['star3']?>"></span>
  							</div>
  						</div>
  						<div class="roundBoxTitle">
  							<div class="roundBoxTitleFirst"><?php echo $borad[$i]['round_name']?></div>
  							<div class="roundBoxTitleSecond"><?php echo $borad[$i]['round_category']?></div>
  						</div>
  						<div class="roundBoxStar">
  							<div class="gameStars">
  								<span class="gameStar <?php echo $borad[$i]['stary1']?>"></span>
  								<span class="gameStar <?php echo $borad[$i]['stary2']?>"></span>
  								<span class="gameStar <?php echo $borad[$i]['stary3']?>"></span>
  							</div>
  						</div>
  					</div>
          <?php }?>
				</div>
			</div>
		</div>
	</div>

	<div class="fixNav fixNavStart">
    <?php if(@$game_data['over'] == 1){?>
      <div class="gameTurn"><span class="hands"></span><?php echo $game_data['state'];?></div>
    <?php }else{?>
      <?php if($game_data['turn'] == 1){?>
  		  <div class="gameTurn" id="resumeGameOnNext"><span class="hands"></span>نوبت شماست</div>
      <?php }elseif($game_data['turn'] == 2){?>
        <div class="gameTurn"><span class="hands"></span>نوبت حریف</div>
      <?php }?>
    <?php }?>
	</div>

	<!-- JS Files -->
	<script>window.jQuery || document.write('<script src="<?php echo base_url()?>interface/javascripts/jquery.min.js"><\/script>')</script>
	<script src="<?php echo base_url()?>interface/javascripts/jquery.lwtCountdown-1.0.js"></script>
	<script src="<?php echo base_url()?>interface/javascripts/scripts.js"></script>
  <script src="<?php echo base_url()?>interface/javascripts/custom.js"></script>
	<!--/JS Files -->

</body>
</html>
