<!doctype html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Keyvan Mozaffari">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/bootstrap-rtl.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/style.css">
    <title>Dribbl Admin Panel</title>
</head>
<body>
  <div class="container">
    <div class="row" style="margin-top:10%;">
      <div class="col-sm-4"></div>
      <div class="col-sm-4">
        <h4 style="text-align:center;">ورود به پنل مدیریت</h4>
        <?php if(@$this->session->flashdata('error') != null){?>
            <div class="alert alert-danger" role="alert">
                <strong>خطا</strong>
                <?php echo $this->session->flashdata('error');?>
            </div>
        <?php }?>
        <form action="" method="post" style="margin-top:10px;">
          <div class="form-group">
            <label for="username">نام کاربری</label>
            <input type="text" class="form-control" id="username" name="username">
          </div>
          <div class="form-group">
            <label for="pwd">رمز عبور:</label>
            <input type="password" class="form-control" id="pwd" name="password">
          </div>
        <button type="submit" class="btn btn-primary">ورود</button>
      </form>
      </div>
      <div class="col-sm-4"></div>
    </div>
  </div>
<?php $this->load->view('/inc/end.inc.php');?>
