<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Model_tmail extends CI_Model
{

    private $tableMessages						= 'tmail_messages';
    private $tableParticipants					= 'tmail_participants';
    private $tableStatus						= 'msg_status';
    private $tableThreads						= 'tmail_threads';
	private $tableUserAuth						= 'UserAuth';
	private $tableUserProfile					= 'UserProfile';
	private $tableUserShowcase					= 'UserShowcase';
    private $tableWorkProfileRequest            = 'WorkProfileRequest';
    private $tableAttachment                    = 'tmail_attachment';
    private $tableWorkApplication               = 'WorkApplication';
    private $tableWork                          = 'Work';
    private $tableMasterIndustry                = 'MasterIndustry';
    private $tableRequestUrl                    = 'WorkProfileUrlRequest';
    private $LogCrave                           = 'LogCrave';
    private $LogSummary                         = 'LogSummary';
    private $tableProduct                       = 'Product';
    private $tableMediaFile				        = 'MediaFile';
	
	/**
	 * Constructor
	 *
	 * Loads the calendar language file and sets the default time reference
	 */
	public function __construct(){		
		parent::__construct();			// Call parent constructer
	}
	/*
    function getcravedUser($user_id){
		//$entityId=getMasterTableRecord($this->tableUserAuth);
		$this->db->select($this->tableUserShowcase.'.*');
		$this->db->from($this->LogCrave);
		//$this->db->join($this->tableUserAuth, $this->tableUserAuth.'.tdsUid=LogCrave.tdsUid');
		$this->db->join($this->tableUserAuth, $this->tableUserAuth.'.tdsUid=LogCrave.tdsUid');
		$this->db->join($this->tableUserShowcase, $this->tableUserShowcase.'.tdsUid=LogCrave.tdsUid');
		//$this->db->where('LogCrave.elementId',$user_id);
		//$this->db->where('LogCrave.entityId',$entityId);
		
		$this->db->where($this->LogCrave.'.tdsUid !=',$user_id);
		$this->db->where($this->LogCrave.'.ownerId',$user_id);
		$query = $this->db->get(); 
		return $query->result();
			//echo $this->db->last_query();
	
	} */
	
	 function searchCravedUser($user_id=0,$searchBy=''){
		$entityId=getMasterTableRecord($this->tableUserAuth);
		$this->db->select($this->tableUserAuth.'.*, '.$this->tableUserShowcase.'.*');
		$this->db->from('LogCrave');
		$this->db->join($this->tableUserAuth, $this->tableUserAuth.'.tdsUid=LogCrave.tdsUid');
		$this->db->join($this->tableUserShowcase, $this->tableUserShowcase.'.tdsUid=LogCrave.tdsUid');
		$this->db->where('LogCrave.elementId',$user_id);
		$this->db->where('LogCrave.entityId',$entityId);
		if(!empty($searchBy)){
			$this->db->like($this->tableUserAuth.'.email', $searchBy, 'after'); 
			$this->db->or_like($this->tableUserShowcase.'.firstName', $searchBy, 'after'); 
			$this->db->or_like($this->tableUserShowcase.'.lastName', $searchBy, 'after');
		}
		$query = $this->db->get(); 
		return $query->result();
			//echo $this->db->last_query();
	}
	
	function send_new_message($sender_id, $recipients, $subject, $body, $priority,$type=1,$fileId=0,$elementId=0){
    
            $this->db->trans_start();

            $thread_id = $this->_insert_thread($subject);
            if ($this->db->trans_status() === false)
            {
                $this->db->trans_rollback();
                return false;
            }

            $messageData=array(
				'thread_id'=>$thread_id,
				'body'=>$body,
				'sender_id'=>$sender_id,
				'priority'=>($priority>=1)?$priority:1,
				'subject'=>$subject,
				'type'=>$type,
				'elementId'=>$elementId,
				
            );
            $msg_id = $this->_insert_message($messageData);
           
            if ($this->db->trans_status() === false)
            {
                $this->db->trans_rollback();
                return false;
            }
           
            //Manage attachment for collaboration
            if(isset($fileId) && !empty($fileId) && isset($msg_id)) {
				$this->_insert_collaboration_attachment($fileId,$msg_id);
			}

            //create batch inserts
            $participants[] = array('thread_id'=>$thread_id,'user_id'=> $sender_id,'msg_id'=>$msg_id,'is_sender'=>'t');
            $statuses[]     = array('message_id'=>$msg_id, 'user_id'=> $sender_id,'status'=> MSG_STATUS_READ);

            if (!is_array($recipients))
            {   
                $participants[] = array('thread_id'=>$thread_id,'user_id'=>$recipients,'msg_id'=>$msg_id,'is_sender'=>'f');
                $statuses[]     = array('message_id'=>$msg_id, 'user_id'=>$recipients, 'status'=>MSG_STATUS_UNREAD);
            }
            else
            {
                foreach ($recipients as $recipient)
                {
                    $participants[] = array('thread_id'=>$thread_id,'user_id'=>$recipient,'msg_id'=>$msg_id,'is_sender'=>'f');
                    $statuses[]     = array('message_id'=>$msg_id, 'user_id'=>$recipient, 'status'=>MSG_STATUS_UNREAD);
                }
            }
            $this->_insert_participants($participants);
            if ($this->db->trans_status() === false)
            {
                $this->db->trans_rollback();
                return false;
            }

            $this->_insert_statuses($statuses);
            if ($this->db->trans_status() === false)
            {
                $this->db->trans_rollback();
                return false;
            }

            $this->db->trans_complete();
            return $msg_id;
    }

    //reply to message
    function reply_to_message($reply_msg_id, $sender_id,$recipients, $body, $priority,$subject,$type)
    {
            $this->db->trans_start();
               
            //get the thread id to keep messages together
            if (!($thread_id = $this->_get_thread_id_from_message($reply_msg_id)))
            {
                return false;
            }

            //add this message
           
			 $messageData=array(
				'thread_id'=>$thread_id,
				'body'=>$body,
				'sender_id'=>$sender_id,
				'priority'=>$priority,
				'subject'=>$subject,
				'type'=>$type,
				'parent_message_id'=>($reply_msg_id>=1)?$reply_msg_id:0,
				
            );
            
            $msg_id = $this->_insert_message($messageData);
            if ($this->db->trans_status() === false)
            {
                $this->db->trans_rollback();
                return false;
            }

              //create batch inserts
            $participants[] = array('thread_id'=>$thread_id,'user_id'=> $sender_id,'msg_id'=>$msg_id,'is_sender'=>'t');
            $statuses[]     = array('message_id'=>$msg_id, 'user_id'=> $sender_id,'status'=> MSG_STATUS_READ);

            if (!is_array($recipients))
            {   
				
				
                $participants[] = array('thread_id'=>$thread_id,'user_id'=>$recipients,'msg_id'=>$msg_id,'is_sender'=>'f');
               
            }
            else
            {
                foreach ($recipients as $recipient)
                {
                    $participants[] = array('thread_id'=>$thread_id,'user_id'=>$recipient,'msg_id'=>$msg_id,'is_sender'=>'f');
                    
                }
            }
            $this->_insert_participants($participants);
            if ($this->db->trans_status() === false)
            {
                $this->db->trans_rollback();
                return false;
            }
            

            $this->db->trans_complete();
            return $msg_id;    
    }
	
	//get user Information message
	function get_User($user_id){
	        $tableUser=$this->db->dbprefix($this->tableUserAuth);
	        
	       $sql = 'SELECT * FROM "'.$tableUser.'" WHERE "tdsUid" = ? ' ;
            $query = $this->db->query($sql, array($user_id)); 
            return $query->result_array();
	}
    //get a single message
    function get_message($msg_id, $user_id)
    {
          
           $tableParticipants=$this->db->dbprefix($this->tableParticipants);
		   $tableStatus=$this->db->dbprefix($this->tableStatus);
		   $tableMessages=$this->db->dbprefix($this->tableMessages);
		   $tableThreads=$this->db->dbprefix($this->tableThreads);
		   
          $tableUser=$this->db->dbprefix($this->tableUserAuth);
           
           $sql = 'SELECT m.*, s.status, t.subject, u.username'.
                ' FROM "'.$tableMessages.'" m ' .
                ' JOIN "'.$tableThreads.'" t ON (m.thread_id = t.id) ' .
                ' JOIN "'.$tableUser.'" u ON (u."tdsUid" = m.sender_id) '.
                ' JOIN "'.$tableStatus.'" s ON (s.message_id = m.id AND s.user_id = ? ) ' .
                ' WHERE m.id = ? ' ;

            $query = $this->db->query($sql, array($user_id, $msg_id)); 
            return $query->result_array();
    }

    //get full thread
    function get_full_thread($messageId, $user_id, $full_thread = false, $order_by='asc'){
           
           $tableParticipants=$this->db->dbprefix($this->tableParticipants);
		   $tableStatus=$this->db->dbprefix($this->tableStatus);
		   $tableMessages=$this->db->dbprefix($this->tableMessages);
		   $tableThreads=$this->db->dbprefix($this->tableThreads);
           $tableUser=$this->db->dbprefix($this->tableUserAuth);
           $tableUserShowcase=$this->db->dbprefix($this->tableUserShowcase);
           
           $sql = 'SELECT m.*, s.status, t.subject,"'.$tableUserShowcase.'"."firstName",
					"'.$tableUserShowcase.'"."lastName",
					"'.$tableUserShowcase.'"."profileImagePath" as image,
					"'.$tableUserShowcase.'"."creative",
					"'.$tableUserShowcase.'"."associatedProfessional",
					"'.$tableUserShowcase.'"."enterprise",
					u.username'. 
                ' FROM "'.$tableParticipants.'" p ' .
                ' JOIN "'.$tableThreads.'" t ON (t.id = p.thread_id) ' .
                ' JOIN "'.$tableMessages.'" m ON (m.thread_id = t.id) ' .
                ' JOIN "'.$tableUser.'" u ON (u."tdsUid" = m.sender_id) '.
                ' JOIN "'.$tableStatus.'" s ON (s.message_id = m.id AND s.user_id = ? ) ' .
				' JOIN "'.$tableUserShowcase.'" ON ("'.$tableUserShowcase.'"."tdsUid" = m.sender_id)  ' .
                ' WHERE p.user_id = ? ' .
                ' AND m.id = ? ';
            if (!$full_thread)
            {
                $sql .= ' AND m.cdate >= p.cdate';
            }
            $sql .= ' ORDER BY m.cdate '.$order_by;

            $query = $this->db->query($sql, array($user_id, $user_id, $messageId)); 
			$res = $query->result_array();
			if($res){
				$updateData=array('status'=>1);
				$loggedUserId=$this->isLoginUser();
				$this->db->where('message_id' , $messageId);
				$this->db->where('user_id' , $loggedUserId);
				$this->db->update('msg_status' , $updateData);
				//echo $this->db->last_query();
			}
			
				//echo $this->db->last_query();
            return $res;
    }

    //get all threads
    function get_all_threads($user_id, $full_thread = false, $order_by='asc'){
           
		   $tableParticipants=$this->db->dbprefix($this->tableParticipants);
		   $tableStatus=$this->db->dbprefix($this->tableStatus);
		   $tableMessages=$this->db->dbprefix($this->tableMessages);
		   $tableThreads=$this->db->dbprefix($this->tableThreads);
		   $tableUser=$this->db->dbprefix($this->tableUserAuth);
           
            $sql = 'SELECT m.*, s.status, t.subject, u.username'.
                ' FROM "'.$tableParticipants.'" p ' .
                ' JOIN "'.$tableThreads.'" t ON (t.id = p.thread_id) ' .
                ' JOIN "'.$tableMessages.'" m ON (m.thread_id = t.id) ' .
                ' JOIN "'.$tableUser.'" u ON (u."tdsUid" = m.sender_id) '.
                ' JOIN "'.$tableStatus.'" s ON (s.message_id = m.id AND s.user_id = ? ) ' .
                ' WHERE p.user_id = ? ' ;
            if (!$full_thread)
            {
                $sql .= ' AND m.cdate >= p.cdate';
            }
            $sql .= ' ORDER BY t.id '.$order_by. ', m.cdate '.$order_by;

            $query = $this->db->query($sql, array($user_id, $user_id));
            return $query->result_array();
    }

	function get_user_Inbox($user_id,$offset=0,$limit=0){
			
		   $tableParticipants=$this->db->dbprefix($this->tableParticipants);		  
		   $tableMessages=$this->db->dbprefix($this->tableMessages);
		   $tableThreads=$this->db->dbprefix($this->tableThreads);
           $tableUser=$this->db->dbprefix($this->tableUserAuth);
           $tableUserShowcase=$this->db->dbprefix($this->tableUserShowcase);
          
			/*$sql=' SELECT "m".id,"m".thread_id,"m".body,"m".priority,"m".sender_id,"m".cdate,	"m".type,	
					p.status,p.id as status_id,					
					m.subject, p.is_sender,
					u.username,	u.email,
					up."profileImageName",up."firstName",up."lastName",up."profileImagePath" as image,up."creative",up."associatedProfessional",up."enterprise"	
					FROM "'.$tableParticipants.'" p
					JOIN "'.$tableThreads.'" t ON (t.id = p.thread_id)
					JOIN "'.$tableMessages.'" m ON (m.id = p.msg_id AND m.sender_id != '.$user_id.' )					
					LEFT JOIN "'.$tableUser.'" u ON (u."tdsUid" = m.sender_id) 
					LEFT JOIN "'.$tableUserShowcase.'" up ON (up."tdsUid" = m.sender_id)  
					WHERE p.user_id =  '.$user_id.' AND p.is_sender = false AND p.status!=2 AND p.status!=3
					order by "p".id DESC 
					LIMIT '.$limit.'
					OFFSET '.$offset.'
				';*/
				
			$sql=' SELECT "m".id,"m".thread_id,"m".body,"m".priority,"m".sender_id,"m".cdate,	"m".type,	
					p.status,p.id as status_id,					
					m.subject,
					u.username,	u.email,
					up."profileImageName",up."firstName",up."lastName",up."profileImagePath" as image,up."creative",up."associatedProfessional",up."enterprise",up."enterpriseName"	
					FROM "'.$tableParticipants.'" p
					JOIN "'.$tableThreads.'" t ON (t.id = p.thread_id)
					JOIN "'.$tableMessages.'" m ON (m.id = p.msg_id AND m.sender_id!= '.$user_id.')					
					LEFT JOIN "'.$tableUser.'" u ON (u."tdsUid" = m.sender_id) 
					LEFT JOIN "'.$tableUserShowcase.'" up ON (up."tdsUid" = m.sender_id)  
					WHERE p.user_id =  '.$user_id.' AND p.is_sender = false AND p.status!=2 AND p.status!=3
					order by "p".id DESC 
					LIMIT '.$limit.'
					OFFSET '.$offset.' 
				';	
				
			//echo $sql;	die;
				
			
			/*$this->db->select('p.status,p.id as status_id, m.id, m.thread_id, m.body,m.priority,m.sender_id,m.cdate,m.type,m.subject,up.profileImageName,up.firstName,up.lastName,up.profileImagePath as image,up.creative,up.associatedProfessional,up.enterprise,u.username,	u.email');
			$this->db->from("$tableParticipants as p");
			$this->db->join("$tableThreads as t", 't.id = p.thread_id');
			$this->db->join("$tableMessages as m", "m.id = p.msg_id AND m.sender_id!= $user_id");
			$this->db->join("$tableUser as u", 'u.tdsUid = m.sender_id','left');
			$this->db->join("$tableUserShowcase as up", 'up.tdsUid = m.sender_id','left');
			$this->db->where("p.user_id",$user_id);
			$this->db->where("p.is_sender",'f');
		    $this->db->where("p.status !=","2");//
			$this->db->where("p.status !=","3");//
			$this->db->order_by("p.id", "desc");
			$this->db->limit($limit, $offset);
			$query = $this->db->get();*/
			
			//echo $this->db->last_query();die;
			
			$query = $this->db->query($sql);
			$res = $query->result_array();
			
			return $res;
	}
	
	function get_user_Inbox_Count($user_id){
			
		   $tableParticipants=$this->db->dbprefix($this->tableParticipants);		  
		   $tableMessages=$this->db->dbprefix($this->tableMessages);
		   $tableThreads=$this->db->dbprefix($this->tableThreads);
           $tableUser=$this->db->dbprefix($this->tableUserAuth);
           $tableUserShowcase=$this->db->dbprefix($this->tableUserShowcase);
          
			$sql=' SELECT "m".id,"m".thread_id,"m".body,"m".priority,"m".sender_id,"m".cdate,	"m".type,	
					p.status,p.id as status_id,					
					m.subject,
					u.username,	u.email,
					up."profileImageName",up."firstName",up."lastName",up."profileImagePath" as image,up."creative",up."associatedProfessional",up."enterprise"	
					FROM "'.$tableParticipants.'" p
					JOIN "'.$tableThreads.'" t ON (t.id = p.thread_id)
					JOIN "'.$tableMessages.'" m ON (m.id = p.msg_id AND m.sender_id!= '.$user_id.')					
					LEFT JOIN "'.$tableUser.'" u ON (u."tdsUid" = m.sender_id) 
					LEFT JOIN "'.$tableUserShowcase.'" up ON (up."tdsUid" = m.sender_id)  
					WHERE p.user_id =  '.$user_id.' AND p.is_sender = false AND p.status!=2 AND p.status!=3
					order by "p".id DESC 
				';
//echo $sql;	die;
				
			
			$query = $this->db->query($sql);
			if($query->num_rows()>0)
			{
				$res = $query->num_rows();
			}else
			{
				$res = 0;
			}
            return $res;
	}
	
	function get_user_sent($user_id,$offset=0,$limit=0){
			
		   $tableParticipants=$this->db->dbprefix($this->tableParticipants);
		   $tableStatus=$this->db->dbprefix($this->tableStatus);
		   $tableMessages=$this->db->dbprefix($this->tableMessages);
		   $tableThreads=$this->db->dbprefix($this->tableThreads);
           $tableUser=$this->db->dbprefix($this->tableUserAuth);
           $tableUserShowcase=$this->db->dbprefix($this->tableUserShowcase);
           
           
			$sql=' SELECT  m.id,m.thread_id,m.body,m.priority,	m.sender_id,m.type,m.cdate,					
					p.id as status_id,p.status,
					m.subject,					
					u.username,u.email,
					up."firstName",up."lastName" ,up."profileImagePath" as image,up."creative",up."associatedProfessional",up."enterprise"	
					FROM "'.$tableParticipants.'" p
					JOIN "'.$tableThreads.'" t ON (t.id = p.thread_id)
					JOIN "'.$tableMessages.'" m ON (m.id = p.msg_id AND m.sender_id= '.$user_id.')
					LEFT JOIN "'.$tableUser.'" u ON (u."tdsUid" = m.sender_id) 					
					LEFT JOIN "'.$tableUserShowcase.'" up ON (up."tdsUid" = m.sender_id)  
					WHERE p.user_id = '.$user_id.' 	AND p.is_sender = true AND p.status!=2 AND p.status!=3
					order by "p".id DESC
					LIMIT '.$limit.'
					OFFSET '.$offset.'
				';
	//echo $sql;	die;			
			$query = $this->db->query($sql, array($user_id, $user_id,$user_id,$user_id));
			//echo $this->db->last_query();
			return $query->result_array();
	}
	
	function get_user_sent_count($user_id){
			
		   $tableParticipants=$this->db->dbprefix($this->tableParticipants);
		   $tableStatus=$this->db->dbprefix($this->tableStatus);
		   $tableMessages=$this->db->dbprefix($this->tableMessages);
		   $tableThreads=$this->db->dbprefix($this->tableThreads);
           $tableUser=$this->db->dbprefix($this->tableUserAuth);
           $tableUserShowcase=$this->db->dbprefix($this->tableUserShowcase);
           
           
			$sql=' SELECT 	m.id,m.thread_id,m.body,m.priority,	m.sender_id,m.type,m.cdate,					
					p.id as status_id,p.status,
					m.subject,					
					u.username,u.email,
					up."firstName",up."lastName" ,up."profileImagePath" as image,up."creative",up."associatedProfessional",up."enterprise"	
					FROM "'.$tableParticipants.'" p
					JOIN "'.$tableThreads.'" t ON (t.id = p.thread_id)
					JOIN "'.$tableMessages.'" m ON (m.id = p.msg_id AND m.sender_id= '.$user_id.')
					LEFT JOIN "'.$tableUser.'" u ON (u."tdsUid" = m.sender_id) 					
					LEFT JOIN "'.$tableUserShowcase.'" up ON (up."tdsUid" = m.sender_id)  
					WHERE p.user_id = '.$user_id.' 	AND p.is_sender = true AND p.status!=2 AND p.status!=3
					order by "p".id DESC
				';
	//echo $sql;	die;			
			$query = $this->db->query($sql, array($user_id, $user_id,$user_id,$user_id));
			//echo $this->db->last_query();
			
			if($query->num_rows()>0)
			{
				$res = $query->num_rows();
			}else
			{
				$res = 0;
			}
			return $res;
	}
	
	/** This function is used to show tmail reciever details**/
	
	function get_tmail_sender_details($thread_id)
	{
		$tableParticipants=$this->db->dbprefix($this->tableParticipants);
		
		$this->db->where('thread_id',$thread_id);
		$this->db->where('is_sender', 'f');
		$query = $this->db->get($tableParticipants);
		
		if($query->num_rows()>0)
			{
				$userID = $query->row()->user_id;
			}else
			{
				$userID = 0;
			}
			
		return $userID;
	}
	
	
	function get_user_trash($user_id,$offset=0,$limit=0){
		   
		   $tableParticipants=$this->db->dbprefix($this->tableParticipants);
		   $tableStatus=$this->db->dbprefix($this->tableStatus);
		   $tableMessages=$this->db->dbprefix($this->tableMessages);
		   $tableThreads=$this->db->dbprefix($this->tableThreads);
           $tableUser=$this->db->dbprefix($this->tableUserAuth);
           $tableUserShowcase=$this->db->dbprefix($this->tableUserShowcase);
			
			$sql=' SELECT m.id,m.thread_id,m.body,m.priority,m.sender_id,m.cdate,m.type,
					p.id as status_id,p.status,p.is_sender,
					m.subject,					
					u.username,u.email,
					up."firstName",up."lastName" ,up."profileImagePath" as image,up."creative",up."associatedProfessional",up."enterprise"	
					FROM "'.$tableParticipants.'" p
					JOIN "'.$tableThreads.'" t ON (t.id = p.thread_id)
					JOIN "'.$tableMessages.'" m ON (m.id = p.msg_id)
					LEFT JOIN "'.$tableUser.'" u ON (u."tdsUid" = m.sender_id)					
					LEFT JOIN "'.$tableUserShowcase.'" up ON (up."tdsUid" = m.sender_id)  
					WHERE p.user_id = '.$user_id.' AND p.status = 2 
					order by "p".id DESC
					LIMIT '.$limit.'
					OFFSET '.$offset.' 
				';
			$query = $this->db->query($sql, array($user_id, $user_id));
            return $query->result_array();
	}
	
	
	function get_user_trash_count($user_id){
		   
		   $tableParticipants=$this->db->dbprefix($this->tableParticipants);
		   $tableStatus=$this->db->dbprefix($this->tableStatus);
		   $tableMessages=$this->db->dbprefix($this->tableMessages);
		   $tableThreads=$this->db->dbprefix($this->tableThreads);
           $tableUser=$this->db->dbprefix($this->tableUserAuth);
           $tableUserShowcase=$this->db->dbprefix($this->tableUserShowcase);
			
			$sql=' SELECT m.id,m.thread_id,m.body,m.priority,m.sender_id,m.cdate,m.type,
					p.id as status_id,p.status,
					m.subject,					
					u.username,u.email,
					up."firstName",up."lastName" ,up."profileImagePath" as image,up."creative",up."associatedProfessional",up."enterprise"	
					FROM "'.$tableParticipants.'" p
					JOIN "'.$tableThreads.'" t ON (t.id = p.thread_id)
					JOIN "'.$tableMessages.'" m ON (m.id = p.msg_id)
					LEFT JOIN "'.$tableUser.'" u ON (u."tdsUid" = m.sender_id)					
					LEFT JOIN "'.$tableUserShowcase.'" up ON (up."tdsUid" = m.sender_id)  
					WHERE p.user_id = '.$user_id.' AND p.status = 2 
					order by "p".id DESC
				';
			$query = $this->db->query($sql, array($user_id, $user_id));
            if($query->num_rows()>0)
			{
				$res = $query->num_rows();
			}else
			{
				$res = 0;
			}
			return $res;
	}
    //maove messages in trash 
	function trashed($status_id=0,$trash_by=0){
            $this->db->where_in('id',$status_id);
            $this->db->update('msg_status', array('trash_by'=>$trash_by));
			//echo $this->db->last_query();
            return $this->db->affected_rows();
    }
	//change message status
    function update_message_status($msg_id, $user_id, $status_id  ){
            $this->db->where(array('message_id'=>$msg_id, 'user_id'=>$user_id ));
            $this->db->update('msg_status', array('status'=>$status_id ));
            return $this->db->affected_rows();
    }


    //add participant
    function add_participant($thread_id, $user_id)
    {
            $this->db->trans_start();

            $participants[] = array('thread_id'=>$thread_id,'user_id'=>$user_id);
            $this->_insert_participants($participants);
            if ($this->db->trans_status() === false)
            {
                $this->db->trans_rollback();
                return false;
            }

            //get messages by thread
            $messages = $this->_get_messages_by_thread_id($thread_id);

            foreach ($messages as $message)
            {
                $statuses[]     = array('message_id'=>$message['id'], 'user_id'=>$user_id, 'status'=>MSG_STATUS_UNREAD);
            }
           
            $this->_insert_statuses($statuses);
            if ($this->db->trans_status() === false)
            {
                $this->db->trans_rollback();
                return false;
            }

            $this->db->trans_complete();
            return true; 
    }

    function remove_participant($thread_id, $user_id)
    {
            $this->db->trans_start();

            $return = $this->_delete_participant($thread_id, $user_id);
            if (($return === false)  || $this->db->trans_status() === false)
            {
                $this->db->trans_rollback();
                return false;
            }

            $this->_delete_statuses($thread_id, $user_id);
            if ($this->db->trans_status() === false)
            {
                $this->db->trans_rollback();
                return false;
            }

            $this->db->trans_complete();
            return true; 
    }

    // because of CodeIgniter's DB Class return style, it is safer to check for uniqueness first 
    function valid_new_participant($thread_id, $user_id)
    {
           $tableParticipants=$this->db->dbprefix($this->tableParticipants);
            
            $sql = 'SELECT COUNT(*) AS count ' .
                ' FROM "'.$tableParticipants.'" p ' .
                ' WHERE p.thread_id = ? ' .
                ' AND p.user_id = ? ';
            $query = $this->db->query($sql, array($thread_id, $user_id));
            if ($query->row()->count)
            {
                return false;
            }
            return true;
    }

    function application_user($user_id)
    {
           $tableUserAuth=$this->db->dbprefix($this->tableUserAuth);
           
           
            $sql = 'SELECT COUNT(*) AS count ' .
                ' FROM  "'.$tableUserAuth.'"' .
                ' WHERE "tds_Uid" = ?' ;
            $query = $this->db->query($sql, array($user_id));
            if ($query->row()->count)
            {
                return true;
            }
            return false;
     }

    function get_participant_list($thread_id, $sender_id =0)
    {
        if ($results = $this->_get_thread_participants($thread_id, $sender_id)) {
            return $results;
        }
        return false;
    }


    //                                              
    //***** private functions *****//
    //

    private function _insert_thread($subject)
    {
			$insert_id = $this->db->insert($this->tableThreads, array('subject'=>$subject));
            return $this->db->insert_id();
    }
    private function _insert_message($insert=array())
    {
		$insert_id = $this->db->insert($this->tableMessages, $insert);
		return $this->db->insert_id();
    }

    private function _insert_participants($participants)
    {
		foreach($participants as $key => $value){
			$insert_id = $this->db->insert($this->tableParticipants, $value);
		}
            //return $this->db->insert_batch('msg_participants', $participants);
    }

    private function _insert_statuses($statuses)
    {
		foreach($statuses as $key => $value){
			$insert_id = $this->db->insert('msg_status', $value);
		}
            //return $this->db->insert_batch('msg_status', $statuses);
    }

    private function _get_thread_id_from_message($msg_id){
            $query = $this->db->select('thread_id')->get_where($this->tableMessages, array('id' => $msg_id));
            if ($query->num_rows()){
                return $query->row()->thread_id;
            }
            return 0;
    }

    private function _get_messages_by_thread_id($thread_id)
    {
            $query = $this->db->get_where($this->tableMessages, array('thread_id' => $thread_id));  
            return $query->result_array();
    }


    private function _get_thread_participants($thread_id, $sender_id=0) 
    {
            $array['thread_id'] = $thread_id;
            if ($sender_id)  //if $sender_id  0, no one to exclude 
            {
                $array['user_id != '] = $sender_id;
            }
            
            $this->db->select('user_id, '.USER_TABLE_USERNAME, false);            
            $this->db->join(USER_TABLE_TABLENAME,'msg_participants.user_id ='.USER_TABLE_ID);
            $query = $this->db->get_where('msg_participants', $array);
            
            return $query->result_array();
    }

    private function _delete_participant($thread_id, $user_id)
    {
            $this->db->delete('msg_participants', array('thread_id'=>$thread_id, 'user_id'=>$user_id));
            if ($this->db->affected_rows() > 0)
            {    
                return true;
            }
            return false;
    }
    
    
    public function insert_work_application($workId,$tdsUid,$tmailId,$isAttachedProfile='f')
    {      
		   $expDays = '+'.$this->config->item('setExpiryWorkProfile').'days';
		   $expiryDate = date ('Y-m-d ', strtotime ( $expDays.date('Y-m-d')));  	  
		 
            $insert['workId'] 	           = $workId;
            $insert['tdsUid'] 	           = $tdsUid;
            $insert['tmailId']             = $tmailId;
            $insert['isAttachedProfile']   = $isAttachedProfile;
            $insert['expirydate']          = $expiryDate;
         
        // print_r($insert);die;

            $insert_id = $this->db->insert('WorkApplication', $insert);
            return $this->db->insert_id();
    }
    
  function getCount($user_id){
	  
			
		   $tableParticipants=$this->db->dbprefix($this->tableParticipants);		  
		   $tableMessages=$this->db->dbprefix($this->tableMessages);
		   $tableThreads=$this->db->dbprefix($this->tableThreads);
           $tableUser=$this->db->dbprefix($this->tableUserAuth);
           $tableUserShowcase=$this->db->dbprefix($this->tableUserShowcase);
          
			$sql='  SELECT count (p.id ) as id					
					FROM "'.$tableParticipants.'" p					
					WHERE p.user_id =  '.$user_id.' 
					AND p.is_sender = false AND p.status!=2 AND p.status!=3										
				';
			
			$query = $this->db->query($sql);
			$result=$query->row();
            return $result->id;
	}
	
	
	function getSentCount($user_id){
			
		   $tableParticipants=$this->db->dbprefix($this->tableParticipants);
		   $tableStatus=$this->db->dbprefix($this->tableStatus);
		   $tableMessages=$this->db->dbprefix($this->tableMessages);
		   $tableThreads=$this->db->dbprefix($this->tableThreads);
           $tableUser=$this->db->dbprefix($this->tableUserAuth);
           $tableUserShowcase=$this->db->dbprefix($this->tableUserShowcase);
           
			$sql=' SELECT count (p.id ) as id				
					FROM "'.$tableParticipants.'" p					
					WHERE p.user_id = '.$user_id.' 
					AND p.is_sender = true AND p.status!=2 AND p.status!=3					
				';
				
			$query = $this->db->query($sql, array($user_id, $user_id,$user_id,$user_id));
			//echo $this->db->last_query();
			//return $query->result_array();
			
			$result=$query->row();
            return $result->id;		
			
			
	}
	
	
	
	  function getTrashCount($user_id){
		  		   
           $tableParticipants=$this->db->dbprefix($this->tableParticipants);
		   $tableStatus=$this->db->dbprefix($this->tableStatus);
		   $tableMessages=$this->db->dbprefix($this->tableMessages);
		   $tableThreads=$this->db->dbprefix($this->tableThreads);
           $tableUser=$this->db->dbprefix($this->tableUserAuth);
           $tableUserShowcase=$this->db->dbprefix($this->tableUserShowcase);
			
			$sql=' SELECT count (p.id ) as id 					
					FROM "'.$tableParticipants.'" p					 
					WHERE p.user_id = '.$user_id.' 
					AND p.status = 2 
					
				';
			$query = $this->db->query($sql, array($user_id, $user_id));
            $result=$query->row();
            return $result->id;
	}
	
	
	
	/* View Tnail Popup Functionality */
	
	function getUserMessage($Uid,$curentUid=0)
	{    
		   //	$this->db->select('body,cdate,subject');
		    $this->db->select($this->tableMessages.'.* ,'.$this->tableUserShowcase.'.* ,'.$this->tableUserShowcase.'.profileImagePath as image ,'.$this->tableUserAuth.'.* ,'.$this->tableParticipants.'.id as status_id,is_sender');
			$this->db->from($this->tableMessages);
			
			$this->db->join($this->tableUserShowcase, $this->tableUserShowcase.'.tdsUid = '.$this->tableMessages.'.sender_id');
            $this->db->join($this->tableUserAuth, $this->tableUserAuth.'.tdsUid = '.$this->tableMessages.'.sender_id');
            $this->db->join($this->tableParticipants, $this->tableParticipants.'.msg_id = '.$this->tableMessages.'.id');            
			$this->db->where($this->tableParticipants.'.msg_id',$Uid);
			$this->db->where($this->tableParticipants.'.user_id',$curentUid);
			
			
			$query = $this->db->get();
			return $result=$query->result();
			
		}
		
		
		function isRead($Uid,$curentUid=0){						
			$status = array('status'=>1);											
			$this->db->where('msg_id',$Uid);
			$this->db->where('user_id',$curentUid);		
			$this->db->update($this->tableParticipants,$status);			
		}
		
		
		
		
	function getMaxNo($user_id,$type='Inbox'){		    
		   $tableParticipants=$this->db->dbprefix($this->tableParticipants);		  
		   $tableMessages=$this->db->dbprefix($this->tableMessages);
		   $tableThreads=$this->db->dbprefix($this->tableThreads);
           $tableUser=$this->db->dbprefix($this->tableUserAuth);
           $tableUserShowcase=$this->db->dbprefix($this->tableUserShowcase);
           
           if($type=='Inbox'){
				
				$whereMessage = "AND m.sender_id!= $user_id";				
				$whereTrash = "AND p.is_sender = false AND p.status!=2 AND p.status!=3";
				
		     } elseif($type=='Sent') {
				
			   $whereMessage = "AND m.sender_id= $user_id";			  
			   $whereTrash = "AND p.is_sender = true AND p.status!=2 AND p.status!=3";		
				
			} elseif($type=='Trash') {
				
			   $whereMessage = "";			 	
			   $whereTrash = "AND p.status = 2 ";
			   
			}
           
			 $sql=' SELECT max(m.id)					
					FROM "'.$tableParticipants.'" p
					JOIN "'.$tableThreads.'" t ON (t.id = p.thread_id)
					JOIN "'.$tableMessages.'" m ON (m.thread_id = t.id '.$whereMessage.')					
					WHERE p.user_id =  '.$user_id.' '.$whereTrash.' 				
				';			
			$query = $this->db->query($sql, array($user_id, $user_id,$user_id,$user_id));
						
			$result=$query->row();
			//echo $this->db->last_query(); die;
            return $result->max; 
			//$this->db->last_query();
		
		}	
		
		
	function getMinNo($user_id,$type='Inbox'){
		
			$tableParticipants=$this->db->dbprefix($this->tableParticipants);
			$tableStatus=$this->db->dbprefix($this->tableStatus);
			$tableMessages=$this->db->dbprefix($this->tableMessages);
			$tableThreads=$this->db->dbprefix($this->tableThreads);
			$tableUser=$this->db->dbprefix($this->tableUserAuth);
			$tableUserShowcase=$this->db->dbprefix($this->tableUserShowcase);
			
			if($type=='Inbox'){
				
				$whereMessage = "AND m.sender_id!= $user_id";				
				$whereTrash = "AND p.is_sender = false AND p.status!=2 AND p.status!=3";
				
		     } elseif($type=='Sent') {
				
			   $whereMessage = "AND m.sender_id= $user_id";			  
			   $whereTrash = "AND p.is_sender = true AND p.status!=2 AND p.status!=3";		
				
			} elseif($type=='Trash') {
				
			   $whereMessage = "";			 	
			   $whereTrash = "AND p.status = 2 ";
			   
			}
		     
		     
			$sql=' SELECT min(m.id)								
					FROM "'.$tableParticipants.'" p
					JOIN "'.$tableThreads.'" t ON (t.id = p.thread_id)
					JOIN "'.$tableMessages.'" m ON (m.thread_id = t.id '.$whereMessage.')									  
					WHERE p.user_id =  '.$user_id.' '.$whereTrash.' ';
								
			$query = $this->db->query($sql);			
			$result=$query->row();
            return $result->min; 		
		}	
		
		
		
		 function getnexTmail($contId,$user_id,$type){
			
		   $tableParticipants=$this->db->dbprefix($this->tableParticipants);
		   $tableStatus=$this->db->dbprefix($this->tableStatus);
		   $tableMessages=$this->db->dbprefix($this->tableMessages);
		   $tableThreads=$this->db->dbprefix($this->tableThreads);
           $tableUser=$this->db->dbprefix($this->tableUserAuth);
           $tableUserShowcase=$this->db->dbprefix($this->tableUserShowcase);
           
           if($type=='Inbox'){
				
				$whereMessage = "AND m.sender_id!= $user_id";				
				$whereTrash = "AND p.is_sender = false AND p.status!=2 AND p.status!=3";
				
		     } elseif($type=='Sent') {
				
			   $whereMessage = "AND m.sender_id= $user_id";			  
			   $whereTrash = "AND p.is_sender = true AND p.status!=2 AND p.status!=3";		
				
			} elseif($type=='Trash') {
				
			   $whereMessage = "";			 	
			   $whereTrash = "AND p.status = 2 ";
			   
			}
           
           
			$sql=' SELECT m.id,m.thread_id,m.body,m.priority,m.sender_id,m.cdate,
				p.id as status_id,p.status,
					m.subject,m.type,					
					u.username,u.email,
					up."firstName",	up."lastName" ,	up."profileImagePath" as image,up."creative",up."associatedProfessional",up."enterprise"									
					FROM "'.$tableParticipants.'" p
					JOIN "'.$tableThreads.'" t ON (t.id = p.thread_id)
					JOIN "'.$tableMessages.'" m ON (m.id = p.msg_id '.$whereMessage.')
					LEFT JOIN "'.$tableUser.'" u ON (u."tdsUid" = m.sender_id) 					
					LEFT JOIN "'.$tableUserShowcase.'" up ON (up."tdsUid" = m.sender_id)  						  
					WHERE m.id <  '.$contId.' AND p.user_id =  '.$user_id.' '.$whereTrash.'
					order by "m".id DESC 
					LIMIT 1
				';
			
			$query = $this->db->query($sql);
			//echo $this->db->last_query(); die;
			$result=$query->result();			
				if(isset($result[0]->id) && !empty($result[0]->id))	{  
					return $result;
				 }
				else{ 
					 return 0;
					}		
		}
		
		
		function getprevTmail($contId,$user_id,$type){
			
		   $tableParticipants=$this->db->dbprefix($this->tableParticipants);
		   $tableStatus=$this->db->dbprefix($this->tableStatus);
		   $tableMessages=$this->db->dbprefix($this->tableMessages);
		   $tableThreads=$this->db->dbprefix($this->tableThreads);
           $tableUser=$this->db->dbprefix($this->tableUserAuth);
           $tableUserShowcase=$this->db->dbprefix($this->tableUserShowcase);
           
           if($type=='Inbox'){
				
				$whereMessage = "AND m.sender_id!= $user_id";				
				$whereTrash = "AND p.is_sender = false AND p.status!=2 AND p.status!=3";
				
		     } elseif($type=='Sent') {
				
			   $whereMessage = "AND m.sender_id= $user_id";			  
			   $whereTrash = "AND p.is_sender = true AND p.status!=2 AND p.status!=3";		
				
			} elseif($type=='Trash') {
				
			   $whereMessage = "";			 	
			   $whereTrash = "AND p.status = 2 ";
			   
			}
           
			$sql=' SELECT
					m.id,m.thread_id,m.body,m.priority,m.sender_id,m.cdate,m.type,
					p.id as status_id,p.status,
					m.subject,					
					u.username,u.email,
					up."firstName",up."lastName" ,up."profileImagePath" as image,up."creative",up."associatedProfessional",up."enterprise"						
					FROM "'.$tableParticipants.'" p
					JOIN "'.$tableThreads.'" t ON (t.id = p.thread_id)
					JOIN "'.$tableMessages.'" m ON (m.id = p.msg_id '.$whereMessage.')					
					LEFT JOIN "'.$tableUser.'" u ON (u."tdsUid" = m.sender_id) 										
					LEFT JOIN "'.$tableUserShowcase.'" up ON (up."tdsUid" = m.sender_id)  					  
					WHERE m.id >  '.$contId.' AND p.user_id =  '.$user_id.' '.$whereTrash.'
					order by "m".id ASC 
					LIMIT 1
				';
			
			$query = $this->db->query($sql, array($user_id, $user_id,$user_id,$user_id));			
			$result=$query->result();
			//echo $this->db->last_query();die;
             if(isset($result[0]->id) && !empty($result[0]->id)){  
					return $result;
				 } else { 
					 	return 0;
					 }
		
		}		
		
		
		function getcravedUser($user_id,$sort=''){
			
		   $LogSummary=$this->db->dbprefix($this->LogSummary);
		   $LogCrave=$this->db->dbprefix($this->LogCrave);		   
           $tableUserShowcase=$this->db->dbprefix($this->tableUserShowcase);
           $tableUserAuth =$this->db->dbprefix($this->tableUserAuth);
           $tableUserProfile =$this->db->dbprefix($this->tableUserProfile);
           
           if(isset($sort) && $sort!='') {             
              $where = 'Where (up."firstName" ILIKE \'%'.$sort.'%\' OR 	up."lastName" ILIKE \'%'.$sort.'%\' OR 	u."enterpriseName" ILIKE \'%'.$sort.'%\') AND						 					  
					 c."ownerId" ='.$user_id.' AND c."tdsUid" !=  '.$user_id.' ' ;
		    } else {
				$where ='Where c."ownerId" ='.$user_id.' AND c."tdsUid" !=  '.$user_id.'';
				
				}            
         
           $sql=' SELECT  DISTINCT ON (c."tdsUid")
					up."firstName",up."lastName",u."creative",u."associatedProfessional",u."enterprise",u."enterpriseName",u."isPublished",
					c."projectType",a."email",a."active",a."banned",s."craveCount",c."tdsUid",s."viewCount",s."reviewCount",s."ratingAvg"
										
					FROM "'.$LogCrave.'" c
					LEFT JOIN "'.$tableUserShowcase.'" u ON (u."tdsUid" = c."tdsUid") 
					LEFT JOIN "'.$tableUserProfile.'" up ON (up."tdsUid" = c."tdsUid") 
					LEFT JOIN "'.$LogSummary.'" s ON (s."elementId" = u."showcaseId" AND s."entityId" = 93  )
					JOIN "'.$tableUserAuth.'" a ON (a."tdsUid" = c."tdsUid") 					
					'.$where.' 				
				';
	
		//echo $sql;die;	
			$query = $this->db->query($sql);			
			return $result=$query->result();
			
		/*
		$this->db->select($this->tableUserShowcase.'.*');
		$this->db->from($this->LogCrave);
		$this->db->join($this->tableUserShowcase, $this->tableUserShowcase.'.tdsUid ='.$this->LogCrave.'.tdsUid');
		//$this->db->join($this->LogSummary, $this->LogSummary.'.entityId='.$this->LogCrave.'.entityId' . " AND " . $LogSummary.'.elementId ='.$LogCrave.'.elementId');
		$this->db->join($this->LogSummary.' as ls', 'ls.entityId = '.$this->LogCrave.'.entityId AND ls."elementId"='.$LogSummary.'.elementId','left');
		$this->db->join($this->tableUserAuth, $this->tableUserAuth.'.tdsUid = '.$this->LogSummary.'.ownerId');
		$this->db->where($this->LogCrave.'.ownerId',$user_id);
		$this->db->where($this->LogCrave.'.ownerId !=',$user_id); 
		
		$query = $this->db->get(); 
		return $query->result();
			//echo $this->db->last_query();	*/
	
	}
		
		
		
		
		
		
	/* End */	
		
		function trashTmailMessage($Id,$currentUserId,$view){	
			//$Id =261;$currentUserId=22;
			if($view=='Trash')
			$status = array('status'=>3);					
			
			if($view!='Trash')
			$status = array('status'=>2);
			
			$this->db->where('id',$Id);		
			$this->db->update($this->tableParticipants,$status);				
			
		}
		
		
		/* Insert data in WP REquest */
		
		
    public function insert_work_request($senderId,$receiverId){
		
		    $expDays = '+'.$this->config->item('setExpiryWorkProfile').'days';		
		    $expiryDate = date ('Y-m-d ', strtotime ( $expDays.date('Y-m-d h:i:s')));		    
		    $acces_token = substr(number_format(time() * rand(),0,'',''),0,5);		  
		 
            $insert['sender_id'] 	    = $senderId;
            $insert['receiver_id'] 	    = $receiverId;           
            $insert['expiry_date']      = $expiryDate;
            $insert['access_token']     = $acces_token;
            
            $insert_id = $this->db->insert('WorkProfileUrlRequest', $insert);
             return $this->db->insert_id();
    }
		
		
	public function insert_attachments($attchment_id,$msg_id) {  		         
		  $insert['msg_id']  = $msg_id ;  
		  $insert_id = $this->db->insert('tmail_attachment', $insert);
		  return $this->db->insert_id();
    }	
		
	
	
	/** Insert Data in table in object form */
	
	function insertAttachmentIntoObject($Table,$data=array()){
			$table=$this->db->dbprefix($Table);
			$countData=count($data);
			$field='';
			$fieldValue='';
			
			if(is_array($data) && $countData > 0){
				$i=0;
				foreach($data as $key=>$value){
					$i++;
					$field.="".trim($key)."";
					$fieldValue.="'".trim($value)."'";
					if($i < $countData){
						$field.=',';
						$fieldValue.=',';
					}
				}				
					
			  $insertsql = 'INSERT INTO "'.$table.'" ('.$field.') VALUES ('.$fieldValue.')' ;
			  $query = $this->db->query($insertsql);
			  return $this->db->insert_id();
				
			}else{
				return false;
			}
	}
	
	
	// Work Applied For
	function getWorkAppliedFor($user_id){			
		   		  
		   $tableMessages=$this->db->dbprefix($this->tableMessages);		   
           $tableUser=$this->db->dbprefix($this->tableUserAuth);
           $tableUserShowcase=$this->db->dbprefix($this->tableUserShowcase);
           $tableWorkApplication = $this->db->dbprefix($this->tableWorkApplication);
           $tableWork = $this->db->dbprefix($this->tableWork);
           $tableMasterIndustry =  $this->db->dbprefix($this->tableMasterIndustry);
           $tableParticipants=$this->db->dbprefix($this->tableParticipants);
          
			$sql=' SELECT 
				    wa."workId",wa."tmailId",
				    w."tdsUid",w."workShortDesc",w."workTitle",w."workType",					
				    m.body,m.type,m.subject,
					p."status",p."id" as status_id,	
					u.username,u.email,
					up."firstName",up."lastName",up."profileImagePath" as imagePath,up."profileImageName" as image,up."creative",up."associatedProfessional",up."enterprise",				
					wa."dateApplied",wa."expirydate",
					i."IndustryName"					
					FROM "'.$tableMessages.'" m
					JOIN "'.$tableWorkApplication.'" wa ON (wa."tmailId" = m.id)
					JOIN "'.$tableWork.'" w ON (w."workId" = wa."workId") 
					JOIN "'.$tableUser.'" u ON (u."tdsUid" = w."tdsUid") 					
					JOIN "'.$tableUserShowcase.'" up ON (up."tdsUid" = w."tdsUid") 				
					JOIN "'.$tableMasterIndustry.'" i ON (i."IndustryId" = w."workIndustryId")
					JOIN "'.$tableParticipants.'" p ON (p."msg_id" = m."id")		
								
					WHERE wa."tdsUid" = '.$user_id.' AND p.is_sender = true AND p.status!=2 AND p.status!=3					
					order by wa."appId" DESC				
				';
			
			$query = $this->db->query($sql);
			$res = $query->result_array();
			$this->db->last_query();
			return $res;
	}	
		
	
	// Work Request Received
		
	function getWorkAppReceived($workId){
			
		   $tableMessages=$this->db->dbprefix($this->tableMessages);		   
           $tableUser=$this->db->dbprefix($this->tableUserAuth);
           $tableUserShowcase=$this->db->dbprefix($this->tableUserShowcase);
           $tableWorkApplication = $this->db->dbprefix($this->tableWorkApplication);
           $tableWork = $this->db->dbprefix($this->tableWork);
           $tableMasterIndustry =  $this->db->dbprefix($this->tableMasterIndustry);
           $tableAttachment = $this->db->dbprefix($this->tableAttachment);
           $tableRequestUrl = $this->db->dbprefix($this->tableRequestUrl);
           $tableParticipants=$this->db->dbprefix($this->tableParticipants);
          
			$sql=' SELECT DISTINCT ON (wa."appId")
				    wa."workId",wa."tdsUid",wa."isAttachedProfile",wa."tmailId",
				    w."workShortDesc",w."workCreateDate",w."workExpireDate",w."workType",				    
				    p."status",p."id" as status_id,					
				    m.body,m.type,m.subject,
					u.username,u.email,
					up."firstName",up."lastName",up."profileImagePath" as imagePath,up."profileImageName" as image,up."creative",up."associatedProfessional",up."enterprise",					
					wa."dateApplied",tr."expiry_date",
					i."IndustryName",
					(attachment).elementid,
					tr."sender_id",tr."access_token"
										
					FROM "'.$tableMessages.'" m
					JOIN "'.$tableWorkApplication.'" wa ON (wa."tmailId" = m.id)					
					JOIN "'.$tableUser.'" u ON (u."tdsUid" = m.sender_id) 					
					JOIN "'.$tableUserShowcase.'" up ON (up."tdsUid" = wa."tdsUid")  
					JOIN "'.$tableWork.'" w ON (w."workId" = wa."workId") 
					JOIN "'.$tableMasterIndustry.'" i ON (i."IndustryId" = w."workIndustryId") 
					LEFT JOIN "'.$tableAttachment.'" ta ON (ta."msg_id" = wa."tmailId") 
					LEFT JOIN "'.$tableRequestUrl.'" tr ON (attachment)."elementid" = tr."id"	
					LEFT JOIN "'.$tableParticipants.'" p ON (p."msg_id" = m."id")					
					WHERE wa."workId" = '.$workId.' AND p.is_sender = false AND p.status!=2 AND p.status!=3										
					order by wa."appId" DESC				
				';
//echo $sql;	die;			
			$query = $this->db->query($sql, array($workId));
			$res = $query->result_array();
			$this->db->last_query();
			return $res;
	}		
		
	function getEmailId($reseiverId) {		
		$this->db->select($this->tableUserAuth.'.email,'.$this->tableUserShowcase.'.firstName,'.$this->tableUserShowcase.'.lastName');
		$this->db->from($this->tableUserAuth);			
		$this->db->join($this->tableUserShowcase, $this->tableUserShowcase.'.tdsUid='.$this->tableUserAuth.'.tdsUid');	
		$this->db->where($this->tableUserAuth.'.tdsUid',$reseiverId);		
		$query =  $this->db->get();	
		//echo $this->db->last_query();die;
		$result = $query->result();					
		return $result;	
	}	
	
	
	function getReceiverId($Id,$threadId) {		
		$this->db->select('user_id');
		$this->db->from($this->tableParticipants);		
		$this->db->where($this->tableParticipants.'.is_sender','false');
		$this->db->where($this->tableParticipants.'.thread_id',$threadId);		
		$this->db->limit(1);
		
		$query =  $this->db->get();			
		$result = $query->result();					
		return $result;	
	}	
	
		
	function getAttacmentDetails($tmailId,$currentUserId) {
		
		  $tableMessages=$this->db->dbprefix($this->tableMessages);         
           $tableWorkApplication = $this->db->dbprefix($this->tableWorkApplication);          
           $tableAttachment = $this->db->dbprefix($this->tableAttachment);
           $tableRequestUrl = $this->db->dbprefix($this->tableRequestUrl);           
          
			$sql=' SELECT				   
					(attachment).elementid,
					tr."sender_id",
					tr."access_token"										
					FROM "'.$tableMessages.'" m
					LEFT JOIN "'.$tableWorkApplication.'" wa ON (wa."tmailId" = m.id)									
					LEFT JOIN "'.$tableAttachment.'" ta ON (ta."msg_id" = wa."tmailId") 
					LEFT JOIN "'.$tableRequestUrl.'" tr ON (attachment)."elementid" = tr."id"														
					WHERE wa."tmailId" = '.$tmailId.' AND wa."workOwnerId" ='.$currentUserId.'
					
				';
			$query = $this->db->query($sql);
			$res = $query->result_array();
			$this->db->last_query();
			return $res;		
	}
	
	
	function getWorkProfileAttach($tmailId,$currentUserId) {
		
		  $tableMessages=$this->db->dbprefix($this->tableMessages);         
          $tableAttachment = $this->db->dbprefix($this->tableAttachment);
          $tableRequestUrl = $this->db->dbprefix($this->tableRequestUrl);           
          
			$sql=' SELECT				   
					(attachment).elementid,
					tr."sender_id",
					tr."access_token"										
					FROM "'.$tableMessages.'" m
					LEFT JOIN "'.$tableAttachment.'" ta ON (ta."msg_id" = m.id) 
					LEFT JOIN "'.$tableRequestUrl.'" tr ON (attachment)."elementid" = tr."id"														
					WHERE m.id = '.$tmailId;
			$query = $this->db->query($sql);
			$res = $query->row_array();
			$this->db->last_query();
			return $res;		
	}
		
	  
	  
	   //get full thread
    function getMailThread($threadId='', $currentUserId='',$id=''){
               // $date = $this->getMsgCreationDate($id);                 
              //  $msd_date = $date[0]->cdate;
           $tableParticipants=$this->db->dbprefix($this->tableParticipants);
		   $tableStatus=$this->db->dbprefix($this->tableStatus);
		   $tableMessages=$this->db->dbprefix($this->tableMessages);
		   $tableThreads=$this->db->dbprefix($this->tableThreads);
           $tableUser=$this->db->dbprefix($this->tableUserAuth);
           $tableUserShowcase=$this->db->dbprefix($this->tableUserShowcase);
           //'AND m.cdate < p.cdate
           
           $sql = 'SELECT  DISTINCT ON ( m."id") m.*,p.id as pr_id,  t.subject,"'.$tableUserShowcase.'"."firstName",
					"'.$tableUserShowcase.'"."lastName",
					"'.$tableUserShowcase.'"."profileImagePath" as image,					
					u.username'. 
                ' FROM "'.$tableParticipants.'" p ' .
                ' JOIN "'.$tableThreads.'" t ON (t.id = p.thread_id) ' .
                ' JOIN "'.$tableMessages.'" m ON (m.thread_id = p.thread_id) ' .
                ' JOIN "'.$tableUser.'" u ON (u."tdsUid" = m.sender_id) '.
                ' JOIN "'.$tableUserShowcase.'" ON ("'.$tableUserShowcase.'"."tdsUid" = m.sender_id)  ' .
                ' WHERE p.user_id = ' .$currentUserId.
                ' AND p.thread_id = ' .$threadId.
                'AND m.cdate > p.cdate
                  GROUP BY m.id,  t.subject,p.id,"'.$tableUserShowcase.'"."firstName",
					"'.$tableUserShowcase.'"."lastName",
					"'.$tableUserShowcase.'"."profileImagePath" ,					
					u.username'.
				' order by m.id DESC'	
               ;          
       
            $query = $this->db->query($sql); 
			$res = $query->result_array();
			
				
            return $res;
    }
    
    
       //get full thread
    function getMailDetailsNewUser($threadId='', $currentUserId='',$id=''){
               // $date = $this->getMsgCreationDate($id);                 
              //  $msd_date = $date[0]->cdate;
           $tableParticipants=$this->db->dbprefix($this->tableParticipants);
		   $tableStatus=$this->db->dbprefix($this->tableStatus);
		   $tableMessages=$this->db->dbprefix($this->tableMessages);
		   $tableThreads=$this->db->dbprefix($this->tableThreads);
           $tableUser=$this->db->dbprefix($this->tableUserAuth);
           $tableUserShowcase=$this->db->dbprefix($this->tableUserShowcase);
           //'AND m.cdate < p.cdate
           
           $sql = 'SELECT  DISTINCT ON ( m."id") m.*,p.id as pr_id,  t.subject FROM "'.$tableParticipants.'" p ' .
                ' JOIN "'.$tableThreads.'" t ON (t.id = p.thread_id) ' .
                ' JOIN "'.$tableMessages.'" m ON (m.thread_id = p.thread_id) ' .
                ' WHERE p.user_id = ' .$currentUserId.
                ' AND p.thread_id = ' .$threadId.
                'AND m.cdate > p.cdate  order by m.id DESC'	
               ;
            
       
            $query = $this->db->query($sql); 
			$res = $query->result_array();
			
				
            return $res;
    }
    
    function getMsgCreationDate($id){	
		$this->db->select('cdate');
		$this->db->from($this->tableParticipants);		
		$this->db->where($this->tableParticipants.'.id',$id);
		$query = $this->db->get(); 
		return $query->result();	
		
		}    
	  
	 
	 private function _delete_statuses($thread_id, $user_id)
    {
			$tableMessages=$this->db->dbprefix($this->tableMessages);
          
            $sql = 'DELETE s FROM msg_status s ' .
                   ' JOIN "'.$tableMessages.'" m ON (m.id = s.message_id) ' .
                   ' WHERE m.thread_id = ?  ' .
                   ' AND s.user_id = ? ';
            $query = $this->db->query($sql, array($thread_id, $user_id));
            return true;
    }
    
    
   function getThreadId($msg_id){
            $query = $this->db->select('thread_id')->get_where($this->tableMessages, array('id' => $msg_id));
            if ($query->num_rows()){
                return $query->row()->thread_id;
            }
            return 0;
    }
    
     function getSenderId($msg_id){
            $query = $this->db->select('sender_id')->get_where($this->tableMessages, array('id' => $msg_id));
            if ($query->num_rows()){
                return $query->row()->sender_id;
            }
            return 0;
    }
    
    
    
    function getProductAttacment($tmailId) {
		
		   $tableMessages=$this->db->dbprefix($this->tableMessages);                   
           $tableAttachment = $this->db->dbprefix($this->tableAttachment);
           $tableProduct   =$this->db->dbprefix($this->tableProduct);       
          
			$sql=' SELECT				   
					(attachment).elementid,tp."tdsUid"														
					FROM "'.$tableMessages.'" m														
					LEFT JOIN "'.$tableAttachment.'" ta ON (ta."msg_id" = m."id")					
					LEFT JOIN "'.$tableProduct.'" tp ON tp."productId" = (attachment)."elementid" 																			
					WHERE m."id" = '.$tmailId.' 
					
				';
			$query = $this->db->query($sql);
			$res = $query->result_array();
			$this->db->last_query();
			return $res;		
	}
    
    
    
    function get_user_unread_tmail($user_id){
			
		   $tableParticipants=$this->db->dbprefix($this->tableParticipants);		  
		   $tableMessages=$this->db->dbprefix($this->tableMessages);
		   $tableThreads=$this->db->dbprefix($this->tableThreads);
           $tableUser=$this->db->dbprefix($this->tableUserAuth);
           $tableUserShowcase=$this->db->dbprefix($this->tableUserShowcase);
          
			$sql=' SELECT "m".id,"m".thread_id,"m".body,"m".priority,"m".sender_id,"m".cdate,	"m".type,	
					p.status,p.id as status_id,					
					m.subject,
					u.username,	u.email,
					up."profileImageName",up."firstName",up."lastName",up."profileImagePath" as image,up."creative",up."associatedProfessional",up."enterprise"	
					FROM "'.$tableParticipants.'" p
					JOIN "'.$tableThreads.'" t ON (t.id = p.thread_id)
					JOIN "'.$tableMessages.'" m ON (m.id = p.msg_id AND m.sender_id!= '.$user_id.')					
					LEFT JOIN "'.$tableUser.'" u ON (u."tdsUid" = m.sender_id) 
					LEFT JOIN "'.$tableUserShowcase.'" up ON (up."tdsUid" = m.sender_id)  
					WHERE p.user_id =  '.$user_id.' AND p.is_sender = false AND p.status=0 order by "p".id DESC 
				';
			//echo $sql;	die;
				
			
			$query = $this->db->query($sql);
			if($query->num_rows()>0)
			{
				$res = $query->num_rows();
			}else
			{
				$res = 0;
			}
            return $res;
	}
	
	/*
	 * Function used to add attachment for collaboration 
	 */
	private function _insert_collaboration_attachment($file_id,$msg_id)
    {
		$insert['msg_id']  = $msg_id;
		$insert['fileId']  = $file_id;  
		$insert_id = $this->db->insert('tmail_attachment', $insert);
		return $this->db->insert_id();
    }
	 
	/*
	 * Function used to get msg attachment data
	 */
	public function getAttachmentData($msgId) {
		$this->db->select('ta.fileId,ta.id');
		$this->db->select('mf.filePath,mf.fileName,mf.jobStsatus,mf.rawFileName');
		$this->db->from($this->tableAttachment.' as ta');
		$this->db->join($this->tableMediaFile.' as mf', 'ta.fileId=mf.fileId');
		$this->db->where(array('ta.msg_id'=>$msgId));
		$this->db->limit(1);
		$query = $this->db->get();
		return $result = $query->row();
	} 
	    
    
}

/* end of file model_tmail.php */
