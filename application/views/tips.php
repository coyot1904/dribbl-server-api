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
        <a href="<?php echo base_url();?>admin/new_tips" style="color:green;">افزودن جدید</a>
        <table class="table table-striped" style="margin-top:20px;">
          <thead>
            <tr>
              <th>#</th>
              <th>متن</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php for($i=0;$i<count($tips);$i++){?>
              <tr>
                <td><?php echo $i+1?></td>
                <td><?php echo $tips[$i]['text'];?></td>
                <td>
                  <a href="<?php echo base_url()?>admin/delete_tips/<?php echo $tips[$i]['id'];?>">حذف</a>
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
