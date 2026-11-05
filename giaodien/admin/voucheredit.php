<?php
    include "header.php";
    include "slider.php";
    include "class/voucher_class.php";
?>


<?php
    $voucher = new voucher;
    $idvoucher = $_GET['idvoucher'];
    $get_voucher = $voucher -> get_voucher($idvoucher);
    if($get_voucher)
    {
        $result = $get_voucher -> fetch_assoc();
    }


    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
        $tenvoucher = $_POST['tenvoucher'];
        $loaigiam = $_POST['loaigiam'];
        $giagiam = $_POST['giagiam'];
        $slvoucher = $_POST['slvoucher'];
        $alert = $voucher->update_voucher($tenvoucher, $loaigiam, $giagiam,$slvoucher, $idvoucher);
        
        if ($alert) {
            echo "<script>alert('$alert');</script>";
        }
    }
?>


<div class="admin-content-right">
            <div class="admin-content-right-product_add">
                <h1>Chỉnh sửa voucher</h1>
                <form action="" method="post">
                    <label for="">Tên voucher<span style="color: orangered;">*</span></label>
                        <input required name="tenvoucher" type="text" placeholder="Nhập tên voucher"
                        value="<?php echo $result['tenvoucher']; ?>" required>
                    <label for="">Loại giảm<span style="color: orangered;">*</span></label>
                        <select name="loaigiam" id="loaigiam">
                            <option value="VNĐ" <?php if ($result['loaigiam'] == 'VNĐ') echo 'selected'; ?>>VNĐ</option>
                            <option value="PHẦN TRĂM" <?php if ($result['loaigiam'] == 'PHẦN TRĂM') echo 'selected'; ?>>PHẦN TRĂM</option>
                        </select>
                    <label for="">Giá giảm<span style="color: orangered;">*</span></label>
                        <input required name="giagiam" type="text" placeholder="Nhập giá giảm"
                        value="<?php echo $result['giagiam']; ?>" required>
                    <label for="">Số lượng voucher<span style="color: orangered;">*</span></label>
                        <input required name="slvoucher" type="text" placeholder="Nhập số lượng"
                        value="<?php echo $result['slvoucher']; ?>" required>
                    <button type="submit">Sửa</button>
                </form>
            </div>
        </div>
    </section>
</body>
</html>