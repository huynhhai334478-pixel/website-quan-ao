<?php
include "./slider_top.php";
include "./class/Dangnhap.php";
?>
<?php
// Xử lý đăng nhập
    $login_error = null;

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['actionC']) && $_POST['actionC'] == 'login') {
        if (isset($_POST['user_taikhoan']) && isset($_POST['user_matkhau'])) {
            $user_taikhoan = $_POST['user_taikhoan'];
            $user_matkhau = $_POST['user_matkhau'];
            $userObj = new user($db);
            $result = $userObj->login($user_taikhoan, $user_matkhau);

            if ($result && is_array($result)) {
                // Đăng nhập thành công
                $_SESSION['user_id'] = $result['user_id'];
                $_SESSION['user_taikhoan'] = $result['user_taikhoan'];
                $_SESSION['user_quyen'] = $result['user_quyen'];
                if ($result['user_quyen'] == 'Admin') {
                    echo "<script>
                        alert('Đăng nhập thành công với quyền Admin!');
                        window.location.href = 'index.php';
                    </script>";
                    exit();
                } else {
                    echo "<script>window.location.href = 'index.php';</script>";
                    exit();
                }
            } else {
                // Lỗi đăng nhập, lưu vào biến để hiển thị dưới form
                $login_error = $result;
            }
        } else {
            $login_error = "Thông tin đăng nhập không đầy đủ!";
        }
    }
    // Xử lý đăng ký
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['actionC']) && $_POST['actionC'] == 'register') {
        $user_taikhoan = $_POST['user_taikhoan'];
        $user_matkhau = $_POST['user_matkhau'];
        $user_sdt = $_POST['user_sdt'];
        $userObj = new User($db); // Truyền $db vào lớp user
        $register = $userObj->register($user_taikhoan, $user_matkhau, $user_sdt);
        if ($register === true) {
            $register_success = true;
            $register_message = 'Đăng ký thành công! Vui lòng đăng nhập.';
        } else {
            $register_success = false;
            $register_message = $register;
        }
    }
?>
    <?php if (isset($register_success) && $register_success): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const wrapper = document.querySelector('.warpper');
                if (wrapper) {
                    wrapper.classList.remove('activeC'); // Mở form login
                    wrapper.classList.add('active-popup'); // Hiện form
                    // Thêm dòng chữ thông báo thành công bên dưới login form nếu cần
                }
            });
        </script>
    <?php elseif (isset($register_success) && !$register_success): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const wrapper = document.querySelector('.warpper');
                if (wrapper) {
                    wrapper.classList.add('activeC'); // Mở lại form register
                    wrapper.classList.add('active-popup');
                    // Thêm dòng chữ thông báo thất bại bên dưới register form nếu cần
                }
            });
        </script>
    <?php endif; ?>
<?php if (!$logged_in): ?>
    <div class="warpper">
            <!-- Form Đăng nhập -->
            <div class="form-box login">
                <h2>Đăng nhập</h2>
                <p class="message-register <?php if (isset($register_success) && $register_success) echo 'show'; ?>">
                    <?= isset($register_message) ? htmlspecialchars($register_message) : '&nbsp;' ?>
                </p>
                <div class="error-message <?= isset($login_error) && $login_error ? 'show' : '' ?>">
                    <?= isset($login_error) ? htmlspecialchars($login_error) : '&nbsp;' ?>
                </div>
                <form method="POST" action="">
                    <input type="hidden" name="actionC" value="login">
                    <div class="input-box">
                        <span class="icon"><i class="fa-solid fa-user"></i></span>
                        <input type="text" id="user_taikhoan" name="user_taikhoan" required>
                        <label>Tài khoản</label>
                    </div>
                    <div class="input-box">
                        <span class="toggle-password" toggle="#login_password"><i class="fa-solid fa-eye"></i></span>
                        <input type="password" id="login_password" name="user_matkhau" required>
                        <label>Mật khẩu</label>
                    </div>
                    <div class="remember-forgot">
                        <label><input type="checkbox" required>Lưu tài khoản</label>
                        <a href="quenmatkhau.php">Quên mật khẩu?</a>
                    </div>
                    <button type="submit" class="btn">Đăng nhập</button>
                    <div class="login-register">
                        <p>Bạn không có tài khoản?<a href="#" class="register-link">Đăng ký</a></p>
                    </div>
                </form>
            </div>

            <!-- Form Đăng ký -->
            <div class="form-box register">
                <h2>Đăng ký</h2>
                <p class="message-register <?= isset($register_message) ? 'show' : '' ?>" style="text-align:center; color: <?= $register_success ? 'green' : 'red' ?>;">
                    <?= isset($register_message) ? htmlspecialchars($register_message) : '&nbsp;' ?>
                </p>
                <form method="POST" action="">
                    <input type="hidden" name="actionC" value="register">
                    <div class="input-box">
                        <span class="icon"><i class="fa-solid fa-user"></i></span>
                        <input type="text" name="user_taikhoan" maxlength="25" required>
                        <label>Tài khoản</label>
                    </div>
                    <div class="input-box">
                        <span class="toggle-password" toggle="#register_password"><i class="fa-solid fa-eye"></i></span>
                        <input type="password" id="register_password" name="user_matkhau" required>
                        <label>Mật khẩu</label>
                    </div>
                    <div class="input-box">
                        <span class="icon"><i class="fa-solid fa-phone"></i></span>
                        <input type="text" name="user_sdt" maxlength="10" required>
                        <label>Số điện thoại</label>
                    </div>
                    <div class="remember-forgot">
                        <label><input type="checkbox" required>Tôi đồng ý với các điều khoản và điều kiện</label>
                    </div>
                    <button type="submit" class="btn">Đăng ký</button>
                    <div class="login-link">
                        <p>Bạn đã có tài khoản?<a href="#" class="login-link">Đăng nhập</a></p>
                    </div>
                </form>
            </div>
    </div>
    <?php endif; ?>
<?php
include "./slider_bot.php";
?>