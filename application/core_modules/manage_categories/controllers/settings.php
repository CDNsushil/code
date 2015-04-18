<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller for CodeIgniter tip files editor.
 *
 * Idea:
 * Keys stored in database only as an information and simple way to communicate between files.
 * Edit translation for existing keys, Add new keys, Same keys for every tip.
 * @version		2.1
 */

class Settings extends MY_Controller{
	function __construct(){
		parent::__construct();			
		$this->load->helper(array('url','file','language','form')); //load this helpers if youre not doing it in autoload
		$this->load->model(array('model_categories','admin_model'));
		$this->load->library(array('session','language/lang_library')); //load libraries if youre not doing it in autoload
		$this->load->language(array('admin_template')); //you can delete it if you have translation for you language
		$this->load->library('admin_template');
		$this->config->load('language_editor');
		$this->head->add_css($this->config->item('default_css').'template.css');
	}
	
	function index($type = "forums"){
		
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}else{
			
			$this->category_list($type);//+
			
		}
	}
	
	// ------------------------------------- Forum Category Function ------------------------------- //
	
	/**
	 * Get Category list.
	 *
	 * @return void
	 */
	function category_list($type,$limit='',$perPage='') {
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}
		$limit= (!empty($limit))? $limit : $this->config->item('limitPageRecordAdmin');
		$perPage=(!empty($perPage)) ? $perPage : $this->config->item('perPageRecordAdmin');
		
		// check Where Condition for helper and Forum
	
			$where=array('parentID'=>'0','type'=>$type,'thrash'=>'0');
		$countTotal = $this->model_common->countResult('forum_category',$where);
		
		$pages = new Pagination_ajax;
		$pages->items_total = $countTotal; // this is the COUNT(*) query that gets the total record count from the table you are querying
		$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$perPage;
		$pages->paginate();
		$data['items_total'] = $pages->items_total;
		$data['items_per_page'] = $pages->items_per_page;
		$data['pagination_links'] = $pages->display_pages();	
		$data['countTotal'] = $countTotal;
		$data['type'] = $type;
		
		$categoriesList = $this->model_categories->get_categories_listing($type,$pages->limit,$pages->offst);//+
		
		if(isset($categoriesList) && !empty($categoriesList)){
			$data['categoriesList'] = $categoriesList;
		}else {
			$data['categoriesList'] = '';
		}
		
		if(isset($_POST['ajaxRequest']) && $_POST['ajaxRequest']==1){
			$this->load->view('manage_categories/category_view_listing', $data);
		}else{
			$this->toad_admin_template->load('toad_admin_template','manage_categories/categories_listing', $data);
		}
	}
	
	/**
	* Function to Manage Category.
	*/
	public function category_manage($type,$catId=0)
    { 	
		
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}else{
			/* Get Genre data*/
			
			$data['categoryData'] = $this->model_categories->get_categories_details($type,$catId);	
			$data['type'] = $type;
			$this->toad_admin_template->load('toad_admin_template','manage_categories/category_manage',$data);
		}
	}
	
	/**
	* Insert or Update Category Data.
	*/
    public function update_category($type)
    {
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}else{
			/*Get Post values*/
			$CategoryID 			= $this->input->post('CategoryID');
			
			$data['Name'] 			= $this->input->post('Name');
			$data['type'] 			= $this->input->post('type');
			$data['parentID'] 		= '0';
			$data['Active'] 		= '1';
			
			/*Insert or Update State*/
			if(isset($CategoryID) && !empty($CategoryID)){
				$updateGenre = $this->model_categories->update_category($data,$CategoryID);
				$msg = $this->lang->line('no_exist_newsletter');
				$msg = "Category Update Successfully";
			}else{
				/* -----------------Count _max_ order--------------------------------  */  
				$count = $this->model_categories->count_max_order($type,'forum_category','order');	
				$data['order']=$count+1;
				$addGenre = $this->model_categories->add_category($data);
				$msg = "Category Add Successfully";
			}
			
				
			set_global_messages($msg, $type='error', $is_multiple=true);
		}
	}
	
	/**
	* Remove selected Categories.
	*/
	function delete_category($type,$catId){
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}	
		if($catId > 0 )
		{
			$data['thrash'] = '1';
			$data['Active'] = '0';
			$updateGenre = $this->model_categories->update_category($data,$catId);
			redirect(site_url(SITE_AREA_SETTINGS.'manage_categories/index/'.$type));
		}
		
	}
	
	/* ------------------- Subcategory Section ------------------------------*/
	/*
	 * 
	 * 
	 *
	*/
	function sub_index($type = "forums"){
		
		
		
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}else{
			
			$this->subcategory_list($type);//+
			
		}
	}
	
  function subcategory_list($type,$limit='',$perPage='') {
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}
		$limit= (!empty($limit))? $limit : $this->config->item('limitPageRecordAdmin');
		$perPage=(!empty($perPage)) ? $perPage : $this->config->item('perPageRecordAdmin');
		
		// check Where Condition for helper and Forum
	
		$where=array('parentID !='=>'0','type'=>$type,'thrash'=>'0');
		$countTotal = $this->model_common->countResult('forum_category',$where);
		
		$pages = new Pagination_ajax;
		$pages->items_total = $countTotal; // this is the COUNT(*) query that gets the total record count from the table you are querying
		$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$perPage;
		$pages->paginate();
		$data['items_total'] = $pages->items_total;
		$data['items_per_page'] = $pages->items_per_page;
		$data['pagination_links'] = $pages->display_pages();	
		$data['countTotal'] = $countTotal;
		$data['type'] = $type;
		
		$categoriesList = $this->model_categories->get_subcategories_listing($type,$pages->limit,$pages->offst);//+
		
		if(isset($categoriesList) && !empty($categoriesList)){
			$data['categoriesList'] = $categoriesList;
		}else {
			$data['categoriesList'] = '';
		}
		
		if(isset($_POST['ajaxRequest']) && $_POST['ajaxRequest']==1){
			$this->load->view('manage_categories/subcategory_view_listing', $data);
		}else{
			$this->toad_admin_template->load('toad_admin_template','manage_categories/subcategories_listing', $data);
		}
	}
	
	
	
	/**
	* Function to Manage SubCategory.
	*/
	public function subcategory_manage($type,$catId=0)
    { 	
		
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}else{
			/* Get Genre data*/
			
			$data['categoryData'] = $this->model_categories->get_subcategories_details($type,$catId);	
			$data['type'] = $type;
			$this->toad_admin_template->load('toad_admin_template','manage_categories/subcategory_manage',$data);
		}
	}
	
	
	/**
	* Insert or Update Category Data.
	*/
    public function update_subcategory($type)
    {
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}else{
			/*Get Post values*/
			$CategoryID 			= $this->input->post('CategoryID');
			$data['Name'] 			= $this->input->post('Name');
			$data['type'] 			= $this->input->post('type');
			$data['parentID'] 		= $this->input->post('parentID');;
			$data['Description'] 	= $this->input->post('sub_description');;
			$data['Active'] 		= '1';
			
			/*Insert or Update State*/
			if(isset($CategoryID) && !empty($CategoryID)){
				$updateGenre = $this->model_categories->update_category($data,$CategoryID);
				$msg = $this->lang->line('no_exist_newsletter');
				$msg = "Subcategory Edited Successfully";
			}else{
				/* -----------------Count _max_ order--------------------------------  */  
				$count = $this->model_categories->sub_count_max_order($type,'forum_category','order');	
				$data['order']=$count+1;
				$addGenre = $this->model_categories->add_category($data);
				$msg = "Subcategory Add Successfully";
			}
			
				
			set_global_messages($msg, $type='error', $is_multiple=true);
		}
	}
	
	/**
	* Remove selected SubCategories.
	*/
	function delete_subcategory($type,$catId){
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}	
		if($catId > 0 )
		{
			$data['thrash'] = '1';
			$data['Active'] = '0';
			$updateGenre = $this->model_categories->update_category($data,$catId);
			redirect(site_url(SITE_AREA_SETTINGS.'manage_categories/sub_index/'.$type));
		}
		
	}
	
	/* Update Status  */
	
	function update_status_categroy($catId,$status)
	{
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}	
		if($catId > 0 )
		{
			$data['Active'] = $status;
			$updateGenre = $this->model_categories->update_category($data,$catId);
		}	
	}
	
	/* Update Order  */
	
	
	function update_order_categroy($catId,$order)
	{
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}	
		if($catId > 0 )
		{
			
			$data['order'] = $order;
			$updateGenre = $this->model_categories->update_category($data,$catId);
		}	
	}
	
    
    /**
	* Arrange tip listing order.
	*/
	function update_category_order()
	{
		
		$updateRecordsArray = $this->input->post('recordsArray');
		$listingCounter = 1;
		foreach ($updateRecordsArray as $recordIDValue) {
			$tip_data = array(
                'order' 		=> $listingCounter,
                );
              
            $this->db->where('CategoryID', $recordIDValue);
            $this->db->update('forum_category', $tip_data);
            $listingCounter = $listingCounter + 1;	
		}
		
	}

	
	
}
