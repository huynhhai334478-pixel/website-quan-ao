<?php
include "class/donhang_class.php";

if (isset($_GET['donhang_id'])) {
    $donhang_id = $_GET['donhang_id'];

    $donhang = new donhang();
    $result = $donhang->update_Danggiao($donhang_id, 'Đang giao');

    if ($result) {
        echo "<script>alert('Đơn hàng đã được duyệt và chuyển sang trạng thái Đang giao.');
        window.location.href = 'donhang_choduyet.php';</script>";
    } else {
        echo "<script>alert('Cập nhật trạng thái thất bại.');
        window.location.href = 'donhang_choduyet.php';</script>";
    }
} else {
    echo "<script>alert('Không tìm thấy ID đơn hàng.');
    window.location.href = 'donhang_choduyet.php';</script>";
}
?>