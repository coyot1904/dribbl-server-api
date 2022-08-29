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
        <form action="" method="post" style="margin-top:10px;" enctype="multipart/form-data">
          <div class="form-group">
            <label for="username">متن سوال</label>
            <input type="text" class="form-control" id="username" name="name" value="<?php echo $quiz[0]['name']?>">
          </div>
          <div class="form-group">
            <label for="username">عکس سوال</label>
            <input type="file" class="form-control" id="username" name="userfile">
          </div>
          <em>در صورت عدم ارسال عکس این فیلد ویرایش نمیگردد.</em>
          <div class="form-group">
            <label for="cate_id">دسته بندی سوال</label>
            <select id="cate_id" name="cate_id" class="form-control">
              <?php for($i=0;$i<count($category);$i++){?>
                <option value="<?php echo $category[$i]['id'];?>"><?php echo $category[$i]['name'];?></option>
              <?php }?>
            </select>
            <hr/>
            <div class="form-group">
              <label for="aw_1">جواب شماره یک</label>
              <input type="text" class="form-control" id="aw_1" name="aw_1" value="<?php echo $awsners[0]['title']?>">
            </div>
            <div class="form-group">
              <label for="aw_2">جواب شماره دوم</label>
              <input type="text" class="form-control" id="aw_2" name="aw_2" value="<?php echo $awsners[1]['title']?>">
            </div>
            <div class="form-group">
              <label for="aw_3">جواب شماره سوم</label>
              <input type="text" class="form-control" id="aw_3" name="aw_3" value="<?php echo $awsners[2]['title']?>">
            </div>
            <div class="form-group">
              <label for="aw_4">جواب شماره چهارم</label>
              <input type="text" class="form-control" id="aw_4" name="aw_4" value="<?php echo $awsners[3]['title']?>">
            </div>
            <div class="form-group">
              <label for="correct">شماره جواب درست</label>
              <input type="number" class="form-control" id="correct" name="correct">
              <em style="font-size:10px;color:red;">در زمان ویرایش لطفا شماره جواب درست را حتما وارد نمایید</em>
            </div>
          </div>
        <button type="submit" class="btn btn-primary">ویرایش</button>
      </form>
      </div>
      <div class="col-sm-2"></div>
    </div>
  </div>
  <?php $this->load->view('/inc/end.inc.php');?>
