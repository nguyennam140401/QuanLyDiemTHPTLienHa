<?php
require '../../template/config.php';
$maGV = $_POST['maGV'];
$tenGV = $_POST['tenGV'];
$ngaySinh = $_POST['ngaySinh'];
$gioiTinh = $_POST['gioiTinh'];
$diaChi = $_POST['diaChi'];

$mysqli->query("UPDATE `giaovien` SET `tenGV`='$tenGV',`ngaySinh`='$ngaySinh',`gioiTinh`='$gioiTinh',`diaChi`='$diaChi' WHERE maGV = $maGV");

header('location:giaovien.php');