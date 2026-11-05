<?php
    include "./slider_top.php";
    include "./class/donhang_class.php";

    
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    if (!isset($_GET['donhang_id'])) {
    echo "Không có đơn hàng nào được chọn.";
    exit();
    }
    $donhang_id = $_GET['donhang_id'];
    $donhang = new donhang;
    $chitiet_donhang = $donhang->show_chitietdonhang($donhang_id);
?>
<section class="donhang">
    <div class="container">
        <div class="donhang-top-wrap">
            <div class="donhang-top">
                <div class="donhang-top-shopping delivery-top-item">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
                <div class="donhang-top-money delivery-top-item">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <div class="donhang-top-pay delivery-top-item">
                    <i class="fa-solid fa-coins"></i>
                </div>
            </div>  
        </div>  
    </div>
    <div class="container">
        <div class="donhang-container row">
            <table>
                    <tr>
                        <th>ID đơn hàng</th>
                        <th>Tên sản phẩm</th>
                        <th>Mã sản phẩm</th>
                        <th>SIZE</th>
                        <th>Số lượng</th>
                    </tr>
                    <tr>
                    <?php
                        if ($chitiet_donhang) {
                            while ($result = $chitiet_donhang->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?php echo $result['donhang_id']; ?></td>
                                    <td><?php echo $result['product_name']; ?></td>
                                    <td><?php echo $result['product_ma']; ?></td>
                                    <td><?php echo $result['cart_size']; ?></td>
                                    <td><?php echo $result['product_soluong']; ?></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
            </table>
        </div>
        <div class="back-to-orders">
            <a href="donhang.php" class="btn-back">Trở lại danh sách đơn hàng</a>    
         </div>
    </div>
<?php
    include "./slider_bot.php";
?>