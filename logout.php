<?php
session_start();
$expires = time() - 60*60*24*365;
setcookie("username" , '' , $expires,"/QuanLyDiemTHPT");
setcookie("token" , '', $expires,"/QuanLyDiemTHPT");
session_destroy();

header('Location: /');
