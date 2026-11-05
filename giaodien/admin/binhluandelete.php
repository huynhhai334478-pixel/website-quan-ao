<?php
    include "class/product_class.php";
    $product = new product;
    $idbinhluan = $_GET['idbinhluan'];
    $delete_binhluan = $product -> delete_binhluan($idbinhluan);
?>