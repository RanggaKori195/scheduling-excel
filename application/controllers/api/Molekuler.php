<?php 
require APPPATH.'libraries/REST_Controller.php';
header('Access-Control-Allow-Origin: *'); 
	header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
require_once 'vendor/autoload.php';


class Molekuler extends REST_Controller{

    public function __construct(){

        parent::__construct();
        //load database
        $this->load->database();
        $this->load->model(array("api/Molekuler_model"));
        $this->load->library(array("form_validation"));
        $this->load->helper("security");
      }


      public function index_get(){
        $TestStatus = $this->input->get('TestStatus');
        $Date_Received_Now = $this->input->get('Date_Received_Now');
        $Date_Received_last = $this->input->get('Date_Received_last');
 
        $data = $this->Molekuler_model->get_molekuler_data_by_allfilter($TestStatus, $Date_Received_Now, $Date_Received_last);
        if(count($data) > 0){
            $this->response(array(
              "success" => true,
              "data" => $data
            ) , REST_Controller::HTTP_OK);
          }else{
            $this->response(array(
              "success" => false,
              "data" => []
            ) ,  REST_Controller::HTTP_OK);
          }
    }


    public function getTestStatus_get(){
        $account = $this->input->get("account");
        if($account != "")
        {
        $data = $this->Molekuler_model->get_status_by_account($account);
        }else {
        $data = $this->Molekuler_model->get_molekuler_teststatus();
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
            ) ,  REST_Controller::HTTP_OK);
          }
    }

    public function getAccount_get()
    {
      $data = $this->Molekuler_model->get_data_account();
      if(count($data) > 0){
          $this->response(array(
            "success" => true,
            "data" => $data
          ) , REST_Controller::HTTP_OK);
        }else{
          $this->response(array(
            "success" => false,
            "data" => []
          ) ,  REST_Controller::HTTP_OK);
        }
    }

    public function getDetailAccount_get()
    {
      $data = $this->Molekuler_model->get_data_detail_account();
      if(count($data) > 0){
          $this->response(array(
            "success" => true,
            "data" => $data
          ) , REST_Controller::HTTP_OK);
        }else{
          $this->response(array(
            "success" => false,
            "data" => []
          ) ,  REST_Controller::HTTP_OK);
        }
    }

    public function insertData_post()
    {

      $data = array(
        'id_account' => $this->post('id_account'),
        'test_status' => $this->post('test_status'),
      );
      $result = $this->Molekuler_model->insert_data_detail_account($data);
      if(count($result) > 0){
          $this->response(array(
            "success" => true,
          ) , REST_Controller::HTTP_OK);
        }else{
          $this->response(array(
            "success" => false,
            "data" => []
          ) ,  REST_Controller::HTTP_OK);
        }
    }

    public function getDataExcel_get()
    {
      $client = new Google\Client();
$client->setApplicationName('RestAPIMolekuler');
$client->setScopes('https://www.googleapis.com/auth/spreadsheets');
$client->setAuthConfig('credentials.json');
$client->setAccessType('offline');
$client->setPrompt('select_account consent');
$service = new Google\Service\Sheets($client);
$spreadsheetId = '1MGfOfeG-Xhbb9WzjYgNt2tnBljxnaOW6MTctFpOTYT0';
$range = 'Jun 2022!A4:BB';
$response = $service->spreadsheets_values->get($spreadsheetId, $range);
$values = $response->getValues();
$finalItems = [];
foreach ($values as $key => $value) {
    $isiFinalItem = [];
    $isiFinalItem['KalgenInnolabID'] = $value[0] ?? 'N/A';
    $isiFinalItem['Clinician'] = $value[1] ?? 'N/A';
    $isiFinalItem['Pathologist'] =  $value[2] ?? 'N/A';
    $isiFinalItem['Account'] = $value[3] ?? 'N/A';
    $isiFinalItem['City'] =  $value[4] ?? 'N/A';
    $isiFinalItem['Patient'] =  isset($value[5]) ? $this->replacePatient($value[5]) : 'N/A'; 
    $isiFinalItem['Patient_Singkatan'] =  isset($value[5]) ? $this->replacePatientSingkatan($value[5]) : 'N/A'; 
    $isiFinalItem['Patient_ID_Number'] =  $value[6] ?? 'N/A';
    $isiFinalItem['PA_Number'] = $value[7] ?? 'N/A';
    $isiFinalItem['Date_Of_Birth'] =  isset($value[8]) ? date("Y-m-d", strtotime($value[8])) : 'N/A';
    $isiFinalItem['Age'] =  $value[9] ?? 'N/A';
    $isiFinalItem['Sex'] =  $value[10] ?? 'N/A';
    $isiFinalItem['Test'] =  $value[11] ?? 'N/A';
    $isiFinalItem['Test_Subcriteria'] =  $value[12] ?? 'N/A';
    $isiFinalItem['Specimen'] =  $value[13] ?? 'N/A';
    $isiFinalItem['Uncompliance_Specimen_Condition'] =  $value[14] ?? 'N/A';
    $isiFinalItem['Quantity_Block'] =  $value[15] ?? 'N/A';
    $isiFinalItem['Quantity_Slides'] =  $value[16] ?? 'N/A';
    $isiFinalItem['Clinical_Diagnosis'] =  $value[17] ?? 'N/A';
    $isiFinalItem['%_Tumor_Cells'] =  $value[18] ?? 'N/A';
    $isiFinalItem['Internal_Pathologist'] =  $value[19] ?? 'N/A';
    $isiFinalItem['Result_Makroskopik'] =  $value[20] ?? 'N/A';
    $isiFinalItem['Date_Received'] = isset($value[21]) ? (($value[21] == "")  ? "" : date("Y-m-d", strtotime($value[21])))  : 'N/A';
    $isiFinalItem['Time_Received'] =  $value[22] ?? 'N/A';
    $isiFinalItem['Date_of_Technical_Start'] =  isset($value[23]) ? (($value[23] == "")  ? "" : date("Y-m-d", strtotime($value[23])))  : 'N/A';
    $isiFinalItem['Date_Molecular_Pathologist_Scoring'] =  isset($value[24]) ? (($value[24] == "")  ? "" : date("Y-m-d", strtotime($value[24])))  : 'N/A';
    $isiFinalItem['Date_of_Technical_Finished'] =  isset($value[25]) ? (($value[25] == "")  ? "" : date("Y-m-d", strtotime($value[25])))  : 'N/A';
    $isiFinalItem['Date_of_Pathologist_IHC_Finished'] =  isset($value[26]) ? (($value[26] == "")  ? "" : date("Y-m-d", strtotime($value[26])))  : 'N/A';
    $isiFinalItem['Date_of_Result_Out_SendtoCostumer'] =  isset($value[27]) ? (($value[27] == "")  ? "" : date("Y-m-d", strtotime($value[27])))  : 'N/A';
    $isiFinalItem['Date_of_Hardcopy_Send_to_Costumer'] =  $value[28] ?? 'N/A';
    $isiFinalItem['Date_of_Hardcopy_Received_by_Costumer'] =  $value[29] ?? 'N/A';
    $isiFinalItem['Signed_for_by'] =  $value[30] ?? 'N/A';
    $isiFinalItem['Delivery_Location'] =  $value[31] ?? 'N/A';
    $isiFinalItem['Note'] =  $value[32] ?? 'N/A';
    $isiFinalItem['Holiday_Date'] =  $value[33] ?? 'N/A';
    $isiFinalItem['Time_Length'] =  $value[34] ?? 'N/A';
    $isiFinalItem['Prediction_of_Date_Result_Out'] =  $value[35] ?? 'N/A';
    $isiFinalItem['Working_Day_Deadline'] =  $value[36] ?? 'N/A';
    $isiFinalItem['Marker_TAT'] =  $value[37] ?? 'N/A';
    $isiFinalItem['Working_Day_Molecular_Pathologist_Scoring'] = $value[38] ?? 'N/A';
    $isiFinalItem['Working_Day_Technical'] =  $value[39] ?? 'N/A';
    $isiFinalItem['Working_Day_Pathologist_IHC_Finished'] =  $value[40] ?? 'N/A';
    $isiFinalItem['Working_Day_Admin'] =  $value[41] ?? 'N/A';
    $isiFinalItem['Working_Day_Total'] =  $value[42] ?? 'N/A';
    $isiFinalItem['_'] =  $value[43] ?? 'N/A';
    $isiFinalItem['TestStatus'] =  $value[44] ?? 'N/A';
    $isiFinalItem['VoucherNumber'] =  $value[45] ?? 'N/A';
    $isiFinalItem['LA'] =  $value[46] ?? 'N/A';
    $isiFinalItem['T_O_P'] =  $value[47] ?? 'N/A';
    $isiFinalItem['InvoicingAddress'] =  $value[48] ?? 'N/A';
    $isiFinalItem['InvoiceNumber'] =  $value[50] ?? 'N/A';
    $isiFinalItem['DateofInvoice'] =  $value[51] ?? 'N/A';
    $isiFinalItem['Selling_Price'] =  $value[52] ?? 'N/A';
    $isiFinalItem['Remarks'] = $value[53] ?? 'N/A';
    // Hanya data yang punya index 0
    if($isiFinalItem['KalgenInnolabID'] != 'N/A' && $isiFinalItem['KalgenInnolabID'] != '')
        $finalItems[] = $isiFinalItem;}
        // echo '<pre>';
        // print_r($finalItems);
        $this->db->insert_batch('data_molekuler_excel_dev', $finalItems); 

    }


    function replacePatient($str = "")
{
    $str = str_replace('Mrs. ' ,''   , $str);
    $str = str_replace('Mr. ' ,''  , $str);
    return $str;
    // return $this->singkatanPatient($str);
}

function replacePatientSingkatan($str = "")
{
    $str = str_replace('Mrs. ' ,''   , $str);
    $str = str_replace('Mr. ' ,''  , $str);
    //return $str;
     return $this->singkatanPatient($str);
}

function singkatanPatient($str = "")
{

$arr = explode(' ', $str);
$singkatan = '';
foreach($arr as $kata)
{
$singkatan .= substr($kata, 0, 1);
}
return $singkatan;
}




    
}
?>