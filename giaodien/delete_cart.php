<?php
include "./class/cart_class.php";
include "./admin/database.php";

    $cart = new cart();
    $cart_id = $_GET['cart_id'];
    $delete_cart = $cart -> delete_cart($cart_id);
?>