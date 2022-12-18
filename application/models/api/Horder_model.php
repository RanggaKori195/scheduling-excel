<?php

class Horder_model extends CI_Model{

  public function __construct(){
    parent::__construct();
    $this->load->database();
  }

  public function get_horder_header(){

    $this->db->select("*");
    $this->db->from("data_horder_header_july");
    $query = $this->db->get();
    return $query->result();
  }

  public function get_horder_header_by_TNO($TNO =NULL,$PID = NULL,$LAST_NAME = NULL,$NIKKTP = NULL){
      $this->db->select("A.TNO,A.TRX_DT,A.PID,A.LAST_NAME,A.PATADDR1,A.SEX,A.BOD,A.AGE_YY,A.DCODE,A.CLINIC_CODE,CONCAT(A.DIAG1,' ',A.DIAG2) as DIAG ,A.PCMT,A.OUTSRC,B.CLINIC_DESC,C.RESOURCE_NAME as DOC_NAME");
      //join
      $this->db->join("data_clinic B", "A.CLINIC_CODE = B.CLINIC_CODE", "BOTH");
      $this->db->join("hfresource C", "A.DCODE = C.RESOURCE_CODE", "BOTH");
      $this->db->from("data_horder_header A");
      $this->db->where("A.LAST_NAME", $LAST_NAME);
      if($TNO != NULL){
        $this->db->or_where("A.TNO", $TNO);
      }
      if($PID != NULL){
        $this->db->or_where("A.PID", $PID);
      }
      if($NIKKTP != NULL){
        $this->db->or_where("A.NIKKTP", $NIKKTP);
      }
      $query = $this->db->get();
      return $query->result_array();
  }

  public function get_horder_detail_by_TNO_groupBY($TNO = NULL){
    $this->db->select("A.TEST_GRP,A.VALIDATE_ON,B.test_group_name,B.test_group_other_name");
    //join 
    $this->db->join("data_test_group B", "A.TEST_GRP = B.test_group_code", "BOTH");
    $this->db->from("data_horder_detail A");
    //$this->db->where_in("A.TNO", $arr_TNO);
    $this->db->where("A.TNO", $TNO);
    $this->db->group_by('TEST_GRP');
    $query = $this->db->get();
    return $query->result();
  }

  public function get_horder_detail_by_TNO($TNO = NULL){
    $this->db->select("A.*,B.test_group_name,C.TEST_NAME");
    $this->db->join("data_test_group B", "A.TEST_GRP = B.test_group_code", "BOTH");
    $this->db->join("data_test_item C", "A.TESTCODE = C.TEST_CODE", "BOTH");
    $this->db->from("data_horder_detail A");
    //$this->db->where_in("A.TNO", $arr_TNO);
    $this->db->where("A.TNO", $TNO);
    $this->db->order_by("A.TEST_GRP", "asc");
    $query = $this->db->get();
    return $query->result();
  }

  public function get_special_price_by_code($Test_Code)
  {
    $this->db->select("*");
    $this->db->from("data_special_price");
    $this->db->where("Test_Code", $Test_Code);
    $query = $this->db->get();
    return $query->row_array();
  }


  public function get_horder_header_by_NIK($NIK){
    $this->db->select("*");
    $this->db->from("data_horder_header");
    $this->db->where("NIKKTP", $NIK);
    $query = $this->db->get();
    return $query->result();
  }

  public function get_horder_header_by_PID($PID){
    $this->db->select("*");
    $this->db->from("data_horder_header");
    $this->db->where("PID", $PID);
    $query = $this->db->get();
    return $query->result();
  }

  public function get_horder_header_by_KalgenID($KalgenID){
    $this->db->select("*");
    $this->db->from("data_horder_header");
    $this->db->where("TNO", $KalgenID);
    $query = $this->db->get();
    return $query->result();
  }

  public function get_molekuler_by_KalgenID($KalgenID){
    $this->db->select("KalgenInnolabID");
    $this->db->from("data_molekuler_excel");
    $this->db->where("KalgenInnolabID", $KalgenID);
    $query = $this->db->get();
    return $query->row_array();
  }

  public function get_horder_header_by_NamaPasien($NamaPasien)
  {
    $this->db->select("*");
    $this->db->from("data_horder_header");
    $this->db->like("LAST_NAME", $NamaPasien);
    $query = $this->db->get();
    return $query->result();
  }

  public function get_molekuler_by_NamaPasien($NamaPasien)
  {
    $this->db->select("Patient");
    $this->db->from("data_molekuler_excel");
    $this->db->like("Patient", $NamaPasien);
    $query = $this->db->get();
    return $query->row_array();
  }

  public function get_data_pasien_molekuler($KalgenID = NULL , $LAST_NAME = NULL)
  {
    $this->db->select("*");
    $this->db->from("data_molekuler_excel");
    $this->db->where("Patient", $LAST_NAME);
    $this->db->or_where("KalgenInnolabID", $KalgenID);
    $query = $this->db->get();
    return $query->result();
  }


}

 ?>
