<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');

class HorderPasien extends REST_Controller{

  public function __construct(){

    parent::__construct();
    //load database
    $this->load->database();
    $this->load->model(array("api/Horder_model"));
    $this->load->library(array("form_validation"));
    $this->load->helper("security");
  }

  /*
    INSERT: POST REQUEST TYPE
    UPDATE: PUT REQUEST TYPE
    DELETE: DELETE REQUEST TYPE
    LIST: Get REQUEST TYPE
  */

  // GET: <project_url>/index.php/student
  public function index_get(){

   $TNO =  $this->input->get('TNO'); 
   $PID = $this->input->get('PID'); 
   $LAST_NAME =  $this->input->get('LAST_NAME'); 
   $NIKKTP =  $this->input->get('NIK');
   $arr_TNO = array();
   if($LAST_NAME != NULL){
    $data = $this->Horder_model->get_horder_header_by_TNO($TNO,$PID,$LAST_NAME,$NIKKTP);
    $dataMolekuler = $this->datamolekuler_get($TNO,$LAST_NAME);
    // if(count($data) > 0){
    // foreach($data as $row){
    //   $arr_TNO[] = $row['TNO'];
    // }
    // }
    //  if(!empty($arr_TNO)){
    // $data_test_group_by = $this->Horder_model->get_horder_detail_by_TNO_groupBY($arr_TNO);
    //  }else{
    // $data_test_group_by = array();
    //  }
    //$detail = $this->Horder_model->get_horder_detail_by_TNO($arr_TNO);
    $result_data = array(
      "header" => $data,
      //"detail_test_group_by" => $data_test_group_by,
      "detail_molekuler" => $dataMolekuler
      //"detail" => $detail
    );
    
    if(count($result_data) > 0){
      $this->response(array(
        'response' => 200,
        'status' => TRUE,
        "data" => $result_data
      ) , REST_Controller::HTTP_OK);
    }else{
      $this->response(array(
        "success" => false,
        "message" => "No data found"
      ) , REST_Controller::HTTP_OK);
    }

   }else{
    $this->response(array(
      "success" => false,
      "message" => "No data found"
    ) , REST_Controller::HTTP_OK);
   }
  }

  public function getdetailtest_get()
  {
    $TNO = $this->input->get('TNO');
    $data_test_group_by = $this->Horder_model->get_horder_detail_by_TNO_groupBY($TNO);
    $detail = $this->Horder_model->get_horder_detail_by_TNO($TNO);
    $data = array(
      "detail_test_group_by" => $data_test_group_by,
      "detail" => $detail
    );
    if(count($data_test_group_by) > 0 ){
      $this->response(array(
        'response' => 200,
        'status' => TRUE,
        "data" => $data
      ) , REST_Controller::HTTP_OK);
    }else{
      $this->response(array(
        "success" => false,
        "message" => "No data found",
        "data"=>[],
      ) , REST_Controller::HTTP_OK);
    }
  }

  public function datamolekuler_get($TNO = NULL ,$LAST_NAME = NULL)
  {
    $data = $this->Horder_model->get_data_pasien_molekuler($TNO,$LAST_NAME);
    if(count($data) > 0){
      $data = $data;
    }else{
      $data = [];
    }
    return $data;
  }

  public function checkNIK_get()
  {
    $NIK = $this->input->get('NIK');
    $data = $this->Horder_model->get_horder_header_by_NIK($NIK);
    if(count($data) > 0){
      $this->response(array(
        'response' => 200,
        'status' => TRUE,
        'message' => 'Data Found',
      ) , REST_Controller::HTTP_OK);
    }else{
      $this->response(array(
        'response' => 405,
        'status' => FALSE,
        'message' => 'Data Not Found',
      ) , REST_Controller::HTTP_OK);
    }
  }

  public function checkPID_get()
  {
    $PID = $this->input->get('PID');
    $data = $this->Horder_model->get_horder_header_by_PID($PID);
    if(count($data) > 0){
      $this->response(array(
        'response' => 200,
        'status' => TRUE,
        'message' => 'Data Found',
      ) , REST_Controller::HTTP_OK);
    }else{
      $this->response(array(
        'response' => 405,
        'status' => FALSE,
        'message' => 'Data Not Found',
      ) , REST_Controller::HTTP_OK);
    }
  }

  public function checkKalgenID_get()
  {
    $KalgenID = $this->input->get('KalgenID');
    $checking = 0;
    $data = $this->Horder_model->get_horder_header_by_KalgenID($KalgenID);
    $data_molekuler = $this->Horder_model->get_molekuler_by_KalgenID($KalgenID);

    if(count($data) > 0){
      $checking = 1;
    }elseif (count($data_molekuler) > 0) {
      $checking = 1;
    }else{
      $checking = 0;
    }
      
    if($checking > 0){
      $this->response(array(
        'response' => 200,
        'status' => TRUE,
        'message' => 'Data Found',
      ) , REST_Controller::HTTP_OK);
    }else{
      $this->response(array(
        'response' => 405,
        'status' => FALSE,
        'message' => 'Data Not Found',
      ) , REST_Controller::HTTP_OK);
    }
  }

  public function checkNamaPasien_get()
  {
    $NamaPasien = $this->input->get('NamaPasien');
    $checking = 0;
    $data = $this->Horder_model->get_horder_header_by_NamaPasien($NamaPasien);
    $data_molekuler = $this->Horder_model->get_molekuler_by_NamaPasien($NamaPasien);

    if(count($data) > 0){
      $checking = 1;
    }elseif (count($data_molekuler) > 0) {
      $checking = 1;
    }else{
      $checking = 0;
    }

    if($checking > 0){
      $this->response(array(
        'response' => 200,
        'status' => TRUE,
        'message' => 'Data Found',
      ) , REST_Controller::HTTP_OK);
    }else{
      $this->response(array(
        'response' => 405,
        'status' => FALSE,
        'message' => 'Data Not Found',
      ) , REST_Controller::HTTP_OK);
    }
  }



}

 ?>
