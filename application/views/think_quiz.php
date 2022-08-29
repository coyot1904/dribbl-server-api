<?php $this->load->view('/inc/head.inc.php');?>
<?php $this->load->view('/inc/menu.inc.php');?>
  <div class="container-fluid" style="margin-top:10%">
	<div class="row">
      <div class="col-sm-2"></div>
      <div class="col-sm-4">
        <form action="" method="post" style="margin-top:10px;">
          <div class="form-group">
            <label for="username">نام سوال</label>
            <input type="text" class="form-control" id="username" name="name">
          </div>
          <button type="submit" class="btn btn-primary">جستجو</button>
        </form>
      </div>
      <div class="col-sm-4"></div>
      <div class="col-sm-2"></div>
    </div>
    <div class="row" style="margin-top:10px;">
      <div class="col-sm-2"></div>
      <div class="col-sm-8">
        <?php if(@$this->session->flashdata('success') != null){?>
            <div class="alert alert-success" role="alert">
                <?php echo $this->session->flashdata('success');?>
            </div>
        <?php }?>
        <a href="<?php echo base_url();?>admin/new_think_quiz" style="color:green;">افزودن سوال جدید</a>
        <table class="table table-striped" style="margin-top:20px;">
          <thead>
            <tr>
              <th>#</th>
              <th>متن سوال</th>
              <th>رده بندی</th>
              <th>جواب درست</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php for($i=0;$i<count($quiz);$i++){?>
              <tr>
                <td><?php echo $i+1?></td>
                <td><?php echo $quiz[$i]['title'];?></td>
                <td><?php echo $quiz[$i]['level'];?></td>
                <td><?php echo $quiz[$i]['trueaw'];?></td>
                <td>
                  <a href="<?php echo base_url()?>admin/edit_think_quiz/<?php echo $quiz[$i]['id'];?>">ویرایش</a> -
                  <a href="<?php echo base_url()?>admin/delete_think_quiz/<?php echo $quiz[$i]['id'];?>" style="color:red;">حذف</a> -
                </td>
              </tr>
            <?php }?>
          </tbody>
        </table>
        <div><?php echo $this->pagination->create_links();?></div>
      </div>
      <div class="col-sm-2"></div>
    </div>
  </div>
  <?php $this->load->view('/inc/end.inc.php');?>
