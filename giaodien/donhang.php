<?php
    include "./slider_top.php";
    include "./class/donhang_class.php";

    
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    if ($user_id) 
    {   
        $donhang = new donhang;
        $show_donhang = $donhang->show_donhang($user_id);
    }
     else 
    {
        echo "<script>
            alert('Vui lòng đăng nhập để xem đơn hàng.');
            window.location.href = 'index.php'; // Chuyển hướng về index.php
        </script>";
        exit();
    }
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
                        <th>Họ tên</th>
                        <th>SĐT</th>
                        <th>Tỉnh/Tp</th>
                        <th>Quận/Huyện</th>
                        <th>Địa chỉ</th>
                        <th>Số tiền</th>
                        <th>Thời gian</th>
                        <th>Tình trạng</th>
                        <th>Chi tiết</th>
                        <th>Hủy đơn</th>
                    </tr>
                    <tr>
                    <?php
                        if ($show_donhang) {
                            while ($result = $show_donhang->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?php echo $result['hoten']; ?></td>
                                    <td><?php echo $result['sdt']; ?></td>
                                    <td><?php echo $result['tinh_Tp']; ?></td>
                                    <td><?php echo $result['quan_huyen']; ?></td>
                                    <td><?php echo $result['diachi']; ?></td>
                                    <td><?php echo number_format($result['sotien'], 0, ',', '.'); ?><sup>VNĐ</sup></td>
                                    <td><?php echo date('d/m/Y', strtotime($result['thoigian'])); ?></td>
                                    <td><?php echo $result['tinhtrang']; ?></td>
                                    <td>
                                        <?php
                                            if ($result['tinhtrang'] === 'Đã hủy' || $result['tinhtrang'] === 'Đã hoàn thành') {
                                                echo "<span style='color: gray;'>Không có chi tiết</span>";
                                            } else {
                                                echo "<a href='chitiet_donhang.php?donhang_id={$result['donhang_id']}'>Xem chi tiết</a>";
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                            if ($result['tinhtrang'] === 'Chờ duyệt') { 
                                        ?>
                                            <a href="huydon_donhang.php?donhang_id=<?php echo $result['donhang_id']; ?>">Hủy đơn</a>
                                        <?php 
                                            } elseif ($result['tinhtrang'] === 'Đã giao') {
                                        ?>
                                            <a href="danhan_donhang.php?donhang_id=<?php echo $result['donhang_id']; ?>">Đã nhận</a>
                                        <?php 
                                            } elseif ($result['tinhtrang'] === 'Hoàn thành') {
                                        ?>
                                            <a href="hoantra_donhang.php?donhang_id=<?php echo $result['donhang_id']; ?>">Hoàn trả</a>
                                        <?php 
                                            }elseif ($result['tinhtrang'] === 'Đã hủy' || $result['tinhtrang'] === 'Đã hoàn đơn') { 
                                        ?>
                                            <a href="delete_donhang.php?donhang_id=<?php echo $result['donhang_id']; ?>">Xóa đơn</a>
                                        <?php 
                                            } else { 
                                        ?>
                                            <span style="color: red;">không thể hủy</span>
                                        <?php 
                                            } 
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo "<tr><td colspan='8'>Không có đơn hàng nào.</td></tr>";
                        }
                        ?>
            </table>    
        </div>
    </div>




<?php
    include "./slider_bot.php";
?>