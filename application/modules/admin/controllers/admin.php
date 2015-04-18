<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
* Admin Controller 
*
* @author			Chris Baines
* @package			Dove Forums
* @copyright		© 2010 - 2011 Dove Forums
* @last modified	03/02/2011
**/
class Admin extends MY_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->head->add_css($this->config->item('forum_css').'default.css');
		$this->head->add_css($this->config->item('common_css').'common.css');
		$this->head->add_js($this->config->item('forum_js').'forums.js');
		$this->head->add_js($this->config->item('system_js').'common.js');
	}
	
	public function index()
	{
		if (!$this->ion_auth->logged_in())
		{
			// The user is not logged in, let's redirect them
			set_global_messages($this->lang->line('errorLoginRequired'), 'error');
			redirect('forums');
		}
		elseif (!$this->ion_auth->is_admin())
		{
			set_global_messages($this->lang->line('errorAdminRequired'), 'error');
			redirect('forums');
		}
		else
		{
			//What action ?
			$action = $this->uri->segment(3);
			
			switch($action){
				
				default:
				
				// Construct the data array for the page
				$data = array(
					'siteName'				=> $this->siteName, // Variable from MY_Controller
					'adminTheme' 			=> $this->adminTheme, // Variable from MY_Controller
					'errorMessageTitle' 	=> $this->errorTitle,
					'Error' 				=> $this->Error,
					'successMessageTitle' 	=> $this->messageTitle,
					'Message' 				=> $this->Message,
					'users'					=> $this->admin_m->count_users(),
					'discussions'			=> $this->admin_m->count_discussions(),
					'posts'					=> $this->admin_m->count_posts(),
				);
			
				//Page construction variables
				$page = 'dashboard';
				$title = $this->lang->line('dashboardTitle');
				
				/**
				* Send page to the page constructor
				**/



			//	$data['page']=$this->admin_construct($page, $title, $data);

				$this->template->load('admin_template','dashboard',$data);	

				
				//Send all information to the constructor
			// 	$this->admin_construct($page, $title, $data);
			}
		}
	}
	
	public function users()
	{
		if (!$this->ion_auth->logged_in())
		{
			// The user is not logged in, let's redirect them
			set_global_messages($this->lang->line('errorLoginRequired'), 'error');
			redirect('forums');
		}
		elseif (!$this->ion_auth->is_admin())
		{
			set_global_messages($this->lang->line('errorAdminRequired'), 'error');
			redirect('forums');
		}
		else
		{	
			//What action ?
			$action = $this->uri->segment(4);
			
			
			switch($action) {
				
				/**
				* Activate/De-Activate User Action
				**/					
				case 'status':
					$userID = $this->uri->segment('5');
					$status = $this->uri->segment('6');
					
					if(is_numeric($status))
					{
						if ($status == '1')
						{
							$data = array(
								'active' => '0',
							);
							$this->db->where('tdsUid', $userID);
							$this->db->update('UserAuth', $data);
						
							set_global_messages($this->lang->line('userDeactivated'), 'success');
							redirect(lang().'/admin/users/manage/');
						}
						elseif ($status == '0')
						{
							$data = array(
								'active' => '1',
							);
							$this->db->where('tdsUid', $userID);
							$this->db->update('UserAuth', $data);
						
							set_global_messages($this->lang->line('userActivated'), 'success');
							redirect(lang().'/admin/users/manage/');
						}
					}
					else
					{
						set_global_messages($this->lang->line('generalError'), 'error');
						redirect(lang().'/admin/users/manage/');
					}
				break;
				
				/**
				* New User Action
				**/
				case 'add_new':
					$groups = $this->admin_m->get_groups();
					$gen_password = $this->create_random_password();
					
					foreach($groups as $row)
					{
						$group_options[$row['name']] = $row['name'];
					}
					
					$username = array(
						'name' => 'username',
						'id' => 'username',
						'type' => 'text',
						'class' => 'textbox width_350 mt5',
					);
					
					$first_name = array(
						'name' => 'first_name',
						'id' => 'first_name',
						'type' => 'text',
						'class' => 'textbox width_350 mt5',
					);
					
					$password = array(
						'name' => 'password',
						'id' => 'password',
						'type' => 'text',
						'class' => 'textbox width_350 mt5',
						'value' => ''.$gen_password.'',
					);
					
					$last_name = array(
						'name' => 'last_name',
						'id' => 'last_name',
						'type' => 'text',
						'class' => 'textbox width_350 mt5',
					);
					
					$email = array(
						'name' => 'email',
						'id' => 'email',
						'type' => 'text',
						'class' => 'textbox width_350 mt5',
					);
					
					$options = array(
						'male' => 'Male',
						'female' => 'Female',
					);
					
					// Construct the page 
					$data = array(
						'siteName'						=> $this->siteName,
						'adminTheme'					=> $this->adminTheme,
						'errorMessageTitle'				=> $this->errorTitle,
						'Error'							=> $this->Error,
						'successMessageTitle'			=> $this->messageTitle,
						'Message'						=> $this->Message,
						'username'						=> $username,
						'email'							=> $email,
						'first_name'					=> $first_name,
						'last_name'						=> $last_name,
						'gender'						=> $options,
						'group_options'					=> $group_options,
						'password'						=> $password,
					);
					
					//Page construction variables
					$page = 'addUser';
					$title = $this->lang->line('addUserTitle');
					//$this->admin_construct($page, $title, $data);
					
					$this->template->load('admin_template',$page,$data);		

				break;
				
				/**
				* Save User Action
				**/
				case 'save_user':
				
					// Validate the form
					$this->form_validation->set_rules('username', 'Username', 'required');
					$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
		
					if($this->form_validation->run() == true)
					{
						$username = $this->input->post('username');
						$email = $this->input->post('email');
						$password = $this->input->post('password');
					}
					
					$additional_data = array(
						'first_name' => $this->input->post('first_name'),
						'last_name' => $this->input->post('last_name'),
						'gender' => $this->input->post('gender'),
					);
					
					$group_name = $this->input->post('group');
					
					if($this->form_validation->run() == true && $this->ion_auth->register($username, $password, $email, $additional_data, $group_name))
					{
						// Redirect them back to the home page with a message
						set_global_messages($this->lang->line('userCreated'), 'success');
						redirect(lang().'/admin/users/manage/');
					}
					else
					{
						set_global_messages(validation_errors(), 'error');
						redirect(lang().'/admin/users/manage/');
					}
					
				break;
				
				/**
				* Edit User Action
				**/	
				case 'edit':
					$userID = $this->uri->segment('5');
					$user = $this->admin_m->get_user($userID);
					
					// Need to remove
					redirect(lang().'/admin/users/manage/');

					
					
					$groups = $this->admin_m->get_groups();
					
					foreach($groups as $row)
					{
						$group_options[$row['id']] = $row['name'];
					}
					
					foreach($user as $row)
					{
						$username = array(
							'name' => 'Username',
							'id' => 'Username',
							'type' => 'text',
							'value' => ''.$row['username'].'',
							'class' => 'textbox',
						);
						
						$first_name = array(
							'name' => 'first_name',
							'id' => 'first_name',
							'type' => 'text',
							'value' => ''.$row['first_name'].'',
							'class' => 'textbox',
						);
						
						$last_name = array(
							'name' => 'last_name',
							'id' => 'last_name',
							'type' => 'text',
							'value' => ''.$row['last_name'].'',
							'class' => 'textbox',
						);
						
						$location = array(
							'name' => 'location',
							'id' => 'location',
							'type' => 'text',
							'value' => ''.$row['location'].'',
							'class' => 'textbox',
						);
						
						$interests = array(
							'name' => 'interests',
							'id' => 'interests',
							'type' => 'textarea',
							'value' => ''.$row['interests'].'',
							'class' => 'textarea',
						);
						
						$occupation = array(
							'name' => 'occupation',
							'id' => 'occupation',
							'type' => 'text',
							'value' => ''.$row['occupation'].'',
							'class' => 'textbox',
						);	
						
						$email = array(
							'name' => 'Email',
							'id' => 'Email',
							'type' => 'text',
							'value' => ''.$row['email'].'',
							'class' => 'textbox',
						);
						
						$signature = array(
							'name' => 'Signature',
							'id' => 'Signature',
							'type' => 'textarea',
							'value' => ''.$row['signature'].'',
							'class' => 'textarea',
						);
						
						if($row['active'] == '1')
						{
							$checked = TRUE;
						}
						else
						{
							$checked = FALSE;
						}
						
						$active = array(
							'name' => 'Active',
							'id' => 'Active',
							'class' => 'checkbox',
							'value' => '1',
							'checked' => $checked,
						);
						
						$options = array(
							'male' => 'Male',
							'female' => 'Female',
						);
					}
					
					// Construct the page 
					$data = array(
						'siteName'						=> $this->siteName,
						'adminTheme'					=> $this->adminTheme,
						'errorMessageTitle'				=> $this->errorTitle,
						'Error'							=> $this->Error,
						'successMessageTitle'			=> $this->messageTitle,
						'Message'						=> $this->Message,
						'username'						=> $username,
						'email'							=> $email,
					//	'signature'						=> $signature,
						'active'						=> $active,
						'userID'						=> $userID,
						'first_name'					=> $first_name,
						'last_name'						=> $last_name,
						'interests'						=> $interests,
						'occupation'					=> $occupation,
						'location'						=> $location,
						'gender'						=> $options,
						'sex'							=> strtolower($row['gender']),
						'group_options'					=> $group_options,
						'group'							=> $row['group_id'],
					);
					
					//Page construction variables
					$page = 'editUser';
					$title = $this->lang->line('editUserTitle');	
					$this->admin_construct($page, $title, $data);
				break;
				
				/**
				* Update User Action
				**/	
				case 'update':
					$userID = $this->uri->segment('4');
					
					if($this->input->post('Active') == '1')
					{
						$active = '1';
					}
					else
					{
						$active = '0';
					}
					
					// Update the user table
					$data = array(
						'Username' => $this->input->post('Username'),
						'email' => $this->input->post('Email'),
						'signature' => $this->input->post('Signature'),
						'Active' => $active,
						'group_id' => $this->input->post('group'),
					);
					$this->db->where('id', $userID);
					$this->db->update('users', $data);
					
					// Update user meta table
					$data = array(
						'first_name' => $this->input->post('first_name'),
						'last_name' => $this->input->post('last_name'),
						'location' => $this->input->post('location'),
						'interests' => $this->input->post('interests'),
						'occupation' => $this->input->post('occupation'),
						'gender' => $this->input->post('gender'),
					);
					$this->db->where('user_id', $userID);
					$this->db->update('meta', $data);
					
					set_global_messages($this->lang->line('userUpdated'), 'success');
					redirect(lang().'/admin/users/manage/');
					
				break;
				
				/**
				* Delete User Action
				**/
				case 'delete':
					$userID = $this->uri->segment('4');
					
					//Delete the users
					$this->db->where('id', $userID);
					$this->db->delete('users');
					
					$this->db->where('user_id', $userID);
					$this->db->delete('meta');
					
					set_global_messages($this->lang->line('deleteUser'), 'success');
					redirect(lang().'/admin/users/manage/');
				break;

				/**
				* Default User Action
				**/	
				default:
					/**
					* Load all the users from the database
					**/
					$users = $this->admin_m->get_users();

				$delete_icon = '<img src="'.base_url().'templates/assets/images/delete_f2.png"  />';
				$edit_icon = '<img src="'.base_url().'templates/assets/images/admin_edit.png" width="21" height="21"  />';


					$this->table->set_heading($this->lang->line('usernameTH'), $this->lang->line('userEmailTH'),$this->lang->line('active'), $this->lang->line('edit'), $this->lang->line('delete'));
					$tmpl = array (
						'table_open'          => '<table border="0" cellpadding="0" cellspacing="0" class="table">',
						'heading_row_start'   => '<tr>',
						'heading_row_end'     => '</tr>',
						'heading_cell_start'  => '<th>',
						'heading_cell_end'    => '</th>',
						'row_start'           => '<tr>',
						'row_end'             => '</tr>',
						'cell_start'          => '<td class="alt">',
						'cell_end'            => '</td>',
						'row_alt_start'       => '<tr>',
						'row_alt_end'         => '</tr>',
						'cell_alt_start'      => '<td>',
						'cell_alt_end'        => '</td>',
						'table_close'         => '</table>'
					);
					$this->table->set_template($tmpl); 
				
					if(!$users)
					{
						$this->table->add_row(
							''.$this->lang->line('noDiscussions').''
						);
					}
					else
					{
						
						foreach($users as $row)
						{
							if($row['active'] == '1')
							{
								$active = $this->lang->line('yes');
								$active_msg = '<img src="'.base_url().'templates/assets/images/tick.png" />';
							}
							else
							{
								$active = $this->lang->line('no');
								$active_msg = '<img src="'.base_url().'templates/assets/images/publish_x.png" />';
							}
							
							$UserAuth		=	$this->db->dbprefix('UserAuth');
						$UserProfile	=	$this->db->dbprefix('UserProfile');
						$res	=	getDataFromMixTabel('"'.$UserAuth.'" ua, "'.$UserProfile.'" up', $field='"up"."firstName","up"."lastName"','WHERE "ua"."username"=\''.$row['username'].'\' AND "up"."tdsUid"="ua"."tdsUid"', 'limit 1');
						$postedBy	=	'';

						if($res){
							$postedBy=$res[0]->firstName;
						}
							
							$this->table->add_row($postedBy,$row['email'], anchor(lang().'/admin/users/status/'.$row['tdsUid'].'/'.$row['active'].'/', ''.$active_msg.''), anchor(lang().'/admin/users/edit/'.$row['tdsUid'].'/', $edit_icon), anchor(lang().'/admin/users/delete/'.$row['tdsUid'].'/', $delete_icon));
						}
					}
			
			
					$users = $this->table->generate();
					$this->table->clear();
			
					// Construct the data array for the page
					$data = array(
						'siteName'				=> $this->siteName, // Variable from MY_Controller
						'adminTheme' 			=> $this->adminTheme, // Variable from MY_Controller
						'errorMessageTitle' 	=> $this->errorTitle,
						'Error' 				=> $this->Error,
						'successMessageTitle' 	=> $this->messageTitle,
						'Message' 				=> $this->Message,
						'users'					=> $users,
					);
					//Page construction variables
					$page = 'users';
					$title = $this->lang->line('manageUsersTitle');
				//	$this->admin_construct($page, $title, $data);
				
				/**
				* Send page to the page constructor
				**/
					$this->template->load('admin_template',$page,$data);		

					
				break;
			}
		}		
	}
	
	
	public function request_category()
	{
		
				$val1 		= 	$this->input->get('val1');
				$val2 		= 	$this->input->get('val2');
				
				// Get category record by category id
				$options 		 = array('CategoryID' => $val1);
				$category_record = $this->categories_m->categories_for_admin($options);
			
				foreach($category_record as $row) { } 	


				//Page construction variables
				$page 		= 	'request_category';
				$title 		= 	$this->lang->line('manageUsersTitle');
				
				$body = array(
					'name' => 'postBody',
					'id' => 'postBody',
					'type' => 'text',
					'rows' => '4',
					'value' => $row['Description'],
					'class' => 'textarea widht_490',
				);
				
					
				$title = array(
					'name' => 'cat_name',
					'id' => 'cat_name',
					'value' => $row['Name'],
					'type' => 'text',
				);
				
					
				$commentID = array(
					'name' => 'commentID',
					'id' => 'commentID',
					'type' => 'hidden',
					'value'=>'1'
				);
			
			
			
			
				$data = array(
					'siteName' 					=> $this->siteName,			
					'siteTheme' 				=> $this->siteTheme,		
					'welcomeMessage'			=> $this->sSettings[0]['siteWelcomeMessage'],			
					'errorMessageTitle' 		=> $this->errorTitle,
					'Error' 					=> $this->Error,
					'successMessageTitle' 		=> $this->messageTitle,
					'Message' 					=> $this->Message,
					'body' 						=> $body,
					'title'						=> $title,
					'category_id'				=> $val1,
					'forumsInstalled'		    => $this->sSettings[0]['forumInstalled'],
                    'navigation'                => $this->build_navigation(),
				);
			
			/**
				* Send page to the page constructor
			**/
			
			$page = 'request_category';
			$title = $this->lang->line('titleEditPost');
			
			//Send all information to the constructor
			$data['page']= $this->forums_page_construct($page, $title, $data);
			$this->load->view('request_category', $data);

	}
		
	
	public function categories()
	{
		if (!$this->ion_auth->logged_in())
		{
			// The user is not logged in, let's redirect them
			set_global_messages($this->lang->line('errorLoginRequired'), 'error');
			redirect('forums');
		}
		elseif (!$this->ion_auth->is_admin())
		{
			set_global_messages($this->lang->line('errorAdminRequired'), 'error');
			redirect('forums');
		}
		else
		{
			//What action ?
			$action = $this->uri->segment(4);
		
			switch($action){
				case 'active':
					$categoryID = $this->uri->segment('5');
					$active 	= $this->uri->segment('6');
						
					if(is_numeric($active))
					{
						if($active == '1')
						{
							$data = array(
								'Active' => '0',
							);
							$this->db->where('CategoryID', $categoryID);
							$this->db->update('forum_category', $data);
						
							set_global_messages($this->lang->line('categoryDeactivated'), 'success');
							redirect(lang().'/admin/categories/manage/');
						}
						elseif($active == '0')
						{
							$data = array(
								'Active' => '1',
							);
							$this->db->where('CategoryID', $categoryID);
							$this->db->update('forum_category', $data);
							
							set_global_messages($this->lang->line('categoryActivated'), 'success');
							redirect(lang().'/admin/categories/manage/');
						}
					}
					else
					{
						set_global_messages($this->lang->line('generalError'), 'error');
						redirect(lang().'/admin/categories/manage/');
					}
				break;
				
				case 'add_new':
				
				
				/**
				* Get all categories from the database.
				**/	
				$options = array('Active' => '1', 'parentID' => '0');
				$categories = $this->categories_m->categories_for_admin($options);			
				/**
				* Create a dropdown box.
				**/	
                $category_options['0'] = 'None selected';
				foreach($categories as $row)		
				{			
					$category_options[$row['CategoryID']] = $row['Name'];
				}
 
                $category_type['help'] = 'Help';
                $category_type['forums'] = 'Forums';
				
					$name = array(
						'name' => 'Name',
						'id' => 'Name',
						'type' => 'text',
						'class' => 'textbox width_350 mt5',
					);
						
					$description = array(
						'name' => 'Description',
						'id' => 'Description',
						'type' => 'textarea',
						'rows'	=> '10',
						'class' => 'textarea width_350',
					);
						
					$active = array(
						'name' => 'active',
						'id' => 'active',
						'class' => 'checkbox ',
						'value' => '1',
						'checked' => FALSE,
					);		

					// Construct the data array for the page
					$data = array(
						'siteName'				=> $this->siteName, // Variable from MY_Controller
						'adminTheme' 			=> $this->adminTheme, // Variable from MY_Controller
						'errorMessageTitle' 	=> $this->errorTitle,
						'Error' 				=> $this->Error,
						'successMessageTitle' 	=> $this->messageTitle,
						'Message' 				=> $this->Message,
						'name'					=> $name,
						'description'			=> $description,
						'active'				=> $active,
						'category_options' 		=> $category_options,
                        'category_type'         => $category_type,
					);
			
					//Page construction variables
					//Page construction variables
					$page = 'addCategory';
					$title = $this->lang->line('addCategoryTitle');
					//$this->admin_construct($page, $title, $data);				
					
					//$this->template->load('admin_template',$page,$data);		
						$this->template->load('admin_template',$page,$data);		

				break;
				
				case 'save_category':
				
					if($this->input->post('active') == '1')
					{
						$active = '1';
					}
					else
					{
						$active = '0';
					}
					// Save the category
					$data = array(
						'Name' => $this->input->post('Name'),
						'Description' => $this->input->post('Description'),
						'parentID' => $this->input->post('category'),
						'Active' => $active,
                        'type' => strtolower($this->input->post('type')),
					);
					$this->db->insert('forum_category', $data);
					
					set_global_messages($this->lang->line('categoryCreated'), 'success');
					redirect(lang().'/admin/categories/manage/');				
				break;
				
				case 'edit':
					$categoryID = $this->uri->segment('5');
					$category = $this->admin_m->get_category($categoryID);
					
					foreach($category as $row)
					{
						$name = array(
							'name' => 'Name',
							'id' => 'Name',
							'type' => 'text',
							'value' => ''.$row['Name'].'',
							'class' => 'textbox width_350',
						);
						
						$description = array(
							'name' => 'Description',
							'id' => 'Description',
							'type' => 'textarea',
							'value' => ''.$row['Description'].'',
							'rows'	=> '10',
							'cols'	=> '47',
							'class' => 'textarea width_350',
						);
						
						if ($row['Active'] == '1')
						{
							$checked = TRUE;
						}
						else
						{
							$checked = FALSE;
						}
						
						$active = array(
							'name' => 'Active',
							'id' => 'Active',
							'class' => 'checkbox',
							'value' => '1',
							'checked' => $checked,
						);
					}
						
					// Construct the data array for the page
					$data = array(
						'siteName'				=> $this->siteName, // Variable from MY_Controller
						'adminTheme' 			=> $this->adminTheme, // Variable from MY_Controller
						'errorMessageTitle' 	=> $this->errorTitle,
						'Error' 				=> $this->Error,
						'successMessageTitle' 	=> $this->messageTitle,
						'Message' 				=> $this->Message,
						'name'					=> $name,
						'description'			=> $description,
						'active'				=> $active,
						'categoryID'			=> $categoryID,
					);
			
					//Page construction variables
					$page = 'editCategory';
					$title = $this->lang->line('editCategoryTitle');
				//	$this->admin_construct($page, $title, $data);
					$this->template->load('admin_template',$page,$data);		

				break;
				
				case 'update':
					$categoryID = $this->uri->segment('5');
					
					if($this->input->post('Active') == '1')
					{
						$active = '1';
					}
					else
					{
						$active = '0';
					}
					
					// Update the category
					$data = array(
						'Name' => $this->input->post('Name'),
						'Description' => $this->input->post('Description'),
						'Active' => $active,
					);
					$this->db->where('CategoryID', $categoryID);
					$this->db->update('forum_category', $data);
					
					set_global_messages($this->lang->line('categoryUpdated'), 'success');
					redirect(lang().'/admin/categories/manage/');
				break;
				
				case 'delete':
					$categoryID = $this->uri->segment('5');
		
					// Delete the category
					$this->db->where('CategoryID', $categoryID);
					$this->db->delete('forum_category');
					
					// Redirect 
					set_global_messages($this->lang->line('categoryDeleted'), 'success');
					redirect(lang().'/admin/categories/manage/');
				break;
				
				
				case 'requested':
				/**
				* Load all the categories from the database
				**/
				$options = array('parentID !=' => '0','Active' => '0');
				
				$categories = $this->categories_m->categories_for_admin($options);
				
			
				$new_cat_arr = array();
				
					foreach($categories as $row)
					{
						$new_cat_arr[] = $row['parentID'];
					}
					
					$new_cat_arr = array_unique($new_cat_arr);
					
				
				$this->table->set_heading($this->lang->line('catNameTH'), $this->lang->line('catDescriptionTH'),'Accept','Reject');
		
				$tmpl = array (
					'table_open'          => '<table border="0" cellpadding="0" cellspacing="0" class="table">',
					'heading_row_start'   => '<tr>',
					'heading_row_end'     => '</tr>',
					'heading_cell_start'  => '<th>',
					'heading_cell_end'    => '</th>',
					'row_start'           => '<tr>',
					'row_end'             => '</tr>',
					'cell_start'          => '<td class="alt">',
					'cell_end'            => '</td>',
					'row_alt_start'       => '<tr>',
					'row_alt_end'         => '</tr>',
					'cell_alt_start'      => '<td>',
					'cell_alt_end'        => '</td>',
					'table_close'         => '</table>'
				);
				
				$this->table->set_template($tmpl); 
				
				if(!$categories)
				{
					$this->table->add_row(
						''.$this->lang->line('noCategories').''
					);
				}
				else
				{
					foreach($new_cat_arr as $key=>$val)
					{
						
						$get_parent_root = $this->categories_m->get_parent_categories($val);
						foreach($get_parent_root as $rowname) {	}
						
						$this->table->add_row($rowname['Name'],'','','');
						
						$root_categories = $this->categories_m->sub_categories_for_admin($val);

						$reject_msg = '<img src="'.base_url().'templates/assets/images/delete_f2.png"  />';
						$active_msg = '<img src="'.base_url().'templates/assets/images/tick.png"  />';


						foreach($root_categories as $row)
						{
							if($row['Active'] == '1')
							{
								$active = $this->lang->line('yes');
							}
							else
							{
								$active = $this->lang->line('no');
								// $active_msg = "Accpet";	
							}
							
							$this->table->add_row('&nbsp;&nbsp;&nbsp;&nbsp;'.ucfirst($row['Name']), $row['Description'],
							'<a onclick=javascript:openLightBox("loginLightBoxWp","loginFormContainer","/admin/request_category","'.$row['CategoryID'].'","'.$row['Active'].'") href="#">
							<img  src="'.base_url().'templates/assets/images/tick.png">
							</a>', anchor(lang().'/admin/categories/delete/'.$row['CategoryID'].'/', ''.$reject_msg.''));
							
							}
					}
				}
			
				$categories = $this->table->generate();
				$this->table->clear();
	
				// Construct the data array for the page
				$data = array(
					'siteName'				=> $this->siteName, // Variable from MY_Controller
					'adminTheme' 			=> $this->adminTheme, // Variable from MY_Controller
					'errorMessageTitle' 	=> $this->errorTitle,
					'Error' 				=> $this->Error,
					'successMessageTitle' 	=> $this->messageTitle,
					'Message' 				=> $this->Message,
					'categories'			=> $categories,
					'title'					=> $this->lang->line('catReqCat'),
				);
			
				//Page construction variables
				$page = 'catrequest';
				
				//Send all information to the constructor
				//$this->admin_construct($page, $title, $data);
				
					$this->template->load('admin_template',$page,$data);		

				break;
				
				
				default:
				/**
				* Load all the categories from the database
				**/
				$options = array('parentID' => '0');
				$categories = $this->categories_m->categories_for_admin($options);
				$delete_icon = '<img src="'.base_url().'templates/assets/images/delete_f2.png" />';
				$edit_icon = '<img src="'.base_url().'templates/assets/images/admin_edit.png"  width="21" height="21" />';

				$this->table->set_heading($this->lang->line('catNameTH'), $this->lang->line('catDescriptionTH'), $this->lang->line('catTypeTH'), $this->lang->line('catActiveTH'), $this->lang->line('catEditTH'), $this->lang->line('catDeleteTH'));
		
				$tmpl = array (
					'table_open'          => '<table border="0" cellpadding="0" cellspacing="0" class="table">',
					'heading_row_start'   => '<tr>',
					'heading_row_end'     => '</tr>',
					'heading_cell_start'  => '<th>',
					'heading_cell_end'    => '</th>',
					'row_start'           => '<tr>',
					'row_end'             => '</tr>',
					'cell_start'          => '<td class="alt">',
					'cell_end'            => '</td>',
					'row_alt_start'       => '<tr>',
					'row_alt_end'         => '</tr>',
					'cell_alt_start'      => '<td>',
					'cell_alt_end'        => '</td>',
					'table_close'         => '</table>'
				);
				
				
				$this->table->set_template($tmpl); 
				
				if(!$categories)
				{
					$this->table->add_row(
						''.$this->lang->line('noCategories').''
					);
				}
				else
				{
					foreach($categories as $row)
					{
						if($row['Active'] == '1')
						{
							$active = $this->lang->line('yes');
							$active_msg = '<img src="'.base_url().'templates/assets/images/tick.png" />';
						}
						else
						{
							$active = $this->lang->line('no');
							$active_msg = '<img src="'.base_url().'templates/assets/images/publish_x.png" />';
						}
						
						$this->table->add_row($row['Name'], $row['Description'], $row['type'], anchor(lang().'/admin/categories/active/'.$row['CategoryID'].'/'.$row['Active'].'/', ''.$active_msg.''), anchor(lang().'/admin/categories/edit/'.$row['CategoryID'].'/', $edit_icon), anchor(lang().'/admin/categories/delete/'.$row['CategoryID'].'/', $delete_icon));


						// Get subcategories 
						$sub_categories = $this->categories_m->sub_categories_for_admin($row['CategoryID']);
						foreach($sub_categories as $sub_row)
						{
								if($sub_row['Active'] == '1')
								{
									$active = $this->lang->line('yes');
									$active_msg = '<img src="'.base_url().'templates/assets/images/tick.png" />';
								}
								else
								{
									$active = $this->lang->line('no');
									$active_msg = '<img src="'.base_url().'templates/assets/images/publish_x.png" />';
								}
								
								if($sub_row['type']=='Requested') { $type_class = "admin_request"; } else { $type_class = ""; }
						
							$this->table->add_row('&nbsp;&nbsp;&nbsp;&nbsp;	'.ucfirst($sub_row['Name']).'', $sub_row['Description'],'<span class="'.$type_class.'">'.$sub_row['type'].'</span>', anchor(lang().'/admin/categories/active/'.$sub_row['CategoryID'].'/'.$sub_row['Active'].'/', ''.$active_msg.''), anchor(lang().'/admin/categories/edit/'.$sub_row['CategoryID'].'/', $edit_icon), anchor(lang().'/admin/categories/delete/'.$sub_row['CategoryID'].'/', $delete_icon));
						}
					}
				}
			
				$categories = $this->table->generate();
				$this->table->clear();
	
				// Construct the data array for the page
				$data = array(
					'siteName'				=> $this->siteName, // Variable from MY_Controller
					'adminTheme' 			=> $this->adminTheme, // Variable from MY_Controller
					'errorMessageTitle' 	=> $this->errorTitle,
					'Error' 				=> $this->Error,
					'successMessageTitle' 	=> $this->messageTitle,
					'Message' 				=> $this->Message,
					'categories'			=> $categories,
					'title'					=> $this->lang->line('manageCategoriesTitle'),
				);
			
				//Page construction variables
				$page = 'categories';
				$title = $this->lang->line('manageCategoriesTitle');
				
				//Send all information to the constructor
				//$this->admin_construct($page, $title, $data);
				
					$this->template->load('admin_template',$page,$data);		

			}
		}	
	}
	
	public function discussions()
	{
		if(!$this->ion_auth->logged_in())
		{
			// The user is not logged in, let's redirect them
			
			set_global_messages($this->lang->line('errorLoginRequired'), 'error');
			redirect('forums');
		}
		elseif (!$this->ion_auth->is_admin())
		{
	
			set_global_messages($this->lang->line('errorAdminRequired'), 'error');
			redirect('forums');
		}
		else
		{
			//What action ?
			$action = $this->uri->segment(4);
		
			
			switch ($action) {
				
				case 'status':
					$TopicID = $this->uri->segment('5');
					$status = $this->uri->segment('6');
					
			
					if(is_numeric($status))
					{					
						if ($status == '1')
						{
							$data = array(
								'Active' => '0',
							);
							$this->db->where('TopicID', $TopicID);
							$this->db->update('forum_topics', $data);
						
							set_global_messages($this->lang->line('discussionDeactivated'), 'success');
							redirect(lang().'/admin/discussions/manage');
						}
						elseif ($status == '0')
						{
							$data = array(
								'Active' => '1',
							);
							$this->db->where('TopicID', $TopicID);
							$this->db->update('forum_topics', $data);	

							
							set_global_messages($this->lang->line('discussionActivated'), 'success');
							redirect(lang().'/admin/discussions/manage');						
						}
					}
					else
					{
						// There must have being a problem, inform and redirect
						set_global_messages($this->lang->line('generalError'), 'error');
						redirect(lang().'/admin/discussions/manage');
					}
				break;
				
				case 'sticky':
					$TopicID = $this->uri->segment('5');
					$sticky = $this->uri->segment('6');
					
					if(is_numeric($sticky))
					{
					
						if($sticky == '1')
						{
							$data = array(
								'Sticky' => '0',
							);
							$this->db->where('TopicID', $TopicID);
							$this->db->update('forum_topics', $data);
							
							set_global_messages($this->lang->line('discussionStickyOff'), 'success');
							redirect(lang().'/admin/discussions/manage/');
						}
						elseif($sticky == '0')
						{
							$data = array(
								'Sticky' => '1',
							);
							$this->db->where('TopicID', $TopicID);
							$this->db->update('forum_topics', $data);	

							set_global_messages($this->lang->line('discussionStickyOn'), 'success');
							redirect(lang().'/admin/discussions/manage/');
						}
					}
					else
					{
						
						set_global_messages($this->lang->line('generalError'), 'error');
						redirect(lang().'/admin/discussions/manage');			
					}
				break;
				
				case 'closed':
					$TopicID = $this->uri->segment('5');
					$closed = $this->uri->segment('6');
					
					if(is_numeric($closed))
					{
					
						if ($closed == '1')
						{
							$data = array(
								'Closed' => '0',
							);
							$this->db->where('TopicID', $TopicID);
							$this->db->update('forum_topics', $data);
							
							set_global_messages($this->lang->line('discussionOpen'), 'success');
							redirect(lang().'/admin/discussions/manage/');
						}
						elseif ($closed == '0')
						{
							$data = array(
								'Closed' => '1',
							);
							$this->db->where('TopicID', $TopicID);
							$this->db->update('forum_topics', $data);	

							set_global_messages($this->lang->line('discussionClosed'), 'success');
							redirect(lang().'/admin/discussions/manage/');
						}
					}
					else
					{

						set_global_messages($this->lang->line('generalError'), 'error');
						redirect(lang().'/admin/discussions/manage');					
					}
				break;
				
				case 'flagged':
					$TopicID = $this->uri->segment('5');
					$flagged = $this->uri->segment('6');
					
					if(is_numeric($flagged))
					{
						if ($flagged == '1')
						{
							$data = array(
								'Flagged' => '0',
							);
							
							$this->db->where('TopicID', $TopicID);
							$this->db->update('forum_topics', $data);
							
							set_global_messages($this->lang->line('discussionFlaggedOff'), 'success');
							redirect(lang().'/admin/discussions/manage/');
						}
						elseif ($flagged == '0')
						{
							$data = array(
								'Flagged' => '1',
							);
							$this->db->where('TopicID', $TopicID);
							$this->db->update('forum_topics', $data);		

							set_global_messages($this->lang->line('discussionFlaggedOn'), 'success');
							redirect(lang().'/admin/discussions/manage/');
						}
					}
					else
					{
						set_global_messages($this->lang->line('generalError'), 'error');
						redirect(lang().'/admin/discussions/manage');
					}
				break;
					
				case 'delete':
					$TopicID = $this->uri->segment('5');
					
					//Delete topic
					$this->db->where('TopicID', $TopicID);
					$this->db->delete('forum_topics');
		
					//Delete related posts
					$this->db->where('TopicID', $TopicID);
					$this->db->delete('forum_comments');
		
					//Data has being deleted lets redirect the user back to the home page.
					set_global_messages($this->lang->line('discussionRemoved'), 'success');
					redirect(lang().'/admin/discussions/manage');
				break;
				
				default:
				
				$delete_icon = '<img src="'.base_url().'templates/assets/images/delete_f2.png" />';
				$edit_icon	 = '<img src="'.base_url().'templates/assets/images/admin_edit.png"  width="21" height="21" />';
								
				/**
				* Load all the users from the database
				**/
				$discussions = $this->admin_m->get_discussions();

				//$this->table->set_heading($this->lang->line('disName'), $this->lang->line('disCreatedBy'), $this->lang->line('disLastPost'), $this->lang->line('disActive'), $this->lang->line('disSticky'), $this->lang->line('disClosed'), $this->lang->line('disFlagged'), $this->lang->line('disDelete'));
				$this->table->set_heading($this->lang->line('disName'), $this->lang->line('disCreatedBy'), $this->lang->line('disLastPost'), $this->lang->line('disActive'), $this->lang->line('disSticky'), $this->lang->line('disClosed'), $this->lang->line('disDelete'));
				$tmpl = array (
					'table_open'          => '<table border="0" cellpadding="0" cellspacing="0" class="table">',
					'heading_row_start'   => '<tr>',
					'heading_row_end'     => '</tr>',
					'heading_cell_start'  => '<th>',
					'heading_cell_end'    => '</th>',
					'row_start'           => '<tr>',
					'row_end'             => '</tr>',
					'cell_start'          => '<td class="alt" >',
					'cell_end'            => '</td>',
					'row_alt_start'       => '<tr>',
					'row_alt_end'         => '</tr>',
					'cell_alt_start'      => '<td>',
					'cell_alt_end'        => '</td>',
					'table_close'         => '</table>'
				);
				$this->table->set_template($tmpl); 
				
				if(!$discussions)
				{
					$this->table->add_row(
						''.$this->lang->line('noDiscussions').''
					);
				}
				else
				{
					foreach($discussions as $row)
					{
						if($row['Active'] == '1')
						{
							$active = $this->lang->line('yes');
							$active_msg	 = '<img src="'.base_url().'templates/assets/images/tick.png" />';

						}
						else
						{
							$active = $this->lang->line('no');
							$active_msg  = '<img src="'.base_url().'templates/assets/images/publish_x.png" />';

						}
						
						if($row['Sticky'] == '1')
						{
							$sticky = $this->lang->line('yes');
							$sticky_msg	 = '<img src="'.base_url().'templates/assets/images/tick.png" />';

						}
						else
						{
							$sticky = $this->lang->line('no');
							$sticky_msg  = '<img src="'.base_url().'templates/assets/images/publish_x.png" />';
						}
						
						if($row['Closed'] == '1')
						{
							$closed = $this->lang->line('yes');
							$closed_msg	 = '<img src="'.base_url().'templates/assets/images/tick.png" />';
						}
						else
						{
							$closed = $this->lang->line('no');
							$closed_msg  = '<img src="'.base_url().'templates/assets/images/publish_x.png" />';
						}
						
						/*if($row['Flagged'] == '1')
						{
							$flagged = $this->lang->line('yes');
						}
						else
						{
							$flagged = $this->lang->line('no');
						}*/
						
						$UserAuth		=	$this->db->dbprefix('UserAuth');
						$UserProfile	=	$this->db->dbprefix('UserProfile');
						$res	=	getDataFromMixTabel('"'.$UserAuth.'" ua, "'.$UserProfile.'" up', $field='"up"."firstName","up"."lastName"','WHERE "ua"."username"=\''.$row['CreatedBy'].'\' AND "up"."tdsUid"="ua"."tdsUid"', 'limit 1');
						$postedBy	=	'';

						if($res){
							$CreatedBy=$res[0]->firstName;
						}
						
						$UserAuth		=	$this->db->dbprefix('UserAuth');
						$UserProfile	=	$this->db->dbprefix('UserProfile');
						$res	=	getDataFromMixTabel('"'.$UserAuth.'" ua, "'.$UserProfile.'" up', $field='"up"."firstName","up"."lastName"','WHERE "ua"."username"=\''.$row['LastPost'].'\' AND "up"."tdsUid"="ua"."tdsUid"', 'limit 1');
						$postedBy	=	'';

						if($res){
							$LastPost=$res[0]->firstName;
						}
							
							
						//$this->table->add_row($row['TopicName'], $row['CreatedBy'], $row['LastPost'], anchor('admin/discussions/status/'.$row['TopicID'].'/'.$row['Active'].'/', ''.$active.''), anchor('admin/discussions/sticky/'.$row['TopicID'].'/'.$row['Sticky'].'/', ''.$sticky.''), anchor('admin/discussions/closed/'.$row['TopicID'].'/'.$row['Closed'].'/', ''.$closed.''), anchor('admin/discussions/flagged/'.$row['TopicID'].'/'.$row['Flagged'].'/', ''.$flagged.''), anchor('admin/discussions/delete/'.$row['TopicID'].'/', $this->lang->line('delete')));
						$this->table->add_row($row['TopicName'], $CreatedBy, $LastPost, anchor(lang().'/admin/discussions/status/'.$row['TopicID'].'/'.$row['Active'].'/', ''.$active_msg.''), anchor(lang().'/admin/discussions/sticky/'.$row['TopicID'].'/'.$row['Sticky'].'/', ''.$sticky_msg.''), anchor(lang().'/admin/discussions/closed/'.$row['TopicID'].'/'.$row['Closed'].'/', ''.$closed_msg.''),  anchor(lang().'/admin/discussions/delete/'.$row['TopicID'].'/', $delete_icon));
					}
				}
			
				$discussions = $this->table->generate();
				$this->table->clear();


				// Construct the data array for the page
				$data = array(
					'siteName'				=> $this->siteName, // Variable from MY_Controller
					'adminTheme' 			=> $this->adminTheme, // Variable from MY_Controller
					'errorMessageTitle' 	=> $this->errorTitle,
					'Error' 				=> $this->Error,
					'successMessageTitle' 	=> $this->messageTitle,
					'Message' 				=> $this->Message,
					'discussions'			=> $discussions,
				);
			
				//Page construction variables
				$page = 'discussions';
				$title = $this->lang->line('manageDiscussionsTitle');
				
				//Send all information to the constructor
		//		$this->admin_construct($page, $title, $data);
				$this->template->load('admin_template',$page,$data);		

			}
		}	
	}
    
    public function plugins()
    {
        if (!$this->ion_auth->logged_in())
        {
            // The user is not logged in, let's redirect them
 			set_global_messages($this->lang->line('errorLoginRequired'), 'error');
            redirect('forums');
        }
        elseif (!$this->ion_auth->is_admin())
        {
			set_global_messages($this->lang->line('errorAdminRequired'), 'error');
            redirect('forums');
        }
        else
        {
            // What action ?
            $action = $this->uri->segment(3);
            
            switch($action) {
                
                default:
                
                $plugin_info = array();
                $plugins = $this->core_m->get_all_plugins();
                
                if($plugins)
                {
                    foreach ($plugins as $row)
                    {
                        $plugin_info[$row['name']] = $this->plugins->plugin_info($row['name']);
                    }
                }
                
				// Construct the data array for the page
				$data = array(
					'siteName'				=> $this->siteName, // Variable from MY_Controller
					'adminTheme' 			=> $this->adminTheme, // Variable from MY_Controller
					'errorMessageTitle' 	=> $this->errorTitle,
					'Error' 				=> $this->Error,
					'successMessageTitle' 	=> $this->messageTitle,
					'Message' 				=> $this->Message,
                    'plugins'               => $plugins,
                    'plugin_info'           => $plugin_info,
				);
			
				//Page construction variables
				$page = 'plugins';
				$title = $this->lang->line('managePluginsTitle');
				$this->admin_construct($page, $title, $data);
            }
        }
    }
	
	public function settings()
	{
		if (!$this->ion_auth->logged_in())
		{
			// The user is not logged in, let's redirect them
			set_global_messages($this->lang->line('errorLoginRequired'), 'error');
			redirect('forums');
		}
		elseif (!$this->ion_auth->is_admin())
		{
			set_global_messages($this->lang->line('errorLoginRequired'), 'error');
			redirect('forums');
		}
		else
		{
			//What action ?
			$action = $this->uri->segment(3);
			
			switch($action) {
				
				case 'update':
				
				// Store the page the user came from.
				$this->session->set_userdata('refered_from', $_SERVER['HTTP_REFERER']);
				
				if($this->input->post('allowRegistration') == '1')
				{
					$allowRegistration = '1';
				}
				else
				{
					$allowRegistration = '0';
				}
                
                if($this->input->post('editOwnPosts') == '1')
                {
                    $editOwnPosts = '1';
                } else {
                    $editOwnPosts = '0';
                }
                
                if($this->input->post('deleteOwnPosts') == '1')
                {
                    $deleteOwnPosts = '1';
                } else {
                    $deleteOwnPosts = '0';
                }
                
                if($this->input->post('editOwnDiscussions') == '1')
                {
                    $editOwnDiscussions = '1';
                } else {
                    $editOwnDiscussions = '0';
                }
                
                if($this->input->post('deleteOwnDiscussions') == '1')
                {
                    $deleteOwnDiscussions = '1';
                } else {
                    $deleteOwnDiscussions = '0';
                }
                
                if($this->input->post('modsEditPosts') == '1')
                {
                    $modsEditPosts = '1';
                } else {
                    $modsEditPosts = '0';
                }
                
                if($this->input->post('modsDeletePosts') == '1')
                {
                    $modsDeletePosts = '1';
                } else {
                    $modsDeletePosts = '0';
                }
                
                if($this->input->post('modsEditDiscussions') == '1')
                {
                    $modsEditDiscussions = '1';
                } else {
                    $modsEditDiscussions = '0';
                }
                
                if($this->input->post('modsDeleteDiscussions') == '1')
                {
                    $modsDeleteDiscussions = '1';
                } else {
                    $modsDeleteDiscussions = '0';
                }
                
                if($this->input->post('canStickyDiscussions') == '1')
                {
                    $canStickyDiscussions = '1';
                } else {
                    $canStickyDiscussions = '0';
                }
                
                if($this->input->post('canCloseDiscussions') == '1')
                {
                    $canCloseDiscussions = '1';
                } else {
                    $canCloseDiscussions = '0';
                }
                
                if($this->input->post('modsStickyDiscussions') == '1')
                {
                    $modsStickyDiscussions = '1';
                } else {
                    $modsStickyDiscussions = '0';
                }
                
                if($this->input->post('modsCloseDiscussions') == '1')
                {
                    $modsCloseDiscussions = '1';
                } else {
                    $modsCloseDiscussions = '0';
                }
				
				$data = array(
					'themeID' => $this->input->post('theme'),
					'sName' => $this->input->post('sName'),
					'siteUrl' => $this->input->post('siteUrl'),
					'siteLanguage' => $this->input->post('siteLanguage'),
					'adminEmail' => $this->input->post('adminEmail'),
					'siteKeywords' => $this->input->post('siteKeywords'),
					'siteDescription' => $this->input->post('siteDescription'),
					'topicsPerPage' => $this->input->post('topicsPerPage'),
					'allowRegistration' => $allowRegistration,
					'postsPerPage' => $this->input->post('postsPerPage'),
                    'editOwnPosts' => $editOwnPosts,
                    'deleteOwnPosts' => $deleteOwnPosts,
                    'editOwnDiscussions' => $editOwnDiscussions,
                    'deleteOwnDiscussions' => $deleteOwnDiscussions,
                    'canStickyDiscussions' => $canStickyDiscussions,
                    'canCloseDiscussions' => $canCloseDiscussions,
                    'modsEditPosts' => $modsEditPosts,
                    'modsDeletePosts' => $modsDeletePosts,
                    'modsEditDiscussions' => $modsEditDiscussions,
                    'modsDeleteDiscussions' => $modsDeleteDiscussions,
                    'modsStickyDiscussions' => $modsStickyDiscussions,
                    'modsCloseDiscussions' => $modsCloseDiscussions,
				);
				$this->db->update('forum_settings', $data);
				
				$data = array(
					'siteName' => $this->input->post('sName'),
					'adminEmail' => $this->input->post('adminEmail'),
				);

				if ($this->write_settings($data) == false) 
				{
					set_global_messages($this->lang->line('settingsUpdateFailed'), 'error');
					redirect(lang().'/admin/settings/manage');
				}
				
				$data = array(
					'siteUrl' => $this->input->post('siteUrl'),
					'siteLanguage' => $this->input->post('siteLanguage'),
				);
				
				if ($this->write_config($data) == false) 
				{
					set_global_messages($this->lang->line('settingsUpdateFailed'), 'error');
					redirect(lang().'/admin/settings/manage/');
				}
				else
				{
					set_global_messages($this->lang->line('settingsUpdated'), 'success');
					redirect(lang().'/admin/settings/manage/');
				}
			
				break;
				
				default:
				/**
				* Load all the users from the database
				**/
				$settings = $this->admin_m->get_settings();
				$themes = $this->admin_m->get_themes();
				
				foreach($themes as $row)		
				{			
					$theme_options[$row['themeID']] = $row['themeName'];	
				}	
				
				// To fix - Add language support via database.
				$language_options['english'] = 'English';
				
				foreach($settings as $row)
				{
					$sName = array(
						'name'	=> 'sName',
						'id'	=> 'sName',
						'type'	=> 'text',
						'value'	=> ''.$row['sName'].'',
						'class'	=> 'textbox',
					);
					
					$adminEmail = array(
						'name'	=> 'adminEmail',
						'id'	=> 'adminEmail',
						'type'	=> 'text',
						'value' => ''.$row['adminEmail'].'',
						'class' => 'textbox',
					);
					
					$siteUrl = array(
						'name'	=> 'siteUrl',
						'id'	=> 'siteUrl',
						'type'	=> 'text',
						'value' => ''.$row['siteUrl'].'',
						'class' => 'textbox',
					);
					
					$siteLanguage = array(
						'name' => 'siteLanguage',
						'id' => 'siteLanguage',
						'type' => 'text',
						'value' => ''.$row['siteLanguage'].'',
						'class' => 'textbox',
					);
					
					$siteKeywords = array(
						'name'	=> 'siteKeywords',
						'id'	=> 'siteKeywords',
						'type'	=> 'textarea',
						'value' => ''.$row['siteKeywords'].'',
						'class'	=> 'textarea',
					);
				
					$siteDescription = array(
						'name'	=> 'siteDescription',
						'id'	=> 'siteDescription',
						'type'	=> 'textarea',
						'value' => ''.$row['siteDescription'].'',
						'class'	=> 'textarea',
					);
			
					if($row['allowRegistration'] == '1')
					{ 
						$checked = TRUE; 
					}
					else
					{
						$checked = FALSE; 
					}
				
					$allowRegistration = array(
						'name'        => 'allowRegistration',
						'id'		  => 'allowRegistration',
						'class'       => 'checkbox',
						'value'       => '1',
						'checked'	  => $checked,
					);	
				
					$topicsPerPage = array(
						'name'	=> 'topicsPerPage',
						'id'	=> 'topicsPerPage',
						'type'	=> 'textarea',
						'value' => ''.$row['topicsPerPage'].'',
						'class'	=> 'textbox',
					);
				
					$postsPerPage = array(
						'name'	=> 'postsPerPage',
						'id'	=> 'postsPerPage',
						'type'	=> 'textarea',
						'value' => ''.$row['postsPerPage'].'',
						'class'	=> 'textbox',
					);
                    
                    if($row['deleteOwnDiscussions'] == '1')
                    {
                        $deleteOwnDiscussions = TRUE;
                    } else {
                        $deleteOwnDiscussions = FALSE;
                    }
                    
                    $deleteOwnDiscussions = array(
                        'name' => 'deleteOwnDiscussions',
                        'id' => 'deleteOwnDiscussions',
                        'value' => '1',
                        'class' => 'checkbox',
                        'checked' => $deleteOwnDiscussions,
                    );
                    
                    if($row['editOwnDiscussions'] == '1')
                    {
                        $editOwnDiscussions = TRUE;
                    } else {
                        $editOwnDiscussions = FALSE;
                    }
                    
                    $editOwnDiscussions = array(
                        'name' => 'editOwnDiscussions',
                        'id' => 'editOwnDiscussions',
                        'value' => '1',
                        'class' => 'checkbox',
                        'checked' => $editOwnDiscussions,
                    );
                    
                    if($row['editOwnPosts'] == '1')
                    {
                        $editOwnPosts = TRUE;
                    } else {
                        $editOwnPosts = FALSE;
                    }
                    
                    $editOwnPosts = array(
                        'name' => 'editOwnPosts',
                        'id' => 'editOwnPosts',
                        'value' => '1',
                        'class' => 'checkbox',
                        'checked' => $editOwnPosts,
                    );
                    
                    if($row['deleteOwnPosts'] == '1')
                    {
                        $deleteOwnPosts = TRUE;
                    } else {
                        $deleteOwnPosts = FALSE;
                    }
                    
                    $deleteOwnPosts = array(
                        'name' => 'deleteOwnPosts',
                        'id' => 'deleteOwnPosts',
                        'value' => '1',
                        'class' => 'checkbox',
                        'checked' => $deleteOwnPosts,
                    );
                    
                    if($row['modsDeletePosts'] == '1')
                    {
                        $modsDeletePosts = TRUE;
                    } else {
                        $modsDeletePosts = FALSE;
                    }
                    
                    if($row['canStickyDiscussions'] == '1')
                    {
                        $canStickyDiscussions = TRUE;
                    } else {
                        $canStickyDiscussions = FALSE;
                    }
                    
                    $canStickyDiscussions = array(
                        'name' => 'canStickyDiscussions',
                        'id' => 'canStickyDiscussions',
                        'value' => '1',
                        'class' => 'checkbox',
                        'checked' => $canStickyDiscussions,
                    );
                    
                    if($row['canCloseDiscussions'] == '1')
                    {
                        $canCloseDiscussions = TRUE;
                    } else {
                        $canCloseDiscussions = FALSE;
                    }
                    
                    $canCloseDiscussions = array(
                        'name' => 'canCloseDiscussions',
                        'id' => 'canCloseDiscussions',
                        'value' => '1',
                        'class' => 'checkbox',
                        'checked' => $canCloseDiscussions,
                    );
                    
                    $modsDeletePosts = array(
                        'name' => 'modsDeletePosts',
                        'id' => 'modsDeletePosts',
                        'value' => '1',
                        'class' => 'checkbox',
                        'checked' => $modsDeletePosts,
                    );
                    
                    if($row['modsEditPosts'] == '1')
                    {
                        $modsEditPosts = TRUE;
                    } else {
                        $modsEditPosts = FALSE;
                    }
                    
                    $modsEditPosts = array(
                        'name' => 'modsEditPosts',
                        'id' => 'modsEditPosts',
                        'value' => '1',
                        'class' => 'checkbox',
                        'checked' => $modsEditPosts,
                    );
                    
                    if($row['modsDeleteDiscussions'] == '1')
                    {
                        $modsDeleteDiscussions = TRUE;
                    } else {
                        $modsDeleteDiscussions = FALSE;
                    }
                    
                    $modsDeleteDiscussions = array(
                        'name' => 'modsDeleteDiscussions',
                        'id' => 'modsDeleteDiscussions',
                        'value' => '1',
                        'class' => 'checkbox',
                        'checked' => $modsDeleteDiscussions,
                    );
                    
                    if($row['modsEditDiscussions'] == '1')
                    {
                        $modsEditDiscussions = TRUE;
                    } else {
                        $modsEditDiscussions = FALSE;
                    }
                    
                    $modsEditDiscussions = array(
                        'name' => 'modsEditDiscussions',
                        'id' => 'modsEditDiscussions',
                        'value' => '1',
                        'class' => 'checkbox',
                        'checked' => $modsEditDiscussions,
                    );
                    
                    if($row['modsStickyDiscussions'] == '1')
                    {
                        $modsStickyDiscussions = TRUE;
                    } else {
                        $modsStickyDiscussions = FALSE;
                    }
                    
                    $modsStickyDiscussions = array(
                        'name' => 'modsStickyDiscussions',
                        'id' => 'modsStickyDiscussions',
                        'value' => '1',
                        'class' => 'checkbox',
                        'checked' => $modsStickyDiscussions,
                    );
                    
                    if($row['modsCloseDiscussions'] == '1')
                    {
                        $modsCloseDiscussions = TRUE;
                    } else {
                        $modsCloseDiscussions = FALSE;
                    }
                    
                    $modsCloseDiscussions = array(
                        'name' => 'modsCloseDiscussions',
                        'id' => 'modsCloseDiscussions',
                        'value' => '1',
                        'class' => 'checkbox',
                        'checked' => $modsCloseDiscussions,
                    );
				}

				// Construct the data array for the page
				$data = array(
					'siteName'				=> $this->siteName, // Variable from MY_Controller
					'adminTheme' 			=> $this->adminTheme, // Variable from MY_Controller
					'errorMessageTitle' 	=> $this->errorTitle,
					'Error' 				=> $this->Error,
					'successMessageTitle' 	=> $this->messageTitle,
					'Message' 				=> $this->Message,
					'settings'				=> $settings,
					'sName'					=> $sName,
					'siteUrl'				=> $siteUrl,
					'siteLanguage'			=> $siteLanguage,
					'adminEmail'			=> $adminEmail,
					'siteKeywords'			=> $siteKeywords,
					'siteDescription'		=> $siteDescription,
					'allowRegistration'		=> $allowRegistration,
					'topicsPerPage'			=> $topicsPerPage,
					'postsPerPage'			=> $postsPerPage,
					'theme_options'			=> $theme_options,
                    'editOwnPosts'          => $editOwnPosts,
                    'deleteOwnPosts'        => $deleteOwnPosts,
                    'editOwnDiscussions'    => $editOwnDiscussions,
                    'deleteOwnDiscussions'  => $deleteOwnDiscussions,
                    'canStickyDiscussions'  => $canStickyDiscussions,
                    'canCloseDiscussions'   => $canCloseDiscussions,
                    'modsEditPosts'         => $modsEditPosts,
                    'modsDeletePosts'       => $modsDeletePosts,
                    'modsEditDiscussions'   => $modsEditDiscussions,
                    'modsDeleteDiscussions' => $modsDeleteDiscussions,
                    'modsStickyDiscussions' => $modsStickyDiscussions,
                    'modsCloseDiscussions'  => $modsCloseDiscussions,
				);
			
				//Page construction variables
				$page = 'settings';
				$title = $this->lang->line('manageSettingsTitle');
				$this->admin_construct($page, $title, $data);
			}
		}	
	}
	
	// Function to write the ion_auth settings file
	public function write_settings($data) 
	{
		// Config path
		$template_path = ''.getcwd().'/application/modules/installer/views/installer/masks/ion_auth_temp.php';
		$output_path = ''.getcwd().'/application/config/ion_auth.php';

		// Open the file
		$database_file = file_get_contents($template_path);

		$new  = str_replace("%SITETITLE%",$data['siteName'],$database_file);
		$new  = str_replace("%ADMINEMAIL%",$data['adminEmail'],$new);

		// Write the new database.php file
		$handle = fopen($output_path,'w+');

		// Chmod the file, in case the user forgot
		@chmod($output_path,0777);

		// Verify file permissions
		if(is_writable($output_path)) 
		{
			// Write the file
			if(fwrite($handle,$new)) 
			{
				return true;
			} 
			else 
			{
				return false;
			}

		} 
		else 
		{
			return false;
		}
	}
	
	// Function to write the config file
	public function write_config($data) 
	{
		// Config path
		$template_path = ''.getcwd().'/application/modules/installer/views/installer/masks/config_temp.php';
		$output_path = ''.getcwd().'/application/config/config.php';

		// Open the file
		$database_file = file_get_contents($template_path);

		$new  = str_replace("%BASEURL%",$data['siteUrl'],$database_file);
		$new  = str_replace("%LANGUAGE%",$data['siteLanguage'],$new);
		
		@chmod($output_path,0777);

		// Write the new database.php file
		$handle = fopen($output_path,'w+');

		// Chmod the file, in case the user forgot
		@chmod($output_path,0777);

		// Verify file permissions
		if(is_writable($output_path)) 
		{
			// Write the file
			if(fwrite($handle,$new)) 
			{
				return true;
			} 
			else 
			{
				return false;
			}
		} 
		else 
		{
			return false;
		}
	}
	
	
	// Function for save Request category data 
	public function udpdate_request()
	{
		
		$categoryID 	= 	$this->input->post('category_id');
		$cat_name 	 	= 	$this->input->post('cat_name');
		$postBody  	 	= 	$this->input->post('postBody');
		
		$data = array(
				'Active' => '1',
				'Name'	=> $cat_name,
				'Description' => $postBody,
			);
			
		$this->db->where('CategoryID', $categoryID);
		$this->db->update('forum_category', $data);

		set_global_messages($this->lang->line('categoryAeactivated'), 'success');
		redirect(lang().'/admin/categories/manage/');
							
	}
	
}
