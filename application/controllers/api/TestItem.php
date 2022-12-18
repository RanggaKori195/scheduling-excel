<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
//use Restserver\Libraries\REST_Controller;
require APPPATH.'libraries/REST_Controller.php';
require APPPATH.'libraries/Format.php';
header('Access-Control-Allow-Origin: *'); 
	header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
class Testitem extends REST_Controller{

    public function __construct(){
        parent::__construct();
        
        //load database
        $this->load->database();
        $this->load->model(array("api/Testitem_model"));
        $this->load->library(array("form_validation"));
        //$this->load->helper("security");
      }


      public function testAll_get()
      {
        $data = $this->Testitem_model->get_testitem_all();
        if (isset($_SERVER['HTTP_ORIGIN'])) {
          // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
          // you want to allow, and if so:
          header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
          header('Access-Control-Allow-Credentials: true');
          header('Access-Control-Max-Age: 86400');    // cache for 1 day
      }
          // Access-Control headers are received during OPTIONS requests
      if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

          if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
              // may also be using PUT, PATCH, HEAD etc
              header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

          if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
              header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

          exit(0);
      }
      
        if(count($data) > 0){
            $this->response(array(
              "success" => true,
              "data" => $data
            ) , REST_Controller::HTTP_OK);
          }else{
            $this->response(array(
              "success" => false,
              "data" => []
            ) , REST_Controller::HTTP_OK);
          }
      }

      public function testheaderbycode_get()
      {
        $TestCode = $this->input->get('TestCode');
        $data = $this->Testitem_model->get_testitem_header_by_code($TestCode);
        if(count($data) > 0){
            $this->response(array(
              "success" => true,
              "data" => $data
            ) , REST_Controller::HTTP_OK);
          }else{
            $this->response(array(
              "success" => false,
              "data" => []
            ) , REST_Controller::HTTP_BAD_REQUEST);
          }
      }

      public function testnilairujukanbycode_get()
      {
        $TestCode = $this->input->get('TestCode');
        $data = $this->Testitem_model->get_testitem_nilai_rujukan_by_code($TestCode);
        if(count($data) > 0){
            $this->response(array(
              'response' => 200,
              'status' => TRUE,
              "data" => $data
            ) , REST_Controller::HTTP_OK);
          }else{
            $this->response(array(
              'response' => 405,
              'status' => FALSE,
              "data" => []
            ) , REST_Controller::HTTP_OK);
          }
      }

      public function testnilaiprofilebycode_get()
      {
        $TestCode = $this->input->get('TestCode');
        $data = $this->Testitem_model->get_testitem_nilai_profile_by_code($TestCode);
        if(count($data) > 0){
            $this->response(array(
              'response' => 200,
              'status' => TRUE,
              "data" => $data
            ) , REST_Controller::HTTP_OK);
          }else{
            $this->response(array(
              'response' => 405,
              'status' => FALSE,
              "data" => []
            ) , REST_Controller::HTTP_OK);
          }
      }

      public function getcrossselling_get(){

        $TestCode = $this->input->get('TestCode');
        $data = $this->Testitem_model->get_cross_selling($TestCode);
        if(count($data) > 0){
            $this->response(array(
              'response' => 200,
              'status' => TRUE,
              "data" => $data
            ) , REST_Controller::HTTP_OK);
          }else{
            $this->response(array(
              'response' => 405,
              'status' => FALSE,
              "data" => []
            ) , REST_Controller::HTTP_OK);
          }
      }

      public function testextvaluebycode_get()
      {
        $TestCode = $this->input->get('TestCode');
        $data = $this->Testitem_model->get_testitem_ext_value_by_code($TestCode);
        if(count($data) > 0){
            $this->response(array(
              'response' => 200,
              'status' => TRUE,
              "data" => $data
            ) , REST_Controller::HTTP_OK);
          }else{
            $this->response(array(
              'response' => 405,
              'status' => FALSE,
              "data" => []
            ) , REST_Controller::HTTP_OK);
          }
      }

      public function datamateriklinis_get()
      {
        $data = $this->Testitem_model->get_data_materi_klinis();
        if(count($data) > 0){
            $this->response(array(
              "success" => true,
              "data" => $data
            ) , REST_Controller::HTTP_OK);
          }else{
            $this->response(array(
              "success" => false,
              "data" => []
            ) , REST_Controller::HTTP_BAD_REQUEST);
          }
      }

      public function insertNewInformationLain_post()
      {
       
        foreach ($this->post('no') as $key => $val){
          $data_detail[] = array(
            'TEST_OTHER_CODE'=>$this->post('TEST_CODE'),
            'Harga'=>$this->post('harga')[$key],
            'Umur'=>$this->post('umur')[$key],
            'BB'=>$this->post('BB')[$key],
            'Keterangan'=>$this->post('Keterangan')[$key],
            'KriteriaJenisSample_Diagnosa'=>$this->post('KriteriaJenisSample_Diagnosa')[$key],
            'Minimal'=>$this->post('Minimal')[$key],
            'Maximal'=>$this->post('Maximal')[$key],
            'Tube'=>$this->post('Tube')[$key],
            'Stabilitas'=>$this->post('Stabilitas')[$key],
            'Puasa'=>$this->post('Puasa')[$key],
            'Hasil_Test'=>$this->post('Hasil_Test')[$key],
          );
            $update_test_item = $this->Testitem_model->updateTestItem($this->post('TEST_CODE'),$this->post('Puasa')[$key],$this->post('Stabilitas')[$key],$this->post('Tube')[$key]);
          }
          $insert = $this->Testitem_model->insertNewInformationLain($data_detail);
          if($insert){
            $this->response(array(
              'response' => 200,
              'status' => TRUE,
            ) , REST_Controller::HTTP_OK);
          }else{
            $this->response(array(
              'response' => 405,
              'status' => FALSE,
            ) , REST_Controller::HTTP_OK);
          }
      }

      public function datainformasilain_get()
      {
        $data = $this->Testitem_model->get_data_informasi_lain();
        if(count($data) > 0){
            $this->response(array(
              'response' => 200,
              'status' => TRUE,
              "data" => $data
            ) , REST_Controller::HTTP_OK);
          }else{
            $this->response(array(
              'response' => 405,
              'status' => FALSE,
              "data" => []
            ) , REST_Controller::HTTP_OK);
          }
      }


      public function insertNewMateriKlinis_post()
      {
        $this->load->library('upload');
        $config['upload_path'] = 'assets/materi_klinis';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf|PDF|doc|docx|JPG|JPEG|PNG|GIF|pptx';
        $config['max_size'] = '50000';
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('file')) {
            $error = array('error' => $this->upload->display_errors());
            $this->response([
                'status'    => 404,
                'response'  => false,
                'message'   => 'Upload Failed',
                'data'      => $error
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $data = array('upload_data' => $this->upload->data());
            $dataUpload = array(
                'file_name' => $data['upload_data']['file_name'],
                'file_type' => $data['upload_data']['file_type'],
                'status' => 'success',
            );
            $data = array(
              'ti_code'=>$this->post('ti_code'),
              'nama_materi_klinis'=>$this->post('nama_materi_klinis'),
              'file_materi_klinis'=>$dataUpload['file_name'],
            );
            $res = $this->Testitem_model->insert_new_materi_klinis($data);
            if($res){
              $this->response([
                  'status'    => 200,
                  'response'  => true,
                  'message'   => 'Insert Success',
                  'data'      => $data
              ], REST_Controller::HTTP_OK);
            }else{
              $this->response([
                  'status'    => 404,
                  'response'  => false,
                  'message'   => 'Insert Failed',
                  'data'      => $data
              ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
      }


}

?>