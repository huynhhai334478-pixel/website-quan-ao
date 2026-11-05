<?php
    include "header.php";
    include "slider.php";
    include "class/voucher_class.php";
?>
<?php
    $voucher = new voucher;
    $show_voucher = $voucher ->show_voucher();
?>



<div class="admin-content-right">
            <div class="admin-content-right-category_list">
                <h1>Danh sách voucher</h1>
                <table>
                    <tr>
                        <th>Stt</th>
                        <th>ID</th>
                        <th>Tên voucher</th>
                        <th>Loại giảm</th>
                        <th>Giá giảm</th>
                        <th>Số lượng voucher</th>
                        <th>Lượt dùng</th>
                        <th>Tùy biến</th>
                    </tr>
                    <?php
                    if($show_voucher)
                    {
                        $i=0;
                        while($result = $show_voucher->fetch_assoc())
                        {$i++;
                    ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $result['idvoucher']?></td>
                        <td><?php echo $result['tenvoucher']?></td>
                        <td><?php echo $result['loaigiam']?></td>
                        <td><?php echo $result['giagiam']?></td>
                        <td><?php echo $result['slvoucher']?></td>
                        <td><?php echo $result['luotdung']?></td>
                        <td><a href="voucheredit.php?idvoucher=<?php echo $result['idvoucher']?>"><i class="fa-solid fa-wrench"></i></a>|<a href="voucherdelete.php?idvoucher=<?php echo $result['idvoucher']?>"><i class="fa-solid fa-delete-left"></i></a></td>
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