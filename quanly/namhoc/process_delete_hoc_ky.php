<?php
require '../../template/config.php';
$id = $_GET['id'];
$query = $mysqli->query("DELETE FROM `hocky` WHERE maHK = '$id'");
if ($query) {
    header('location:namhoc.php');
} else {
    header('location:namhoc.php');
}
