<?php 
class Molekuler_model extends CI_Model{

    public function __construct(){
        parent::__construct();
        $this->load->database();
      }

      public function get_molekuler_data(){
        $this->db->limit(1000);
        $this->db->select("Clinician,Pathologist,Account,City,Patient,Age,Sex,Clinical_Diagnosis,KalgenInnolabID,Date_Received,Date_of_Result_Out_SendtoCostumer,Result_Makroskopik,TestStatus");
        $this->db->from("data_molekuler_excel");
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result();
      }

      public function get_molekuler_data_by_teststatus($teststatus = NULL) 
      {
        $this->db->select("Clinician,Pathologist,Account,City,Patient,Age,Sex,Clinical_Diagnosis,KalgenInnolabID,Date_Received,Date_of_Result_Out_SendtoCostumer,Result_Makroskopik,TestStatus");
        $this->db->from("data_molekuler_excel");
        $this->db->where("TestStatus", $teststatus);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result();
      }

      public function get_molekuler_data_by_rangedate($datenow = NULL , $datelast = NULL)
      {
        $this->db->select("Clinician,Pathologist,Account,City,Patient,Age,Sex,Clinical_Diagnosis,KalgenInnolabID,Date_Received,Date_of_Result_Out_SendtoCostumer,Result_Makroskopik,TestStatus");
        $this->db->from("data_molekuler_excel");
        $this->db->where("Date_Received >=", $datenow);
        $this->db->where("Date_Received <=", $datelast);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result();
      }

      public function get_molekuler_data_by_allfilter($teststatus = NULL , $datenow = NULL , $datelast = NULL)
      {
  
        $this->db->select("Clinician,Pathologist,Account,City,Patient,Patient_Singkatan,Age,Sex,Clinical_Diagnosis,KalgenInnolabID,Date_Received,Date_of_Result_Out_SendtoCostumer,VoucherNumber,Result_Makroskopik,TestStatus,Test");
        $this->db->from("data_molekuler_excel_dev");
        $this->db->where("TestStatus", $teststatus);
        $this->db->where("Date_Received >=", $datenow);
        $this->db->where("Date_Received <=", $datelast);
        $this->db->order_by("id", "desc");
        $query = $this->db->get();
        return $query->result();
      }

      public function get_molekuler_teststatus()
      {
        $this->db->select("TestStatus");
        $this->db->from("data_molekuler_excel_dev");
        $this->db->group_by('TestStatus');
        $query = $this->db->get();
        return $query->result();
      }

      public function get_data_account()
      {
        $this->db->select("*");
        $this->db->from("data_account");
        $query = $this->db->get();
        return $query->result();
      }

      public function get_data_detail_account($account = NULL)
      {
        $this->db->select("A.*,B.nama_account");
        $this->db->join("data_account B", "A.id_account = B.id");
        $this->db->from("data_detail_account A");
        $query = $this->db->get();
        return $query->result();
      }

      public function insert_data_detail_account($data = NULL)
      {
        $this->db->insert("data_detail_account", $data);
        return $this->db->insert_id();
      }

      public function get_status_by_account($account)
      {
        $this->db->select("A.test_status as TestStatus");
        $this->db->join("data_account B", "A.id_account = B.id");
        $this->db->from("data_detail_account A");
        $this->db->where("B.nama_account", $account);
        $query = $this->db->get();
        return $query->result();
      }


}



?>