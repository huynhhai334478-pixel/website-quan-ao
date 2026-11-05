<?php
    include "database.php";
?>

<?php
class donhang {
    private $db;

    public function __construct() 
    {
        $this->db = new Database();
    }
    public function show_choduyet()
    {
        $query = "SELECT * FROM tbl_donhang WHERE tinhtrang = 'Chờ duyệt' ORDER BY donhang_id ASC";
        $result = $this->db->select($query);
        return $result;
    }
    public function show_danggiao()
    {
        $query = "SELECT * FROM tbl_donhang WHERE tinhtrang = 'Đang giao' ORDER BY donhang_id ASC";
        $result = $this->db->select($query);
        return $result;
    }
    public function show_dagiao()
    {
        $query = "SELECT * FROM tbl_donhang WHERE tinhtrang = 'Đã giao' ORDER BY donhang_id ASC";
        $result = $this->db->select($query);
        return $result;
    }
    public function show_hoanthanh()
    {
        $query = "SELECT * FROM tbl_donhang WHERE tinhtrang = 'Hoàn thành' ORDER BY donhang_id ASC";
        $result = $this->db->select($query);
        return $result;
    }
    public function show_chitietdonhang()
    {
        $query = "SELECT * FROM tbl_chitietdonhang ORDER BY idchitiet ASC";
        $result = $this->db->select($query);
        return $result;
    }
    public function update_danggiao($donhang_id, $tinhtrang) {
        $query = "UPDATE tbl_donhang SET tinhtrang = ? WHERE donhang_id = ?";
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            die("Lỗi chuẩn bị câu truy vấn: " . $this->db->connect()->error);
        }
        $stmt->bind_param("si", $tinhtrang, $donhang_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
    public function update_hoanthanh($donhang_id, $tinhtrang) {
        $query = "UPDATE tbl_donhang SET tinhtrang = ? WHERE donhang_id = ?";
        $stmt = $this->db->prepare($query);
        if (!$stmt) {
            die("Lỗi chuẩn bị câu truy vấn: " . $this->db->connect()->error);
        }
        $stmt->bind_param("si", $tinhtrang, $donhang_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
    public function get_doanhthu() {
        $query = "SELECT MONTH(thoigian) AS month, SUM(sotien) AS total
                FROM tbl_donhang
                WHERE tinhtrang = 'Hoàn thành'
                GROUP BY MONTH(thoigian)";
        $result = $this->db->select($query);

        $doanhthu = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $doanhthu[$row['month']] = $row['total'];
            }
        }
        return $doanhthu;
    }
    //tổng users, products, đơn hàng
    public function getTotalUsers() {
        $query = "SELECT COUNT(*) as total_users FROM tbl_user";
        return $this->db->select($query);
    }

    public function getTotalProducts() {
        $query = "SELECT COUNT(*) as total_products FROM tbl_product";
        return $this->db->select($query);
    }

    public function getTotalOrders() {
        $query = "SELECT COUNT(*) as total_orders FROM tbl_donhang";
        return $this->db->select($query);
    }
}
?>