<?php
    include "header.php";
    include "slider.php";
    include "class/product_class.php";
?>
<?php
    $product = new product;
    $show_product = $product ->show_product();
?>



<div class="admin-content-right">
            <div class="admin-content-right-category_list">
                <h1>Danh sách sản phẩm</h1>
                <table>
                    <tr>
                        <th>Stt</th>
                        <th>ID</th>
                        <th>category_id</th>
                        <th>brand_id</th>
                        <th>tên sản sản phẩm</th>
                        <th>mã sản phẩm</th>
                        <th>giá</th>
                        <th>Mô tả</th>
                        <th>hình ảnh</th>
                        <th>Tùy biến</th>
                    </tr>
                    <?php
                    if($show_product)
                    {
                        $i=0;
                        while($result = $show_product->fetch_assoc())
                        {$i++;
                    ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $result['product_id']?></td>
                        <td><?php echo $result['category_name']?></td>
                        <td><?php echo $result['brand_name']?></td>
                        <td><?php echo $result['product_name']?></td>
                        <td><?php echo $result['product_ma']?></td>
                        <td><?php echo $result['product_price']?></td>
                        <td><?php echo $result['product_desc']?></td>
                        <td>
                        <?php
                        // Kiểm tra xem có hình ảnh không và hiển thị hình ảnh nếu có
                        if ($result['product_img']) {
                            $imagePath = './class/uploads/' . $result['product_img'];
                            // Kiểm tra nếu hình ảnh tồn tại trong thư mục uploads
                            if (file_exists($imagePath)) {
                                echo '<img src="' . $imagePath . '" alt="Product Image" width="100">';
                            } else {
                                echo 'Image not found.';
                            }
                        }
                        ?>
                        </td>
                        <td><a href="productedit.php?product_id=<?php echo $result['product_id']?>"><i class="fa-solid fa-wrench"></i></a>|<a href="productdelete.php?product_id=<?php echo $result['product_id']?>"><i class="fa-solid fa-delete-left"></i></a></td>
                    </tr>
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