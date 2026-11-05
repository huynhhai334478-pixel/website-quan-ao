<?php
include "class/donhang_class.php";
include "./admin/database.php";

if (isset($_GET['donhang_id'])) {
    $donhang_id = $_GET['donhang_id'];
    $donhang = new donhang();

    $result = $donhang->huy_donhang($donhang_id);

    if ($result) {
        echo "<script>alert('Đơn hàng đã được hủy và hàng đã được hoàn trả về kho.');
        window.location.href = 'donhang.php';</script>";
    } else {
        echo "<script>alert('Hủy đơn hàng thất bại.');
        window.location.href = 'donhang.php';</script>";
    }
} else {
    echo "<script>alert('Không tìm thấy ID đơn hàng.');
    window.location.href = 'donhang.php';</script>";
}
?>
