<?php $this->load->view('/main/inc/head.inc.php');?>
	<input type="hidden" id="base_url" value="<?php echo base_url()?>"/>
	<input type="hidden" id="token" value="<?php echo $token;?>"/>
	<div class="appContainer appContainer2 clearfix" style="background-image: url('<?php echo base_url()?>interface/images/leaderbg.jpg');">
		<div class="centerBox">
			<header class="homeHeader">
				<div class="row">
					<div class="col-md-4 col-sm-4 col-xs-4 text-right ">
						<a href="#" class="homeLogo"><img src="<?php echo base_url()?>interface/images/homelogo.png" alt=""></a>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-4">
						<h2 class="topPageTitle">رده بندی</h2>
					</div>
					<div class="col-md-4 col-sm-4 col-xs-4 text-left">
						<div class="headerIcons">
							<a href="#" class="headerIcon refreshIcon"><span class="backBtn"></span></a>
						</div>
					</div>
				</div>
			</header>

			<div class="ligueScorePage">
				<div class="ligueScorePageHeader">
					<div class="row">
						<div class="col-md-1 col-sm-1 col-xs-1 text-right">
							<a href="#"><span class="sliderPrev backBtn rotate"></span></a>
						</div>
						<div class="col-md-10 col-sm-10 col-xs-10">
							<div class="sliderHeader">
								<div class="sliderTitle"><?php echo $level;?></div>
								<div class="sliderTimeout"> 21 روز و 5ساعت و 22 دقیقه و 12 ثانیه تا پایان لیگ</div>
							</div>
						</div>
						<div class="col-md-1 col-sm-1 col-xs-1">
							<a href="#"><span class="sliderNext backBtn"></span></a>
						</div>
					</div>
				</div>
				<div class="ligueScorePageContent">
					<div class="userList" id="list1">
            <?php for($i=0;$i<count($leader);$i++){?>
						<div class="userListBox clearfix">
  						<div class="userBoxNum">
  								<span class="ubNbox"><?php echo $i+1?>.</span>
  							</div>
  							<div class="userBoxText">
  								<span class="userBoxImage"><img src="https://dribbl.ir/v2/assets/profile/<?php echo $leader[$i]['image'];?>" alt=""></span>
  								<h3 class="userBoxTitle"><?php echo $leader[$i]['fname'];?> <?php echo $leader[$i]['lname'];?></h3>
  							</div>
  							<div class="userBoxScrote">
  								<?php echo $leader[$i]['score']?> <span class="star"></span>
  							</div>
  						</div>
            <?php }?>
						<div class="circles">
							<div class="circle"></div>
							<div class="circle"></div>
							<div class="circle"></div>
						</div>
						<div class="userListBox clearfix">
							<div class="userBoxNum">
								<span class="ubNbox"><?php echo $mylevel;?></span>
							</div>
							<div class="userBoxText">
								<span class="userBoxImage"><img src="https://dribbl.ir/v2/assets/profile/<?php echo $user_data[0]['image'];?>" alt=""></span>
								<h3 class="userBoxTitle"><?php echo $user_data[0]['fname']?> <?php echo $user_data[0]['lname']?></h3>
							</div>
							<div class="userBoxScrote">
								<?php echo $user_data[0]['score']?> <span class="star"></span>
							</div>
						</div>
					</div>
					<div class="userList" id="list2">
            <?php for($i=0;$i<count($leage3);$i++){?>
						        <div class="userListBox clearfix">
							<div class="userBoxNum">
								<span class="ubNbox"><?php echo $i+1?>.</span>
							</div>
							<div class="userBoxText">
								<span class="userBoxImage"><img src="https://dribbl.ir/v2/assets/profile/<?php echo $leage3[$i]['image'];?>" alt=""></span>
								<h3 class="userBoxTitle"><?php echo $leage3[$i]['fname']?> <?php echo $leage3[$i]['lname']?></h3>
							</div>
							<div class="userBoxScrote">
								<?php echo $leage3[$i]['score']?> <span class="star"></span>
							</div>
						</div>
            <?php }?>
					</div>
					<div class="userList" id="list3">
            <?php for($i=0;$i<count($leage2);$i++){?>
                    <div class="userListBox clearfix">
              <div class="userBoxNum">
                <span class="ubNbox"><?php echo $i+1?>.</span>
              </div>
              <div class="userBoxText">
                <span class="userBoxImage"><img src="https://dribbl.ir/v2/assets/profile/<?php echo $leage2[$i]['image'];?>" alt=""></span>
                <h3 class="userBoxTitle"><?php echo $leage2[$i]['fname']?> <?php echo $leage2[$i]['lname']?></h3>
              </div>
              <div class="userBoxScrote">
                <?php echo $leage2[$i]['score']?> <span class="star"></span>
              </div>
            </div>
            <?php }?>
					</div>
					<div class="userList" id="list4">
            <?php for($i=0;$i<count($leage1);$i++){?>
                    <div class="userListBox clearfix">
              <div class="userBoxNum">
                <span class="ubNbox"><?php echo $i+1?>.</span>
              </div>
              <div class="userBoxText">
                <span class="userBoxImage"><img src="https://dribbl.ir/v2/assets/profile/<?php echo $leage1[$i]['image'];?>" alt=""></span>
                <h3 class="userBoxTitle"><?php echo $leage1[$i]['fname']?> <?php echo $leage1[$i]['lname']?></h3>
              </div>
              <div class="userBoxScrote">
                <?php echo $leage1[$i]['score']?> <span class="star"></span>
              </div>
            </div>
            <?php }?>
					</div>
				</div>
			</div>
		</div>
	</div>

  <?php $this->load->view('/main/inc/nav.inc.php');?>

	<?php $this->load->view('/main/inc/end.inc.php');?>
</html>
