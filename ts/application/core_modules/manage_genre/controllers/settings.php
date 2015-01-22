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
		$this->load->model(array('model_genre','admin_model'));
		$this->load->library(array('session','language/lang_library')); //load libraries if youre not doing it in autoload
		$this->load->language(array('admin_template')); //you can delete it if you have translation for you language
		$this->load->library('admin_template');
		$this->config->load('language_editor');
		$this->head->add_css($this->config->item('default_css').'template.css');
	}
	
	function index(){
		
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}else{
			$this->genre_list();
		}
	}
	
	/**
	 * Get Users list.
	 *
	 * @return void
	 */
	function genre_list($limit='',$perPage='') {
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}
		$limit= (!empty($limit))? $limit : $this->config->item('limitPageRecordAdmin');
		$perPage=(!empty($perPage)) ? $perPage : $this->config->item('perPageRecordAdmin');
		$countTotal = $this->model_common->countResult('Genre');
		$pages = new Pagination_ajax;
		$pages->items_total = $countTotal; // this is the COUNT(*) query that gets the total record count from the table you are querying
		$pages->items_per_page=(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$perPage;
		$pages->paginate();
		$data['items_total'] = $pages->items_total;
		$data['items_per_page'] = $pages->items_per_page;
		$data['pagination_links'] = $pages->display_pages();	
		$data['countTotal'] = $countTotal;
		
		$genreList = $this->model_genre->get_genre_listing($pages->limit,$pages->offst);
		
		if(isset($genreList) && !empty($genreList)){
			$data['genreList'] = $genreList;
		}else {
			$data['genreList'] = '';
		}
		
		if(isset($_POST['ajaxRequest']) && $_POST['ajaxRequest']==1){
			$this->load->view('manage_genre/genre_view_listing', $data);
		}else{
			$this->toad_admin_template->load('toad_admin_template','manage_genre/genre_listing', $data);
		}
	}
	
	/**
	* Function to Manage Genre.
	*/
	public function genre_manage($genreId=0)
    { 	
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}else{
			/* Get Genre data*/
			$data['genreData'] = $this->model_genre->get_genre_details($genreId);	
			$this->toad_admin_template->load('toad_admin_template','manage_genre/genre_manage',$data);
		}
	}
	
	/**
	* Insert or Update Genre Data.
	*/
    public function update_genre()
    {
		if(!$this->lang_library->login_check()){
			redirect('toad_admin/toad_admin');
		}else{
			/*Get Post values*/
			$genreId 				= $this->input->post('GenreId');
			$data['Genre'] 			= $this->input->post('Genre');
			$data['industryId'] 	= $this->input->post('industryId');
			$data['lang']			= $this->input->post('lang');
			$data['typeId'] 		= $this->input->post('projType');
			$data['entityId'] 		= $this->input->post('projectEntityId');
			
			/*Insert or Update State*/
			if(isset($genreId) && !empty($genreId)){
				$updateGenre = $this->model_genre->update_genre($data,$genreId);
			}else{
				$addGenre = $this->model_genre->add_genre($data);
			}
		}
	}
	
	/**
	 * getTypeList function to get project List 
	 */
	public function getTypeList() {
		$lang='en';
		$indusrtyId=$this->input->post('val1');
		$catId=$this->input->post('val2');
		
		$projectType =getAdminTypeList($indusrtyId, $lang, 'selectProjectType',$catId);
		$html=form_dropdown('projType', $projectType, '','id="projType" class="required selectBox"');
		$html.=" <script>selectBox();</script>";
		echo $html;
	}
	
	/**
	 * Function to manage Project category and Type list
	 */
	public function getProjectStyle() {
		$lang = 'en';
		$indusrtyId=$this->input->post('val1');
		$catId=$this->input->post('val2');
		$typeId=$this->input->post('val3');
		
		/* Set entity Id based on industry id*/
		switch($indusrtyId){
			case 1:
			$entityId = 12;
			break;
			case 2:
			$entityId = 25;
			break;
			case 3:
			$entityId = 84;
			break;
			case 4:
			$entityId = 47;
			break;
			case 5:
			$entityId = 15;
			break;
			default:
			$entityId = false;
		}

		if(isset($entityId)){
			$projCategoryList=getProjCategoryList('', $lang, 'selectCategory',$entityId);
			next($projCategoryList); 
			$projCategory=key($projCategoryList);
			$projCategory=(isset($catId) && $catId > 0)?$catId:$projCategory;
			$projectTypeList = getTypeList('', $lang,'selectProjectType',$projCategory);
			next($projectTypeList); 
			$projType=key($projectTypeList);

			$defaultOption = $this->lang->line('selectGenreType');
			$typeList = form_dropdown('projType', $projectTypeList,set_value('projType' , ( ( isset($typeId) && !empty($typeId) ) ? "$typeId" : 0 )),'id="projType" class="required error"');
			$typeList.="<script>selectBox();</script>";
			
			$projectCategory = '<div id="oneLineDescription" class="label_wrapper_topic">
						<label class="select_field_topic"> '.$this->lang->line('genreProjectStyle').' </label>
					</div>';
			/*Get category check box list*/
			$projectCategory.=  projAdminCategoryInRadio($indusrtyId,'en', $defaultOption,$entityId,$projCategory);
			$projectCategory.="<script>runTimeCheckBox();</script>";
			echo $projectCategory;
			
			echo '<div id="oneLineDescription" class="label_wrapper_topic">
					<label class="select_field_topic"> '.$this->lang->line('genreType').' </label>
				</div>';
				
			echo '<li>
					<div id="projectTypeList" class="pr">';
					echo $typeList;
					echo '</div>
				</li>
				<input type="hidden" id="projectEntityId" name="projectEntityId" value="'.$entityId.'">
				<div class="clear"></div>';
		}
		else{
			return false;
		}
	}
	
	/* Function to update Genre status */
	function updateStatus()
	{
		$GenreId = $this->input->post('GenreId');
		$GenreStatus = $this->input->post('status');
		if($GenreStatus == 0){
			$data['status'] = 'f';
		}else{
			$data['status'] = 't';
		}
		
		if(isset($GenreId)){
			$updateActiveStatus = $this->model_genre->update_genre($data,$GenreId);
		}else{
			return false;
		}
	}
}
