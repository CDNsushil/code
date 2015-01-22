<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Chatching admin Model Class
 * It include functionality to fetch/add/edit Page content for logged in admin 
 * @category	Model
 * @author		CDN Solutions
 */

Class Admin_model extends CI_Model{

	private $read_db;//private variable
	/**
	* Constructor
	**/	
	public function __construct(){
		parent::__construct();
	}

	/**
	* Function To check admin details in the database for login
	**/
	public function login($username){
		$this->db->select('UserAuth.*');
		$this->db->select('UserShowcase.firstName,UserShowcase.lastName,enterprise,enterpriseName');
		$this->db->join('UserProfile', 'UserProfile.tdsUid = UserAuth.tdsUid');
		
		$this->db->join('UserShowcase', 'UserShowcase.tdsUid = UserAuth.tdsUid');
		$this->db->where('email',$username);
		//$this->db->where_in('password', array(md5($password),encode($password), sha2($password)));
		//$this->read_db->where('password',$password);
		//$this->read_db->where('user_role != ','0');
		//return $this->read_db->get('user'); // please do not change user to admin, user_role defined in user table
		$this->db->where('active',1);
		$this->db->where('group',4);
		$this->db->from('UserAuth');
		$query = $this->db->get();
		if ($query->num_rows()) 
		{
			$result = $query->row();
		}else
		{
			$result = 0;
		}
		// echo $this->db->last_query();die;
		return $result;
	}
	
	/**
	* Function to Fetch list of all pages from database
	**/
	public function get_pages(){
		return $this->read_db->get('pages');
	}
	
	/**
	* Function to fetch content of single page from database
	**/
	public function get_single_page($id,$language_id){
		$this->read_db->select('*');
		$this->read_db->from('pages');
		$this->read_db->join('page_contents', 'pages.page_id = page_contents.page_id');
		$this->read_db->where('page_contents.page_id',$id);
		$this->read_db->where('page_contents.language_id',$language_id);
		//print_r($this->read_db->get());
		return $this->read_db->get();
	}
	/**
	* Function to fetch language code by name
	**/
	public function get_language_code($language_name)
	{
		$this->read_db->select('language_id');
		$this->read_db->from('language');
		$this->read_db->where('language',$language_name);
		$q =  $this->read_db->get();
		return $q->row()->language_id;
	}
	
	/*
	*	function get page content by key
	*/
	public function get_page_content_by_key($key=false,$withHtml=true){
		if($key){
			$this->read_db->select('page_content');
			$this->read_db->from('page_contents');
			$this->read_db->where('page_contents.page_key',$key);			
			$content	=	$this->read_db->get();
			$content	=	$content->row();
			$content	=	$content->page_content; 			
			if($content=='')
			$content	= 	 	$this->lang->line('register_value_terms');
			
			if(!$withHtml)
			$content	=		stripHTMLtags($content);
		
			return $content;
		}
		else{
			return '';	
		}
	}  
	
	
	
	/**
	* Function to Add/Edit the page
	**/
	public function edit_page($content_id,$page_arr){
		$num = $this->check_lang($page_arr['page_id'],$page_arr['language_id']);
		if($num['num'] == 0){
			return $this->db->insert('page_contents',$page_arr);
		}else{
			//$this->db->where('page_content_id',$content_id);
			$this->db->where('page_id',$page_arr['page_id']);
			$this->db->where('language_id',$page_arr['language_id']);
			if($this->db->update('page_contents',$page_arr))
			{
				$this->db->where('page_id',$page_arr['page_id']);
				$this->db->set('updated_date',date('y-m-d h:i:s'));
				return $this->db->update('pages');
			}
		}
	 }
	
	/**
	* Function to fetch availabel Languages from the database
	**/
	public function get_lang(){
		$result = $this->read_db->get('language');
		return $result->result();
	}
	
	/**
	* Function to check if the page is exist in the database
	**/
	public function check_lang($page_id,$lang_id){
		$this->read_db->where('page_id',$page_id);
		$this->read_db->where('language_id',$lang_id);
		$result = $this->read_db->get('page_contents');
		$data['num'] 	 = $result->num_rows();
		$data['results'] = $result->result();
		return $data;			
	}
	
	function get_country_list(){
		$this->read_db->select('country_id,country_name');
		$this->read_db->from('country');
		//$this->db->limit(10);
		return $this->read_db->get();	
	}
	
	function get_state_list($country_id,$start='',$limit=''){
		$this->read_db->where('country_id',$country_id);
		if($limit !=""){
			$this->read_db->limit($limit,$start);	
		}
		$result = $this->read_db->get('state');
		return $result;
	}
	
	function update_state($state_id,$ins_value){
		$this->db->where('state_id',$state_id);
		$this->db->set('is_under_incentive_program',$ins_value);
		$state_update = $this->db->update('state');
		if($state_update && $ins_value==0){
			$this->update_user_alert($state_id);	
		}
		if($state_update && ($ins_value==1))
		{
			/*--------------notification check----------------*/
			$qualified_users = $this->get_qualified_users_by_state($state_id);
			foreach($qualified_users as $users){
							$to 		= get_email($users->user_id);
							$to_name 	= get_username($users->user_id);
							$mail_head_data = array('to'=>$to);
							$mail_body_data = array('host_name'=>$to_name);
							$notification_type_id = 53;
							$notification_post_user = check_notification($users->user_id,$notification_type_id);
							if(!empty($notification_post_user)){ 
								if($notification_post_user[0]->email==1){ 
									$this->email_template->send_email('__state_now_equity_program_notification___',$mail_head_data,$mail_body_data);			
								}
								if($notification_post_user[0]->sms==1){   /*--1 for check user had activated the sms notification--*/
								/*--sms code here--*/	
								}
						}
			}
			/*--------------notification check----------------*/	
		}
		return $state_update;
	}
	
	
	function get_qualified_users_by_state($state_id){
			/*-----Get age by state id------*/
			$this->read_db->select('age_limit');
			$this->read_db->from('state');
			$this->read_db->where('state_id',$state_id);
			$query = $this->read_db->get();
			$res = $query->result();
			$age_limit = $res[0]->age_limit;
			$date_of_age_limit = date("Y-m-d", strtotime("-".$age_limit." Year"));
			/*-----------------*/
			$this->read_db->select('user_profile.user_id');
			$this->read_db->where('user_profile.state_id',$state_id);
			$this->read_db->where('user.dob <=',$date_of_age_limit);
			$this->read_db->from('user_profile');
			$this->read_db->join('user','user_profile.user_id=user.user_id');
			$users_resource_id = $this->read_db->get();
			$users_list = $users_resource_id->result();
			return $users_list;
		}
	
	function update_user_alert($state_id){
		$this->db->where('state_id',$state_id);
		$this->db->set('last_alert','0000-00-00');
		$this->db->set('is_register_for_points','0');
		return $this->db->update('user_profile');
	}

/*--functions by piyush jain--*/

	/**
	* Get current user password
	*/
	function get_user_password($user_id) {
		$this->read_db->select('password');
		$this->read_db->where('user_id', $user_id); 
		$query=$this->read_db->get('cc_admin');
		return $query->result();	
	}


	/**
	*Update Password
	*/
	function update_password($password,$user_id){
		$this->db->update("cc_admin", $password, array('user_id' => $user_id));
	}
	
	/**
	*Get user activity points
	*@Params User id, start ,limit
	*@return Array
	*/
 	function get_user_points($activity_id=0,$user_id,$page='',$perpage='') {
		
		$start=0;
		$start=($page-1)*$perpage;

		if($activity_id!=0){
			$this->read_db->where('cc_point.activity_id',$activity_id);
		} 
	
		$this->read_db->select('cc_user.user_id,cc_user.username,cc_user.firstname,cc_user.lastname,cc_point.point,cc_point.point_id,cc_point.datetime,cc_activity.activity_name');
		$this->read_db->from('cc_user');

		$this->read_db->join('cc_point', 'cc_point.user_id = cc_user.user_id');
		$this->read_db->join('cc_activity', 'cc_activity.activity_id = cc_point.activity_id');
		
		$this->read_db->where('cc_user.user_id', $user_id);
		$this->read_db->order_by("cc_point.datetime",'desc');

		if($perpage!=0){		
			$this->read_db->limit($perpage,$start);
		}	 
		$result	 =  $this->read_db->get();
		return $result->result();
	}	


	/**
	*Get user total points
	*@Params User id
	*@return Array
	*/
 	function get_total_user_points($user_id) {	
		$this->read_db->select_sum('cc_point.point');
		$this->read_db->where('cc_point.user_id', $user_id);
		$query = $this->read_db->get('cc_point');
		return $query->result();
	}	
	
	/**
	*Delete_points
	*@Params point id
	*/
	function delete_points($point_id)  {
       $user_array = $this->session->userdata('session_data'); 
       $admin_id = $user_array['user_id'];
	   $success = $this->save_data_deleted_point($point_id,$admin_id);
       if($success){
            return $this->db->delete('cc_point', array('point_id' => $point_id)); 	
       }
	}
	
    
    private function get_point_tobe_delete($point_id){
        $this->db->where('point_id',$point_id);
        $result = $this->db->get('cc_point');
        if($result->num_rows()>0){
             return $result->row();  
        }else{ return FALSE; }
    }
    
    function save_data_deleted_point($point_id,$admin_id){
        $point_data = $this->get_point_tobe_delete($point_id);
        if($point_data){
             $data = array(
                'transaction_id'=>$point_data->transaction_id,
                'user_id'=>$point_data->user_id,
                'activity_id'=>$point_data->activity_id,
                'point'=>$point_data->point,
                'friend_id'=>$point_data->friend_id,
                'child_id'=>$point_data->child_id,
                'datetime'=>$point_data->datetime,
                'delete_by_id'=>$admin_id
             );
             $success = $this->db->insert('deleted_points',$data);
             if($success){
                 return TRUE;   
             }else{
                 return FALSE;
             }
      }else{
          return FALSE;
      }
    }
	
	/**
	*update user activity points
	*@Params point id, point array
	*@return bool
	*/
	function update_points($pointarr,$point_id) {
		$res = $this->db->update('cc_point', $pointarr, array('point_id' =>$point_id));  
		return $res;	
	}

         /**
	*update  points log
	*@Params point id, point array
	*@return bool
        * Amit Wali
        * 11-07-12   
	*/
	function update_points_log($point_id,$old,$new) {
               
                 $curdate = date('Y-m-d H:m:s');               
                 $data = array('user_id'=>$old[0]->user_id,'activity_id'=>$point_id,
                 'old_value'=>$old[0]->point,'new_value'=>$new,'updated_at' =>$curdate);
                // print_r($data );die;
		 $this->db->insert('cc_points_log',$data);                

	}


	
	/**
	*Get point of particular user
	*@Params point id
	*@return array
	*/
	function get_point_by_id($point_id) {
		$this->read_db->select('cc_point.point,cc_point.user_id');
		$this->read_db->where('cc_point.point_id',$point_id);
		$query = $this->read_db->get('cc_point');
		return $query->result();
	}
	
	/**
	*Get user activities
	*@Params user id, activity id, page, perpage
	*@return array
	*/
 	function get_user_activity($user_id=0,$activity_id=0,$page=0,$perpage=0) {
		$start=0;
		$start=($page-1)*$perpage;
		
		if($user_id!=0){
			$this->read_db->where('cc_point.user_id',$user_id);
		}
		if($activity_id!=0){
			$this->read_db->where('cc_point.activity_id',$activity_id);
		} 		
 		
		$this->read_db->select('cc_point.user_id,cc_point.point,cc_point.activity_id,cc_point.datetime,cc_user.username,cc_user.firstname,cc_user.lastname,cc_activity.activity_name');
		$this->read_db->from('cc_point');
		$this->read_db->join('cc_user', 'cc_user.user_id = cc_point.user_id');
		$this->read_db->join('cc_activity', 'cc_activity.activity_id = cc_point.activity_id');
		$this->read_db->order_by("cc_point.datetime",'desc');
		
		if($perpage!=0){		
			$this->read_db->limit($perpage,$start);
		}	
		 
		$result=$this->read_db->get();
		return $result->result();
	}

	
	/**
	*Get all user first name & last name
	*@Params 
	*@return array
	*/
 	function get_all_users() {
		$this->read_db->select('cc_user.user_id,cc_user.username,cc_user.firstname,cc_user.lastname');
		$this->read_db->distinct('cc_user.user_id');
		$this->read_db->from('cc_user');
		$this->read_db->join('cc_point','cc_point.user_id=cc_user.user_id');
		$result=$this->read_db->get();
		return $result->result();
	}
	
	/**
	*Get all activity names
	*@Params 
	*@return array
	*/
 	function get_activity_names() {
		$this->read_db->select('activity_id,activity_name');
		$this->read_db->from('cc_activity');
		$result=$this->read_db->get();
		return $result->result();
	}	
	
	/**
	*Get user and activity search result
	*@Params user id, activity id, page, perpage
	*@return array
	*/
	function get_search_user_activity($user_id=0,$activity_id=0,$page=0,$perpage=0) {
		$start=0;
		if($page!=0){
			$start=($page-1)*$perpage;
		}
		
		$this->read_db->select('user_id,activity_id');
		if($user_id!=0){
			$this->read_db->where('cc_point.user_id',$user_id);
		}
		if($activity_id!=0){
			$this->read_db->where('cc_point.activity_id',$activity_id);
		}
		
		$result=$this->read_db->get('cc_point',$start,$perpage);
		
		return $result->result();
		
	}

	/**
	*Get all support q and ans
	*@Params start, limit
	*@return array
	*/
 	function get_support_q_a($user_id=0,$ans_status='',$page=0,$perpage=0) {
		$start=0;
		if($page!=0){
			$start=($page-1)*$perpage;
		}
		
		if($user_id!=0){
			$this->read_db->where('cc_admin_support_question.user_id',$user_id);
		}
		if($ans_status==1){
			$this->read_db->where('cc_admin_support_question.is_answered',1);
		}
		if($ans_status==2){
			$this->read_db->where('cc_admin_support_question.is_answered',0);
		}
		$this->read_db->select('cc_admin_support_question.question_id,cc_admin_support_question.question
		,cc_admin_support_question.user_id,cc_admin_support_question.datetime as q_date,cc_user.username,cc_user.firstname,cc_user.lastname,
		cc_admin_support_answer.answer_id,cc_admin_support_answer.answer,cc_admin_support_answer.datetime as a_date');

		$this->read_db->from('cc_admin_support_question');

		$this->read_db->join('cc_admin_support_answer', 'cc_admin_support_answer.question_id =
 		cc_admin_support_question.question_id','LEFT');

		$this->read_db->join('cc_user', 'cc_user.user_id = cc_admin_support_question.user_id');

		$this->read_db->order_by("cc_admin_support_question.datetime",'desc');

		if($perpage!=0){		
			$this->read_db->limit($perpage,$start);
		}

		$result=$this->read_db->get();
		return $result->result();
	}
	
	/**
	*Get q by question id
	*@Params question id
	*@return array
	*/
	function get_question_by_qid($q_id) {
	$this->read_db->select('cc_admin_support_question.question_id,cc_admin_support_question.question
	,cc_admin_support_answer.answer,cc_admin_support_answer.answer_id,cc_admin_support_question.user_id,cc_user.email,cc_user.firstname,cc_user.lastname,cc_user.user_id');

	$this->read_db->from('cc_admin_support_question');

	$this->read_db->join('cc_admin_support_answer', 'cc_admin_support_answer.question_id =
 		cc_admin_support_question.question_id','LEFT');
	$this->read_db->join('cc_user', 'cc_admin_support_question.user_id=cc_user.user_id','LEFT');
	$this->read_db->where('cc_admin_support_question.question_id',$q_id);

	$query=$this->read_db->get();
	
	return $res=$query->result();
	}
	
	/**
	*Insert support answer
	*@Params answer array
	*@return bool
	*/
	function insert_support_a($ansarr,$q_id){
	$res=$this->db->insert('cc_admin_support_answer',$ansarr); 
	$this->update_support_question_status($q_id);
	return $res;
	}
	
	/**
	*Update support question is answered status
	*@Params 
	*@return bool
	*/
	function update_support_question_status($q_id){
		$res=$this->db->update('cc_admin_support_question', array('is_answered'=>1), array('question_id' =>$q_id));  
		return $res;	
	}
	
	/**
	*Update support answer
	*@Params answer array, answer id
	*@return bool
	*/
	function update_support_answer($answer_arr,$answer_id){
		$res=$this->db->update('cc_admin_support_answer', $answer_arr, array('answer_id' =>$answer_id));  
		return $res;	
	}
	
	/**
	*get total answered q
	*@Params 
	*@return count
	*/
	function get_total_ans(){
		$this->read_db->select('cc_admin_support_answer.answer');
		$this->read_db->from('cc_admin_support_answer');  
		$query = $this->read_db->get();
		$res   = $query->num_rows();
		return $res;	
	}
	
	/**
	*get total questions
	*@Params 
	*@return count
	*/
	function get_total_questions(){
		$this->read_db->select('cc_admin_support_question.question');
		$this->read_db->from('cc_admin_support_question');  
		$query = $this->read_db->get();
		$res   = $query->num_rows();
		return $res;	
	}
	/**
	*Insert reward point
	*@Params answer array
	*@return bool
	*/
	function insert_reward_point($reward_point_arr,$user_id){
	$this->db->insert('cc_transaction',$reward_point_arr); 
	$tr_id  =$this->db->insert_id();
	$reward_point_arr['transaction_id']=$tr_id;
	$res=$this->db->insert('cc_point',$reward_point_arr); 
	return $res;
	}
	/******* End Piyush **************/

function update_age_limit()
{
	
	$state_id 	= $this->input->post('state_id');
	$update_age = $this->input->post('update_age');
	
	$data = array(
               'age_limit' => $update_age
            );

		$this->db->where('state_id', $state_id);
		$this->db->update('state', $data); 
}


/** Get Advertisement  list
 * Return Array
 * Created : 30-5-2012
 * */
function get_advertisment_list($start='', $limit='')
{

			$user_id = $this->input->post('user_id');
			if($user_id)
			{
				$query = $this->read_db->query('select b.*,u.username,u.email from ox_banners As b JOIN cc_user As u on u.user_id=b.user_id WHERE b.user_id='.$user_id);
			} else if($limit !=""){
					$query = $this->read_db->query('select b.*,u.username,u.email from ox_banners As b JOIN cc_user As u on u.user_id=b.user_id LIMIT '.$start.', '.$limit);
				} else { 
					$query = $this->read_db->query('select b.*,u.username,u.email from ox_banners As b JOIN cc_user As u on u.user_id=b.user_id ');
				}
			
		return $query->result();
}

/** Delete common function 
 * Return boolean
 * Created : 30-5-2012
 * */
function delete_common($delete_id,$delete_field,$table_name,$table_type)
{
	if($table_type=="custom")
	{
		$query = $this->db->query("delete from ".$table_name." where ".$delete_field."=".$delete_id);
	}
}

/** Status common
 * Return boolean
 * Created : 30-5-2012
 * */
function status_ch_common($data_id,$update_status,$status_field,$table_name,$table_type)
{
	if($table_type=="custom")
	{
		$query = $this->db->query("update ".$table_name." set published=".$update_status." where ".$status_field."=".$data_id);
	}
}

/** Get Advertisement user list
 * Return Array
 * Created : 31-5-2012
 * */
 function get_advertisement_users()
 {
	 $query = "SELECT DISTINCT user.firstname,user.lastname,user.user_id FROM cc_user as user,ox_banners as banner";
	 $query.=" WHERE banner.user_id=user.user_id";
	 $query_execute = $this->read_db->query($query);
	 return $query_execute->result();
 }

 function get_num_invite_report()
 {
	$query =  $this->read_db->get('invite_report');
	return $query->num_rows();
 }
 

 function get_num_manage_activity()
 {
	$query =  $this->read_db->get('admin_activity');
	return $query->num_rows();
 }

 
 
 function get_invite_report($num, $offset)
 {
	 $query =  $this->read_db->get('invite_report',$num,$offset);
	 return $query->result();
 }


	/**
		Function for display all record of a day which perform by a admin	
	*/
 
  function get_admin_activity($num, $offset)
  {
 		
		$this->read_db->select('*');
		$this->read_db->from('admin_activity');
//		$this->read_db->group_by("create_date");		
		$this->read_db->order_by("create_date",'desc');

		$this->read_db->limit($num,$offset);
		 
		$result=$this->read_db->get();

		return $result->result();
		
  } 
 
/*
* @Input : advertisment id
* @Output : advertisment info
* Comment : Function for get information about advertisment
*/
 function get_ads_detail($ads_id)
	{		
		$query  ='select b.*,payment.*,u.username,u.email ';
		$query .='from ox_banners As b ';
		$query .='JOIN cc_user As u on u.user_id=b.user_id ';
		$query .='LEFT JOIN cc_ad_payment As payment on payment.bannerid=b.bannerid ';
		$query .='WHERE  b.bannerid='.$ads_id;
		
		$ads_result = $this->read_db->query($query);	
		return 	$ads_result->row();
	}
 
 
/**
* Function for save admin activities
* Return boolean
*/ 
 function manage_activity($userId,$module_name,$module_summary,$module_action)
 {

 		// Get admin type by user id
 		$admin_type = $this->get_admin_type($userId);
	 	

	$data = array(
	   'admin_type' => $admin_type ,
	   'admin_id' => $userId ,
	   'module_name' => $module_name,
		'module_summary' => $module_summary,
	   'module_action' => $module_action,
	   'status' => '1',
	 );

	$this->db->insert('admin_activity', $data); 
 } 
 
// Function for get user type by user id
 
 function get_admin_type($user_id)
 {
 		$query  ='select user_type ';
		$query .='from cc_user_roll_type As roll_type,cc_user as user';
		$query .=' WHERE  user.user_role='.$user_id;
		$query .=' AND  user.user_role = roll_type.role_id limit 0,1';
		
		$result_exe = $this->read_db->query($query);	
		$result =  $result_exe->row();
		return $result->user_type;
 }


//function to get charity page list

function get_charity_page_list()
{
    $this->db->where('action_category_id','6');
    $obj_data = $this->db->get('cc_page');
    $result = $obj_data->result();
    return $result;
}

//function to get charity page list

function update_charity_page($page_id,$page_status)
{
    $this->db->where('page_id',$page_id);
    $this->db->set('page_status',$page_status);
    $obj_data = $this->db->update('cc_page');
    return $obj_data;
}

	//Function to get title of a section
	// pera 1 - tablename, 2 - title for display , 3 - table primary key , 4 - id 
	function get_activity_title($tab_name,$tab_title,$tab_id,$id)
	{
		
		$query = $this->read_db->query('select '.$tab_title.' from '.$tab_name.' WHERE '.$tab_id.'='.$id);
		return $query->result();	
	}



}//End of Class Admin_model

/* End of file admin_model.php */
/* Location: ./application/models/admin_model.php */
