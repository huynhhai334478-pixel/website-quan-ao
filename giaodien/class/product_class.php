<?php
class product {
    private $db;

    public function __construct() 
    {
        $this->db = new Database();
    }

    public function get_products_by_category_and_brand($category_id, $brand_id = null) 
    {
    if ($brand_id !== null) {
        // Trường hợp có cả category_id và brand_id
        $query = "SELECT * FROM tbl_product WHERE category_id = '$category_id' AND brand_id = '$brand_id'";
    } else {
        // Trường hợp chỉ có category_id
        $query = "SELECT * FROM tbl_product WHERE category_id = '$category_id'";
    }

    $result = $this->db->select($query); // Lấy kết quả từ cơ sở dữ liệu
    return $result;
    }
    public function show_product($product_id)
    {
        $query = $query = "SELECT * FROM tbl_product WHERE product_id = '$product_id'";
        $result = $this->db->select($query);
        return $result;
    }
    public function search_product_by_name($search) {
    $query = "SELECT * FROM tbl_product WHERE product_name LIKE ?";
    $stmt = $this->db->prepare($query);
    $search_param = '%' . $search . '%';
    $stmt->bind_param("s", $search_param);
    $stmt->execute();
    return $stmt->get_result();
    }  
    // vote sao và bình luận
    public function insert_vote($user_id, $product_id, $sao)
    {
        $query_check = "SELECT * FROM tbl_sao WHERE user_id = ? AND product_id = ?";
        $stmt_check = $this->db->prepare($query_check);
        $stmt_check->bind_param("ii", $user_id, $product_id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            return "Bạn đã đánh giá sản phẩm này rồi!";
        }

        $stmt_check->close();

        $query = "INSERT INTO tbl_sao (user_id, product_id, sao) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("iii", $user_id, $product_id, $sao);
        $stmt->execute();
        $stmt->close();

        return true;
    }
    public function insert_binhluan($user_id, $product_id, $user_taikhoan, $binhluan)
    {
        $query = "INSERT INTO tbl_binhluan (user_id, product_id, user_taikhoan, binhluan, thoigian) VALUES (?, ?, ?, ?, CURDATE())";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("iiss", $user_id, $product_id, $user_taikhoan, $binhluan);
        $stmt->execute();
        $stmt->close();
        return true;
    }

    public function get_binhluan_by_product($product_id) {
    $query = "SELECT user_id, product_id, user_taikhoan, binhluan, thoigian, idbinhluan FROM tbl_binhluan WHERE product_id = ? ORDER BY idbinhluan DESC";
    $stmt = $this->db->prepare($query);
    if (!$stmt) {
        return false;
    }
    $stmt->bind_param("i", $product_id);
    if (!$stmt->execute()) {
        $stmt->close();
        return false;
    }
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
    }

    public function get_average_rating($product_id) {
    $query = "SELECT AVG(sao) as avg_sao, COUNT(*) as total FROM tbl_sao WHERE product_id = '$product_id'";
    return $this->db->select($query);
    }
    //mua hàng thanh toán sẽ tự động cập nhật số lượng sản phẩm
    public function updateProductAfterOrder($product_ma, $quantity) {
    $product_ma = $this->db->connection->real_escape_string($product_ma);

    $quantity = intval($quantity);

    $query = "UPDATE tbl_product 
              SET 
                  product_soluong = product_soluong - $quantity,
                  product_daban = product_daban + $quantity 
              WHERE product_ma = '$product_ma' AND product_soluong >= $quantity";

    return $this->db->update($query);
    }
    public function getProductQuantity($product_ma) {
    $product_ma = $this->db->connection->real_escape_string($product_ma);
    $query = "SELECT product_soluong FROM tbl_product WHERE product_ma = '$product_ma'";
    $result = $this->db->select($query);
    if ($result && $row = $result->fetch_assoc()) {
        return intval($row['product_soluong']);
    }
    return 0; // nếu không tìm thấy trả về 0 để không cho đặt
    }
    //xóa bình luận
    public function delete_binhluan($idbinhluan, $user_id)
    {
    $query = "DELETE FROM tbl_binhluan WHERE idbinhluan = ? AND user_id = ?";
    $stmt = $this->db->prepare($query);
    if (!$stmt) {
        return false;
    }

    $stmt->bind_param("ii", $idbinhluan, $user_id);
    $result = $stmt->execute();
    $stmt->close();

    return $result;
    }

}
?>
