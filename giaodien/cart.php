<?php
    include "./slider_top.php";
    include "./class/cart_class.php"; // Cập nhật để sử dụng lớp product từ product_class.php

    $cart = new cart;
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    $total_quantity = 0;
    $total_price = 0;

    if ($user_id) 
    {
        $show_cart = $cart->show_cart($user_id);
        if ($show_cart) 
        {
            while ($cart_item = $show_cart->fetch_assoc()) {
                $total_quantity += $cart_item['cart_sl']; 
                $total_price += $cart_item['product_price'] * $cart_item['cart_sl'];
            }
            $show_cart->data_seek(0);
        }
    }
     else 
    {
        echo "<script>
            alert('Vui lòng đăng nhập để xem giỏ hàng.');
            window.location.href = 'index.php'; // Chuyển hướng về index.php
        </script>";
        exit();
    }
?>

<section class="cart">
    <div class="container">
        <div class="cart-top-wrap">
            <div class="cart-top">
                <div class="cart-top-shopping cart-top-item">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
                <div class="cart-top-money cart-top-item">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <div class="cart-top-pay cart-top-item">
                    <i class="fa-solid fa-coins"></i>
                </div>
            </div>  
        </div>  
    </div>
    <div class="container">
        <div class="cart-container row">
            <div class="cart-container-left"> 
                <table>
                    <tr>
                        <th>SẢN PHẨM</th>
                        <th>TÊN SẢN PHẨM</th>
                        <th>MÃ SẢN PHẨM</th>
                        <th>SIZE</th>
                        <th>SL</th>
                        <th>THÀNH TIỀN</th>
                        <TH>XÓA</TH>
                    </tr>
                    <?php
                        if ($show_cart) {
                            while ($cart_item = $show_cart->fetch_assoc()) {
                                $imageSrc = $cart_item['product_img'];
                                if (!file_exists($imageSrc)) {
                                    $imageSrc = './giaodien/admin/class/uploads/default.jpg'; // Hình ảnh mặc định nếu không tìm thấy ảnh
                                }
                                ?>
                                <tr>
                                    <td><img src="<?php echo $imageSrc; ?>" alt="Product Image"></td>
                                    <td><p><?php echo $cart_item['product_name']; ?></p></td>
                                    <td><p><?php echo $cart_item['product_ma']; ?></p></td>
                                    <td><p><?php echo $cart_item['cart_size']; ?></p></td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <form method="POST" action="update_cart.php" class="quantity-form">
                                            <input type="hidden" name="cart_id" value="<?php echo $cart_item['cart_id']; ?>">
                                            <button type="submit" name="action" value="minus" class="qty-btn">-</button>
                                            <input type="number" name="cart_sl" value="<?php echo $cart_item['cart_sl']; ?>" min="1" max="25" class="qty-input" onchange="this.form.submit()">
                                            <button type="submit" name="action" value="plus" class="qty-btn">+</button>
                                        </form>
                                    </td>
                                    <td>
                                        <p data-price="<?php echo $cart_item['product_price']; ?>">
                                            <?php echo number_format($cart_item['product_price'] * $cart_item['cart_sl'], 0, ',', '.'); ?><sup>VNĐ</sup>
                                        </p>
                                    </td>
                                    <td>
                                        <a href="delete_cart.php?cart_id=<?php echo $cart_item['cart_id'];?>"><i class="fa-solid fa-delete-left"></i></a>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='6'>Giỏ hàng của bạn đang trống.</td></tr>";
                        }
                    ?>
                </table>
            </div>
            <div class="cart-container-right">
                <table>
                <tr>
                    <th colspan="2">TỔNG TIỀN GIỎ HÀNG</th>
                </tr>
                <tr>
                    <td>TỔNG SẢN PHẨM</td>
                    <td id="total-quantity">
                        <?php echo $total_quantity; ?>
                    </td>
                </tr>
                <tr>
                    <td>TỔNG TIỀN HÀNG</td>
                    <td id="total-price">
                        <?php echo number_format($total_price, 0, ',', '.') . '<sup>VNĐ</sup>'; ?>
                    </td>
                </tr>
                </table>
                <div class="cart-container-right-text">
                    <?php if ($total_price >= 2000000): ?>
                        <p style="color: green; font-weight: bold;">Bạn đã được miễn phí SHIP!</p>
                    <?php else: ?>
                        <p>Bạn sẽ được miễn phí ship khi đơn hàng của bạn có tổng giá trị trên 2.000.000<sup>VNĐ</sup></p>
                        <p style="color: orangered; font-weight: bold;">
                            Mua thêm <span style="font-size: 18px;">
                                <?php echo number_format(2000000 - $total_price, 0, ',', '.'); ?><sup>VNĐ</sup>
                            </span> để được miễn phí SHIP
                        </p>
                    <?php endif; ?>
                </div>
                <div class="cart-container-right-button">
                    <?php
                    // Tạo category_id ngẫu nhiên từ 1 đến 4
                    $random_category_id = rand(1, 4);
                    ?>
                    <a href="cartegory.php?category_id=<?php echo $random_category_id; ?>&user_id=<?php echo $user_id; ?>">
                        <button>TIẾP TỤC MUA SẮM</button>
                    </a>
                    <a href="delivery.php?user_id=<?php echo $user_id; ?>">
                        <button>THANH TOÁN</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
    include "./slider_bot.php";
?>
