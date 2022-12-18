<?php 
class Complaint_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        $this->load->database();
      }

      public function getDataAll(){
        $this->db->select("*");
        $this->db->from("data_complaint_km");
        $query = $this->db->get();
        return $query->result_array();
      }
}

?>