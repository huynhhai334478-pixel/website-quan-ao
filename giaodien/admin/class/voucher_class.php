<?php
    include "database.php";
?>

<?php
class voucher {
    private $db;

    public function __construct() 
    {
        $this->db = new Database();
    }
    public function insert_voucher($tenvoucher, $loaigiam, $giagiam, $slvoucher)
    {
        $check_query = "SELECT * FROM tbl_voucher WHERE tenvoucher = '$tenvoucher'";
        $check_result = $this->db->select($check_query);
        if ($check_result && $check_result->num_rows > 0) {
            $alert = "Thêm thất bại:Tên voucher đã tồn tại!";
            return $alert;
        } 
        if ($loaigiam === "PHẦN TRĂM" && floatval($giagiam) > 100) {
            $alert = "Thêm thất bại: Giảm phần trăm không được vượt quá 100!";
            return $alert;
        }
            $query = "INSERT INTO tbl_voucher  
            (
            tenvoucher,
            loaigiam,
            giagiam,
            slvoucher
            ) 
            VALUES 
            (
            '$tenvoucher',
            '$loaigiam',
            '$giagiam',
            '$slvoucher'
            )";
            $result = $this->db->insert($query);
            header('location:voucherlist.php');
            return $result;
    }
    public function show_voucher()
    {
        $query = "SELECT * FROM tbl_voucher ORDER BY idvoucher ASC";
        $result = $this->db->select($query);
        return $result;
    }
    public function get_voucher($idvoucher)
    {
        $query = "SELECT * FROM tbl_voucher WHERE idvoucher = '$idvoucher'";
        $result = $this->db->select($query);
        return $result;
    }
    public function update_voucher($tenvoucher, $loaigiam, $giagiam,$slvoucher, $idvoucher)
    {
        $check_query = "SELECT * FROM tbl_voucher WHERE tenvoucher = '$tenvoucher' AND idvoucher != '$idvoucher'";
        $check_result = $this->db->select($check_query);

        if ($check_result && $check_result->num_rows > 0) {
            $alert = "Cập nhật thất bại:Tên voucher đã tồn tại!";
            return $alert;
        } 
        else 
        {
        $query = "UPDATE tbl_voucher SET 
        tenvoucher = '$tenvoucher',
        loaigiam = '$loaigiam',
        giagiam = '$giagiam',
        slvoucher = '$slvoucher'
        WHERE idvoucher = '$idvoucher'";
        $result = $this->db->update($query);
        header('location:voucherlist.php');
        return $result;
        }
    }
    public function delete_voucher($idvoucher)
    {
        $query = "DELETE FROM tbl_voucher WHERE idvoucher = '$idvoucher'";
        $result = $this->db->delete($query);
        header('location:voucherlist.php');
        return $result;
    }
}
?>
