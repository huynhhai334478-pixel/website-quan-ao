<?php
include "class/donhang_class.php";
include "./admin/database.php";

if (isset($_GET['donhang_id'])) {
    $donhang_id = $_GET['donhang_id'];

    $donhang = new donhang();
    $result = $donhang->danhan_donhang($donhang_id, 'Hoàn thành');

    if ($result) {
        echo "<script>alert('Đơn hàng đã nhân.');
        window.location.href = 'donhang.php';</script>";
    } else {
        echo "<script>alert('Cập nhật trạng thái thất bại.');
        window.location.href = 'donhang.php';</script>";
    }
} else {
    echo "<script>alert('Không tìm thấy ID đơn hàng.');
    window.location.href = 'donhang.php';</script>";
}
?>