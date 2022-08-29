<?php $this->load->view('/inc/head.inc.php');?>
<?php $this->load->view('/inc/menu.inc.php');?>
  <div class="container-fluid" style="margin-top:10%">
    <div class="row">
      <div class="col-sm-2"></div>
      <div class="col-sm-4">
        <form action="" method="post" style="margin-top:10px;">
          <div class="form-group">
            <label for="username">نام کاربری</label>
            <input type="text" class="form-control" id="username" name="name">
          </div>
          <div class="form-group">
            <label for="username">شماره تلفن همراه</label>
            <input type="text" class="form-control" id="mobile" name="mobile">
          </div>
          <button type="submit" class="btn btn-primary">جستجو</button>
        </form>
      </div>
      <div class="col-sm-4"></div>
      <div class="col-sm-2"></div>
    </div>
    <div class="row">
      <div class="col-sm-2"></div>
      <div class="col-sm-8">
        <?php if(@$this->session->flashdata('success') != null){?>
            <div class="alert alert-success" role="alert">
                <?php echo $this->session->flashdata('success');?>
            </div>
        <?php }?>
        <table class="table table-striped" style="margin-top:20px;">
          <thead>
            <tr>
              <th>#</th>
              <th>نام و نام خانوادگی</th>
              <th>امتیاز</th>
              <th>لیگ</th>
              <th>سکه </th>
              <th>جون</th>
              <th>مسدود سازی</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php for($i=0;$i<count($users);$i++){?>
              <tr>
                <td><?php echo $i+1?></td>
                <td><?php echo $users[$i]['fname'];?> <?php echo $users[$i]['lname'];?></td>
                <td><?php echo $users[$i]['score'];?></td>
                <td><?php echo $users[$i]['level'];?></td>
                <td><?php echo $users[$i]['coin'];?></td>
                <td><?php echo $users[$i]['heart'];?></td>
                <td>
                  <?php
                    if($users[$i]['ban'] == 1)
                    {
                      echo "مسدود شده";
                    }
                    else {
                      echo "اکانت آزاد";
                    }
                  ?>
                </td>
                <td>
                  <a href="<?php echo base_url()?>admin/edit_user/<?php echo $users[$i]['id'];?>">ویرایش</a> -
                  <a href="<?php echo base_url()?>admin/ban_user/<?php echo $users[$i]['id'];?>">مسدود سازی</a>
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
