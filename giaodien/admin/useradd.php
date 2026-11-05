<?php
    include "header.php";
    include "slider.php";
    include "class/user_class.php";
?>


<?php
    $user = new user;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
        $user_taikhoan = $_POST['user_taikhoan'];
        $user_matkhau = $_POST['user_matkhau'];
        $user_sdt = $_POST['user_sdt'];
        $user_quyen = $_POST['user_quyen'];
        $alert = $user->insert_user( $user_taikhoan, $user_matkhau, $user_sdt, $user_quyen);
        
        if ($alert) {
            echo "<script>alert('$alert');</script>";
        }
    }
?>



<div class="admin-content-right">
            <div class="admin-content-right-product_add">
                <h1>Thêm tài khoản</h1>
                <form action="" method="post">
                    <label for="">Tài khoản<span style="color: orangered;">*</span></label>
                        <input required name="user_taikhoan" type="text" placeholder="Nhập tên tài khoản">
                    <label for="">Mật khẩu<span style="color: orangered;">*</span></label>
                        <input required name="user_matkhau" type="text" placeholder="Nhập mật khẩu" required>
                    <label for="">Số điện thoại<span style="color: orangered;">*</span></label>
                        <input required name="user_sdt" type="text" placeholder="Nhập sdt">
                    <label for="">Phân quyền<span style="color: orangered;">*</span></label>
                       <select name="user_quyen" id="">
                            <option value="Admin">Admin</option>
                            <option value="User">User</option>
                       </select>
                    <button type="submit">Thêm</button>
                </form>
            </div>
        </div>
    </section>
</body>
</html>