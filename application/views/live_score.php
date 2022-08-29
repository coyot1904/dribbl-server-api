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
        <a href="<?php echo base_url();?>admin/live_reset" style="color:green;">ریست امتیازات</a>
        <table class="table table-striped" style="margin-top:20px;">
          <thead>
            <tr>
              <th>#</th>
              <th>نام و نام خانوادگی</th>
              <th>شماره تماس</th>
              <th>امتیاز</th>
            </tr>
          </thead>
          <tbody>
            <?php for($i=0;$i<count($score);$i++){?>
              <tr>
                <td><?php echo $i+1?></td>
                <td><?php echo $score[$i]['fname'];?> <?php echo $score[$i]['lname'];?></td>
                <td><?php echo $score[$i]['mobile'];?></td>
                <td><?php echo $score[$i]['score'];?></td>
              </tr>
            <?php }?>
          </tbody>
        </table>
      </div>
      <div class="col-sm-2"></div>
    </div>
  </div>
  <?php $this->load->view('/inc/end.inc.php');?>
