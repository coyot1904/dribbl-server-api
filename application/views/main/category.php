<?php $this->load->view('/main/inc/head.inc.php');?>
	<input type="hidden" id="base_url" value="<?php echo base_url()?>"/>
	<input type="hidden" id="token" value="<?php echo $token;?>"/>
  <input type="hidden" id="game_id" value="<?php echo $game_id;?>"/>
	<div class="appContainer clearfix">
		<div class="centerBox">
			<header class="homeHeader">
				<div class="row">
					<div class="col-md-4 col-sm-4 col-xs-4 text-right ">
						<a href="#" class="homeLogo"><img src="<?php echo base_url()?>interface/images/homelogo.png" alt=""></a>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-4">
						<h2 class="topPageTitle">نوع بازی</h2>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-4 text-left">
						<div class="headerIcons">
							<a href="#" class="headerIcon coinIcon"><span class="coinText"><?php echo $user_data[0]['coin']?></span><span class="coin"></span></a>
						</div>
					</div>
				</div>
			</header>

			<div class="chooseCatPage">
				<div class="chooseCatPageTitle">موضوع دسته بندی برای سوالات انتخاب کن</div>
        <?php for($i=0;$i<count($category);$i++){?>
				      <a href="javascript:void(0)" class="chooseCatBtn setCategory" id="<?php echo $category[$i]['id']?>"><?php echo $category[$i]['name']?></a>
        <?php }?>

				<div class="otherCatTitle">دسته بندی دیگری میخواهید؟</div>

				<a href="javascript:void(0)" class="buyCoin" id="changeCategory">
					<span class="textOuter">50 سکه <span class="lText">عوض کن</span></span>
					<span class="coinOuter"> <span class="coin"></span></span>
				</a>
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
