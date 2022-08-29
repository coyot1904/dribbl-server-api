<?php $this->load->view('/inc/head.inc.php');?>
<?php $this->load->view('/inc/menu.inc.php');?>
  <div class="container-fluid" style="margin-top:10%">
    <div class="row">
      <div class="col-sm-12">
        <?php if(@$this->session->flashdata('success') != null){?>
            <div class="alert alert-success" role="alert">
                <?php echo $this->session->flashdata('success');?>
            </div>
        <?php }?>
        <table class="table table-striped" style="margin-top:20px;">
          <thead>
            <tr>
              <th>#</th>
              <th>پیام</th>
              <th>دسته بندی</th>
              <th>کاربر</th>
              <th>زمان ارسال</th>
              <th>وضیعت پاسخ دهی</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php for($i=1;$i<count($message);$i++){?>
              <tr>
                <td><?php echo $i+1?></td>
                <td><?php echo $message[$i]['message'];?></td>
                <td>
                  <?php
                    if($message[$i]['category'] == 0)
                    {
                      echo "خرید سکه";
                    }
                    if($message[$i]['category'] == 1)
                    {
                      echo "پشتبانی";
                    }
                    if($message[$i]['category'] == 2)
                    {
                      echo "بازی آنلاین";
                    }
                    if($message[$i]['category'] == 3)
                    {
                      echo "خطا در بازی";
                    }
                  ?>
                </td>
                <td><?php echo $message[$i]['fname'];?> <?php echo $message[$i]['lname'];?></td>
                <td><?php echo $message[$i]['time'];?></td>
                <td><?php if($message[$i]['status'] == 0){echo "-";}else{echo "پاسخ داده شده";}?></td>
                <td>
                  <a style="color:green;" href="<?php echo base_url()?>index.php/admin/support_message/<?php echo $message[$i]['user_id'];?>/<?php echo $message[$i]['id'];?>">پاسخ به کاربر</a>
                </td>
              </tr>
            <?php }?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <?php $this->load->view('/inc/end.inc.php');?>
