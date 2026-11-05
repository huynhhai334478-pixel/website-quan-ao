<?php
class donhang
{    
    private $db;

    public function __construct() 
    {
        $this->db = new Database();
    }

    public function insert_donhang($user_id, $hoten, $sdt, $tinh_tp, $quan_huyen, $diachi, $sotien, $thoigian) {
    $conn = $this->db->connect();
    $stmt = $conn->prepare("INSERT INTO tbl_donhang (user_id, hoten, sdt, tinh_tp, quan_huyen, diachi, sotien, thoigian) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssis", $user_id, $hoten, $sdt, $tinh_tp, $quan_huyen, $diachi, $sotien, $thoigian);
    $result = $stmt->execute();
    $donhang_id = $conn->insert_id; // Lấy id vừa tạo
    $stmt->close();
    return $result ? $donhang_id : false;
    }
    public function show_donhang($user_id) {
        $query = "SELECT * FROM tbl_donhang WHERE user_id = ?";
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            die("Lỗi chuẩn bị câu truy vấn: " . $this->db->connect()->error);
        }
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
    public function delete_donhang($donhang_id)
    {
        $query = "DELETE FROM tbl_donhang WHERE donhang_id = '$donhang_id'";
        $result = $this->db->delete($query);
        return $result;
    }
    public function danhan_donhang($donhang_id, $tinhtrang) {
    // Đặt múi giờ Việt Nam để đảm bảo đúng ngày thực tế
    date_default_timezone_set('Asia/Ho_Chi_Minh');

    // Lấy ngày hiện tại (ví dụ: 2025-08-04)
    $thoigian = date("Y-m-d");

    // Câu lệnh SQL cập nhật trạng thái và ngày
    $query = "UPDATE tbl_donhang SET tinhtrang = ?, thoigian = ? WHERE donhang_id = ?";
    $stmt = $this->db->prepare($query);

    if (!$stmt) {
        die("Lỗi chuẩn bị câu truy vấn: " . $this->db->connect()->error);
    }

    // Gán giá trị cho câu truy vấn
        $stmt->bind_param("ssi", $tinhtrang, $thoigian, $donhang_id);

        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }
    public function insert_chitietdonhang($donhang_id, $product_ma, $product_name, $cart_size, $product_soluong, $idvoucher) {
    $conn = $this->db->connect();
    $stmt = $conn->prepare("INSERT INTO tbl_chitietdonhang (donhang_id, product_ma, product_name, cart_size, product_soluong, idvoucher) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssii", $donhang_id, $product_ma, $product_name, $cart_size, $product_soluong, $idvoucher);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
    }



    //xem thời gian
    public function getOrderTime($donhang_id) {
    $conn = $this->db->connect();
    $stmt = $conn->prepare("SELECT thoigian FROM tbl_donhang WHERE donhang_id = ?");
    $stmt->bind_param("i", $donhang_id);
    $stmt->execute();
    $stmt->bind_result($thoigian);
    $stmt->fetch();
    $stmt->close();
    return $thoigian;
    }
    //hủy đơn hàng
    public function huy_donhang($donhang_id) {
    $conn = $this->db->connect(); // Duy nhất 1 kết nối dùng lại tất cả bên dưới

    // Bước 1: Lấy danh sách sản phẩm trong đơn hàng
    $query = "SELECT product_ma, product_soluong FROM tbl_chitietdonhang WHERE donhang_id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Lỗi chuẩn bị truy vấn: " . $conn->error);
    }

    $stmt->bind_param("i", $donhang_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $sanphams = [];
    while ($row = $result->fetch_assoc()) {
        $sanphams[] = $row;
    }
    $stmt->close();

    // Bước 2: Cập nhật lại số lượng trong tbl_product
    foreach ($sanphams as $sp) {
        $update = "UPDATE tbl_product 
                   SET product_soluong = product_soluong + ?, 
                       product_daban = product_daban - ? 
                   WHERE product_ma = ?";
        $stmt = $conn->prepare($update);
        if (!$stmt) {
            die("Lỗi chuẩn bị cập nhật sản phẩm: " . $conn->error);
        }
        $stmt->bind_param("iis", $sp['product_soluong'], $sp['product_soluong'], $sp['product_ma']);
        $stmt->execute();
        $stmt->close();
    }

    // Bước 3: Xóa chi tiết đơn hàng
    $delete = "DELETE FROM tbl_chitietdonhang WHERE donhang_id = ?";
    $stmt = $conn->prepare($delete);
    $stmt->bind_param("i", $donhang_id);
    $stmt->execute();
    $stmt->close();

    // Bước 4: Cập nhật trạng thái đơn hàng thành "Đã hủy"
    return $this->danhan_donhang($donhang_id, 'Đã hủy');
}
    //hoàn đơn//////////////////////////////////////////////////////////////////////////
    public function hoan_donhang($donhang_id) {
    $conn = $this->db->connect();

    // 1. Lấy thời gian đặt đơn hàng
    $query_time = "SELECT thoigian FROM tbl_donhang WHERE donhang_id = ?";
    $stmt = $conn->prepare($query_time);
    if (!$stmt) {
        die("Lỗi lấy thời gian đơn hàng: " . $conn->error);
    }
    $stmt->bind_param("i", $donhang_id);
    $stmt->execute();
    $stmt->bind_result($thoigian);
    if (!$stmt->fetch()) {
        $stmt->close();
        return "Không tìm thấy đơn hàng.";
    }
    $stmt->close();

    // 2. Kiểm tra thời gian quá 7 ngày hay chưa
    $order_time = strtotime($thoigian);
    $now = time();
    if (($now - $order_time) > (7 * 86400)) { // 7 ngày * 86400 giây
        return "Đơn hàng đã quá 7 ngày, không thể hoàn trả.";
    }

    // 3. Lấy chi tiết đơn hàng
    $query_detail = "SELECT product_ma, product_soluong FROM tbl_chitietdonhang WHERE donhang_id = ?";
    $stmt = $conn->prepare($query_detail);
    if (!$stmt) {
        die("Lỗi lấy chi tiết đơn hàng: " . $conn->error);
    }
    $stmt->bind_param("i", $donhang_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $chitiet = [];
    while ($row = $result->fetch_assoc()) {
        $chitiet[] = $row;
    }
    $stmt->close();

    // 4. Cập nhật số lượng sản phẩm
    foreach ($chitiet as $sp) {
        $update_product = "UPDATE tbl_product 
            SET product_soluong = product_soluong + ?, 
                product_daban = product_daban - ?
            WHERE product_ma = ?";
        $stmt = $conn->prepare($update_product);
        if (!$stmt) {
            die("Lỗi cập nhật sản phẩm: " . $conn->error);
        }
        $stmt->bind_param("iis", $sp['product_soluong'], $sp['product_soluong'], $sp['product_ma']);
        $stmt->execute();
        $stmt->close();
    }

    // 5. Xóa chi tiết đơn hàng
    $delete_detail = "DELETE FROM tbl_chitietdonhang WHERE donhang_id = ?";
    $stmt = $conn->prepare($delete_detail);
    $stmt->bind_param("i", $donhang_id);
    $stmt->execute();
    $stmt->close();

    // 6. Cập nhật trạng thái và thời gian
    return $this->danhan_donhang($donhang_id, 'Đã hoàn đơn');
    }
    public function show_chitietdonhang($donhang_id) {
        $query = "SELECT * FROM tbl_chitietdonhang WHERE donhang_id = ?";
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            die("Lỗi chuẩn bị câu truy vấn: " . $this->db->connect()->error);
        }
        $stmt->bind_param("i", $donhang_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

}
?>