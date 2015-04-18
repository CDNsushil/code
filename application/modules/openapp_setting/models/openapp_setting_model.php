<?php

class Openapp_setting_model extends CI_model{

	private $read_db;
	/**
	* Constructor
	*/
	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->read_db = $this->load->database('read', TRUE);


	}

	public function get_person_applications($user_id) {
     $ret = array();
  //  include_once PartuzaConfig::get('models_root') . "/oauth/oauth.php";
   // include_once "oauth.php";
     $res = $this->read_db->query("select cc_applications.*, cc_person_applications.id as mod_id from cc_person_applications, cc_applications where cc_person_applications.person_id = $user_id and cc_applications.id = cc_person_applications.application_id");
	foreach($res->result() as $row) {
      //$this->add_dependency('applications', $row['id']);
      $row->user_prefs = $this->get_application_prefs($user_id, $row->id);
      $row->oauth = $this->oauth_model->get_gadget_consumer($user_id);
      $ret[] = $row;
    }
    return $ret;
  }




  /**************************************/
  //	Get all application
  /**************************************/
  public function get_all_applications($title='',$cat='',$page=0,$perpage=0) {

	$start=0;
		$start=($page-1)*$perpage;

	$ret = array();

  //  include_once PartuzaConfig::get('models_root') . "/oauth/oauth.php";
   // include_once "oauth.php";
	$q = "select cc_applications.*, cc_person_applications.id as mod_id,person_id, 	cc_person_applications.app_category_id 	 from cc_person_applications, cc_applications where cc_applications.id = cc_person_applications.application_id and approved='Y'";
	if(!empty($title)){
		$q.=" and cc_applications.title like '%$title%' or description like '%$title%'";
	}
	if(!empty($cat)){
		$q.=" and cc_person_applications.app_category_id='$cat'";
	}
	$q.=" ORDER BY modified DESC";
	if($perpage!=0){
		$q.=" limit $start,$perpage";
	}
   $res = $this->read_db->query($q);

	foreach($res->result() as $row) {

      $row->user_prefs = $this->get_application_prefs1($row->id);
      $row->oauth = $this->oauth_model->get_gadget_consumer($row->id);
      $row->star_rating = $this->get_apps_star_rating($row->id);
	  $ret[] = $row;
    }
    return $ret;
  }

   public function get_app_categories(){
	  $query = $this->read_db->query('select * from cc_app_category');
	  $res   = $query->result();
	  return $res;
	   }

  /**************************************/
			//Remove Application
  /**************************************/
  public function remove_application($person_id, $app_id, $mod_id) {
	$person_id = addslashes($person_id);
    $app_id = addslashes($app_id);
    $mod_id = addslashes($mod_id);
    $res = $this->db->query("delete from cc_person_applications where id = $mod_id and person_id = $person_id and application_id = $app_id");
    $res1 = $this->db->query("delete from cc_applications where id = $app_id");
	return ($res != 0 && $res1 != 0);
    //$this->invalidate_dependency('person_applications', $person_id);

  }
  /**************************************/
 public function get_application_prefs1($app_id) {
    $prefs = array();
    $res = $this->read_db->query("select name, value from cc_application_settings where application_id = $app_id ");
    foreach($res->result() as $name =>$value) {
	  $prefs[$name] = $value;
    }
    return $prefs;
  }


  public function get_application_prefs($person_id, $app_id) {
    $prefs = array();
    $res = $this->read_db->query("select name, value from cc_application_settings where application_id = $app_id and person_id = $person_id");
    foreach($res->result() as $name =>$value) {
	  $prefs[$name] = $value;
    }
    return $prefs;
  }

   public function add_application($person_id, $app_url,$app_category) {
    $mod_id = false;
	$app = $this->get_application($app_url);
	$app_id = isset($app['appid']) ? $app['appid'] : false;
    $error = $app['error'];
	if ($app_id && empty($error)) {
      // we now have a valid gadget record in $info, with no errors occured, proceed to add it to the person
      // keep in mind a person -could- have two the same apps on his page (though with different module_id's) so no
      // unique check is done.
      $this->db->query("insert into cc_person_applications (id, person_id, application_id,app_category_id) values (0, $person_id, $app_id,$app_category)");
      $mod_id = $this->db->insert_id();
    }
    return array('app_id' => $app_id, 'mod_id' => $mod_id, 'error' => $app['error']);
  }

   // This function either returns a valid applications record or
  // the error (string) that occured in ['error'].
  // After this function you can assume there is a valid, and up to date gadget metadata
  // record in the database.
  public function get_application($app_url) {
    $error = false;
    $info = array();
    // see if we have up-to-date info in our db. Cut-off time is 1 day (aka refresh module info once a day)
    //$time = $_SERVER['REQUEST_TIME'] - (24 * 60 * 60);
   // $url =  $app_url;
    //$res =  $this->db->query("select * from applications where url = '$url' and modified > $time");
	// if ($res->num_rows()) {
      // we have an entry with up-to-date info
	 //$info =   $res->result();
    //} else {
      // Either we dont have a record of this module or its out of date, so we retrieve the app meta data.
      $response = $this->fetch_gadget_metadata($app_url);
	  if (! is_object($response) && ! is_array($response)) {
        // invalid json object, something bad happened on the shindig metadata side.
        $error = 'An error occured while retrieving the gadget information';
      } else {
        // valid response, process it
        $gadget = $response->gadgets[0];
        if (isset($gadget->errors) && ! empty($gadget->errors[0])) {
		 // failed to retrieve gadget, or failed parsing it
          $error = $gadget->errors[0];
		} else {
          // retrieved and parsed gadget ok, store it in db
          $info['url'] =  $gadget->url;
          $info['title'] = isset($gadget->title) ? $gadget->title : '';
          $info['directory_title'] = isset($gadget->directoryTitle) ? $gadget->directoryTitle : '';
          $info['height'] = isset($gadget->height) ? $gadget->height : '';
          $info['screenshot'] = isset($gadget->screenshot) ? $gadget->screenshot : '';
          $info['thumbnail'] = isset($gadget->thumbnail) ? $gadget->thumbnail : '';
          $info['author'] = isset($gadget->author) ? $gadget->author : '';
          $info['author_email'] = isset($gadget->authorEmail) ? $gadget->authorEmail : '';
          $info['description'] = isset($gadget->description) ? $gadget->description : '';
          $info['settings'] = isset($gadget->userPrefs) ? serialize($gadget->userPrefs) : '';
          $info['views'] = isset($gadget->views) ? serialize($gadget->views) : '';
          if ($gadget->scrolling == 'true') {
            $gadget->scrolling = 1;
          }
          $info['scrolling'] = ! empty($gadget->scrolling) ? $gadget->scrolling : '0';
          $info['height'] = ! empty($gadget->height) ? $gadget->height : '0';
          // extract the version from the iframe url
          $iframe_url = $gadget->iframeUrl;
          $iframe_params = array();
          parse_str($iframe_url, $iframe_params);
          $info['version'] = isset($iframe_params['v']) ? $iframe_params['v'] : '';
          $info['modified'] = $_SERVER['REQUEST_TIME'];
		  // Insert new application into our db, or if it exists (but had expired info) update the meta data
           $res1 = $this->read_db->query("select * from cc_applications where url='".$info['url']."'");
           $resus=$res1->row();
		   $info['appid'] = $resus->id;
           if (!$res1->num_rows() && ($this->uri->segment(2)!='application')) {
			$this->db->query("insert into cc_applications
								(id, url, title, directory_title, screenshot, thumbnail, author, author_email, description, settings, views, version, height, scrolling, modified)
								values
								(
									0,
									'" . $info['url'] . "',
									'" . $info['title'] . "',
									'" . $info['directory_title'] . "',
									'" . $info['screenshot'] . "',
									'" . $info['thumbnail'] . "',
									'" . $info['author'] . "',
									'" . $info['author_email'] . "',
									'" . $info['description'] . "',
									'" . $info['settings'] . "',
									'" . $info['views'] . "',
									'" . $info['version'] . "',
									'" . $info['height'] . "',
									'" . $info['scrolling'] . "',
									'" . $info['modified'] . "'
								) on duplicate key update
									url = '" . $info['url'] . "',
									title = '" . $info['title'] . "',
									directory_title = '" . $info['directory_title'] . "',
									screenshot = '" . $info['screenshot'] . "',
									thumbnail = '" . $info['thumbnail'] . "',
									author = '" . $info['author'] . "',
									author_email = '" . $info['author_email'] . "',
									description = '" . $info['description'] . "',
									settings = '" . $info['settings'] . "',
									views = '" . $info['views'] . "',
									version = '" . $info['version'] . "',
									height = '" . $info['height'] . "',
									scrolling = '" . $info['scrolling'] . "',
									modified = '" . $info['modified'] . "'
								");



			  $res =  $this->read_db->query("select id,description from cc_applications where url = '" .  $info['url'] . "' LIMIT 1");
			 if (!  $res->num_rows()) {
				$error = "Could not store application in registry";
			  } else {
				$id =  $res->result();
				$info['appid'] = $id[0]->id;
				}
		  }
		  else{
			  if($this->uri->segment(2)!='application'){
				  $error = "This application is already added";
				  }
			  }
        }
      }
   //}

    $info['error'] = $error;
    return $info;
  }

   private function fetch_gadget_metadata($app_url) {
    $request = json_encode(array(
        'context' => array('country' => 'US', 'language' => 'en', 'view' => 'default',
            'container' => 'openapp'),
        'gadgets' => array(array('url' => $app_url, 'moduleId' => '1'))));
	$request;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, Openappconfig::get('gadget_server') . '/gadgets/metadata');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'request=' . urlencode($request));
    $content = @curl_exec($ch);
	return json_decode($content);

  }

  public function get_person_application($user_id, $app_id, $mod_id) {
  $ret = array();
    $res = $this->read_db->query("select url from cc_applications where id = $app_id");
    if ($res->num_rows()) {
	  $owner_res = $this->read_db->query("select person_id from cc_person_applications where application_id = $app_id");
      $app_url = $res->row()->url;
      $ret = $this->get_application($app_url);
	  $ret['ownerid'] = $owner_res->row()->person_id;
	  $ret['mod_id'] = $mod_id;
      $ret['user_prefs'] = $this->get_application_prefs($user_id, $app_id);
    }
    return $ret;
  }

/*********************admin***************************/
  public function get_all_openapp($category='',$page=0,$perpage=0) {

		$start=0;
		$start=($page-1)*$perpage;

		$query1 = ('select  cc_applications.id as app_id,cc_applications.title,cc_user.firstname,cc_user.user_id,cc_user.lastname,cc_applications.description,cc_applications.approved, cc_person_applications.*,cc_app_category.category_name from
		cc_applications join cc_person_applications on cc_person_applications.application_id=cc_applications.id join
		cc_user on cc_person_applications.person_id=cc_user.user_id join cc_app_category on cc_app_category.id=cc_person_applications.app_category_id');
		if($category!=0){
			$query1.=" where cc_person_applications.app_category_id='$category'";
		}
		if($perpage!=0){
			$query1.=" limit $start,$perpage";
		}
		$query = $this->read_db->query($query1);
		$query1 = $this->read_db->query("select id from cc_applications where approved='Y'");
		$query2 = $this->read_db->query("select id from cc_applications where approved='N'");
		$res['all_apps'] = $query;
		$res['total_approved'] = $query1->num_rows;
		$res['total_pending'] = $query2->num_rows;
		return $res;
	}



	public function udpate_app_status($app_id,$action){
		 $res = $this->db->query("update cc_applications set approved='".$action."' where id='".$app_id."'");
		 return $res;
     }
  /******************admin*******************/
	public function set_application_log($log_id=0,$user_id=0, $app_id=0){
	//SET field in database table named
	if($log_id !=0){
		$cur_time = date('Y-m-d h-i-s');
		$res = $this->db->query("UPDATE  cc_opensocial_application_log SET in_time=in_time,out_time='".$cur_time."' WHERE log_id = $log_id");
		return $log_id;
	}
	else if($log_id == 0){
		$in_time = 0;

		$read = $this->read_db->query("select max(in_time) as in_time,MAX(log_id)  as log_id from cc_opensocial_application_log where user_id= $user_id AND app_id = $app_id");
		$result = $read->result();
		if ($result[0]->log_id != NULL) {
			$in_time = $result[0]->in_time;
			$log_id = $result[0]->log_id;
			$cur_time = date('Y-m-d h-i-s');
			//echo date('Y-m-d h-i-s',$cur_time).'  -'. $in_time.' - '.($cur_time  - strtotime($in_time))/3600;die;
			if((strtotime($cur_time)  - strtotime($in_time))/60 < 60){ // if user again open application with in 1 hour
				return  $log_id;
			}else{
				$cur_time = date('Y-m-d h-i-s');
				$res = $this->db->query("INSERT INTO cc_opensocial_application_log SET app_id=$app_id, user_id = $user_id,in_time = '".$cur_time."' ");
				$log_id = $this->db->insert_id();
				return $log_id;
			}
		}else{ // else cretae new entry user again open application after 1 hour
			$cur_time = date('Y-m-d h-i-s');
			$res = $this->db->query("INSERT INTO cc_opensocial_application_log SET app_id=$app_id, user_id=$user_id,in_time='".$cur_time."'");
			$log_id = $this->db->insert_id();
			return $log_id;
		}
	}
}

	public function get_application_log($user_id, $app_id){
	//SET field in database table named

	}

	public function friends_recently_played($user_id,$app_id){
		$friends = get_user_friends($user_id);
		foreach($friends as $friend){
			$friend_dis_arr[]= $friend->friend_id;
		}
		$friend_dis = implode(',',$friend_dis_arr);
		$read = $this->read_db->query("select * from `cc_opensocial_application_log` where user_id in($friend_dis )  AND app_id=$app_id  AND out_time <> '0000-00-00 00:00:00' ORDER BY in_time DESC");
		if ($read->num_rows()) {
		$results = array();
		$done = array();
			foreach($read->result() as $result){
			if(!in_array($result->user_id,$done)){
				foreach($friend_dis_arr as $kay => $friend){
						if($friend ==  $result->user_id ){
							// call get image helper function to get url of the image
								$profile_image_dimention = $this->config->item('__68X68__');
								$image_src = getimage('user', 2, $result->user_id,'','','','',$profile_image_dimention);
							$results['pic'] = $image_src;
							$results['name'] = '';//$friend->fname.' '. $friend->lname;
							unset($friend_dis_arr[$kay]);
							break;
						}
				}
				$done[] = $result->user_id;
				$results['user_id'] = $result->user_id;
				$results['app_id'] = $result->app_id;
				$results['in_time'] = $result->in_time;
				$return[] = $results;
			}
			}
			return $return;
		}else{
			return array();
		}


	}

	public function friends_playing_now($user_id){
		$friends = get_user_friends($user_id);
		foreach($friends as $friend){
			$friend_dis_arr2[]= $friend->friend_id;
			$friend_dis_arr[$friend->friend_id]['friend_id']= $friend->friend_id;
			$friend_dis_arr[$friend->friend_id]['name']= $friend->fname.' '.$friend->lname;
		}
		$friend_dis = implode(',',$friend_dis_arr2);
		$read = $this->read_db->query("select * from `cc_opensocial_application_log` where user_id in( $friend_dis ) and out_time = '0000-00-00 00:00:00' ORDER BY in_time DESC limit 0,6");
		if ($read->num_rows()) {
		$results = array();
		$done = array();
			foreach($read->result() as $result){
				if(!in_array($result->user_id,$done)){
					foreach($friend_dis_arr as $kay => $friend){
						if($kay ==  $result->user_id ){
							// call get image helper function to get url of the image

								$profile_image_dimention = $this->config->item('__68X68__');
								$image_src = getimage('user', 2, $result ->user_id,'','','','',$profile_image_dimention);
							$results['pic'] = $image_src;
							$results['name'] = $friend_dis_arr[$result->user_id]['name'];
							unset($friend_dis_arr[$kay]);
							break;
						}
					}
					$done[] = $result->user_id;
					$results['user_id'] = $result ->user_id;
					$results['app_id'] = $result ->app_id;
					$results['in_time'] = $result ->in_time;
				$return[] = $results;
				}

			}

			return $return;
		}else{
			return array();
		}

	}

	public function friends_apps_most_using($user_id,$categoty='app'){
		$results = array();
		$friends = get_user_friends($user_id);
		foreach($friends as $friend){
			$friend_dis[]= $friend->friend_id;
		}
		$friend_dis = implode(',',$friend_dis);
		$read = $this->read_db->query("SELECT count(user_id) as counts,`app_id` FROM `cc_opensocial_application_log` WHERE user_id in  ($friend_dis)  group by app_id ORDER BY count(user_id) DESC");
		if ($read->num_rows()) {


			foreach($read->result() as $result){
					$app = $this->get_app_details($result->app_id,$categoty);
					if($app){
						$app[0]->counts = $result->counts;
						$app[0]->url = base_url() . "opensocial/application/".$result->app_id."/1";
						$results[] = $app[0];
					}
			}
		}
		return $results;
	}
	public function get_app_details($app_id,$categoty=''){
		if($categoty=='app'){
		$app_category_id = 2; // 2 for game see  `cc_app_category` table
		// get all application whose category is not game
		$read = $this->read_db->query("SELECT cc_applications.id,url,title,screenshot,thumbnail FROM cc_applications, cc_person_applications WHERE cc_person_applications.app_category_id <> $app_category_id AND cc_person_applications.application_id= cc_applications.id AND cc_applications.id = $app_id ");
		}else if($categoty=='game'){
			$app_category_id = 2; // 2 for game see  `cc_app_category` table
			// get all application whose category is not game
			$read = $this->read_db->query("SELECT cc_applications.id,url,title,screenshot,thumbnail FROM cc_applications, cc_person_applications WHERE cc_person_applications.app_category_id = $app_category_id AND cc_person_applications.application_id= cc_applications.id AND cc_applications.id = $app_id ");
		}else{
			$read = $this->read_db->query("SELECT cc_applications.id,url,title,screenshot,thumbnail FROM cc_applications WHERE cc_applications.id = $app_id");
		}
		if ($read->num_rows()) {
			return	$read->result();
		}else return 0;
	}
	public function get_application_favorite($user_id,$app_id){
		$read = $this->read_db->query("SELECT activity_id  FROM cc_opensocial_application_activity WHERE from_user_id=$user_id AND  app_id= $app_id AND activity_type='FAVORITE'");
		if ($read->num_rows()) {
			return	'<div id="un_favorite" class="un_favorite">Remove form Favorites</div>';
		}else {
			return	'<div id="favorite" class="favorite">Add to Favorites</div>';
		}
	}
	public function set_application_activity($user_id,$app_id,$op){
		$activity_type='';
		switch($op){
		case 0:
			$activity_type='UNFAVORITE';
			$second_activity_type = 'FAVORITE';
			break;
		case 1:
			$activity_type='FAVORITE';
			$second_activity_type = 'UNFAVORITE';
			break;
		}
		if($activity_type!=''){
			$read = $this->read_db->query("SELECT activity_id  FROM cc_opensocial_application_activity WHERE from_user_id=$user_id AND  app_id= $app_id AND activity_type='$activity_type'");
			if (!$read->num_rows()) {
				$read = $this->read_db->query("SELECT activity_id  FROM cc_opensocial_application_activity WHERE from_user_id=$user_id AND  app_id= $app_id AND activity_type='$second_activity_type'");

				if ($read->num_rows()) {
					$this->read_db->query("UPDATE cc_opensocial_application_activity SET activity_type='$activity_type' WHERE from_user_id=$user_id AND  app_id= $app_id AND activity_type='$second_activity_type'");
				}else{
					$res = $this->db->query("INSERT INTO cc_opensocial_application_activity SET app_id=$app_id, from_user_id=	$user_id, activity_time=now(),status=1,activity_type='$activity_type'");
				}
				return  1;  // success
			}else{
				return  1;  // Allready present
			}
		}else{
			return 0; // error
		}
	}
	public function invites_from_friends($user_id){
		$returns = array();
		//status = 2 request panding
		$read = $this->read_db->query("SELECT cc_opensocial_application_activity .*,cc_user.firstname, cc_user.lastname FROM cc_opensocial_application_activity JOIN cc_user ON cc_user.user_id = cc_opensocial_application_activity.from_user_id WHERE to_user_id=$user_id AND  activity_type='INVITE' AND status = 2 Limit 0,6");
		if ($read->num_rows()) {
			foreach($read->result() as $result){
				$return->activity_id =  $result->activity_id;
				$return->friend_name ='';
				$return->friend_name =  $result->firstname.' '. $result->lastname;
				$application = $this->get_app_details($result->app_id);
				if($application !=0){
					$return->title = $application[0]->title;
					$return->app_link = base_url() . "opensocial/application/".$application[0]->id."/1";;
					$return->app_image = $application[0]->thumbnail;
				}else{
					$return->title = '';
					$return->app_link = '';
					$return->app_image = '';

				}
				$returns[] = $return;
				unset($return);
			}
			return $returns;
		}else {
			return	$returns;
		}
	}
	public function invites_from_friends_request($user_id,$app_id,$friend_ids){
		$friend_ids = explode(',',$friend_ids);
		if(!empty($friend_ids)){
			$sql = 'INSERT INTO  cc_opensocial_application_activity (app_id, to_user_id, 	from_user_id, 	activity_time,status,activity_type) VALUES ';
			$data ='';
			foreach($friend_ids as $friend_id){
				$data .= ",($app_id,$friend_id,$user_id,now(),2,'INVITE') ";
			}
			$data = substr($data,1);
			//status = 2 request panding
			$read = $this->db->query($sql.$data);
			if($temp = mysql_affected_rows()){
				return $temp;
			}else{
				return	0;
			}
		}
	}
	public function invites_from_friends_responce($action_id,$status){
		$returns = array();
		//status = 2 request panding
		$read = $this->read_db->query("UPDATE cc_opensocial_application_activity SET status = $status, responce_time = now() WHERE activity_id=$action_id AND  activity_type='INVITE' AND status = 2");
		if($temp = mysql_affected_rows()){
			return $temp;
		}else {
			return	0;
		}
	}

	public function udpate_oauth_permission($data){
		$profile_data = isset($data['profile']) ? 1:0;
		$friend_data = isset($data['friend']) ? 1:0;
		$wall_data = isset($data['wall']) ? 1:0;
		$user_id = $data['user_id'];
		$app_id = $data['app_id'];
		$this->db->query("UPDATE cc_oauth_permission SET (user_id, app_id, profile_data, friend_data,wall_data) values ($user_id, $app_id, $profile_data, $friend_data ,$wall_data)");
	}

	public function get_person_application_setting($user_id){
		$this->db->select('cc_applications.thumbnail,cc_applications.title,cc_oauth_permission.profile_data,cc_oauth_permission.friend_data,cc_oauth_permission.wall_data,cc_oauth_permission.app_id');
		$this->db->from('cc_applications');
		$this->db->join('cc_oauth_permission','cc_oauth_permission.app_id=cc_applications.id');
		$this->db->where('cc_oauth_permission.user_id',$user_id);
		$res = $this->db->get();
		if(count($res->result())>0){
			return $res->result();
			}
		else{
			return array();
			}
	}

	public function save_user_setting($data_array,$user_id,$app_id){
		$this->db->set($data_array);
		$this->db->where('user_id',$user_id);
		$this->db->where('app_id',$app_id);
		$res = $this->db->update('oauth_permission');
		return $res;
	}
    public function get_apps_star_rating($app_id){
		$read = $this->read_db->query("SELECT count(rating_id) as votecount,sum(rating) as rating  FROM cc_opensocial_application_rating WHERE app_id= $app_id");
		$result = $read->result();
		if ($result[0]->rating != NULL) {
			$average = $result[0]->rating/$result[0]->votecount;
			$average=Round($average,2);
			return $average;
		}else {
			return	0;
		}
  }
    public function set_apps_star_rating($post,$user_id){
		$app_id = $post['app_id'];
		$rating =  $post['rating'];
		$read = $this->read_db->query("SELECT rating  FROM cc_opensocial_application_rating WHERE user_id = $user_id AND app_id = $app_id");
		if ($read->num_rows()) {
			$res = $this->db->query("UPDATE cc_opensocial_application_rating SET rating=$rating WHERE app_id=$app_id AND user_id=	$user_id");
			return 0; // allready present
		}else{
			$res = $this->db->query("INSERT INTO cc_opensocial_application_rating SET app_id=$app_id, user_id=	$user_id, rating = $rating");
			return 1; // success
		}
  }
  }


