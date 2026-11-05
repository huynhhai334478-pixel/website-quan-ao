<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    // Chưa đăng nhập
    header("Location: http://127.0.0.1/DEMO/giaodien/index.php?error=not_logged_in");
    exit();
} elseif (!isset($_SESSION['user_quyen']) || $_SESSION['user_quyen'] != 'Admin') {
    // Đã đăng nhập nhưng không phải admin
    header("Location: http://127.0.0.1/DEMO/giaodien/index.php?error=not_admin");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="adminstyle.css?<?php echo time(); ?>">
    <script
    src="https://code.jquery.com/jquery-3.7.1.js"
    integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/0673e6ca43.js" crossorigin="anonymous"></script>
    <title>Danh mục sản phẩm</title>
</head>
<body>
    <header>
        <h1><a href="admin.php">Trang chủ admin</a></h1>
    </header>



