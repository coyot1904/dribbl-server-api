<nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
  <!-- Links -->
  <ul class="navbar-nav active">
    <li class="nav-item">
      <a class="nav-link" href="<?php echo base_url()?>admin/dashboard" style="color:#FFF;">خانه</a>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle"  data-toggle="dropdown" href="javascript:void(0)" style="color:#FFF;">سوالات <span class="caret"></span></a>
      <ul class="dropdown-menu">
        <li><a href="<?php echo base_url()?>admin/category">دسته بندی سوالات</a></li>
        <li><a href="<?php echo base_url()?>admin/quiz">سوالات</a></li>
        <li><a href="<?php echo base_url()?>admin/live">سوالات لایو استریم</a></li>
        <li><a href="<?php echo base_url()?>admin/think_quiz">سوالات بازی تکنفره</a></li>
      </ul>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo base_url()?>admin/users" style="color:#FFF;">کاربران</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo base_url()?>admin/user_quiz" style="color:#FFF;">سوالات ارسال کاربران</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo base_url()?>admin/statictics" style="color:#FFF;">آمار</a>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle"  data-toggle="dropdown" href="javascript:void(0)" style="color:#FFF;">بانک<span class="caret"></span></a>
      <ul class="dropdown-menu">
        <li><a href="<?php echo base_url()?>admin/bank">پرداخت شده ها</a></li>
        <li><a href="<?php echo base_url()?>admin/bankover">پرداخت نشده ها</a></li>
      </ul>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle"  data-toggle="dropdown" href="javascript:void(0)" style="color:#FFF;">لایو<span class="caret"></span></a>
      <ul class="dropdown-menu">
        <li><a href="<?php echo base_url()?>admin/live_status">وضعیت سوالات لایو</a></li>
        <li><a href="<?php echo base_url()?>admin/live_score">جدول امتیازات لایو</a></li>
        <li><a href="<?php echo base_url()?>admin/live_time">زمان شروع بازی لایو</a></li>
        <li><a href="<?php echo base_url()?>admin/live_ask">جدول سوالات لایو</a></li>
      </ul>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo base_url()?>admin/support" style="color:#FFF;">پیام پشتیبانی</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo base_url()?>admin/report" style="color:#FFF;">گزارش خطا</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo base_url()?>admin/wallet" style="color:#FFF;">کیف پول</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="<?php echo base_url()?>admin/tips" style="color:#FFF;">Tips</a>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle"  data-toggle="dropdown" href="javascript:void(0)" style="color:#FFF;">تیم ها<span class="caret"></span></a>
      <ul class="dropdown-menu">
        <li><a href="<?php echo base_url()?>admin/leauge">لیگ ها</a></li>
        <li><a href="<?php echo base_url()?>admin/teams">تیم ها</a></li>
      </ul>
    </li>
  </ul>
</nav>
