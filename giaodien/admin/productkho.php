<?php
    include "header.php";
    include "slider.php";
    include "class/product_class.php";
?>
<?php
    $product = new product;
    $show_product = $product ->show_productkho();
    $low_stock_products = [];
        if ($show_product) {
            while($row = $show_product->fetch_assoc()) {
                if ($row['product_soluong'] <= 10) {
                    $low_stock_products[] = $row;
                }
                $all_products[] = $row; // lưu lại tất cả sản phẩm để dùng tiếp
            }
        }

    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_add'])) {
    $product_id = $_POST['product_id'];
    $soluong_them = $_POST['soluong_them'];

    if (is_numeric($soluong_them) && $soluong_them > 0) {
        $product->update_soluong($product_id, $soluong_them);
        echo "<script>window.location.href = window.location.href;</script>";
    } else {
        echo "<script>alert('Số lượng phải là số lớn hơn 0!');</script>";
    }
}

?>



<div class="admin-content-right">
            <div class="admin-content-right-category_list">
            <?php if (!empty($low_stock_products)) { ?>
                <h2 style="color: red;">Sản phẩm sắp hết hàng (≤ 10)</h2>
                    <table>
                        <tr>
                            <th>Stt</th>
                            <th>ID</th>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Đã bán</th>
                            <th>Thêm số lượng</th>
                            <th>Tùy biến</th>
                        </tr>
                        <?php
                        $i = 0;
                        foreach ($low_stock_products as $product_row) {
                            $i++;
                        ?>
                        <form method="post" action="">
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $product_row['product_id']; ?></td>
                            <td><?php echo $product_row['product_name']; ?></td>
                            <td><?php echo $product_row['product_soluong']; ?></td>
                            <td><?php echo $product_row['product_daban']; ?></td>
                            <td><input type="number" name="soluong_them" min="1" required>
                                <input type="hidden" name="product_id" value="<?php echo $product_row['product_id']; ?>">
                            </td>
                            <td class="duyet">
                                <button type="submit" name="submit_add">Thêm</button>
                            </td>
                        </tr>
                        </form>
                        <?php } ?>
                    </table>
                <?php } ?>



                <h1>Danh sách kho</h1>
                <table>
                    <tr>
                        <th>Stt</th>
                        <th>ID</th>
                        <th>tên sản sản phẩm</th>
                        <th>số lượng</th>
                        <th>Đã bán</th>
                        <th>Số lượng thêm</th>
                        <th>Tùy biến</th>
                    </tr>
                    <?php
                    if (!empty($all_products)) {
                    $i = 0;
                    foreach ($all_products as $result) {
                        $i++;
                    ?>
                    <form method="post" action="">
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $result['product_id']?></td>
                            <td><?php echo $result['product_name']?></td>
                            <td><?php echo $result['product_soluong']?></td>
                            <td><?php echo $result['product_daban']?></td>
                            <td class="kho">
                                <input type="number" name="soluong_them" min="1" required>
                                <input type="hidden" name="product_id" value="<?php echo $result['product_id'] ?>">
                            </td>
                            <td class="duyet">
                                <button type="submit" name="submit_add">Thêm</button>
                            </td>
                        </tr>
                        </form>
                    <?php
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
    </section>
</body>
</html>