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
        <form action="" method="post" style="margin-top:10px;" enctype="multipart/form-data">
          <div class="form-group">
            <label for="username">متن سوال</label>
            <input type="text" class="form-control" id="username" name="name">
          </div>
          <div class="form-group">
            <label for="username">عکس سوال</label>
            <input type="file" class="form-control" id="username" name="userfile">
          </div>
          <div class="form-group">
            <label for="cate_id">مرحله</label>
            <select id="cate_id" name="cate_id" class="form-control">
              <?php for($i=1;$i<201;$i++){?>
                <option value="<?php echo $i;?>"><?php echo $i;?></option>
              <?php }?>
            </select>
            <hr/>
            <div class="form-group">
              <label for="aw_1">جواب شماره یک</label>
              <input type="text" class="form-control" id="aw_1" name="aw_1">
            </div>
            <div class="form-group">
              <label for="aw_2">جواب شماره دوم</label>
              <input type="text" class="form-control" id="aw_2" name="aw_2">
            </div>
            <div class="form-group">
              <label for="aw_3">جواب شماره سوم</label>
              <input type="text" class="form-control" id="aw_3" name="aw_3">
            </div>
            <div class="form-group">
              <label for="aw_4">جواب شماره چهارم</label>
              <input type="text" class="form-control" id="aw_4" name="aw_4">
            </div>
            <div class="form-group">
              <label for="correct">شماره جواب درست</label>
              <input type="number" class="form-control" id="correct" name="correct">
            </div>
          </div>
        <button type="submit" class="btn btn-primary">افزودن</button>
      </form>
      </div>
      <div class="col-sm-2"></div>
    </div>
  </div>
  <?php $this->load->view('/inc/end.inc.php');?>
