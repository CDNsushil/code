 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	if ( ! function_exists('formRowInputText')){
		function formRowInputText($param=array()){
			if(is_array($param) && count($param) >0){
				return '<div  class="formRow">
							<div class="formRowLabel">'.$param['label'].'<div class="clear"></div></div>
							<div class="formRowInput">
									<div>'.$param['inputItem'].'</div>
									<div class="formError">
										'.$param['error'].'								
									</div>
							</div>
							<div class="clear"></div>
						</div><div class="clear"></div>';
			}else{
				return '<div  class="formRow">
							<div class="formRowLabel"><div class="clear"></div></div>
							<div class="formRowInput">
									<div class="formError">								
									</div>
							</div>
							<div class="clear"></div>
						</div>';
			}
		}
	}
	if (!function_exists('dateFormate')){           
	/* function for change date format 
	 * Wriiten By Sushil Mishra 
	*/
		function dateFormate($fmt = 'DATE_d/m/Y', $time = '')
		{
			$formats = array('DATE_d/m/Y'		=>	'%d/%m/%Y');

			if ( ! isset($formats[$fmt]))
			{
				return FALSE;
			}

			return mdate($formats[$fmt], $time);
		}
	}
	
	if ( ! function_exists('currntDateTime')){           
	/* function for change date format 
	 * Wriiten By Sushil Mishra 
	*/
		function currntDateTime($fmt = 'Y-m-d h:i:s')
		{
			return date($fmt);
		}
	}
	if ( ! function_exists('lang')){           
		/* function for get browser language 
		 * Wriiten By Sushil Mishra 
		*/
		function lang(){
			$CI =& get_instance();
			return $CI->uri->segment(1);
		}
	}
	if ( ! function_exists('redirectTohome')){           
		/* function for get redirectTohome 
		 * Wriiten By Gurutva Singh
		*/
		function redirectTohome($userId){
			$CI =& get_instance();
			if($userId<=0) redirect('home');
		}
	}
	if ( ! function_exists('redirectTo404')){           
		/* function for get redirectTo404 
		 * Wriiten By Gurutva Singh
		*/
		function redirectToNorecord404(){			
			redirect(base_url('my404/norecordfound'));
		}
	}
	

	if ( ! function_exists('delete_directory')){
		function delete_directory($dirname) {
			//echo $dirname; die;
       if (is_dir($dirname))
          $dir_handle = opendir($dirname);
       if (!$dir_handle)
          return false;
       while($file = readdir($dir_handle)) {
          if ($file != "." && $file != "..") {
             if (!is_dir($dirname.DIRECTORY_SEPARATOR.$file))
                @unlink($dirname.DIRECTORY_SEPARATOR.$file);
             else
                delete_directory($dirname.DIRECTORY_SEPARATOR.$file);    
          }
       }
       closedir($dir_handle);
       @rmdir($dirname);
       return true;
    }
	}
	
	if ( ! function_exists('getImage')){		 
	/* function for get fill image path if image is exist else it will return image path of "no-image" file.
	 * Wriiten By Sushil Mishra 
	 */
		function getImage($imagePath='',$imagetype='',$deafultPath=0)
		{
			$imagesFolder = current( explode( "/", $imagetype ) ); 
			if(!@empty($imagePath) && (@is_file($imagePath))){
				$imagepath = base_url($imagePath);
			}else{
				if($imagetype=='') $imagetype= 'images/no_images.png';
				else {
				if($deafultPath ==1 || (strcmp('images',@$imagesFolder)==0)) {$imagetype=$imagetype;}
				else{
					$imagetype = $imagetype=='userIcon'?'images/icons/user.png':$imagetype=='user'?'images/user.png':'images/'.$imagetype;
				}
				}
				$imagepath = base_url($imagetype);
			}
			//$imagepath = str_replace('\\','/',$imagepath );
			return $imagepath;
		}
	}
	/**
		* Fetches the loaction for Location table to get displayed in preview of work
	**/	
	function getCountry($workCountryId)
	{
		$country='';
		if($workCountryId > 0){
			$country = getDataFromTabel('MasterCountry','countryName',  'countryId', $workCountryId,'', 'ASC', $limit=1 );
			$country=@$country[0]->countryName;
		}
		
			return $country;
		
	}
	function getCountryID($countryName='')
	{
		
		$countryId=0;
		if(!empty($countryName)){
			$CI =&get_instance();
			$countryName=trim($countryName);
			
			$table= $CI->db->dbprefix('MasterCountry');
			$query='Select "countryId" From "'.$table.'" WHERE  "countryName" ILIKE \''.$countryName.'\' ';
			$result = $CI->model_common->runQuery($query);
			if($result){
				$country=$result->result();
			}
			if(isset($country[0]->countryId)){
				$countryId=$country[0]->countryId;
			}
		}
		
		return $countryId;
		
	}
	/**
		* Fetches the Language from Language table to get displayed in preview of work
	**/	
	
	
	if ( ! function_exists('getMessageTemplate')){		 
		/* function for get Country List.
		 * Wriiten By Sushil Mishra 
		 */
		function getMessageTemplate($purpose='', $lang='en')
		{
			$lang=trim($lang);
			if(empty($lang)){
				$lang='en';
			}
			$CI =&get_instance();
			// Change in parameter - added by Sapna Jain on 20-03-2012 - for country's Ordered list
			$res =  $CI->model_common->getMessageTemplate($purpose,$lang);
			if($res){
				return $res[0];
			}else{
				return false;
			}
		}
	}
	
	if ( ! function_exists('getMasterTableRecord')){		 
		/* 
		 * Wriiten By Sushil Mishra 
		 */
		function getMasterTableRecord($tableName='')
		{
			global $masterTable;
			if(!strstr($tableName,'TDS_') && !strstr($tableName,'tds_')){
				$CI =&get_instance();
				$tableName=$CI->db->dbprefix($tableName);	
			}
			if(isset($masterTable[$tableName])){
				return $masterTable[$tableName];
			}else{
				return false;
			}

		}
	}
	
	if ( ! function_exists('getMasterTableName')){		 
		/* 
		 * Wriiten By Sushil Mishra 
		 */
		function getMasterTableName($tableId='')
		{
			global $masterTable;			
			return (array_keys($masterTable,$tableId));

		}
	}
	
	if ( ! function_exists('getCountryList')){		 
	/* function for get Country List.
	 * Wriiten By Sushil Mishra 
	 */
		function getCountryList()
		{
			$CI =&get_instance();
			$countries[''] = $CI->lang->line('selectCountry');
			$res =  $CI->model_common->getDataFromTabel('MasterCountry', 'countryName,countryId',  'status', '1', 'countryName');
			if($res){
				foreach ($res as $country) {
						$countries[$country->countryId] = $country->countryName;
				}
			}
			return $countries;
		}
	}
	
	 
	 function get_id_max()
		{
			$CI =&get_instance();
			$table=$CI->db->dbprefix('UserContacts');

			$CI->db->select_max('UserContacts.contId');
			$CI->db->from('UserContacts');
			
			$query = $CI->db->get();
			//echo $CI->db->last_query();
			
			
			return $result=$query->result();		
			
		}
	
	 function get_id_max_1($search)
		{
			$CI =&get_instance();
			$table=$CI->db->dbprefix('UserContacts');

			$CI->db->select_max('UserContacts.contId');
			$CI->db->from('UserContacts');
			//$CI->db->where('UserContacts.tdsUid',$userId);
			if($search != ""){
				$CI->db->like('UserContacts.firstName',$search,'both');
				$CI->db->or_like('UserContacts.firstName',strtolower($search),'both');
				$CI->db->or_like('UserContacts.firstName',ucfirst($search),'both');
				$CI->db->or_like('UserContacts.lastName',strtolower($search),'both');
				$CI->db->or_like('UserContacts.lastName',ucfirst($search),'both');
				$CI->db->or_like('UserContacts.emailId',strtolower($search),'both');
				//$CI->db->or_like('UserContacts.firstName',ucwords($search),'after');
			}
		      $query = $CI->db->get();
			//echo $CI->db->last_query();
		return $result=$query->result();		
			
		}
	
	 function get_id_min()
		{
			$CI =&get_instance();
			
			$table=$CI->db->dbprefix('UserContacts');

			$CI->db->select_min('UserContacts.contId');
			$CI->db->from('UserContacts');
			
			$query = $CI->db->get();
			//echo $CI->db->last_query();		
			return $result=$query->result();		
			
		}
	function get_id_min_1($search)
		{
			$CI =&get_instance();
			$table=$CI->db->dbprefix('UserContacts');

			$CI->db->select_min('UserContacts.contId');
			$CI->db->from('UserContacts');
			//$CI->db->where('UserContacts.tdsUid',$userId);
			if($search != "")
			{
				$CI->db->like('UserContacts.firstName',$search,'both');
				$CI->db->or_like('UserContacts.firstName',strtolower($search),'both');
				$CI->db->or_like('UserContacts.firstName',ucfirst($search),'both');
				$CI->db->or_like('UserContacts.lastName',strtolower($search),'both');
				$CI->db->or_like('UserContacts.lastName',ucfirst($search),'both');
				$CI->db->or_like('UserContacts.emailId',strtolower($search),'both');
								
				//$CI->db->or_like('UserContacts.firstName',ucwords($search),'after');
			}
            $query = $CI->db->get();
            return $result=$query->result();		
		}
	
	if ( ! function_exists('getCountryListById')){		 
	/* function for get Country List.
	 * Wriiten By Sushil Mishra 
	 */
		function getCountryListById()
		{
			return getCountryList();
		}
	}
	if ( ! function_exists('getIconList')){		 
	/* function for get Social Media Icon List.
	 * Wriiten By Sapna Jain 
	 */
		function getIconList()
		{
			$CI =&get_instance();
			
			$res =  $CI->model_common->getDataFromTabel('profileSocialMediaIcon', '', '','','profileSocialMediaName');
			
			$socialMediaIcon=array();
			$socialMediaIcon[''] = $CI->lang->line('selectIcon');
			if($res){
				foreach ($res as $mediaIcon) {
	
						$socialMediaIcon[$mediaIcon->profileSocialMediaId] = $mediaIcon->profileSocialMediaName;
					}
				return $socialMediaIcon;
			}else{
				return false;
			}
		}
	}
	
	if ( ! function_exists('getlanguageList')){		 
	/* function for get language List.
	 * Wriiten By Sushil Mishra 
	 */
		function getlanguageList()
		{
			$CI =&get_instance();
			// Change in parameter - added by Sapna Jain on 20-03-2012 - for country's Ordered list
			$res =  $CI->model_common->getDataFromTabel('MasterLang', 'langId,Language_local','','','Language','ASC');
			if($res){
				$languages[0] = $CI->lang->line('selectLanguage');
				foreach ($res as $language) {
						$languages[$language->langId] = $language->Language_local;
				}
				return $languages;
			}else{
				return false;
			}
		}
	}
	
	if ( ! function_exists('getAbbrLangList')){		 
	/* function for get language List.
	 * Wriiten By Sushil Mishra 
	 */
		function getAbbrLangList($selectedLang)
		{
			$CI =&get_instance();
			// Change in parameter - added by Sapna Jain on 20-03-2012 - for country's Ordered list
			$res =  $CI->model_common->getDataFromTabelWhereWhereIn('MasterLang', 'langId,Language_local,lang_abbr','','Language',$selectedLang,'Language_local',1);
			if($res){
				$languages[''] = $CI->lang->line('selectLanguage');
				foreach ($res as $language) {
						$languages[$language->lang_abbr] = $language->Language_local;
				}
				return $languages;
			}else{
				return false;
			}
		}
	}
	
	if ( ! function_exists('getProjCategory')){		 
		/* function for get Proj Category.
		 * Wriiten By Sushil Mishra 
		 */
		function getProjCategoryList($IndustryId=0, $lang='en', $defaultOption='selectCategory',$entityId=''){
			$lang=trim($lang);
			if(empty($lang)){
				$lang='en';
			}
			$CI =& get_instance();
			$data=array();
			$whereField = array(
							'lang'=>$lang
						  );
			if(is_numeric($IndustryId)){
				$whereField['IndustryId']=$IndustryId;
			}
			if(is_numeric($entityId)){
				$whereField['entityId']=$entityId;
			}
			$res = $CI->model_common->getDataFromTabel('ProjCategory', 'catId, category',  $whereField, '', 'category','ASC');
			//return $res;
			if($defaultOption) $data[''] = $CI->lang->line($defaultOption);
			
			if($res){
				foreach ($res as $category)
				{
					$data[$category->catId] = $category->category;
				}
				
			}
			return $data;
		}
	}
	
	if ( ! function_exists('projCategoryInRadio')){		 
		/* function for get Proj Category.
		 * Wriiten By Sushil Mishra 
		 */
		function projCategoryInRadio($indusrtyId=0, $lang='en', $defaultOption='selectCategory',$entityId='',$catId=0){
			
			$lang=trim($lang);
			if(empty($lang)){
				$lang='en';
			}
			$catString='';
			$CI =& get_instance();
			
			$whereField = array(
							'lang'=>$lang
						  );
			if(is_numeric($entityId)){
				$whereField['entityId']=$entityId;
			}
			$res = $CI->model_common->getDataFromTabel('ProjCategory', 'catId, category',  $whereField, '', 'category','ASC');
			//return $res;
			if($res){
				foreach ($res as $k=>$category)
				{
					if($catId == $category->catId){
						$checked='checked';
						$toltipMsg=$CI->lang->line('collectionProjectInfo');
					}else{
						$checked='';
						$toltipMsg=$CI->lang->line('majorProjectInfo');
					}
					if($category->category)
					

					$catString.='
						<div class="cell defaultP formTip" title="'.$toltipMsg.'" >
							<input '.$checked.' type="radio" value="'.$category->catId.'" name="projCategory" onchange="getTypeList(\'projectTypeList\',\'projGenre\','.$indusrtyId.','.$category->catId.',\''.$defaultOption.'\');"  >
						</div>
						<div class="cell mr8">
						  <label class="lH25">'.$category->category.'</label>
						</div>
					';
				}
				
			}
			return $catString;
		}
	}
	
	if ( ! function_exists('getTypeList')){		 
		/* function for get Type List.
		 * Wriiten By Sushil Mishra 
		 */
		function getTypeList($IndustryId='', $lang='en', $defaultOption='selectProjectType',$catId=''){
			
			$lang=trim($lang);
			if(empty($lang)){
				$lang='en';
			}
			$CI =& get_instance();
			$data=array();
			$whereField = array(
							'lang'=>$lang 
						  );
			
			if($IndustryId > 0 && is_numeric($IndustryId)){
				$whereField['industryId']=$IndustryId;
			}
			
			if($catId>0){
				$whereField['catId']=$catId;
			}
			
			if($defaultOption)$data[''] = $CI->lang->line($defaultOption);
			
			if($IndustryId > 0 || $catId > 0 ){
				$res = $CI->model_common->getDataFromTabel('MasterProjectType', 'typeId, projectTypeName',  $whereField, '', 'projectTypeName','ASC');
				if($res){
					foreach ($res as $type)
					{
						$data[$type->typeId] = $type->projectTypeName;
					}
					
				}
			}
			return $data;
		}
	}
	
	
	if ( ! function_exists('getGenerList')){		 
	/* function for get Gener List.
	 * Wriiten By Sushil Mishra 
	 */
		function getGenerList($typeId=0, $indstryId=0, $lang='en', $defaultOption='selectProjectType',$entityId=0)
		{
			$lang=trim($lang);
			if(empty($lang)){
				$lang='en';
			}
			$CI =&get_instance();
			// Change in parameter - added by Sapna Jain on 20-03-2012 - for country's Ordered list
			$genere=array();
			if($defaultOption) $genere['']=$CI->lang->line($defaultOption);
			if($typeId > 0 || $indstryId > 0 || $entityId > 0){
				$res =  $CI->model_common->getGenerList($typeId,$indstryId,$lang,$entityId);
				if($res){
					$GenreName='';
					foreach ($res as $gener) {
						if($gener->Genre != $GenreName){
							$genere[$gener->GenreId] = $gener->Genre;
							$GenreName=$gener->Genre;
						}
					}
				}
			}
			//$genere['other'] = $CI->lang->line('other');
			return $genere;
		}
	}
	
		
	if ( ! function_exists('getRatingList')){		 
	/* function for get Rating List.
	 * Wriiten By Sushil Mishra 
	 */
		function getRatingList($IndustryId=1, $lang='en', $defaultOption='selectRating')
		{
			
			$lang=trim($lang);
			if(empty($lang)){
				$lang='en';
			}
			$CI =&get_instance();
			// Change in parameter - added by Sapna Jain on 20-03-2012 - for country's Ordered list
			$Rating=array();
			$Rating['']=$CI->lang->line($defaultOption);
			$res =  $CI->model_common->getRatingList($IndustryId, $lang);
			if($res){
				foreach ($res as $rat) {
						$Rating[$rat->ratId] = $rat->otpion;
				}
			}
			return $Rating;
		}
	}
	
	
	function getLanguage($langId)
	{
		$language = getDataFromTabel('MasterLang','Language_local',  'langId', $langId,'', 'ASC', $limit=1 );
		//echo '<pre />count';print_r($language);
		if(count($language)>0 &&  $language !='')
			return $language[0]->Language_local;
		else 
			return '';
	}
	
	
	function getMasterRating($ratingId)
	{
		$masterRating = getDataFromTabel('MasterRating','otpion',  'ratId', $ratingId,'', 'ASC', $limit=1 );
		//echo '<pre />count';print_r($language);
		if(count($masterRating)>0 &&  $masterRating !='')
			return $masterRating[0]->otpion;
		else 
			return ' ';
	}
	
	/**
		* Fetches the industry  from industry  array to get displayed in preview of work
	**/	
	function loadIndustry($isMediaIndustry='')
	{
		if(isset($isMediaIndustry) && $isMediaIndustry!='') $whereField = array('lang'=>lang(),'isMediaIndustry'=>'t');
		else $whereField = array('lang'=>lang(),'isIndustry'=>'t');
		$industry = getDataFromTabel('MasterIndustry','IndustryId,IndustryName',$whereField,'','IndustryName','ASC');
		return $industry;
	}
	
	
	if ( ! function_exists('getIndustryList')){		 
		/* function forgetIndustryList.
		 * Wriiten By Sushil Mishra 
		 */
		function getIndustryList($lang='en',$isSection=0,$isMediaIndustry='', $isall=0){
			if($lang==''){
				$lang = lang();
			}
			$CI =& get_instance();
			$isAssoMember = 0;
			if(!isset($isMediaIndustry) || $isMediaIndustry!='') {
				$data[''] = $CI->lang->line('selectIndustry');
				$whereField = array('lang'=>lang(),'isMediaIndustry'=>'t');
			}
			elseif($isSection==1){
				$data[''] = $CI->lang->line('selectSection');
				$whereField = array('lang'=>$lang,'isSection'=>'t');
			}
			elseif($isSection==2){
				$data[''] = $CI->lang->line('selectSection');
				$whereField = '"IndustryId"=6 OR "IndustryId"=7 OR "IndustryId"=8';
                $isAssoMember = 1;
			}
			else{
				$data[''] = $CI->lang->line('selectIndustry');
				$whereField = array('lang'=>$lang,'isIndustry'=>'t');
			}
            
			$res = $CI->model_common->getDataFromTabel('MasterIndustry', 'IndustryId,IndustryName',  $whereField, '', 'IndustryName','ASC',0,0,false,$isAssoMember);
			if($res){
				foreach ($res as $industry){
                    $data[$industry->IndustryId] = $industry->IndustryName;
				}
				
			}
			return $data;
		}
	}
	if ( ! function_exists('getStatesList')){		 
		/* function forgetStatesList.
		 * Wriiten By Sushil Mishra 
		 */
		function getStatesList($countryId=0,$iscountry=false){
			$CI =& get_instance();
				
			if($iscountry && !$countryId>0){
				 $data['']  = $CI->lang->line('selectState');		
				 return $data;		
			} 	
			$where['status']='t';
			$data = false;
			if($countryId > 0){
				$where['countryId']=$countryId;
			}
			$res = $CI->model_common->getDataFromTabel('MasterStates', 'stateId,stateName',  $where, '', 'stateName','ASC');
			if($res){
				$data['']  = $CI->lang->line('selectState');
				foreach ($res as $state){
					$data[$state->stateId] = $state->stateName;
				}
			} 
			
			if(!$res && $iscountry ){
				 $data['']  = $CI->lang->line('selectState');				
			}
			 return $data;
		}
	}
	if ( ! function_exists('euCountiesList')){		 
		/* function forgetIndustryList.
		 * Wriiten By Sushil Mishra 
		 */
		function euCountiesList(){
			$CI =& get_instance();
			$where['countryGroup']='EU';
			$where['status']='1';
			$data = false;
			$res = $CI->model_common->getDataFromTabel('MasterCountry', 'countryId,countryName',  $where, '', 'countryName','ASC');
			if($res){
				foreach ($res as $country){
					$data[$country->countryId] = $country->countryName;
				}
			}
			return $data;
		}
	}
	
	if ( ! function_exists('countiesNotInEU')){		 
		/* function forgetIndustryList.
		 * Wriiten By Sushil Mishra 
		 */
		function countiesNotInEU(){
			$CI =& get_instance();
			$where['status']='1';
			$where['status']='1';
			$data = false;
			$res = $CI->model_common->getDataFromTabelWhereWhereIn('MasterCountry', 'countryId,countryName',  $where, 'countryGroup', 'EU', 'countryName', 1);
			
			if($res){
				foreach ($res as $country){
					$data[$country->countryId] = $country->countryName;
				}
			}
			return $data;
		}
	}
	
	/**
		* Fetches the industry  from industry  array to get displayed in preview of work
	**/	
	function getIndustry($IndustryId)
	{
		$industry = getDataFromTabel('MasterIndustry','IndustryName',  'IndustryId', $IndustryId,'', 'ASC', $limit=1 );
		
		if($industry) 
			return $industry[0]->IndustryName;
		else 
			return false;
	}

	
	/**
		* Fetches the industry  from industry  array to get displayed in preview of work
	**/	
	function getUserName($UId)
	{
		$resultUserName = getDataFromTabel('UserProfile','firstName,lastName',  'tdsUid', $UId,'', 'ASC', $limit=1 );
		$finalUserName = $resultUserName[0]->firstName.' '.$resultUserName[0]->lastName;
		return $finalUserName;
	}

	/**
		* Fetches the industry  from industry  array to get displayed in preview of work
	**/	
	function getUserImage($UId)
	{
		
		$resultUserName = getDataFromTabel('UserProfile','image',  'tdsUid', $UId,'', 'ASC', $limit=1 );
		
		if(count($resultUserName)>0)
			$finalUserImage = $resultUserName[0]->image;
		else 
			$finalUserImage = 0;
			
		return $finalUserImage;
		
	}
	
	/**
		* Fetches the given file from given table name for the primary Id given for defined table name
		* @param:anyField //this to specify which field I want to extract from table
		* @param:anyTable //this to specify from which table I need record(anyField)
		* @param:anyWhereField //this is to specify on which I have to apply the where clause
		* @param:anyWhereFieldValue //this to specify for which value have to apply the where clause
	**/	
	function getFieldValueFrmTable($anyField='blogImgPath',$anyTable='Blogs',$anyWhereField='',$anyWhereFieldValue=0,$orderBy='')
	{
		
		$anyrecordValue = getDataFromTabel($anyTable,$anyField,  $anyWhereField, $anyWhereFieldValue,$orderBy);
		if(count($anyrecordValue)>0) return $anyrecordValue;
		else return 0;
	}
	
	/**
	 * Set Global Messages
	 * Wriiten By Sushil Mishra 
	 * Date 09-03-2012
	 * @access	public
	 * @param	array | String
	 * @return	void
	 */	
	if ( ! function_exists('set_global_messages'))
	{
		function set_global_messages($msg='', $type='error', $is_multiple=true)
		{
			$CI =&get_instance();
			
			$global_messages = array();
			foreach((array)$msg as $v) {
				$global_messages[$type.'Msg'][] = (string)$v;
			}
			$CI->session->set_userdata('global_messages', $global_messages);
		}
	}
	/**
	 * Get Global Messages
	 * Wriiten By Sushil Mishra 
	 * Date 09-03-2012
	 * @access	public
	 * @param	void
	 * @return	string
	 */
	//error_reporting(0);
	if ( ! function_exists('get_global_messages'))
	{
		function get_global_messages()
		{
			$str = '';
			$CI =&get_instance();
			
			$global_messages = (array)$CI->session->userdata('global_messages');
			
			if($global_messages && is_array($global_messages) &&count($global_messages) > 0) {
				foreach($global_messages as $k => $v) {
					echo '<div id="messageSuccessError" class="'.$k.'">';
					
					foreach((array)$v as $w) {
						echo "$w\n";
					}
					
					echo '</div>';
				}
			} 
			
			if($global_messages && !empty($global_messages)){
				$CI->session->unset_userdata('global_messages');
			}
			
			
			return $str;
		}
		
	}
	
	if ( ! function_exists('isLoginUser')){		 
		/* function for isLoginUser.
		 * Wriiten By Sushil Mishra 
		 */
		function isLoginUser(){
			$CI =& get_instance();
			$user_id=$CI->session->userdata('user_id');
			if($user_id > 0){
				return $user_id;
			}else{
				return false;
			}
		}
	}
	
	if ( ! function_exists('LoginUserDetails')){		 
		/* function for isLoginUser.
		 * Wriiten By Sushil Mishra 
		 */
		function LoginUserDetails($field='username'){
			$CI =& get_instance();
            $data = $CI->session->userdata($field);
            if(!$data && ($field == 'firstName' || $field == 'lastName')){
                $field = strtolower($field);
                $data = $CI->session->userdata($field);
            }
			return $data;
		}
	}
	if ( ! function_exists('set_userdata')){		 
		/* function for isLoginUser.
		 * Wriiten By Sushil Mishra 
		 */
		function set_userdata($var='', $value=''){
			if($var != '' && $value != ''){
				$CI =& get_instance();
				$CI->session->set_userdata($var,$value);
			}
		}
	}
	
	function object2array($object) 
	{
		if (is_object($object)) {
			foreach ($object as $key => $value) {
				$array[$key] = $value;
			}
		}
		else {
			$array = $object;
		}
		return $array;
	}
	
	if ( ! function_exists('getCountryFromIP')){		 
		/* function for getCountryFromIP.
		 * Wriiten By Sushil Mishra 
		 */
		function getCountryFromIP(){
		
			//$country='India';
			//return $country;
			//if (isset($_COOKIE['toadSquare'])) {
				//$country=$_COOKIE['toadSquare']['Country'];
				
			//}else{
			
				if($_SERVER["REMOTE_ADDR"]=="" || $_SERVER["REMOTE_ADDR"]=="::1" || $_SERVER["REMOTE_ADDR"]=="127.0.0.1" || substr($_SERVER["REMOTE_ADDR"],0,3) =="192")
				{
					$ip="115.113.182.141";
				}else{
					$ip=$_SERVER["REMOTE_ADDR"];
				}
				
				$country = getCountryDetailsFromIP($ip, " NamE ");
				setcookie("toadSquare[Country]", $country, time()+(3600*24*365));
				
				/*// -- Request to API to get Country --
				
				$tags = @get_meta_tags('http://www.geobytes.com/IpLocator.htm?GetLocation&template=php3.txt&IpAddress='.$_SERVER["REMOTE_ADDR"]);
				$country = @$tags['country'];
				
				if (is_array($tags)){
					$country = @$tags['country'];
					// -- set the cookies --
					setcookie("toadSquare[shortCountry]", @$tags['iso2'], time()+(3600*24*365));
					setcookie("toadSquare[Country]", @$tags['country'], time()+(3600*24*365));
					setcookie("toadSquare[City]", @$tags['city'], time()+(3600*24*365));			
					
				}*/
			//}
			return $country;
		}
	}

//Created By Sapna for the different Date Time Format
	if( ! function_exists('get_timestamp'))
	{
		function get_timestamp($formate,$value)
		{
			$value = strtotime($value);
			echo date($formate,$value);
		}
	}

	if( ! function_exists('in_arrayr'))
	{
		function in_arrayr( $value, $array, $key='', $is_object=0 ) {
            foreach( $array as $v ){
                if($is_object){
                    if( $value == $v->$key )
                        return true;
                }else{
                    if( $value == $v )
                        return true;
                    elseif( is_array( $v ) )
                        if( in_arrayr( $value, $v ) )
                            return true;
                }
            }
            return false;
        }
    
    }
	if( ! function_exists('uploadFile'))
	{
		function uploadFile($uploadFile,$key,$type='image', $config=array()){
			$CI =& get_instance();
			$CI->load->library('upload_file'); 
			$CI->upload_file->initialize($config);
			$err_msgs="";
			$uploaddata=array();
			if(!$CI->upload_file->do_upload($uploadFile,$key))
			{
				// If there is any error
				$uploaddata['err_msg']= 'Error in Uploading video '.$CI->upload_file->display_errors().'<br />';
				$uploaddata['return']= false;
			}
			else
			{
				$data=array('upload_data' => $CI->upload_file->data());
				$video_path = $data['upload_data']['file_name'];
				$directory_path 	 = $data['upload_data']['file_path'];
				$directory_path_full     = $data['upload_data']['full_path'];
				$uploaddata['file_name'] = $data['upload_data']['raw_name'];
				$uploaddata['file_ext']  = $data['upload_data']['file_ext'];
				$uploaddata['file_size'] = $data['upload_data']['file_size'];
				
				// ffmpeg command to convert video
				/*
				if(($uploaddata['file_ext'] != 'flv') && ($type=='video')){
					$uploaddata['file_name'] =$uploaddata['file_name'].".flv";
					exec("ffmpeg -i ".$directory_path_full." ".$directory_path.$uploaddata['file_name']); 
				}else{
					$uploaddata['file_name'] =$uploaddata['file_name'].$uploaddata['file_ext'];
				}
				*/
				$uploaddata['file_name'] =$uploaddata['file_name'].$uploaddata['file_ext'];
				$uploaddata['return']= true;
				
			}

			return $uploaddata;
		}
	}
	
	if(! function_exists('getDataFromTabel')){
		function getDataFromTabel($table='', $field='*',  $whereField='', $whereValue='', $orderBy='', $order='ASC', $limit=0, $offset=0, $resultInArray=false ){
			$CI =& get_instance();
			$res =  $CI->model_common->getDataFromTabel($table, $field,  $whereField, $whereValue, $orderBy, $order, $limit, $offset, $resultInArray );
			return $res;
		}
	}
	
	if(! function_exists('getSum')){
		function getSum($table='',$field='',$where=''){
			$sum=0;
			$CI =& get_instance();
			$res =  $CI->model_common->getSum($table, $field,  $where);
			
			$field=strtolower($field);
			if($res && isset($res[0]->$field) && ($res[0]->$field >0)){
				$sum=$res[0]->$field;
			}
			
			$sum=number_format($sum,2);
			return $sum;
		}
		
	}
	
	if(! function_exists('getDataFromTabelWhereWhereIn')){
		function getDataFromTabelWhereWhereIn($table='', $field='*',  $where='',  $whereinField='', $whereinValue='', $orderBy='', $order='ASC', $whereNotIn=0){
			$CI =& get_instance();
			$res =  $CI->model_common->getDataFromTabelWhereWhereIn($table, $field,  $where,  $whereinField, $whereinValue, $orderBy, $order, $whereNotIn);
			return $res;
		}
	}


if(! function_exists('getDataFromMixTabel')){
		function getDataFromMixTabel($table='', $field='*',  $where="", $orderBy='',  $limit='' ){
			$CI =& get_instance();
			$res =  $CI->model_common->getDataFromMixTabel($table, $field,  $where, $orderBy,  $limit );
			return $res;
		}
	}


	/*Added by Gurutva Singh*/
	function getDataFromTabelCommon($table='', $field='*',  $whereField='', $whereValue='', $orderBy='', $order='ASC', $limit=0 ){
		
		$dataResult=getDataFromTabel($table, $field,  $whereField, $whereValue, $orderBy, $order, $limit);
		
		return $dataResult;
	}

	/* Added by Gurutva Singh for promo media add/edit */

	function saveUploadPromoMedia($tableName,$promoMediaField,$promoMediaFieldValues,$promoMediaPath,$uploadArray,$entityId,$fileType,$returnUrl,$imgConfigArray)
	{

		$CI =& get_instance();
		$CI->lib_sub_master_media->setPromoImageValue($tableName,$promoMediaField,$promoMediaFieldValues);

		$promoMedia['detailed'] = $CI->lib_sub_master_media->getPromoImageValue();

		//$eventNotification['data'] = $eventNotification['detailed']['event'];
		foreach($promoMedia['detailed']['entityMedia'] as $k => $v){

			if(isset($promoMedia['detailed']['entityMedia'][$k]) && $promoMedia['detailed']['entityMedia'][$k]!='')//checking in process {
			$promoMedia['data'][$k] = $v;

		}

		$uploadedData = array(); // File Upload code
	
		$promoMediaName = '';
		//file given to upload then only call upload function
		//echo '<pre />';print_r($promoMediaFieldValues);die;
		if(isset($uploadArray['userfileImage']['name'])){

			if($promoMediaFieldValues['mediaId']==0 && $uploadArray['userfileImage']['name'] == ''){
				$message= 'You did not select a file to upload';
				set_global_messages($message, 'error');
				redirect($returnUrl);
			}
			if($uploadArray['userfileImage']['name'] != ''){

				$uploadedData = $CI->lib_sub_master_media->do_upload($uploadArray,$promoMediaPath,$entityId,$fileType,'userfileImage');
				if(!isset($uploadedData['error']))
				{
					$promoMediaName = $uploadedData['upload_data']['file_name'];
					$orignalImgName = $promoMediaName;
				//echo $promoMediaPath.$promoMediaName; die;	
					/*-------------for versions----------*/
					$versionThumbsFolderPath = $promoMediaPath;
						
				}else{
					$message= $uploadedData['error'];
					set_global_messages($message, 'error');
					redirect($returnUrl);
				}
				$data['filePath'] = $promoMediaPath;
				$data['fileName'] = $uploadedData['upload_data']['file_name'];
				$data['fileSize'] = $uploadedData['upload_data']['file_size'];
				$data['fileType'] = $fileType;
				$data['fileCreateDate'] = currntDateTime();
				
				//Insert data into main mediaFile. get the Id of mediaFile....
				if(!isset($promoMedia['data']['fileId']) || $promoMedia['data']['fileId'] == 0)
					$fileId = $CI->model_common->addDataIntoTabel('MediaFile', $data);
				else{
					$CI->model_common->editDataFromTabel('MediaFile', $data,'fileId',$promoMedia['data']['fileId']);
					$fileId = $promoMedia['data']['fileId'];
					unset($promoMedia['data']['fileSize']);
				}
				unset($data['fileId']);
				$dataSetValue = $CI->lib_mastermedia->setValues($data);
				$data= $CI->lib_mastermedia->getValues();
				$promoMedia['data']['fileId'] = $fileId;
			}
		}
		//if($launchEventId>0) $promoMedia['data']['launchEventId']=$launchEventId;
		unset($promoMedia['data']['filePath']);
		unset($promoMedia['data']['fileName']);
		//unset($promoMedia['data']['fileSize']);
		unset($promoMedia['data']['fileType']);
		unset($promoMedia['data']['fileCreateDate']);
		unset($promoMedia['data']['entityId']);
		unset($promoMedia['data']['isExternal']);
		
		
		if(isset($promoMedia['data']['mode']) && strcmp($promoMedia['data']['mode'],'edit') == 0) {
			if($promoMedia['data']['mediaId'] ==0)
			unset($promoMedia['data']['mediaId']);
			unset($promoMedia['data']['mode']);
		}
		
		//Added as per client's requirement as title in not manadatory
		$promoMedia['data']['mediaTitle'] = $promoMediaFieldValues['mediaTitle'];
	
		$savePromoImageQuery = $CI->lib_sub_master_media->savePromoMedia($promoMedia['data'],$tableName);
		if($fileType==1)
			set_global_messages($CI->lang->line('imgSaveSucc'), 'success');
		else 
			set_global_messages($CI->lang->line('mediaSaved'), 'success');
			
		redirect($returnUrl);
	}

	function createthumbimages($targetDir='',$fileName=''){		
		$targetDir=trim($targetDir);
		$fileName=trim($fileName);
		$filePath=str_replace('+',DIRECTORY_SEPARATOR,$targetDir);
		
		$CI =& get_instance();
		ini_set('memory_limit', '-1');
		$thumbFolder = $CI->config->item('imgThumbVersionFolder');
		$thumb_config = $CI->config->item('thumb_config');
        
       
		//************************************************************//
		if(!@empty($filePath) && (@is_dir($filePath)))
		{
			$imgThumbFolder = $filePath.$thumbFolder;
			$orignalImagPath = $filePath;
			
			$cmdimgFolderPath = 'chmod -R 0777 '.$orignalImagPath;
			exec($cmdimgFolderPath);
			
			$imagePath = $orignalImagPath.$fileName;
			if(!empty($thumb_config) && is_array($thumb_config)){
                foreach($thumb_config  as $key=>$config){
                    $thumbConfig = array('filename'=>$fileName,'width'=>$config['width'],'height'=>$config['height'],'suffix'=>$config['suffix']);
                    createMultiThumb($thumbConfig,$orignalImagPath,$imgThumbFolder);
                }
            }
		}
	}
	
	function createMultiThumb($imageStuff,$imgFolderPath,$imgThumbPath,$createWaterMarkFlag=0)  //file name passed
	{  	
		$CI =& get_instance();		
		$MediaGalleryAttribute = @getimagesize($imgFolderPath.$imageStuff['filename']); 
		$orgImagWidth = $MediaGalleryAttribute[0];
		$orgImagHeight = $MediaGalleryAttribute[1];
		
		if($imageStuff['width'] > $orgImagWidth)  $imageStuff['width'] = $orgImagWidth;
		if($imageStuff['height'] > $orgImagHeight)  $imageStuff['height'] = $orgImagHeight;

		
		$cmdimgFolderPath = 'chmod -R 0777 '.$imgFolderPath;
		exec($cmdimgFolderPath);
		if (!is_dir($imgThumbPath)) {
			if (!mkdir($imgThumbPath, 0777, true)) 
			{
				die('Failed to create folders...');
			}
		}
		
		$cmdImgThumbPath = 'chmod -R 0777 '.$imgThumbPath;
		exec($cmdImgThumbPath);
		
		// Use strrpos() & substr() to get the file extension
		$ext = substr($imageStuff['filename'], strrpos($imageStuff['filename'], "."));
		// Then stitch it together with the new string and file's basename
		
		$orgImageName = $imageStuff['filename'];
		
		// this thumbnail created
		$config['image_library'] = 'gd2';
		$config['source_image']    = $imgFolderPath.$orgImageName;
		$config['create_thumb'] = FALSE;   
		$config['maintain_ratio'] = TRUE;
		$config['width']     = $imageStuff['width'];
		$config['height']   = $imageStuff['height'];
		
		// Then stitch it together with the new string and file's basename
		$newImageName = basename($imageStuff['filename'], $ext) . $imageStuff['suffix'] . $ext;

		$config['new_image'] = $imgThumbPath.$newImageName;
		if(!is_file($imgThumbPath.$newImageName))
		{
			//echo '<br /> '.$config['new_image'];
			$CI->load->library('image_lib', $config);
			$CI->image_lib->clear();
			$CI->image_lib->initialize($config);
			
			if (!$CI->image_lib->resize())
			{
				echo $CI->image_lib->display_errors();
			}
			$CI->image_lib->clear();
		}
		
		if($createWaterMarkFlag==1){ // create watermark of image
			if(is_file($config['new_image'])){
				$watermarkFolder    = $imgFolderPath.$CI->config->item('watermarkFolder');
				if(!is_dir($watermarkFolder)){
					if (!mkdir($watermarkFolder, 0777, true)) 
					{
						//die('Failed to create folders...');
					}
					if(is_dir($watermarkFolder)){
						$cmdimgFolderPath = 'chmod -R 0777 '.$watermarkFolder;
						exec($cmdimgFolderPath);
					}
				}
				
				$watermarkImage    = $watermarkFolder.$newImageName;
				applyImageWaterMark($config['new_image'],'images/watermark.png',$watermarkImage);
			}
		}
		return $newImageName;
	   
	}

	function getSessionTimeAtt($sesTimeId)
	{
		$CI =& get_instance();
		$sessionattribute = $CI->model_common->getSessionTimeAtt($sesTimeId);
		//echo $CI->db->last_query();
		//echo '<pre />';print_r($sessionattribute);
		return $sessionattribute;	
	}
	//////////////////////////////// Added By Sapna ///////////////////////
	function getProductImages($localMediaTable,$filedName,$imageId,$productType='',$orderBy='')
	{
		$CI =& get_instance();	
		$field = $filedName;
		$fieldproductType = 'mediaType';
		$CI->db->select('*');
		$CI->db->from($localMediaTable);
		$CI->db->join("MediaFile", "MediaFile.fileId = ".$localMediaTable.".fileId", 'left');		
		
		$CI->db->where($field,$imageId);
		$CI->db->where($fieldproductType,$productType);
		if($orderBy !=''){
			$CI->db->order_by('isMain','desc');
		}
		$dataProduct =  $CI->db->get();
		//echo $CI->db->last_query();
		return $dataProduct->result();
	}
	
	function getMainImages($localMediaTable,$fieldToSelected='*',$filedName,$imageId,$productType='',$orderBy='')
	{
		$CI =& get_instance();	
		$field = $filedName;
		$fieldproductType = 'mediaType';
		$CI->db->select($fieldToSelected);
		$CI->db->from($localMediaTable);
		$CI->db->join("MediaFile", "MediaFile.fileId = ".$localMediaTable.".fileId", 'left');		
		
		if(isset($productType) && $productType!=''){
			$CI->db->where('isMain','t');
			$CI->db->where($fieldproductType,$productType);
		}
		
		$CI->db->where($field,$imageId);
		
		if($orderBy !=''){
			$CI->db->order_by('isMain','desc');
		}
		$dataProduct =  $CI->db->get();
		//echo $CI->db->last_query();
		return $dataProduct->result();
	}
	
	function getProductCategoryName($productCategoryId='1')
	{
		$cat=getDataFromTabel('ProdCategory', 'Category', 'catId', $productCategoryId, '', '', 1 )	;
		if($cat){
			$productCategoryName=$cat[0]->Category;	
		}
		return $productCategoryName;
	}


	function deletePromotionImage($localMediaTable,$localMediaTableId, $mediaId, $entityIdfiled, $entityIdValue)
	{
		$CI =& get_instance();

		$getFileId =  $CI->model_common->getDataFromTabel($localMediaTable,'fileId', $localMediaTableId, $mediaId, '', '', $limit=0 );

		$getImageDetail =  $CI->model_common->getDataFromTabel('MediaFile','*', 'fileId', $getFileId[0]->fileId, '', '', $limit=0 );

		$filePath =  $getImageDetail[0]->filePath; 
		$fileName = $getImageDetail[0]->fileName; 
		
		

		$chcekForFeaturedImage = $CI->model_common->chcekForFeaturedImage($localMediaTable,$mediaId,$entityIdfiled,$entityIdValue,'1');

		$CI->model_common->deleteMedia($localMediaTable,$mediaId,$entityIdfiled,$entityIdValue);

		if($chcekForFeaturedImage==$mediaId)
		{
			$CI->model_common->updatePromotionImageStatus($localMediaTable,$entityIdfiled,$entityIdValue,'1');
		}
		
		$filePath=trim($filePath);
		$fileName=trim($fileName);
		if(is_dir($filePath) && $fileName !=''){
			$fpLen=strlen($filePath);
			if($fpLen > 0 && substr($filePath,-1) != DIRECTORY_SEPARATOR){
				$filePath=$filePath.DIRECTORY_SEPARATOR;
			}
			findFileNDelete($filePath,$fileName);
		}
		$CI->model_common->deleteRowFromTabel('MediaFile','fileId',$getFileId[0]->fileId);
	
	}

	function chcekFeaturedImageChangeStatus($localMediaTable,$entityIdfiled, $entityIdValue,$mediaType)
	{
		$CI =& get_instance();

		$fieldmediaType = 'mediaType';
		$fieldentityIdfiled = $entityIdfiled;
		$fieldisMain = 'isMain';
		$CI->db->where($fieldentityIdfiled,$entityIdValue);
		$CI->db->where($fieldmediaType,$mediaType);
		$CI->db->where($fieldisMain,'t');
		$getPromotionMediaStatus = $CI->db->get($localMediaTable);

		$result =  $getPromotionMediaStatus->row();

		$toBeupdatedImageId = @$result->mediaId;

		$updateData->isMain = 'f';
		$field = 'mediaId';
		$CI->db->where($field,$toBeupdatedImageId);
		$CI->db->update($localMediaTable,$updateData);
		return true;
	}

	function getMediaDetail($fileId,$fields="*")
	{

		$CI =& get_instance();
		$data = $CI->model_common->getDataFromTabel('MediaFile',$fields,  'fileId', $fileId, '', 'ASC', 0 );
		//$data = $CI->model_common->getDataFromTabelWhereWhereIn('MediaFile',$fields, '', 'fileId', $fileId,  '','ASC', 0 );		
		return $data;
	}


	//////////////////////// End List By Sapna//////////////////////////////////////////////

	if(! function_exists('addDataIntoLogSummary')){
		function addDataIntoLogSummary($tblName,$elementId)  //file name passed
		{
			$logId = 0;
			$CI =& get_instance();
			$tblLogSummary = $CI->db->dbprefix('LogSummary');
			$entityId = getMasterTableRecord($tblName);
			$where = 'WHERE "entityId"= '.$entityId.' AND "elementId"= '.$elementId.' ';
			$res = $CI->model_common->getDataFromMixTabel('"'.$tblLogSummary.'"', '"actId"',  $where, '',  'LIMIT 1' );
           
			if(!$res){
				$dataLogSummary = array(
					'entityId'=>$entityId,
					'elementId' => $elementId,
					'viewCount' => 0,
					'createDate' => currntDateTime(),
					'lastViewDate' => currntDateTime()
				);
               
				$logId = $CI->model_common->addDataIntoTabel('LogSummary', $dataLogSummary);
			}
			return $logId;
		}
	}
	
	//////////////// Sapna //////////////////////////

	/* Function to get the Media Type - Image(1),Video(2), Audio(3), Document(4) */
	 function getMediaFileType($localMediaTable,$getFiled, $mediaId)
	 {
		 $CI =& get_instance();
		 $res =  $CI->model_common->getDataFromTabel($localMediaTable, $getFiled, 'mediaId', $mediaId, '', '','');
		
		 return $res[0]->mediaType;
	 }
	 
	 function countResult($table='',$field='',$value='', $limit=0)
	 {
		 $CI =& get_instance();
		 return $CI->model_common->countResult($table,$field,$value,$limit);
	 }
	 
	 function countResultFirstInsert($table='',$field='')
	 {
		 $CI =& get_instance();
		 return $CI->model_common->countResultFirstInsert($table,$field);
	 }
	 
	 function userProfileImage($userId=0)
	 {
		$CI =& get_instance();
		$currentClass = $CI->router->class;
		$myShowcase = 0;
		$userFullName = '';
		//echo 'User Id:'.$userId;
		if(!isset($userId) && $userId<=0 && strcmp($currentClass,'showcase')!=0) 
		{
			$userId = isLoginUser();			
		}
			$res =  $CI->model_common->getUserDetails($userId);
			if($res)
			{
				$stockImgId=$res[0]->stockImageId;
				$userFullName = $res[0]->firstName.' '.$res[0]->lastName;
				$userArea = $res[0]->optionAreaName;
				$enterpriseName = $res[0]->enterpriseName;
				$countryName = $res[0]->countryName;
				$creative = $res[0]->creative;
				$associatedProfessional = $res[0]->associatedProfessional;
				$enterprise = $res[0]->enterprise;
				$seller_currency = $res[0]->seller_currency;
				$websiteUrl = $res[0]->websiteUrl;
				$showcaseId = $res[0]->showcaseId;
				if(is_numeric($stockImgId) && ($stockImgId > 0) )
				{
					$userImage=$res[0]->stockImgPath.DIRECTORY_SEPARATOR.$res[0]->stockFilename;					
				}
				else
				{
					$profileImagePath  = 'media/'.$res[0]->username.'/profile_image/';
					$userImage=$profileImagePath.$res[0]->profileImageName;	
				}
				
			}
			else
			{
				$userFullName = LoginUserDetails('firstName').' '.LoginUserDetails('lastName');
				$userImage = LoginUserDetails('imagePath');
				$userArea = LoginUserDetails('userArea');				
				$countryName = LoginUserDetails('countryName');				
				$enterpriseName = LoginUserDetails('enterpriseName');
				$creative =  LoginUserDetails('creative');
				$associatedProfessional =  LoginUserDetails('associatedProfessional');
				$enterprise = LoginUserDetails('enterprise');
				$seller_currency = LoginUserDetails('seller_currency');
				$websiteUrl = LoginUserDetails('websiteUrl');
				$showcaseId = LoginUserDetails('showcaseId');
			}
			
			$userInfo['userFullName'] = $userFullName;
			$userInfo['userImage'] = $userImage;
			$userInfo['userArea'] = $userArea;
			$userInfo['enterpriseName'] = $enterpriseName;
			$userInfo['countryName'] = $countryName;
			$userInfo['creative'] = $creative;
			$userInfo['associatedProfessional'] = $associatedProfessional;
			$userInfo['enterprise'] = $enterprise;
			$userInfo['seller_currency'] = $seller_currency;
			$userInfo['websiteUrl'] = $websiteUrl;
			$userInfo['showcaseId'] = $showcaseId;
	
			return $userInfo;
	 }
	//////////////// End ///////////////////////////
	
	if ( ! function_exists('dateFormatView')){           
	/* function for change date format for view
	 * Wriiten By Gurutva 
	*/
		function dateFormatView($time = '',$fmt = 'l, d F Y')
		{	
			if ( ! isset($time))
			{
				return FALSE;
			}
			return date($fmt, strtotime($time));
		}
	}
	
	
	if(! function_exists('showCaseUserDetails'))
	{		 
		/* function for showCaseUserDetails: to get the detail of user to get shown in breadcrumb.
		 * Wriiten By Gurutva Singh 
		 */
		function showCaseUserDetails($userId=0,$section='userBackend'){		
				
			$CI =& get_instance();
			$module=$CI->router->fetch_class();
			$moldulesFrontEnd=array('showcase','mediafrontend','writingnpublishing','musicnaudio','photographynart','filmnvideo','educationmaterial','blogshowcase','blogs','creatives','associateprofessional','enterprises','works','products','event','upcomingfrontend','eventfrontend','showproject','workshowcase','productshowcase','craves');
			if(in_array($module,$moldulesFrontEnd)){
				$section='frontend';
			}
			
			if($userId>0){
				$showcaseUserId =$userId;
			}
			elseif($section=='userBackend'){
				$showcaseUserId =isLoginUser();
			}else{
				$showcaseUserId = ($CI->uri->segment(4)>0)?$CI->uri->segment(4):isLoginUser();
			}
			//$showcaseUserId = ($userId>0)?$userId:(($CI->uri->segment(4)>0)?$CI->uri->segment(4):isLoginUser());
			$loggedUserId=isLoginUser();
			$userInfo['userFullName'] = '';
			$userInfo['userImage'] = '';
			$userInfo['userArea'] = '';
			if($showcaseUserId==$loggedUserId){
				$userInfo['userFullName'] = LoginUserDetails('userFullName');
				$userInfo['userImage'] = LoginUserDetails('imagePath');
				$userInfo['userArea'] = LoginUserDetails('userArea');
				$userInfo['countryName'] = LoginUserDetails('countryName');
				$userInfo['enterpriseName'] = LoginUserDetails('enterpriseName');
				$userInfo['creative'] = LoginUserDetails('creative');
				$userInfo['associatedProfessional'] = LoginUserDetails('associatedProfessional');
				$userInfo['enterprise'] = LoginUserDetails('enterprise');
				$userInfo['seller_currency'] = LoginUserDetails('seller_currency');
				$userInfo['websiteUrl'] = LoginUserDetails('websiteUrl');
				$userInfo['showcaseId'] = LoginUserDetails('showcaseId');
			}elseif($showcaseUserId > 0){
				$userInfo = userProfileImage($showcaseUserId);
			}
			
			if(isset($showcaseUserId) && $showcaseUserId>0 &&  ($section=='frontend'))
			{					
				$userInfo['hideFrontMenu'] = 1;
			}
			else
			{
				$userInfo['hideFrontMenu'] = 0;
			}
			if($userInfo['enterprise'] == 't'){
				$userInfo['userFullName'] = $userInfo['enterpriseName'];
			}
			return $userInfo;
		}
	}
	/**
	 *  get category id of entity
	 *  @ return category id
	 *  Amit 
	 *  26June12
	**/
	
	if(! function_exists('getEntityCategory')){
		function getEntityCategory($entityId)  //file name passed
		{
			$CI =& get_instance();
			$res = $CI->model_common->getEntityCategory($entityId);
			return $res;
		}
		
	}
	
	
	

	
	if(! function_exists('getSubString')){
		function getSubString($string='', $length=0)  //file name passed
		{
			if(!empty($string)){
				$strlrn=strlen($string);
				if($strlrn > $length){
					//$string = substr($string, 0, $length).'...';
					$string = join("", array_slice( preg_split("//u", $string, -1, PREG_SPLIT_NO_EMPTY), 0, $length));
					$string = $string.'...';
				}
				
							}
			return $string;
		}
		
	}
	
	
	if(! function_exists('getContactUserProfileImage')){
		function getContactUserProfileImage($emailId)  //file name passed
		{
			$CI =& get_instance();
			$checkForUserContactEmail = $CI->lib_message_center->checkForUserContactEmail($emailId);
			
			if(count($checkForUserContactEmail) > 0)
			{
				$data['UserContactId'] = $checkForUserContactEmail['0']->tdsUid;
				$checkForProfileImage = $CI->lib_message_center->checkForProfileImage($data['UserContactId']);
				if(isset($checkForStockImage['0']->stockImgPath) && isset($checkForStockImage['0']->stockImageId) && isset($checkForStockImage['0']->stockFilename) && $checkForProfileImage['0']->profileImageName == "")
				{
					$checkForStockImage = $CI->lib_message_center->checkForstockImage($checkForProfileImage['0']->stockImageId);	
					$data['ContactUserProfileImage'] = $checkForStockImage['0']->stockImgPath."/".$checkForStockImage['0']->stockFilename;									
				}
				else
				{
					$data['ContactUserProfileImage'] ="media/".$checkForUserContactEmail['0']->username."/profile_image/".$checkForProfileImage['0']->profileImageName;
				}
				
				if(!file_exists($data['ContactUserProfileImage']))$data['ContactUserProfileImage'] = '';
			}
			else
			{
				$data['UserContactId'] = "0";
				$data['ContactUserProfileImage'] = "";
			}
			
			return $data;
		}
		
	}
	
	
	if(! function_exists('getUserRecordforNext')){
		function getUserRecordforNext($contId)  //file name passed
		{
			$CI =& get_instance();
			$checkForNextUserDetail = $CI->lib_message_center->getnextUserValuesFromDB($contId);
			
				return $checkForNextUserDetail;
			
		}
		
	}
	
	if(! function_exists('getUserRecordforPrev')){
		function getUserRecordforPrev($contId)  //file name passed
		{
			$CI =& get_instance();
			$checkForPrevUserDetail = $CI->lib_message_center->getpreviousUserValuesFromDB($contId);
			return $checkForPrevUserDetail;
		}
	}
	
	
	 //-------------------------------------------------------------------------------------------------
	// get folder size
	//
	// input parameter (string $dirname directory name)
	// return $dirname folder size in bytes
	//
	// usage example : getFolderSize("myFolder");
	//
	// author: Sushil Mishra (www.toadsquare.com.com)
	//-------------------------------------------------------------------------------------------------
	if(! function_exists('getFolderSize')){	
		function getFolderSize($dirname='') {
			// open the directory, if the script cannot open the directory then return folderSize = 0
			$folderSize=0;
			if(!is_dir($dirname)){
				return $folderSize;
			}
			$dir_handle = opendir($dirname);
			if (!$dir_handle) return 0;

			// traversal for every entry in the directory
			while ($file = readdir($dir_handle)){

				// ignore '.' and '..' directory
				if  ($file  !=  "."  &&  $file  !=  "..")  {

					// if entry is directory then go recursive !
					if  (is_dir($dirname."/".$file)){
						
						if($file != 'converted'){
							  $folderSize += getFolderSize($dirname.DIRECTORY_SEPARATOR.$file);
						}

					// if file then accumulate the size
					} else {
						  $folderSize += filesize($dirname."/".$file);
					}
				}
			}
			// chose the directory
			closedir($dir_handle);
			// return $dirname folder size
			
			return $folderSize ;
		}
	}
	
	if(! function_exists('bytestoMB')){	
		function bytestoMB($size=0,$sizeUnit='mb'){
			
		$size = is_numeric($size) ? $size : 0;	
		
				if($size > 0){
					
				//	$size=($sizeUnit == 'kb')?number_format(($size/1024),2,'.',''):($sizeUnit == 'mb'?number_format(($size/1048576),2,'.',''):($sizeUnit == 'gb'?number_format(($size/1073741824),2,'.',''):$size));
					
					switch($sizeUnit){
						
						case 'kb':
						  $size =(number_format(($size/1024),2,'.','') - 0);					
				         break;
				         
				         case 'mb':
						  $size = (number_format(($size/1048576),2,'.','') - 0);					
				         break;
				         
				         case 'gb':
						  $size = ( number_format(($size/1073741824),2,'.','') - 0);					
				         break;				
				
						default:
							$size;
						break;	
					}			
					
				}
				return $size;
		}
	}
	
	//------------------------------------------------------------------------------------
	
	/*
	 * @access: public
	 * @description: This function is used to convert mb, gb into bytes 
	 * @retrun size
	 */ 
	
	
	if(! function_exists('mbToBytes')){	
		function mbToBytes($size=0,$sizeUnit='bytes'){
			
			$size = is_numeric($size) ? $size : 0;
				
				if($size > 0){
					
					//$size=($sizeUnit == 'kb')?(int)($size*1024):($sizeUnit == 'mb'?(int)($size*1048576):($sizeUnit == 'gb'?(int)($size*1073741824):$size));
					
					switch($sizeUnit){
						
						case 'kb':
						  $size = ($size*1024);					
				         break;
				         
				         case 'mb':
						  $size = ($size*1048576);					
				         break;
				         
				         case 'gb':
						  $size = ($size*1073741824);					
				         break;				
				
						default:
							$size;
						break;						
						
					}
					
				}
				return $size;
		}
	}
        
    //----------------------------------------------------------------------
    
    /*
     * @Description: This function is use to calculate price of package container
     * @param: usedSpaceSize
     * @return: interger
     */ 
    
    if(! function_exists('packageContainerPrice')){
        function packageContainerPrice($usedSpaceSize="0"){
            $CI =& get_instance();
            $containerDefaultSize  =  $CI->config->item('defaultContainerStorageSpace_Byets');
            $isExtraSpace          =  false;
            $usedExtraSpace        =  '0';
            $usedExtraSpacePrice   =  '0';
            if(!empty($usedSpaceSize)){
                
                //check used space is greater then 100 mb default container space
                if($usedSpaceSize > $containerDefaultSize){
                    $isExtraSpace           =   true;
                    $usedExtraSpace         =   $usedSpaceSize  -  $containerDefaultSize;
                    $usedSpaceSizeInMB      =   bytestoMB($usedExtraSpace,'mb');
                    $roundExtraSpace        =   roundNearestHundredUp($usedSpaceSizeInMB);
                    $sizeInNumber           =   ($roundExtraSpace/100);
                    $usedExtraSpacePrice    =   $sizeInNumber * 0.8;
                }
            }
            return array('isExtraSpace'=>$isExtraSpace,'usedExtraSpace'=>$usedExtraSpace,'usedExtraSpacePrice'=>$usedExtraSpacePrice);
        }
    }
    
    //----------------------------------------------------------------------
    
    /*
    * @Description: This function is use to round 100 neareset any number
    * @param: number
    * @return: interger
    */ 
    
    if(! function_exists('roundNearestHundredUp')){
        function roundNearestHundredUp($number="0"){
            return ceil( $number / 100 ) * 100;
       }
    }    
		
	//Created by vikas to show updated first name of user for welcome text 

	function LoginUserDetailsUpdated($field='username'){
		return LoginUserDetails($field);
	}
			
	//Added by gurutva			
	FUNCTION getTimeDiff($dtime,$atime){
		 $nextDay=$dtime>$atime?1:0;
		 $dep=EXPLODE(':',$dtime);
		 $arr=EXPLODE(':',$atime);
		 $diff=ABS(MKTIME($dep[0],$dep[1],0,DATE('n'),DATE('j'),DATE('y'))-MKTIME($arr[0],$arr[1],0,DATE('n'),DATE('j')+$nextDay,DATE('y')));
		 $hours=FLOOR($diff/(60*60));
		 $mins=FLOOR(($diff-($hours*60*60))/(60));
		 $secs=FLOOR(($diff-(($hours*60*60)+($mins*60))));
		 IF(STRLEN($hours)<2){$hours="0".$hours;}
		 IF(STRLEN($mins)<2){$mins="0".$mins;}
		 IF(STRLEN($secs)<2){$secs="0".$secs;}
		 RETURN $hours.':'.$mins.':'.$secs;
	}
	
	if(! function_exists('zoneCountries')){	
		function zoneCountries($countriesId=''){
				$countriesId=trim($countriesId);
				$countriesString='';
				if(!empty($countriesId) && $countriesId != null){
					$countriesId = explode('|',$countriesId);
					$countriesId=array_diff($countriesId, array('',null));
					
					
					
					if($countriesId && is_array($countriesId) && count($countriesId)>0 ){
						if(isset($countriesId[0]) && !($countriesId[0] > 0)){
							$countriesId[0]=0;
						}
						$CI =&get_instance();
						// Change in parameter - added by Sapna Jain on 20-03-2012 - for country's Ordered list
						
						$res =  $CI->model_common->getDataFromTabelWhereIn($table='MasterCountry', $field='countryName',  $whereField='countryId', $whereValue=$countriesId, $orderBy='countryName', $order='ASC', $whereNotIn=0);
						if($res){
							$countriesString='';
							$count=count($res);
							foreach($res as $k=>$country){
								$countriesString.=$country['countryName'];
								if($k < ($count-1)){
									$countriesString.=', ';
								}
							}
						}
					}
				}
				
				
				return $countriesString;
		}
	}
	
	// recursive search for key in nested array, also search in objects!!
	// returns: array with "values" for the searched "key"
	function search_nested_arrays($array, $key){
		
		if(is_object($array))
			$array = (array)$array;
	   
		// search for the key
		$result = array();
		foreach ($array as $k => $value) {
			if(is_array($value) || is_object($value)){
				$r = search_nested_arrays($value, $key);
				if(!is_null($r))
					array_push($result,$r);
			}
		}
	   
		if(array_key_exists($key, $array))
			array_push($result,$array[$key]);
	   
	   
		if(count($result) > 0){
			// resolve nested arrays
			$result_plain = array();
			foreach ($result as $k => $value) {
				if(is_array($value))
					$result_plain = array_merge($result_plain,$value);
				else
					array_push($result_plain,$value);
			}
			return $result_plain;
		}
		return NULL;
	}
	
	function roundRatingValue($value){

		$decimal = ($value - floor($value));
		$addvalue = 0;

		if($decimal > 0 ) {
			if($decimal >= 0.3 && $decimal < 0.8){
				$addvalue = 0.5;	
			}
			if($decimal > 0.7) {
				$addvalue = 1;	
			}
		}
		$roundValue = (floor($value) + $addvalue);
		return $roundValue;
	}
	

	function removeSpacialChar($string){
		$string=preg_replace('#[^\w-]#',"",$string);
		return $string;
	}
	


	function addThumbFolder($imagePath,$suffix='_s',$thumbFolder ='thumb',$defaultThumb='')
	{
        //if crop_thumb folder image not exist then use thumb folder image [added by lokendra]
        if($thumbFolder=="crop_thumb"){
            $imageInfo = pathinfo($imagePath);
            $ImageName =$imageInfo['basename'];
            $ImageName =$imageInfo['dirname'].DIRECTORY_SEPARATOR.$thumbFolder.DIRECTORY_SEPARATOR.$ImageName;
            if(!is_file($ImageName)){
                $thumbFolder ='thumb';
                $suffix      = '_s';
            }
        }
        
		if(is_file($imagePath)){
		   $imageInfo = pathinfo($imagePath);
		   $ImageName=$imageInfo['filename'];
		   $ImageName=$imageInfo['dirname'].DIRECTORY_SEPARATOR.$thumbFolder.DIRECTORY_SEPARATOR.$ImageName.$suffix.'.'.$imageInfo['extension'];
		   if(is_file($ImageName)){
			   $imagePath=$ImageName;
			}
	    }elseif($defaultThumb !=''){
			$imagePath=$defaultThumb;
		}
		return $imagePath;
	}
	
	/*
	 *****************************
	 * This function is used to get converted video thumb image 
	 ***************************** 
	 */  
	 
	 
	function getVideoThumbFolder($imagePath,$suffix='_s',$thumbFolder ='thumb',$defaultThumb='') {
		if(is_file($imagePath)){
		   $imageInfo = pathinfo($imagePath);
		   $ImageName=$imageInfo['filename'];
		   $ImageName=$imageInfo['dirname'].DIRECTORY_SEPARATOR.$thumbFolder.DIRECTORY_SEPARATOR.$ImageName.$suffix.'.jpg';
		   if(is_file($ImageName)){
			   $imagePath=$ImageName;
			}else{
				$imagePath=$defaultThumb;
			}
	    }elseif($defaultThumb !=''){
			$imagePath=$defaultThumb;
		}
		return $imagePath;
	}
	
	function getUserShowcaseId($userId=0){
		$res=getDataFromTabel('UserShowcase','*', array('tdsUid'=>$userId,'isArchive'=>'f'), '', '', '',1 );
		if($res){
			return $res[0];
		}else{
				return false;
		}
	}
	
	function getMeetingPointUserId($sessionId=0,$userId=0){
		
		$CI = &get_instance();
		
		$MeetingPoint = $CI->db->dbprefix('MeetingPoint');		
		$whereMeetingPoint = array('session_id'=>$sessionId);		
		$resUsers = getDataFromTabel($MeetingPoint,'id,user_id,is_at_meeting_place', $whereMeetingPoint);
		
		foreach($resUsers as $k =>$userId){
			
		$res =  $CI->model_common->getUserDetails($userId->user_id);
		
		
		
		if($res)
			{
				$stockImgId=$res[0]->stockImageId;
				$userFullName = $res[0]->firstName.' '.$res[0]->lastName;
				$userArea = $res[0]->optionAreaName;
				if($stockImgId)
				{
					$userImage=$res[0]->stockImgPath.DIRECTORY_SEPARATOR.$res[0]->stockFilename;					
				}
				else
				{
					$userImage=$res[0]->profileImageName;	
				}
			$userInfo[$k]['associatedProfessional'] = $res[0]->associatedProfessional;
			$userInfo[$k]['enterprise'] = $res[0]->enterprise;
			$userInfo[$k]['creative'] = $res[0]->creative;
			$userInfo[$k]['enterpriseName'] = $res[0]->enterpriseName;
			$userInfo[$k]['username'] = $res[0]->username;
			$userInfo[$k]['userFullName'] = $userFullName;
			$userInfo[$k]['userImage'] = $userImage;
			$userInfo[$k]['userArea'] = $userArea;
			$userInfo[$k]['id'] = $userId->id;
			$userInfo[$k]['user_id'] = $userId->user_id;
			$userInfo[$k]['is_at_meeting_place'] = $userId->is_at_meeting_place;
			}
			
		}
		
		//echo 'Last Query:'.$CI->db->last_query();die;
		if($userInfo){
			return $userInfo;
		}else{
				return false;
		}
		
	}

	
	
	/* Get Next & Previous Tmail in popup secton */
	
	if(! function_exists('getUserNextTmail')){
		function getUserNextTmail($contId,$uId,$type)  //file name passed
		{
			$CI =& get_instance();
			$checkForNextUserDetail = $CI->model_tmail->getnexTmail($contId,$uId,$type);
			
			return $checkForNextUserDetail;
			
		}
		
	}
	
	if(! function_exists('getUserPrevTmail')){
		function getUserPrevTmail($contId,$uId,$type)  //file name passed
		{
			$CI =& get_instance();
			$checkForNextUserDetail = $CI->model_tmail->getprevTmail($contId,$uId,$type);
			
			return $checkForNextUserDetail;
		}
	}
	
	if(! function_exists('getConvertedFile')){
		function getConvertedFile($file,$convertedExt='.mp4',$convertDir ='converted')
		{
			if(is_file($file)){
			   $fileInfo = pathinfo($file);
			   $fileName=$fileInfo['filename'];
			   $fileName=$fileInfo['dirname'].DIRECTORY_SEPARATOR.$convertDir.DIRECTORY_SEPARATOR.$fileName.$convertedExt;
			   if(is_file($fileName)){
				   $file=$fileName;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
	}
	
	/* Function to add http in url */
	
	if(! function_exists('addhttp')){
		function addhttp($url) {
			if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
				$url = "http://" . $url;
			}
			return  $url;
		}
      }
      
     if(! function_exists('showProjectDetails')){
		function showProjectDetails($where='') {
			$result=false;
			if(is_array($where) && count($where) > 0){
				$CI = &get_instance();
				$res=getDataFromTabel($table='ShowProject', 'entityid,elementid',  $where, '','','',  $limit=1 );
				if($res){
					$res=$res[0];
					$entityid=$res->entityid;
					$elementid=$res->elementid;
					
					$whereCondition=array('entityid'=>$entityid,'elementid'=>$elementid);
					$result=getDataFromTabel($table='search', '(item).title,(item).userid,sectionid,section,entityid,elementid',  $whereCondition, '','','',  $limit=1 );
					if($result){
						$result=$result[0];
						if($result->section='upcoming'){
							switch ($result->sectionid) {
								case 1:
									$section='filmNvideo';
									break;
								case 2:
									$section='musicNaudio';
									break;
								case 3:
									$section='writingNpublishing';
									break;
								case 4:
									$section='photographyNart';
									break;
								case 6:
									$section='creatives';
									break;
								case 7:
									$section='associatedprofessionals';
									break;
								case 8:
									$section='enterprises';
									break;
								case 9:
									$section='performances&events';
									break;
								case 10:
									$section='educationMaterial';
									break;
								case 11:
									$section='work';
									break;
								case 12:
									$section='Product';
									break;
								case 13:
									$section='blog';
									break;
								default:
									$section='';
									break;
								
							}
							$result->projectType=$section;
						}else{
							$result->projectType=$result->section;
						}
					}
				}
			}
			return $result;
		}
      }
	if(! function_exists('multiArraySort')){   
		function multiArraySort($array=array(), $key) {
			$sorter=array();
			$ret=array();
			reset($array);
			foreach ($array as $ii => $va) {
				$sorter[$ii]=$va[$key];
			}
			asort($sorter);
			foreach ($sorter as $ii => $va) {
				$ret[$ii]=$array[$ii];
			}
			$array=$ret;
			return $array;
		}
	}
	if(! function_exists('getUrl')){   
		function getUrl($url='') {
			$returnUrl=false;
			if($url!=''){
				if(filter_var($url, FILTER_VALIDATE_URL) === FALSE){
					$urlArray=explode('src="',$url);
					if(!count($urlArray) > 1){
						$urlArray=explode("src='",$url);
					}
					if(isset($urlArray[1])){
						$urlArray=explode('"',$urlArray[1]);
						if(!count($urlArray) > 1){
							$urlArray=explode("'",$urlArray[1]);
						}
						if(isset($urlArray[0])){
							$url=$urlArray[0];
							if(filter_var($url, FILTER_VALIDATE_URL) === FALSE){
								$returnUrl=false;
							}else{
								$returnUrl=$url;
							}
						}
					}
				}else{
					$returnUrl=$url;
					
				}
			}
			return $returnUrl;
		}
	}
	/*
	 *************************
	 * This function is used to check external image if exist otherwise return default image
	 ************************* 
	 */  
	 
	 
	if(! function_exists('getMediaUrl')){   
		
		function checkExternalImage($imgUrl='',$imgSize='_s'){
				$CI = &get_instance();
				$imagetype='images/default_thumb/photography_art.jpg';
				$isImageExist=true;
				if(!empty($imgUrl)){
					$imgUrl = getUrl($imgUrl);
                   
					if($imgUrl){
						if(@getimagesize($imgUrl)){
							$isImageExist=false;
							$projectImage = $imgUrl;
						}
					}
				}		
				//--------if image not exist then show default image---------//
				if($isImageExist){
					$projThumbImage = addThumbFolder('',$imgSize,$imagetype);
					$projectImage = getImage($projThumbImage,$imagetype,1);
				}	
			return $projectImage;
		}	
	}	

	/*
	 *************************************************** 
	 * This code media url if user enter below code 
	 * Like : iframe,object,embed,embeded and src 
	 *************************************************** 
	 */ 
	
	
	if(! function_exists('getMediaUrl')){   
		function getMediaUrl($embedCode='') {
			
			if (strpos($embedCode,'iframe')) {
				
				$getSrc= getUrl($embedCode);
				
				return array('embedtype' =>'iframe','getsource' =>$getSrc,'isUrl' =>false);
		
			}else
			{
				if (strpos($embedCode,'object')) {
				
				return array('embedtype' =>'embed','getsource' =>$embedCode,'isUrl' =>false);
				
				
				}else
				{
					if (strpos($embedCode,'embed')) {
						
						$getEmbedUrl = getEmbedUrl($embedCode);
						if($getEmbedUrl['isValid'])
						{
							return array('embedtype' =>'iframe','getsource' =>$getEmbedUrl['src'],'isUrl' =>false);
							
						}else
						{
							return array('embedtype' =>'embed','getsource' =>$embedCode,'isUrl' =>false);
						}
					
					}else
					{
						if (strpos($embedCode,'embeded')) {
				
						return array('embedtype' =>'embed','getsource' =>$embedCode,'isUrl' =>false);
						
						}else
						{
							
							$getEmbedUrl = getEmbedUrl($embedCode);
							if($getEmbedUrl['isValid'])
							{
								return array('embedtype' =>'iframe','getsource' =>$getEmbedUrl['src'],'isUrl' =>false);
								
							}else
							{
								return array('isUrl' =>true);
							}
						}
					}
				}
			}
		}
	}
	
	
	if(! function_exists('getMediaImageUrl')){   
		function getMediaImageUrl($embedCode='') {
			
			
			if (strpos($embedCode,'iframe')) {
				
				$getSrc= getUrl($embedCode);
				
				return array('embedtype' =>'iframe','getsource' =>$getSrc);
		
			}else
			{
				if (strpos($embedCode,'object')) {
				
				return array('embedtype' =>'embed','getsource' =>$embedCode);
				
				
				}else
				{
					if (strpos($embedCode,'embed')) {
				
					return array('embedtype' =>'embed','getsource' =>$embedCode);
					
					}else
					{
						if (strpos($embedCode,'embeded')) {
				
						return array('embedtype' =>'embed','getsource' =>$embedCode);
						
						}else
						{ 
							if (strpos($embedCode,'img')) {
								
								$getSrc= getUrl($embedCode);
								
								return array('embedtype' =>'image','getsource' =>$getSrc);
						
							}else
							{
								$getSrc= getUrl($embedCode);
								if($getSrc==false)
								{
									return false;	
								}else
								{
									return array('embedtype' =>'image','getsource' =>$getSrc);
								}
								
								
							}
						}
					}
				}
			}
			
		}
	}
	
	
	
	if(! function_exists('isShowcaseCreated')){   
		function isShowcaseCreated($href='', $linkTitle='', $userNavigations='') {
			$returnUrl=false;
			if(isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'enterprises', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'associatedprofessionals', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'creatives', $userNavigations, $key='section', $is_object=0 ))){ 
				$href=base_url(lang().DIRECTORY_SEPARATOR.$href);
			}else{
				$CI = &get_instance();
				$create_showcase_popup=$CI->load->view('dashboard/create_showcase_popup','',true);
				$create_showcase_popup=json_encode($create_showcase_popup);
				echo '<script>var create_showcase_popup='.$create_showcase_popup.';</script>';
				$href="javascript:loadPopupData('popupBoxWp','popup_box',create_showcase_popup);";
			}
			return "<a href=\"$href\">$linkTitle</a>";
		}
	}
	
	if(! function_exists('userNavigations')){   
		function userNavigations($userId=0,$publishCheck=true, $sectionIn='') {
			$CI = &get_instance();
			$userNavigations=$CI->model_common->userNavigations($userId,$publishCheck, $sectionIn);
			return $userNavigations;
		}
	}
	
	
function applyImageWaterMark($img_path, $watermark_path="images/watermark.png", $copy_path) {
	$watermark_path=base_url("images/watermark.png");
	$imageSize = getimagesize($img_path);
	// Determine type
	$image_type = $imageSize[2]; // 1 = GIF, 2 = JPG, 3 = PNG
	$image = ImageCreateFromType($image_type, $img_path);
	ImageCreateFromType($image_type, $img_path);
	$watermark = imagecreatefrompng($watermark_path);

	$watermark_o_width = imagesx($watermark);
	$watermark_o_height = imagesy($watermark);

	$newWatermarkWidth = $imageSize[0]-20;
	$newWatermarkHeight = $watermark_o_height * $newWatermarkWidth / $watermark_o_width;

	imagecopyresized($image, $watermark, $imageSize[0]/2 - $newWatermarkWidth/2, $imageSize[1]/2 - $newWatermarkHeight/2, 0, 0, $newWatermarkWidth, $newWatermarkHeight, imagesx($watermark), imagesy($watermark));

	ImageSaveAs($image_type, $image, $copy_path);

	imagedestroy($image);
	imagedestroy($watermark);
	
}

function ImageCreateFromType($type,$filename) {
	$im = null;
	switch ($type) {
		case 1:
			$im = ImageCreateFromGif($filename);
			break;
		case 2:
			$im = ImageCreateFromJpeg($filename);
			break;
		case 3:
			$im = ImageCreateFromPNG($filename);
			break;
		default:
			$im = ImageCreateFromJpeg($filename);
			break;
	}
	return $im;
}

function ImageSaveAs ($type,$image,$destination) {
	switch ($type) {
		case 1:
			imagegif($image, $destination);
			break;
		case 2:
			imagejpeg($image, $destination,100);
			break;
		case 3:
			imagepng($image, $destination, 9);
			break;
		default:
			imagejpeg($image, $destination,100);
		break;
	}
}

function toadsquare_site_block_linkify_twitter_status($status_text) {
  // linkify URLs
  
  $status_text = preg_replace(
    '/(https?:\/\/\S+)/',
    '<a href="\1" class="preg-links ptr" target="_blank">\1</a>',
    $status_text
  );
 
  // linkify twitter users
  $status_text = preg_replace(
    '/(^|\s)@(\w+)/',
    '\1@<a href="http://twitter.com/\2" class="preg-links ptr"  target="_blank">\2</a>',
    $status_text
  );
 
  // linkify tags
  $status_text = preg_replace(
    '/(^|\s)#(\w+)/',
    '\1#<a href="http://search.twitter.com/search?q=%23\2" class="preg-links ptr"  target="_blank">\2</a>',
    $status_text
  );
 
  return getSubString($status_text,125);
}
if(! function_exists('userNavigations')){   
	function userNavigations($userId=0,$publishCheck=true, $sectionIn='')
	{
		if ($userId > 0){
			$CI = &get_instance();
		   return $CI->model_common->userNavigations($userId,$publishCheck, $sectionIn);
		} else{
			return false;
		}
	}
}
if(! function_exists('getDisplayPrice')){   
	function getDisplayPrice($price=0,$currency=0)
	{
		$CI = &get_instance();
		$price=($price > 0)?$price:0;
		$currency=($currency > 0)?$currency:0;
		$currencySign=$CI->config->item('currency'.$currency);
		$minimumComission=$CI->config->item('minimumComission'.$currency);
		$commisionPercentage=$CI->config->item('commisionPercentage');
		
		$VATpercentage=$CI->config->item('VATpercentage');
		
		$commisionOnPrice=(($price * $commisionPercentage)/100);
		$commisionOnPrice=($commisionOnPrice > $minimumComission)?$commisionOnPrice:$minimumComission;
		
		$VATCharge=(($commisionOnPrice * $VATpercentage)/100);
		$VATCharge=$price>0?$VATCharge:0;
		
		//$totalCommision=($commisionOnPrice+$VATCharge); // commented because as client requirements: VAT Charge should not add in commision
		
		$totalCommision=$commisionOnPrice;		
		$totalCommision=$price>0?$totalCommision:0;
		
		$displayPrice=($price+$totalCommision);
		$displayPrice=$price>0?$displayPrice:0;
		$commisionOnPrice=number_format($commisionOnPrice,2,'.','');
		$displayPrice=number_format($displayPrice,2,'.','');
		$totalCommision=number_format($totalCommision,2,'.','');
		$VATCharge=number_format($VATCharge,2,'.','');
		$priceArray=array(
							'currencySign'=>$currencySign,
							'minimumComission'=>$minimumComission,
							'commisionPercentage'=>$commisionPercentage,
							'VATpercentage'=>$VATpercentage,
							'price'=>$price,
							'commisionOnPrice'=>$commisionOnPrice,
							'VATCharge'=>$VATCharge,
							'totalCommision'=>$totalCommision,
							'displayPrice'=>$displayPrice
					);
		return $priceArray;
	}
}

function numbersList($startFrom=0, $Upto=120, $interval=1){
	$numbers =array();
	for($i=$startFrom; $i<=$Upto; $i=($i+$interval)){
		$val=($i<10)?sprintf ("%02u", $i):$i;
		$numbers[$val]=$val;
	}
	return $numbers;
}


/* Get Space associated with products */
if(! function_exists('getAssociatedSpace')){
	function getAssociatedSpace($id) {	
		$CI = &get_instance();
		$details=$CI->model_membershipcart->getAssociatedSpace($id);
		return $details;
		}
}

/*Get Full Media File Path*/
function getFullMediaPath($getMediaPathData)
{
	$file_name = explode('.',$getMediaPathData['fileName']);
	$file_name[count($file_name)-1] = 'mp3';
	$fileName = implode('.',$file_name);
	$getfileName = str_replace('.mp3','_preview.mp3',$fileName);
	
	// remove /media form file path
	$filePath = explode('/',$getMediaPathData['filePath']); 
	unset($filePath[0]);
	
		// add new fodler name for converted media files 
	$filePath[] = 'converted';
	
	foreach($filePath as $key => $value) if($value =='') {unset($filePath[$key]);}
	$getMediaPath = '/'.implode('/',$filePath);
		 
	$fullFilePath =  $getMediaPath.DIRECTORY_SEPARATOR.$getfileName;
	
	return $fullFilePath;
}

 

/* Get Space associated with products */
if(!function_exists('getConsumptionTax')){
	function getConsumptionTax($id) {		
		//$id = 85;	
		$CI = &get_instance();
		$res=$CI->model_common->getDataFromTabel('MasterCountry', 'vatPercentage',  'countryId',134,'','','',1);
		
		$vatCharge = $res[0]->vatPercentage;		
		//$vatCharge = $CI->config->item('VATpercentage');
		$currentBilling=$CI->model_membershipcart->getBillingDetails();
		if(isset($currentBilling->billingdetails) && ($currentBilling->billingdetails!=''))
		  $currentUserbilling= json_decode($currentBilling->billingdetails);
		//print_r($currentUserbilling);die;
		if(isset($currentUserbilling) && !empty($currentUserbilling) ){

				$VatIdentificationNumber = $currentUserbilling->EuVatIdentificationNumber;
				$buyerBillingCountry = $currentUserbilling->billing_country;
				if (($VatIdentificationNumber!='') && strlen($VatIdentificationNumber)>=2 && strlen($VatIdentificationNumber)<=12 ) {				  
				        $VatIdentificationNumber = $VatIdentificationNumber;				  
				}else {
				       $VatIdentificationNumber = '' ;
				}			    

             //  echo $currentUserbilling->countryGroup.'---'.$VatIdentificationNumber.'--'.$buyerBillingCountry;die;


				if(($currentUserbilling->countryGroup=='EU') && ($VatIdentificationNumber=='') ){ 				   
				        return $vatCharge; 
				}elseif(($currentUserbilling->countryGroup=='EU') && ($buyerBillingCountry==134)) {
				          return $vatCharge;	
				}else {
				       return 0;
				}

		} else{				

			$billingDetail=$CI->model_membershipcart->getUserBillingDetails($id);
			
			if(isset($billingDetail) && !empty($billingDetail) ){

				$VatIdentificationNumber = $billingDetail->EuVatIdentificationNumber;
				$buyerBillingCountry = $billingDetail->billing_country;

				if (($VatIdentificationNumber!='') && strlen($VatIdentificationNumber)>=2 && strlen($VatIdentificationNumber)<=12 ) {				  
				       $VatIdentificationNumber = $VatIdentificationNumber;				  
				}else {
				       $VatIdentificationNumber = '' ;
				}			    
   
								
				if(($billingDetail->countryGroup=='EU') && ($VatIdentificationNumber=='') ){ 				   
				        return $vatCharge; 
				}elseif(($billingDetail->countryGroup=='EU') && ($buyerBillingCountry==134)) {
				          return $vatCharge;	
				}else {
				       return 0;
				}
				
			}
		}		
	}
}


function getImagesFromDir($path) {
    
$newImageList= $images = array();
$rand_image='';
	if(is_dir($path))
	{
		$imgList = glob($path.'/*.*');
	
		foreach($imgList as $file){
		if( preg_match("/\.(jpg|jpeg|gif|bmp|png)$/i", $file)) $newImageList[]=$file;
		}
		if(count($newImageList) >0 ){
		$randomImageNumber = array_rand($newImageList);
		$parts = pathinfo($newImageList[$randomImageNumber]);
		$rand_image = $parts['filename'].'.'.$parts['extension'];
	}
	}
	return $rand_image;
 
}

function getPreviousOrFututrDate($date='', $interval='-1 month' ,$format='Y-m-d H:i:s'){	
	
	if($date == ''){
		$date=date($format);
	}
	
	$date = new DateTime($date);
	$date->modify($interval);
	return $date->format($format);
	
}


if(! function_exists('getSelectedTools')){
	function getSelectedTools($cartId,$ProductId){
		$CI = &get_instance();
		$details=$CI->model_membershipcart->getSelectedTools($cartId,$ProductId);
		return $details;	
	}
}
  
 
 // Get Associated Space checked by user on update 
  if(! function_exists('isExtraSpaceChecked')){		
	 function isExtraSpaceChecked($parentId,$ProductId){
		$CI = &get_instance();
		$details=$CI->model_membershipcart->isExtraSpaceChecked($parentId,$ProductId);
		return $details;	 
		 }
   }
   
   
  // Get Sum of price 
  if(! function_exists('getTotalPrice')){		
	 function getTotalPrice($cartId,$field,$sum){
		$CI = &get_instance();
		$details=$CI->model_membershipcart->getTotalPrice($cartId,$field,$sum);
		return $details;	 
		 }	

   } 
   
   
    // Get Sum of price 
  if(! function_exists('isReviewProject')){		
	 function isReviewProject($Id){
		$CI = &get_instance();
		$details=$CI->model_common->isReviewProjects($Id);		
		return $details;
	 }	
   }
   
   /*
   * Function to Check and Update view count
   */ 
	function manageViewCount($entityId=0,$elementId=0,$viewUser=0,$projectId=0,$sectionId=0){
	
	   $userId = isLoginUser();
	   if(isset($userId)){
			$loggedUserId = $userId;
		}else{
			$loggedUserId = 0;
		}
		
		$CI = &get_instance();
		$CI->load->helper('cookie');
		
		if((!empty($viewUser)) && ($projectId==0)) {
			$pageView = DIRECTORY_SEPARATOR.$viewUser.DIRECTORY_SEPARATOR.$entityId.DIRECTORY_SEPARATOR.$elementId;
		}
		elseif((!empty($viewUser)) && (isset($projectId)) && (!empty($elementId))){
			//$entityId = $CI->model_common->get_entity_id($projectId,$elementId);
			$pageView = $viewUser.DIRECTORY_SEPARATOR.$entityId.DIRECTORY_SEPARATOR.$elementId.DIRECTORY_SEPARATOR.$projectId;
		}
		else{
			$pageView = '';
		}
		$session_id = $CI->session->userdata('session_id');
		$checkSessionString = $loggedUserId.'_'.$pageView;
		
		$cookieName = 'userSession_'.$loggedUserId.$pageView;
		$userCookieId = get_cookie($cookieName); 
		
		/*Get IP address*/
		$remoteAddress = $_SERVER['REMOTE_ADDR'];
		//echo "entityId===>".$entityId;
		//echo "elementId===>".$elementId;die;
		/*Check View project for today*/
	 	$checkProjectView = $CI->model_common->check_project_view($entityId,$elementId,$projectId,$sectionId,$loggedUserId,$remoteAddress);
	 	
		if($checkProjectView==0)
		{
			if($remoteAddress!='127.0.0.1'){
				/*If not match cookie strings view count increses*/
				//if($userCookieId !== $checkSessionString){
					$CI->session->set_userdata('check_session_view_data',$checkSessionString);
							
					$cookieUserSession = array(
					'name'   => $cookieName,
					'value'  => $checkSessionString,
					'expire' => time()+1000,
					'path'   => '/',
					'secure' => false
					);				
					set_cookie($cookieUserSession);		
					
					if((isset($entityId)) && (isset($elementId))) {
						$viewCount = $CI->model_common->get_view_count($entityId,$elementId);	
						$viewCountSum = $viewCount+1;
						
						//Update view count
						$data = array(
							'viewCount' => $viewCountSum,
						);
						
						/*Check data present in log summery or not*/
						$entity_tableName = getMasterTableName($entityId);
						$tableName= $entity_tableName[0];
						addDataIntoLogSummary($tableName,$elementId);
						
						/*Add view count in View log*/
						$viewData['tdsUid'] = $loggedUserId;
						$viewData['projId'] = $projectId;
						$viewData['elementId'] = $elementId;
						$viewData['entityId'] = $entityId;
						$viewData['sectionId'] = $sectionId;
						$viewData['IP'] = $remoteAddress;
						$CI->model_common->add_project_view($viewData);
						
						/*Update Log summery view count*/
						$CI->model_common->update_view_count($data,$entityId,$elementId);				
					}
				//}
			}
		}
	}

   if(! function_exists('isAnyItemBlocked')){		
		function isAnyItemBlocked($items='',$isObject=false){
			$isAnyItemBlocked=false;
			if(is_array($items) && count($items) > 0){
				foreach($items as $key=>$item){
					if($isObject){
						$isBlocked=$item->isBlocked;
					}else{
						$isBlocked=$item['isBlocked'];
					}
					if($isBlocked=='t'){
						$isAnyItemBlocked=true;
						break;
					}
				}
			}
			return $isAnyItemBlocked;
		}	
   } 
   

   if(! function_exists('topCraved')){		
		function topCraved($topCravedArray){
			$CI = &get_instance();
			if(isset($topCravedArray) && is_array($topCravedArray) && count($topCravedArray)>0){
				
				$TDS_UserShowcase = $CI->db->dbprefix('UserShowcase');
				$TDS_LogSummary = $CI->db->dbprefix('LogSummary');
				$TDS_LogCrave = $CI->db->dbprefix('LogCrave');
				$TDS_StockImages = $CI->db->dbprefix('StockImages');
				$TDS_MediaFile = $CI->db->dbprefix('MediaFile');
				$TDS_Project = $CI->db->dbprefix('Project');
				$TDS_Events = $CI->db->dbprefix('Events');
				$TDS_Work = $CI->db->dbprefix('Work');
				$TDS_Product = $CI->db->dbprefix('Product');
				$TDS_ProductPromotionMedia = $CI->db->dbprefix('ProductPromotionMedia');
				$TDS_workPromotionMedia = $CI->db->dbprefix('workPromotionMedia');
				$TDS_Blog = $CI->db->dbprefix('Blogs');
				$TDS_Posts = $CI->db->dbprefix('Posts');
				
				switch ($topCravedArray['projectType']) {
					case "creatives":
					case "enterprises":
					case "associatedprofessionals":
						$topCraveQuery = 'SELECT "'.$TDS_UserShowcase.'"."showcaseId","'.$TDS_UserShowcase.'"."tdsUid", "'.$TDS_UserShowcase.'"."creativeFocus", "'.$TDS_LogSummary.'"."elementId", "'.$TDS_LogSummary.'"."craveCount", "'.$TDS_LogSummary.'"."reviewCount", "'.$TDS_LogSummary.'"."viewCount", "'.$TDS_LogSummary.'"."entityId", "'.$TDS_LogSummary.'"."elementId", "'.$TDS_LogSummary.'"."viewCount" 
						from "TDS_LogCrave" 
												
						left join "'.$TDS_LogSummary.'" on "'.$TDS_LogCrave.'"."entityId"= "'.$TDS_LogSummary.'"."entityId" AND "'.$TDS_LogCrave.'"."elementId"= "'.$TDS_LogSummary.'"."elementId"
						
						left join "'.$TDS_UserShowcase.'" on "'.$TDS_UserShowcase.'"."showcaseId" = "'.$TDS_LogSummary.'"."elementId" where "'.$TDS_LogCrave.'"."entityId" = \''.$topCravedArray['entityId'].'\' AND "'.$TDS_LogCrave.'"."projectType" = \''.$topCravedArray['projectType'].'\'
						order by  "'.$TDS_LogSummary.'"."craveCount" Desc limit 1';
						break;
					case "filmNvideo":
					case "musicNaudio":
					case "photographyNart":
					case "writingNpublishing":
					case "educationMaterial":
					
				
					//case "product":
					//case "blog":
						$topCraveQuery = 'SELECT "'.$TDS_Project.'"."tdsUid","'.$TDS_Project.'"."projId","'.$TDS_Project.'"."projName","'.$TDS_Project.'"."projShortDesc","'.$TDS_Project.'"."projBaseImgPath","'.$TDS_UserShowcase.'"."firstName","'.$TDS_UserShowcase.'"."lastName",
						"'.$TDS_LogSummary.'"."elementId", "'.$TDS_LogSummary.'"."craveCount", "'.$TDS_LogSummary.'"."reviewCount",
						"'.$TDS_LogSummary.'"."viewCount", "'.$TDS_LogSummary.'"."entityId", "'.$TDS_LogSummary.'"."elementId"
						from "TDS_LogCrave" 
												
						left join "'.$TDS_LogSummary.'" on "'.$TDS_LogCrave.'"."entityId"= "'.$TDS_LogSummary.'"."entityId" AND "'.$TDS_LogCrave.'"."elementId"= "'.$TDS_LogSummary.'"."elementId"
						
						left join "'.$TDS_Project.'" on "'.$TDS_Project.'"."projId" = "'.$TDS_LogSummary.'"."elementId" AND "'.$TDS_Project.'"."projectType" = "'.$TDS_LogCrave.'"."projectType" 
						
						left join "'.$TDS_UserShowcase.'" on "'.$TDS_UserShowcase.'"."tdsUid"= "'.$TDS_Project.'"."tdsUid" 
												
						where "'.$TDS_LogCrave.'"."entityId" = \''.$topCravedArray['entityId'].'\'
						AND "'.$TDS_LogCrave.'"."projectType" = \''.$topCravedArray['projectType'].'\'
						AND "'.$TDS_Project.'"."isPublished" = \'t\' 
						AND "'.$TDS_Project.'"."isArchive" = \'f\'
						AND "'.$TDS_Project.'"."isBlocked" = \'f\'
						order by  "'.$TDS_LogSummary.'"."craveCount" Desc limit 1';
						break;
					case "performancesevents":
					
						$currentDateTime = currntDateTime();
						$interval = $CI->config->item('eventShownForExtraDays');
						$eventShownForExtraDays = getPreviousOrFututrDate($currentDateTime, $interval ,$format='Y-m-d H:i:s');	
						
						$topCraveQuery = 'SELECT "'.$TDS_Events.'"."NatureId","'.$TDS_Events.'"."tdsUid","'.$TDS_Events.'"."EventId","'.$TDS_Events.'"."Title","'.$TDS_Events.'"."OneLineDescription","'.$TDS_Events.'"."FileId",
						"'.$TDS_UserShowcase.'"."firstName","'.$TDS_UserShowcase.'"."lastName",
						"'.$TDS_MediaFile.'"."filePath","'.$TDS_MediaFile.'"."fileName",
						"'.$TDS_LogSummary.'"."elementId", "'.$TDS_LogSummary.'"."craveCount", "'.$TDS_LogSummary.'"."reviewCount",
						"'.$TDS_LogSummary.'"."viewCount", "'.$TDS_LogSummary.'"."entityId", "'.$TDS_LogSummary.'"."elementId"
						from "TDS_LogCrave" 
												
						left join "'.$TDS_LogSummary.'" on "'.$TDS_LogCrave.'"."entityId"= "'.$TDS_LogSummary.'"."entityId" AND "'.$TDS_LogCrave.'"."elementId"= "'.$TDS_LogSummary.'"."elementId"
						
						left join "'.$TDS_Events.'" on "'.$TDS_Events.'"."EventId" = "'.$TDS_LogSummary.'"."elementId" 
						
						left join "'.$TDS_MediaFile.'" on "'.$TDS_MediaFile.'"."fileId" = "'.$TDS_Events.'"."FileId" 							
												
						left join "'.$TDS_UserShowcase.'" on "'.$TDS_UserShowcase.'"."tdsUid"= "'.$TDS_Events.'"."tdsUid" 
												
						where "'.$TDS_LogCrave.'"."entityId" = \''.$topCravedArray['entityId'].'\'
						AND "'.$TDS_Events.'"."FinishDate" >= \''.$eventShownForExtraDays.'\'
						AND "'.$TDS_LogCrave.'"."projectType" = \''.$topCravedArray['projectType'].'\'
						AND "'.$TDS_Events.'"."isPublished" = \'t\' 
						AND "'.$TDS_Events.'"."EventArchive" = \'f\'
						AND "'.$TDS_Events.'"."isBlocked" = \'f\'
						order by  "'.$TDS_LogSummary.'"."craveCount" Desc limit 1';
						break;
					case "work":
						$topCraveQuery = 'SELECT "'.$TDS_Work.'"."workId","'.$TDS_Work.'"."tdsUid","'.$TDS_Work.'"."workTitle", "'.$TDS_Work.'"."workType","'.$TDS_Work.'"."workShortDesc",
						
						"'.$TDS_UserShowcase.'"."firstName","'.$TDS_UserShowcase.'"."lastName",
						
						"'.$TDS_MediaFile.'"."filePath","'.$TDS_MediaFile.'"."fileName",
					
						"'.$TDS_LogSummary.'"."elementId", "'.$TDS_LogSummary.'"."craveCount", "'.$TDS_LogSummary.'"."reviewCount",
						
						"'.$TDS_LogSummary.'"."viewCount", "'.$TDS_LogSummary.'"."entityId", "'.$TDS_LogSummary.'"."elementId"
						
						from "TDS_LogCrave" 
												
						left join "'.$TDS_LogSummary.'" on "'.$TDS_LogCrave.'"."entityId"= "'.$TDS_LogSummary.'"."entityId" AND "'.$TDS_LogCrave.'"."elementId"= "'.$TDS_LogSummary.'"."elementId"
						
						left join "'.$TDS_Work.'" on "'.$TDS_Work.'"."workId" = "'.$TDS_LogSummary.'"."elementId" 			
					
						left join "'.$TDS_workPromotionMedia.'" on "'.$TDS_workPromotionMedia.'"."workId" = "'.$TDS_Work.'"."workId" AND "'.$TDS_workPromotionMedia.'"."isMain"=\'t\' 			
							
						left join "'.$TDS_MediaFile.'" on "'.$TDS_MediaFile.'"."fileId" = "'.$TDS_workPromotionMedia.'"."fileId" 			
											
						left join "'.$TDS_UserShowcase.'" on "'.$TDS_UserShowcase.'"."tdsUid"= "'.$TDS_Work.'"."tdsUid" 
												
						where "'.$TDS_LogCrave.'"."entityId" = \''.$topCravedArray['entityId'].'\'
						AND "'.$TDS_LogCrave.'"."projectType" = \''.$topCravedArray['projectType'].'\'
						AND "'.$TDS_Work.'"."workExpireDate" > \''.date('Y-m-d').'\'
						AND "'.$TDS_Work.'"."isPublished" = \'t\' 
						AND "'.$TDS_Work.'"."workArchived" = \'f\'
						AND "'.$TDS_Work.'"."isBlocked" = \'f\'
						order by  "'.$TDS_LogSummary.'"."craveCount" Desc limit 1';
						break;
					case "product":
						$topCraveQuery = 'SELECT "'.$TDS_Product.'"."productId","'.$TDS_Product.'"."tdsUid","'.$TDS_Product.'"."productTitle", "'.$TDS_Product.'"."catId","'.$TDS_Product.'"."productOneLineDesc",
						"'.$TDS_UserShowcase.'"."firstName","'.$TDS_UserShowcase.'"."lastName",
						"'.$TDS_MediaFile.'"."filePath","'.$TDS_MediaFile.'"."fileName",
					
						"'.$TDS_LogSummary.'"."elementId", "'.$TDS_LogSummary.'"."craveCount", "'.$TDS_LogSummary.'"."reviewCount",
						"'.$TDS_LogSummary.'"."viewCount", "'.$TDS_LogSummary.'"."entityId", "'.$TDS_LogSummary.'"."elementId"
						
						from "TDS_LogCrave" 
												
						left join "'.$TDS_LogSummary.'" on "'.$TDS_LogCrave.'"."entityId"= "'.$TDS_LogSummary.'"."entityId" AND "'.$TDS_LogCrave.'"."elementId"= "'.$TDS_LogSummary.'"."elementId"
						
						left join "'.$TDS_Product.'" on "'.$TDS_Product.'"."productId" = "'.$TDS_LogSummary.'"."elementId" 			
					
						left join "'.$TDS_ProductPromotionMedia.'" on "'.$TDS_ProductPromotionMedia.'"."prodId" = "'.$TDS_Product.'"."productId" AND "'.$TDS_ProductPromotionMedia.'"."isMain"=\'t\' 			
							
						left join "'.$TDS_MediaFile.'" on "'.$TDS_MediaFile.'"."fileId" = "'.$TDS_ProductPromotionMedia.'"."fileId" 			
											
						left join "'.$TDS_UserShowcase.'" on "'.$TDS_UserShowcase.'"."tdsUid"= "'.$TDS_Product.'"."tdsUid" 
												
						where "'.$TDS_LogCrave.'"."entityId" = \''.$topCravedArray['entityId'].'\'
						AND "'.$TDS_LogCrave.'"."projectType" = \''.$topCravedArray['projectType'].'\'
						AND "'.$TDS_Product.'"."productExpiryDate" > \''.date('Y-m-d').'\'
						AND "'.$TDS_Product.'"."isPublished" = \'1\' 
						AND "'.$TDS_Product.'"."productArchived" = \'f\'
						AND "'.$TDS_Product.'"."isBlocked" = \'f\'
						order by  "'.$TDS_LogSummary.'"."craveCount" Desc limit 1';
						break;
					case "blog":
						$topCraveQuery = 'SELECT "'.$TDS_Posts.'"."postId","'.$TDS_Posts.'"."custId","'.$TDS_Posts.'"."postTitle","'.$TDS_Posts.'"."postOneLineDesc",
						"'.$TDS_UserShowcase.'"."firstName","'.$TDS_UserShowcase.'"."lastName",
						"'.$TDS_MediaFile.'"."filePath","'.$TDS_MediaFile.'"."fileName",					
						"'.$TDS_LogSummary.'"."elementId", "'.$TDS_LogSummary.'"."craveCount", "'.$TDS_LogSummary.'"."reviewCount",
						"'.$TDS_LogSummary.'"."viewCount", "'.$TDS_LogSummary.'"."entityId", "'.$TDS_LogSummary.'"."elementId"
						
						from "TDS_LogCrave" 
												
						left join "'.$TDS_LogSummary.'" on "'.$TDS_LogCrave.'"."entityId"= "'.$TDS_LogSummary.'"."entityId" AND "'.$TDS_LogCrave.'"."elementId"= "'.$TDS_LogSummary.'"."elementId"
						
						left join "'.$TDS_Posts.'" on "'.$TDS_Posts.'"."postId" = "'.$TDS_LogSummary.'"."elementId" 	
								
						left join "'.$TDS_MediaFile.'" on "'.$TDS_MediaFile.'"."fileId" = "'.$TDS_Posts.'"."postFileId" 		
						
						left join "'.$TDS_UserShowcase.'" on "'.$TDS_UserShowcase.'"."tdsUid"= "'.$TDS_Posts.'"."custId" 
												
						where "'.$TDS_LogCrave.'"."entityId" = \''.$topCravedArray['entityId'].'\'
						AND "'.$TDS_LogCrave.'"."projectType" = \''.$topCravedArray['projectType'].'\'
						AND "'.$TDS_Posts.'"."isPublished" = \'t\' 
						AND "'.$TDS_Posts.'"."postArchived" = \'f\'
						AND "'.$TDS_Posts.'"."isBlocked" = \'f\'
						order by  "'.$TDS_LogSummary.'"."craveCount" Desc limit 1';
						break;
				}
				//echo $topCraveQuery;die;
				$resultArray=$CI->model_common->executeQuery($topCraveQuery);	
				return $resultArray;
			} 
			else return false;
	}
   }
   if(! function_exists('topCravedElement')){		
		function topCravedElement($topCravedArray){
			$CI = &get_instance();
			if(isset($topCravedArray) && is_array($topCravedArray) && count($topCravedArray)>0){
				
				$TDS_UserShowcase = $CI->db->dbprefix('UserShowcase');
				$TDS_LogSummary = $CI->db->dbprefix('LogSummary');
				$TDS_LogCrave = $CI->db->dbprefix('LogCrave');
				$TDS_StockImages = $CI->db->dbprefix('StockImages');
				$TDS_MediaFile = $CI->db->dbprefix('MediaFile');
				$TDS_Project = $CI->db->dbprefix('Project');
				$TDS_FvElement = $CI->db->dbprefix('FvElement');
				$TDS_MaElement = $CI->db->dbprefix('MaElement');
				$TDS_PaElement = $CI->db->dbprefix('PaElement');
				$TDS_WpElement = $CI->db->dbprefix('WpElement');
				$TDS_EmElement = $CI->db->dbprefix('EmElement');
				$TDS_Events = $CI->db->dbprefix('Events');
				$TDS_Work = $CI->db->dbprefix('Work');
				$TDS_Product = $CI->db->dbprefix('Product');
				$TDS_ProductPromotionMedia = $CI->db->dbprefix('ProductPromotionMedia');
				$TDS_workPromotionMedia = $CI->db->dbprefix('workPromotionMedia');
				$TDS_Blog = $CI->db->dbprefix('Blogs');
				$TDS_Posts = $CI->db->dbprefix('Posts');
				
				switch ($topCravedArray['projectType']) {
				
					case "filmNvideo":
					 $topCraveQuery = 'SELECT "'.$TDS_Project.'"."tdsUid","'.$TDS_FvElement.'"."imagePath","'.$TDS_FvElement.'"."projId","'.$TDS_FvElement.'"."fileId","'.$TDS_FvElement.'"."title","'.$TDS_FvElement.'"."description",
						"'.$TDS_LogSummary.'"."elementId", "'.$TDS_LogSummary.'"."craveCount", "'.$TDS_LogSummary.'"."reviewCount",
						"'.$TDS_LogSummary.'"."viewCount", "'.$TDS_LogSummary.'"."entityId", "'.$TDS_LogSummary.'"."elementId",
						"'.$TDS_UserShowcase.'"."firstName","'.$TDS_UserShowcase.'"."lastName"
						from "'.$TDS_LogCrave.'" 												
						left join "'.$TDS_LogSummary.'" on "'.$TDS_LogCrave.'"."entityId"= "'.$TDS_LogSummary.'"."entityId" AND "'.$TDS_LogCrave.'"."elementId"= "'.$TDS_LogSummary.'"."elementId"						
						left join "'.$TDS_FvElement.'" on "'.$TDS_FvElement.'"."elementId" = "'.$TDS_LogSummary.'"."elementId"
						left join "'.$TDS_Project.'" on "'.$TDS_Project.'"."projId" = "'.$TDS_FvElement.'"."projId" 						
						left join "'.$TDS_UserShowcase.'" on "'.$TDS_UserShowcase.'"."tdsUid"= "'.$TDS_Project.'"."tdsUid" 
											
						where "'.$TDS_LogCrave.'"."entityId" = \''.$topCravedArray['entityId'].'\'
						AND "'.$TDS_LogCrave.'"."projectType" = \''.$topCravedArray['projectType'].'\'
						AND "'.$TDS_FvElement.'"."isPublished" = \'t\' 
						AND "'.$TDS_FvElement.'"."isBlocked" = \'f\'
						order by  "'.$TDS_LogSummary.'"."craveCount" Desc limit 1';
						break;
						
					case "musicNaudio":
					 $topCraveQuery = 'SELECT "'.$TDS_Project.'"."tdsUid","'.$TDS_MaElement.'"."imagePath","'.$TDS_MaElement.'"."projId","'.$TDS_MaElement.'"."fileId","'.$TDS_MaElement.'"."title","'.$TDS_MaElement.'"."description",
						"'.$TDS_LogSummary.'"."elementId", "'.$TDS_LogSummary.'"."craveCount", "'.$TDS_LogSummary.'"."reviewCount",
						"'.$TDS_LogSummary.'"."viewCount", "'.$TDS_LogSummary.'"."entityId", "'.$TDS_LogSummary.'"."elementId",
						"'.$TDS_UserShowcase.'"."firstName","'.$TDS_UserShowcase.'"."lastName"
						from "'.$TDS_LogCrave.'" 												
						left join "'.$TDS_LogSummary.'" on "'.$TDS_LogCrave.'"."entityId"= "'.$TDS_LogSummary.'"."entityId" AND "'.$TDS_LogCrave.'"."elementId"= "'.$TDS_LogSummary.'"."elementId"						
						left join "'.$TDS_MaElement.'" on "'.$TDS_MaElement.'"."elementId" = "'.$TDS_LogSummary.'"."elementId"
						left join "'.$TDS_Project.'" on "'.$TDS_Project.'"."projId" = "'.$TDS_MaElement.'"."projId" 						
						left join "'.$TDS_UserShowcase.'" on "'.$TDS_UserShowcase.'"."tdsUid"= "'.$TDS_Project.'"."tdsUid" 
											
						where "'.$TDS_LogCrave.'"."entityId" = \''.$topCravedArray['entityId'].'\'
						AND "'.$TDS_LogCrave.'"."projectType" = \''.$topCravedArray['projectType'].'\'
						AND "'.$TDS_MaElement.'"."isPublished" = \'t\' 
						AND "'.$TDS_MaElement.'"."isBlocked" = \'f\'
						order by  "'.$TDS_LogSummary.'"."craveCount" Desc limit 1';
						break;
					
					case "photographyNart":
					$topCraveQuery = 'SELECT "'.$TDS_Project.'"."tdsUid","'.$TDS_PaElement.'"."projId","'.$TDS_PaElement.'"."fileId","'.$TDS_PaElement.'"."title","'.$TDS_PaElement.'"."description",
						"'.$TDS_LogSummary.'"."elementId", "'.$TDS_LogSummary.'"."craveCount", "'.$TDS_LogSummary.'"."reviewCount",
						"'.$TDS_LogSummary.'"."viewCount", "'.$TDS_LogSummary.'"."entityId", "'.$TDS_LogSummary.'"."elementId",
						"'.$TDS_UserShowcase.'"."firstName","'.$TDS_UserShowcase.'"."lastName",	"'.$TDS_MediaFile.'"."filePath","'.$TDS_MediaFile.'"."fileName"
						from "'.$TDS_LogCrave.'" 												
						left join "'.$TDS_LogSummary.'" on "'.$TDS_LogCrave.'"."entityId"= "'.$TDS_LogSummary.'"."entityId" AND "'.$TDS_LogCrave.'"."elementId"= "'.$TDS_LogSummary.'"."elementId"						
						left join "'.$TDS_PaElement.'" on "'.$TDS_PaElement.'"."elementId" = "'.$TDS_LogSummary.'"."elementId"
						left join "'.$TDS_Project.'" on "'.$TDS_Project.'"."projId" = "'.$TDS_PaElement.'"."projId" 						
						left join "'.$TDS_UserShowcase.'" on "'.$TDS_UserShowcase.'"."tdsUid"= "'.$TDS_Project.'"."tdsUid" 
						left join "'.$TDS_MediaFile.'" on "'.$TDS_MediaFile.'"."fileId" = "'.$TDS_PaElement.'"."fileId" 						
						where "'.$TDS_LogCrave.'"."entityId" = \''.$topCravedArray['entityId'].'\'
						AND "'.$TDS_LogCrave.'"."projectType" = \''.$topCravedArray['projectType'].'\'
						AND "'.$TDS_PaElement.'"."isPublished" = \'t\' 
						AND "'.$TDS_PaElement.'"."isBlocked" = \'f\'
						order by  "'.$TDS_LogSummary.'"."craveCount" Desc limit 1';
						break;
						
					case "writingNpublishing":
					$topCraveQuery = 'SELECT "'.$TDS_Project.'"."tdsUid","'.$TDS_WpElement.'"."imagePath","'.$TDS_WpElement.'"."projId","'.$TDS_WpElement.'"."fileId","'.$TDS_WpElement.'"."title","'.$TDS_WpElement.'"."description",
						"'.$TDS_LogSummary.'"."elementId", "'.$TDS_LogSummary.'"."craveCount", "'.$TDS_LogSummary.'"."reviewCount",
						"'.$TDS_LogSummary.'"."viewCount", "'.$TDS_LogSummary.'"."entityId", "'.$TDS_LogSummary.'"."elementId",
						"'.$TDS_UserShowcase.'"."firstName","'.$TDS_UserShowcase.'"."lastName"
						
						from "'.$TDS_LogCrave.'" 												
						left join "'.$TDS_LogSummary.'" on "'.$TDS_LogCrave.'"."entityId"= "'.$TDS_LogSummary.'"."entityId" AND "'.$TDS_LogCrave.'"."elementId"= "'.$TDS_LogSummary.'"."elementId"						
						left join "'.$TDS_WpElement.'" on "'.$TDS_WpElement.'"."elementId" = "'.$TDS_LogSummary.'"."elementId"
						left join "'.$TDS_Project.'" on "'.$TDS_Project.'"."projId" = "'.$TDS_WpElement.'"."projId" 						
						left join "'.$TDS_UserShowcase.'" on "'.$TDS_UserShowcase.'"."tdsUid"= "'.$TDS_Project.'"."tdsUid" 
											
						where "'.$TDS_LogCrave.'"."entityId" = \''.$topCravedArray['entityId'].'\'
						AND "'.$TDS_LogCrave.'"."projectType" = \''.$topCravedArray['projectType'].'\'
						AND "'.$TDS_WpElement.'"."isPublished" = \'t\' 
						AND "'.$TDS_WpElement.'"."isBlocked" = \'f\'
						order by  "'.$TDS_LogSummary.'"."craveCount" Desc limit 1';
						break;
						
					case "educationMaterial":
					$topCraveQuery = 'SELECT "'.$TDS_Project.'"."tdsUid","'.$TDS_EmElement.'"."imagePath","'.$TDS_EmElement.'"."projId","'.$TDS_EmElement.'"."fileId","'.$TDS_EmElement.'"."title","'.$TDS_EmElement.'"."description",
						"'.$TDS_LogSummary.'"."elementId", "'.$TDS_LogSummary.'"."craveCount", "'.$TDS_LogSummary.'"."reviewCount",
						"'.$TDS_LogSummary.'"."viewCount", "'.$TDS_LogSummary.'"."entityId", "'.$TDS_LogSummary.'"."elementId",
						"'.$TDS_UserShowcase.'"."firstName","'.$TDS_UserShowcase.'"."lastName"
						from "'.$TDS_LogCrave.'" 												
						left join "'.$TDS_LogSummary.'" on "'.$TDS_LogCrave.'"."entityId"= "'.$TDS_LogSummary.'"."entityId" AND "'.$TDS_LogCrave.'"."elementId"= "'.$TDS_LogSummary.'"."elementId"						
						left join "'.$TDS_EmElement.'" on "'.$TDS_EmElement.'"."elementId" = "'.$TDS_LogSummary.'"."elementId"
						left join "'.$TDS_Project.'" on "'.$TDS_Project.'"."projId" = "'.$TDS_EmElement.'"."projId" 						
						left join "'.$TDS_UserShowcase.'" on "'.$TDS_UserShowcase.'"."tdsUid"= "'.$TDS_Project.'"."tdsUid" 
											
						where "'.$TDS_LogCrave.'"."entityId" = \''.$topCravedArray['entityId'].'\'
						AND "'.$TDS_LogCrave.'"."projectType" = \''.$topCravedArray['projectType'].'\'
						AND "'.$TDS_EmElement.'"."isPublished" = \'t\' 
						AND "'.$TDS_EmElement.'"."isBlocked" = \'f\'
						order by  "'.$TDS_LogSummary.'"."craveCount" Desc limit 1';
						break;
						
				}
				
				//echo $topCraveQuery;die;
				$resultArray=$CI->model_common->executeQuery($topCraveQuery);	
				return $resultArray;
			} 
			else return false;
	}
   }

   
   // Get Sum of price 
  if(! function_exists('isRequestAlreadySent')){		
	 function isRequestAlreadySent($userId,$productId){
		$CI = &get_instance();
		$details=$CI->model_common->getProductAttacment($userId,$productId);
		return $details;	 
	 }	
   } 
   

  /*Function to get default image when given path is not working*/
	 if(! function_exists('getDefaultProfileTypeImage')){
		function getDefaultProfileTypeImage($userIds,$user_img='')  //file name passed
		{
			$CI =& get_instance();
			$getUserShowcase	= showCaseUserDetails($userIds);
              
			$creative=$getUserShowcase['creative'];
			$associatedProfessional=$getUserShowcase['associatedProfessional'];
			$enterprise=$getUserShowcase['enterprise'];
			
			$userDefaultImage=($creative=='t')?$CI->config->item('defaultCreativeImg'):(($associatedProfessional=='t')?$CI->config->item('defaultAssProfImg'):(($enterprise=='t')?$CI->config->item('defaultEnterpriseImg'):''));
			if($user_img!='') {
				 $userImage=$user_img;
			}
			$userImage=addThumbFolder($userImage,$suffix='_xxs',$thumbFolder ='thumb',$userDefaultImage);  	
			$userImage=getImage($userImage,$userDefaultImage);
			return $userImage;
			
		}
	}	
	
   
   
    // Get user name if enterprise is True
  if(! function_exists('isGetUserName')){		
	 function isGetUserName($userId){
		
			$CI = &get_instance();
			
			$getUserShowcase = showCaseUserDetails($userId);
			
			$getUserFullName=$CI->model_common->getDataFromTabel('UserProfile', 'firstName, lastName',  'tdsUid', $userId, '', 'ASC', 0, 0, true);
			
		
			$userFullName = $getUserFullName[0]['firstName'].' '.$getUserFullName[0]['lastName'];
			
			if(isset($getUserShowcase['enterprise']))
			{
				$enterprise=$getUserShowcase['enterprise'];
						
				if($enterprise=="t")
					{
						$name= $getUserShowcase['enterpriseName'];
					}else
					{
						$name =  $userFullName;
					}
			}else
			{
				$name =  $userFullName;
			}	
				
			return $name;	
		}	
   }
   
   
   //get attachment by msg_id
   if(! function_exists('getAttacmentWorkProfile')){
		function getAttacmentWorkProfile($id=''){
			 $CI =& get_instance();
			 $curentUid = isLoginUser();
			 if(isset($id) && $id!='')
			 $attachInfo = $CI->model_tmail->getWorkProfileAttach($id,$curentUid);	
			 if( isset($attachInfo['sender_id']) && $attachInfo['sender_id']!='')
				{
					$workProfileLink= encode($attachInfo['sender_id'].'-'.$attachInfo['elementid'].'-'.$attachInfo['access_token']);
				}else
				{
					$workProfileLink ="";
				} 
			return $workProfileLink;	
		}
	}
	if(! function_exists('getstateName')){
		function getstateName($stateId) {
			 $CI =& get_instance();		
			 $getName=$CI->model_common->getDataFromTabel('MasterStates', 'stateName',  array('stateId'=>$stateId),'','','','');
			 $getName = (isset($getName[0]->stateName) && ($getName[0]->stateName!='')) ? $getName[0]->stateName :'';
			 return $getName;
		}
	}
	if(! function_exists('downloadFile')){
		function downloadFile($filePath='',$fileName='',$dwnFileName=''){ 
			$file=$filePath.$fileName;
			if(is_file($file)){
				if($dwnFileName==''){
					$dwnFileName=$fileName;
				}
				$fsize = filesize($file);
				$fileInfo=pathinfo($file);
				$extension=$fileInfo['extension'];
				$extension = strtolower($extension);
				switch($extension) { case 'jar': $mime = "application/java-archive"; break; case 'zip': $mime = "application/zip"; break; case 'jpeg': $mime = "image/jpeg"; break; case 'jpg': $mime = "image/jpg"; break; case 'jad': $mime = "text/vnd.sun.j2me.app-descriptor"; break; case "gif": $mime = "image/gif"; break; case "png": $mime = "image/png"; break; case "pdf": $mime = "application/pdf"; break; case "txt": $mime = "text/plain"; break; case "doc": $mime = "application/msword"; break; case "ppt": $mime = "application/vnd.ms-powerpoint"; break; case "wbmp": $mime = "image/vnd.wap.wbmp"; break; case "wmlc": $mime = "application/vnd.wap.wmlc"; break; case "mp4s": $mime = "application/mp4"; break; case "ogg": $mime = "application/ogg"; break; case "pls": $mime = "application/pls+xml"; break; case "asf": $mime = "application/vnd.ms-asf"; break; case "swf": $mime = "application/x-shockwave-flash"; break; case "mp4": $mime = "video/mp4"; break; case "m4a": $mime = "audio/mp4"; break; case "m4p": $mime = "audio/mp4"; break; case "mp4a": $mime = "audio/mp4"; break; case "mp3": $mime = "audio/mpeg"; break; case "m3a": $mime = "audio/mpeg"; break; case "m2a": $mime = "audio/mpeg"; break; case "mp2a": $mime = "audio/mpeg"; break; case "mp2": $mime = "audio/mpeg"; break; case "mpga": $mime = "audio/mpeg"; break; case "wav": $mime = "audio/wav"; break; case "m3u": $mime = "audio/x-mpegurl"; break; case "bmp": $mime = "image/bmp"; break; case "ico": $mime = "image/x-icon"; break; case "3gp": $mime = "video/3gpp"; break; case "3g2": $mime = "video/3gpp2"; break; case "mp4v": $mime = "video/mp4"; break; case "mpg4": $mime = "video/mp4"; break; case "m2v": $mime = "video/mpeg"; break; case "m1v": $mime = "video/mpeg"; break; case "mpe": $mime = "video/mpeg"; break; case "mpeg": $mime = "video/mpeg"; break; case "mpg": $mime = "video/mpeg"; break; case "mov": $mime = "video/quicktime"; break; case "qt": $mime = "video/quicktime"; break; case "avi": $mime = "video/x-msvideo"; break; case "midi": $mime = "audio/midi"; break; case "mid": $mime = "audio/mid"; break; case "amr": $mime = "audio/amr"; break; default: $mime = "application/octet-stream"; }
				set_time_limit(0);
				ob_clean(); 
				header("Content-Type: application/".$mime);
				header("Content-Description: file transfer");
				header('Content-Disposition: attachment; filename="' . basename($dwnFileName) . '"');
				header('Content-Length: '. $fsize);
				$open = fopen($file, "rb");
				flush();
				while(!feof($open)){
					print fread($open, (1024*1024));
					ob_flush();
					flush();
					usleep(500);
				}
				fclose($open);
				flush(); 
				exit();
			}
		}
	}
	
	if(! function_exists('findFileNDelete')){
		function findFileNDelete($dir, $filename){
		   if(is_dir($dir) && $filename !=''){
			  
				$fpLen=strlen($dir);
				if($fpLen > 0 && substr($dir,-1) != DIRECTORY_SEPARATOR){
					$dir=$dir.DIRECTORY_SEPARATOR;
				}
			   
				$ffs = scandir($dir);
				foreach($ffs as $ff){
					if($ff != '.' && $ff != '..'){
						if(is_dir($dir.$ff)){
							findFileNDelete($dir.$ff.DIRECTORY_SEPARATOR, $filename);
						}elseif(is_file($dir.$ff)){
							$fileInfo=pathinfo($filename);
							if(strstr($ff,$fileInfo['filename'])){
								unlink($dir.$ff);
							}
						}
					}
				}
			}
		}
	}
	
	
	if(! function_exists('findFullPathFileNDelete')){
		function findFullPathFileNDelete($deleteFile){
		   if(!empty($deleteFile)){
			  
				$revStr = strrev($deleteFile);
				$getArray= explode("/",$revStr);
				$fileName = strrev($getArray[0]);
				unset($getArray[0]);
				$getArray = implode("/",$getArray);
				$dir = strrev($getArray);
				//call delete file helper
				findFileNDelete($dir, $fileName);
			}
		}
	}
	
	
	
	
	if(! function_exists('findFileNnovieInTrash')){
		function findFileNnovieInTrash($dir, $filename,$trash='trash'){
		   if(is_dir($dir) && $filename !=''){
				$fpLen=strlen($dir);
				if($fpLen > 0 && substr($dir,-1) != DIRECTORY_SEPARATOR){
					$dir=$dir.DIRECTORY_SEPARATOR;
				}
				$ffs = scandir($dir);
				foreach($ffs as $ff){
					if($ff != '.' && $ff != '..'){
						if(is_dir($dir.$ff)){
							findFileNnovieInTrash($dir.$ff.DIRECTORY_SEPARATOR, $filename);
						}elseif(is_file($dir.$ff)){
							$fileInfo=pathinfo($filename);
							if(strstr($ff,$fileInfo['filename'])){
								$trashDir=str_replace('media/',$trash.'/',$dir);
								$trashFile=$trashDir.$ff;
								$file=$dir.$ff;
								if(!is_dir($trashDir)){
									if (!mkdir($trashDir, 0777, true)) {
										die('Failed to create folders...');
									}else{
										
									}
								 }
								copy($file,$trashFile);
								unlink($file); 
							}
						}
					}
				}
			}
		}
	}


/**This function is used to return currency type
 * Doalr:1
 * Euro : 0
 *  **/
if(! function_exists('getCurrencyType')){
	function getCurrencyType($currency) {
			$currencyType = ($currency==1) ?'$':'€';
		 return $currencyType;
			
		}
	}

//1:shipping,2:download,3:PPV,4:Donation, 5: event
/**This function is used to return currency type **/
if(! function_exists('getPurchaseType')){
	function getPurchaseType($purchaseType) {
		$CI =& get_instance();
		
		//
		switch($purchaseType)
		{
			case 1:
			$purchaseType=$CI->lang->line('product');
		    break;
		    case 2:
			$purchaseType=$CI->lang->line('download');
		    break;
		    case 3:
			$purchaseType=$CI->lang->line('payperview');
			break;
			case 4:
			$purchaseType=$CI->lang->line('donation');
			break;
			case 5:
			$purchaseType=$CI->lang->line('event');
		    break;
		    default:
				$purchaseType="None";
		}
			
		 return $purchaseType;
			
		}
	}	

//1:shipping,2:download,3:PPV,4:Donation
/**This function is used to return currency type **/
if(! function_exists('getInvoicePurchaseType')){
	function getInvoicePurchaseType($purchaseType) {
		$CI =& get_instance();
		
		//
		switch($purchaseType)
		{
			case 1:
			$purchaseType=$CI->lang->line('shipping');
		    break;
		    case 2:
			$purchaseType=$CI->lang->line('download');
		    break;
		    case 3:
			$purchaseType=$CI->lang->line('payperview');
			break;
			case 4:
			$purchaseType=$CI->lang->line('donation');
			break;
			case 5:
			$purchaseType=$CI->lang->line('Tickets');
		    break;
		    default:
				$purchaseType="None";
		}
			
		 return $purchaseType;
			
		}
	}	
/*
 ***************************************** 
 *  This function is user to give showcase url by project id
 ***************************************** 
 */ 	
	
	
	if(! function_exists('getShowCaseUrlBySectionId')){
	function getShowCaseUrlBySectionId($SectionId) {
		$CI =& get_instance();
		switch($SectionId)
		{
			
			case 1:
			$url=base_url('filmnvideo');
		    break;
		    case 2:
			$url=base_url('musicnaudio');
		    break;
		    case 3:
			$url=base_url('writingnpublishing');
			break;
			case 4:
			$url=base_url('photographynart');
			break;
			case 9:
			$url=base_url('performancesnevents');
		    break;
		    case 10:
			$url=base_url('educationnmaterial');
		    break;
		    case 12:
			$url=base_url('products');
		    break;
		    default:
				$url=base_url('filmnvideo');
		}
			
		 return $url;
			
		}
	}
	
	
	
	
	
/*
 *********
 * This function is used to get status Type 
 ********* 
*/
if(! function_exists('getStatusType')){
	function getStatusType($viewType,$itemId) {
		 $CI =& get_instance();
		
		//Shipped : Not Shipped  : Recieved
		 
		switch($viewType)
		{
			case 1:
			
				$result = $CI->model_common->getShippingStatus($itemId);
				if($result==0)
				{
					$viewType = 'Not Shipped';
				}else
				{
					if($result==1)
					{
						$viewType = 'Shipped';
					}else
					{
						$viewType = 'Recieved';
					}
						
				}
				
		    break;
		    case 2:
			
				$result = $CI->model_common->getDownloadStatus($itemId);
				
				$viewType= ($result==1)?'Downloaded':'Not Downloaded';
				
		    break;
		    case 3:
			
				$result = $CI->model_common->getDownloadStatus($itemId);
				
				$viewType= ($result==1)?'Viewed':'Not Viewed';
				
		    break;
		    default:
				$viewType="None";
		}
			
		 return $viewType;
			
		}
	}

/*
 *********
 * This function is used to get Invoice Id by receiverTransactionId
 * Type : Cart 0 ; Membership Contatiner : 1; 
 ********* 
*/
if(! function_exists('getInvoiceId')){
	function getInvoiceId($transactionId,$type=0) {
		$CI =& get_instance();
		
		$result = $CI->model_common->get_InvoiceId_Data($transactionId,$type);
		 
		if($result['get_num_rows'] > 0)
		{
			
			$getId = $result['get_result']->id;
			$getNumberLenght = strlen($getId);
			switch($getNumberLenght)
			{
				case 1:
				$nvoiceId = 'TS00000'.$getId;
				break;
				case 2:
				$nvoiceId = 'TS0000'.$getId;
				break;
				case 3:
				$nvoiceId = 'TS000'.$getId;
				break;
				case 4:
				$nvoiceId = 'TS00'.$getId;
				break;
				case 5:
				$nvoiceId = 'TS0'.$getId;
				break;
				case 6:
				$nvoiceId = 'TS'.$getId;
				break;
				default:
				$nvoiceId = 'TS000000';
			}
			
		}else
		{
			$nvoiceId = 'TS000000';
		}
		
			
		 return $nvoiceId;
			
		}
	}		
		
	
/*
 *********
 * This function is used to get Download and PPV period 
 ********* 
*/
if(! function_exists('getDownloadPeriod')){
	function getDownloadPeriod($itemId) {
		 $CI =& get_instance();
		
			$result = $CI->model_common->getDownloadPeriod($itemId);
			
		 return $result;
			
		}
	}	
	
	
/*
 *********
 * This function is used to get membership item price by itemId
 ********* 
*/
if(! function_exists('getItemAmount')){
	function getItemAmount($itemId) {
		 $CI =& get_instance();
		 
		 $result = $CI->model_common->getItemPrice($itemId);
			
		 return $result;
			
		}
	}	
	
	
/*
 *********
 * This function is used to get total price value by Project Id
 ********* 
*/
if(! function_exists('getPriceByProjectId')){
	function getPriceByProjectId($projId) {
			 $CI =& get_instance();
			 $where =array('projId'=>$projId);
			 $getbasePrice = $CI->model_common->getSum('SalesOrderItem','basePrice',$where);
			 $gettaxValue = $CI->model_common->getSum('SalesOrderItem','taxValue',$where);
			 $totalPriceValue = $getbasePrice[0]->baseprice;
			 $totalTaxValue = $gettaxValue[0]->taxvalue;
			 $totalValue =  $totalPriceValue + $totalTaxValue;
			 return $totalValue;
		}
	}
    

/*
 *********
 * This function is used to get total price value by Project Id
 ********* 
*/
if(! function_exists('getSalesPriceByProjectId')){
	function getSalesPriceByProjectId($projId) {
            $CI =& get_instance();
            $priceArray        =   false;
            $where             =   array('projId'=>$projId);
            $getbasePrice      =   $CI->model_common->getSum('SalesOrderItem','basePrice',$where);
            $gettaxValue       =   $CI->model_common->getSum('SalesOrderItem','taxValue',$where);
            $getCommsionValue  =   $CI->model_common->getSum('SalesOrderItem','tsCommissionValue',$where);
            $priceArray['baseprice']             =   (!empty($getbasePrice[0]->baseprice))?number_format($getbasePrice[0]->baseprice,2):0;
            $priceArray['taxvalue']              =   (!empty($gettaxValue[0]->taxvalue))?number_format($gettaxValue[0]->taxvalue,2):0;
            $priceArray['tsCommissionValue']     =    (!empty($getCommsionValue[0]->tsCommissionValue))?number_format($getCommsionValue[0]->tsCommissionValue,2):0;
            return $priceArray;
		}
	}
	
/*
 *********
 * This function is used to get currency by Project Id
 ********* 
*/
if(! function_exists('getCurrencyByProjectId')){
	function getCurrencyByProjectId($projId) {
			$CI =& get_instance();
			//get order id by project id
			$currencyType ='';
			$where =array('projId'=>$projId);
			$getOrderId=getDataFromTabel('SalesOrderItem', 'ordId',  $where, '', $orderBy='', '', 1 );
			//get currency type by order Id
			if(isset($getOrderId))
			{
				$where =array('ordId'=>$getOrderId[0]->ordId);
				$getCurrencyType=getDataFromTabel('SalesOrder', 'ordCurrency',  $where, '', $orderBy='', '', 1 );
				if(isset($getCurrencyType))
				{
					$currencyType = getCurrencyType($getCurrencyType[0]->ordCurrency);
					return $currencyType;
					
				}else
				{
					return $currencyType;
				}
				
			}else
			{
				return $currencyType;
			}
		}
	}			

/*
 *********
 * This function is used to get membership item container size
 ********* 
*/
	if(! function_exists('getItemSize')){
		function getItemSize($itemId) {
			 $CI =& get_instance();
			 
			 $result = $CI->model_common->get_Item_Size($itemId);
				
			 return $result;
				
		}
	}
	
	
	if ( ! function_exists('getMultilingualLanguageListing')){		 
	/* 
	 * function for get language Listing for multilingual lanuages.
	 */
		function getMultilingualLanguageListing($langId)
		{
			$CI =&get_instance();
			// Get language listing
			$res =  $CI->model_common->getDataFromTabel('MasterLang', 'langId,Language_local','','Language');
			if($res){
				$glanguages = array();
				foreach ($res as $language) {
					if($language->langId!=1 && $language->Language_local!='English'){
						
						$languages['langId'] = $language->langId;
						$languages['Language_local'] = $language->Language_local;
						$glanguages[]= $languages;
						}
					}
					$userId=isLoginUser();
					$userLangList = $CI->model_common->getDataFromTabel('UserShowcaseLang', 'langId','tdsUid',$userId);
					$gUserlanguages = array();
					if(isset($userLangList) && !empty($userLangList)){
						//set language listing
						foreach ($userLangList as $userLangList) {
							$userLangres =  $CI->model_common->getDataFromTabel('MasterLang', 'langId,Language_local','langId',$userLangList->langId,'Language');
							foreach ($userLangres as $userLangres) {
								$userlanguages[] = $userLangres->langId;
							}	
						}
						$mainLanguageList =array();
						$mainLanguageList[''] = $CI->lang->line('selectMultiLanguage');
						//set selected language
						if(isset($langId) && !empty($langId)){
							$userSelectedLang = $CI->model_common->getDataFromTabel('MasterLang', 'Language_local','langId',$langId);
							foreach ($userSelectedLang as $userSelectedLang) {
							$mainLanguageList[$langId] = $userSelectedLang->Language_local;
							}
						}
						//set language list exept selected language
						foreach($glanguages as $glanguages){
							if(!in_array($glanguages['langId'], $userlanguages)) {
								
								$mainLanguageList[$glanguages['langId']] = $glanguages['Language_local'];
							}
						}
						
					}else{
						$mainLanguageList[''] = $CI->lang->line('selectMultiLanguage');
						foreach ($res as $languageList) {
							if($languageList->langId!=1 && $languageList->Language_local!='English'){
								$mainLanguageList[$languageList->langId] = $languageList->Language_local;
							}
						}
					}							
				return $mainLanguageList;
			}else{
				return false;
			}
		}
	}
	
	if(! function_exists('getTicketNumber')){
		function getTicketNumber() {
			
			 $CI =& get_instance();
			 
			$result =  $CI->model_common->getMax('TicketTransectionLog', 'id');
			
			if($result){
				$ticketNumber= $result[0]->id;
			}else{
				$ticketNumber=0;
			}
			
			$ticketNumberStartFrom=$CI->config->item('ticketNumberStartFrom');
			$ticketNumber=($ticketNumberStartFrom+$ticketNumber);
			
			$ticketxDigit=strlen($ticketNumber);
			$maxDigit=8;
			$remainingDigit=($maxDigit-$ticketxDigit);
			if($remainingDigit > 0){
				for($k=1; $k<=$remainingDigit; $k++){
					$ticketNumber='0'.$ticketNumber;
				}
			}
			
			return $ticketNumber;
			
		}
	}
	if(! function_exists('getTicketNumberAsString')){
		function getTicketNumberAsString($ticketNumber='') {
			$ticketxDigit=strlen($ticketNumber);
			$maxDigit=8;
			$remainingDigit=($maxDigit-$ticketxDigit);
			if($remainingDigit > 0){
				for($k=1; $k<=$remainingDigit; $k++){
					$ticketNumber='0'.$ticketNumber;
				}
			}
			return $ticketNumber;
		}
	}
		
	
/**This function is used return enterprise name**/
if(! function_exists('getEnterpriseName')){
	function getEnterpriseName($tdsUid) {
		
		$getUserShowcase	= showCaseUserDetails($tdsUid);
	
		//get user first name
		
		$resultUserName = getDataFromTabel('UserProfile','firstName,lastName',  'tdsUid', $tdsUid,'', 'ASC', $limit=1 );
		$getUserName = $resultUserName[0]->firstName;
		
		// if user enterprise is true
		if($getUserShowcase['enterprise']=='t')
		{
			$getUserName = $getUserShowcase['enterpriseName'];
		}
		
		 return $getUserName;
			
		}
	}
	
/** Get userId on the basis of elementId and enitytId **/
if(! function_exists('getUserIdUsingGivenId')){
	function getUserIdUsingGivenId($entityId,$elementId) {
		
		$whereCondition=array('entityid'=>$entityId,'elementid'=>$elementId);
		$result=getDataFromTabel($table='search', '(item).userid',  $whereCondition, '','','',  $limit=1 );
		
		if($result){
			if(isset($result[0]->userid))
				return $result[0]->userid;
			else 
				return false;
		}else return false;
	}
}


/** Get userId on the basis of elementId and enitytId **/
if(! function_exists('getFrontEndLink')){
	function getFrontEndLink($entityId=0,$elementId=0) {
		$projectLink='#';
		
		$whereCondition=array('entityid'=>$entityId,'elementid'=>$elementId);
		$result=getDataFromTabel('search', '*, (item).userid,(item).languageid,(item).element_type,(item).type',  $whereCondition, '','','',  $limit=1 );
		
		if($result && isset($result[0])){
			$search=$result[0];
			$section=$search->section;
			if($search->section=='upcoming'){
				switch ($search->sectionid) {
					case 1:
						$section='filmNvideo';
						break;
					case 2:
						$section='musicNaudio';
						break;
					case 3:
						$section='writingNpublishing';
						break;
					case 4:
						$section='photographyNart';
						break;
				}
				
			}
			switch ($section) {
				case 'filmNvideo':
					$linkId=($search->elementid == $search->projectid)?$search->userid.'/'.$search->projectid.'/':$search->userid.'/'.$search->projectid.'/'.$search->elementid.'/';
					$projectLink=($search->section=='upcoming')?base_url(lang().'/upcomingfrontend/viewproject/'.$linkId.'filmvideo'):base_url(lang().'/mediafrontend/searchresult/'.$linkId.'filmvideo');
					break;
				case 'musicNaudio':
					$linkId=($search->elementid == $search->projectid)?$search->userid.'/'.$search->projectid.'/':$search->userid.'/'.$search->projectid.'/'.$search->elementid.'/';
					$projectLink=($search->section=='upcoming')?base_url(lang().'/upcomingfrontend/viewproject/'.$linkId.'musicaudio'):base_url(lang().'/mediafrontend/searchresult/'.$linkId.'musicaudio');
					break;
				case 'photographyNart':
					$linkId=($search->elementid == $search->projectid)?$search->userid.'/'.$search->projectid.'/':$search->userid.'/'.$search->projectid.'/'.$search->elementid.'/';
					$projectLink=($search->section=='upcoming')?base_url(lang().'/upcomingfrontend/viewproject/'.$linkId.'photographyart'):base_url(lang().'/mediafrontend/searchresult/'.$linkId.'photographyart');
					break;
				case 'writingNpublishing':
					$linkId=($search->elementid == $search->projectid)?$search->userid.'/'.$search->projectid.'/':$search->userid.'/'.$search->projectid.'/'.$search->elementid.'/';
					$projectLink=($search->section=='upcoming')?base_url(lang().'/upcomingfrontend/viewproject/'.$linkId.'writingpublishing'):base_url(lang().'/mediafrontend/searchresult/'.$linkId.'writingpublishing');
					break;
				case 'educationMaterial':
					$linkId=($search->elementid == $search->projectid)?$search->userid.'/'.$search->projectid.'/':$search->userid.'/'.$search->projectid.'/'.$search->elementid.'/';
					$projectLink=($search->section=='upcoming')?base_url(lang().'/upcomingfrontend/viewproject/'.$linkId.'educationmaterial'):base_url(lang().'/mediafrontend/searchresult/'.$linkId.'educationmaterial');
					break;
				case 'performances&events':
					$linkId=$search->userid.'/'.$search->projectid;
					$projectLink=base_url(lang().'/eventfrontend/events/'.$search->element_type.'/'.$linkId);
					break;
				case 'event':
					$linkId=$search->userid.'/'.$search->projectid;
					$projectLink=base_url(lang().'/eventfrontend/events/'.$search->element_type.'/'.$linkId);
					break;
				case 'launch':
					$linkId=$search->userid.'/'.$search->projectid;
					$projectLink=base_url(lang().'/eventfrontend/events/'.$search->element_type.'/'.$linkId);
					break;
				case 'notification':
					$linkId=$search->userid.'/'.$search->projectid;
					$projectLink=base_url(lang().'/eventfrontend/events/'.$search->element_type.'/'.$linkId);
					break;
				case 'product':
					$linkId=($search->elementid == $search->projectid)?$search->userid.'/'.$search->projectid.'/':$search->userid.'/'.$search->projectid.'/'.$search->elementid.'/';
					$projectLink=base_url(lang().'/productshowcase/viewproject/'.$linkId);
					break;
				case 'blog':
					$linkId=($search->elementid == $search->projectid)?'frontblog/'.$search->userid.'/'.$search->projectid.'/':'frontpost/'.$search->userid.'/'.$search->elementid.'/';
					$projectLink=base_url(lang().'/blogs/'.$linkId);
					break;
				case 'work':
					$linkId=($search->elementid == $search->projectid)?$search->userid.'/'.$search->projectid.'/':$search->userid.'/'.$search->projectid.'/'.$search->elementid.'/';
					$projectLink=base_url(lang().'/workshowcase/viewproject/'.$linkId);
					break;
				case 'news':
					$linkId=($search->elementid == $search->projectid)?$search->userid.'/'.$search->projectid.'/':$search->userid.'/'.$search->projectid.'/'.$search->elementid.'/';
					$projectLink=($search->section=='upcoming')?base_url(lang().'/upcomingfrontend/viewproject/'.$linkId.'news'):base_url(lang().'/mediafrontend/searchresult/'.$linkId.'news');
					break;
				case 'reviews':
					$search->type=($search->elementid != $search->projectid)?$search->type:'';
					$linkId=($search->elementid == $search->projectid)?$search->userid.'/'.$search->projectid.'/':$search->userid.'/'.$search->projectid.'/'.$search->elementid.'/';
					$projectLink=($search->section=='upcoming')?base_url(lang().'/upcomingfrontend/viewproject/'.$linkId.'reviews'):base_url(lang().'/mediafrontend/searchresult/'.$linkId.'reviews');
					break;
				case 'creatives':
					$linkId=$search->userid.'/';
					$linkId=($search->languageid>1)?$linkId.$search->elementid.'/':$linkId;
					$projectLink=base_url(lang().'/showcase/index/'.$linkId);
					break;
				case 'associatedprofessionals':
					$linkId=$search->userid.'/';
					$linkId=($search->languageid>1)?$linkId.$search->elementid.'/':$linkId;
					$projectLink=base_url(lang().'/showcase/index/'.$linkId);
					break;
				case 'enterprises':
					$linkId=$search->userid.'/';
					$linkId=($search->languageid>1)?$linkId.$search->elementid.'/':$linkId;
					$projectLink=base_url(lang().'/showcase/index/'.$linkId);
					break;
				default:
					$projectLink='#';
			}
		}
		return $projectLink;
	}
}

/** Get BackEnd Link on the basis of elementId and enitytId **/
if(! function_exists('getBackEndLink')){
	function getBackEndLink($entityId=0,$elementId=0) {
		$indexLink='';
		$whereCondition=array('entityid'=>$entityId,'elementid'=>$elementId);
		$result=getDataFromTabel('search', '*, (item).userid,(item).languageid,(item).element_type,(item).type',  $whereCondition, '','','',  $limit=1 );
		
		if($result && isset($result[0])){
			$search=$result[0];
			$section=$search->section;
			switch ($section) {
				case 'filmNvideo':
					$indexLink='/media/filmNvideo/'.$search->projectid;
					break;
				case 'musicNaudio':
					$indexLink='/media/musicNaudio/'.$search->projectid;
					break;
				case 'photographyNart':
					$indexLink='/media/photographyNart/'.$search->projectid;
					break;
				case 'writingNpublishing':
					$indexLink='/media/writingNpublishing/'.$search->projectid;
					break;
				case 'educationMaterial':
					$indexLink='/media/educationMaterial/'.$search->projectid;
					break;
				case 'news':
					$indexLink='/media/news/'.$search->projectid;
					break;
				
				case 'reviews':
					$indexLink='/media/reviews/'.$search->projectid;
					break;
				
				case 'event':
					$indexLink='/event/events/eventdetail/'.$search->projectid;
					break;
				
				case 'launch':
					$indexLink='/event/launch/launchdetail/'.$search->projectid;
					break;
				
				default:
					$indexLink='';
			}
			
			$indexLink=base_url(lang().$indexLink);
		}
		return $indexLink;
	}
}

//--------------------------------------------------------------------------



if(! function_exists('getFrontEndLinkNew')){
	function getFrontEndLinkNew($entityId=0,$elementId=0) {
		$projectLink='#';
		
		$whereCondition=array('entityid'=>$entityId,'elementid'=>$elementId);
		$result=getDataFromTabel('search', '*, (item).userid,(item).languageid,(item).element_type,(item).type',  $whereCondition, '','','',  $limit=1 );
		
		if($result && isset($result[0])){
			$search=$result[0];
			$section=$search->section;
			if($search->section=='upcoming'){
				switch ($search->sectionid) {
					case 1:
						$section='filmNvideo';
						break;
					case 2:
						$section='musicNaudio';
						break;
					case 3:
						$section='writingNpublishing';
						break;
					case 4:
						$section='photographyNart';
						break;
				}
				
			}
			switch ($section) {
				case 'filmNvideo':
					$linkId=($search->elementid == $search->projectid)?$search->userid.'/'.$search->projectid.'/':$search->userid.'/'.$search->projectid.'/'.$search->elementid.'/';
					$getMethodName=($search->elementid == $search->projectid)?'mediashowcases':'mediadetails';
					$projectLink=($search->section=='upcoming')?'#':base_url(lang().'/mediafrontend/'.$getMethodName.'/'.$linkId);
					break;
				case 'musicNaudio':
					$linkId=($search->elementid == $search->projectid)?$search->userid.'/'.$search->projectid.'/':$search->userid.'/'.$search->projectid.'/'.$search->elementid.'/';
					$getMethodName=($search->elementid == $search->projectid)?'aboutalbum':'tracklist';
                    $projectLink=($search->section=='upcoming')?'#':base_url(lang().'/mediafrontend/'.$getMethodName.'/'.$linkId);
					break;
				case 'photographyNart':
					$linkId=($search->elementid == $search->projectid)?$search->userid.'/'.$search->projectid.'/':$search->userid.'/'.$search->projectid.'/'.$search->elementid.'/';
					$getMethodName=($search->elementid == $search->projectid)?'photoartdetails':'photoartelement';
                    $projectLink=($search->section=='upcoming')?'#':base_url(lang().'/mediafrontend/'.$getMethodName.'/'.$linkId);
					break;
				case 'writingNpublishing':
					$linkId=($search->elementid == $search->projectid)?$search->userid.'/'.$search->projectid.'/':$search->userid.'/'.$search->projectid.'/'.$search->elementid.'/';
					$getMethodName=($search->elementid == $search->projectid)?'writingdetails':'writingelement';
                    $projectLink=($search->section=='upcoming')?'#':base_url(lang().'/mediafrontend/'.$getMethodName.'/'.$linkId);
					break;
				case 'educationMaterial':
					$linkId=($search->elementid == $search->projectid)?$search->userid.'/'.$search->projectid.'/':$search->userid.'/'.$search->projectid.'/'.$search->elementid.'/';
					$getMethodName=($search->elementid == $search->projectid)?'educationdetails':'educationelement';
                    $projectLink=($search->section=='upcoming')?'#':base_url(lang().'/mediafrontend/'.$getMethodName.'/'.$linkId);
					break;
				case 'performances&events':
					$linkId=$search->userid.'/'.$search->projectid;
					$projectLink=base_url(lang().'/eventfrontend/events/'.$search->element_type.'/'.$linkId);
					break;
				case 'event':
					$linkId=$search->userid.'/'.$search->projectid;
					$projectLink=base_url(lang().'/eventfrontend/events/'.$search->element_type.'/'.$linkId);
                    $projectLink = "#";
					break;
				case 'launch':
					$linkId=$search->userid.'/'.$search->projectid;
					$projectLink=base_url(lang().'/eventfrontend/events/'.$search->element_type.'/'.$linkId);
                    $projectLink = "#";
					break;
				case 'notification':
					$linkId=$search->userid.'/'.$search->projectid;
					$projectLink=base_url(lang().'/eventfrontend/events/'.$search->element_type.'/'.$linkId);
                    $projectLink = "#";
					break;
				case 'product':
					$linkId=($search->elementid == $search->projectid)?$search->userid.'/'.$search->projectid.'/':$search->userid.'/'.$search->projectid.'/'.$search->elementid.'/';
					$projectLink=base_url(lang().'/productshowcase/viewproject/'.$linkId);
                    $projectLink = "#";
					break;
				case 'blog':
					$linkId=($search->elementid == $search->projectid)?'frontblog/'.$search->userid.'/'.$search->projectid.'/':'frontpost/'.$search->userid.'/'.$search->elementid.'/';
					$projectLink=base_url(lang().'/blogs/'.$linkId);
                    $projectLink = "#";
					break;
				case 'work':
					$linkId=($search->elementid == $search->projectid)?$search->userid.'/'.$search->projectid.'/':$search->userid.'/'.$search->projectid.'/'.$search->elementid.'/';
					$projectLink=base_url(lang().'/workshowcase/viewproject/'.$linkId);
                    $projectLink = "#";
					break;
				case 'news':
					$linkId=($search->elementid == $search->projectid)?$search->userid.'/'.$search->projectid.'/':$search->userid.'/'.$search->projectid.'/'.$search->elementid.'/';
					$getMethodName=($search->elementid == $search->projectid)?'newscollection':'articledetails';
                    $projectLink=($search->section=='upcoming')?'#':base_url(lang().'/mediafrontend/'.$getMethodName.'/'.$linkId);
					break;
				case 'reviews':
					$search->type=($search->elementid != $search->projectid)?$search->type:'';
					$linkId=($search->elementid == $search->projectid)?$search->userid.'/'.$search->projectid.'/':$search->userid.'/'.$search->projectid.'/'.$search->elementid.'/';
					$getMethodName=($search->elementid == $search->projectid)?'reviewscollection':'reviewsdetails';
                    $projectLink=($search->section=='upcoming')?'#':base_url(lang().'/mediafrontend/'.$getMethodName.'/'.$linkId);
					break;
				case 'creatives':
					$linkId=$search->userid.'/';
					$linkId=($search->languageid>1)?$linkId.$search->elementid.'/':$linkId;
					$projectLink=base_url(lang().'/showcase/index/'.$linkId);
					break;
				case 'associatedprofessionals':
					$linkId=$search->userid.'/';
					$linkId=($search->languageid>1)?$linkId.$search->elementid.'/':$linkId;
					$projectLink=base_url(lang().'/showcase/index/'.$linkId);
					break;
				case 'enterprises':
					$linkId=$search->userid.'/';
					$linkId=($search->languageid>1)?$linkId.$search->elementid.'/':$linkId;
					$projectLink=base_url(lang().'/showcase/index/'.$linkId);
					break;
				default:
					$projectLink='#';
			}
		}
		return $projectLink;
	}
}

/** check ia any user has paid for ppv or download for that project or element **/
if(! function_exists('checkDownloadPPVaccess')){
	function checkDownloadPPVaccess($entityId=0,$elementId=0,$projectId=0) {
		$return=false;
		if($entityId > 0 && $elementId > 0 && $projectId > 0){
			$CI =& get_instance();
			if($entityId==54){
				$whereCondition=array('entityId'=>$entityId,'projId'=>$projectId);
				$isElement=false;
			}else{
				$whereCondition=array('entityId'=>$entityId,'elementId'=>$elementId);
				$isElement=true;
			}
			
			$purchaseData=$CI->model_common->getDataFromTabel('SalesItemDownload', 'dwnDate,dwnMaxday,purchaseType,itemInfo', $whereCondition, '', 'dwnDate', 'DESC', 1 );
			
			if($purchaseData){
				$purchaseData=$purchaseData[0];
				$dwnMaxday = $purchaseData->dwnMaxday;
				$currentDate=date('Y-m-d');
				$expiryDate= getPreviousOrFututrDate($purchaseData->dwnDate, '+'.$dwnMaxday.' day' ,$format='d F Y');
				if(strtotime($currentDate) <= strtotime($expiryDate)){
					$return=$expiryDate;
				}
			}elseif($isElement){
				$whereCondition=array('entityId'=>54,'projId'=>$projectId);
				$purchaseData=$CI->model_common->getDataFromTabel('SalesItemDownload', 'dwnId, dwnDate,dwnMaxday,purchaseType,itemInfo', $whereCondition, '', 'dwnDate', 'DESC', 1 );
				
				if($purchaseData){
					$purchaseData=$purchaseData[0];
					$dwnMaxday = $purchaseData->dwnMaxday;
					$itemInfo = $purchaseData->itemInfo;
					
					$currentDate=date('Y-m-d');
					$expiryDate= getPreviousOrFututrDate($purchaseData->dwnDate, '+'.$dwnMaxday.' day' ,$format='d F Y');
					if(strtotime($currentDate) <= strtotime($expiryDate)){
						if($itemInfo !='' && $itemInfo != null && strlen($itemInfo) > 5){
							$itemInfo = json_decode($itemInfo);
							
							if(is_array($itemInfo) && count($itemInfo) > 0){
								foreach($itemInfo as $item){
									if($item->elementId == $elementId){
										/*if($item->isDownloadPrice == 't' || $item->isPerViewPrice == 't'){
											$return=true;
										}*/
										$return=$expiryDate;
										break;
									}
								}
							}
							
						}
					}
				}
			}
		}
		return $return;
	}
}

//To show special charcters name in given limit with given proper characters no improper cutting of text
// 19 April 2013

function substr_unicode($str, $s, $l = null) {
    return join("", array_slice(
    preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY), $s, $l));
}


/*
 ************************************************************
 * This section is used to get section id by project, entityId and elementId
 ************************************************************ 
 */  
 
 
 if(! function_exists('getSectionId')){
	function getSectionId($projectId) {
		
			$CI =& get_instance();
			$getSectionId	=  $CI->model_common->getSectionId($projectId);
			
			if($getSectionId['get_num_rows'] > 0)
			{
				$projectType = $getSectionId['get_result']->projectType;
				
			}else
			{
				$projectType = 'none';
			}
		
			return $projectType;
		}
	}
	
 
 /*
  ********************************************** 
  * This function is used to detect Os name 
  **********************************************
  */  
   
	if(! function_exists('getOsName')){
	function getOsName() {
		
			$ua = $_SERVER["HTTP_USER_AGENT"];

			// ---- For Mobile ----

			// Android
			$android = strpos($ua, 'Android') ? true : false;

			// BlackBerry
			$blackberry = strpos($ua, 'BlackBerry') ? true : false;

			// iPhone
			$iphone = strpos($ua, 'iPhone') ? true : false;

			// Palm
			$palm = strpos($ua, 'Palm') ? true : false;
			
			// ipad
			$ipad = strpos($ua, 'iPad') ? true : false;

			// ---- Desktop ----

			// Linux
			$linux = strpos($ua, 'Linux') ? true : false;

			// Macintosh
			$mac = strpos($ua, 'Macintosh') ? true : false;

			// Windows
			$win = strpos($ua, 'Windows') ? true : false;
			
			if($linux==true || $mac==true || $win==true)
			{
				$osName ="desktop";
			}
			
			if($android==true || $blackberry==true || $iphone==true || $palm==true || $ipad==true)
			{
				$osName ="mobile";
			}
			
			return $osName;
		}
	}
	
	
	/*
	 **************************************
	 *  This function is used to get Device Type
	 *************************************
	 */ 
	
	
	if(! function_exists('getDeviceType')){
	function getDeviceType() {
		
			$ua = $_SERVER["HTTP_USER_AGENT"];

			// ---- For Mobile ----

			// Android
			$android = strpos($ua, 'Android') ? true : false;

			// BlackBerry
			$blackberry = strpos($ua, 'BlackBerry') ? true : false;

			// iPhone
			$iphone = strpos($ua, 'iPhone') ? true : false;

			// Palm
			$palm = strpos($ua, 'Palm') ? true : false;
			
			// ipad
			$ipad = strpos($ua, 'iPad') ? true : false;

			$deviceType ="none";
			
			if($ipad==true)
			{
				$deviceType ="iPhone";
			}
			
			return $deviceType;
		}
	}
	
	
	
	
	
	if(! function_exists('copyFolder')){
		function copyFolder($src,$dst) { 
			if(is_dir($src)){
				 if(!is_dir($dst)){
					if (!mkdir($dst, 0777, true)) {
						die('Failed to create folders...');
					} 
				 }
				$dir = opendir($src); 
				while(false !== ( $file = readdir($dir)) ) { 
					if (( $file != '.' ) && ( $file != '..' )) { 
						if ( is_dir($src . '/' . $file) ) { 
							copyFolder($src . '/' . $file,$dst . '/' . $file); 
						} 
						else { 
							copy($src . '/' . $file,$dst . '/' . $file); 
						} 
					} 
				} 
				closedir($dir);
			}
		}
	}
    if(! function_exists('removeDir')){
		function removeDir($dir) { 
		  if(is_dir($dir)){
			  foreach(glob($dir . '/*') as $file) { 
				if(is_dir($file)) removeDir($file); else unlink($file); 
			  } rmdir($dir);
		  }
		}
	}
	
	if(! function_exists('get_user_browser')){
		function get_user_browser($checkI8=false)
		{
			 $u_agent = $_SERVER['HTTP_USER_AGENT'];
			$ub = '';
			$isIE8=false;
			if(preg_match('/MSIE/i',$u_agent))
			{
				$isIE8 = strpos($u_agent, 'MSIE 9.0') ? false : true;
				$ub = "ie";
			}
			elseif(preg_match('/Firefox/i',$u_agent))
			{
				$ub = "firefox";
			}
			
			elseif(preg_match('/Chrome/i',$u_agent))
			{
				$ub = "chrome";
			}
			elseif(preg_match('/Safari/i',$u_agent))
			{
				$ub = "safari";
			}
			elseif(preg_match('/Flock/i',$u_agent))
			{
				$ub = "flock";
			}
			elseif(preg_match('/Opera/i',$u_agent))
			{
				$ub = "opera";
			}
			if($checkI8){
				return $isIE8;
			}else{
				return $ub;
			}
		}
	}
 
 

/*
 *********
 * This function get user country name by country Id
 ********* 
*/
	if(! function_exists('userCountryName')){
		function userCountryName($countryId) {
			 $CI =& get_instance();
			 
			 $result = $CI->model_common->userCountryName($countryId);
			 if($result['get_num_rows'] > 0)
				{
					$result = $result['get_result']->countryName;
				}else
				{
					$result = "None";
				}
			 
				
			 return $result;
				
		}
	}

/*
 *********
 * This function return embed url 
 ********* 
*/
	if(! function_exists('getEmbedUrl')){
		function getEmbedUrl($videoUrl) {
			if(strpos($videoUrl,'youtube'))
				{
					// This code get video id if exist
					parse_str( parse_url( $videoUrl, PHP_URL_QUERY ), $my_array_of_vars );
					
					if(isset($my_array_of_vars['v']) && $my_array_of_vars['v']!="")
					{
						$dataArray['src'] = 'http://www.youtube.com/embed/'.$my_array_of_vars['v']; 
						$dataArray['isValid'] = true;
					}else
					{
						// This code if enter youtube embed url
						if(strpos($videoUrl,'embed'))
						{
							$dataArray['src'] = $videoUrl; 
							$dataArray['isValid'] = true;
						}else
						{
							$dataArray['src'] = $videoUrl;
							$dataArray['isValid'] = false;
						}
						
						
					}
					
				}else
				{
					//This code for check vimeo video id exist
					if(strpos($videoUrl,'vimeo'))
					{
						sscanf(parse_url($videoUrl, PHP_URL_PATH), '/%d', $video_id);
						if(isset($video_id) && $video_id!="")
						{
							$dataArray['src'] = 'http://player.vimeo.com/video/'.$video_id; 
							$dataArray['isValid'] = true;
						}else
						{
							// This code for vimeo id not exist
							$dataArray['src'] = $videoUrl; 
							$dataArray['isValid'] = true;
						}
						
					}else
					{
						$dataArray['src'] = $videoUrl;
						$dataArray['isValid'] = false;
					}	
				}		
				
			return $dataArray;	
					
		}
	}
	
	/*
	 ****************************** 
	 *  This functino is used to get site_base_url
	 ******************************  
	 */ 
	
	if(! function_exists('site_base_url')){
		
	function site_base_url(){
			//return base_url();
			return 'http://cdnsolutionsgroup.com/toadsquare_branch/dev/';
			
			
		}
	}
		
	
	
// For Secure urls in payment module 
  	
function base_url_secure($url_string=false){
    
    $CI =&get_instance();
    $secureUrlEnable = $CI->config->item('secure_url_enable');
    
    if($secureUrlEnable){
        $secureUrl = str_replace('http','https',base_url_lang($url_string));
    }else{
        $secureUrl = base_url_lang($url_string);
    }
    return $secureUrl;
 
} 

/* Function to get projects image */
if(! function_exists('getProjectImage')){
	function getProjectImage($entityId=0,$elementId=0,$projectId=0,$notificationProjectType='',$imageSize='_m'){
       
		//echo $elementId;die;
		$CI =&get_instance();
		$entity_tableName = getMasterTableName($entityId);
		$tableName= $entity_tableName[0];
		$smallImg = '';
		if(isset($entityId) && isset($elementId) && isset($projectId)){
			switch ($tableName)
			{
				case 'TDS_Posts':
					$projectImage = getImage($smallImg,$CI->config->item('defaultBlogImg'.$imageSize));
					// get post data
					$getProjectDetails = $CI->model_common->getBlogDataForPost($elementId);
					if(!empty($getProjectDetails)) {
						$projectImage = getBlogImage( $getProjectDetails[0],0,$imageSize );
					}
					
				break;
				case 'TDS_Project':
					// get project cover image
					$projectImage = getProjectCoverImage($projectId,$imageSize);
		
				break;
				case 'TDS_FvElement':
					$projectImage = getProjectElementImage($projectId,$entityId,$elementId,$imageSize,'filmNvideoImage');
					
				break;
				case 'TDS_MaElement':
					$projectImage = getProjectElementImage($projectId,$entityId,$elementId,$imageSize,'musicNaudioImage');
					
				break;
				case 'TDS_PaElement':
					$projectImage = getProjectElementImage($projectId,$entityId,$elementId,$imageSize,'photographyNartImage');
					
				break;
				case 'TDS_ReviewsElement':
					$projectImage = getProjectElementImage($projectId,$entityId,$elementId,$imageSize,'defaultReviewsImg');
					
				break;
				case 'TDS_NewsElement':
					$projectImage = getProjectElementImage($projectId,$entityId,$elementId,$imageSize,'defaultNewsImg');
					
				break;
				case 'TDS_WpElement':
					$projectImage = getProjectElementImage($projectId,$entityId,$elementId,$imageSize,'writingNpublishingImage');
					
				break;
				case 'TDS_EmElement':
					$projectImage = getProjectElementImage($projectId,$entityId,$elementId,$imageSize,'educationMaterialImage');
					
				break;
				case 'TDS_LaunchEvent':
					$projectImage = getEventImage($tableName,$elementId,$projectId,'LaunchEventId');
				break;
				case 'TDS_Events':
					$projectImage = getEventImage($tableName,$elementId,$projectId,'EventId');
				break;
				case 'TDS_EventSessions':
					$fileFName = 'eventId';
					$elementFName = 'sessionId';
					$projectFName = '';
					$getProjectDetails = $CI->model_common->getProjectDetails($tableName,$elementId,$projectId,$fileFName,$elementFName,$projectFName);	
					if((isset($getProjectDetails)) && ($getProjectDetails==$projectId))
					{
						$projectImage = getEventImage('TDS_Events',$elementId,$projectId,'EventId');
					}else{
						$projectImage = getEventImage('TDS_LaunchEvent',$elementId,$projectId,'LaunchEventId');
					}
				break;
				case 'TDS_Product':
					$prodFileFName = 'fileId';
					$prodId = 'prodId';
					$prodFName = 'isMain';
					$getProductProDetails = $CI->model_common->getProjectDetails('TDS_ProductPromotionMedia',$elementId,'t',$prodFileFName,$prodId,$prodFName);	
					if(isset($getProductProDetails) && !empty($getProductProDetails))
					{
						$imageDetails = getMediaDetail($getProductProDetails);
						if((!empty($imageDetails[0]->filePath)) && (!empty($imageDetails[0]->fileName)))
						{
							$filePath = ROOTPATH.$imageDetails[0]->filePath.'/'.$imageDetails[0]->fileName;							
						}
						if((isset($filePath)) && (file_exists($filePath))){
							//$projectImage = base_url().$imageDetails[0]->filePath.'/'.$imageDetails[0]->fileName;							
							$imgType = $imageDetails[0]->filePath.'/'.$imageDetails[0]->fileName;
							$projectImage=addThumbFolder($imgType,$imageSize);
							$projectImage=base_url().$projectImage;
							
						}else{
							$projectImage = getProWorkImage($tableName,$elementId,$projectId,'product');
						}
					}else{
						$projectImage = getProWorkImage($tableName,$elementId,$projectId,'product');
					}
				break;
				case 'TDS_Work':
					$workFileFName = 'fileId';
					$workId = 'workId';
					$workFName = 'isMain';
					$getWorkProDetails = $CI->model_common->getProjectDetails('TDS_workPromotionMedia',$elementId,'t',$workFileFName,$workId,$workFName);
					
					if((isset($getWorkProDetails)) && (!empty($getWorkProDetails)))
					{
						$imageDetails = getMediaDetail($getWorkProDetails);
						if((!empty($imageDetails[0]->filePath)) && (!empty($imageDetails[0]->fileName)))
						{
							$filePath = ROOTPATH.$imageDetails[0]->filePath.'/'.$imageDetails[0]->fileName;
						}
						if((isset($filePath)) && (file_exists($filePath))){
							//$projectImage = base_url().$imageDetails[0]->filePath.'/'.$imageDetails[0]->fileName;
							
							$imgType = $imageDetails[0]->filePath.'/'.$imageDetails[0]->fileName;
							$projectImage=addThumbFolder($imgType,$imageSize);
							$projectImage=base_url().$projectImage;
							
							
						}else{
							$projectImage = getProWorkImage($tableName,$elementId,$projectId,'work');
						}
					}else{
						$projectImage = getProWorkImage($tableName,$elementId,$projectId,'work');
					}
				break;
				case 'TDS_UserShowcase':
						$projectImage='';
						$res=getDataFromTabel('UserShowcase','tdsUid', array('showcaseId'=>$elementId), '', '', '',1 );
						if($res){
							$getUserShowcase = showCaseUserDetails($res['0']->tdsUid);
							if(isset($res['0']->tdsUid) && !empty($res['0']->tdsUid))
							{
								$creative=$getUserShowcase['creative'];
								$associatedProfessional=$getUserShowcase['associatedProfessional'];
								$enterprise=$getUserShowcase['enterprise'];
								$userDefaultImage=($creative=='t')?$CI->config->item('defaultCreativeImg'):(($associatedProfessional=='t')?$CI->config->item('defaultAssProfImg'):(($enterprise=='t')?$CI->config->item('defaultEnterpriseImg'):''));
								if(!isset($userDefaultImage) || $userDefaultImage=='') $userDefaultImage=$CI->config->item('defaultMemberImg'.$imageSize);
								if($getUserShowcase['userImage']!='') {
									 $userImage=$getUserShowcase['userImage'];
								}
								$suffix = $imageSize;
								$userImage=addThumbFolder($userImage,$suffix,$thumbFolder ='thumb',$userDefaultImage);  	
								$userImage=getImage($userImage,$userDefaultImage);
							}else{
								$userImage = base_url().'images/var_user_img_default2.jpg';
							}
							$projectImage = $userImage;
						}
				break;
				
				
				default:
					$projectImage = '';
			}
			
		}
		return $projectImage;
	}
}

/* Function to get projects image */
if(! function_exists('getProjectField')){
	function getProjectField($entityId=0){
		$CI =&get_instance();
		$isTableFound=false;
		if(is_numeric($entityId) && $entityId >0){
			$entity_tableName = getMasterTableName($entityId);
			$tableName= $entity_tableName[0];
			
			$publishedField='isPublished';
			
			$isTableFound=true;
			
			switch ($tableName)
			{
				case 'TDS_Blogs':
					$primeryField = 'blogId';
					$archiveField = 'isArchive';
					$publishedField = 'isPublished';
					$ModifiedDateField = 'dateModified';
				break;
				
				case 'TDS_Posts':
					$primeryField = 'postId';
					$archiveField = 'postArchived';
					$ModifiedDateField = 'dateModified';
				break;
				
				case 'TDS_UserShowcase':
					$primeryField = 'showcaseId';
					$archiveField = 'isArchive';
					$ModifiedDateField = 'dateModified';
				break;
				
				case 'TDS_UserShowcaseLang':
					$primeryField = 'showcaseLangId';
					$archiveField = 'isArchive';
					$ModifiedDateField = 'dateModified';
				break;
				
				case 'TDS_WorkProfile':
					$primeryField = 'workProfileId';
					$archiveField = 'isArchive';
					$ModifiedDateField = 'dateModified';
				break;
				
				case 'TDS_UpcomingProject':
					$primeryField = 'projId';
					$archiveField = 'projArchived';
					$ModifiedDateField = 'projModifiedDate';
				break;
				
				case 'TDS_Project':
					$primeryField = 'projId';
					$archiveField = 'isArchive';
					$ModifiedDateField = 'projLastModifyDate';
				break;
				
				case 'TDS_FvElement':
				case 'TDS_MaElement':
				case 'TDS_PaElement':
				case 'TDS_ReviewsElement':
				case 'TDS_NewsElement':
				case 'TDS_WpElement':
				case 'TDS_EmElement':
					$primeryField = 'elementId';
					$archiveField = 'isArchive';
					$ModifiedDateField = 'modifyDate';
				break;
				
				case 'TDS_LaunchEvent':
					$primeryField = 'LaunchEventId';
					$archiveField = 'isArchive';
					$ModifiedDateField = 'LaunchEventModified';
				break;
				
				case 'TDS_Events':
					$primeryField = 'EventId';
					$archiveField = 'isArchive';
					$ModifiedDateField = 'EventDateModified';
				break;
				
				case 'TDS_Product':
					$primeryField = 'productId';
					$archiveField = 'productArchived';
					$ModifiedDateField = 'productModifiedDate';
				break;
				
				case 'TDS_Work':
					$primeryField = 'workId';
					$archiveField = 'workArchived';
					$ModifiedDateField = 'workModifiedDate';
				break;
				
				default:
					$isTableFound=false;
				break;
			}
			
		}
		
		if($isTableFound){
			$returnData['table']=$tableName;
			$returnData['primeryField']=$primeryField;
			$returnData['publishedField']=$publishedField;
			$returnData['archiveField']=$archiveField;
			$returnData['ModifiedDateField']=$ModifiedDateField;
		}else{
			$returnData=false;
		}
		return $returnData;
	}
}

/* Function to get projects image */
if(! function_exists('getSection')){
	function getSection($entityId=0,$elememtId=0){
		
		
		$CI =&get_instance();
		$section=false;
		if(is_numeric($entityId) && $entityId >0){
			$entity_tableName = getMasterTableName($entityId);
			$tableName= $entity_tableName[0];
			
		
			switch ($tableName){
				case 'TDS_Blogs':
					$section='blog';
				break;
				
				case 'TDS_Posts':
					$section='post';
				break;
				
				case 'TDS_UserShowcase':
					$section='showcase';
				break;
				
				case 'TDS_WorkProfile':
					$section='workprofile';
				break;
				
				case 'TDS_UpcomingProject':
					$section='upcoming';
				break;
				
				case 'TDS_Project':
					if(is_numeric($elememtId) && $elememtId >0){
						$data=$CI->model_common->getDataFromTabel('Project', 'projectType', array('projId'=>$elememtId),'', '', '', 1);
						if($data && isset($data[0]->projectType)){
							$section = $data[0]->projectType;
						}
					}
					
				break;
				
				case 'TDS_FvElement':
					$section='filmNvideo';
				break;
				
				case 'TDS_MaElement':
					$section='musicNaudio';
				break;
				
				case 'TDS_PaElement':
					$section='photographyNart';
				break;
				
				case 'TDS_ReviewsElement':
					$section='reviews';
				break;
				
				case 'TDS_NewsElement':
					$section='news';
				break;
				
				case 'TDS_WpElement':
					$section='writingNpublishing';
				break;
				
				case 'TDS_EmElement':
					$section='educationMaterial';
				break;
				
				case 'TDS_LaunchEvent':
					$section='launch';
				break;
				
				case 'TDS_Events':
					$section='event';
				break;
				
				case 'TDS_Product':
					$section='product';
				break;
				
				case 'TDS_Work':
					$section='work';
				break;
				
				case 'TDS_Competition':
					$section='competition';
				break;
				
				case 'TDS_CompetitionEntry':
					$section='competitionentry';
				break;
				
				default:
					$section=false;
				break;
			}
			
		}
		
		return $section;
	}
}

 /* Function to get Media details */
if(! function_exists('checkMediaDetails')){
	function checkMediaDetails($tableName,$elementId,$projectId,$industryType){
	
		$CI =&get_instance();
		
		if($tableName=='TDS_PaElement')	{
			$entityId = '47';
			$getElementData = $CI->model_common->getProjectElementImage($projId,$entityId,$elementId);
			if($getElementData->isExternal=="t"){
				$projectImage = checkExternalImage($getElementData->filePath,'_s');
			}else{
				$smallImg = $getElementData->filePath.$getElementData->fileName;
				if(file_exists($smallImg)){
					$projectImage = getImage($smallImg,$CI->config->item($industryType));
				}else{
					$projectImage = getImage($smallImg,$CI->config->item($industryType));
				}
			}
		}else{	
			$fileFName = 'imagePath';
			$elementFName = 'elementId';
			$projectFName = 'projId';
			$getProjectDetails = $CI->model_common->getProjectDetails($tableName,$elementId,$projectId,$fileFName,$elementFName,$projectFName);	
			$filePath = ROOTPATH.$getProjectDetails;
			if((file_exists($filePath)) && (!empty($getProjectDetails)) && (isset($getProjectDetails))){
				$projectImage = base_url().$getProjectDetails;
			}else{
				$smallImg = '';
				$projectImage = getImage($smallImg,$CI->config->item($industryType));
			}
		}
		
		return $projectImage;
	}
}

/* Function to get Event Images */
if(! function_exists('getEventImage')){
	function getEventImage($tableName,$elementId,$projectId,$elementFName){
		$CI =&get_instance();
		if($projectId==$elementId){
			$projectId = 0;
		}
		$fileFName = 'FileId';
		$projectFName = '';
		//echo $tableName.'||'.$elementId.'||'.$projectId.'||'.$elementFName.'=========';
		$getProjectDetails = $CI->model_common->getProjectDetails($tableName,$elementId,$projectId,$fileFName,$elementFName,$projectFName);	
		
		if(!empty($getProjectDetails)){
			$imageDetails = getMediaDetail($getProjectDetails);
		}else{
			$imageDetails = '';
		}
		//var_dump($imageDetails);
		if((!empty($imageDetails[0]->filePath)) && (!empty($imageDetails[0]->fileName)))
		{
			$filePath = ROOTPATH.$imageDetails[0]->filePath.'/'.$imageDetails[0]->fileName;
		}
		
		
		if((isset($filePath)) && (file_exists($filePath)) && (isset($getProjectDetails))){
			$default_urgent_Image = $CI->config->item('performanceseventsImage');
			$thumbImage = addThumbFolder(@$imageDetails[0]->filePath.@$imageDetails[0]->fileName,'_s');	
			$projectImage = getImage(@$thumbImage,$default_urgent_Image);
		}else{
			//echo "test";
			$smallImg = '';
			if(isset($projectId)) {
				$projectEventId = $projectId;
			}else {
				$projectEventId = $elementId;
			}
			if($elementFName = 'EventId') {
				$getProjectImage = getEventsPrimaryImage($projectEventId,'.eventId');
			} elseif($elementFName = 'LaunchEventId') {
				$getProjectImage = getEventsPrimaryImage($projectEventId,'.launchEventId');
			} else {
				$getProjectImage = '';
			}
			if(isset($getProjectImage) && !empty($getProjectImage)){
				$eventImage = $getProjectImage;
			}else{
				$eventImage=$smallImg;				
			}
			$projectImage = getImage(@$eventImage,$CI->config->item('performanceseventsImage'));
		}
		return $projectImage;
	}
}

/* Function to get Products and Works Images */
if(! function_exists('getProWorkImage')){
	function getProWorkImage($tableName,$elementId,$projectId,$type){
		$CI =&get_instance();
		$projectImage = '';
		$smallImg = '';
		if($type=='product')
		{
			$fileFName = 'catId';
			$elementFName = 'productId';
			$projectFName = '';
			$getProjectDetails = $CI->model_common->getProjectDetails($tableName,$elementId,$projectId,$fileFName,$elementFName,$projectFName);	
			if(isset($getProjectDetails))
			{
				if(isset($getProjectDetails) && $getProjectDetails==1){
					$projectImage = getImage($smallImg,$CI->config->item('defaultProductForSale'));
				}elseif(isset($getProjectDetails) && $getProjectDetails==2){
					$projectImage = getImage($smallImg,$CI->config->item('defaultProductWanted'));
				}else{
					$projectImage = getImage($smallImg,$CI->config->item('defaultProductFree'));
				}
			}
		}else{
			$fileFName = 'workType';
			$elementFName = 'workId';
			$projectFName = '';
			$getProjectDetails = $CI->model_common->getProjectDetails($tableName,$elementId,$projectId,$fileFName,$elementFName,$projectFName);
			if(isset($getProjectDetails))
			{
				if($getProjectDetails=='offered'){
					$projectImage = getImage($smallImg,$CI->config->item('defaultWorkOffered_xs'));
				}else{
					$projectImage = getImage($smallImg,$CI->config->item('defaultWorkWanted_xs'));
				}
			}
		}
		return $projectImage;
	}
}

if(! function_exists('htmlEntityDecode')){
	function htmlEntityDecode($data){ 
	 if(is_object($data) || is_array($data)){
		 foreach($data as &$value)
		 $value = htmlEntityDecode($value);
	 }else $data = html_entity_decode($data, ENT_QUOTES, 'UTF-8');
	 return $data;
	}
}

function getFileType($fileName){ 
	
	$fileType=0;
	if($fileName != ''){
		$CI =&get_instance();
		$path_parts = pathinfo($fileName);
		$extension = strtolower($path_parts['extension']);
		$imageAccept=$CI->config->item('imageAccept');
		$videoAccept=$CI->config->item('videoAccept');
		$audioAccept=$CI->config->item('audioAccept');
		$docAccept=$CI->config->item('docAccept');
		
		if(strstr($imageAccept,$extension)){
			$fileType=1;
		}elseif(strstr($videoAccept,$extension)){
			$fileType=2;
		}elseif(strstr($audioAccept,$extension)){
			$fileType=3;
		}
		elseif(strstr($docAccept,$extension)){
			$fileType=4;
		}
	}
	return $fileType;
}


/*
 **************************************************
 *  This function is used to get src of external video and audio
 ************************************************** 
 */  
 
 if(! function_exists('getExternalMediaSrc')){
		function getExternalMediaSrc($filePath,$mediaId,$elementEntityId,$elementId,$projectId)
		{
			//this section is for external video
			$getMediaUrlData = getMediaUrl($filePath);
			
			if($getMediaUrlData['isUrl'])
			{
				//url is valid 
				$headerDetails = @get_headers($filePath,1);
				if(isset($headerDetails['X-Frame-Options']))
				{
					// This code will show error 
					$src[0] = base_url().'en/player/videoError/';
					$src[1] = true;

				}else
				{
					// This code will play url 
					$src[0] = $filePath;
					$src[1] = true;

				}
				 
			}else
			{	
				$getSrc = $getMediaUrlData['getsource'];
				if($getMediaUrlData['embedtype'] == 'iframe')
				{
					 // This code will play embeded ifram code
					 $src[0] = $getSrc;
					 $src[1] = true;
				}else
				{
					// This code will play other type of embed code
					$src[0] = base_url().'en/player/commonPlayerIframe/'.$mediaId.'_full/'.$elementEntityId.'/'.$elementId.'/'.$projectId;
					$src[1] = true;
				} 
			}
			
			return $src;
			
			
	}
} 
 
 
 /*
 ****************************** 
 *  This function is used to Set Cookie for Results per page 
 ******************************  
 */ 
	
if(! function_exists('setPerPageCookie')){

	function setPerPageCookie($setName='',$defPerPage=10){ 
		
		$CI =&get_instance();				    
		$userId = isLoginUser();	
		$isCokkie = $CI->input->cookie($userId.$setName, TRUE);
		$ipp=$CI->input->post('ipp');
		
		if(is_numeric($ipp) && ($ipp > 0)){			
			setcookie($userId.$setName, $ipp, time()+(3600*24*365),"/");			
		}else{		
			$ipp=$defPerPage;
		}
		
		if(is_numeric($isCokkie) && ($isCokkie > 0)){			
								
		}else{		
			$isCokkie=$ipp;
		}
		
       return $isCokkie; 
	}
}
 
 
 /*
 ****************************** 
 *  This function is used to Set Cookie for Results per page 
 ******************************  
 */ 
	
if(! function_exists('getPerPageCookie')){

  function getPerPageCookie($getName='',$defPerPage=10){ 
		
		$CI =&get_instance();				    
		$userId = isLoginUser();	
		$currentCookieVal = $CI->input->cookie($userId.$getName, TRUE);
		
			if($currentCookieVal!=''){
				$newCookieVal = $currentCookieVal;
			}else {				
			   $newCookieVal=$defPerPage;
			}
			 
		return $newCookieVal;
	}

} 

if ( ! function_exists('getContinentList')){		 
	/*
	 *  function for get Continent List.
	 */
		function getContinentList()
		{
			$CI =&get_instance();
			$res =  $CI->model_common->getDataFromTabel('MasterContinent', 'id,continent','status','t','continent');
			if($res){
				$continents[''] = $CI->lang->line('selectContinent');
				foreach ($res as $continent) {
						$continents[$continent->id] = $continent->continent;
				}
				return $continents;
			}else{
				return false;
			}
		}
	}

/*
 **********************************
 * This functino is used to change show html special character
 ********************************** 
 */  
 
 
 if ( ! function_exists('string_decode')){		 
	/*
	 *  function for string decode.
	 */
		function string_decode($string='')
		{
			$string = html_entity_decode($string);
			return $string;
		}
	}
 
/*
 **********************************
 * This functino is used to replace unwanted string character
 ********************************** 
 */  
 
 
 if ( ! function_exists('string_replace')){		 
	/*
	 *  function for string replace.
	 */
		function string_replace($string='')
		{
			$string = str_replace('�','',$string);
			return $string;
		}
	}  
 


if ( ! function_exists('getContinentList')){		 
	/*
	 *  function for get Continent List.
	 */
		function getContinentList()
		{
			$CI =&get_instance();
			$res =  $CI->model_common->getDataFromTabel('MasterContinent', 'id,continent','status','t','continent');
			if($res){
				$continents[''] = $CI->lang->line('selectContinent');
				foreach ($res as $continent) {
						$continents[$continent->id] = $continent->continent;
				}
				return $continents;
			}else{
				return false;
			}
		}
	}

/*
 ********************************** 
 * This function is used to open pdf file in Mobile IOS devices 
 ********************************** 
 */ 


if ( ! function_exists('getIsOpenPdf')){		 
	
		function getIsOpenPdf($mediaId="")
		{
			$getUserIdByShow=getMediaDetail(@$mediaId);
			$returnArray= "";
			//This code for open pdf file in Ipade and iphone directy
			if($getUserIdByShow)
			{
				if(getOsName()=="mobile")
				{
					$ua = $_SERVER["HTTP_USER_AGENT"];
					
					// Android
					$android = strpos($ua, 'Android') ? true : false;
					
					if($android==true)
					{
						$returnArray['getSrc'] = "";
						$returnArray['isShowPdf'] = "no";
					}else
					{
						$getUserIdByShow = $getUserIdByShow[0];
						if($getUserIdByShow->fileType=="4")
						{
							$returnArray['getSrc'] = base_url().$getUserIdByShow->filePath.'/'.$getUserIdByShow->fileName;
							$returnArray['isShowPdf'] = "yes";
						}else
						{
							$returnArray['getSrc'] = "";
							$returnArray['isShowPdf'] = "no";
						}
					}
					
				}else
				{
					$returnArray['getSrc'] = "";
					$returnArray['isShowPdf'] = "no";
				}
				
				
			}else
			{
				$returnArray['getSrc'] = "";
				$returnArray['isShowPdf'] = "no";
			}
			
			return $returnArray;
		}
	}
	
	
/*
 ********************************** 
 * This function is used to open pdf file in Mobile IOS devices 
 ********************************** 
 */ 


if ( ! function_exists('getIsAssociatedMembers')){		 
	
		function getIsAssociatedMembers($from_showcaseid=0)
		{
			
			$CI =&get_instance();
			$CI->load->model('showcase/model_showcase');
			$result = $CI->model_showcase->getAssociatedMembers($from_showcaseid);
			return $result;
		}	
	}	
	



if ( ! function_exists('getMediaImage')){		 
/* Function for View gallery image returns blank if no image exists
 * Wriiten By Amit Wali 
 */
	function getMediaImage($imagePath='')
	{			
		if(!@empty($imagePath) && (@is_file($imagePath))){
			$imagepath = base_url($imagePath);
		}else{
			
			$imagepath = '';
		}
		//$imagepath = str_replace('\\','/',$imagepath );
		return $imagepath;
	}
}

/*
 * Function for check users project data
 */ 
if ( ! function_exists('checkUsersProjects')){		
	function checkUsersProjects($table,$where)
	{
		$getDetails = getDataFromTabel($table, '*',  $where, '', $orderBy='', '', 1 );
			if(empty($getDetails)){
				redirectToNorecord404();
			}
	}
}


/*
 * Function to change url in text to link 
 * @Amit
 */ 
if ( ! function_exists('changeToUrl')){
	
   function changeToUrl($text)	{
	  return  preg_replace(
		 array(
		   '/(?(?=<a[^>]*>.+<\/a>)
				 (?:<a[^>]*>.+<\/a>)
				 |
				 ([^="\']?)((?:https?|ftp|bf2|):\/\/[^<> \n\r]+)
			 )/iex',
		   '/<a([^>]*)target="?[^"\']+"?/i',
		   '/<a([^>]+)>/i',
		   '/(^|\s)(www.[^<> \n\r]+)/iex',
		   '/(([_A-Za-z0-9-]+)(\\.[_A-Za-z0-9-]+)*@([A-Za-z0-9-]+)
		   (\\.[A-Za-z0-9-]+)*)/iex'
		   ),
		 array(
		   "stripslashes((strlen('\\2')>0?'\\1<a href=\"\\2\">\\2</a>\\3':'\\0'))",
		   '<a\\1',
		   '<a\\1 target="_blank" class="dash_link_hover">',
		   "stripslashes((strlen('\\2')>0?'\\1<a class=\"dash_link_hover\" href=\"http://\\2\">\\2</a>\\3':'\\0'))",
		   "stripslashes((strlen('\\2')>0?'<a href=\"mailto:\\0\">\\0</a>':'\\0'))"
		   ),
		   $text
	   );
	}
}


/* Get ProductId based on Section */
if ( ! function_exists('getTSProductId')){
 function getTSProductId($sectionId='0'){
		$CI =&get_instance();
		$pkg=$CI->db->dbprefix('MasterPackage');
		$role=$CI->db->dbprefix('MasterPackgesRole');
		$product=$CI->db->dbprefix('MasterTsProduct');

		$table =' "'.$pkg.'" LEFT JOIN "'.$role.'" ON ("'.$role.'"."pkgId" = "'.$pkg.'"."pkgId" )';
		$table .=' LEFT JOIN "'.$product.'" ON ("'.$product.'"."tsProductId" = "'.$role.'"."tsProductId" )';
		$field ='"'.$product.'"."tsProductId"';
		$where ='WHERE \''.$sectionId.'\' = ANY ("allowedSections") ';			
		$where .=' AND "'.$pkg.'"."pkgActiveStatus" = \'t\' AND "'.$pkg.'"."isFree"=\'f\' ';

		$userContainers=$CI->model_common->getDataFromMixTabel($table,$field,$where);	

		if(is_array($userContainers) && count($userContainers)>0){				
			return $userContainers[0]->tsProductId;				
				}else {
			return 0;
		}
	}
 }


/*
 * Function to get competition projects
 */ 
if ( ! function_exists('getCompetitionProjects')){		
	function getCompetitionProjects($industry)
	{
		$CI =&get_instance();
		$res = $CI->model_competition->getCompetitionProjects($industry);
		return $res;
			
	}
}

/*
 * Function to set visitors log Add by AMIT 
 */ 
if ( ! function_exists('getVisitorsIp')){		
	function getVisitorsIp()
	{
	   $CI =&get_instance();	
	   $iPinfo = getIpInfo();		 
	   $CI->model_common->checkIpAddr($iPinfo);
	   return true;	
	}
}

/*
 * Function to get  visitors info based on Ip Address 
 * @ Amit
 * Used API for getting info 
 */ 
if (!function_exists('getIpInfo')){		
	function getIpInfo(){		
		$CI =&get_instance();		
		$IpSignature = $CI->config->item('IpAPISignature');
		$iP = $CI->input->ip_address(); 
		$ch = curl_init();
		$pageurl = "http://api.ipinfodb.com/v3/ip-city/?key=$IpSignature&ip=$iP&format=json";
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_URL, $pageurl );
		$data = curl_exec ($ch);
		curl_close($ch); 	
		return $data ;  	   	
	}
}


/*
 * Function to get competition projects
 */ 
if ( ! function_exists('getFacebookLoginUrl')){		
	function getFacebookLoginUrl($redirect_url='/auth/LoginOrRegisterWithFB'){
		$redirect_url = base_url(lang().$redirect_url);
		$CI =&get_instance();
		
		$config = $CI->config->item('facebook');
        $CI->load->library('lib_facebook', $config);
       
       $params = array(
			'redirect_uri' => $redirect_url,
			'scope' => 'email,publish_stream,publish_actions,user_photos,offline_access',
			'display' => 'popup'
		);
        //displya:async, iframe, page, popup, touch, wap
        
		//$params = array('redirect_uri' => $redirect_url,'scope' => 'email,publish_stream,publish_actions,user_photos','display' => 'popup');
		
		$url = $CI->lib_facebook->getLoginUrl($params);
		return $url;
			
	}
}


/*
 ******************** 
 * This function is used to get project image
 ******************** 
 */ 
 
 if ( ! function_exists('getProjectElementImage')){		
	function getProjectElementImage($projId=0,$entityId=0,$elementId=0,$sufix='_s',$defaultImageType=''){
		$CI =&get_instance();
		$getElementData = $CI->model_common->getProjectElementImage($projId,$entityId,$elementId);
		$imageType = $CI->config->item($defaultImageType.$sufix);
		$thumbImage = '';
		if(!empty($getElementData) && isset($getElementData->imagePath)){
			if(empty($getElementData->imagePath)){
				$getThumbImage = getVideoThumbFolder($getElementData->filePath.$getElementData->fileName,$sufix);			
				if(file_exists($getThumbImage)){
					$thumbImage = $getThumbImage;
				}
				
				//------------For photograph and art section----------//
				$entity_tableName = getMasterTableName($entityId);
				if($entity_tableName && isset($entity_tableName[0])){
					$getTableName = $entity_tableName[0];
					if($getTableName=='TDS_PaElement'){
						if($getElementData->isExternal=="t"){
							$thumbImage = array("filePath"=>$getElementData->filePath,"isExternal"=>"t");	
						}else{
							if(empty($thumbImage)){
								$thumbImage = $getElementData->filePath.$getElementData->fileName;
							}
						}
					}
				}
				
			}else{
				if(file_exists($getElementData->imagePath)){
					$thumbImage =  $getElementData->imagePath;
				}
			}
		
			$elementImage  =  getImage($thumbImage,$imageType); // set blank value as default	
			return $elementImage;
		}else{
		    return false;
		}
	}
}


/*
 ***************************** 
 * This function is used to get element image by project type 
 ***************************** 
 */ 
 
 
 if ( ! function_exists('getElementImageByType')){		
	function getElementImageByType($projId,$projType){
		
		switch ($projType)
		{
			case 'filmNvideo':
			case '1':
				$entityId='12';
				$projectImage = getProjectElementImage($projId,$entityId);
			break;
			case 'musicNaudio':
			case '2':
				$entityId='25';
				$projectImage = getProjectElementImage($projId,$entityId);
			break;
			case 'photographyNart':
			case '4':
				$entityId='47';
				$projectImage = getProjectElementImage($projId,$entityId);
			break;
			case 'writingNpublishing':
			case '3':
				$entityId='84';
				$projectImage = getProjectElementImage($projId,$entityId);
			break;
			case 'news':
				$entityId='94';
				$projectImage = getProjectElementImage($projId,$entityId);
			break;
			case 'reviews':
				$entityId='95';
				$projectImage = getProjectElementImage($projId,$entityId);
			break;
			case 'educationMaterial':
			case '10':
				$entityId='7';
				$projectImage = getProjectElementImage($projId,$entityId);
			break;
			default:
				$projectImage = false;
		}
		return $projectImage;
	}
}
 
 
 


function save_image_form_url($url,$imageDir) {
	$return=false;
	$info=pathinfo($url);
	$fileName=$info['basename'];
	
	if(!is_dir($imageDir)){
		mkdir($imageDir, 0777, true);
	}
	  $file=$imageDir.$fileName;
	  $inbuf = file_get_contents($url);
	  $fp = fopen($file,'wb');
	  if(fwrite($fp,$inbuf)){
		  $return=true;
	  }
	  fclose($fp);
  
  return $return;
  
  /*$in  = fopen($inPath,  "rb");
  $out = fopen($outPath, "wb");

  while (!feof($in)) {
    $read = fread($in, 8192);
    fwrite($out, $read);
  }

  fclose($in);
  fclose($out); */
  
}

if(! function_exists('asort2ascending')){ 

	function asort2ascending($records, $field, $reverse=false) {
			  $hash = array();
			  foreach($records as $key => $record) {
				$hash[$record[$field].$key] = $record;
			  }
			  ($reverse)? krsort($hash) : ksort($hash);
			  $records = array();
			  foreach($hash as $record) {
				$records []= $record;
			  }
			  return $records;
			}
			
		}	
	
	
	/*
	 **************************
	 * This function used show time formate 
	 ************************** 
	 */  
	 
	if(! function_exists('getTimeFormate')){
		
		function getTimeFormate($timeValue)
		{
			if(!empty($timeValue)){
				$getTimeArr= explode(":",$timeValue);
				if(is_array($getTimeArr)){
					if($getTimeArr[0]=="00"){
						$timeValue = $getTimeArr[1].' min '.$getTimeArr[2].' sec';
					}else{
						$timeValue = $getTimeArr[0].' hour '.$getTimeArr[1].' min '.$getTimeArr[2].' sec';
					}
				}
			}
			return $timeValue;
		}
	}
	
	
	
	/*
	 ******************************
	 * This function is use to check competition is published and it has one entry
	 ****************************** 
	 */  
	
	if(! function_exists('isCompetitionPublished')){
		
		function isCompetitionPublished($competitionId)
		{
			$isPublished=false;
			//get competition published status
			$getPublishedStatus = getDataFromTabel('Competition','isPublished', 'competitionId', $competitionId, 'competitionId', 'ASC',1,0,true);
			if($getPublishedStatus){
			// get competition entry count
			$whereCondition = array('competitionId'=>$competitionId,'isPublished'=>'t','isBlocked'=>'f','isArchive'=>'f');
			$getEntriesCount = countResult('CompetitionEntry',$whereCondition);
				if($getPublishedStatus[0]['isPublished']=="t" && $getEntriesCount){
					$isPublished=true;
				}
			}				
			return $isPublished;
		}
		
	}	
		
	/*
	******************** 
	* This function is used to get events primary image
	******************** 
	*/ 
	if ( ! function_exists('getEventsPrimaryImage')){		
		function getEventsPrimaryImage($projId=0,$fieldName='',$entityId=0,$sufix='_m'){
			$CI =&get_instance();
			if(isset($projId) && !empty($projId) && !empty($fieldName)) {
				$getElementData = $CI->model_common->getEventPrimaryImage($projId,$fieldName,$entityId);
				if(!empty($getElementData) && isset($getElementData->filePath) && isset($getElementData->fileName)){
					$filePath=trim($getElementData->filePath);
					$fileName=trim($getElementData->fileName);
					if(is_dir($filePath) && $fileName !=''){
						$fpLen=strlen($filePath);
						if($fpLen > 0 && substr($filePath,-1) != DIRECTORY_SEPARATOR){
							$filePath=$filePath.DIRECTORY_SEPARATOR;
						}
						$projImage=$filePath.$fileName;
					}else{
						$projImage='';
					}
					$thumbImage = addThumbFolder($projImage,$sufix);		
					return $thumbImage;
				}else{
					return false;
				}
			} else {
				return false;
			}
		}
	}
	
	/*
	******************** 
	* This function is used to get users work profile id
	******************** 
	*/ 
	if ( ! function_exists('getUserWorkProfileId')){	
		function getUserWorkProfileId($userId=0){
			
			$CI =&get_instance();
			$res =  $CI->model_common->getDataFromTabel('WorkProfile', 'workProfileId','tdsUid',$userId,'');
			if($res){
				return$res;
			}else{
				return false;
			}
		}
	}
	
	/*
	******************** 
	* This function is used to get users social media links
	******************** 
	*/
	if ( ! function_exists('getProfileSocialMediaLinks')){	 
		function getProfileSocialMediaLinks($entityId=0,$workProfileId=0) {	
			$CI =&get_instance();
			$socialLinkResult = $CI->model_common->getProfileSocialMediaLinks($entityId,$workProfileId);
			return $socialLinkResult;
		}
	}
	 
	 
	/*
	****************************************
	* This function is used to show enterprise name 
	**************************************** 
	*/  
	if ( ! function_exists('getUserEnterpriseName')){	
	function getUserEnterpriseName($userId=0){
		
			$userDetail = showCaseUserDetails($userId);
			
			if($userDetail['enterprise']=='t'){
				$userName = $userDetail['enterpriseName'];
			}else{
				$userName = $userDetail['userFullName'];
			}
			return $userName;
		}
	}
	
	
	  
	  
	/*
	  ****************************************
	  * This function is used to get userPlaylist
	  **************************************** 
	  */  
	if ( ! function_exists('getMyPlaylistCount')){	
		  
	function getMyPlaylistCount($userId=0){
			
			$CI =&get_instance();
			$CI->load->model('media/model_media');
			$getUserCravedData = $CI->model_media->myplaylist($userId);
			$myplaylistcount=0;
			if($getUserCravedData && !empty($getUserCravedData)){
				foreach($getUserCravedData as $userCravedData)
					{
						// get audio file path
							$MainFilePath 	=	$userCravedData['filePath'].$userCravedData['fileName'];
							
							// check media file exist
							if(file_exists($MainFilePath)) {
								$myplaylistcount++;
							}	
					}	
					if($myplaylistcount > 0){
						return	$myplaylistcount;
					}else{
						return false;
					}
			}else{
				return false;
			}
			
		}
	}
	
	if ( ! function_exists('getSearchIndustryList')){		 
		/* 
		 * function to get industry for sarch section.
		 */
		function getSearchIndustryList(){
			
			$CI =& get_instance();
			$data[''] = $CI->lang->line('selectIndustry');
			$whereField = array('isSearchSection'=>'t');
			
			$res = $CI->model_common->getDataFromTabel('MasterIndustry', 'IndustryId,IndustryName',  $whereField, '', 'IndustryName','ASC');
			if($res){
				foreach ($res as $industry){
					$data[$industry->IndustryId] = $industry->IndustryName;
				}
				
			}
			return $data;
		}
	}  
	
	if ( ! function_exists('getBlogIndustryList')){		 
	/* 
	 * function to get blog industries.
	*/
		function getBlogIndustryList($section=''){
			$CI =& get_instance();
			$whereField = array('isBlogIndustry'=>'t');
			if(isset($section) && !empty($section) && $section='search') {
				$res = $CI->model_common->getDataFromTabel('MasterIndustry', 'IndustryId,IndustryName',  $whereField, '', 'IndustryOrder','ASC');
				if($res){
					foreach ($res as $industry){
						$data[$industry->IndustryId] = $industry->IndustryName;
					}
					
				}
			}else{
				$data = getDataFromTabel('MasterIndustry','IndustryId,IndustryName,IndustryKey',$whereField,'','IndustryOrder','ASC');
			}
			return $data;
		}
	}
	
	/*
	 ************************
	 * This function is used to get user sing In meeting point count 
	 ************************ 
	 */  
	
	if ( ! function_exists('userSignInSessionCount')){		 

		function userSignInSessionCount(){
			$userId = isLoginUser();
			$CI =& get_instance();
			$field = array('user_id'=>$userId);
			$result = $CI->model_common->countResult('MeetingPoint',$field);
			if($result > 0){
				$countResult = $result;
			}else{
				$countResult = 0;
			}
			return $countResult;
		}
	}
	
	
	/*
	 ************************
	 * This function is used to get user sing In meeting point count 
	 ************************ 
	 */  
	
	if ( ! function_exists('getUserShowcaseImage')){		 

		function getUserShowcaseImage($userData=''){
			$userImage='';
			if($userData){
				
				if(is_numeric($userData['stockImageId']) && ($userData['stockImageId'] > 0) )
					{
						$userImage=$userData['stockImgPath'].DIRECTORY_SEPARATOR.$userData['stockFilename'];	
					}
					else
					{
						$profileImagePath  = 'media/'.$userData['username'].'/profile_image/';
						$userImage=$profileImagePath.$userData['profileImageName'];	
					}
			}
			
			return $userImage;
			
		}
	}
	
	function limit_words( $str, $num, $append_str='...' )
	{
	  $words = preg_split( '/[\s]+/', $str, -1, PREG_SPLIT_OFFSET_CAPTURE );
	  if( isset($words[$num][1]) )
	  {
		$str = substr( $str, 0, $words[$num][1] ) . $append_str;
	  }
	  unset( $words, $num );
	  return trim( $str );
	}

	/*
	******************** 
	* This function is used to get media project details
	******************** 
	*/ 
	if ( ! function_exists('getProjectDataStatus')){	
		function getProjectDataStatus($entityId=0,$projId=0,$userId=0){
			$getMasterTableName = getMasterTableName($entityId);
			$CI =&get_instance();
			if ($entityId==82) {
				$wherePrimaryField = 'workId';
			} elseif ($entityId==49) {
				$wherePrimaryField ='productId';
			} elseif ($entityId==54){
				$wherePrimaryField = 'projId';
			} elseif ($entityId==9){
				$wherePrimaryField = 'EventId';
			} elseif ($entityId==15){
				$wherePrimaryField = 'LaunchEventId';
			}
			$whereField = array($wherePrimaryField=>$projId,'tdsUid'=>$userId);
			$res =  $CI->model_common->getDataFromTabel($getMasterTableName, 'isPublished',$whereField,'');
			if($res){
				return $res;
			}else{
				return false;
			}
		}
	}
	 
	 	
	 	
	/*
	******************** 
	* This function is get image width by remove absulte path
	******************** 
	*/ 
	if ( ! function_exists('getImageWidth')){	
		function getImageWidth($imagePath){
			$getWidth = '277';
			$thumbFinalImgGet 	= $imagePath;
			$thumbFinalImgPath 	=  str_replace(base_url(),'',$thumbFinalImgGet);
			list($getWidth) = getimagesize($thumbFinalImgPath);
			return $getWidth;
		}
	} 	

/*
 * @description: This helper is used to show openx image
 * @param : advertImage string 
 * @return : image url
 * 
 */  


if ( ! function_exists('getAdvertImage')){		 
		function getAdvertImage($advertImage=''){
			$CI =& get_instance();
			$noImage = $CI->config->item('no_image_40_40');
			$pathinfo = pathinfo($advertImage);
			if(isset($pathinfo['extension'])){
				$extension = strtolower($pathinfo['extension']);
				if($extension=="jpg" || $extension=="jpeg" || $extension=="gif" || $extension=="png"){
					$advertImage = 'openx/www/images/'.$advertImage;
					if(!@empty($advertImage) && (@is_file($advertImage))){
						$imagepath = base_url($advertImage);
					}else{
						if($imagetype=='') $imagetype= $noImage;
						else {
						if($deafultPath ==1 || (strcmp('images',@$imagesFolder)==0)) {$imagetype=$imagetype;}
						else{
							$imagetype = $imagetype=='userIcon'?'images/icons/user.png':$imagetype=='user'?'images/user.png':'images/'.$imagetype;
						}
						}
						$imagepath = base_url($imagetype);
					}
				}else{
					$imagepath = base_url($noImage);
				}			
			}else{
				$imagepath = base_url($noImage);
			}
			return $imagepath;
		}
	}
	
	if ( ! function_exists('getSellerInfo')){		 
		/* function used to get seller details
		 * Wriiten By Tosif qureshi
		 */
		function getSellerInfo($sellerId=0){
			$CI =& get_instance();
			$whereField = array('tdsUid'=>$sellerId);
			$res =  $CI->model_common->getDataFromTabel('UserSellerSettings', 'seller_currency',$whereField,'');
			if($res){
				return $res[0]->seller_currency;;
			}else{
				return false;
			}
		}
	} 
	
	
	if ( ! function_exists('getBidderInfo')){		 
		/* function used to get auctions bidder info
		 * Wriiten By Tosif qureshi
		 */
		function getBidderInfo($auctionId=0,$limit=0){
			$CI =& get_instance();
			$whereField = array('auctionId'=>$auctionId,'isWinnerExpire'=>'f');
			$res = $CI->model_common->getDataFromTabel('AuctionBids', '*',  $whereField,'','price','Desc',$limit);
			if($res){
				if($limit==1) {
					return $res[0]->price;
				} else {
					return $res;
				}
			}else{
				return false;
			}
		}
	} 
	if ( ! function_exists('currencySign')){		 
		/* function used to get auctions bidder info
		 * Wriiten By Tosif qureshi
		 */
		function currencySign(){
			$CI =& get_instance();
			$seller_currency=LoginUserDetails('seller_currency');
			$seller_currency=($seller_currency>0)?$seller_currency:0;
			return $currencySign=$CI->config->item('currency'.$seller_currency);
		}
	} 
  
  //-----------------------------------------------------------------------
  
  /*
   * @Description: This function is used to get multi array sum
   * @return total 
   */
  
  	if ( ! function_exists('multiarraysum')){		 
		function multiarraysum($multiArray='',$key=''){
      $totalSum = 0;
      if(!empty($multiArray)){
        foreach($multiArray as $getArray){
          $getArray = (array) $getArray;
          
          $totalSum =  $totalSum + $getArray[$key];
        }
      }
      return $totalSum; 
    }
	}
  
  
  //------------------------------------------------------------------------
  
  /*
   * @description : This function is use to get membership item type title
   * @return: membership item type title
   */ 
  
    if ( ! function_exists('membershipitemtitle')){		 
      function membershipitemtitle($itemType="0",$pkgId="0"){
        $itemTitle = 'None';
        //create instance object
        $CI =& get_instance();
        switch($itemType){
          case $CI->config->item('membership_item_type_1'):
          case $CI->config->item('membership_item_type_3'):
               $itemTitle = "Tool";
          break;
          
          case $CI->config->item('membership_item_type_2'):
               $itemTitle = "Space";
          break;
          
          case $CI->config->item('membership_item_type_4'):
               $itemTitle = ($pkgId=='17')?"3-Year Membership":'Annual Membership';
          break;
          
          case $CI->config->item('membership_item_type_5'):
                $itemTitle = ($pkgId=='17')?" Refund 3-Year Membership":'Refund Annual Membership';
          break;
          
          case $CI->config->item('membership_item_type_6'):
               $itemTitle = ($pkgId=='17')?" Upgrade 3-Year Membership":'Upgrade Annual Membership';
          break;
          
          case $CI->config->item('membership_item_type_7'):
               $itemTitle = ($pkgId=='17')?" Renew 3-Year Membership":'Renew Annual Membership';
          break;
        
          case $CI->config->item('membership_item_type_8'):
               $itemTitle = ($pkgId=='17')?" Downgrade 3-Year Membership":'Downgrade Annual Membership';
          break;
          
          case $CI->config->item('membership_item_type_9'):
               $itemTitle = "Renew Space";
          break;
        }
        return $itemTitle;
      }
    }
    
   //----------------------------------------------------------------------
   
   /*
   * @description : This function is use to get membership item type title
   * @return: membership item type title
   */ 
  
   if ( ! function_exists('membershipordertitle')){		 
      function membershipordertitle($orderType="0"){
        $orderTitle = 'None';
        //create instance object
        $CI =& get_instance();
        switch($orderType){
          case $CI->config->item('membership_order_type_1'):
          case $CI->config->item('membership_order_type_3'):
               $orderTitle = "Invoice";
          break;
          
          case $CI->config->item('membership_order_type_2'):
          case $CI->config->item('membership_order_type_4'):
               $orderTitle = "Refund";
          break;
        }
        return $orderTitle;
      }
    }
  
   //----------------------------------------------------------------------
    
	if ( ! function_exists('getUserSubscriptionInfo')){		 
		function getUserSubscriptionInfo($userId=0,$sectionId=0){
			$data = false;
			if($userId > 0 && $sectionId > 0){
				$data = array();
				$CI =& get_instance();
				$data['subscription_end_date'] = $CI->session->userdata('subscription_end_date');
				$data['subscriptionType'] = $CI->session->userdata('subscriptionType');
				$uc = new lib_userContainer();
				$data['availableContainer'] = $uc->getAvailableUserContainer($userId,$sectionId);
				
			}
			return $data;
		}
	}
	
	if ( ! function_exists('getUserContainerSpace')){		 
		function getUserContainerSpace($dirname = '', $userId=0, $membershipType=1, $containerId=0){
			$data = false;
			if($dirname != ''){
				$data =array();
				$CI =& get_instance();
				if($membershipType == 1){
					$unit = 'mb';
					$containerSize=$CI->config->item('defaultContainerStorageSpace_Byets');
					
				}else{
					$unit = 'gb';
					$containerSize=$CI->config->item('defaultStorageSpace_paidMember_Byets');
					
				}
				
				$dirSize=getFolderSize($dirname);
				$remainingSize=($containerSize-$dirSize);
				if($remainingSize < 0){
					$remainingSize = 0;
				}
				if($remainingSize > 0){
					$remainingSize = bytestoMB($remainingSize,$unit);
				}
				
				$reminSize = $remainingSize;
				
				$data['remainingSize']=$remainingSize.' '.$CI->lang->line($unit);
				$data['UsedSpace']=bytestoMB($dirSize,$unit).' '.$CI->lang->line($unit);
				$data['containerSize']=bytestoMB($containerSize,$unit).' '.$CI->lang->line($unit);
			}
			return $data;
		}
	}
   
   //----------------------------------------------------------------------
    
   /*
   * @description : This function is use search array in multi array
   * @return: array
   */ 
  
  if ( ! function_exists('search_multi_array')){		  
    function search_multi_array($needle, $haystack, $strict = false) {
      foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && search_multi_array($needle, $item, $strict))) {
          return true;
        }
      }
      return false;
    }
  }
  
   //----------------------------------------------------------------------
    
   /*
   * @description : This function is use project element data by project id
   * @param: projectId
   * @return: array
   */ 
  
  if ( ! function_exists('getDataFromJoinTabel')){		  
    function getDataFromJoinTabel($table,$projectId) {
      $CI =& get_instance();
      $CI->db->select('e.title,met.default, mf.fileType');
      $CI->db->from($table.' as e'); 
      $CI->db->join('MediaEelementType as met','met.elementTypeId = e.mediaTypeId','left');
      $CI->db->join('MediaFile as mf','mf.fileId = e.fileId','left');
      $CI->db->where('e.projId',$projectId);
      $CI->db->where('e.isPublished','t');
      $query = $CI->db->get();
      return $query->result_array();
    }
  }
  
   //----------------------------------------------------------------------
    
   /*
   * @description : This function is use to get the day defference of user subscrption
   * @param: dateType , 1: starDate , 2: endDate
   * @return: int
   */ 
	if ( ! function_exists('getSubscriptionDayDiff')){		  
		function getSubscriptionDayDiff($dateType=1) {
			 
			$userId = isLoginUser();
			
			//get logged user subscription details data
			$whereSubcrip = array('tdsUid' => $userId);
			$CI = &get_instance();
			$packageDetails  = $CI->model_common->getDataFromTabel('UserSubscription', '*',  $whereSubcrip, '', $orderBy='subId', $order='ASC', $limit=1, $offset=0, $resultInArray=false);
			$dayDifference = 0;
			if(!empty($packageDetails)) {
				$packageDetails  = $packageDetails[0];
				$whereDate = $packageDetails->startDate; // default from date 
				if($dateType==2) {
					$whereDate = $packageDetails->endDate;
				}
				/* manage subscription day difference */
				$whereDate = date('Y-m-d',strtotime($whereDate));
				$currentDate = new DateTime(date('Y-m-d')); #set current date object
				$whereDate = new DateTime($whereDate); #set subscription date object
				$dayDifference = $currentDate->diff($whereDate)->days;  #set day diff
			}
			return $dayDifference;
		}
	}
	
	//----------------------------------------------------------------------
    
   /*
   * @description : This function is use to get the users billing details
   * @return: json
   */ 
  
	if ( ! function_exists('getUserBillingDetails')){		  
		function getUserBillingDetails() {
			$userId = isLoginUser();
			$CI = &get_instance();
			$billingDetail = $CI->model_membershipcart->getBillingDetails($userId);

			if(isset($billingDetail->billingdetails) && $billingDetail->billingdetails!=''){
			  $billingdetails = json_decode($billingDetail->billingdetails);
			}else {	  
			  $billingdetails =  $CI->model_membershipcart->getUserBillingDetails($userId);
			}
			$billingdetails = json_encode($billingdetails);
			return $billingdetails;
		}
	}
  
  
  if ( ! function_exists('getCompetitionMediaList')){		  
    function getCompetitionMediaList($projectId) {
      $CI =& get_instance();
      $CI->db->select('cm.title, mf.fileType');
      $CI->db->from('CompetitionMedia as cm'); 
      $CI->db->join('MediaFile as mf','mf.fileId = cm.fileId','left');
      $CI->db->where('cm.competitionId',$projectId);
      $query = $CI->db->get();
      return $query->result_array();
    }
  }
  
  //----------------------------------------------------------------------
    
   /*
   * @description : This function is use Collaboration data by project id
   * @param: projectId
   * @return: array
   */ 
  
  if ( ! function_exists('getCollaborationMediaList')){		  
    function getCollaborationMediaList($projectId) {
      $CI =& get_instance();
      $CI->db->select('cm.title, mf.fileType');
      $CI->db->from('CollaborationMedia as cm'); 
      $CI->db->join('MediaFile as mf','mf.fileId = cm.fileId','left');
      $CI->db->where('cm.collaborationId',$projectId);
      $query = $CI->db->get();
      return $query->result_array();
    }
  }
  
  //----------------------------------------------------------------------
    
   /*
   * @description : This function is use Product media data by project id
   * @param: projectId
   * @return: array
   */ 
  
  if ( ! function_exists('getProductMediaList')){		  
    function getProductMediaList($projectId) {
      $CI =& get_instance();
      $CI->db->select('ppm.mediaTitle,mf.fileType');
      $CI->db->from('ProductPromotionMedia as ppm'); 
      $CI->db->join('MediaFile as mf','mf.fileId = ppm.fileId','left');
      $CI->db->where('ppm.prodId',$projectId);
      $query = $CI->db->get();
      return $query->result_array();
    }
  }
  
  //----------------------------------------------------------------------
    
   /*
   * @description : This function is use Upcoming media data by project id
   * @param: projectId
   * @return: array
   */ 
  
  if ( ! function_exists('getUpcomingMediaList')){		  
    function getUpcomingMediaList($projectId) {
      $CI =& get_instance();
      $CI->db->select('upm.mediaTitle,upm.isMain,upm.mediaType,mf.fileType');
      $CI->db->from('UpcomingProjectMedia as upm'); 
      $CI->db->join('MediaFile as mf','mf.fileId = upm.fileId','left');
      $CI->db->where('upm.projId',$projectId);
      $query = $CI->db->get();
      return $query->result_array();
    }
  }
  
  
  //----------------------------------------------------------------------
    
   /*
   * @description : This function is use to get user container  extra space and product default space
   * @param: userId
   * @param: containerId
   * @return: array
   */ 
  
  if ( ! function_exists('getContainerExtraSpace')){		  
    function getContainerExtraSpace($userId="0", $containerId="0") {
      $defaultSize   =  0; // set default value
      $extraSpace    =  0; // set default value
      $totalSpace    =  0; // set default value
      $returnValue   = false;  // set default value
       
      $CI =& get_instance();
      $CI->db->select('umi.userContainerId,umi.size as extraspace, mtp.size as defaultsize, mtp.price');
      $CI->db->from('UserMembershipItem as umi'); 
      $CI->db->join('UserContainer as uc','uc.userContainerId = umi.userContainerId','left');
      $CI->db->join('TDS_MasterTsProduct as mtp','mtp.tsProductId = uc.tsProductId','left');
      $CI->db->where('umi.tdsUid',$userId);
      $CI->db->where('umi.userContainerId',$containerId);
      $CI->db->where('umi.type','2');
      $query = $CI->db->get();
      $getResultData = $query->result_array();
      
      if(!empty($getResultData)){
          foreach($getResultData as $getResult){
              $defaultSize     = $getResult['defaultsize'];
              $extraSpaceTemp  = $getResult['extraspace'];
              $extraSpace      = $extraSpace + $extraSpaceTemp;
              $totalSpace      = $extraSpace + $defaultSize;
          }
          
          // prepare return array
          $returnValue = array('defaultSize'=>$defaultSize,'extraSpace'=>$extraSpace, 'totalSpace'=>$totalSpace);
      }
      
      return $returnValue;
    }
  }
  
  //----------------------------------------------------------------------
    
   /*
   * @description : This function is use to get user package extra space and product default space
   * @param: userId
   * @return: array
   */ 
  
  if ( ! function_exists('getPackageExtraSpace')){		  
    function getPackageExtraSpace($userId="0") {
      $packageSpace   =  0; // set default value
      $extraSpace     =  0; // set default value
      $totalSpace     =  0; // set default value
      $returnValue    = false;  // set default value
       
      $CI =& get_instance();
      $CI->db->select('umi.memItemId, umi.size as extraspace, umi.tdsUid, us.packageSpace');
      $CI->db->from('UserMembershipItem as umi'); 
      $CI->db->join('UserSubscription as us','us.tdsUid = umi.tdsUid','left');
      $CI->db->where('umi.tdsUid',$userId);
      $CI->db->where('umi.type','10');
      $query = $CI->db->get();
      $packageResultData = $query->result_array();
      
      if(!empty($packageResultData)){
          foreach($packageResultData as $packageResult){
              $packageSpace     =  $packageResult['packageSpace'];
              $extraSpaceTemp   =  $packageResult['extraspace'];
              $extraSpace       =  $extraSpace + $extraSpaceTemp;
              $totalSpace       =  $extraSpace + $defaultSize;
          }
          
          // prepare return array
          $returnValue = array('packageSpace'=>$packageSpace,'extraSpace'=>$extraSpace, 'totalSpace'=>$totalSpace);
      }
      
      return $returnValue;
    }
  }
  
  //----------------------------------------------------------------------
    
   /*
   * @description : This function is use to get project image
   * @param: projectdata
   * @param: elementEntityId
   * @return: array
   */ 
	if ( ! function_exists('getPackageProjectImage')) {		  
		function getPackageProjectImage($projectdata,$elementEntityId) {
			$CI =& get_instance();
			$projectImage = ''; // set default image as blank
			if( !empty($projectdata['IndustryId']) || !empty($projectdata['entityId']) ) {
				if ( $projectdata['entityId'] == 9 || $projectdata['entityId'] == 15 ) {
					// get event or launchs project image
					$projectImage = getEventProjImage($projectdata);
				} elseif ( $projectdata['IndustryId'] == 16 ) {
					// get competitions project image 
					$projectImage = getCompetitionProjImage($projectdata);
				} elseif ( $projectdata['IndustryId'] == 15 ) {
					//get collaboration project image
					$projectImage = getCollaborationProjImage($projectdata);
				} elseif ( $projectdata['entityId'] == 49 ) {
					//get products project image
					$projectImage = getProductProjImage($projectdata);
				} elseif ( $projectdata['entityId'] == 71 ) {
					//get upcoming project image
					$projectImage = getUpcomingProjImage($projectdata);
				} elseif ( $projectdata['entityId'] == 86 ) {
					//get workprofile image
					$projectImage = getWorkprofileProjImage($projectdata);
				} else {
					//get media project image
					$projectImage = getMediaProjImage($projectdata,$elementEntityId);
				}
			}
			return $projectImage;
		}
	}
	
	//----------------------------------------------------------------------
    
   /*
   * @description : This function is use to get media project image
   * @param: projectdata
   * @return: string
   */ 
	if ( ! function_exists('getMediaProjImage')) {	
		function getMediaProjImage($projectdata,$elementEntityId) {
			$CI =& get_instance();
			if(isset($projectdata['isExternalImageURL']) && $projectdata['isExternalImageURL'] == 't') {
				$projectImage = trim($projectdata['projBaseImgPath']);
			} else {
				$imagetype = $CI->config->item($projectdata['projectType'].'FileConfig');
				$imageFileType = $imagetype['defaultImage_s'];
				//----------make element default project image code start---------//
				if(!empty($projectdata['projBaseImgPath'])) {
					$projThumbImage = addThumbFolder($projectdata['projBaseImgPath'],'_s',$imageFileType);						
					$projectImage = getImage($projThumbImage,$imageFileType,1);
				} else {
					
					$getProjectImage = getProjectElementImage($projectdata['elementId'],$elementEntityId);	
					
					if(is_array($getProjectImage)) {
						if($getProjectImage['isExternal']=="t") {
							$getImageUrl =  checkExternalImage($getProjectImage['filePath'],'_s');
							if(getimagesize($getImageUrl)) {
								$projectImage = $getImageUrl;
							}
						}
					} else {
						if($getProjectImage){
							$projThumbImage = $getProjectImage;
						}else{
							$projThumbImage = addThumbFolder($projectdata['projBaseImgPath'],'_s',$imagetype);				
						}
						if(empty($projectdata['projBaseImgPath'])) {
							$projectImage =  base_url($imagetype['defaultImage_s']);
						} else {
							$projectImage = getImage($projThumbImage,$imagetype,1);
						}
					}
				}
			}
			return $projectImage;	
		}
	}
	
	//----------------------------------------------------------------------
    
   /*
   * @description : This function is use to get event or launch project image
   * @param: projectdata
   * @return: string
   */ 
	if ( ! function_exists('getEventProjImage')) {	
		function getEventProjImage($projectdata) {
			$CI =& get_instance();
			// set image path if exist
			$eventImage = $projectdata['filePath'].$projectdata['fileName'];
			if(!empty($projectdata['filePath']) && !empty($projectdata['fileName']) && file_exists($eventImage)) {
				$eventImage = addThumbFolder($eventImage,'_s');
				$eventMediaSrc = getImage($eventImage,$CI->config->item('defaultEventImg_s'));
			} else {
				if(!empty($projectdata['elementId'])) {
					if($projectdata['entityId'] == 9) {
						$projectFieldName = '.eventId';
					} else {
						$projectFieldName = '.launchEventId';
					}
					
					$getProjectImage = getEventsPrimaryImage($projectdata['elementId'],$projectFieldName);
					if($getProjectImage){
						$eventImage = $getProjectImage;
					}else{
						$eventImage = addThumbFolder($eventImage,'_s');				
					}
				} else {
					$eventImage = addThumbFolder($eventImage,'_s');	
				}
				$eventMediaSrc = getImage(@$eventImage,$CI->config->item('defaultEventImg_s'));
			}
			return $eventMediaSrc;		
		}
	}
	
	//----------------------------------------------------------------------
    
   /*
   * @description : This function is use to get competition's project image
   * @param: projectdata
   * @return: string
   */ 
	if ( ! function_exists('getCompetitionProjImage')) {	
		function getCompetitionProjImage($projectdata) {
			$CI =& get_instance();
			if(isset($projectdata['coverImage']) && !empty($projectdata['coverImage']) ){
				$mainCoverImage = $projectdata['coverImage'];
			}
			else{
				$mainCoverImage = '';
			}
					
			$coverImage = '';
			$defCoverImage = $CI->config->item('defaultcompetitonImg73X110');
			$coverImage = addThumbFolder($mainCoverImage,$suffix = '_s',$thumbFolder = 'thumb',$defCoverImage);	
			$projectImage = getImage($coverImage,$defCoverImage);
			return $projectImage;
		}
	}
	
  /*
   * @description : This function is use to get collaborations's project image
   * @param: projectdata
   * @return: string
   */ 
	if ( ! function_exists('getCollaborationProjImage')) {	
		function getCollaborationProjImage($projectdata) {
			$CI =& get_instance();
			if(isset($projectdata['coverImage']) && !empty($projectdata['coverImage']) ){
			$mainCoverImage = $projectdata['coverImage'];
			}
			else{
				$mainCoverImage = '';
			}
			$defCoverImage = $CI->config->item('defaultcollaborationImage');
			$coverImage = addThumbFolder($mainCoverImage,$suffix='_s',$thumbFolder ='thumb',$defCoverImage);	
			$projectImage = getImage($coverImage,$defCoverImage);
			return $projectImage;
		}
	}
	
  /*
   * @description : This function is use to get products project image
   * @param: projectdata
   * @return: string
   */ 
	if ( ! function_exists('getProductProjImage')) {	
		function getProductProjImage($projectdata) {
			$CI =& get_instance();
			// get products all promotional images
			$sliderImages = getProductImages('ProductPromotionMedia','prodId',$projectdata['elementId'],1, 'isMain');
			// set default images of product category
			if($projectdata['pkgSections'] == '{12:1}') {
				$defaultImage = $CI->config->item('defaultProductForSale_s');
			} else if($projectdata['pkgSections'] == '{12:2}') {
				$defaultImage = $CI->config->item('defaultProductWanted_s');
			} else {
				$defaultImage = $CI->config->item('defaultProductFree');
			}
			$projectImage = managePromotionalImages($sliderImages,$defaultImage);
			return $projectImage;
		}
	}
	
  /*
   * @description : This function is use to get upcoming project image
   * @param: projectdata
   * @return: string
   */ 
	if ( ! function_exists('getUpcomingProjImage')) {	
		function getUpcomingProjImage($projectdata) {
			$CI =& get_instance();
			// get products all promotional images
			$sliderImages = getProductImages('TDS_UpcomingProjectMedia','projId',$projectdata['elementId'], 1, 'isMain');// Defination is on Common controller
			$defaultImage = $CI->config->item('defaultUpcomingImg_s');
			$projectImage = managePromotionalImages($sliderImages,$defaultImage);
			return $projectImage;
		}
	}

	/*
   * @description : This function is use to manage promotional images
   * @param: sliderImages , defaultImage
   * @return: string
   */ 
	if ( ! function_exists('managePromotionalImages')) {	
		function managePromotionalImages($sliderImages,$defaultImage) {
			// manage product image
			$showDefaultImage = 0;
			if(!empty($sliderImages)) {
				foreach($sliderImages as $k =>$slider) {		
					if(file_exists(ROOTPATH.$slider->filePath.$slider->fileName)) {
						$sliderThumbImage = addThumbFolder($slider->filePath.$slider->fileName,'_m');
						$projectImage = getImage($sliderThumbImage,$defaultImage,1);
					} else {
						if($showDefaultImage == 0){
							$showDefaultImage = 1;
							$projectImage = getImage($defaultImage);				
						}
					}					
				}
			} else { 
				$projectImage = getImage($defaultImage);
			}
			return $projectImage;
		}
	}
	
  /*
   * @description : This function is use to get workprofile image
   * @param: projectdata
   * @return: string
   */ 
	if ( ! function_exists('getWorkprofileProjImage')) {	
		function getWorkprofileProjImage($projectdata) {
			$CI =& get_instance();
			if(!empty($projectdata['filePath']) && !empty($projectdata['fileName'])) {
				$profileImgPath = $projectdata['filePath'];
				$profileImgName = $projectdata['fileName'];
			} else {
				$profileImgPath = '';
				$profileImgName = '';
			}
			// get workprofile thumb image
			$workProfileThumbImage = addThumbFolder($profileImgPath.$profileImgName,'_s');
			$projectImage = getImage($workProfileThumbImage , $CI->config->item('defaultWorkWanted_s'));
			return $projectImage;
		}
	}
    
    
    
     /*
     * @Access: public
     * @Description: This method is use to get section Id
     * @param: $sectionName (string)
     * @param: $entityId (integer)
     * @param: $elementId (integer)
     * @return: $sectionId (integer)
     * @auther: lokendra 
     */ 
    if ( ! function_exists('creaveSectionId')) {	 
        function creaveSectionId($sectionName,$entityId,$elementId){
            
            $CI =& get_instance();
            
            $sectionId = 0; // defined default id 
            
            switch ($sectionName) {
                case 'filmNvideo':
                    $sectionId ='1';
                    break;
                case 'musicNaudio':
                    $sectionId='2';
                    break;
                case 'writingNpublishing':
                    $sectionId='3';
                    break;
                case 'photographyNart':
                    $sectionId='4';
                    break;
                case 'creatives':
                    $sectionId='6';
                    break;
                case 'associatedprofessionals':
                    $sectionId='7';
                    break;
                case 'enterprises':
                    $sectionId='8';
                    break;
                case 'fans':
                    $sectionId='34';
                    break;
                case 'performancesevents':
                    $sectionId='9';
                    break;
                case 'educationMaterial':
                    $sectionId='10';
                    break;
                case 'work':
                    
                     //--------get work sub section id--------//
                    $entityTableName    =    getMasterTableName($entityId);
                    $tableName          =    $entityTableName[0];
                    $where              =    array('workId' =>  $elementId);
                    
                    $getWorkData        =   $CI->model_common->getDataFromTabel($tableName, 'workType',  $where, '', '', '', 1);
                    
                    $subSectionId    = 0; // set default value
                    if(!empty($getWorkData)){
                        $getWorkData     =   $getWorkData[0];
                        $getWorkData     =   $getWorkData->workType; 
                         $subSectionId = ($getWorkData == 'offered')?'1':'2';
                    }
                    
                    $sectionId ='11:'.$subSectionId;
                    break;
                case 'product':
                    
                    //--------get product sub section id--------//
                    $entityTableName    =    getMasterTableName($entityId);
                    $tableName          =    $entityTableName[0];
                    $where              =    array('productId' =>  $elementId);
                    
                    $getProductData  =   $CI->model_common->getDataFromTabel($tableName, 'catId',  $where, '', '', '', 1);
                  
                    $subSectionId    = 0;// set default value
                    if(!empty($getProductData)){
                        $getProductData = $getProductData[0];
                        $subSectionId   = $getProductData->catId; 
                    }
                    
                    $sectionId ='12:'.$subSectionId;
                    break;
                case 'blog':
                    $sectionId='13';
                    break;
                case 'news':
                    $sectionId='3:1';
                    break;
                case 'reviews':
                    $sectionId='3:2';
                    break;
                case 'upcoming':
                    $sectionId='17';
                    break;
                case 'competition':
                    $sectionId='16';
                    break;
                
                default:
                    $sectionId='0';
                    break;
            }
            
            return ((int)$sectionId>0)?$sectionId:0;
        }
    }
    
  /*
   * @description : This function is use to get base media url
   * @return: string
   */ 
    if ( ! function_exists('formBaseUrl')) {
        function formBaseUrl() {
            $CI =& get_instance();
            return base_url(lang().DIRECTORY_SEPARATOR.$CI->router->fetch_class().DIRECTORY_SEPARATOR.$CI->router->fetch_method()); 
        }
    }

    
    
    /**
    * @access: public
    * @descrition: This method is use to get rating path 
    * @param: $ratingAvg
    * @param: $ratingImageSize (big/small)
    * @return: string 
    * @auther: lokendra meena
    */
    
    if (!function_exists('ratingImagePath')):
        function ratingImagePath($ratingAvg="0", $ratingImageSize='big'){
            $CI =& get_instance();
           
            $ratingImagesPath        =       $CI->config->item('rating_images_path');
            $ratingImagesPathGet     =       $ratingImagesPath.'rating_0'.$ratingAvg.'.png';
            $ratingImagesPathFull    =       $ratingImagesPath.'rating_00.png';
            if(file_exists($ratingImagesPathGet)){
                $ratingImagesPathFull   =    base_url($ratingImagesPathGet);
            }else{
                $ratingImagesPathFull   =    base_url($ratingImagesPathFull);
            }
            return $ratingImagesPathFull;
        }
    endif;
    
    

    
  /*
   * @description : This function is used to get industry name from table
   * @return: string
   */ 
    if ( ! function_exists('getIndustryName')) {
        function getIndustryName($tableName = '') {
            
            switch ($tableName) {
                case 'TDS_FvElement':
                    $sectionName = 'filmNvideo';
                    break;
                case 'TDS_MaElement':
                    $sectionName = 'musicNaudio';
                    break;
                case 'TDS_WpElement':
                    $sectionName = 'writingNpublishing';
                    break;
                case 'TDS_PaElement':
                    $sectionName = 'photographyNart';
                    break;
                case 'TDS_EmElement':
                    $sectionName = 'educationMaterial';
                    break;
             
                default:
                    $sectionName = $tableName;
                    break;
            }
            
            return $sectionName;
        }
    }
    
   /*
    * @description : This function is use to get genre records as per media category
    * @return: string
    */ 
    if ( ! function_exists('getMediaGenerList')){
        function getMediaGenerList($catId=0, $defaultOption='selectProjectType')
        {
           
            $CI =&get_instance();
            $genere=array();
            if($defaultOption) $genere['']=$CI->lang->line($defaultOption);
            if($catId > 0){
                $res =  $CI->model_common->getMediaGenerList($catId);
                if($res){
                    $GenreName='';
                    foreach ($res as $gener) {
                        if($gener->Genre != $GenreName){
                            $genere[$gener->GenreId] = $gener->Genre;
                            $GenreName=$gener->Genre;
                        }
                    }
                }
            }
            return $genere;
        }
    }
    
    //----------------------------------------------------------------------------
     
    /*
    * @description: This method is use to show base url with current activated language
    * @auther: lokendra meena
    * @return: string
    */
    
    if(! function_exists('base_url_lang')){
        function base_url_lang($url=''){
            $baseUrl      =  base_url().lang().'/'.$url;
            return   $baseUrl;
        }
    }
    
    //---------------------------------------------------------------------------- 
     
    /*
    * @description: This methos is use to get frentendUserId for viewing showcase of 
    * any user  
    * @auther: lokendra
    * @return: string
    */ 
    
     if(! function_exists('frentendUserId')){
        function frentendUserId(){
        
        $CI                   =    &get_instance(); // create instance 
        $frentendUserId       =    '0'; // defined userId
        
        $moduleArray          =    array('mediafrontend','blogshowcase','buyer_comment');//defined module names
        $methodArray          =    array('buyer_comment/index','showcase/index','showcase/developementpath','showcase/aboutme','showcase/videos','showcase/mycraves','showcase/cravingme','showcase/mypaylist','showproject/othercollections','frontPostDetail');//defined module names
        $className            =    $CI->router->fetch_class();   // get module name
        $methodName       =   $CI->router->fetch_method();  // get module name

            //check method is exist 
            if(in_array($className,$moduleArray) || in_array($className.'/'.$methodName,$methodArray)){
                $userId    =    $CI->uri->segment('4');
                if(is_numeric($userId) && !empty($userId)){
                    $frentendUserId    =   $userId;
                }else{   
                    // segment 4 is blank then use segment 5
                    $userId     =   $CI->uri->segment('5');
                    if(is_numeric($userId) && !empty($userId)){
                        $frentendUserId     =   $userId;
                    }elseif(isLoginUser()){
                        $frentendUserId    =    isLoginUser();
                    }
                }
            }else{
                if(isLoginUser()){
                    $frentendUserId    =    isLoginUser();
                }
            }
            return $frentendUserId;
        }
    }
    
    
    //---------------------------------------------------------------------------- 

    /*
    * @description: This methos is use to get short link
    * any user  
    * @param: string
    * @auther: lokendra
    * @return: string
    */ 
    
    if(! function_exists('getShortLink')){
        
        function    getShortLink($shortLinkUrl=''){
            
            $CI                  =    &get_instance(); // create instance 
            $isLoginUser         =    isLoginUser(); // create instance 
           
            $userId     =   ($isLoginUser)?$sLoginUser:'0'; // userId if logged In
            
            $createShortLink    =   $CI->model_common->getShortLink($shortLinkUrl);
            
            return $createShortLink;
        }
    }
    
      //---------------------------------------------------------------------------- 

    /*
    * @description: This methode is use to get cover image
    * any user  
    * @param: string
    * @return: string
    */ 
    
    if(! function_exists('getProjectCoverImage')) {
        
        function getProjectCoverImage($projId=0,$imageSize='_m',$isActualSize=0) {
            
            $CI             =  &get_instance(); // create instance 
            $coverImage     =  ''; // set blank value as default
            
            $CI->config->load('media/media');
           
            // get project data
            $getProjData  =   $CI->model_common->getDataFromTabel('Project', 'projSellstatus,projId,tdsUid,projectType,elementImageId,isProfileCoverImage',  array('projId' =>  $projId), '', '', '', 1);
            
            if(!empty($getProjData) && count($getProjData)>0) {
                
                $getProjData = $getProjData[0];
                
                //get element image default size
                switch($getProjData->projectType){
                    
                    case "news";
                    case "reviews";
                        $imagetype      =  $CI->config->item('default'.ucwords($getProjData->projectType).'Img'.$imageSize);
                    break;
                    
                    default:
                     $imagetype      =  $CI->config->item($getProjData->projectType.'Image'.$imageSize);
                }
                $coverImage     =  getImage('',$imagetype); // set blank value as default
                
                if($getProjData->isProfileCoverImage == 'f' && $getProjData->elementImageId > 0 ) {
                    
                    // get element's table name
                    $elementTblPrefix    =  $CI->config->item( $getProjData->projectType.'Prifix');
                    $elementTable        =  $elementTblPrefix.'Element';
                    
                    // set element's image as cover image
                    $getElementData  =  $CI->model_common->getDataFromTabel($elementTable, 'fileId,displayImageType,imagePath',  array('projId' => $getProjData->projId,'elementId' => $getProjData->elementImageId), '', '', '', 1);
                    if(!empty($getElementData) && count($getElementData)>0) {
                        $getElementData = $getElementData[0];
                        if($getElementData->displayImageType == 1) {
                            // set uploaded element image
                            $thumbImage = addThumbFolder($getElementData->imagePath,$imageSize,'thumb',$imagetype);	
                            if($isActualSize == 1) {
                                $thumbImage = $getElementData->imagePath;
                            }
                            
                            if(file_exists(ROOTPATH.$thumbImage)) {
								 $coverImage = getImage($thumbImage,$imagetype,1);
							}
							
                        } else if($getElementData->displayImageType == 2) {
                            // set embedd Image
                            $coverImage = checkExternalImage($getElementData->imagePath,$imagetype);
                        } else if($getElementData->displayImageType == 3) {
                            // set project's default Image 
                            $coverImage = getImage('',$imagetype);
                        }else if($getElementData->displayImageType == 0) {
                            // set project's default Image 
                            $getElementMediaData  =  $CI->model_common->getDataFromTabel('MediaFile', 'fileName,filePath',  array('fileId' => $getElementData->fileId), '', '', '', 1);
                            $getElementMediaData  =  $getElementMediaData[0];
                            $photoImage  = $getElementMediaData->filePath.$getElementMediaData->fileName; 
                            
                            //check project sell status then  show image by type
                            if($getProjData->projSellstatus=="t"){
                                $thumbFolder='watermark'; 
                            }else{
                                $thumbFolder='thumb';
                            }
                            
                            $thumbImage = addThumbFolder($photoImage,$imageSize,$thumbFolder);	
                            $coverImage=getImage($thumbImage,$imagetype,'');
                        }
                    }
                } else if($getProjData->isProfileCoverImage == 't' && $getProjData->elementImageId == 0 ) {
                    
                    // set user's profile image as cover image

                    //$coverImage = getProjectImage(getMasterTableRecord('UserShowcase'),LoginUserDetails('showcaseId'));
                
                    $getUserId =  $getProjData->tdsUid;

                    //get user showcase details
                    $userInfo   =  showCaseUserDetails($getUserId,'userBackend');

                    //get user first name
                    $userFullName = $userInfo['userFullName'];

                    //if(isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'enterprises', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'associatedprofessionals', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'creatives', $userNavigations, $key='section', $is_object=0 ))){ 
                    if(!empty($userInfo['creative']) || !empty($userInfo['associatedProfessional']) || !empty($userInfo['enterprise'])){ 
                        $userDefaultImage=($userInfo['enterprise']=='t')?$CI->config->item('defaultEnterpriseImg'.$imageSize):($userInfo['associatedProfessional']=='t'?$CI->config->item('defaultAssProfImg'.$imageSize):$CI->config->item('defaultCreativeImg'.$imageSize));
                    }else{
                        $userDefaultImage=$CI->config->item('defaultMemberImg'.$imageSize);
                    }

                    $userTemplateThumbImage = addThumbFolder($userInfo['userImage'],$imageSize);	
                    $coverImage = getImage($userTemplateThumbImage,$userDefaultImage);
                } else {
                    
                    
                    // set project's default Image 
                   $coverImage = getImage('',$imagetype);

                }
            }
            
            return $coverImage;
        }
    }
    
    //-----------------------------------------------------------------------
    
    /*
    * @description: This methode is use to get subscription type
    * @param: string
    * @return: string
    */ 
    

    if(! function_exists('getSubscriptionType')) {
        function getSubscriptionType() {
            $return = false;
            $CI = &get_instance();
            $userId = isLoginUser();
            //get logged user subscription details data
            $whereSubcrip = array('tdsUid' => $userId);
            $packageDetails  = $CI->model_common->getDataFromTabel('UserSubscription', '*',  $whereSubcrip, '', $orderBy='subId', $order='ASC', $limit=1, $offset=0, $resultInArray=false);
            if(isset($packageDetails[0]->subscriptionType)){
               $return = $packageDetails[0]->subscriptionType;
            }
            return $return; 
        }
    }
    
    //---------------------------------------------------------------------------- 
    
    /*
    * @description: This method is use to add and updated uploaded media files
    * count
    * @param: entityId
    * @param: elementId
    * @return:true
    * @auther: lokendra meena
    */ 
    
     if(! function_exists('mediaFileCount')) {
        
        function mediaFileCount($entityId="0",$elementId="0",$indusrtyName="",$isShippable=0,$mediaFileType=0,$shippableStatus='',$projElementId=0) {
            
            $CI         =  &get_instance(); // create instance 
            $fieldName  = 'imageFileCount';
            $fileAction = 'add';
            switch ($indusrtyName) {
                case 'filmNvideo': // set field name for filmNvideo
                    $fieldName = 'videoFileCount';
                    $shipFieldName = 'dvdCount';
                    if($isShippable == 1) {
                        $fieldName = $shipFieldName;
                    }
                  
                break;
                
                case 'musicNaudio': // set field name for musicNaudio
                    $fieldName = 'audioFileCount';
                    $shipFieldName = 'cdCount';
                    if($isShippable == 1) {
                        $fieldName = $shipFieldName;
                    }
                break;
                
                case 'writingNpublishing': // set field name for writingNpublishing
                    $fieldName = 'docFileCount';
                    $shipFieldName = 'docCount';
                    if($isShippable == 1) {
                        $fieldName = $shipFieldName;
                    }
                   
                break;
                
                case 'photographyNart': // set field name for photographyNart
                    $fieldName = 'imageFileCount';
                    $shipFieldName = 'printCount';
                    if($isShippable == 1) {
                        $fieldName = $shipFieldName;
                    }
                break;
                
                case 'educationMaterial': // set field name for educationMaterial
                   switch($mediaFileType) {
                        case 2:
                            $fieldName = 'videoFileCount';
                            $shipFieldName = 'dvdCount';
                            if($isShippable == 1) {
                                $fieldName = $shipFieldName;
                            }
                            break;
                        case 3:
                            $fieldName = 'audioFileCount';
                            $shipFieldName = 'cdCount';
                            if($isShippable == 1) {
                                $fieldName = $shipFieldName;
                            }
                            break;
                        case 4:
                            $fieldName = 'docFileCount';
                            $shipFieldName = 'docCount';
                            if($isShippable == 1) {
                                $fieldName = $shipFieldName;
                            }
                            break;
                        default :
                            $fieldName = 'videoFileCount';
                            $shipFieldName = 'dvdCount';
                            break;
                    }
                break;
                
                default:
                    $fieldName      =  'imageFileCount';
            }
           
            //get media file data by field type
            $whereFileCondi =   array('entityId'=>$entityId,'elementId'=>$elementId);
            // set fields name which we want to get 
            $getFiledNames    =   'actId, '.$fieldName;
           
            if($shippableStatus == 't' || $shippableStatus == 'f' ) {
                $getFiledNames    =   'actId, '.$fieldName.', '.$shipFieldName;
            } 
           
            $getProjData    =   $CI->model_common->getDataFromTabel('LogSummary', $getFiledNames,  $whereFileCondi, '', '', '', 1);
            
            // if record is available 
            if(!empty($getProjData)) {
                $getProjData     =   $getProjData[0];
                $getFileCount    =   $getProjData->$fieldName;
                $actId           =   $getProjData->actId;
              
                // if we add new file 
                if($fileAction == 'add') {
                    $fileCount     =   $getFileCount + 1;
                    // update file count
                    $updateData      =   array($fieldName=>$fileCount);
					$updateElementData =   array($fieldName=>'1'); // set field value for element
                    if($shippableStatus == 't' || $shippableStatus == 'f' ) {
                         // get shippable file count
                        $getShipFileCount =   $getProjData->$shipFieldName;
                        if($shippableStatus == 't') {
							// set counts for project
                            $shipFileCount    =   $getShipFileCount - 1;
                            $fileCount        =   $getFileCount + 1;
                            // set counts for element
                            $shipElementCount =   0;
                            $elementFileCount =   1;
                        } else {
                            $shipFileCount    =   $getShipFileCount + 1;
                            $fileCount        =   $getFileCount - 1;
							// set counts for element
                            $shipElementCount =  1;
                            $elementFileCount =  0;
                        }
                        // set update fields
                        $updateData      =   array($fieldName=>$fileCount,$shipFieldName=>$shipFileCount);
                        $updateElementData = array($fieldName=>$elementFileCount,$shipFieldName=>$shipElementCount);; // set field value for element
                    }
                }elseif($fileAction=='remove'){
                    if($getFileCount >= 1) {
                        $fileCount       =   $getFileCount - 1;
                    }
                }
        
                $CI->model_common->editDataFromTabel('LogSummary', $updateData, 'actId', $actId);
                
                if(!empty($projElementId)) {
					$logProjElementId = $projElementId;
				} else {
					// get last inserted log id 
					$logProjElementId = $CI->db->insert_id();
				}
				// update element file count
				$CI->model_common->editDataFromTabel('LogSummary', $updateElementData, 'actId', $logProjElementId);
               
            } else {
                //if not exist then insert one time only
                $insertData =  array('entityId'=>$entityId,'elementId'=>$elementId);
                $CI->model_common->addDataIntoTabel('LogSummary', $insertData);
            }
        }
    }
    
    //----------------------------------------------------------------------
    
    /*
    * @description: This method is use to show left time remaings
    * @param: datetime
    * @auther: lokendra meena
    * @return: void
    */
    
    if(! function_exists('timeleft')) {
        
        function timeleft($dateTime) {
            $date = strtotime($dateTime);
            $remaining = $date - time();
            $days_remaining = floor($remaining / 86400);
            $hours_remaining = floor(($remaining % 86400) / 3600);
            $minute = floor(($remaining % 3600) / 60);
            return  "$days_remaining day : $hours_remaining hours : $minute min";
        }
    }
    
   //----------------------------------------------------------------------
    
    /*
    * @description: This method is use to get element image
    * @param: datetime
    * @auther: lokendra meena
    * @return: void
    */
    
    if(! function_exists('getMediaElementImage')) {
        
        function getMediaElementImage($table='', $id=0, $projectType='', $imageSize='_m') {
            $elementImag = false;
            if((int)$id > 0 && !empty($table)){
                $CI  =  &get_instance(); // create instance 
                $data  =   $CI->model_common->getDataFromTabel($table, 'imagePath,displayImageType',  array('elementId'=>$id));
                if(isset($data[0])){
                    $elementImage = getElementImage($data[0]->displayImageType,$data[0]->imagePath,$projectType,$imageSize);
                }
            }
            return $elementImage;
        }
    } 
    
    if(! function_exists('getElementImage')) {
        
        function getElementImage($displayImageType,$imagePath,$indusrtyName,$imageSize='_m') {
           
            $CI  =  &get_instance(); // create instance 
            //get element image default size
            switch($indusrtyName){
                
                case "news";
                case "reviews";
                    $imagetype      =  $CI->config->item('default'.ucwords($indusrtyName).'Img'.$imageSize);
                break;
                
                default:
                $imagetype      =  $CI->config->item($indusrtyName.'Image'.$imageSize);
            }
           
            
            if($displayImageType == 1) {
                // set uploaded element image
                $thumbImage = addThumbFolder($imagePath,$imageSize,'thumb',$imagetype);	
                $elementImage = getImage($thumbImage,$imagetype,1);
                
            } else if($displayImageType == 2) {
                // set embedd Image
                $elementImage = checkExternalImage($imagePath,$imagetype);
            } else {
                // set project's default Image 
                $elementImage = getImage('',$imagetype);
            }
            return $elementImage;
        }
    }
    
    //----------------------------------------------------------------------
    
    
    /*
    * @description: This method is use to check media element is physical or not
    * @param: array/object
    * @auther: lokendra meena
    * @return: void 
    */
    
    if(! function_exists('mediaIsPhysical')) {
        
        function  mediaPhysicalType($projectData,$addtionalString=''){
            $mediaElementType = '';
            
            if(!empty($projectData)){
                
                $isprojPrice             = (!empty($projectData['isprojPrice']))?$projectData['isprojPrice']:'f';
                $hasDownloadableFileOnly = (!empty($projectData['hasDownloadableFileOnly']))?$projectData['hasDownloadableFileOnly']:'f';
                $projectType             = (!empty($projectData['projectType']))?$projectData['projectType']:'f';
                switch($projectType){
                    case "filmNvideo":
                            
                            if($isprojPrice=='t' && $hasDownloadableFileOnly=="0"){
                                $mediaElementType = 'DVD';
                            }else{
                                $mediaElementType = 'Video';
                            }
                    break;
                    
                    default:
                    
                    if($isprojPrice=='t' && $hasDownloadableFileOnly=="0"){
                        $mediaElementType = 'DVD';
                    }else{
                        $mediaElementType = 'Video';
                    }
                }
            }
            
            return $mediaElementType.' '.$addtionalString;
        }
    }
    
    //---------------------------------------------------------------------
    
    /*
    *  @description: This method is use to get cout down days
    *  @param: startDate
    *  @param: days
    *  @return: days
    *  @auther: lokendra meena
    */ 

    if(! function_exists('daycountdown')) {
        
        function daycountdown($startDate="0",$days="7"){
            
            $startDate              =   ($startDate)?$startDate:time();
            $startTimestamp         =   strtotime($startDate);
            $startTimestamp         =   strtotime("+".$days." day", $startTimestamp);
            $remaining              =   $startTimestamp - time();
            $daysRemaining          =   floor($remaining / 86400);
            return  $daysRemaining  ;
        }
      
    }
    
    if(! function_exists('MediaFileTypeString')) {
        
        function MediaFileTypeString($mediaFileType=0){
            $CI  =  &get_instance();
            $returnData=array();
            //1:Image, 2:video, 3:Audio, 4:Text,Document
            switch($mediaFileType){
                case 1:
                    $returnData=array('fileType_dwnld'=>$CI->lang->line('imageFile'), 'fileType_shipd'=>$CI->lang->line('print'));
                break;

                case 2:
                    $returnData=array('fileType_dwnld'=>$CI->lang->line('videoFile'), 'fileType_shipd'=>$CI->lang->line('DVD'));					
                break;

                case 3:
                    $returnData=array('fileType_dwnld'=>$CI->lang->line('audioFile'), 'fileType_shipd'=>$CI->lang->line('CD'));					
                break;
                
                case 4:
                    $returnData=array('fileType_dwnld'=>$CI->lang->line('textFile'), 'fileType_shipd'=>$CI->lang->line('textFile'));		
                break;				

                default:
                    $returnData=false;
                break;	
            }	
            return  $returnData  ;
        }
      
    }
    
    
    
     /*
     * @Access: public
     * @Description: This method is use to get section name
     * @param: $sectionId (string)
     * @auther: lokendra 
     */ 
    if ( ! function_exists('getSectioName')) {	 
        function getSectioName($sectionId){
            
            $CI =& get_instance();
            
            $sectionName = ''; // defined default id 
            
            switch ($sectionId) {
                case '1':
                    $sectionName ='Film & Video';
                    break;
                case '2':
                    $sectionName='Music & Audio';
                    break;
                case '3':
                    $sectionName='Writing & Publishing';
                    break;
                case '4':
                    $sectionName='Photography & Art';
                    break;
                case '9':
                    $sectionName='Performances Events';
                    break;
                case '10':
                    $sectionName='Education Material';
                    break;
                case '11:1':
                case '11:2':
                    $sectionName ='Work';
                    break;
                case '12:1':
                case '12:2':
                    $sectionName ='product';
                    break;
                case '13':
                    $sectionName='blog';
                    break;
                case '3:1':
                    $sectionName='news';
                    break;
                case '3:2':
                    $sectionName='reviews';
                    break;
                case '17':
                    $sectionName='upcoming';
                    break;
                case '16':
                    $sectionName='competition ';
                    break;
                
                default:
                    $sectionName='';
                    break;
            }
            
            return $sectionName;
        }
    }
    
    //-----------------------------------------------------------------------
    
    /*
    *  @description: media playlist file length show 
    *  @auther: lokendra
    *  @return: string
    */ 

    if(!function_exists('playlistFileLength')){
        function playlistFileLength($fileLenght="0"){
            $durationTime = "00:00:00";
            if(!empty($fileLenght)){
                $timeArray = explode(":",$fileLenght);
                if(!empty($timeArray)){
                    $timeHours      =   (!empty($timeArray[0]))?$timeArray[0]:0;
                    $timeMinute     =   (!empty($timeArray[1]))?$timeArray[1]:0;
                    $timeSecond     =   (!empty($timeArray[2]))?$timeArray[2]:0;
                    
                    //check lenght of string
                    $timeHours  = (strlen($timeHours)==1)?'0'.$timeHours:$timeHours;
                    $timeMinute = (strlen($timeMinute)==1)?'0'.$timeMinute:$timeMinute;
                    $timeSecond = (strlen($timeSecond)==1)?'0'.$timeSecond:$timeSecond;
                    
                    $lengthTime = "";
                    
                    //get hours of string
                    if($timeHours!="00"){
                        $lengthTime = $timeHours.'h';
                    }
                    
                    //get minute of string
                    if($timeMinute!="00"){
                        $lengthTime .= $timeMinute.'m';
                    }
                    
                    //get second of string
                    if($timeSecond!="00"){
                        $lengthTime .= $timeSecond.'s';
                    }
                    
                    $durationTime  = ($lengthTime!="")?$lengthTime:$defaultLength;
                }
            }
            return $durationTime;
        }
    }
    
    //-----------------------------------------------------------------------
    
    /*
    *  @description: media element file length show 
    *  @auther: lokendra
    *  @return: string
    */ 

    if(!function_exists('elementFileLength')){
        function elementFileLength($fileLenght="0"){
            $durationTime = "00:00:00";
            if(!empty($fileLenght)){
                $timeArray = explode(":",$fileLenght);
                if(!empty($timeArray)){
                    $timeHours      =   (!empty($timeArray[0]))?$timeArray[0]:0;
                    $timeMinute     =   (!empty($timeArray[1]))?$timeArray[1]:0;
                    $timeSecond     =   (!empty($timeArray[2]))?$timeArray[2]:0;
                    
                    //check lenght of string
                    $timeHours  = (strlen($timeHours)==1)?'0'.$timeHours:$timeHours;
                    $timeMinute = (strlen($timeMinute)==1)?'0'.$timeMinute:$timeMinute;
                    $timeSecond = (strlen($timeSecond)==1)?'0'.$timeSecond:$timeSecond;
                    
                    $lengthTime = "";
                    $stringTime = '';
                    
                    //get hours of string
                    if($timeHours!="00"){
                        $lengthTime = $timeHours.':';
                        $stringTime  = 'Hour'; // concanate string time
                    }
                    
                    //get minute of string
                    if($timeMinute!="00"){
                        $lengthTime .= $timeMinute.':';
                        $stringTime  = ($stringTime!="")?$stringTime:'Min'; // concanate string time
                    }
                    
                    //get second of string
                    if($timeSecond!="00"){
                        $lengthTime .= $timeSecond.'';
                        $stringTime  = ($stringTime!="")?$stringTime:'Sec'; // concanate string time
                    }
                    
                    $durationTime  = ($lengthTime!="")?$lengthTime.' '.$stringTime:$defaultLength;
                }
            }
            return $durationTime;
        }
    }
    
    //------------------------------------------------------------------------
    
    /*
    *  @description: This helper for not show section by config defined 
    *  @auther: lokendra meena
    *  @return: boolean;
    */ 
    
    if(!function_exists('sectionNotShow')){
        function sectionNotShow($sectionName=''){
            
            $CI =& get_instance();
            $methodName       =   $CI->router->fetch_method();
            $className        =   $CI->router->fetch_class();
            $sectionShow      =   true;
            
            if($sectionName){
                $configList= $CI->config->item($sectionName);
                
                if(!empty($configList)){
                    
                    if(array_key_exists($className, $configList)){
                        if(!empty($configList[$className])){
                            if(array_key_exists($methodName, $configList[$className])){
                                $sectionShow=false;
                            }
                        }else{
                            $sectionShow=false;
                        }
                    }

                }
            }
            return $sectionShow;
        }
    } 
    
    
    //------------------------------------------------------------------------
    
    /*
    *  @description: This helper for show section by config defined 
    *  @auther: lokendra meena
    *  @return: boolean;
    */ 
    
    if(!function_exists('sectionShow')){
        function sectionShow($sectionName=''){
            $CI =& get_instance();
            $methodName       =   $CI->router->fetch_method();
            $className        =   $CI->router->fetch_class();
            $sectionShow      =   false;
            
            if($sectionName){
                $configList= $CI->config->item($sectionName);
                
                if(!empty($configList)){
                    if(array_key_exists($className, $configList)){
                        
                        if(!empty($configList[$className])){
                            if(in_array($methodName, $configList[$className])){
                                $sectionShow=true;
                            }
                        }else{
                            $sectionShow=true;
                        }
                    }

                }
            }
            return $sectionShow;
        }
    }
    
    //-------------------------------------------------------------------------
    
    /*
    * @descriptin: This method is use to show specific string
    * @auther: lokendra meena
    * @return: string
    */ 
    
    if(!function_exists('showString')){
        function showString($string='',$stringCount="25"){
            return substr($string, 0, $stringCount);
        }
    } 
    
	//-------------------------------------------------------------------------
    
    /*
    * @descriptin: This method is use to get newsletter lis
    * @auther: Tosif Qureshi 
    * @return: string
    */ 
    if ( ! function_exists('getNewsletterList')) {
		function getNewsletterList($lang='en') {
			if($lang=='') {
				$lang = lang();
			}
			$CI =& get_instance();
			$data[''] = $CI->lang->line('selectNewsletter');
			$whereField = array('status'=>'t');
			
			$res = $CI->model_common->getDataFromTabel('EmailNewsletter', 'id,title',  $whereField, '', 'title','ASC',0,0,false);
			if($res){
				foreach ($res as $newsletter){
                    $data[$newsletter->id] = $newsletter->title;
				}
			}
			return $data;
		}
	}	
    
    
    //-------------------------------------------------------------------------
    
    /*
    * @descriptin: This method is use to get newsletter lis
    * @auther: lokendr meena
    * @return: string
    */ 
    if ( ! function_exists('getImageInfo')) {
		function getImageInfo($entityId=0,$elementId=0,$sectionId=0) {
		       return Modules::run("cart/getImageInfo",$entityId,$elementId,$sectionId);
		}
	}	
    
    //-------------------------------------------------------------------------
    
    /*
    * @descriptin: This method is human readable form file size
    * @auther: Lokendra meena
    * @return: string
    */ 
    if ( ! function_exists('formatSizeUnits')) {
		function formatSizeUnits($bytes)
            {
                if ($bytes >= 1073741824)
                {
                    $bytes = number_format($bytes / 1073741824, 2) . ' GB';
                }
                elseif ($bytes >= 1048576)
                {
                    $bytes = number_format($bytes / 1048576, 2) . ' MB';
                }
                elseif ($bytes >= 1024)
                {
                    $bytes = number_format($bytes / 1024, 2) . ' KB';
                }
                elseif ($bytes > 1)
                {
                    $bytes = $bytes . ' bytes';
                }
                elseif ($bytes == 1)
                {
                    $bytes = $bytes . ' byte';
                }
                else
                {
                    $bytes = '0 bytes';
                }

                return $bytes;
        }
	}	
    
    //----------------------------------------------------------------------
    
    /*
    * @descriptin: This method is use to get newsletter lis
    * @param: array
    * @auther: lokendr meena
    * @return: object
    */ 
    if ( ! function_exists('getSocialMediaLinks')) {
		function getSocialMediaLinks($whereCondi=false) {
		    $CI =&get_instance();
			$result = $CI->model_common->getSocialMediaLinks($whereCondi);
            return $result;
		}
	}
	
	//----------------------------------------------------------------------
    
    /*
    * @descriptin: This method is use to get project details by container id
    * @param: array
    * @auther: Tosif qureshi
    * @return: object
    */ 
    if ( ! function_exists('getContainerProjData')) {
		function getContainerProjData($containerId=0) {
		    $CI =&get_instance();
			$containerRes  =  $CI->model_common->getContainerProjData($containerId);
			
            return $containerRes;
		}
	}
	
	/*
   * @description : This function is use to get refund collaboration project image
   * @param: projectdata
   * @return: string
   */ 
	if ( ! function_exists('getCollaborationRefundImage')) {	
		function getCollaborationRefundImage($userContainerId=0) {
			$CI =& get_instance();
			// get products all promotional images
			$whereField = array('userContainerId'=>$userContainerId);
			$res = $CI->model_common->getDataFromTabel('Collaboration', 'coverImage',  $whereField, '', '','ASC',0,0,false);
			
			if(isset($res[0]->coverImage) && !empty($res[0]->coverImage) ){
				$mainCoverImage = $res[0]->coverImage;
			}
			else{
				$mainCoverImage = '';
			}
			$defCoverImage = $CI->config->item('defaultcollaborationImage');
			$coverImage = addThumbFolder($mainCoverImage,$suffix='_b',$thumbFolder ='thumb',$defCoverImage);	
			$projectImage = getImage($coverImage,$defCoverImage);
			return $projectImage;
		}
	}

	/*
   * @description : This function is use to get refund Competition project image
   * @param: projectdata
   * @return: string
   */ 
	if ( ! function_exists('getCompetitionRefundImage')) {	
		function getCompetitionRefundImage($userContainerId=0) {
			$CI =& get_instance();
			// get products all promotional images
			$whereField = array('userContainerId'=>$userContainerId);
			$res = $CI->model_common->getDataFromTabel('Competition', 'coverImage',  $whereField, '', '','ASC',0,0,false);
			
			if(isset($res[0]->coverImage) && !empty($res[0]->coverImage) ){
				$mainCoverImage = $res[0]->coverImage;
			} else {
				$mainCoverImage = '';
			}
					
			$coverImage = '';
			$defCoverImage = $CI->config->item('defaultcompetitonImg73X110');
			$coverImage = addThumbFolder($mainCoverImage,$suffix = '_b',$thumbFolder = 'thumb',$defCoverImage);	
			$projectImage = getImage($coverImage,$defCoverImage);
			return $projectImage;
		}
	}

	/*
   * @description : This function is use to get refund product, event, work project image
   * @param: projectdata
   * @return: string
   */ 
	if ( ! function_exists('getRefundProjectImage')) {	
		function getRefundProjectImage($userContainerId=0) {
			$CI =& get_instance();
			// get products all promotional images
			$whereField = array('userContainerId'=>$userContainerId);
			$res = $CI->model_common->getDataFromTabel('UserContainer', 'entityId,elementId',  $whereField, '', '','ASC',0,0,false);
			
			if(!empty($res[0])) {
				$containerRes = $res[0];
				$projectImage = getProjectImage($containerRes->entityId,$containerRes->elementId,$containerRes->elementId,'','_b');
			} else {
				$projectImage = '';
			}
					
			return $projectImage;
		}
	}
	
  /*
   * @description : This function is use to get blog or post image
   * @param: elementData, isBlog : 1 blog 0 post
   * @return: string
   */ 
	if ( ! function_exists('getBlogImage')) {	
		function getBlogImage( $elementData='',$isBlog=0,$thumbSize='_s') { 
			
			$CI = & get_instance();
			$imagetype = $CI->config->item('blogImage');
			$imageSize = '_m';
			
			if(!empty($elementData)) {
				// get image default profile type status
				if($isBlog == 1) {
					$isProfileImage = $elementData->isProfileCoverImage;
				} else {
					$isProfileImage = $elementData->isUserProfileImage;
				}
				
				if(!empty($elementData->filePath)) {
					// get thumb image path
					$getThumbImage = addThumbFolder($elementData->filePath.$elementData->fileName,$thumbSize);
					if(file_exists($getThumbImage)) {
						$thumbImage = $getThumbImage;
					} else {
						$thumbImage = $elementData->imagePath;
					}
					
					if($elementData->isExternal=="t") {
						$thumbImage = array("filePath"=>$elementData->filePath,"isExternal"=>"t");	
						// set embedd Image
						$blogImage = checkExternalImage($elementData->filePath,$imagetype);
					} else {
						//$thumbImage = $elementData->filePath.$elementData->fileName;
						if(file_exists($thumbImage)) {
							$blogImage = getImage($thumbImage,$imagetype);
						} else {
							$blogImage = getImage($thumbImage,$imagetype);
						}
					}	
				}  else if( $isProfileImage == 't' ) {
                   
                    // set user's profile image as cover image
                    $getUserId =  $elementData->custId;
                    //get user showcase details
                    $userInfo   =  showCaseUserDetails($getUserId,'userBackend');

                    //get user first name
                    $userFullName = $userInfo['userFullName'];

                    //if(isset($userNavigations) && is_array($userNavigations) && count($userNavigations) > 0 &&(in_arrayr( 'enterprises', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'associatedprofessionals', $userNavigations, $key='section', $is_object=0 ) || in_arrayr( 'creatives', $userNavigations, $key='section', $is_object=0 ))){ 
                    if(!empty($userInfo['creative']) || !empty($userInfo['associatedProfessional']) || !empty($userInfo['enterprise'])){ 
                        $userDefaultImage=($userInfo['enterprise']=='t')?$CI->config->item('defaultEnterpriseImg'.$imageSize):($userInfo['associatedProfessional']=='t'?$CI->config->item('defaultAssProfImg'.$imageSize):$CI->config->item('defaultCreativeImg'.$imageSize));
                    }else{
                        $userDefaultImage=$CI->config->item('defaultMemberImg'.$imageSize);
                    }

                    $userTemplateThumbImage = addThumbFolder($userInfo['userImage'],$imageSize);	
                    $blogImage = getImage($userTemplateThumbImage,$userDefaultImage);
                } else {
					$thumbImage = $elementData->imagePath;
					$blogImage = getImage($thumbImage,$imagetype);
				}
		} else {
		    return false;
		}
					
			return $blogImage;
		}
	}

    
    //---------------------------------------------------------------------
    /*
     *   search by key=>value in a multidimensional array in PHP
     * 
     */ 
    
    if ( ! function_exists('searchinarray')) {	
     function searchinarray($array, $key, $value)
        {
            $results = array();

            if (is_array($array)) {
                if (isset($array[$key]) && $array[$key] == $value) {
                    $results[] = $array;
                }

                foreach ($array as $subarray) {
                    $results = array_merge($results, searchinarray($subarray, $key, $value));
                }
            }

            return $results;
        }
    }
    

	
	if( ! function_exists('key_in_arrayr'))
	{
		function key_in_arrayr( $value, $array ) {
			
			foreach($array as $arrKey => $arrValue){
				
                if(in_array($value,$arrValue) && $arrValue['elementid']==$arrValue['projectid'] ){
					
					//return $arrValue['ispublished'];
					return $arrValue;
				}
            }
            return false;
        }
    
    }

    //-------------------------------------------------------------------------
    
    /*
     * background color class get helper
     * 
     */ 
    
    if( ! function_exists('templatebgname'))
	{
		function templatebgname() {
			
            $CI =&get_instance();
            $className       = "";
            $getClassName    =  $CI->router->fetch_class(); // get class name
            $getMethodName   =  $CI->router->fetch_method(); // get class name
            switch($getClassName){
                case "creatives":
                    $className = "lp_crav";
                break;
                
                case "associateprofessional":
                    $className = "lp_professional";
                break;
                
                case "enterprises":
                    $className = "lp_business";
                break;
                
                case "fans":
                    $className = "bg_fans";
                break;
                
                case "filmnvideo":
                    $className = "PA_splash_texture";
                break;
                
                case "musicnaudio":
                    $className = "ma_landing";
                break;
                
                case "writingnpublishing":
                    $className = "writing_bg";
                break;
                
                case "photographynart":
                    $className = "photo_lp memberhsip";
                break;
                
                case "educationnmaterial":
                    $className = "lp_piceswrap";
                break;
               
                case "forums":
                    $className = "bg_forum";
                break;
               
                case "help":
                    $className = "bg_help";
                break;
                
                case "home":
                    $className = "bg_index";
                break;
                
                case "help":
                case "tips":
                    $className = "bg_help";
                break;
                
                case "blogs":
                    if($getMethodName=="index" || $getMethodName=="photographyart" || $getMethodName=="musicaudio"
                    || $getMethodName=="writingpublishing" || $getMethodName=="educationmaterial" || $getMethodName=="others"){
                        $className = "blog_bg";
                    }
                break;
                
                default:
                    $className = "";
                break;
            }
            
            return  $className;
			
        }
    
    }
    
    //----------------------------------------------------------------------
    
    /*
     * @description: read files and zip make  
     */ 
    
    if( ! function_exists('selectedfileszip'))
	{
		function selectedfileszip($fileList,$fileName) {
            
            # create new zip opbject
            $zip = new ZipArchive();

            # create a temp file & open it
            $tmp_file = tempnam('.','');
            //$zip->open($tmp_file, ZipArchive::CREATE);
            
            if($zip->open($tmp_file, ZIPARCHIVE::CREATE)===TRUE)
            { 
                # loop through each file
                foreach($fileList as $file){

                    # download file
                    $download_file = file_get_contents($file);

                    #add it to the zip
                    $zip->addFromString(basename($file),$download_file);

                }

                # close zip
                $zip->close();

                # send the file to the browser as a download
                header('Content-disposition: attachment; filename='.$fileName.'.zip');
                header('Content-type: application/zip');
                readfile($tmp_file);
                unlink($tmp_file);
            }
        }
    }
    
    if( ! function_exists('getStringBetween')){
        function getStringBetween($str,$from,$to){
            $sub = substr($str, strpos($str,$from)+strlen($from),strlen($str));
            $sub =  substr($sub,0,strpos($sub,$to));
            return trim($sub);
        }
    }
    

    /*
   * @description : This function is use to get blog or post image
   * @param: isPrice, isShippable, indusrtyName
   * @return: string
   */ 
    if( ! function_exists('getElementFileType')){
        function getElementFileType($isPrice='f',$isShippable='f',$indusrtyName='',$mediaFileType='') {
			
			switch($indusrtyName) {	
				case 'filmNvideo':
					$fileType = 'Video File';
					if($isPrice == 't' && $isShippable == 't')	
						$fileType = 'DVD';
				  			
				 break;
				 
				case 'musicNaudio':
					$fileType = 'Audio File';
					if($isPrice == 't' && $isShippable == 't')	
						$fileType = 'CD';
									
				 break;
				 
				case 'writingNpublishing':
					$fileType = 'Text File';	
					if($isPrice == 't' && $isShippable == 't')	
						$fileType = 'Text';
							
				break;				
				
				case 'photographyNart':
					$fileType = 'Image File';
					if($isPrice == 't' && $isShippable == 't')	
						$fileType = 'Print';
										
				break;
				 
				case 'educationMaterial':
					switch($mediaFileType) {
						case 2:
							$fileType = 'Video File';
							if($isPrice == 't' && $isShippable == 't')
								$fileType = 'DVD';
				
							break;
						case 3:
							$fileType = 'Audio File';
							if($isPrice == 't' && $isShippable == 't')
								$fileType = 'CD';
							
							break;
						case 4:
							$fileType = 'Text File';
							if($isPrice == 't' && $isShippable == 't')
								$fileType = 'Text';
						
							break;
						default :
							$fileType = 'Video File';
							if($isPrice == 't' && $isShippable == 't')
								$fileType = 'DVD';
							
							break;
					}
				break;
				
				default:
					$fileType = '';
				break;						
			}
			return $fileType;
		}
	}
    
    
    /* Get category name From id */
    
    if( ! function_exists('getCategoryname')){
        function getCategoryname($catid){
          if($catid==''){
				return '';
			}
			else{			
				$CI =& get_instance();
				$whereField = array('CategoryID'=>$catid);
				$res = $CI->model_common->getDataFromTabel('forum_category', 'Name',  $whereField, '', 'Name','Desc');
				return $res[0]->Name;
			}
		}
	}
    

    /* Get categorylist name From id */
    
    if( ! function_exists('getCategorylist')){
        function getCategorylist($type){
				$CI =& get_instance();
					$whereField = array('parentID'=>'0','type'=>$type,'thrash'=>'0','Active'=>'1');
					$res = $CI->model_common->getDataFromTabel('forum_category','CategoryID,Name',  $whereField, '', 'Name','Desc');
					if($res){
					foreach ($res as $val){
						$data[$val->CategoryID] = $val->Name;
					}
				}
				return $data;
			}
		}  

    /*
    *
    * @description: get master industry by spefice category group wise
    * @auther: lokendra meena
    */  
     
    if ( ! function_exists('getSelectedSearchIndustryList')){		 
		/* 
		 * function to get industry for sarch section.
		 */
		function getSelectedSearchIndustryList($industryArray=false){
			
			$CI =& get_instance();
			$data[''] = $CI->lang->line('selectIndustry');
            if($industryArray){
                $whereCondition = array('isSearchSection'=>'t');
                $res = $CI->model_common->getDataFromTabelWhereIn('MasterIndustry', 'IndustryId,IndustryName','IndustryId', $industryArray,$whereCondition);
               if($res){
                    foreach ($res as $industry){
                        $data[$industry['IndustryId']] = $industry['IndustryName'];
                    }
                }
            }
			return $data;
		}
	} 
	
	if ( ! function_exists('getFluencyTypeList')){		 
	/* function for get fluency type List.
	 * Wriiten By Tosif Qureshi
	 */
		function getFluencyTypeList() {
			
			$CI =&get_instance();
			
			$fluencyType =  $CI->config->item('fluency_type');
			
			if($fluencyType){
				$fluency[''] = $CI->lang->line('selectFluency');
				for ($i=0;$i<count($fluencyType);$i++) {
					$fluency[$fluencyType[$i]] = $fluencyType[$i];
				}
				return $fluency;
			}else{
				return false;
			}
		}
	}
    
    if ( ! function_exists('redirectPage'))
    {
        function redirectPage($uri = '', $method = 'location', $http_response_code = 302)
        {
            if ( ! preg_match('#^https?://#i', $uri))
            {
                $uri = site_url($uri);
            }

            switch($method)
            {
                case 'refresh'	: header("Refresh:0;url=".$uri);
                    break;
                default: 
                    $CI =& get_instance();
                    $CI->load->view('redirect',array('uri'=>$uri,'http_response_code'=>$http_response_code));
                    return true;
                break;
            }
            exit;
        }
    }

/* function to check email id.
	* Wriiten By Amit Neema
*/
	
	if ( ! function_exists('checkEmailId')){		 
		function checkEmailId($email) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
              return true;
            } else {
              return false;
            }
		}
	} 
	
	if ( ! function_exists('getMaritalTypeList')){		 
	/* function for get marital type List.
	 * Wriiten By Tosif Qureshi
	 */
		function getMaritalTypeList() {
			
			$CI =&get_instance();
			
			$maritalType =  $CI->config->item('marital_status_type');
			
			if($maritalType){
				$maritalAry[''] = $CI->lang->line('selectMaritalType');
				for ($i=0;$i<count($maritalType);$i++) {
					$maritalAry[$maritalType[$i]] = $maritalType[$i];
				}
				return $maritalAry;
			}else{
				return false;
			}
		}
	}
	
	if ( ! function_exists('getRemunerationRateList')){		 
	/* function for get Remuneration Rate List.
	 * Wriiten By Tosif Qureshi
	 */
		function getRemunerationRateList() {
			
			$CI =&get_instance();
			
			$rateType =  $CI->config->item('renumeration_rates');
			
			if($rateType){
				$rateAry[''] = $CI->lang->line('selectPeriod');
				for ($i=0;$i<count($rateType);$i++) {
					$rateId = $i+1;
					$rateAry[$rateId] = $rateType[$i];
				}
				return $rateAry;
			}else{
				return false;
			}
		}
	}
	
	if ( ! function_exists('getAvailabilityList')){		 
	/* function for get Remuneration Rate List.
	 * Wriiten By Tosif Qureshi
	 */
		function getAvailabilityList() {
			
			$CI =&get_instance();
			
			$availabilityType =  $CI->config->item('availability_type');
			
			if($availabilityType){
				$availabilityAry[''] = $CI->lang->line('selectAvailability');
				for ($i=0;$i<count($availabilityType);$i++) {
					$availabilityAry[$availabilityType[$i]] = $CI->lang->line($availabilityType[$i]);
				}
				return $availabilityAry;
			}else{
				return false;
			}
		}
	}


    /*
    * @description: This method is use to preivew project and element
    * @auther: lokendra meena
    * @return: string
    */ 
	
	if ( ! function_exists('previewModeActive')){
		function previewModeActive(){
           
            //get current url
            $getCurrentString =  current_url();
            $isPreview        =  false;
            
            //check if preivew word exist then not published project also view
            if(strpos($getCurrentString,'preview') !== false && isLoginUser() > 0){
                $isPreview                        =   true;
            }
            
            return $isPreview;
		}
	} 
	
	if ( ! function_exists('getWorkLocation')){		 
	/*
	 *  function for get location name
	 */
		function getWorkLocation($locationType=0,$locationId=0)
		{
			$CI =&get_instance();
			if($locationType == 1) {
				$res =  $CI->model_common->getDataFromTabel('MasterContinent', 'continent as name',array('id'=>$locationId));
			} else if($locationType == 2) {
				$res =  $CI->model_common->getDataFromTabel('MasterCountry', 'countryName as name',array('countryId'=>$locationId));
			} else {
				$res =  $CI->model_common->getDataFromTabel('MasterStates', 'stateName as name',array('stateId'=>$locationId));
			}
			
			if($locationType > 0 && isset($res) && !empty($res)) {
				return $res[0]->name;
			}else{
				return false;
			}
		}
	}
    
    
    //---------------------------------------------------------------------
    
    /*
    *  description: This method is use to show current stage update
    *  @param: array
    *  @auther: lokendra meena
    */ 
    
    if ( ! function_exists('yourToadsqureData')){
	/*
	 *  function for get location name
	 */
		function yourToadsqureData($dataArray)
		{
            $CI =& get_instance();
            $userId = isLoginUser();
            
            $entityid               =  (isset($dataArray['entityid']))?$dataArray['entityid']:0;
            $elementid              =  (isset($dataArray['elementid']))?$dataArray['elementid']:0;
            $projectid              =  (isset($dataArray['projectid']))?$dataArray['projectid']:0;
            $item                   =  (isset($dataArray['item']))?$dataArray['item']:NULL;
            $section                =  (isset($dataArray['section']))?$dataArray['section']:NULL;
            $sectionid              =  (isset($dataArray['sectionid']))?$dataArray['sectionid']:0;
            $ispublished            =  (isset($dataArray['ispublished']))?$dataArray['ispublished']:'f';
            $currentStage           =  (isset($dataArray['currentStage']))?$dataArray['currentStage']:NULL;
            $isCompleted            =  (isset($dataArray['isCompleted']))?$dataArray['isCompleted']:'f';
            $sectionParent          =  (isset($dataArray['sectionParent']))?$dataArray['sectionParent']:NULL;
            $tdsUid                 =  (!empty($userId))?$userId:0;
            
            //prepare for checking 
            $whereCondition      =   array('entityid'=>$entityid,'elementid'=>$elementid,'projectid'=>$projectid,'tdsUid'=>$tdsUid);
            $getResult           =   getDataFromTabel('YourToadsquare', '*',  $whereCondition, '','','',  $limit=1 );
            
            if(empty($getResult)){
                
                $inserData    =   array(
                    'entityid'              =>  $entityid,
                    'elementid'             =>  $elementid,
                    'projectid'             =>  $projectid,
                    'item'                  =>  $item,
                    'section'               =>  $section,
                    'sectionid'             =>  $sectionid,
                    'isPublished'           =>  $ispublished,
                    'currentStage'          =>  $currentStage,
                    'isCompleted'           =>  $isCompleted,
                    'tdsUid'                =>  $tdsUid,
                    'sectionparent'         =>  $sectionParent
                );
                //insert your toadsquare data
                $CI->model_common->addDataIntoTabel('YourToadsquare', $inserData);
            
            }
        }
	}
    
    
    //---------------------------------------------------------------------
    
    /*
    *  description: This method is use to show current stage update
    *  @param: array
    *  @auther: lokendra meena
    */ 
    
    if ( ! function_exists('currentStage')){
	/*
	 *  function for current stage
	 */
		function currentStage($dataArray)
		{
            $CI =& get_instance();
            $userId = isLoginUser();
            
            $entityid               =  (isset($dataArray['entityid']))?$dataArray['entityid']:0;
            $projectid              =  (isset($dataArray['projectid']))?$dataArray['projectid']:0;
            $tdsUid                 =  (!empty($userId))?$userId:0;
            
            //prepare for checking 
            $whereCondition      =   array('entityid'=>$entityid,'projectid'=>$projectid,'tdsUid'=>$tdsUid);
            $getResult           =   getDataFromTabel('YourToadsquare', '*',  $whereCondition, '','','',  $limit=1 );
            
            if(!empty($getResult)){
                
                $getResult           = $getResult[0];
                $isCompleted = $getResult->isCompleted;
                
                    if($isCompleted=="f"){
                    $updateData    =   array(
                        'currentStage'        =>  uri_string(),
                    );
                    //update your toadsquare data
                    $UserShowcaseData = array('currentStage'=>$currentStage);
                    $CI->model_common->editDataFromTabel('YourToadsquare', $updateData, $whereCondition);
                }
            }
        }
	}
    
    
     //---------------------------------------------------------------------
    
    /*
    *  description: This method is use to Add shopping cart data in Toadsquare
    *  @param: array
    *  @auther: Amit Neema  
    */ 
    
    if ( ! function_exists('yourToadsquareNotification')){
	/*
	 *  function for get location name
	 */
		function yourToadsquareNotification($dataArray,$type)
		{
            $CI =& get_instance();
            $userId = isLoginUser();
            $entityid               =  (isset($dataArray['entityid']))?$dataArray['entityid']:0;
            $elementid              =  ($dataArray['elementid'] != 0)?$dataArray['elementid']:$dataArray['projectid'];
            $projectid              =  (isset($dataArray['projectid']))?$dataArray['projectid']:0;
            $item                   =  ($dataArray['entityid'] != 54)?'element':'collection';
            $section                =  (isset($dataArray['sectionid']))?$CI->config->item('sectionId'.$dataArray['sectionid']):NULL;
            $sectionid              =  (isset($dataArray['sectionid']))?$dataArray['sectionid']:0;
            $ispublished            =  't';
            $isCompleted            =  't';
            $sectionParent          =  $type;
            $tdsUid                 =  (!empty($userId))?$userId:0;
            //prepare for checking 
                $inserData    =   array(
                    'entityid'              =>  $entityid,
                    'elementid'             =>  $elementid,
                    'projectid'             =>  $projectid,
                    'item'                  =>  $item,
                    'section'               =>  $section,
                    'sectionid'             =>  $sectionid,
                    'isPublished'           =>  $ispublished,
                    'isCompleted'           =>  $isCompleted,
                    'tdsUid'                =>  $tdsUid,
                    'sectionparent'         =>  $sectionParent
                );
                
                
                //insert your toadsquare data
                $CI->model_common->addDataIntoTabel('YourToadsquare', $inserData);
                
        }
	}
   
    
    
    
    
    

