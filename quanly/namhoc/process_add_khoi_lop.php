<?php
require '../../template/config.php';
$tenKhoiLop = $_POST['tenKhoiLop'];
$mysqli->query("INSERT INTO `khoilop`(`tenKhoiLop`) VALUES ('$tenKhoiLop')");
header('location:namhoc.php');