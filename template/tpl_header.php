<?php
session_start();
ob_start();
require 'config.php';

$taikhoan = array();

if (!isset($_SESSION['username']) && !isset($_SESSION['password']) && isset($_COOKIE['username']) && isset($_COOKIE['token'])) {

    $result = $mysqli->query('SELECT * FROM `taikhoan` WHERE `username`=\'' . htmlspecialchars($_COOKIE['username']) . '\' AND MD5(`password`)=\'' . htmlspecialchars($_COOKIE['token']) . '\';');

    if ($result->num_rows > 0) {
        $taikhoan = $result->fetch_array(MYSQLI_ASSOC);
        $_SESSION['username'] = $taikhoan['username'];
        $_SESSION['password'] = $taikhoan['password'];
    } else {
        setcookie('username', '', time() - (365 * 30 * 86400), "/");
        setcookie('token', '', time() - (365 * 30 * 86400), "/");
        session_destroy();
    }
}
if ((isset($_SESSION['username'])) && (isset($_SESSION['password']))) {
    $result = $mysqli->query('SELECT * FROM `taikhoan` WHERE `username`=\'' . htmlspecialchars($_SESSION['username']) . '\' AND `password`=\'' . htmlspecialchars($_SESSION['password']) . '\';');

    if ($result->num_rows > 0) {
        $taikhoan = $result->fetch_array(MYSQLI_ASSOC);
    } else {
        setcookie('username', '', time() - (365 * 30 * 86400), "/");
        setcookie('token', '', time() - (365 * 30 * 86400), "/");
        session_destroy();
        echo '<script>alert("Token hết hạn, vui lòng đăng nhập lại!");</script>';
        header('Location: /QuanLyDiemTHPT/login.php');
        die();
    }
} else {
    header('Location: /QuanLyDiemTHPT/login.php');
    die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Hệ thống quản lý điểm trường THPT Liên Hà</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="vuiz.net">
    <meta property="og:title" content="Hệ thống quản lý điểm trường THPT Liên Hà" />
    <meta property="og:image" content="/assets/images/logo.png" />
    <meta property="og:site_name" content="THPTLH" />
    <meta property="og:description" content="Hệ thống quản lý điểm trường THPT Liên Hà" />

    <!-- Favicon -->
    <link href="/assets/images/logo.png" rel="icon" type="image/png">
    <link href="/assets/images/logo.png" rel="shortcut icon" type="image/png">


    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css"
        integrity="sha512-mxrUXSjrxl8vm5GwafxcqTrEwO1/oBNU25l20GODsysHReZo4uhVISzAKzaABH6/tTfAxZrY2FprmeAP5UZY8A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css"
        integrity="sha512-8vq2g5nHE062j3xor4XxPeZiPjmRDh6wlufQlfC6pdQ/9urJkU07NM0tEREeymP++NczacJ/Q59ul+/K2eYvcg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="/QuanLyDiemTHPT/assets/images/logo.png" alt="VNEDU" height="120"
                width="120">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/QuanLyDiemTHPT/logout.php" role="button">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.navbar -->



        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="/QuanLyDiemTHPT" class="brand-link">
                <img src="/QuanLyDiemTHPT/assets/images/logo.png" alt="VNEDU" class="brand-image" style="opacity: .8">
                <span class="brand-text font-weight-light">THPTLH</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="/QuanLyDiemTHPT/" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Hệ thống
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <?php if (in_array($taikhoan['role'], array('admin', 'manager'))) : ?>
                                <li class="nav-item">
                                    <a href="/QuanLyDiemTHPT/system/quanlytaikhoan.php" class="nav-link">
                                        <i class="fas fa-chevron-right nav-icon"></i>
                                        <p>Quản lý tài khoản</p>
                                    </a>
                                </li>
                                <?php endif; ?>
                                <li class="nav-item">
                                    <a href="/QuanLyDiemTHPT/system/thongtintaikhoan.php" class="nav-link">
                                        <i class="fas fa-chevron-right nav-icon"></i>
                                        <p>Thông tin tài khoản</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php if (in_array($taikhoan['role'], array('admin', 'manager', 'teacher'))) : ?>
                        <li class="nav-item">
                            <a href="/QuanLyDiemTHPT/quanly/hocsinh.php" class="nav-link">
                                <i class="nav-icon fas fa-user-graduate"></i>
                                <p>
                                    Quản lý học sinh
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/QuanLyDiemTHPT/quanly/diem.php" class="nav-link">
                                <i class="nav-icon fas fa-file-contract"></i>
                                <p>
                                    Quản lý điểm
                                </p>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if (in_array($taikhoan['role'], array('admin', 'manager'))) : ?>
                        <li class="nav-item">
                            <a href="/QuanLyDiemTHPT/quanly/giaovien.php" class="nav-link">
                                <i class="nav-icon fas fa-user-tie"></i>
                                <p>
                                    Quản lý giáo viên
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/QuanLyDiemTHPT/quanly/monhoc.php" class="nav-link">
                                <i class="nav-icon fas fa-award"></i>
                                <p>
                                    Quản lý môn học
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-calendar-alt"></i>
                                <p>
                                    Quản lý lớp - học kỳ
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/QuanLyDiemTHPT/quanly/lophoc.php" class="nav-link">
                                        <i class="fas fa-chevron-right nav-icon"></i>
                                        <p>Quản lý lớp học</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/QuanLyDiemTHPT/quanly/namhoc.php" class="nav-link">
                                        <i class="fas fa-chevron-right nav-icon"></i>
                                        <p>Học kỳ - Khối lớp - Năm học</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="/QuanLyDiemTHPT/quanly/phanconggv.php" class="nav-link">
                                <i class="nav-icon fas fa-file-contract"></i>
                                <p>
                                    Phân công công việc
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-chart-bar"></i>
                                <p>
                                    Thống kê
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/QuanLyDiemTHPT/thongke/thongkesiso.php" class="nav-link">
                                        <i class="fas fa-chevron-right nav-icon"></i>
                                        <p>Thống kê sĩ số lớp</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/QuanLyDiemTHPT/thongke/thongkediem.php" class="nav-link">
                                        <i class="fas fa-chevron-right nav-icon"></i>
                                        <p>Thống kê điểm học sinh</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-search"></i>
                                <p>
                                    Tra cứu
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/QuanLyDiemTHPT/tracuu/lophoc.php" class="nav-link">
                                        <i class="fas fa-chevron-right nav-icon"></i>
                                        <p>Tra cứu lớp học</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="/QuanLyDiemTHPT/tracuu/diem.php" class="nav-link">
                                        <i class="fas fa-chevron-right nav-icon"></i>
                                        <p>Tra cứu điểm</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
    </aside>