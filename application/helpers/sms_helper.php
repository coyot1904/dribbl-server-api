<?php
  function sendSms($text , $number)
  {
    $ch = curl_init();
    $username = "c.09128146925";
    $password = "534646";
    $url = "https://dribbl.app/sms/sms.php?number=".$number."&message=".$text;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_exec($ch);
    curl_close($ch);
  }
?>
