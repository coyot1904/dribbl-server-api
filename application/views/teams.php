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
        <a href="<?php echo base_url();?>admin/add_team" style="color:green;">افزودن تیم جدید</a>
        <table class="table table-striped" style="margin-top:20px;">
          <thead>
            <tr>
              <th>#</th>
              <th>عکس تیم</th>
              <th>نام لیگ</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php for($i=0;$i<count($teams);$i++){?>
              <tr>
                <td><?php echo $i+1?></td>
                <td><img src="<?php echo base_url()?>assets/teams/<?php echo $teams[$i]['image'];?>" width="32" height="32"/></td>
                <td><?php echo $teams[$i]['name'];?></td>
                <td>
                  <a href="<?php echo base_url()?>admin/delete_teams/<?php echo $teams[$i]['id'];?>" style="color:red;">حذف</a>
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
