<?php
    include "header.php";
    include "slider.php";
    include "class/product_class.php";
?>
<?php
    $product = new product;
    $show_binhluan = $product ->show_binhluan();
?>



<div class="admin-content-right">
            <div class="admin-content-right-category_list">
                <h1>Danh sách bình luận</h1>
                <table>
                    <tr>
                        <th>Stt</th>
                        <th>ID</th>
                        <th>ID sản phẩm</th>
                        <th>ID Tài khoản</th>
                        <th>Tên tài khoản</th>
                        <th>Thời gian</th>
                        <th>Nội dung</th>
                        <th>Xóa</th>
                    </tr>
                    <?php
                    if($show_binhluan)
                    {
                        $i=0;
                        while($result = $show_binhluan->fetch_assoc())
                        {$i++;
                    ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $result['idbinhluan']?></td>
                        <td><?php echo $result['product_id']?></td>
                        <td><?php echo $result['user_id']?></td>
                        <td><?php echo $result['user_taikhoan']?></td>
                        <td><?php echo date('d/m/Y', strtotime($result['thoigian'])); ?></td>
                        <td><?php echo $result['binhluan']?></td>
                        <td><a href="binhluandelete.php?idbinhluan=<?php echo $result['idbinhluan']?>"><i class="fa-solid fa-delete-left"></i></a></td>
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