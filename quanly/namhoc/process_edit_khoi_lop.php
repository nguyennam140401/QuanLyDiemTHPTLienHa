<?php
require '../../template/config.php';
$id = $_POST['maKhoiLop'];
$tenKL = $_POST['tenKhoiLop'];
$mysqli->query("UPDATE `khoilop` SET `tenKhoiLop`='$tenKL' WHERE maKhoiLop = $id");
header("location:namHoc.php");