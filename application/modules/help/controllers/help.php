<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
*
* Help Controller 
*
* @author			Chris Baines
* @package			Dove Help
* @copyright		© 2010 - 2011 Dove Help
* @last modified	31/01/2011
**/
class Help extends MY_Controller {
	
	/**
	* Constructor Method
	**/	
	
	private $userId = null;
	public function __construct()
	{
		//Call constructor
		parent::__construct();
		// $this->userId= $this->isLoginUser();
		// Load authentication model
		$this->load->model(array('ion_auth_model','help_topics','help_posts','help_users'));
		

		// Load required language files
		$this->load->language('help');
		$this->load->language('messages');
		$module = 'help';
		
		
		
		//$this->head->add_css($this->config->item('forum_css').'default.css');
		//$this->head->add_css($this->config->item('forum_css').'forums_help.css');
		$this->head->add_js($this->config->item('forum_js').'forums.js');
		
		//add advertising module if exists
		if(is_dir(APPPATH.'modules/advertising')){
			$this->load->model(array('advertising/model_advertising'));
		}
	}
		
	/**
	* Index Function - List all topics, no category selected
	**/	
	public function index($limit='', $offset='')
	{	
		/**
		* Setup config settings for pagination
		*
		* @base_url - The base url for the pagination.
		* @total_rows - The total number of returned rows.
		* @url_segment - Part of url to look at for pagination offset.
        * @per_page - Setting for topics to show per page.
		**/
		$config['base_url'] = site_url().'/help/index/';
		$config['total_rows'] = $this->help_topics->count_topics(); 
		$config['uri_segment'] = 3;
		$config['per_page'] = $this->sSettings[0]['topicsPerPage'];
		
		/**
		* Initialize the pagination
		**/
		$this->pagination->initialize($config);
		
		/**
		* Build links for the pagination
		**/		
		$links = $this->pagination->create_links();
        
        /**
        * Offset & Limit for topics query
        **/
	   	$limit = $this->sSettings[0]['topicsPerPage'];
	//   	$offset = $this->uri->segment(3); // For pagination


		

		/**
		* Construct the data array for the page
		**/
		$data = array(
			'siteName' 				=> $this->siteName,			
			'siteTheme' 			=> $this->siteTheme,
			'welcomeMessage'		=> $this->sSettings[0]['siteWelcomeMessage'],
			'topics' 				=> $this->help_topics->get_topics($limit, $offset),
			'categories' 			=> $this->categories_m->get_categories('help'),
			'category' 				=> $this->lang->line('noCategory'),
			'errorMessageTitle' 	=> $this->errorTitle,
			'Error' 				=> $this->Error,
			'successMessageTitle' 	=> $this->messageTitle,
			'Message' 				=> $this->Message,
			'links' 				=> $links,
			'forumsInstalled'		=> $this->forumInstalled,
            'navigation'            => $this->build_navigation(),
            'deleteOwnDiscussions'  => $this->sSettings[0]['deleteOwnDiscussions'],
            'editOwnDiscussions'    => $this->sSettings[0]['editOwnDiscussions'],
            'modsEditDiscussions'   => $this->sSettings[0]['modsEditDiscussions'],
            'modsDeleteDiscussions' => $this->sSettings[0]['modsDeleteDiscussions'],
            'userId'				=> isLoginUser(),
            'getCatSubCat'          => $this->categories_m->getCurrentCatSubCat('-1'),
		);

		/**
		* Send page to the page constructor
		**/
		$page = 'help';
		$title = $this->lang->line('titleHome');
		//manage advert types if exists
		if(is_dir(APPPATH.'modules/advertising')) {
			//Set advert section id
			$advertSectionId = $this->config->item('forumSectionId');				    
		
			//Get banner records based on section and advert type
			$bannerType1 = $this->model_advertising->getBannerRecords($advertSectionId,1,1);
			$bannerType2 = $this->model_advertising->getBannerRecords($advertSectionId,2,1);
			$bannerType3 = $this->model_advertising->getBannerRecords($advertSectionId,3,1);
			
			$data['advertSectionId'] = $advertSectionId; //set advert section id
			//Load view of advert js functions
			$data['advertChangeView'] = $this->load->view('advertising/advertAutoChange',array('bannerType1'=>$bannerType1,'bannerType2'=>$bannerType2,'bannerType3'=>$bannerType3,'sectionId'=>$advertSectionId),true);
		} 
		
		
		/**
		*  Add breadcrumb in view
		**/ 
        $breadcrumbItem=array('Tips');
		$breadcrumbURL=array('help/');
		$breadcrumbString=set_breadcrumb("","", $breadcrumbItem ,$breadcrumbURL);
		$data['breadcrumbString']=$breadcrumbString;
			
		$data['page']=$this->forums_page_construct($page, $title, $data, 'help');
		
		$this->new_version->load('new_version','help_innerTemplate',$data);	
		
		/**
		* Log 
		**/
		log_message('debug', 'Index function executed successfully! - /modules/help/controllers/help/index');
		/**
		* Benchmark
		**/


		$this->output->enable_profiler(FALSE); 
	}

	/**
	* Topics Function - List all topics in a category with pagination
	**/		
	public function topics($category='', $offset='')
	{		
		/**
		* Setup config settings for pagination
		*
		* @base_url - The base url for the pagination
		* @total_rows - The total number of returned rows
		* @url_segment - Part of url to look at for pagination offset
        * @per_page - Setting for topics to show per page.
		**/
		$config['base_url'] = site_url().'help/topics/'.$this->uri->segment(4).'';

		$config['total_rows'] = $this->help_topics->count_cat_topics($category); 
		$config['uri_segment'] = 5;
		$config['per_page'] = $this->sSettings[0]['topicsPerPage'];
		
		/**
		* Initialize the pagination
		**/
		$this->pagination->initialize($config);
		
		/**
		* Build links for the pagination
		**/		
		$links = $this->pagination->create_links();
        
        /**
        * Limit & Offset for topics query
        **/
		$limit = $this->sSettings[0]['topicsPerPage'];
		$offset = $this->uri->segment(5);

		/**
		* Construct the data array for the page
		**/


		$data = array(
			'siteName' 				=> $this->siteName,			
			'siteTheme' 			=> $this->siteTheme,
			'welcomeMessage'		=> $this->sSettings[0]['siteWelcomeMessage'],			
			'topics' 				=> $this->help_topics->get_cat_topics($category, $limit, $offset), 	
			'pagination' 			=> $this->pagination->create_links(),
			'categories'			=> $this->categories_m->get_categories('help'),
			'category' 				=> $this->categories_m->get_current_cat($category),
			'errorMessageTitle' 	=> $this->errorTitle,
			'Error' 				=> $this->Error,
			'successMessageTitle' 	=> $this->messageTitle,
			'Message' 				=> $this->Message,
			'links' 				=> $links,
			'forumsInstalled'		=> $this->sSettings[0]['forumInstalled'],
            'navigation'            => $this->build_navigation(),
            'deleteOwnDiscussions'  => $this->sSettings[0]['deleteOwnDiscussions'],
            'editOwnDiscussions'    => $this->sSettings[0]['editOwnDiscussions'],
            'modsEditDiscussions'   => $this->sSettings[0]['modsEditDiscussions'],
            'modsDeleteDiscussions' => $this->sSettings[0]['modsDeleteDiscussions'],
            'userId'				=> isLoginUser(),
            'parentID'				=> $this->topics_m->getCategoryStatus($category),
            'getCatSubCat'          => $this->categories_m->getCurrentCatSubCat($category), 
            'selectedCategory' => $this->uri->segment(4),
            
		);
		
		
		
		/**
		* Send page to the page constructor
		**/
		$page = 'help';
		$title = $this->lang->line('titleTopics');
		
		//manage advert types if exists
		if(is_dir(APPPATH.'modules/advertising')) {
			//Set advert section id
			$advertSectionId = $this->config->item('forumSectionId');				    
		
			//Get banner records based on section and advert type
			$bannerType1 = $this->model_advertising->getBannerRecords($advertSectionId,1,1);
			$bannerType2 = $this->model_advertising->getBannerRecords($advertSectionId,2,1);
			$bannerType3 = $this->model_advertising->getBannerRecords($advertSectionId,3,1);
			
			$data['advertSectionId'] = $advertSectionId; //set advert section id
			//Load view of advert js functions
			$data['advertChangeView'] = $this->load->view('advertising/advertAutoChange',array('bannerType1'=>$bannerType1,'bannerType2'=>$bannerType2,'bannerType3'=>$bannerType3,'sectionId'=>$advertSectionId),true);
		} 
		
		/**
		*  Add breadcrumb in view
		**/ 
		
        $breadcrumbItem=array('Help','Category');
		$breadcrumbURL=array('help','help/topics/'.$category);
		$breadcrumbString=set_breadcrumb("","", $breadcrumbItem ,$breadcrumbURL);
		$data['breadcrumbString']=$breadcrumbString;
		
		$data['page']=$this->forums_page_construct($page, $title, $data);
		
		$this->new_version->load('new_version','help_innerTemplate',$data);

		/**
		* Log 
		**/	
		log_message('debug', 'Topics function executed successfully! - /modules/help/controllers/help/topics');
		
		/**
		* Benchmark
		**/	
		$this->output->enable_profiler(FALSE);	 
	}	
	

	
	/**
	* Posts Function - List all posts in a category with pagination
	**/		
	public function posts($category_id=NULL, $topic_id=NULL, $offset=NULL)
    {
		
		/**
		* Setup config settings for pagination
		*
		* @base_url - The base url for the pagination
		* @total_rows - The total number of returned rows
		* @url_segment - Part of url to look at for pagination offset
        * @per_page - Setting for topics to show per page.
        * 
		**/
		
		if(!$this->uri->segment(4) || !$this->uri->segment(5))
		{
			$config['base_url'] = site_url().'help/posts/'.$this->session->userdata('cat_id').'/'.$this->session->userdata('post_id').'';
			$topic_id = $this->session->userdata('post_id');
			$category_id = $this->session->userdata('cat_id');

			$config['total_rows'] = $this->help_topics->count_posts($topic_id);
		} 
		else 
		{
				$config['base_url'] = site_url().'help/posts/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'';
				$config['total_rows'] = $this->help_topics->count_posts($topic_id);
				
				$this->session->set_userdata('cat_id', $this->uri->segment(4));
				$this->session->set_userdata('post_id', $this->uri->segment(5));
		}

		$config['uri_segment'] = 6;
		$config['per_page'] = $this->sSettings[0]['postsPerPage']; 
			
		/**
		* Initialize the pagination
		**/
		$this->pagination->initialize($config);

		/**
		* Build links for the pagination
		**/		
		$links = $this->pagination->create_links();
        
        /**
        * Limit & Offset for topics query
        **/
        $limit = $this->sSettings[0]['postsPerPage'];
        $offset = $this->uri->segment(6);

        if($this->session->userdata('user_id'))
        {
            // Update the bookmarks table if the user is checking the post from there bookmark
            $data = array(
                'bookmark_replys' => '0',
            );
        
            $options = array(
                'bookmark_user_id' => $this->session->userdata('user_id'),
                'bookmark_topic_id' => $this->uri->segment(5),
            );
        
            $this->db->update('forum_bookmarks', $data, $options);
        }

		/**
		* Construct the data array for the page
		**/
		$data = array(
			'siteName' 				=> $this->siteName,			
			'siteTheme' 			=> $this->siteTheme,
			'welcomeMessage'		=> $this->sSettings[0]['siteWelcomeMessage'],			
			'pagination' 			=> $this->pagination->create_links(),
			'categories' 			=> $this->categories_m->get_categories('help'),
			'category' 				=> $this->categories_m->get_current_cat($category_id),
			'errorMessageTitle' 	=> $this->errorTitle,
			'Error' 				=> $this->Error,
			'successMessageTitle' 	=> $this->messageTitle,
			'Message' 				=> $this->Message,
			'topicName' 			=> $this->help_topics->get_topic_name($topic_id),
            'firstPost'             => $this->help_topics->get_first_post($topic_id),
			'posts' 				=> $this->help_topics->get_posts($limit, $topic_id, $offset),
			'links' 				=> $links,
			'forumsInstalled'		=> $this->sSettings[0]['forumInstalled'],
            'navigation'            => $this->build_navigation(),
            'editOwnPosts'          => $this->sSettings[0]['editOwnPosts'],
            'deleteOwnPosts'        => $this->sSettings[0]['deleteOwnPosts'],
            'modsEditPosts'         => $this->sSettings[0]['modsEditPosts'],
            'modsDeletePosts'       => $this->sSettings[0]['modsDeletePosts'],
            'userId'				=> isLoginUser(),
             'getCatSubCat'          => $this->categories_m->getCurrentCatSubCat($category_id),
              'selectedCategory' => $this->uri->segment(4),
		);	
		
		/**
		* Send page to the page constructor
		**/
	
		$page = 'posts';
		$title = ''.$this->categories_m->get_current_cat($category_id).' | '.$this->help_topics->get_topic_name($topic_id).'';
	
		/**
		*  Add breadcrumb in view
		**/ 
		
	    $breadcrumbItem=array('Help','Discussion');
		$breadcrumbURL=array('help','help/posts/'.$category_id.'/'.$topic_id);
		$breadcrumbString=set_breadcrumb("","", $breadcrumbItem ,$breadcrumbURL);
		$data['breadcrumbString']=$breadcrumbString;
		
	
		$data['page']=$this->forums_page_construct($page, $title, $data);
		
		
		$this->new_version->load('new_version','help_innerTemplate',$data);
		
		/**
		* Logs
		**/		
		log_message('debug', 'Posts function executed successfully! - /modules/help/controllers/help/posts');
		/**
		* Benchmark
		**/	
		$this->output->enable_profiler(FALSE);
    }

	/**
	* submit Post Function - Enters the post into the database via help_posts model
	**/		
	public function submit_post()
	{
		/**
		* Check to see if the user is logged in.
		**/	
		if(!$this->ion_auth->logged_in())
		{
			/**
			* The user is not logged in, redirect them with a message.
			**/	
			set_global_messages($this->lang->line('errorLoginRequired'), 'error');
			redirect('help');
		}
		else
		{            
    		/**
    		* Logs
    		**/		
    		log_message('debug', 'Submit Post function executed successfully! - /modules/help/controllers/help/subit_post');
            
			/**
			* The user is logged in, submit there post.
			**/	
			$this->help_posts->submit_post();
		}
	}
	
	public function login()
	{
		/**
		* Store the page the user came from.
		**/	 
		if(isset($_SERVER['HTTP_REFERER']))
		{
			$this->session->set_userdata('refered_from', $_SERVER['HTTP_REFERER']);
		}else
		{
			redirect(site_url('help'));
		}
		
		/**
		* Check to see if the user can login.
		**/	
		if($this->sSettings[0]['allowLogin'])
		{
			/**
			* Form validation settings.
			**/	
			$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');		
			$this->form_validation->set_rules('password', 'Password', 'required');				
		
			if($this->form_validation->run() == true)		
			{			
				if($this->input->post('remember') == '1')			
				{				
					$remember = true;			
				}			
				else			
				{				
					$remember = false;			
				}								
			
				if($this->ion_auth->login($this->input->post('email'), $this->input->post('password'), $remember))			
				{								
					$data = array(
						'username' 			=> $this->session->userdata('username'),
						'date' 				=> time(),
						'activity' 			=> 'login',
					);				
					$this->db->insert('activity', $data);
			
					set_global_messages($this->lang->line('messageLoginSuccess'), 'success');
					redirect('help', 'refresh');
				}			
				else			
				{					
					
					set_global_messages($this->lang->line('errorLoginFailed'), 'error');
					redirect('help', 'refresh');			
				}		
			}
			else
			{
				if($this->form_validation->run() == FALSE)		
				{			
					set_global_messages(validation_errors(), 'error');
					// Send the user back to the page they came from
					redirect($this->session->userdata('refered_from'));
				}
			}
		}
		else
		{	
			// Login feature is turned off, redirect the user and let them know.
			
			set_global_messages($this->lang->line('messageFeatureOff'), 'error');

			// Send the user back to the page they came from
			redirect($this->session->userdata('refered_from'));	
				
		}
		
		log_message('debug', 'Login function executed successfully! - /modules/help/controllers/help/login');			
		$this->output->enable_profiler(FALSE);	
	}	
	
	public function logout()
    {
		/**
		* Perform the logout.
		**/	
        $this->ion_auth->logout();
		
		/**
		* Redirect the user.
		**/	
		
		set_global_messages($this->lang->line('messageLogoutSuccess'), 'message');

        redirect('help');
    }
		
	public function new_topic()	
	{	
		/**
		* Store the page the user came from.
		**/	 
		if(isset($_SERVER['HTTP_REFERER']))
		{
			$this->session->set_userdata('refered_from', $_SERVER['HTTP_REFERER']);
		}else
		{
			redirect(site_url('help'));
		}
        
		if(!$this->ion_auth->logged_in())
		{
			/**
			* The user is not logged in, redirect them.
			**/	
			set_global_messages($this->lang->line('errorLoginRequired'), 'error');

			redirect($this->session->userdata('refered_from'));
			
		}
		else
		{	
			/**
			* Get all categories from the database.
			**/	
			//$categories = $this->categories_m->get_categories('forums');old code 
			$categories = $this->categories_m->get_categories_new_topic('help');
            
            			
			/**
			* Create a dropdown box.
			**/	
            $category_options = array(' ' => 'Select Category');
			foreach($categories as $row)		
			{
				if($row['parentID']!='0')
				{
					$category_options[$row['CategoryID']] = '--'.$row['Name'];
				}else
				{
					$category_options[$row['CategoryID']] = $row['Name'];
				}
				$subCategories = $this->categories_m->get_sub_categories($row['CategoryID'],'help');
				foreach($subCategories as $sub_row)
				{
					$category_options[$sub_row['CategoryID']] = '--'.$sub_row['Name'].'';
				}	
			}	
					
			/**
			* Build the form fields.
			**/	
			$title = array(			
				'name' 				=> 'title',
				'id' 				=> 'title',
				'type' 				=> 'text',
				'class' 			=> 'bdr_bbb fl required',
                'placeholder'       =>  'Discussion Title*',
			);			 		
			
			$search_tag = array(			
				'name' 				=> 'search_tag',
				'id' 				=> 'search_tag',
				'type' 				=> 'text',
				'title' 			=> $this->lang->line('SearchTagsTips'),
				'class' 			=> 'width322 required',
			);			 		
	
			$comments = array(			
				'name' 				=> 'comment',			
				'id' 				=> 'comment',	
				'class'				=> 'width475 box_siz height128 required',
				'cols'				=> '62',
                'placeholder'       => 'Comment*',
			);	

			$sticky = array(
				'name'        => 'Sticky',
				'class'       => 'checkbox',
				'value'       => '1',
				'checked'     => FALSE,
			);	

			$close = array(
				'name'		=> 'Close',
				'class'		=> 'checkbox',
				'value'		=> '1',
				'checked'	=> FALSE,
			);
			
			$postDiscussion = array(
				'name'		=> 'postDiscussion',
				'id'		=> 'postDiscussion',
				'class'		=> '',
				'type'		=> 'submit',
				'value'	=> $this->lang->line('newTopicButton'),
			);
			/**
			* Construct the data array for the page
			**/
			$data = array(			
				'siteName' 				=> $this->siteName,			
				'siteTheme' 			=> $this->siteTheme,
				'welcomeMessage'		=> $this->sSettings[0]['siteWelcomeMessage'],			
				'category_options' 		=> $category_options,			
				'Title' 				=> $title,		
				'Search_tag'			=> $search_tag,
				'Comments' 				=> $comments,	
				'Sticky'				=> $sticky,
				'Close'					=> $close,
				'postDiscussion'		=> $postDiscussion,
				'errorMessageTitle' 	=> $this->errorTitle,
				'Error' 				=> $this->Error,
				'successMessageTitle' 	=> $this->messageTitle,
				'Message' 				=> $this->Message,		
				'forumsInstalled'		=> $this->sSettings[0]['forumInstalled'],
                'navigation'            => $this->build_navigation(),
                'modsStickyDiscussions' => $this->sSettings[0]['modsStickyDiscussions'],
                'modsCloseDiscussions'  => $this->sSettings[0]['modsCloseDiscussions'],
                'canStickyDiscussions'  => $this->sSettings[0]['canStickyDiscussions'],
                'canCloseDiscussions'   => $this->sSettings[0]['canCloseDiscussions'],
			);			

			/**
			* Send page to the page constructor
			**/
			$page = 'new_topic';
			$title = $this->lang->line('titleCreateNewDiscussion');
			
			
			/**
			*  Add breadcrumb in view
			**/ 
			$breadcrumbItem=array('Help','New Discussion');
			$breadcrumbURL=array('help/','help/new_topic');
			$breadcrumbString=set_breadcrumb("","", $breadcrumbItem ,$breadcrumbURL);
			$data['breadcrumbString']=$breadcrumbString;
			
			$data['page']=$this->forums_page_construct($page, $title, $data);		
			$this->new_version->load('new_version','help_innerTemplate',$data);	
			/**
			* Logs
			**/	
			log_message('debug', 'new_topic function executed successfully! - /modules/help/controllers/help/new_topic');		
			/**
			* Benchmarking
			**/	
			$this->output->enable_profiler(FALSE); 
		}	
	}
    
    public function remove_bookmark($topicID)
    {
        /**
        * Store the page the user came from.
        **/
        if(isset($_SERVER['HTTP_REFERER']))
		{
			$this->session->set_userdata('refered_from', $_SERVER['HTTP_REFERER']);
		}else
		{
			redirect(site_url('help'));
		}
        
        /**
        * Check to see if the user is logged in.
        **/
        if(!$this->ion_auth->logged_in())
        {
            /**
            * The user is not logged in, redrect them with a message.
            **/
            set_global_messages($this->lang->line('errorLoginRequired'), 'error');
            redirect($this->session->userdata('refered_from'));
        }
        else
        {
            $bookmark = $this->help_topics->remove_bookmark($topicID);
            
            if($bookmark == true)
            {
                set_global_messages($this->lang->line('messageBookmarkRemoved'), 'message');

                redirect($this->session->userdata('refered_from'));
            }
            else
            {
                set_global_messages($this->lang->line('errorBookmarkRemoved'), 'error');

                redirect($this->session->userdata('refered_from'));
            }
        }
    }
    
    public function bookmark_topic($topicID)
    {
		/**
		* Store the page the user came from.
		**/	 
		if(isset($_SERVER['HTTP_REFERER']))
		{
			$this->session->set_userdata('refered_from', $_SERVER['HTTP_REFERER']);
		}else
		{
			redirect(site_url('help'));
		}
        
        /**
        * Check to see if the user is loggen in.
        **/
        if(!$this->ion_auth->logged_in())
        {
            /**
            * The user is not logged in, redirect them with a message.
            **/
             set_global_messages($this->lang->line('errorLoginRequired'), 'error');

            redirect($this->session->userdata('refered_from'));
        }
        else
        {
            $topicTitle = $this->help_topics->get_topic_name($topicID);
            
            $bookmark = $this->help_topics->add_bookmark($topicID, $topicTitle);
            
            if($bookmark == true)
            {
                set_global_messages($this->lang->line('messageBookmarkAdded'), 'success');

                redirect($this->session->userdata('refered_from'));
            }
            else
            {
                // There has being a error inserting the data, let the user know
                
                 set_global_messages($this->lang->line('errorBookmarkFailed'), 'error');
                redirect($this->session->userdata('refered_from'));
            }
        }
    }
	
	public function submit_topic()	
	{	
	
		/**
		* Check to see if the user is logged in.
		**/		
		if(!$this->ion_auth->logged_in())
		{
			/**
			* The user is not logged in, redirect them with a message.
			**/	

			set_global_messages($this->lang->line('errorLoginRequired'), 'error');
			redirect('help');		
		}
		else
		{
			/**
			* The user is logged in, submit there post.
			**/	
			$this->help_topics->submit_topic();	
		}
	}
    
    public function delete_topic($topic_id)
    {
		/**
		* Check to see if the user is logged in.
		**/		
		if(!$this->ion_auth->logged_in())
		{
			/**
			* The user is not logged in, redirect them with a message.
			**/	
		     set_global_messages($this->lang->line('errorLoginRequired'), 'error');

			redirect('help');		
		}
		else
		{
    		/**
    		* Store the page the user came from.
    		**/	 
    		if(isset($_SERVER['HTTP_REFERER']))
			{
				$this->session->set_userdata('refered_from', $_SERVER['HTTP_REFERER']);
			}else
			{
				redirect(site_url('help'));
			}
            
            if($this->ion_auth->is_admin())
            {
                // The user is a admin let's delete the discussion.   
                if($this->help_topics->remove_discussion($topic_id))
                {
          		     set_global_messages('The discussion has being removed successfully!', 'success');
                    redirect($this->session->userdata('refered_from'));
                } 
            }
            if($this->ion_auth->is_group('moderators'))
            {
                // The user is a moderator, if they can delete discussions, let them.
                if($this->sSettings[0]['modsDeleteDiscussions'] == '1')
                {
                    if($this->help_topics->remove_discussion($topic_id))
                    {
              		     set_global_messages('The discussion has being removed successfully!', 'success');
                        redirect($this->session->userdata('refered_from'));
                    }else{

              		     set_global_messages('The discussion could not be removed, please try again!.', 'error');
                        redirect($this->session->userdata('refered_from'));
                    }
                }else{
 					set_global_messages('Moderators do not have permissions to remove discussions!', 'error');
                    redirect($this->session->userdata('refered_from'));
                }
            }
            elseif($this->sSettings[0]['deleteOwnDiscussions'] == '1')
            {
                // The user has permission to remove there own discussion.
                if($this->help_topics->remove_discussion($topic_id))
                {
                    //Topic was removed, inform the user and redirect.
  					set_global_messages('Your discussion has being removed successfully!', 'success');
                    redirect($this->session->userdata('refered_from'));
                }else{
                    //Something went wrong, inform the user and redirect.
					set_global_messages('You do not have permission to remove this discussion!.', 'error');
                    redirect($this->session->userdata('refered_from'));
                }    
            }           
        }
    }
    
    public function edit_topic($userId,$topic_id)
    {
		
	
		/**
		* Store the page the user came from.
		**/	 
		//$this->session->set_userdata('refered_from', $_SERVER['HTTP_REFERER']);
		
		if ($this->ion_auth->logged_in())
		{
			
            $discussion = $this->help_topics->get_topic($topic_id);
          
		  /**
			* Get all categories from the database.
			**/	
			$categories = $this->categories_m->get_categories('help');
            			
			/**
			* Create a dropdown box.
			**/	
            $category_options = array('0' => 'None Selected');
			foreach($categories as $row)		
			{
                $category_options[$row['CategoryID']] = $row['Name'];
				$subCategories = $this->categories_m->get_sub_categories($row['CategoryID'],'help');
				foreach($subCategories as $sub_row)
				{
					$category_options[$sub_row['CategoryID']] = '-- '.$sub_row['Name'].'';
				}	
			}	
            
            foreach($discussion as $row)
            {   
                $title = array(
                    'name' => 'title',
                    'id' => 'title',
                    'type' => 'text',
                    'value' =>  html_entity_decode($row['TopicName']),
                    'class' => 'width322 required',
                );
                
                $body = array(
                    'name' => 'body',
                    'id' => 'body',
                    'type' => 'text',
                    'value' =>  html_entity_decode($row['Body']),
                    'class' => 'width322 height128 required',
                );
                
                if($row['Sticky'] == '1')
                {
                    $sticky = TRUE;
                } else {
                    $sticky = FALSE;
                }
                
                $sticky = array(
                    'name' => 'sticky',
                    'id' => 'sticky',
                    'value' => '1',
                    'class' => 'checkbox',
                    'checked' => $sticky,
                );
                
                if($row['Closed'] == '1')
                {
                    $closed = TRUE;
                } else {
                    $closed = FALSE;
                }
                
                $closed = array(
                    'name' => 'closed',
                    'id' => 'closed',
                    'value' => '1',
                    'class' => 'checkbox',
                    'checked' => $closed,
                );
                
                $update_discussion = array(
                    'name' => 'update_discussion',
                    'id' => 'update_discussion',
                    'class' => 'btn_alt',
                    'type' => 'submit',
                    'value' => $this->lang->line('updateTopicButton'),
                );
                
    			$data = array(			
    				'siteName' 				=> $this->siteName,			
    				'siteTheme' 			=> $this->siteTheme,
    				'welcomeMessage'		=> $this->sSettings[0]['siteWelcomeMessage'],						
    				'Title' 				=> $title,			
    				'Body' 				    => $body,	
    				'Sticky'				=> $sticky,
    				'Close'					=> $closed,
    				'update_discussion'		=> $update_discussion,
    				'errorMessageTitle' 	=> $this->errorTitle,
    				'Error' 				=> $this->Error,
    				'successMessageTitle' 	=> $this->messageTitle,
    				'Message' 				=> $this->Message,		
    				'forumsInstalled'		=> $this->sSettings[0]['forumInstalled'],
                    'navigation'            => $this->build_navigation(),
                    'modsStickyDiscussions' => $this->sSettings[0]['modsStickyDiscussions'],
                    'modsCloseDiscussions'  => $this->sSettings[0]['modsCloseDiscussions'],
                    'canStickyDiscussions'  => $this->sSettings[0]['canStickyDiscussions'],
                    'canCloseDiscussions'   => $this->sSettings[0]['canCloseDiscussions'],
                    'category_options'      => $category_options,
                    'topic_id'              => $topic_id,
                    'userId'              => $userId,
                    'comment_id'            => $row['CommentID'],
    			);
                
                //Page construction variables
                $page ='edit_topic';
                $title = 'Edit Discussion';
                
                /**
				*  Add breadcrumb in view
				**/ 
				
				$breadcrumbItem=array('Help','Edit Topic');
				$breadcrumbURL=array('help','help/edit_topic/'.$userId.'/'.$topic_id);
				$breadcrumbString=set_breadcrumb("","", $breadcrumbItem ,$breadcrumbURL);
				$data['breadcrumbString']=$breadcrumbString;
                
                // Send all information to the constructor
               
                $data['page']= $this->forums_page_construct($page, $title, $data);
				$this->new_version->load('new_version','help_innerTemplate',$data);
            } 
        } else {
 			set_global_messages($this->lang->line('errorLoginRequired'), 'error');
            redirect($this->session->userdata('refered_from'));
        }
    }
    
    public function update_topic()
    {
		if ($this->ion_auth->logged_in())
		{
			
		  /**
           * Set form refered
           **/ 
          if(isset($_SERVER['HTTP_REFERER']))
			{
				$this->session->set_userdata('refered_from', $_SERVER['HTTP_REFERER']);
			}else
			{
				redirect(site_url('help'));
			}
			
			$this->form_validation->set_rules('title', 'Title', 'required|max_length[250]|htmlspecialchars');
			$this->form_validation->set_rules('body', 'Comment', 'required|htmlspecialchars');
			
			if ($this->form_validation->run() == FALSE) 
			{
				set_global_messages(validation_errors(), 'error');
				// Send the user back to the page they came from
				redirect($this->session->userdata('refered_from'));
			}
			else 
			{
			
				if($this->input->post('sticky') == '1')
				{
					$sticky = '1';  
				} else {
					$sticky = '0';
				}
			  
				if($this->input->post('closed') == '1')
				{
					$closed = '1';
				} else {
					$closed = '0';
				}
			  
				$discussion_data = array(
					'TopicName' => $this->input->post('title'),
					'Sticky'  	=> $sticky,
					'Closed'  	=> $closed,
				);
						
				$this->db->where('TopicID', $this->input->post('topic_id'));
			  
					if($this->db->update('forum_topics', $discussion_data))
					{
			  
						  $comment_data = array(
								'Title' => $this->input->post('title'),
								'Body' => $this->input->post('body'),
						  );
						  
						  $this->db->where('CommentID', $this->input->post('comment_id'));
						  
						  if($this->db->update('forum_comments', $comment_data))
						  {
	 
								set_global_messages($this->lang->line('messageDiscussionUpdated'), 'success');
							   redirect('help');
						  } else {
	 
								set_global_messages($this->lang->line('errorUpdateDiscussion'), 'error');
								redirect('help');
						  }
					} else {
							
							set_global_messages($this->lang->line('errorUpdateDiscussion'), 'error');
							redirect('help');
					}
            }    
                
          }	else {
				set_global_messages($this->lang->line('errorLoginRequired'), 'error');
				redirect($this->session->userdata('refered_from'));
		}        
    }
	
	public function create_random_password() 
	{

		$chars = "abcdefghijkmnopqrstuvwxyz023456789";

		srand((double)microtime()*1000000);

		$i = 0;
		$pass = '' ;
	
		while ($i <= 7) {
			$num = rand() % 33;
			$tmp = substr($chars, $num, 1);
			$pass = $pass . $tmp;
			$i++;
		}
		return $pass;
	}
	
	function settings()
	{
		if(!$this->ion_auth->logged_in())
		{
			/* User is not logged in do not allow to post */
			set_global_messages($this->lang->line('errorLoginRequired'), 'error');
			redirect('help/login', 'refresh');
		}
		else
		{	
			$data = array(
				'siteName' 				=> $this->siteName,			
				'siteTheme' 			=> $this->siteTheme,
				'welcomeMessage'		=> $this->sSettings[0]['siteWelcomeMessage'],				
				'user_profile' 			=> $this->help_users->user_profile($this->session->userdata('username')),
				'errorMessageTitle' 	=> $this->errorTitle,
				'Error' 				=> $this->Error,
				'successMessageTitle' 	=> $this->messageTitle,
				'Message' 				=> $this->Message,
				'forumsInstalled'		=> $this->sSettings[0]['forumInstalled'],
                'navigation'            => $this->build_navigation(),
			);
		
			//Page construction variables
			$page = 'settings';
			$title = $this->lang->line('titleSettings');
				
			//Send all information to the constructor
			$data['page']= $this->forums_page_construct($page, $title, $data);
			$this->new_version->load('new_version','help_innerTemplate',$data);

			log_message('debug', 'Settings function executed successfully! - /modules/help/controllers/help/settings');		
			$this->output->enable_profiler(FALSE); 				
		}
	}
	
	public function update_settings($username)
	{
		$this->help_users->update_settings($username);
	}
	
	public function change_password()
	{
		$this->form_validation->set_rules('old', 'Old password', 'required');	    
		$this->form_validation->set_rules('new', 'New Password', 'required|min_length['.$this->config->item('min_password_length', 'ion_auth').']|max_length['.$this->config->item('max_password_length', 'ion_auth').']|matches[new_confirm]');
	    $this->form_validation->set_rules('new_confirm', 'Confirm New Password', 'required');	    
		
		if (!$this->ion_auth->logged_in())
		{
			redirect('help/login', 'refresh');	    
		}	    
		$user = $this->ion_auth->get_user($this->session->userdata('user_id'));	    
		
		if ($this->form_validation->run() == false) 
		{ 
			//display the form	        
			//set the flash data error message if there is one	        
			$val_message = (validation_errors());	
			set_global_messages($this->ion_auth->errors(), 'success');

			
			$old_password  = array(
				'name'    			=> 'old',
				'id'      			=> 'old',
				'type'    			=> 'password',
				'class' 			=> 'textbox',	
			);	       

			$new_password  = array(
				'name'    			=> 'new',
				'id'      			=> 'new',
				'type'    			=> 'password',
				'class' 			=> 'textbox',	
			);        	
		
			$new_password_confirm = array(
				'name'    			=> 'new_confirm',
				'id'      			=> 'new_confirm', 
				'type'   			=> 'password', 
				'class' 			=> 'textbox',	
			);        	
		
			$user_id = array(
				'name'    			=> 'user_id',
				'id'      			=> 'user_id',
				'type'    			=> 'hidden', 
				'value'   			=> $user->id,
			);        	
			//render        	
			$data = array(
				'siteName' 				=> $this->siteName,			
				'siteTheme' 			=> $this->siteTheme,	
				'welcomeMessage'		=> $this->sSettings[0]['siteWelcomeMessage'],				
				'category' 				=> '',
				'errorMessageTitle' 	=> $this->errorTitle,
				'Error' 				=> $this->Error,
				'successMessageTitle' 	=> $this->messageTitle,
				'Message' 				=> $this->Message,
				'old_password' 			=> $old_password,
				'new_password' 			=> $new_password,
				'new_password_confirm' 	=> $new_password_confirm,
				'user_id' 				=> $user_id,
				'links' 				=> '',
				'forumsInstalled'		=> $this->sSettings[0]['forumInstalled'],
                'navigation'            => $this->build_navigation(),
			);
			
			//Page construction variables
			$page = 'changePassword';
			$title = $this->lang->line('titleChangePassword');
				
			//Send all information to the constructor
			$data['page']= $this->forums_page_construct($page, $title, $data);
			$this->new_version->load('new_version','help_innerTemplate',$data);

			log_message('debug', 'change_password function executed successfully! - /modules/help/controllers/help/change_password');		
			$this->output->enable_profiler(FALSE); 			
		}	    
		else 
		{	        
		
			$identity = $this->session->userdata($this->config->item('identity', 'ion_auth'));	        
			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));
			if ($change) 
			{ 
				//if the password was successfully changed    			
				set_global_messages($this->lang->line('messagePasswordChanged'), 'success');
				redirect('help', 'refresh');				
			}    		
			else 
			{    			
				set_global_messages($this->ion_auth->errors(), 'error');
				redirect('help/changePassword', 'refresh');    		
			}	    
		}		
	}
	
  	public function register()
	{		
		// Check and see if our site is in maintenance mode.
		if($this->sSettings[0]['allowRegistration'] == '1')
		{
			// Validate the form
			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
		
			if($this->form_validation->run() == true)
			{
				$username = $this->input->post('username');
				$email = $this->input->post('email');
				$password = $this->create_random_password();
			}
		
			if($this->form_validation->run() == true && $this->ion_auth->register($username, $password, $email))
			{
				// Redirect them back to the home page with a message
				set_global_messages($this->lang->line('messageRegistrationSuccess'), 'success');
				redirect('help', 'refresh');
			}
			else
			{
				set_global_messages(validation_errors(), 'error');
				redirect('help', 'refresh');
			}
		}
		else
		{
			// registration has being turned off, redirect
				set_global_messages($this->lang->line('messageFeatureOff'), 'error');
			// Send the user back to the page they came from
			redirect('help');		
		}
	}
	
	public function activate($id, $code=false)
	{
		$activation = $this->ion_auth->activate($id, $code);

        if($activation) 
        {
        	$username = $this->help_users->get_username($id);
        	
        	// Insert information into the activity database.
			$data = array(
				'username' => $username,
				'date' => time(),
				'activity' => 'registered',
			);
			
			$this->db->insert('activity', $data); // Insert activity into activity's table 	
				
			//redirect
			set_global_messages($this->lang->line('messageActivationSuccess'), 'success');
			redirect('help', 'refresh');
        }
        else 
        {
			//redirect them to the forgot password page
			set_global_messages($this->ion_auth->errors(), 'success');
			redirect("help/forgot_password", 'refresh');
        }
    }
	
	public function profile($username)
	{
		$data = array(
			'siteName' 						=> $this->siteName,			
			'siteTheme' 					=> $this->siteTheme,		
			'welcomeMessage'				=> $this->sSettings[0]['siteWelcomeMessage'],			
			'user_profile' 					=> $this->help_users->user_profile($username),
			'errorMessageTitle' 			=> $this->errorTitle,
			'Error' 						=> $this->Error,
			'successMessageTitle' 			=> $this->messageTitle,
			'Message' 						=> $this->Message,
			'username' 						=> $username,
			'forumsInstalled'		        => $this->sSettings[0]['forumInstalled'],
            'navigation'                    => $this->build_navigation(),
            'userid'                        => $this->help_users->get_userid($username),
            'extra'                         => '',
		);
			
		//Page construction variables
		$page = 'profile';
		$title = $this->lang->line('titleProfile');
			
		//Send all information to the constructor
		$data['page']= $this->forums_page_construct($page, $title, $data);
		$this->new_version->load('new_version','help_innerTemplate',$data);
			
		log_message('debug', 'Profile function executed successfully! - /modules/help/controllers/help/profile');		
		$this->output->enable_profiler(FALSE); 	
	}
	
	public function report_post()
	{
		/**
		* Store the page the user came from.
		**/	 
		if(isset($_SERVER['HTTP_REFERER']))
		{
			$this->session->set_userdata('refered_from', $_SERVER['HTTP_REFERER']);
		}else
		{
			redirect(site_url('help'));
		}
		
		// Check and see if the user is logged in
		if (!$this->ion_auth->logged_in())
		{
			// User is not logged in, redirect
			set_global_messages($this->lang->line('errorLoginRequired'), 'error');
			redirect($this->session->userdata('refered_from'));
		}
		else
		{
			// User passed the test, report the post 
			$data = array(
				'reported' => '1',
			);
			$this->db->where('CommentID', $this->uri->segment(3));
			$this->db->update('comments', $data);
			
			if($this->db->affected_rows() >= '1')
			{		
				// Lets flag the topics for the admins attention.
				$data = array(
					'Flagged' => '1',
				);
				$this->db->where('TopicID', $this->uri->segment(4));
				$this->db->update('topics', $data);
				
				
				set_global_messages($this->lang->line('messagePostReported'), 'success');
				redirect($this->session->userdata('refered_from'));
			}
			else
			{
				set_global_messages($this->lang->line('errorPostReportFailed'), 'error');
				redirect($this->session->userdata('refered_from'));
			}
		}
	}
	
	public function remove_report()
	{
		/**
		* Store the page the user came from.
		**/	 
		if(isset($_SERVER['HTTP_REFERER']))
		{
			$this->session->set_userdata('refered_from', $_SERVER['HTTP_REFERER']);
		}else
		{
			redirect(site_url('help'));
		}
		
		// Check and see if the user is logged in
		if (!$this->ion_auth->logged_in())
		{
			// User is not logged in, redirect

			set_global_messages($this->lang->line('errorLoginRequired'), 'error');
			redirect($this->session->userdata('refered_from'));
		}
		else
		{
			// User passed the test, report the post 
			$data = array(
				'reported' => '0',
			);
			$this->db->where('CommentID', $this->uri->segment(3));
			$this->db->update('comments', $data);
			
			if($this->db->affected_rows() >= '1')
			{		
				// Lets flag the topics for the admins attention.
				$data = array(
					'Flagged' => '0',
				);
				$this->db->where('TopicID', $this->uri->segment(4));
				$this->db->update('topics', $data);
				
				set_global_messages($this->lang->line('messagePostRemoveReport'), 'success');
				redirect($this->session->userdata('refered_from'));
			}
			else
			{
				set_global_messages($this->lang->line('errorPostRemoveReport'), 'error');
				redirect($this->session->userdata('refered_from'));
			}
		}	
	}
	
	public function delete_post($postID)
	{
		/**
		* Store the page the user came from.
		**/	 
		if(isset($_SERVER['HTTP_REFERER']))
		{
			$this->session->set_userdata('refered_from', $_SERVER['HTTP_REFERER']);
		}else
		{
			redirect(site_url('help'));
		}
		
		// Check and see if the user is logged in
		if(!$this->ion_auth->logged_in())
		{
			// User is not logged in, redirect
			
			set_global_messages($this->lang->line('errorLoginRequired'), 'error');
			redirect($this->session->userdata('refered_from'));
		}
		else
		{
            //The user is a admin and logged in, remove the post 
			$this->db->where('CommentID', $postID);
			$this->db->delete('forum_comments');
				
			if($this->db->affected_rows() >= 1)
			{
				
				set_global_messages($this->lang->line('messagePostDeleted'), 'success');
				redirect($this->session->userdata('refered_from'));
			}
			else
			{
				set_global_messages($this->lang->line('errorPostDeleteFailed'), 'error');
				redirect($this->session->userdata('refered_from'));
			}
		}
	}
	
	public function edit_post($userId,$postID)
	{
		/**
		* Store the page the user came from.
		**/	 
		if(isset($_SERVER['HTTP_REFERER']))
		{
			$this->session->set_userdata('refered_from', $_SERVER['HTTP_REFERER']);
		}else
		{
			redirect(site_url('help'));
		}
		
		if ($this->ion_auth->logged_in())
		{
			$post = $this->help_posts->get_post($postID);
				
			foreach($post as $row)
			{
				$body = array(
					'name' => 'postBody',
					'id' => 'postBody',
					'type' => 'text',
					'value' => html_entity_decode($row['Body']),
					'class' => 'height171 p15 width100_per bdrcece  color_444 fs13 required',
				);
					
				if($row['reported'] == '1')
				{
					$checked = TRUE;
				}
				else
				{
					$checked = FALSE;
				}
					
				$reported = array(
					'name' => 'reported',
					'id' => 'reported',
					'value' => '1',
					'class' => 'checkbox',
					'checked' => $checked,
				);
					
				$updatePost = array(
					'name'		=> 'updatePost',
					'id'		=> 'updatePost',
					'class'		=> 'btn_alt',
					'type'		=> 'submit',
					'value'	=> $this->lang->line('updatePostButton'),
				);
					
				$commentID = array(
					'name' => 'commentID',
					'id' => 'commentID',
					'type' => 'hidden',
					'value' => $row['CommentID'],
				);
			}

				$data = array(
					'siteName' 					=> $this->siteName,			
					'siteTheme' 				=> $this->siteTheme,		
					'welcomeMessage'			=> $this->sSettings[0]['siteWelcomeMessage'],			
					'errorMessageTitle' 		=> $this->errorTitle,
					'Error' 					=> $this->Error,
					'successMessageTitle' 		=> $this->messageTitle,
					'Message' 					=> $this->Message,
					'body' 						=> $body,
					'reported'					=> $reported,
					'commentID'					=> $row['CommentID'],
					'updatePost'				=> $updatePost,
					'forumsInstalled'		    => $this->sSettings[0]['forumInstalled'],
                    'navigation'                => $this->build_navigation(),
				);
			
				//Page construction variables
				$page = 'editPost';
				$title = $this->lang->line('titleEditPost');
			
				/**
				*  Add breadcrumb in view
				**/ 
				
				$breadcrumbItem=array('Help','Edit Post');
				$breadcrumbURL=array('help','help/edit_post/'.$userId.'/'.$postID);
				$breadcrumbString=set_breadcrumb("","", $breadcrumbItem ,$breadcrumbURL);
				$data['breadcrumbString']=$breadcrumbString;
			
			
				//Send all information to the constructor
				$data['page']= $this->forums_page_construct($page, $title, $data);
				$this->new_version->load('new_version','help_innerTemplate',$data);	
		}
		else
		{
			set_global_messages($this->lang->line('errorLoginRequired'), 'error');
			redirect($this->session->userdata('refered_from'));
		}
	}
	
	public function update_post()
	{
		if ($this->ion_auth->logged_in())
		{
			$CommentID = $this->uri->segment(4);
				
			if ($this->ion_auth->is_admin())
			{
				if ($this->input->post('reported') == '1')
				{
					$reported = '1';
				}
				else
				{
					$reported = '0';
				}
			
				$data = array(
					'Body' => $this->input->post('postBody'),
					'reported' => $reported,
				);

				$this->db->where('CommentID', $CommentID);
				$this->db->update('forum_comments', $data);
			
				if ($this->db->affected_rows() >= '1')
				{
					
					set_global_messages($this->lang->line('messageUpdatePost'), 'success');
					redirect($this->session->userdata('refered_from'));
				}
				else
				{
					set_global_messages($this->lang->line('errorUpdatePost'), 'error');
					redirect('help');
				}
			}
			else
			{
				$data = array(
					'Body' => $this->input->post('postBody'),
				);
				
				$this->db->where('CommentID', $CommentID);
				$this->db->update('forum_comments', $data);
			
				if($this->db->affected_rows() >= '1')
				{
					set_global_messages($this->lang->line('messageUpdatePost'), 'success');
					redirect($this->session->userdata('refered_from'));
				}
				else
				{
					set_global_messages($this->lang->line('errorUpdatePost'), 'error');
					redirect('help');
				}
			}
				
		}
		else
		{
			set_global_messages($this->lang->line('errorLoginRequired'), 'error');
			redirect($this->session->userdata('refered_from'));
		}			
	}
	
	public function forgot_password()
	{
		$this->form_validation->set_rules('email', 'Email Address', 'required');
		if ($this->form_validation->run() == false)
		{
			//setup the input
			$email = array(
				'name' 		=> 'email',
				'id' 		=> 'email',
				'class' 	=> 'textbox',
			);
			//set any errors and display the form

			$data = array(
				'siteName' 						=> $this->siteName,			
				'siteTheme' 					=> $this->siteTheme,		
				'welcomeMessage'				=> $this->sSettings[0]['siteWelcomeMessage'],			
				'errorMessageTitle' 			=> $this->errorTitle,
				'Error' 						=> $this->Error,
				'successMessageTitle' 			=> $this->messageTitle,
				'Message' 						=> $this->Message,
				'email' 						=> $email,
				'forumsInstalled'		=> $this->sSettings[0]['forumInstalled'],
                'navigation'            => $this->build_navigation(),
			);
			
			//Page construction variables
			$page = 'forgot_password';
			$title = $this->lang->line('titleForgotPassword');
			
			//Send all information to the constructor
			$data['page']= $this->forums_page_construct($page, $title, $data);
			$this->new_version->load('new_version','help_innerTemplate',$data);
		}
		else
		{
			//run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($this->input->post('email'));

			if ($forgotten)
			{ //if there were no errors
				
				set_global_messages($this->lang->line('messageResetPassword'), 'success');
				redirect('help');
			}
			else
			{
				set_global_messages($this->lang->line('errorResetPassword'), 'error');
				redirect('help');
			}
		}
	}

	public function reset_password($code)
	{
		$reset = $this->ion_auth->forgotten_password_complete($code);

		if ($reset)
		{ //if the reset worked then send them to the login page
			set_global_messages($this->lang->line('messageResetPasswordComplete'), 'success');
			redirect('help');
		}
		else
		{ //if the reset didnt work then send them back to the forgot password page
			set_global_messages($this->lang->line('messageResetPasswordFailed'), 'success');
			redirect("help/forgot_password", 'refresh');
		}
	}
	
	public function search($limit=NULL, $offset=NULL)
	{
		//What action ?
		$action = $this->uri->segment(4);
		
		
		

		
		switch($action) {
		
			case 'display':
			

				$this->input->load_query($this->uri->segment(5));
				
				if($this->input->get('search')=='Search Tips...')
				{
			
					$query_array = array('search' => '');
			
				}else
				{
					$query_array = array(
					'search' => $this->input->get('search'));
				}
				

				
				$results = $this->core_m->search_help($query_array, $this->sSettings[0]['topicsPerPage'], $this->uri->segment(6));
				
				/**
				* Construct the data array for the page
				**/
				$data = array(
					'siteName' 				=> $this->siteName,			
					'siteTheme' 			=> $this->siteTheme,
					'welcomeMessage'		=> $this->sSettings[0]['siteWelcomeMessage'],
					'topics' 				=> $results,
					'categories' 			=> $this->categories_m->get_categories('help'),
					'category' 				=> $this->lang->line('searchResults'),
					'errorMessageTitle' 	=> $this->errorTitle,
					'Error' 				=> $this->Error,
					'successMessageTitle' 	=> $this->messageTitle,
					'Message' 				=> $this->Message,
					'links' 				=> '',
					'forumsInstalled'		=> $this->sSettings[0]['forumInstalled'],
                    'navigation'            => $this->build_navigation(),
                    'deleteOwnDiscussions'  => $this->sSettings[0]['deleteOwnDiscussions'],
            		'editOwnDiscussions'    => $this->sSettings[0]['editOwnDiscussions'],
            		'modsEditDiscussions'   => $this->sSettings[0]['modsEditDiscussions'],
            		'modsDeleteDiscussions' => $this->sSettings[0]['modsDeleteDiscussions'],
            		'userId'				=> isLoginUser(),
            		 'getCatSubCat'          => $this->categories_m->getCurrentCatSubCat('-1'),
				);
				

				
				/**
				* Send page to the page constructor
				**/
				$page = 'help';
				$title = $this->lang->line('titleSearchResults');
				
				/**
				*  Add breadcrumb in view
				**/ 
				$query_id = $this->uri->segment('5');
				
				$breadcrumbItem=array('Help','Search','Display');
				$breadcrumbURL=array('help','help/search/display/'.$query_id,'help/search/display/'.$query_id);
				$breadcrumbString=set_breadcrumb("","", $breadcrumbItem ,$breadcrumbURL);
				$data['breadcrumbString']=$breadcrumbString;
				
				
				$data['page']= $this->forums_page_construct($page, $title, $data);
				$this->new_version->load('new_version','help_innerTemplate',$data);
			
			break;
			
			default:
			
				$query_array = array(
					'search' => $this->input->post('search'),
				);
				
			
		
				$query_id = $this->input->save_query($query_array);
	
				redirect('help/search/display/'.$query_id.'');
				
			break;
		}
	}
    
    public function get_all_plugins()
    {
        $data = array();
        $this->plugins_dir = FCPATH . "plugins/";   
        $plugins = directory_map($this->plugins_dir, 1);
        
        if($plugins !== false)
        {
            foreach($plugins as $key => $name)
            {
                $name = strtolower(trim($name));
                $data[] = $name;
            }
            return $data;
        }
    }    
    
    public function update_order($order)
    {
		/**
		* Store the page the user came from.
		**/	 
		if(isset($_SERVER['HTTP_REFERER']))
		{
			$this->session->set_userdata('refered_from', $_SERVER['HTTP_REFERER']);
		}else
		{
			redirect(site_url('help'));
		}
        
        if($order == 'asc')
        {
            $this->session->set_userdata('topicsOrder', 'asc');
        }
        elseif($order == 'desc')
        {
            $this->session->set_userdata('topicsOrder', 'desc');
        }
        
		redirect($this->session->userdata('refered_from'));
    }
    
    public function request_category()
    {
		
		
		$parent_cat = $this->input->get('val1');
		/**
		* Store the page the user came from.
		**/	 
		if(isset($_SERVER['HTTP_REFERER']))
		{
			$this->session->set_userdata('refered_from', $_SERVER['HTTP_REFERER']);
		}else
		{
			redirect(site_url('help'));
		}
		
		
		
		if ($this->ion_auth->logged_in())
		{
				
			
				$body = array(
					'name' => 'postBody',
					'id' => 'postBody',
					'type' => 'text',
					'rows' => '4',
					'class' => 'search_box mt0  width338  bdr_bbb fl required',
					'onkeyup' => "checkWordLen(this,50,'wordcountid')",
					'wordlength' => '5,50',
					'desclimit' => 'wordcountid',
                     'placeholder' => 'Why do you want this Subcategory?*',
				);
					
				
					
				$title = array(
					'name' => 'cat_name',
					'id' => 'cat_name',
					'value' => '',
					'type' => 'text',
					'class' => 'required  mb0  search_box width338  bdr_bbb fl',
                    'placeholder' => 'Subcategory*',
				);
				
					
				$commentID = array(
					'name' => 'commentID',
					'id' => 'commentID',
					'type' => 'hidden',
					'value'=>'1'
				);
			
				
				$userFullName = LoginUserDetails('firstName').' '.LoginUserDetails('lastName');
				 
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
					'parent_cat'					=> $parent_cat,
					'forumsInstalled'		    => $this->sSettings[0]['forumInstalled'],
                    'navigation'                => $this->build_navigation(),
                    'userFullName'                => $userFullName,
				);
			
				//Page construction variables
				$page = 'request_category';
				$title = $this->lang->line('titleEditPost');
			
				//Send all information to the constructor
				$data['page']= $this->forums_page_construct($page, $title, $data);
			//	$this->new_version->load('new_version','help_innerTemplate',$data);	
				$this->load->view('request_category', $data);
		}
		else
		{
			set_global_messages($this->lang->line('errorLoginRequired'), 'error');
			redirect($this->session->userdata('refered_from'));
		}
	}
	
	
	public function request_sub_cat()
	{
		$user_id 		= $this->session->userdata('user_id');
		if($user_id)
		{
				$request_return  = $this->help_posts->request_sub_cat($user_id);
				
				$parent_cat 	= $this->input->post('parent_cat');
				$parent_cate_name = $this->categories_m->get_current_cat($parent_cat);
				$request_cate_name	= $this->input->post('cat_name');
				
				//	$this->session->set_flashdata('message', $message);
				//	$msg = $this->lang->language['productSavedSuccessfully'];
				//	set_global_messages($msg, 'success');
				
				/************send sub category email to user*************/
				$getUserShowcase	= showCaseUserDetails($user_id);
				$username =  $getUserShowcase['userFullName'];
				$this->load->library('email');
				$this->email->from($this->config->item('webmaster_email', ''), $this->config->item('website_name', ''));
				$this->email->reply_to($this->config->item('webmaster_email', ''), $this->config->item('website_name', ''));
				$this->email->to($this->config->item('subcategory_email', ''));
				//$this->email->to('lokendrameena@cdnsol.com');	
				$this->email->subject(sprintf('Tips subcategory request', $this->config->item('website_name', '')));
				$where=array('purpose'=>'subcategoryrequest','active'=>1);
				$reportTemplateRes=getDataFromTabel('EmailTemplates','templates',  $where, '','', '', 1 );
				
				$reportTemplate=$reportTemplateRes[0]->templates;
				$searchArray = array("{request_type}", "{user_name}", "{parent_category_name}" , "{request_category_name}" , "{site_name}");
				$replaceArray = array('Tips', $username , $parent_cate_name, $request_cate_name, $this->config->item('website_name', ''));
				$abusiveReportTemplate=str_replace($searchArray, $replaceArray, $reportTemplate);
				
				$this->email->message($abusiveReportTemplate);
				$this->email->send();
				
				
				$message = "Request sended";
				set_global_messages($message, 'success');
				redirect('help');	
		}
	}
    
}

/* End of file help.php */
/* Location: ./application/modules/core/controllers/help.php */
