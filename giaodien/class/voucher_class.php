<?php
class voucher {
    private $db;

    public function __construct() 
    {
        $this->db = new Database();
    }
    public function show_voucher()
    {
        $query = "SELECT * FROM tbl_voucher ORDER BY idvoucher ASC";
        $result = $this->db->select($query);
        return $result;
    }
    public function useVoucher($idvoucher) {
        $idvoucher = intval($idvoucher);
        $sql = "UPDATE tbl_voucher 
                SET slvoucher = slvoucher - 1, luotdung = luotdung + 1 
                WHERE idvoucher = $idvoucher AND slvoucher > 0";

        return $this->db->update($sql);
    }

}