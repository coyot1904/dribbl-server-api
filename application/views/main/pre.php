<?php $this->load->view('/main/inc/head.inc.php');?>
	<input type="hidden" id="base_url" value="<?php echo base_url()?>"/>
	<input type="hidden" id="token" value="<?php echo $token;?>"/>

	<div class="appContainer center clearfix" style="background-image: url('<?php echo base_url()?>interface/images/pre.jpg');background-attachment: inherit;">
	</div>

	<!-- JS Files -->
	<script>window.jQuery || document.write('<script src="<?php echo base_url()?>interface/javascripts/jquery.min.js"><\/script>')</script>
	<script src="<?php echo base_url()?>interface/javascripts/jquery.cycle2.min.js"></script>
	<script src="<?php echo base_url()?>interface/javascripts/jquery.cycle2.carousel.js"></script>
	<script src="<?php echo base_url()?>interface/javascripts/scripts.js"></script>
  <script>
    setTimeout(function(){
      window.location.replace("<?php echo base_url()?>index.php/main/category/<?php echo $token;?>/<?php echo $game_id;?>");
    }, 3000);
  </script>
	<!--/JS Files -->

</body>
</html>
