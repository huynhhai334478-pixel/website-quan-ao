<?php
    include_once "./admin/database.php";
    include "./class/Dangnhap.php";
    $errorMsg = '';

    // Lấy user_id từ GET (được truyền khi quên mật khẩu)
    $user_id = $_GET['user_id'] ?? null;

    // Nếu chưa có user_id, bạn nên redirect hoặc thông báo lỗi
    if (!$user_id) {
        echo "<p style='color:red; text-align:center;'>Không có user_id để đổi mật khẩu.</p>";
        include "./slider_bot.php";
        exit;
    }
    $db = new Database();
    $user = new user($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actionC']) && $_POST['actionC'] == 'login') {
    $password = $_POST['user_matkhau'] ?? '';
    $password_confirm = $_POST['user_matkhau_confirm'] ?? '';

    if ($password !== $password_confirm) {
        $errorMsg = "Mật khẩu nhập lại không khớp!";
    } elseif (!preg_match('/[A-Z]/', $password) ||
              !preg_match('/[a-z]/', $password) ||
              !preg_match('/[\W_]/', $password)) {
        $errorMsg = "Mật khẩu phải có ít nhất 1 chữ hoa, 1 chữ thường và 1 ký tự đặc biệt.";
    } else {
        if ($user->changePassword($user_id, $password)) {
        // chuyển về login.php kèm thông báo qua GET
       echo "<script>
            alert('Đổi mật khẩu thành công!');
            window.location.href = 'login.php';
            </script>";
        exit();
        } else {
            $errorMsg = "Đổi mật khẩu thất bại, vui lòng thử lại.";
        }

    }
}
    include "./slider_top.php";
?>
<div class="warpper">
    <div class="form-box login">
                <h2>Đổi mật khẩu</h2>
                <?php if ($errorMsg !== ''): ?>
                    <p class="error-message show"><?php echo htmlspecialchars($errorMsg); ?></p>
                <?php else: ?>
                    <p class="error-message"></p> <!-- giữ chỗ cao để layout không nhảy -->
                <?php endif; ?>
                <form method="POST" action="">
                    <input type="hidden" name="actionC" value="login">
                    <div class="input-box">
                        <span class="toggle-password" toggle="#user_matkhau"><i class="fa-solid fa-eye"></i></span>
                        <input type="password" id="user_matkhau" name="user_matkhau" required>
                        <label>Mật khẩu</label>
                    </div>
                    <div class="input-box">
                        <span class="toggle-password" toggle="#user_matkhau_confirm"><i class="fa-solid fa-eye"></i></span>
                        <input type="password" id="user_matkhau_confirm" name="user_matkhau_confirm" required>
                        <label>Nhập lại mật khẩu</label>
                    </div>
                    <button type="submit" class="btn">Đổi mật khẩu</button>
                </form>
            </div>
</div>
<?php
include "./slider_bot.php";
?>