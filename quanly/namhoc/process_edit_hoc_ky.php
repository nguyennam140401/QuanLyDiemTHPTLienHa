<?php
require '../../template/config.php';
$id = $_POST['maHK'];
$tenHK = $_POST['tenHK'];
$mysqli->query("UPDATE `hocky` SET `tenHK`='$tenHK' WHERE maHK = $id");
header("location:namHoc.php");