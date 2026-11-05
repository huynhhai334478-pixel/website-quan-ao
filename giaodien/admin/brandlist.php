<?php
    include "header.php";
    include "slider.php";
    include "class/brand_class.php";
?>
<?php
    $brand = new brand;
    $show_brand = $brand ->show_brand();
?>



<div class="admin-content-right">
            <div class="admin-content-right-category_list">
                <h1>Danh sách danh mục</h1>
                <table>
                    <tr>
                        <th>Stt</th>
                        <th>ID</th>
                        <th>category_id</th>
                        <th>Loại sản phẩm</th>
                        <th>Tùy biến</th>
                    </tr>
                    <?php
                    if($show_brand)
                    {
                        $i=0;
                        while($result = $show_brand->fetch_assoc())
                        {$i++;
                    ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $result['brand_id']?></td>
                        <td><?php echo $result['category_name']?></td>
                        <td><?php echo $result['brand_name']?></td>
                        <td><a href="brandedit.php?brand_id=<?php echo $result['brand_id']?>"><i class="fa-solid fa-wrench"></i></a>|<a href="branddelete.php?brand_id=<?php echo $result['brand_id']?>"><i class="fa-solid fa-delete-left"></i></a></td>
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