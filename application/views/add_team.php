<?php $this->load->view('/inc/head.inc.php');?>
<?php $this->load->view('/inc/menu.inc.php');?>
  <div class="container-fluid" style="margin-top:10%">
    <div class="row">
      <div class="col-sm-2"></div>
      <div class="col-sm-8">
        <?php if(@$this->session->flashdata('error') != null){?>
            <div class="alert alert-danger" role="alert">
                <strong>خطا</strong>
                <?php echo $this->session->flashdata('error');?>
            </div>
        <?php }?>
        <form action="" method="post" style="margin-top:10px;" enctype="multipart/form-data">
          <div class="form-group">
            <label for="username">نام لیگ</label>
            <select name="team_id" class="form-control">
              <option disabled selected>انتخاب کنید</option>
              <?php for($i=0;$i<count($leuage);$i++){?>
                <option value="<?php echo $leuage[$i]['id'];?>"><?php echo $leuage[$i]['name'];?></option>
              <?php }?>
            </select>
          </div>
          <div class="form-group">
            <label for="username">عکس تیم</label>
            <input type="file" class="form-control" id="username" name="userfile">
          </div>
        <button type="submit" class="btn btn-primary">افزودن</button>
      </form>
      </div>
      <div class="col-sm-2"></div>
    </div>
  </div>
  <?php $this->load->view('/inc/end.inc.php');?>
