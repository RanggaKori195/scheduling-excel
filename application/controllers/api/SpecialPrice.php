<?php 
require APPPATH.'libraries/REST_Controller.php';
header('Access-Control-Allow-Origin: *'); 
	header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
class SpecialPrice extends REST_Controller{

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

    // GET: <project_url>/index.php/studentprice    
    public function index_get()
    {
        $Test_Code = $this->input->get("Test_Code");

        if($Test_Code != "")
        {
            $data = $this->Horder_model->get_special_price_by_code($Test_Code);

        }else
        {
            $data = [];
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
            ) , REST_Controller::HTTP_BAD_REQUEST);
          }

    }

  

}

?>