<?php
class cart
{    
    private $db;

    public function __construct() 
    {
        $this->db = new Database();
    }
    public function insert_cart($user_id, $product_id, $cart_size, $cart_sl, $product_name, $product_ma, $product_price, $product_img)
{
    // 1. Kiểm tra tồn kho sản phẩm
    $check_query = "SELECT product_soluong FROM tbl_product WHERE product_id = ?";
    $stmt_check = $this->db->prepare($check_query);

    if (!$stmt_check) {
        die("Lỗi chuẩn bị truy vấn kiểm tra số lượng: " . $this->db->connect()->error);
    }

    $stmt_check->bind_param("i", $product_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check && $result_check->num_rows > 0) {
        $row = $result_check->fetch_assoc();
        $product_soluong = (int)$row['product_soluong'];

        if ($product_soluong == 0) {
            return "Hàng đã hết, thêm thất bại!";
        }
    } else {
        return "Không tìm thấy sản phẩm!";
    }
    $stmt_check->close();

    // 2. Kiểm tra sản phẩm cùng size đã có trong giỏ hàng chưa
    $check_cart_query = "SELECT cart_sl FROM tbl_cart WHERE user_id = ? AND product_id = ? AND cart_size = ?";
    $stmt_cart_check = $this->db->prepare($check_cart_query);
    if (!$stmt_cart_check) {
        die("Lỗi chuẩn bị truy vấn kiểm tra giỏ hàng: " . $this->db->connect()->error);
    }
    $stmt_cart_check->bind_param("iis", $user_id, $product_id, $cart_size);
    $stmt_cart_check->execute();
    $result_cart_check = $stmt_cart_check->get_result();

    if ($result_cart_check && $result_cart_check->num_rows > 0) {
        // Đã có sản phẩm cùng size, cộng dồn số lượng
        $row_cart = $result_cart_check->fetch_assoc();
        $current_sl = (int)$row_cart['cart_sl'];
        $new_sl = $current_sl + $cart_sl;

        // Kiểm tra tồn kho với số lượng mới
        if ($new_sl > $product_soluong) {
            return "Không đủ hàng trong kho, bạn chỉ có thể mua tối đa $product_soluong sản phẩm.";
        }

        // Cập nhật lại số lượng trong giỏ hàng
        $update_query = "UPDATE tbl_cart SET cart_sl = ? WHERE user_id = ? AND product_id = ? AND cart_size = ?";
        $stmt_update = $this->db->prepare($update_query);
        if (!$stmt_update) {
            die("Lỗi chuẩn bị truy vấn cập nhật giỏ hàng: " . $this->db->connect()->error);
        }
        $stmt_update->bind_param("iiis", $new_sl, $user_id, $product_id, $cart_size);
        $result_update = $stmt_update->execute();
        $stmt_update->close();

        if ($result_update) {
            return true;
        } else {
            return "Lỗi khi cập nhật số lượng trong giỏ hàng";
        }
    } else {
        // Chưa có sản phẩm cùng size, thêm mới

        // Kiểm tra số lượng đặt có vượt tồn kho không
        if ($cart_sl > $product_soluong) {
            return "Không đủ hàng trong kho, chỉ còn $product_soluong sản phẩm!";
        }

        $insert_query = "INSERT INTO tbl_cart (user_id, product_id, cart_size, cart_sl, product_name, product_ma, product_price, product_img) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = $this->db->prepare($insert_query);
        if (!$stmt_insert) {
            die("Lỗi chuẩn bị câu truy vấn: " . $this->db->connect()->error);
        }
        $stmt_insert->bind_param("iisissss", $user_id, $product_id, $cart_size, $cart_sl, $product_name, $product_ma, $product_price, $product_img);
        $result_insert = $stmt_insert->execute();
        $stmt_insert->close();

        if ($result_insert) {
            return true;
        } else {
            return "Lỗi khi thêm sản phẩm vào giỏ hàng";
        }
    }
}


    public function show_cart($user_id) {
        $query = "SELECT * FROM tbl_cart WHERE user_id = '$user_id'";
        $result = $this->db->select($query);
        return $result;
    }
    public function delete_cart($cart_id)
    {
        $query = "DELETE FROM tbl_cart WHERE cart_id = '$cart_id'";
        $result = $this->db->delete($query);
        header('location:cart.php?user_id='.$_GET['user_id']);
        return $result;
    }
    public function delete_cart_by_user($user_id) {
        $query = "DELETE FROM tbl_cart WHERE user_id = ?";
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            die("Lỗi chuẩn bị câu truy vấn: " . $this->db->connect()->error);
        }
        $stmt->bind_param("i", $user_id);
        $result = $stmt->execute();
        if (!$result) {
            die("Lỗi thực thi câu truy vấn: " . $stmt->error);
        }
        $stmt->close();
        return $result;
    }
    public function update_cart_quantity($cart_id, $cart_sl) {
    $query = "UPDATE tbl_cart SET cart_sl = ? WHERE cart_id = ?";
    $stmt = $this->db->prepare($query);
    if (!$stmt) {
        die("Lỗi chuẩn bị câu truy vấn: " . $this->db->connect()->error);
    }
    $stmt->bind_param("ii", $cart_sl, $cart_id);
    $result = $stmt->execute();
    if (!$result) {
        die("Lỗi thực thi câu truy vấn: " . $stmt->error);
    }
    $stmt->close();
    return $result;
    }
    //voucher
}
?>