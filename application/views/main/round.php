<?php $this->load->view('/main/inc/head.inc.php');?>
	<input type="hidden" id="base_url" value="<?php echo base_url()?>"/>
	<input type="hidden" id="token" value="<?php echo $token;?>"/>
  <input type="hidden" id="game_id" value="<?php echo $game_id;?>"/>
  <input type="hidden" id="quiz_id" value="<?php echo $quiz[$count]['id']?>"/>
  <input type="hidden" id="round" value="<?php echo $round?>"/>
	<div class="appContainer clearfix">
		<header class="homeHeader gameHeader">
			<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-6">
					<h2 class="topPageTitle">حریف <?php echo $game_data['user_b_ponit']?> - <?php echo $game_data['user_a_ponit']?> شما</h2>
				</div>
				<div class="col-md-6 col-sm-6 col-xs-6 text-left">
					<div class="gameStars">
            <span class="gameStar <?php echo $star['star1']?>"></span>
						<span class="gameStar <?php echo $star['star2']?>"></span>
						<span class="gameStar <?php echo $star['star3']?>"></span>
					</div>
				</div>
			</div>
		</header>
		<div class="centerBox">
			<div class="qBox mb50">
				<div class="qboxCat"><?php echo $quiz[$count]['cate_name']?></div>
				<div class="qBoxText">
					<?php echo $quiz[$count]['name']?>
				</div>
			</div>
			<div class="qBoxAnswers">
				<a href="javascript:void(0)" class="qBoxAnswer win" id="voteUp">
					<span class="happy smile"></span>با حال بود
				</a>
				<a href="javascript:void(0)" class="qBoxAnswer loss" id="voteDown">
					<span class="sad smile"></span>خوشم نیومد
				</a>
				<a href="javascript:void(0)" class="qBoxAnswer nextq loss" id="resumeGame">
					ادامه مسابقه
				</a>
			</div>
		</div>

	</div>

	<div class="fixNav gameFixNav">
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-6">
				<div class="haveCoin"><span class="bigCoin"></span> <?php echo $user_data[0]['coin']?> سکه دارید</div>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-6">
				<div class="getCoin">
					<span class="getCoinText" id="goToShop">دریافت سکه</span>
					<span class="basket"></span>
				</div>
			</div>
		</div>
	</div>

	<!-- JS Files -->
  <script>window.jQuery || document.write('<script src="<?php echo base_url()?>interface/javascripts/jquery.min.js"><\/script>')</script>
	<script src="<?php echo base_url()?>interface/javascripts/jquery.lwtCountdown-1.0.js"></script>
	<script src="<?php echo base_url()?>interface/javascripts/scripts.js"></script>
  <script src="<?php echo base_url()?>interface/javascripts/custom.js"></script>
	<!--/JS Files -->

</body>
</html>
