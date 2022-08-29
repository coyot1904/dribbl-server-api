<?php $this->load->view('/inc/head.inc.php');?>
<?php $this->load->view('/inc/menu.inc.php');?>
  <div class="container-fluid" style="margin-top:10%">
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
              <th>پیام</th>
              <th>نام کاربری</th>
              <th>زمان ارسال</th>
            </tr>
          </thead>
          <tbody>
            <?php for($i=1;$i<count($message);$i++){?>
              <tr>
                <td><?php echo $i+1?></td>
                <td><?php echo $message[$i]['message'];?></td>
                <td><?php echo $message[$i]['username'];?></td>
                <td><?php echo $message[$i]['time'];?></td>
              </tr>
            <?php }?>
          </tbody>
        </table>
      </div>
      <div class="col-sm-2"></div>
    </div>
  </div>
  <?php $this->load->view('/inc/end.inc.php');?>
