<?php
class Admin_message_model extends CI_model{

	private $read_db;	// private variable to store db read reference
	var $table_name = "cc_messages";
    var $userid = '';
    var $messages = array();
    var $dateformat = '';
		
	
	function __construct(){
		parent::__construct();		
		
		// assign db read instance to read_db variable
		$this->read_db = $this->load->database('read', TRUE);
		$this->userid = $this->session->userdata('user_user_id');
	}
	
	public function getUserList(){
	
		$sqlStr	=	"SELECT * FROM cc_user 
					 ORDER BY firstname";
		$queryResult = $this->read_db->query($sqlStr);
		if($queryResult->num_rows()>0){
			return  $queryResult->result();
		}else{
			return false;
		}
	
	}
	
	// Fetch all messages from this user
    function getmessages($page='',$perPage='',$userId='',$searchTxt='') 
	{
		$limit='';		
		if($page !=''){
			$limit =" LIMIT ".($page-1)*$perPage .",".$perPage;
		}		
		
		$conditions="";
		$orderby="";
		$groupBy='';
		if($userId!=""){
			$conditions  =" AND (msg.from='".$userId."' OR  msg.to='".$userId."')";
			$conditions .=" AND (CASE WHEN msg.to='".$userId."' THEN msg.to_delete='0' ELSE  1 END) ";
			$conditions .=" AND (CASE WHEN msg.from='".$userId."' THEN msg.from_delete='0' ELSE  1 END) ";
			if($searchTxt!='' and $searchTxt!='Enter Member Name'){
				$conditions .=" AND (fromU.firstname LIKE '".$searchTxt."%' OR toU.firstname LIKE '".$searchTxt."%')";
			}
		}else{
			$groupBy = ' GROUP BY msg.to';
			if($searchTxt!='' and $searchTxt!='Enter Member Name'){
				$conditions .=" AND toU.firstname LIKE '".$searchTxt."%'";
			}
		}
		
		
        // Specify what type of messages you want to fetch		
      
		
		$orderby=" order by  msg.created DESC, msg.viewed ASC";
		
		$query  =" SELECT msg.*,fromU.firstname as from_firstname,fromU.lastname as from_lastname,toU.firstname as to_firstname,toU.lastname as to_lastname from ".$this->table_name." as msg ";
		$query .=" INNER JOIN cc_user as fromU ON fromU.user_id=msg.from ";
		$query .=" INNER JOIN cc_user as toU ON toU.user_id=msg.to ";
		$query .=" WHERE toU.user_id!='1' AND fromU.user_id!='1'  AND 1 ".$conditions;		
		$query .= $groupBy.$orderby.$limit;		
		
		$result = $this->read_db->query($query);		
        // Check if there are any results
        if($result->num_rows() > 0) 
		{
			return $result->result();			
        }else{
			return array();
		}		
    }
		
	
    // Fetch a specific message
    function getmessage($msgId='') 
	{
		$query  =" SELECT msg.*,fromU.firstname as from_firstname,fromU.lastname as from_lastname,toU.firstname as to_firstname,toU.lastname as to_lastname from ".$this->table_name." as msg ";
		$query .=" INNER JOIN cc_user as fromU ON fromU.user_id=msg.from ";
		$query .=" INNER JOIN cc_user as toU ON toU.user_id=msg.to ";
		$query .=" WHERE id='".$msgId."'";
				
		$result = $this->read_db->query($query);		
        if($result->num_rows() > 0) 
		{
			return $result->row();          
        }else{
			return array();
		}
		
		
    }
	
    // Fetch the username from a userid, I made this function because I don't know how you did build your usersystem, that's why I also didn't use left join... this way you can easily edit it
    function getusername($userid) 
	{
		$this->read_db->select("username");
		$this->read_db->where("`user_id` = '".$userid."'");
		$this->read_db->limit(1,0);
		
		$query = $this->read_db->get("cc_user");

        // Check if there is someone with this id
        if($query->num_rows()>0)
		{
			$result=$query->result_array();
            // if yes get his username
            $row = $result[0];
            return $row['username'];
        } 
		else 
		{
            // if not, name him Unknown
            return "Unknown";
        }
    }
	
    // We need the userid for pms, but we only let users input usernames, so we need to get the userid of the username :)
    function getuserid($username) 
	{
		$this->read_db->select("id");
		$this->read_db->where("`username` = '".$username."'");
		$this->read_db->limit(1,0);
		
		$query = $this->read_db->get("users");
		$result=$query->result_array();

        // Check if there is someone with this username
        if(count($result))
		{
            // if yes get his username
            $row = $result[0];
            return $row[0];
        } 
		else 
		{
            // if not, return false as 0
            return false;
        }
	}	
	
    // Flag a message as viewed
    function viewed($from_user_id) 
	{	
			$this->db->set('viewed','1');						
			$this->db->where('to',$this->userid);
			$this->db->where('from',$from_user_id);
			$result=$this->db->update($this->table_name);		
			
			if($result)
			{
				return true;
			}else{			
				return false;
			}
    }
  
    // Add a new personal message
    function sendmessage() 
	{
        //$to = $this->getuserid($to);		
		
		try
		{
			$txtto			=$this->input->post('txtTo');			
			$message	=$this->input->post('txtMessage');			
			if(count($txtto)>0){
			foreach($txtto AS $to){
				$this->db->set('to',$to);
				$this->db->set('from',$this->userid);			
				$this->db->set('message',$message);
				$this->db->set('created','NOW()',false);
				
				$this->db->insert($this->table_name);			
				$msgId=$this->db->insert_id();
				
				$attachment =$this->input->post('attachment');
				foreach($attachment as $path){					
					$file=explode('/',$path);				
					$lastkey =count($file)-1;
					$this->db->set('msg_id',$msgId);			
					$this->db->set('filename',$file[$lastkey]);
					$this->db->set('filepath',$path);
					$this->db->insert('message_attachment');							
				}
			}
			}
			
		}
		catch(Exception $e)
		{
			return false;
		}
			
		return true;
    }
	
    // Render the text (in here you can easily add bbcode for example)
    function render($message) 
	{
        $message = strip_tags($message, '');
        $message = stripslashes($message); 
        $message = nl2br($message);
        return $message;
    }
	
	function deleteMessage($id){
		$user_id =$this->session->userdata('user_user_id');
		$query  =" Update ".$this->table_name." SET " ;
		$query .=" to_delete=(CASE WHEN `to`='".$user_id."' THEN '1' ELSE  `to_delete` END)" ;
		$query .=" ,from_delete=(CASE WHEN `from`='".$user_id."' THEN '1' ELSE  `from_delete` END)" ;
		$query .=" WHERE id='".$id."' " ;
		
		return $this->db->query($query);		
	}
	
	/*
	 * function for logged user friends
	 */
	function search_friend_info($searchtext,$limit=7)
	{
		$user_id =$this->session->userdata('user_user_id');
		// get current user id from session
		
		$sql = "SELECT DISTINCT cc_user.user_id, cc_user.firstname , cc_user.lastname 
				FROM cc_friends f1 					
				JOIN cc_user on cc_user.user_id=(CASE 
					WHEN f1.from_user_id='".$user_id."' THEN f1.to_user_id
					WHEN f1.to_user_id='".$user_id."' THEN f1.from_user_id
					END) 
				WHERE (f1.from_user_id='".$user_id."' OR f1.to_user_id='".$user_id."') AND cc_user.firstname like'".$searchtext."%' AND f1.status=1";		
		$query = $this->read_db->query($sql);
			
		if($query->num_rows()>0)
		{
			return $query->result(); 		
		}	
		else
		{
			return array();
		}	
	}	
}
?>