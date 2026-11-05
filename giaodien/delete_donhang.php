<?php
include "./class/donhang_class.php";
include "./admin/database.php";

   $donhang = new donhang();
    $donhang_id = $_GET['donhang_id'];

    $thoigian = $donhang->getOrderTime($donhang_id);

    if ($thoigian) {
        $order_time = strtotime($thoigian);
        $now = time();
        if (($now - $order_time) < 86400) {
            echo "<script>alert('Đơn hàng chưa vượt quá 1 ngày, không thể xóa!');window.history.back();</script>";
            exit();
        } else {
            $delete_donhang = $donhang->delete_donhang($donhang_id);
            echo "<script>alert('Xóa đơn hàng thành công!');window.location.href='donhang.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Không tìm thấy đơn hàng!');window.history.back();</script>";
        exit();
    }
?>