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
              <th>شماره سوال</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php for($i=1;$i<26;$i++){?>
              <tr>
                <td><?php echo $i+1?></td>
                <td>شماره سوال <?php echo $i;?></td>
                <td>
                  <a href="<?php echo base_url()?>admin/edit_live/<?php echo $i;?>">ویرایش</a>
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
