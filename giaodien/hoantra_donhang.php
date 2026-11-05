<?php
include "class/donhang_class.php";
include "./admin/database.php";

if (isset($_GET['donhang_id'])) {
    $donhang_id = $_GET['donhang_id'];
    $donhang = new donhang();
    $result = $donhang->hoan_donhang($donhang_id);

    if ($result === true) {
        echo "<script>alert('Hoàn đơn hàng thành công!');
        window.location.href='donhang.php';</script>";
    } elseif (is_string($result)) {
        echo "<script>alert('$result');
        window.location.href='donhang.php';</script>";
    } else {
        echo "<script>alert('Có lỗi xảy ra khi hoàn đơn.');
        window.location.href='donhang.php';</script>";
    }
} else {
    echo "<script>alert('Không tìm thấy ID đơn hàng.');
    window.location.href='donhang.php';</script>";
}
?>
