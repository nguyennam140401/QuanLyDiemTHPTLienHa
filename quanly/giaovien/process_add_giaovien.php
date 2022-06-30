<?php
require '../../template/config.php';
$tenGV = $_POST['tenGV'];
$ngaySinh = $_POST['ngaySinh'];
$gioiTinh = $_POST['gioiTinh'];
$diaChi = $_POST['diaChi'];

$mysqli->query("INSERT INTO `giaovien`(`tenGV`, `ngaySinh`, `gioiTinh`, `diaChi`) VALUES ('$tenGV','$ngaySinh','$gioiTinh','$diaChi')");

header('location:giaovien.php');