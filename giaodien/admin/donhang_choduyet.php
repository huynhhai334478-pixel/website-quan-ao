<?php
    include "header.php";
    include "slider.php";
    include "class/donhang_class.php";
?>
<?php
    $donhang = new donhang;
    $show_choduyet = $donhang ->show_choduyet();
?>

<div class="admin-content-right">
            <div class="admin-content-right-category_list">
                <h1>Danh sách chờ duyệt</h1>
                <table>
                    <tr>
                        <th>Stt</th>
                        <th>ID</th>
                        <th>Họ tên</th>
                        <th>SĐT</th>
                        <th>Tỉnh/Tp</th>
                        <th>Quận/Huyện</th>
                        <th>Địa chỉ</th>
                        <th>Số tiền</th>
                        <th>Thời gian</th>
                        <th>Tình trạng</th>
                        <th>Duyệt</th>
                    </tr>
                    <?php
                    if($show_choduyet)
                    {
                        $i=0;
                        while($result = $show_choduyet->fetch_assoc())
                        {$i++;
                    ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $result['donhang_id']?></td>
                        <td><?php echo $result['hoten']; ?></td>
                        <td><?php echo $result['sdt']; ?></td>
                        <td><?php echo $result['tinh_Tp']; ?></td>
                        <td><?php echo $result['quan_huyen']; ?></td>
                        <td><?php echo $result['diachi']; ?></td>
                        <td><?php echo number_format($result['sotien'], 0, ',', '.'); ?><sup>VNĐ</sup></td>
                        <td><?php echo date('d/m/Y', strtotime($result['thoigian'])); ?></td>   
                        <td><?php echo $result['tinhtrang']; ?></td>
                        <td class="duyet"><a href="update_tinhtrangchoduyet.php?donhang_id=<?php echo $result['donhang_id']; ?>">Duyệt</a></td>
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