<?php $this->load->view('/inc/head.inc.php');?>
<?php $this->load->view('/inc/menu.inc.php');?>
  <div class="container-fluid" style="margin-top:6%">
    <div class="row">
      <div class="col-sm-2"></div>
      <div class="col-sm-8">
        <?php if(@$this->session->flashdata('error') != null){?>
            <div class="alert alert-danger" role="alert">
                <strong>خطا</strong>
                <?php echo $this->session->flashdata('error');?>
            </div>
        <?php }?>
        <form action="" method="post" style="margin-top:10px;">
          <div class="form-group">
            <label for="username">نام</label>
            <input type="text" class="form-control" id="username" name="fname" value="<?php echo $user[0]['fname']?>">
          </div>
          <div class="form-group">
            <label for="correct">نام خانوداگی</label>
            <input type="text" class="form-control" id="correct" name="lname" value="<?php echo $user[0]['lname']?>">
          </div>
          <div class="form-group">
            <label for="correct">سکه</label>
            <input type="text" class="form-control" id="correct" name="coin" value="<?php echo $user[0]['coin']?>">
          </div>
          <div class="form-group">
            <label for="correct">جان</label>
            <input type="text" class="form-control" id="correct" name="heart" value="<?php echo $user[0]['heart']?>">
          </div>
          <div class="form-group">
            <label for="correct">امتیاز</label>
            <input type="text" class="form-control" id="correct" name="score" value="<?php echo $user[0]['score']?>">
          </div>
          <div class="form-group">
            <label for="correct">شماره تلفن</label>
            <input type="text" class="form-control" id="correct" name="corremobilect" value="<?php echo $user[0]['mobile']?>">
          </div>
          <div class="form-group">
            <label for="correct">موجودی کیف پول</label>
            <input type="text" class="form-control" id="correct" name="money" value="<?php echo $user[0]['money']?>">
          </div>
        <button type="submit" class="btn btn-primary">ویرایش</button>
      </form>
      </div>
      <div class="col-sm-2"></div>
    </div>
  </div>
  <?php $this->load->view('/inc/end.inc.php');?>
