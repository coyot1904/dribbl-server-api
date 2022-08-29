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
        <em>درلحظه هیچ زمانی بیش از یک سوال را باز نگذارید اپ بسته خواهد شد</em>
        <table class="table table-striped" style="margin-top:20px;">
          <thead>
            <tr>
              <th>#</th>
              <th>مرحله</th>
              <th>وضعیت</th>
              <th>وضیت نمایش جواب سوال</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php for($i=0;$i<count($live);$i++){?>
              <tr>
                <td><?php echo $i+1?></td>
                <td><?php echo $live[$i]['level'];?></td>
                <td>
                  <?php
                    if($live[$i]['status'] == 1)
                    {
                      echo "باز";
                    }
                    else {
                      echo "بسته";
                    }
                  ?>
                </td>
                <td>
                  <?php
                    if($live[$i]['show'] == 1)
                    {
                      echo "باز";
                    }
                    else {
                      echo "بسته";
                    }
                  ?>
                </td>
                <td>
                  <a href="<?php echo base_url()?>admin/change_live_status/<?php echo $live[$i]['id'];?>">تغییر وضعیت سوال</a>
                  <a href="<?php echo base_url()?>admin/change_live_aw/<?php echo $live[$i]['id'];?>">تغییر وضعیت جواب</a>
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
