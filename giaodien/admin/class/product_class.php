<?php
    include "database.php";
?>

<?php
class product {
    private $db;

    public function __construct() 
    {
        $this->db = new Database();
    }
    public function insert_product()
    {   
        $product_name = $_POST['product_name'];
        $product_ma = $_POST['product_ma'];
        $category_id = $_POST['category_id'];
        $brand_id = $_POST['brand_id'];
        $product_price = $_POST['product_price'];
        $product_soluong = $_POST['product_soluong'];
        $product_desc = $_POST['product_desc'];
        $product_img = $_FILES['product_img']['name'];
        $filetarget = basename($_FILES['product_img']['name']);
        $filetype = strtolower(pathinfo($product_img, PATHINFO_EXTENSION));

        // Kiểm tra trùng product_ma
        $check_ma_query = "SELECT * FROM tbl_product WHERE product_ma = '$product_ma'";
        $check_ma_result = $this->db->select($check_ma_query);

        if ($check_ma_result && $check_ma_result->num_rows > 0) {
            $alert = "Thêm thất bại: Mã sản phẩm đã tồn tại!";
            return $alert;
        }

        // Kiểm tra trùng tên theo danh mục và thương hiệu
        $check_query = "SELECT * FROM tbl_product WHERE category_id = '$category_id' AND brand_id = '$brand_id' AND product_name = '$product_name'";
        $check_result = $this->db->select($check_query);

        if ($check_result && $check_result->num_rows > 0) {
            $alert = "Thêm thất bại: Tên sản phẩm đã tồn tại!";
            return $alert;
        }

        // Kiểm tra file ảnh
        if (file_exists("uploads/$filetarget")) {
            $alert = "File đã tồn tại!";
            return $alert;
        } else {
            if ($filetype != "jpg" && $filetype != "png" && $filetype != "jpeg" && $filetype != "webp") {
                $alert = "Chỉ được chọn file jpg, png, jpeg, webp!";
                return $alert;
            } else {
                move_uploaded_file($_FILES['product_img']['tmp_name'], __DIR__ . '/uploads/' . $product_img);
                
                $query = "INSERT INTO tbl_product
                (
                    product_name,
                    product_ma,
                    category_id,
                    brand_id,
                    product_price,
                    product_soluong,
                    product_desc,
                    product_img
                )
                VALUES
                (
                    '$product_name',
                    '$product_ma',
                    '$category_id',
                    '$brand_id',
                    '$product_price',
                    '$product_soluong',
                    '$product_desc',
                    '$product_img'
                )";

                $result = $this->db->insert($query);
            }
        }

        header('location:productlist.php');
        return $result;
    }

    public function show_category()
    {
        $query = "SELECT * FROM tbl_category ORDER BY category_id DESC";
        $result = $this->db->select($query);
        return $result;
    }
    public function show_product()
    {
        $query = "SELECT tbl_product.*, tbl_brand.brand_name, tbl_category.category_name 
                FROM tbl_product 
                INNER JOIN tbl_brand ON tbl_product.brand_id = tbl_brand.brand_id
                INNER JOIN tbl_category ON tbl_product.category_id = tbl_category.category_id
                ORDER BY tbl_product.product_id ASC";
        $result = $this->db->select($query);
        return $result;
    }



    public function get_products_by_category_and_brand($category_id, $brand_id) 
    {
        $query = "SELECT * FROM tbl_product WHERE category_id = '$category_id' AND brand_id = '$brand_id'";
        $result = $this->db->select($query); // Lấy kết quả từ cơ sở dữ liệu
        return $result;
    }

    public function show_brand_ajax($category_id)

    {
        $query = "SELECT * FROM tbl_brand WHERE category_id = '$category_id'";
        $result = $this->db->select($query);
        return $result;
    }
    public function get_product($product_id)
    {
        $query = "SELECT * FROM tbl_product WHERE product_id = '$product_id'";
        $result = $this->db->select($query);
        return $result;
    }
    public function update_product($product_name, $product_ma, $category_id, $brand_id, $product_price, $product_desc, $product_img, $product_id)
    {
        // Kiểm tra trùng tên sản phẩm trong cùng danh mục và thương hiệu, trừ chính sản phẩm đang sửa
        $check_name_query = "SELECT * FROM tbl_product 
                            WHERE product_name = '$product_name' 
                            AND category_id = '$category_id' 
                            AND brand_id = '$brand_id' 
                            AND product_id != '$product_id'";
        $check_name_result = $this->db->select($check_name_query);

        if ($check_name_result && $check_name_result->num_rows > 0) {
            return "Cập nhật thất bại: Tên sản phẩm đã tồn tại!";
        }

        // Kiểm tra trùng mã sản phẩm, trừ chính sản phẩm đang sửa
        $check_ma_query = "SELECT * FROM tbl_product 
                        WHERE product_ma = '$product_ma' 
                        AND product_id != '$product_id'";
        $check_ma_result = $this->db->select($check_ma_query);

        if ($check_ma_result && $check_ma_result->num_rows > 0) {
            return "Cập nhật thất bại: Mã sản phẩm đã tồn tại!";
        }

        // Cập nhật sản phẩm
        $query = "UPDATE tbl_product SET 
                    product_name = '$product_name',
                    product_ma = '$product_ma',
                    category_id = '$category_id',
                    brand_id = '$brand_id',
                    product_price = '$product_price',
                    product_desc = '$product_desc',
                    product_img = '$product_img'
                WHERE product_id = '$product_id'";

        $result = $this->db->update($query);
        header('Location: productlist.php');
        return $result;
    }


    public function delete_product($product_id)
    {
        $query = "DELETE FROM tbl_product WHERE product_id = '$product_id'";
        $result = $this->db->delete($query);
        header('location:productlist.php');
        return $result;
    }
    public function get_brands_by_category($category_id) 
    {
        $query = "SELECT * FROM tbl_brand WHERE category_id = '$category_id' ORDER BY brand_name ASC";
        $result = $this->db->select($query); // Lấy kết quả từ cơ sở dữ liệu
        return $result;
    }
    public function show_productkho()
    {
        $query = "SELECT * FROM tbl_product ORDER BY product_id ASC";
        $result = $this->db->select($query);
        return $result;
    }
    public function update_soluong($product_id, $soluong_them) {
    $product_id = intval($product_id);
    $soluong_them = intval($soluong_them);

    $query = "UPDATE tbl_product SET product_soluong = product_soluong + $soluong_them WHERE product_id = $product_id";
    $result = $this->db->update($query);
    return $result;
    }
    public function show_binhluan()
    {
        $query = "SELECT * FROM tbl_binhluan ORDER BY idbinhluan DESC";
        $result = $this->db->select($query);
        return $result;
    }
    public function delete_binhluan($idbinhluan)
    {
        $idbinhluan = intval($idbinhluan);
        $query = "DELETE FROM tbl_binhluan WHERE idbinhluan = '$idbinhluan'";
        $result = $this->db->delete($query);
        header('location:binhluanlist.php');
        return $result;
    }
}
?>
