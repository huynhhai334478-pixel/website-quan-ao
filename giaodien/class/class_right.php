<?php
class product {
    private $db;
    public function __construct() 
    {
        $this->db = new Database();
    }
    // public function show_brand()
    // {
    //     $query = "SELECT tbl_brand.*, tbl_category.category_name 
    //             FROM tbl_brand 
    //             INNER JOIN tbl_category 
    //             ON tbl_brand.category_id = tbl_category.category_id 
    //             ORDER BY tbl_brand.category_id ASC, tbl_brand.brand_id ASC";
    //     $result = $this->db->select($query);
    //     return $result;
    // }
}
?>