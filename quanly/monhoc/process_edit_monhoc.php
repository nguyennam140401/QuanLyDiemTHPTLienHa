<?php
require '../../template/config.php';
$id = $_POST['id'];
$name = $_POST['name'];
$mysqli->query("UPDATE `monhoc` SET `tenMH`='$name' WHERE maMH = $id");
header("location:monhoc.php");