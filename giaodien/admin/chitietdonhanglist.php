<?php
    include "header.php";
    include "slider.php";
    include "class/donhang_class.php";
?>
<?php
    $donhang = new donhang;
    $show_chitietdonghang = $donhang ->show_chitietdonhang();
?>

<div class="admin-content-right">
            <div class="admin-content-right-category_list">
                <h1>Chi tiết đơn hàng</h1>
                <table>
                    <tr>
                        <th>Stt</th>
                        <th>ID</th>
                        <th>ID đơn hàng</th>
                        <th>Tên sản phẩm</th>
                        <th>Mã sản phẩm</th>
                        <th>Size</th>
                        <th>Số lượng sản phẩm</th>
                    </tr>
                    <?php
                    if($show_chitietdonghang)
                    {
                        $i=0;
                        while($result = $show_chitietdonghang->fetch_assoc())
                        {$i++;
                    ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $result['idchitiet']?></td>
                        <td><?php echo $result['donhang_id']; ?></td>
                        <td><?php echo $result['product_name']; ?></td>
                        <td><?php echo $result['product_ma']; ?></td>
                        <td><?php echo $result['cart_size']; ?></td>
                        <td><?php echo $result['product_soluong']; ?></td>
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