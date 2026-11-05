<?php
    include "database.php";
?>

<?php
class brand {
    private $db;

    public function __construct() 
    {
        $this->db = new Database();
    }
    public function insert_brand($category_id, $brand_name)
    {
        $check_query = "SELECT * FROM tbl_brand WHERE category_id = '$category_id' AND brand_name = '$brand_name'";
        $check_result = $this->db->select($check_query);
        if ($check_result && $check_result->num_rows > 0) {
            $alert = "Thêm thất bại: Loại sản phẩm đã tồn tại trong danh mục này!";
            return $alert;
        } else {
            $query = "INSERT INTO tbl_brand (category_id, brand_name) VALUES ('$category_id', '$brand_name')";
            $result = $this->db->insert($query);
            header('location:brandlist.php');
            return $result;
        }
    }
    public function show_category()
    {
        $query = "SELECT * FROM tbl_category ORDER BY category_id DESC";
        $result = $this->db->select($query);
        return $result;
    }
    public function show_brand()
    {
        $query = "SELECT tbl_brand.*,tbl_category.category_name 
        FROM tbl_brand INNER JOIN tbl_category 
        ON tbl_brand.category_id = tbl_category.category_id
        ORDER BY tbl_brand.brand_id ASC";
        $result = $this->db->select($query);
        return $result;
    }
    public function get_brand($brand_id)
    {
        $query = "SELECT * FROM tbl_brand WHERE brand_id = '$brand_id'";
        $result = $this->db->select($query);
        return $result;
    }
    public function update_brand($category_id, $brand_name, $brand_id)
    {
        $check_query = "SELECT * FROM tbl_brand WHERE brand_name = '$brand_name' AND category_id = '$category_id' AND brand_id != '$brand_id'";
        $check_result = $this->db->select($check_query);
        if ($check_result && $check_result->num_rows > 0) 
        {
            $alert = "Cập nhật thất bại: Loại sản phẩm đã tồn tại trong danh mục này!";
            return $alert;
        } else 
        {
            $query = "UPDATE tbl_brand SET brand_name = '$brand_name', category_id = '$category_id' WHERE brand_id = '$brand_id'";
            $result = $this->db->update($query);
            header('location:brandlist.php');
            return $result;
        }
    }
    public function delete_brand($brand_id)
    {
        $query = "DELETE FROM tbl_brand WHERE brand_id = '$brand_id'";
        $result = $this->db->delete($query);
        header('location:brandlist.php');
        return $result;
    }
}
?>
