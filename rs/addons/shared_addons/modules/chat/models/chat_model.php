<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @Description	:This model only for backend merchant model 
 * @author		:Rajendra Patidar
 * @package		:Merchant
 *
 */
class Chat_model extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->support_chat = "supportchat";
		$this->support_chat_users = "supportchat_users";
		$this->users = "users";
		$this->support_guest_users = "support_guest_users";
    }
    
    public function submitChat($chatText,$userType,$userId,$toUserId)
    {
		$data= array(
			'text'=>$chatText,
			'user_type_id'=>$userType,
			'author'=>$userId,
			'gravatar'=>'test',
			'to_user_id'=>$toUserId,
			'read_status'=>0
		);
		$this->db->insert($this->support_chat,$data);
		$id = $this->db->insert_id();
		if($id)
		{
			$data = array("last_activity" => "NOW()");
			$this->db->update($this->support_chat_users,array('user_id'=>$userId),$data);
			return array('status'=>1,'insertID'=>$id);
		}
		else
		{
			return array('status'=>0,'insertID'=>0);
		}
	}
	
	public function getChats($lastID=0,$user_type=0,$to_user_id=0,$all=0,$is_guest=0,$logged_in_user=0){
		$lastID = (int)$lastID;
		$this->db->from($this->support_chat);
		$this->db->where("chat_id >",$lastID);
		$this->db->order_by('ts');
		if(empty($all)){
			$this->db->where("(`author` = '$to_user_id' OR `to_user_id` = '$to_user_id')", NULL, FALSE);
		}
		$this->db->like('ts',date('Y-m-d'));
		$result = $this->db->get();
		$chats = array();
		foreach($result->result() as $res){
			// Returning the GMT (UTC) time of the chat creation:
			$res->time = array(
				'hours'		=> gmdate('H',strtotime($res->ts)),
				'minutes'	=> gmdate('i',strtotime($res->ts))
			);
			$res->authorName = $this->getAuthorName($res->author);
			if($res->author!=$logged_in_user){
				//$this->markAsRead($res->author);
			}
			//$chat->gravatar = Chat::gravatarFromHash($res->gravatar);
			
			$chats[] = $res;
		}
		return array('chats' => $chats);
	}
	
	public function insert_user($user_id,$username,$is_guest=0)
	{
		$data= array(
			'user_id'=>$user_id,
			'name'=>$username,
			'is_guest'=>$is_guest
		);
		$result = $this->db->get_where($this->support_chat_users,array('user_id'=>$user_id));
		$res = $result->result();
		if(empty($res))
		{
			$res = $this->db->insert($this->support_chat_users,$data);
			$id = $this->db->insert_id();
		}
		else
		{
			$data = array("last_activity" => "NOW()","name"=>$username);
			$id = $this->db->update($this->support_chat_users,array('user_id'=>$user_id,'is_guest'=>$is_guest),$data);
		}
	}
	
	public function getUsers($user_id){
		// Deleting chats older than 5 minutes and users inactive for 30 seconds
		//DB::query("DELETE FROM webchat_lines WHERE ts < SUBTIME(NOW(),'0:5:0')");
		//DB::query("DELETE FROM webchat_users WHERE last_activity < SUBTIME(NOW(),'0:0:30')");
		$this->db->query("delete from default_supportchat_users where last_activity < SUBTIME(NOW(),'0:12:30')"); 
		//$result = DB::query('SELECT * FROM webchat_users ORDER BY name ASC LIMIT 18');
		$this->db->from($this->support_chat_users);
		$this->db->where('user_id!=',$user_id);
		$data = $this->db->get()->result();
		$users = array();
		foreach($data as $result){
			//$user->gravatar = Chat::gravatarFromHash($user->gravatar,30);
			$users[] = $result;
		}
		$this->db->select('COUNT(*) as cnt');
		$count_arr = $this->db->get($this->support_chat_users)->result();
		if(!empty($count_arr)){
			$count = $count_arr[0]->cnt-1;
		}
		else
		{
			$count = 0;
		}
		return array(
			'users' => $users,
			'total' => $count
		);
	}
	
	public function getAuthorName($user_id)
	{
		$this->db->select("CONCAT(first_name,' ',last_name) AS authorName",false);
		$res = $this->db->get_where($this->users,array('id' => $user_id))->result();
		if(!empty($res)){
			return ucwords($res[0]->authorName);
		}
		else
		{
			return false;
		}
	}
	
	public function saveGuestUser($data)
	{
		$res = $this->db->get_where($this->users,array('email' => $data['email']))->result();
		if(empty($res))
		{
			$this->db->insert($this->users,$data);
			$id = $this->db->insert_id();
			if($id)
			{
				$this->insert_user($id,$data['username'],1);
				$this->setSession($id);
				return $id;
			}
			else
			{
				return false;
			}
		}
		else
		{
			$this->insert_user($res[0]->id,$res[0]->username,1);
			$this->setSession($res[0]->id);
			return $res[0]->id;
		}
	}
	
	private function setSession($id=0)
	{
		$this->db->select('first_name,username, email, id, password, group_id')->where('id', $id);
		$user = $this->db
		->limit(1)
		->get($this->users)
		->row();

		$this->session->set_userdata(array(
			'username' 			   => $user->username,
			'email' 			   => $user->email,
			'id'                   => $user->id, //kept for backwards compatibility
			'user_id'              => $user->id, //everyone likes to overwrite id so we'll use user_id
			'first_name'		   => $user->first_name	
		));
		$this->current_user = $user;
	}
}
