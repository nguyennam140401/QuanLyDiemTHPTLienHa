<?php
session_start();
$expires = time() - 60 * 60 * 24 * 365;
setcookie("username", '', $expires, "/");
setcookie("token", '', $expires, "/");
session_destroy();

header('Location: /QuanLyDiemTHPT');