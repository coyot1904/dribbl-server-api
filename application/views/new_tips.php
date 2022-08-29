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
        <em style="font-size:10px;">پر کردن تمامی فیلدها الزامی می باشد.</em>
        <form action="" method="post" style="margin-top:10px;">
          <div class="form-group">
            <label for="username">متن</label>
            <input type="text" class="form-control" id="username" name="text">
          </div>
        <button type="submit" class="btn btn-primary">افزودن</button>
      </form>
      </div>
      <div class="col-sm-2"></div>
    </div>
  </div>
  <?php $this->load->view('/inc/end.inc.php');?>
