<?php
class user {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

        public function login($user_taikhoan, $user_matkhau) {
            $query = "SELECT * FROM tbl_user WHERE user_taikhoan = ?";
            $stmt = $this->db->prepare($query);
        
            if (!$stmt) {
                return "Lỗi prepare: " . $this->db->error;
            }
        
            $stmt->bind_param("s", $user_taikhoan);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
        
            if ($user) {
                // Kiểm tra mật khẩu người dùng nhập vào
                if ($user['user_matkhau'] === $user_matkhau) {
                    return $user;
                } else {
                    return "Mật khẩu không đúng!";
                }
            } else {
                return "Tài khoản không tồn tại!";
            }
        }        
        public function register($user_taikhoan, $user_matkhau, $user_sdt) {
        // Hàm kiểm tra mật khẩu
        if (!preg_match('/[A-Z]/', $user_matkhau) ||
            !preg_match('/[a-z]/', $user_matkhau) ||
            !preg_match('/[\W_]/', $user_matkhau)) {
            return "Mật khẩu phải có ít nhất 1 chữ hoa, 1 chữ thường và 1 ký tự đặc biệt.";
        }

        // Hàm kiểm tra số điện thoại
        if (!preg_match('/^0\d{9}$/', $user_sdt)) {
            return "Số điện thoại không đúng.";
        }

        // Kiểm tra xem user_taikhoan đã tồn tại trong cơ sở dữ liệu chưa
        $checkQuery = "SELECT COUNT(*) FROM tbl_user WHERE user_taikhoan = ?";
        $checkStmt = $this->db->prepare($checkQuery);

        if (!$checkStmt) {
            die("Lỗi prepare: " . $this->db->connection->error);
        }

        $checkStmt->bind_param("s", $user_taikhoan);
        $checkStmt->execute();
        $count = 0;
        $checkStmt->bind_result($count);
        $checkStmt->fetch();
        $checkStmt->close();

        if ($count > 0) {
            return "Tài khoản đã tồn tại, vui lòng chọn tên khác.";
        }
        $checkPhoneQuery = "SELECT COUNT(*) FROM tbl_user WHERE user_sdt = ?";
        $checkPhoneStmt = $this->db->prepare($checkPhoneQuery);

        if (!$checkPhoneStmt) {
            die("Lỗi prepare (số điện thoại): " . $this->db->error);
        }

        $checkPhoneStmt->bind_param("s", $user_sdt);

        if (!$checkPhoneStmt->execute()) {
            die("Lỗi execute (số điện thoại): " . $checkPhoneStmt->error);
        }

        // Khởi tạo biến trước khi bind_result
        $phoneCount = 0;

        $checkPhoneStmt->bind_result($phoneCount);
        $checkPhoneStmt->fetch();
        $checkPhoneStmt->close();

        if ($phoneCount > 0) {
            return "Số điện thoại đã tồn tại.";
        }
        // Thực hiện đăng ký
        $query = "INSERT INTO tbl_user (user_taikhoan, user_matkhau, user_sdt, user_quyen) VALUES (?, ?, ?, 'User')";
        $stmt = $this->db->prepare($query);

        if (!$stmt) {
            die("Lỗi prepare: " . $this->db->connection->error);
        }

        $stmt->bind_param("sss", $user_taikhoan, $user_matkhau, $user_sdt);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }
    //Quên mật khẩu
    public function checkUserForResetPassword($user_taikhoan, $user_sdt) {
    $query = "SELECT user_id FROM tbl_user WHERE user_taikhoan = ? AND user_sdt = ?";
    $stmt = $this->db->prepare($query);
    if (!$stmt) {
        // Debug lỗi prepare
        return "Lỗi prepare: " . $this->db->error;
    }
    $stmt->bind_param("ss", $user_taikhoan, $user_sdt);
    if (!$stmt->execute()) {
        // Debug lỗi execute
        return "Lỗi execute: " . $stmt->error;
    }

    $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stmt->close();
            return $row['user_id'];  // trả về user_id nếu tìm thấy
        } else {
            $stmt->close();
            return false;  // không tìm thấy user phù hợp
        }
    }

    // Đổi mật khẩu
    public function changePassword($user_id, $new_password) {
    $query = "UPDATE tbl_user SET user_matkhau = ? WHERE user_id = ?";
    
    $stmt = $this->db->prepare($query);
    if (!$stmt) {
        return false;
    }
    
    $stmt->bind_param("si", $new_password, $user_id);
    $result = $stmt->execute();
    $stmt->close();
    
    return $result;
    }
    //thông tin tài khoản
     // Lấy thông tin user theo user_id
    public function getUserById($user_id) {
        $query = "SELECT * FROM tbl_user WHERE user_id = ?";
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        return $user;
    }

    // Cập nhật mật khẩu và số điện thoại với kiểm tra tương tự register
    public function updateUser($user_id, $new_pass, $new_phone) {
        // Kiểm tra mật khẩu (ít nhất 1 chữ hoa, 1 chữ thường, 1 ký tự đặc biệt)
        if (!preg_match('/[A-Z]/', $new_pass) ||
            !preg_match('/[a-z]/', $new_pass) ||
            !preg_match('/[\W_]/', $new_pass)) {
            return "Mật khẩu phải có ít nhất 1 chữ hoa, 1 chữ thường và 1 ký tự đặc biệt.";
        }

        // Kiểm tra số điện thoại đúng định dạng 0xxxxxxxxx (10 số)
        if (!preg_match('/^0\d{9}$/', $new_phone)) {
            return "Số điện thoại không đúng định dạng.";
        }

        // Kiểm tra số điện thoại đã tồn tại trên user khác (tránh trùng)
        $query = "SELECT user_id FROM tbl_user WHERE user_sdt = ? AND user_id != ?";
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param("si", $new_phone, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $stmt->close();
            return "Số điện thoại đã được sử dụng bởi người khác.";
        }
        $stmt->close();

        // Thực hiện cập nhật
        $updateQuery = "UPDATE tbl_user SET user_matkhau = ?, user_sdt = ? WHERE user_id = ?";
        $stmt = $this->db->prepare($updateQuery);
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param("ssi", $new_pass, $new_phone, $user_id);
        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

}
?>