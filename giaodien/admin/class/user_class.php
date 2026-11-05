<?php
    include "database.php";
?>

<?php
class user {
    private $db;

    public function __construct() 
    {
        $this->db = new Database();
    }
    public function insert_user($user_taikhoan, $user_matkhau, $user_sdt, $user_quyen)
    {
        $check_query = "SELECT * FROM tbl_user WHERE user_taikhoan = '$user_taikhoan'";
        $check_result = $this->db->select($check_query);
        if ($check_result && $check_result->num_rows > 0) {
            $alert = "Thêm thất bại:Tên tài khoản đã tồn tại!";
            return $alert;
        } else {
            $query = "INSERT INTO tbl_user 
            (
            user_taikhoan,
            user_matkhau,
            user_sdt,
            user_quyen
            ) 
            VALUES 
            (
            '$user_taikhoan',
            '$user_matkhau',
            '$user_sdt',
            '$user_quyen'
            )";
            $result = $this->db->insert($query);
            header('location:userlist.php');
            return $result;
        }
    }
    public function show_user()
    {
        $query = "SELECT * FROM tbl_user ORDER BY user_id ASC";
        $result = $this->db->select($query);
        return $result;
    }
    public function get_user($user_id)
    {
        $query = "SELECT * FROM tbl_user WHERE user_id = '$user_id'";
        $result = $this->db->select($query);
        return $result;
    }
    public function update_user($user_taikhoan, $user_matkhau, $user_sdt,$user_quyen, $user_id)
    {
        $check_query = "SELECT * FROM tbl_user WHERE user_taikhoan = '$user_taikhoan' AND user_id != '$user_id'";
        $check_result = $this->db->select($check_query);

        if ($check_result && $check_result->num_rows > 0) {
            $alert = "Cập nhật thất bại:Tên tài khoản đã tồn tại!";
            return $alert;
        } 
        else 
        {
        $query = "UPDATE tbl_user SET 
        user_taikhoan = '$user_taikhoan',
        user_matkhau = '$user_matkhau',
        user_sdt = '$user_sdt',
        user_quyen = '$user_quyen'
        WHERE user_id = '$user_id'";
        $result = $this->db->update($query);
        header('location:userlist.php');
        return $result;
        }
    }
    public function delete_user($user_id)
    {
        $query = "DELETE FROM tbl_user WHERE user_id = '$user_id'";
        $result = $this->db->delete($query);
        header('location:userlist.php');
        return $result;
    }
}
?>
