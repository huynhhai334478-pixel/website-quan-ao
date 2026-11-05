<?php
    include "class/voucher_class.php";
    $voucher = new voucher;
    $idvoucher = $_GET['idvoucher'];
    $delete_voucher = $voucher -> delete_voucher($idvoucher);
?>
