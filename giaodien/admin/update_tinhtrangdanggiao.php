<?php
include "class/donhang_class.php";

if (isset($_GET['donhang_id'])) {
    $donhang_id = $_GET['donhang_id'];

    $donhang = new donhang();
    $result = $donhang->update_hoanthanh($donhang_id, 'Đã giao');

    if ($result) {
        echo "<script>alert('Đơn hàng đã được hoàn thành và chuyển sang trạng thái Đã giao.');
        window.location.href = 'donhang_danggiao.php';</script>";
    } else {
        echo "<script>alert('Cập nhật trạng thái thất bại.');
        window.location.href = 'donhang_danggiao.php';</script>";
    }
} else {
    echo "<script>alert('Không tìm thấy ID đơn hàng.');
    window.location.href = 'donhang_danggiao.php';</script>";
}
?>