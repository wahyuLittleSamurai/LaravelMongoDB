 <?php
 defined('BASEPATH') OR exit('No direct script access allowed');
 
 class Login extends CI_Controller {
	 function __construct(){
         parent::__construct();
         $this->load->library(array('form_validation'));
         $this->load->helper(array('url','form'));
		 $this->load->database();
         $this->load->model('m_account'); 
     }
     public function index() {
			
		$this->form_validation->set_rules('namaDevice', 'NAMADEVICE','required');
		 if($this->form_validation->run() == FALSE) {
			 
			 $this->data['posts'] = $this->m_account->getSensor();
			 $this->load->view('v_login', $this->data);
		 }
		 else
		 {
			$data['nama'] = $this->input->post('namaDevice');
			$data['volt'] = 0;
			$data['ampere'] = 0;
			$data['rpm'] = 0;
			$this->m_account->addDevice($data);
			$this->data['posts'] = $this->m_account->getSensor();
			$this->load->view('v_login', $this->data);
		 }
		
     }
	
	public function autoLoad(){
		
		$dataNamaDevice = $this->input->post('nameOfDevice');
		
		$valueDataRead = $this->m_account->getSensorSecond($dataNamaDevice);
		
		$valueVolt = NULL;
		$valueAmpere = NULL;
		$valueRpm = NULL;
		foreach($valueDataRead as $post)
		{
			$valueVolt = $post->volt;
			$valueAmpere = $post->ampere;
			$valueRpm = $post->rpm;
		}
		
		
		echo "{ \"volt\":\"".$valueVolt."\",\"ampere\":\"".$valueAmpere."\",\"rpm\":\"".$valueRpm."\"
			}";
	}
	
	public function deleteData(){
		$dataNamaDevice =  $this->input->post('nameOfDevice');
		$this->m_account->deleteTblDevice($dataNamaDevice);
		
	}
	public function getFromArdu($namaDevice, $rpm, $volt, $ampere)
	{
		$data['nama'] = $namaDevice;
		$data['rpm'] = $rpm;
		$data['volt'] = $volt;
		$data['ampere'] = $ampere;
		
		$this->m_account->updateTbl($data);
		echo "sukses";
		
	}
    
 }