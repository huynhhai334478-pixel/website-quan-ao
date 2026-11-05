<?php
    include "./slider_top.php";
    include "./class/cart_class.php";
    include "./class/product_class.php";
    include "./class/voucher_class.php";
    include "./class/donhang_class.php";
?>
<?php
    $cart = new cart;
    $voucher = new voucher;
    $product = new product;
    $show_voucher = $voucher ->show_voucher();
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    $total_quantity = 0;
    $total_price = 0;
    $vat = 0.1;

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
        $vat_amount = $total_price * $vat;
        $grand_total = $total_price + $vat_amount;
    }
     else 
    {
        echo "<script>
            alert('Vui lòng đăng nhập để xem đơn hàng.');
            window.location.href = 'index.php'; // Chuyển hướng về index.php
        </script>";
        exit();
    }

    // $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : null;
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
        $hoten = isset($_POST['hoten']) ? $_POST['hoten'] : '';
        $sdt = isset($_POST['sdt']) ? $_POST['sdt'] : '';
        $tinh_tp = isset($_POST['tinh_tp']) ? $_POST['tinh_tp'] : '';
        $quan_huyen = isset($_POST['quan_huyen']) ? $_POST['quan_huyen'] : '';
        $diachi = isset($_POST['diachi']) ? $_POST['diachi'] : '';
        $sotien = isset($_POST['final_total']) ? intval($_POST['final_total']) : $grand_total;
        $thoigian = date('Y-m-d');
    
        // Thực hiện thêm đơn hàng vào cơ sở dữ liệu
        $donhang = new donhang;
        $insert_donhang = $donhang->insert_donhang($user_id, $hoten, $sdt, $tinh_tp, $quan_huyen, $diachi, $sotien, $thoigian);
    
        if ($insert_donhang) {
            if ($show_cart) {
                $idvoucher = !empty($_POST['idvoucher']) ? intval($_POST['idvoucher']) : 0;

                while ($cart_item = $show_cart->fetch_assoc()) {
                    $product_ma = $cart_item['product_ma'];
                    $product_name = $cart_item['product_name'];
                    $cart_size = $cart_item['cart_size'];
                    $soluong = $cart_item['cart_sl'];

                    // Gọi hàm đã thêm idvoucher
                    $donhang->insert_chitietdonhang($insert_donhang, $product_ma, $product_name, $cart_size, $soluong, $idvoucher);
                }

                $show_cart->data_seek(0);
            }
        }


    // Kiểm tra tồn kho trước
    if ($show_cart) {
        while ($cart_item = $show_cart->fetch_assoc()) {
            $product_ma = $cart_item['product_ma'];
            $soluong = $cart_item['cart_sl'];

            $available_qty = $product->getProductQuantity($product_ma);
            if ($available_qty < $soluong) {
                echo "<script>alert('Đặt hàng thất bại! Số lượng sản phẩm \"{$cart_item['product_name']}\" không đủ. Vui lòng giảm số lượng hoặc chọn sản phẩm khác.'); 
                      window.history.back();
                      </script>";
                exit();
            }
        }
        $show_cart->data_seek(0);
    }

    // Nếu đủ thì cập nhật số lượng
    if ($show_cart) {
        while ($cart_item = $show_cart->fetch_assoc()) {
            $product_ma = $cart_item['product_ma'];
            $soluong = $cart_item['cart_sl'];

            $updated = $product->updateProductAfterOrder($product_ma, $soluong);
            if (!$updated) {
                echo "<script>alert('Lỗi cập nhật sản phẩm: $product_ma');</script>";
            }
        }
        $show_cart->data_seek(0);
    }

    // Xử lý voucher
    if (!empty($_POST['idvoucher'])) {
        $idvoucher = intval($_POST['idvoucher']);
        $used = $voucher->useVoucher($idvoucher);

        if (!$used) {
            echo "<script>alert('Voucher đã hết hoặc không hợp lệ. Đơn hàng vẫn được xử lý không áp dụng mã giảm giá.');</script>";
        }
    }

    $cart->delete_cart_by_user($user_id);

    echo "<script>alert('Đặt hàng thành công!');
    window.location.href = 'donhang.php';
    </script>";
    exit();
}
?>
<!-- delivery---------------------------------------------------------------------------- -->
<section class="delivery">
    <div class="container">
        <div class="delivery-top-wrap">
            <div class="delivery-top">
                <div class="delivery-top-shopping delivery-top-item">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
                <div class="delivery-top-money delivery-top-item">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <div class="delivery-top-pay delivery-top-item">
                    <i class="fa-solid fa-coins"></i>
                </div>
            </div>  
        </div>  
    </div>
    <div class="container">
        <div class="delivery-content row">
            <div class="delivery-content-left">
                <div class="voucher-wrapper">
                    <label for="voucher-select">🎁 Chọn mã giảm giá:</label>
                    <select name="idvoucher" id="voucher-select" class="styled-select">
                        <option value="" data-discount="0" data-type="">-- Không sử dụng mã --</option>
                        <?php
                        if($show_voucher) {
                            while($result = $show_voucher->fetch_assoc()) {
                        ?>
                        <option 
                            value="<?php echo $result['idvoucher']; ?>" 
                            data-discount="<?php echo $result['giagiam']; ?>" 
                            data-type="<?php echo $result['loaigiam']; ?>"
                        >
                            <?php echo $result['tenvoucher']; ?> - Giảm 
                            <?php 
                                echo ($result['loaigiam'] === 'phantram') 
                                    ? $result['giagiam'] . '%' 
                                    : number_format($result['giagiam'], 0, ',', '.') . 'đ'; 
                            ?>
                        </option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                </div>
                <p>Vui lòng chọn địa chỉ giao hàng</p>
                <form method="POST" action="">
                <input type="hidden" name="final_total" id="final-total-value" value="<?php echo $grand_total; ?>">
                <input type="hidden" name="idvoucher" id="idvoucher-value" value="">
                    <div class="delivery-content-left-input-top row">
                        <div class="delivery-content-left-input-top-item">
                            <label for="">Họ tên<span style="color: orangered;">*</span></label>
                            <input type="text" name="hoten" required>
                        </div>
                        <div class="delivery-content-left-input-top-item">
                            <label for="">Điện thoại<span style="color: orangered;">*</span></label>
                            <input type="text" name="sdt" required>
                        </div>
                        <div class="delivery-content-left-input-top-item">
                            <label for="">Tỉnh/Tp<span style="color: orangered;">*</span></label>
                            <input type="text" name="tinh_tp" required>
                        </div>
                        <div class="delivery-content-left-input-top-item">
                            <label for="">Quận/Huyện<span style="color: orangered;">*</span></label>
                            <input type="text" name="quan_huyen" required>
                        </div>
                    </div>
                    <div class="delivery-content-left-input-bottom">
                        <div class="delivery-content-left-input-bottom-item">
                            <label for="">Địa Chỉ<span style="color: orangered;">*</span></label>
                            <input type="text" name="diachi" required>
                        </div>
                    </div>
                    <div class="delivery-content-left-button row">
                        <a href="cart.php"><span>&#171;</span><p>Quay lại giỏ hàng</p></a>
                        <button type="submit" name="submit"><p style="font-weight: bold;">THANH TOÁN VÀ GIAO HÀNG</p></button>
                    </div>
                </form>
            </div>
            <div class="delivery-content-right">
            <table>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>MÃ sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
                <?php
                $vat = 0.1; // Thuế VAT 10%
                $total_price = 0;

                if ($show_cart) {
                    while ($cart_item = $show_cart->fetch_assoc()) {
                        $item_total = $cart_item['product_price'] * $cart_item['cart_sl']; // Thành tiền từng sản phẩm
                        $total_price += $item_total; // Cộng dồn tổng tiền
                        ?>
                        <tr>
                            <td><?php echo $cart_item['product_name']; ?></td>
                            <td><?php echo $cart_item['product_ma']; ?></td>
                            <td><?php echo $cart_item['cart_sl']; ?></td>
                            <td><p><?php echo number_format($item_total, 0, ',', '.'); ?><sup>VNĐ</sup></p></td>
                        </tr>
                        <?php
                    }
                }
                $vat_amount = $total_price * $vat; // Tính thuế VAT
                $grand_total = $total_price + $vat_amount; // Tổng tiền hàng sau thuế
                ?>
                <tr>
                    <td style="font-weight: bold; border-top: 2px solid #dddddd;" colspan="3">Tổng</td>
                    <td style="font-weight: bold; border-top: 2px solid #dddddd;">
                        <p><?php echo number_format($total_price, 0, ',', '.'); ?><sup>VNĐ</sup></p>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;" colspan="3">Thuế VAT</td>
                    <td style="font-weight: bold;">
                        <p><?php echo number_format($vat_amount, 0, ',', '.'); ?><sup>VNĐ</sup></p>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;" colspan="3">Tổng tiền hàng</td>
                    <td style="font-weight: bold;">
                        <p><?php echo number_format($grand_total, 0, ',', '.'); ?><sup>VNĐ</sup></p>
                        <input type="hidden" id="grand-total-value" value="<?php echo $grand_total; ?>">
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;" colspan="3">Giảm giá (Voucher)</td>
                    <td style="font-weight: bold;">
                        <p id="discount-amount">0<sup>VNĐ</sup></p>
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold;" colspan="3">Tổng sau giảm</td>
                    <td style="font-weight: bold;">
                        <p id="final-total"><?php echo number_format($grand_total, 0, ',', '.'); ?><sup>VNĐ</sup></p>
                    </td>
                </tr>
            </table>
            </div>
        </div>
    </div>
</section>
<?php
    include "./slider_bot.php";
?>