<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Todasquare product Model Class
 *
 *  Fetch data for product (Film & Video, Music & Audio, Photography & Art,
 *	 Writing & publishing, Education Material)
 *
 *  @package	Toadsqure
 *  @subpackage	Module
 *  @category	Model
 *  @author		Sapna Jain
 *  @link		http://toadsquare.com/
 */
class model_message_center extends CI_Model {

	/**
	 * Constructor
	 *
	 * Loads the calendar language file and sets the default time reference
	 */
	public function __construct(){		
		parent::__construct();			// Call parent constructer
	}
	
	/**
	 * getProject fucntion 
	 *
	 * getProject call by  Media Controller 
	 *
	 * @access	public
	 * @param	string
	 * @return	Object
	 */
	public function getContactList($userId=0){
		
			$table = $this->db->dbprefix('UserContacts');
			$this->db->select('*');
			$this->db->from('UserContacts');
			$this->db->where('UserContacts.tdsUid',$userId);
			$this->db->order_by("UserContacts.contId", "desc"); 
			$query = $this->db->get();
			//echo $this->db->last_query();die;
			return $result=$query->result();
		}
		
		public function getUserContactList($contId){
			$table=$this->db->dbprefix('UserContacts');

			$this->db->select('*');
			$this->db->from('UserContacts');

			$this->db->where('UserContacts.contId',$contId);
			$query = $this->db->get();
			//echo $this->db->last_query();
			return $result=$query->result();
		}
		
		
		
		public function getnextUserContactList($contId){
						
			$table=$this->db->dbprefix('UserContacts');

			$this->db->select('*');
			$this->db->from('UserContacts');
			
			$this->db->where('UserContacts.contId < ',$contId);
			$this->db->order_by("UserContacts.contId", "desc"); 
			$this->db->limit(1); 
			$query = $this->db->get();
			//echo $this->db->last_query();
			return $result=$query->result();
		}
		
		public function getpreviousUserContactList($contId){
			$table=$this->db->dbprefix('UserContacts');

			$this->db->select('*');
			$this->db->from('UserContacts');

			$this->db->where('UserContacts.contId > ',$contId);
			$this->db->order_by("UserContacts.contId", "asc");
			$this->db->limit(1); 
			$query = $this->db->get();
			//echo $this->db->last_query();
			return $result=$query->result();
		}
		
		public function getSortedContactList($userId=0,$sort){
			$table=$this->db->dbprefix('UserContacts');

			$this->db->select('*');
			$this->db->from('UserContacts');

			$this->db->where('UserContacts.tdsUid',$userId);
			if($sort!= "#" && $sort!= "")
			{
				/*$this->db->like('UserContacts.firstName',$sort,'after');
				$this->db->or_like('UserContacts.firstName',strtolower($sort),'after');*/
				$this->db->like('UserContacts.firstName',$sort,'both');
				$this->db->or_like('UserContacts.firstName',strtolower($sort),'both');
				$this->db->or_like('UserContacts.firstName',ucfirst($sort),'both');
				$this->db->or_like('UserContacts.lastName',strtolower($sort),'both');
				$this->db->or_like('UserContacts.lastName',ucfirst($sort),'both');
				$this->db->or_like('UserContacts.emailId',strtolower($sort),'both');	
			}
			$this->db->order_by("UserContacts.contId", "desc"); 
			$query = $this->db->get();
			//echo $this->db->last_query();
			return $result=$query->result();
		}
		
		public function getSearchedContactList($userId=0,$search){
			$table=$this->db->dbprefix('UserContacts');
			
			$this->db->select('*');
			$this->db->from('UserContacts');

			$this->db->where('UserContacts.tdsUid',$userId);
			if($search != "")
			{
				$this->db->like('UserContacts.firstName',$search,'both');
				$this->db->or_like('UserContacts.firstName',strtolower($search),'both');
				$this->db->or_like('UserContacts.firstName',ucfirst($search),'both');
				$this->db->or_like('UserContacts.lastName',strtolower($search),'both');
				$this->db->or_like('UserContacts.lastName',ucfirst($search),'both');
				$this->db->or_like('UserContacts.emailId',strtolower($search),'both');	
			//$this->db->or_like('UserContacts.firstName',ucwords($search),'after');
			}
			$this->db->order_by("UserContacts.contId", "desc"); 
			$query = $this->db->get();
			//echo $this->db->last_query();
			return $result=$query->result();
		}

	function checkForEmail($emailId,$userId)
	{
		$table=$this->db->dbprefix('UserContacts');

		$this->db->select('*');
		$this->db->from($table);

		$this->db->where('UserContacts.emailId',$emailId);
		$this->db->where('UserContacts.tdsUid',$userId);

		$query = $this->db->get();
		$result=$query->num_rows();
		return $result;
	}
	
	function checkForUserContactEmail($emailId)
	{
		$table=$this->db->dbprefix('UserAuth');

		$this->db->select('*');
		$this->db->from($table);

		$this->db->where('UserAuth.email',$emailId);
		
		$query = $this->db->get();
		$result=$query->result();
		return $result;
	}
	
	function checkForProfileImage($tdsUid)
	{
		$table=$this->db->dbprefix('UserShowcase');

		$this->db->select('*');
		$this->db->from($table);

		$this->db->where('UserShowcase.tdsUid',$tdsUid);
		
		$query = $this->db->get();
		$result=$query->result();
		return $result;
	}
	function checkForstockImage($stockImageId)
	{
		$table=$this->db->dbprefix('StockImages');

		$this->db->select('*');
		$this->db->from($table);

		$this->db->where('StockImages.stockImgId',$stockImageId);
		
		$query = $this->db->get();
		$result=$query->result();
		return $result;
	}
	
	
	function deleteDataFromTabel($contId)
	{
		$table=$this->db->dbprefix('UserContacts');
		$fieldcontId = 'contId';	
		$this->db->where($fieldcontId,$contId);
		$this->db->delete($table); 
	}

	
	}
/* End of file model_product.php */
/* Location: ./application/module/product/model/model_product.php */
