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
              <th>سوال</th>
              <th>جواب ها</th>
              <th>نام کاربر</th>
            </tr>
          </thead>
          <tbody>
            <?php for($i=0;$i<count($quiz);$i++){?>
              <tr>
                <td><?php echo $i+1?></td>
                <td><?php echo $quiz[$i]['name'];?></td>
                <td>
                  <?php
                    for($j=0;$j<count($quiz[$i]['awnser']);$j++)
                    {
                      $k = $j+1;
                      echo $k." - ".$quiz[$i]['awnser'][$j]['title'];
                      if($quiz[$i]['awnser'][$j]['status'] == 1)
                      {
                        echo "<span style='color:red;'>(جواب درست)</span>";
                      }
                      echo "<br/>";
                    }
                  ?>
                </td>
                <td><?php echo $quiz[$i]['fname'];?> <?php echo $quiz[$i]['lname'];?></td>
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
