<?php 

header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type,innolab-key'); 
//use Restserver\Libraries\REST_Controller;
require APPPATH.'libraries/REST_Controller.php';
require APPPATH.'libraries/Format.php';
class Complaint extends REST_Controller{

    public function __construct(){
        parent::__construct();
        
        //load database
        $this->load->database();
        $this->load->model(array("api/Complaint_model"));
        $this->load->library(array("form_validation"));
        //$this->load->helper("security");
      }

      public function index_get()
      {

        $data = $this->Complaint_model->getDataAll();
        if(empty($data))
        {
            $this->response(array(
                "success" => false,
                "data" => []
            ) , REST_Controller::HTTP_OK);
        }else{
            $this->response(array(
                "success" => true,
                "data" => $data
            ) , REST_Controller::HTTP_OK);
        }

      }





}

?>