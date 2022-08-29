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
              <th>نام و نام خانوادگی</th>
              <th>سکه</th>
              <th>جون</th>
              <th>مبلغ</th>
              <th>وضعیت</th>
            </tr>
          </thead>
          <tbody>
            <?php for($i=0;$i<count($bank);$i++){?>
              <tr>
                <td><?php echo $i+1?></td>
                <td><?php echo $bank[$i]['fname'];?> <?php echo $bank[$i]['lname'];?></td>
                <td><?php echo $bank[$i]['coin'];?></td>
                <td><?php echo $bank[$i]['heart'];?></td>
                <td><?php echo $bank[$i]['price'];?></td>
                <td>
                  <?php
                    if($bank[$i]['status'] == 1)
                    {
                      echo "پرداخت شد";
                    }
                    else {
                      echo "پرداخت نشده";
                    }
                  ?>
                </td>
              </tr>
            <?php }?>
          </tbody>
        </table>
      </div>
      <div class="col-sm-2"></div>
    </div>
  </div>
  <?php $this->load->view('/inc/end.inc.php');?>
