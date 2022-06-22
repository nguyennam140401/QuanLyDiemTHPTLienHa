# HƯỚNG DẪN SỬ DỤNG

### Mục lục

[I. Mở đầu](#begin)

[II. Cài đặt](#install)

- [1. Yêu cầu](#requirements)
- [2. Cấu trúc](#requirements)
- [3. Kết nối CSDL](#connectdb)
- [4. Chạy chương trình](#run)

[III. Sử dụng](#usage)

- [1. Đăng nhập](#login)
- [2. Giới thiệu chức năng](#functions)

[Câu hỏi thường gặp](#faq)

===========================

<a name="begin"></a>

## Mở đầu

`Hệ thống quản lý điểm THPT Liên Hà` là sản phẩm bài tập lớn học phần Lập trình lập trình web PHP - HAUI.

<a name="instal"></a>

## Cài đặt

<a name="requirements"></a>

### Yêu cầu

- Apache
- PHP 7 trở lên (7.4 is recomended)
- MySQL 5 trở lên
- MySQL Native Driver để kết nối CSDL

<p align="center"><a href="https://ibb.co/Gn2SwcR"><img width="400px" src="https://i.ibb.co/jbMXKgD/image.png" alt="image" border="0" /></a></p>

<a name="libraries"></a>

### Cấu trúc

- Front-end: Adminlte 3.1, Bootstrap 4, Datatables, Jquery 3.6.0, HTML5, CSS, JavaScript.
- Back-end: PHP + MySQL.

```bash
├── ajax (chứa api gọi ajax)
│   ├── login
│   ├── quanly
│   ├── system
│   ├── thongke
│   ├── tracuu
├── assets (chứa các file css ảnh javascript)
│   ├── css
│   ├── images
│   ├── js
├── plugin (chứa các thư viện PHP)
├── system
├── quanly
├── thongke
├── tracuu
├── template (chứa file config, header và footer)
```

<a name=connectdb></a>

### Kết nối CSDL

- Mở **phpMyAdmin** tạo một database: _vnedu_
- Chạy hay import file _vnedu.sql_
- Upload code lên hosting hoặc localhost **(Chú ý: file index của project phải nằm trong thư mục máy chủ gốc /public_html, /www hoặc /htdocs, không để project trong thư mục!)**
- Mở file `template/config.php` và sửa lại `hostname`, `dbuser`, `dbpass`, `dbname` cho phù hợp.

<a name="run"></a>

### Chạy chương trình

- Đảm bảo mọi file của project không nằm trong bất kỳ thư mục nào trong thư mục máy chủ gốc.
- Tạo một virtual domain (trên localhost) hoặc subdomain (hosting) nếu bạn muốn để project trong một thư mục khác thư mục máy chủ gốc.
- Chạy **localhost** hoặc **domain** chứa project.

<a name="usage"></a>

## Sử dụng

<a name="login"></a>

### Đăng nhập

<p align="center"><a href="https://ibb.co/qnWR53p"><img width="300px" src="https://i.ibb.co/cvCNLSQ/image.png" alt="image" border="0" /></a></p>

Trước khi truy cập vào hệ thống, bắt buộc người dùng phải đăng nhập với tài khoản được cấp phép.

Mội số tài khoản mặc định:

| Tài khoản | Mật khẩu | Quyền   |
| --------- | -------- | ------- |
| admin     | admin    | admin   |
| quanly    | quanly   | manager |
| giaovien  | giaovien | teacher |
| hocsinh   | hocsinh  | student |

<a name="functions"></a>

### Giới thiệu chức năng

Click vào ảnh để xem chi tiết.

<p align="center"><a href="https://ibb.co/PxpLGM3"><img src="https://i.ibb.co/H7vSTC1/image.png" alt="image" border="0" /></a></p>

<a name="faq"></a>

## Câu hỏi thường gặp

**Lỗi ABC**
