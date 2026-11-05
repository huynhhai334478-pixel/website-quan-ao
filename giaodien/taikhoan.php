<?php
    include "./slider_top.php";
    include "./class/Dangnhap.php";
?>
<?php
    if (!isset($_SESSION['user_id'])) {
        echo "<script>alert('Bạn cần đăng nhập để xem thông tin cá nhân.'); window.location.href = 'login.php';</script>";
        exit();
    }

    $userClass = new user($db);
    $user_id = $_SESSION['user_id'];
    $user = $userClass->getUserById($user_id);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $new_pass = $_POST['user_matkhau'];
        $new_phone = $_POST['user_sdt'];

        $update_result = $userClass->updateUser($user_id, $new_pass, $new_phone);

        if ($update_result === true) {
            echo "<script>alert('Cập nhật thông tin thành công!'); window.location.href = 'profile.php';</script>";
            exit();
        } else {
            echo "<script>alert('Lỗi: $update_result');</script>";
        }
    }
?>
<body>
    <div class="profile-container">
        <h2>Thông tin tài khoản</h2>
        <form method="POST">
            <label>Tên đăng nhập</label>
            <input type="text" name="user_taikhoan" value="<?php echo htmlspecialchars($user['user_taikhoan']); ?>" readonly>

            <label>Mật khẩu</label>
            <input type="text" name="user_matkhau" value="<?php echo htmlspecialchars($user['user_matkhau']); ?>">

            <label>Số điện thoại</label>
            <input type="text" name="user_sdt" value="<?php echo htmlspecialchars($user['user_sdt']); ?>">

            <button type="submit">Cập nhật</button>
        </form>
    </div>
</body>
<?php
    include "./slider_bot.php";
?>