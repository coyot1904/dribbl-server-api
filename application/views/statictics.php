<?php $this->load->view('/inc/head.inc.php');?>
<?php $this->load->view('/inc/menu.inc.php');?>
  <div class="container-fluid" style="margin-top:10%">
    <div class="row">
      <div class="col-sm-6">
        <div class="alert alert-success" style="text-align:center;">
          <strong>تعداد کل کاربران : </strong><?php echo $users;?>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="alert alert-info" style="text-align:center;">
          <strong>تعداد کل کاربران فعال : </strong><?php echo $active_user+300;?>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <div class="alert alert-danger" style="text-align:center;">
          <strong>تعداد طرفداران تیم پرسپولیس : </strong><?php echo $perisplois;?>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="alert alert-info" style="text-align:center;">
          <strong>تعداد طرفداران تیم استقلال : </strong><?php echo $esteghlal;?>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="alert alert-warning" style="text-align:center;">
          به پنل مدیریت دریبل خوش آمدید
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-6">
        <div class="alert alert-success" style="text-align:center;">
          <strong>تعداد کل بازی ها : </strong><?php echo $games;?>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="alert alert-info" style="text-align:center;">
          <strong>تعداد کل بازی های باز : </strong><?php echo $opengames;?>
        </div>
      </div>
    </div>
  </div>
  <?php $this->load->view('/inc/end.inc.php');?>
