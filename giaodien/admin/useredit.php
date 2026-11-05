<?php
    include "header.php";
    include "slider.php";
    include "class/user_class.php";
?>


<?php
    $user = new user;
    $user_id = $_GET['user_id'];
    $get_user = $user -> get_user($user_id);
    if($get_user)
    {
        $result = $get_user -> fetch_assoc();
    }


    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
        $user_taikhoan = $_POST['user_taikhoan'];
        $user_matkhau = $_POST['user_matkhau'];
        $user_sdt = $_POST['user_sdt'];
        $user_quyen = $_POST['user_quyen'];
        $alert = $user->update_user($user_taikhoan, $user_matkhau, $user_sdt,$user_quyen, $user_id);
        
        if ($alert) {
            echo "<script>alert('$alert');</script>";
        }
    }
?>


<div class="admin-content-right">
            <div class="admin-content-right-product_add">
                <h1>Chỉnh sửa tài khoản</h1>
                <form action="" method="post">
                    <label for="">Tài khoản<span style="color: orangered;">*</span></label>
                        <input required name="user_taikhoan" type="text" placeholder="Nhập tên tài khoản" 
                        value="<?php echo $result['user_taikhoan']; ?>">
                    <label for="">Mật khẩu<span style="color: orangered;">*</span></label>
                        <input required name="user_matkhau" type="text" placeholder="Nhập mật khẩu"
                        value="<?php echo $result['user_matkhau']; ?>">
                    <label for="">Số điện thoại<span style="color: orangered;">*</span></label>
                        <input required name="user_sdt" type="text" placeholder="Nhập sdt"
                        value="<?php echo $result['user_sdt']; ?>">
                    <label for="">Quyền<span style="color: orangered;">*</span></label>
                        <select name="user_quyen" id="user_quyen">
                            <option value="Admin"<?php if ($result['user_quyen'] == 'Admin') echo 'selected'; ?>>Admin</option>
                            <option value="User"<?php if ($result['user_quyen'] == 'User') echo 'selected'; ?>>User</option>
                        </select>
                        <button type="submit">Sửa</button>
                </form>
            </div>
        </div>
    </section>
</body>
</html>