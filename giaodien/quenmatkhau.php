<?php
    include "./class/Dangnhap.php";
    include_once "./admin/database.php";
    $errorMsg = '';
    $db = new Database(); // Thêm dòng này
    $user = new user($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actionC']) && $_POST['actionC'] == 'login') {
    $user_taikhoan = $_POST['user_taikhoan'];
    $user_sdt = $_POST['user_sdt'];

    $user_id = $user->checkUserForResetPassword($user_taikhoan, $user_sdt);

    if ($user_id) {
        header("Location: doimatkhau.php?user_id=" . urlencode($user_id));
        exit();
    } else {
        $errorMsg = "Tài khoản hoặc số điện thoại không chính xác!";
    }
}

include "./slider_top.php";
?>
<div class="warpper">
    <div class="form-box login">
                <h2>Quên mật khẩu</h2>
                <?php if ($errorMsg !== ''): ?>
                    <p class="error-message show"><?php echo htmlspecialchars($errorMsg); ?></p>
                <?php else: ?>
                    <p class="error-message"></p> <!-- giữ chỗ cao để layout không nhảy -->
                <?php endif; ?>
                <form method="POST" action="">
                    <input type="hidden" name="actionC" value="login">
                    <div class="input-box">
                        <span class="icon"><i class="fa-solid fa-user"></i></span>
                        <input type="text" id="user_taikhoan" name="user_taikhoan" required>
                        <label>Tài khoản</label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><i class="fa-solid fa-phone"></i></span>
                        <input type="text" name="user_sdt" maxlength="10" required>
                        <label>Số điện thoại</label>
                    </div>
                    <button type="submit" class="btn">Quên mật khẩu</button>
                    <div class="login-register">
                        <p>Bạn có muốn trở về <a href="login.php" class="register-link">Đăng nhập?</a></p>
                    </div>
                </form>
            </div>
</div>
<?php
include "./slider_bot.php";
?>