<?php
    include "header.php";
    include "slider.php";
    include "class/voucher_class.php";
?>


<?php
    $voucher = new voucher;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
        $tenvoucher = $_POST['tenvoucher'];
        $loaigiam = $_POST['loaigiam'];
        $giagiam = $_POST['giagiam'];
        $slvoucher = $_POST['slvoucher'];
        $alert = $voucher->insert_voucher( $tenvoucher, $loaigiam, $giagiam, $slvoucher);
        
        if ($alert) {
            echo "<script>alert('$alert');</script>";
        }
    }
?>



<div class="admin-content-right">
            <div class="admin-content-right-product_add">
                <h1>Thêm voucher</h1>
                <form action="" method="post">
                    <label for="">Tên voucher<span style="color: orangered;">*</span></label>
                        <input required name="tenvoucher" type="text" placeholder="Nhập tên voucher" required>
                    <label for="">Loại giảm<span style="color: orangered;">*</span></label>
                        <select name="loaigiam" id="">
                                <option value="VNĐ">VNĐ</option>
                                <option value="PHẦN TRĂM">PHẦN TRĂM</option>
                        </select>
                    <label for="">Giá giảm<span style="color: orangered;">*</span></label>
                        <input required name="giagiam" type="text" placeholder="Nhập giá giảm" required>
                    <label for="">Số lượng voucher<span style="color: orangered;">*</span></label>
                        <input required name="slvoucher" type="text" placeholder="Nhập số lượng" required>
                    <button type="submit">Thêm</button>
                </form>
            </div>
        </div>
    </section>
</body>
</html>