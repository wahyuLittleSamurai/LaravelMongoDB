  <?php
  defined('BASEPATH') OR exit('No direct script access allowed');
 
  class M_account extends CI_Model{

       function getSensor()
	   {
			$this->db->select("*"); 
			$this->db->from('tblrealtimedevice');
			$query = $this->db->get();
			return $query->result();

	   } 
	   function getSensorSecond($data)
	   {
			$this->db->select("*"); 
			$this->db->from('tblrealtimedevice');
			$this->db->where('nama', $data);
			$query = $this->db->get();
			return $query->result();

	   } 
	   function addDevice($data)
	   {
			$this->db->insert('tblrealtimedevice',$data);

	   }
	   
	   function deleteTblDevice($data)
       {
			$this->db->where('nama', $data);
			$this->db->delete('tblrealtimedevice');	
       }
	   
	   function updateTbl($data){
			$this->db->set('volt', $data['volt']);
			$this->db->set('ampere', $data['ampere']);
			$this->db->set('rpm', $data['rpm']);
			$this->db->where('nama', $data['nama']);
			$this->db->update('tblrealtimedevice');
	   }
  }