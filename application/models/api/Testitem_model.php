<?php 
class Testitem_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        $this->load->database();
      }


        public function get_testitem_all(){
            $this->db->select("data_test_item.TEST_REGULAR_PRICE,data_test_item.TEST_CODE,data_test_item.TEST_NAME,data_test_item.TEST_OTHER_CODE");
            $this->db->from("data_test_item");
            $this->db->where("data_test_item.TEST_NAME !=", "");
            $this->db->group_by("data_test_item.TEST_NAME");
            $this->db->order_by("data_test_item.TEST_NAME", "asc");
            $query = $this->db->get();
            return $query->result();
        }

        public function get_testitem_header_by_code($TestCode = "")
        {
            $this->db->select("A.TEST_CODE,A.TEST_NAME,A.TEST_STAT_TAT,A.TEST_ROUTINE_TAT,B.price_k2,C.test_group_name,D.unit_name,E.st_name,A.TEST_TUBE,A.TEST_STABILITAS,A.TEST_PUASA");
            $this->db->join("data_price B", "A.TEST_OTHER_CODE = B.p_code", "LEFT");
            $this->db->join("data_test_group C", "C.test_group_code = A.TEST_TEST_GROUP", "LEFT");
            $this->db->join("data_test_unit D", "D.unit_code = A.test_unit", "LEFT");
            $this->db->join("data_test_sample E", "E.st_code = A.test_sample_type", "LEFT");
            $this->db->from("data_test_item A");
            $this->db->where("A.TEST_CODE", $TestCode);
            $query = $this->db->get();
            return $query->row_array();
        }

        public function get_testitem_nilai_rujukan_by_code($TestCode = "")
        {

            $this->db->select("*");
            $this->db->from("data_normal_nilai_rujukan A");
            $this->db->where("A.tr_ti_code", $TestCode);
            $query = $this->db->get();
            return $query->result();
        }

        public function get_testitem_nilai_profile_by_code($TestCode  = "")
        {
            $this->db->select("*");
            $this->db->from("data_test_profile A");
            $this->db->where("A.tp_code", $TestCode);
            $query = $this->db->get();
            return $query->result();
        }

        public function get_testitem_ext_value_by_code($TestCode = "")
        {
            $this->db->select("*");
            $this->db->from("data_test_text_value A");
            $this->db->where("A.ttv_ti_code", $TestCode);
            $query = $this->db->get();
            return $query->result();
        }

        public function insert_new_materi_klinis($data = NULL)
        {
            $this->db->insert("data_materi_klinis", $data);
            return $this->db->insert_id();

        }

        public function get_data_materi_klinis()
        {
            $this->db->select("A.*,B.test_name");
            $this->db->join("data_test_item B", "A.ti_code = B.TEST_CODE", "LEFT");
            $this->db->from("data_materi_klinis A");
            $query = $this->db->get();
            return $query->result();
        }

        public function updateTestItem($TEST_OTHER_CODE = NULL,$TEST_PUASA = NULL,$TEST_STABILITAS = NULL,$TEST_TUBE = NULL){
            if($TEST_PUASA != NULL){
            $this->db->set("TEST_PUASA", $TEST_PUASA);
            }
            if($TEST_STABILITAS != NULL){
            $this->db->set("TEST_STABILITAS", $TEST_STABILITAS);
            }
            if($TEST_TUBE != NULL){
            $this->db->set("TEST_TUBE", $TEST_TUBE);
            }
            $this->db->where("TEST_CODE", $TEST_OTHER_CODE);
            $this->db->update("data_test_item");
            return $this->db->affected_rows();
        }

        public function insertNewInformationLain($data_detail = NULL)
        {
            $this->db->trans_begin(); 
            $this->db->trans_strict(TRUE);
            $this->db->insert_batch('data_test_item_detail',$data_detail);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            }else {
                $this->db->trans_commit();
                return true;
            }
        }

        public function get_data_informasi_lain()
        {
             $this->db->select("A.*,B.TEST_NAME");
             $this->db->join("data_test_item B", "A.TEST_OTHER_CODE = B.TEST_CODE", "LEFT");
                $this->db->from("data_test_item_detail A");
                $query = $this->db->get();
                return $query->result();
        }

        public function get_cross_selling($TestCode = NULL)
        {
            $this->db->select("A.TEST_CODE,A.TEST_NAME,A.TEST_STAT_TAT,A.TEST_ROUTINE_TAT,B.price_k2,C.test_group_name,D.unit_name,E.st_name,A.TEST_TUBE,A.TEST_STABILITAS,A.TEST_PUASA");
            $this->db->join("data_price B", "A.TEST_OTHER_CODE = B.p_code", "LEFT");
            $this->db->join("data_test_group C", "C.test_group_code = A.TEST_TEST_GROUP", "LEFT");
            $this->db->join("data_test_unit D", "D.unit_code = A.test_unit", "LEFT");
            $this->db->join("data_test_sample E", "E.st_code = A.test_sample_type", "LEFT");
            $this->db->join("data_test_item A", "A.TEST_CODE = F.test_code_h", "LEFT");
            $this->db->from("data_d_cross F");
            $this->db->where("F.test_code_h", $TestCode);
            $query = $this->db->get();
            return $query->result();
        }
}

?>