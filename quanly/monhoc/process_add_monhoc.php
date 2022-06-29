<?php 
require '../../template/config.php';
$name = $_POST['name'];
$mysqli->query("INSERT INTO `monhoc`(`tenMH`) VALUES ('$name')");
header('location:monhoc.php');