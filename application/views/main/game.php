<?php $this->load->view('/main/inc/head.inc.php');?>
	<input type="hidden" id="base_url" value="<?php echo base_url()?>"/>
	<input type="hidden" id="token" value="<?php echo $token;?>"/>
  <input type="hidden" id="game_id" value="<?php echo $game_id;?>"/>
  <input type="hidden" id="quiz_id" value="<?php echo $quiz[$count]['id']?>"/>
  <input type="hidden" id="round" value="<?php echo $round?>"/>
  <input type="hidden" id="timeStatus" value="0"/>
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
			<div class="qBox">
				<div class="qboxCat"><?php echo $quiz[$count]['cate_name']?></div>
				<div class="qBoxText">
					<?php echo $quiz[$count]['name']?>
				</div>
			</div>
			<div class="progress progress-moved">
				<div class="progressIcon"></div>
				<div class="progress-bar" > </div>
			</div>

			<div class="qBoxAnswers">
        <?php for($i=0;$i<count($awnsers);$i++){?>
  				<a href="javascript:void(0)" class="qBoxAnswer <?php if($awnsers[$i]['status'] == 1){ echo "trueClass";}else{ echo "falseClass";}?>" id="<?php echo $awnsers[$i]['id']?>">
            <input type="hidden" value="<?php echo $awnsers[$i]['status']?>" id="aw_<?php echo $awnsers[$i]['id']?>"/>
  					<?php echo $awnsers[$i]['title']?>
  				</a>
        <?php }?>
			</div>

		</div>

	</div>

	<div class="fixNav gameFixNav">
		<a href="javascript:void(0)" class="buyCoin" id="stopTime">
			<span class="textOuter">50 سکه <span class="lText">توقف زمان</span></span>
			<span class="coinOuter"> <span class="coin"></span></span>
		</a>
		<a href="javascript:void(0)" class="buyCoin" id="makeItEasy">
			<span class="textOuter">50 سکه <span class="lText">آسان کردن</span></span>
			<span class="coinOuter"> <span class="coin"></span></span>
		</a>
	</div>

	<!-- JS Files -->
	<script>window.jQuery || document.write('<script src="<?php echo base_url()?>interface/javascripts/jquery.min.js"><\/script>')</script>
	<script src="<?php echo base_url()?>interface/javascripts/jquery.lwtCountdown-1.0.js"></script>
	<script src="<?php echo base_url()?>interface/javascripts/scripts.js"></script>
  <script src="<?php echo base_url()?>interface/javascripts/custom.js"></script>
	<!--/JS Files -->

</body>
</html>
