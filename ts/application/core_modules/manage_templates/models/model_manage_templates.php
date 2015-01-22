<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Model for CodeIgniter tips files editor.
 *
**/

class Model_manage_templates extends CI_Model {
	private $EmailTemplates 	= 'EmailTemplates';	
	
	function __construct()
	{
		parent::__construct();  		
	}
	
	public function get_email_templates($type="email",$limit=0,$offset=0)
	{
		$this->db->select('id,purpose,subject,templates,active,lang');
		$this->db->from($this->EmailTemplates);
		if($offset!=0 || $limit!=0)
		{
			$this->db->limit($limit, $offset);
		}
		if($type == 'email'){
			$this->db->not_like('purpose', 'tmail', 'after'); 
		}
		else{
			$this->db->like('purpose', 'tmail', 'after'); 
		}
		$this->db->order_by('purpose','Asc');
		
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function detail($id=0)
	{
		if(isset($id) && $id>0){
			
		 $this->db->select('purpose,subject,templates,active,lang');
		 $this->db->from($this->EmailTemplates);
		 $this->db->where('id',$id);		 
		 $query = $this->db->get();
		 return $query->result_array();
		 
		}
		else 
			return false;
	}

	

}
/* End of file model_suggestions.php */
