<?php 
require '../../template/config.php';
$namHoc = $_POST['namHoc'];
$mysqli->query("INSERT INTO `namhoc`(`namHoc`) VALUES ('$namHoc')");
header('location:namhoc.php');