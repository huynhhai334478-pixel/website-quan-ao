<?php
include "./class/cart_class.php";
include "./admin/database.php";
    $cart = new cart;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $cart_id = isset($_POST['cart_id']) ? intval($_POST['cart_id']) : 0;
        $cart_sl = isset($_POST['cart_sl']) ? intval($_POST['cart_sl']) : 1;

        // Nếu bấm nút thì $_POST['action'] sẽ tồn tại, nếu chỉ Enter thì không
        if (isset($_POST['action'])) {
            $action = $_POST['action'];
            if ($action === 'plus') {
                $cart_sl++;
            } elseif ($action === 'minus' && $cart_sl > 1) {
                $cart_sl--;
            }
        }
        // Nếu không có action thì giữ nguyên cart_sl (người dùng chỉnh trực tiếp)
        if ($cart_id > 0) {
            $cart->update_cart_quantity($cart_id, $cart_sl);
        }
    }
header("Location: cart.php");
exit();
?>