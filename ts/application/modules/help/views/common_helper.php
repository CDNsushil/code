<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	if ( ! function_exists('formRowInputText')){
		function formRowInputText($param=array()){
			if(count($param) >0){
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
	if ( ! function_exists('dateFormate')){           
	/* function for change date format 
	 * Wriiten By Sushil Mishra 
	*/
		function dateFormate($fmt = 'DATE_d/m/Y', $time = '')
		{
			$formats = array(
							'DATE_d/m/Y'		=>	'%d/%m/%Y'
							);

			if ( ! isset($formats[$fmt]))
			{
				return FALSE;
			}

			return mdate($formats[$fmt], $time);
		}
	}
	if ( ! function_exists('lang')){           
		/* function for get language 
		 * Wriiten By Sushil Mishra 
		*/
		function lang(){
			$CI =& get_instance();
			return $CI->uri->segment(1);
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
             if (!is_dir($dirname."/".$file))
                @unlink($dirname."/".$file);
             else
                delete_directory($dirname.'/'.$file);    
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
		function getImage($imagePath='',$imagetype='')
		{
			if(!@empty($imagePath) && (@is_file($imagePath))){
				$imagepath=base_url($imagePath);
			}else{
				if($imagetype=='') $imagetype= 'images/no_images.jpg';
				else {
				$imagetype=$imagetype=='userIcon'?'images/icons/user.png':$imagetype=='user'?'images/user.png':'images/'.$imagetype;
				}
				$imagepath=base_url($imagetype);
			}
			return $imagepath;
		}
	}
	/**
		* Fetches the loaction for Location table to get displayed in preview of work
	**/	
	function getCountry($workCountryId)
	{
		$country = getDataFromTabel('MasterCountry','countryName',  'countryId', $workCountryId,'', 'ASC', $limit=1 );
		return $country[0]->countryName;
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
		/* function for get Country List.
		 * Wriiten By Sushil Mishra 
		 */
		function getMasterTableRecord($tableName='')
		{
			global $masterTable;
			if(!strstr($tableName,'TDS_')){
				$CI =&get_instance();
				$tableName=$CI->db->dbprefix($tableName);	
			}
			return $masterTable[$tableName];

		}
	}
	
	if ( ! function_exists('getCountryList')){		 
	/* function for get Country List.
	 * Wriiten By Sushil Mishra 
	 */
		function getCountryList()
		{
			$CI =&get_instance();
			// Change in parameter - added by Sapna Jain on 20-03-2012 - for country's Ordered list
			$res =  $CI->model_common->getDataFromTabel('MasterCountry', 'countryName,countryId',  'status', '1', 'countryName');
			if($res){
				$countries[''] = $CI->lang->line('selectCountry');
				foreach ($res as $country) {
						$countries[$country->countryId] = $country->countryName;
				}
				return $countries;
			}else{
				return false;
			}
		}
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
			$res =  $CI->model_common->getDataFromTabel('MasterLang', 'langId,Language_local','','Language');
			if($res){
				$languages[''] = $CI->lang->line('selectLanguage');
				foreach ($res as $language) {
						$languages[$language->langId] = $language->Language_local;
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
			$CI =& get_instance();
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
			$data[''] = $CI->lang->line($defaultOption);
			if($res){
				foreach ($res as $category)
				{
					$data[$category->catId] = $category->category;
				}
				
			}
			return $data;
		}
	}
	
	if ( ! function_exists('getTypeList')){		 
		/* function for get language List.
		 * Wriiten By Sushil Mishra 
		 */
		function getTypeList($IndustryId='', $lang='en', $defaultOption='selectProjectType',$catId=''){
			
			$CI =& get_instance();
			$whereField = array(
							'lang'=>$lang
						  );
			if(is_numeric($IndustryId)){
				$whereField['industryId']=$IndustryId;
			}
			if(is_numeric($catId)){
				$whereField['catId']=$catId;
			}
			$res = $CI->model_common->getDataFromTabel('MasterProjectType', 'typeId, projectTypeName',  $whereField, '', 'projectTypeName','ASC');
			//return $res;
			$data[''] = $CI->lang->line($defaultOption);
			if($res){
				foreach ($res as $type)
				{
					$data[$type->typeId] = $type->projectTypeName;
				}
				
			}
			return $data;
		}
	}

	if ( ! function_exists('getGenerList')){		 
	/* function for get language List.
	 * Wriiten By Sushil Mishra 
	 */
		function getGenerList($typeId=1, $lang='en', $defaultOption='selectProjectType')
		{
			
			$CI =&get_instance();
			// Change in parameter - added by Sapna Jain on 20-03-2012 - for country's Ordered list
			$genere=array();
			$genere['']=$CI->lang->line($defaultOption);
			if(is_numeric($typeId)){
				$res =  $CI->model_common->getGenerList($typeId, $lang);
				if($res){
					foreach ($res as $gener) {
							$genere[$gener->GenreId] = $gener->Genre;
					}
				}
				
			}
			//$genere['other'] = $CI->lang->line('other');
			return $genere;
		}
	}
	
		
	if ( ! function_exists('getRatingList')){		 
	/* function for get language List.
	 * Wriiten By Sushil Mishra 
	 */
		function getRatingList($IndustryId=1, $lang='en', $defaultOption='selectRating')
		{
			
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
		return ' ';
	}
	
	/**
		* Fetches the industry  from industry  array to get displayed in preview of work
	**/	
	function loadIndustry()
	{
		$industry = getDataFromTabel('MasterIndustry','IndustryId,IndustryName','','','IndustryName');
		//echo "<pre />"; print_r($industry);
		return $industry;
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
		$finalUserName = $resultUserName[0]->firstName.'&nbsp;'.$resultUserName[0]->lastName;
		return $finalUserName;
	}

	/**
		* Fetches the industry  from industry  array to get displayed in preview of work
	**/	
	function getUserImage($UId)
	{
		
		$resultUserName = getDataFromTabel('UserProfile','image',  'tdsUid', $UId,'', 'ASC', $limit=1 );
		if(count($resultUserName)>0)$finalUserImage = $resultUserName[0]->image;
		else $finalUserImage = 0;
		return $finalUserImage;
	}
	
	/**
		* Fetches the given file from given table name for the primary Id given for defined table name
		* @param:anyField //this to specify which field I want to extract from table
		* @param:anyTable //this to specify from which table I need record(anyField)
		* @param:anyWhereField //this is to specify on which I have to apply the where clause
		* @param:anyWhereFieldValue //this to specify for which value have to apply the where clause
	**/	
	function getFieldValueFrmTable($anyField='blogImgPath',$anyTable='Blogs',$anyWhereField='',$anyWhereFieldValue=0)
	{
		$anyrecordValue = getDataFromTabel($anyTable,$anyField,  $anyWhereField, $anyWhereFieldValue);
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
			$CI =& get_instance();
			$global_messages = (array)$CI->session->userdata('global_messages');
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
			$CI =& get_instance();
			
			$global_messages = (array)$CI->session->userdata('global_messages');
			
			if(count($global_messages) > 0) {
				foreach($global_messages as $k => $v) {
					echo '<div id="messageSuccessError" class="'.$k.'">';
					
					foreach((array)$v as $w) {
						echo "$w\n";
					}
					
					echo '</div>';
				}
			} 
			
			$CI->session->unset_userdata('global_messages');
			
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
			$user_id=$CI->session->userdata('user_id');
			if($user_id > 0){
				return $CI->session->userdata($field);
			}else{
				return false;
			}
		}
	}
	
	function object2array($object) {
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
		


			// -- after the page reloads, print them out --
			
			$country='India';
			return $country;
			if (isset($_COOKIE['toadSquare'])) {
				$country=$_COOKIE['toadSquare']['Country'];
				
			}else{
			
				if($_SERVER["REMOTE_ADDR"]=="" || $_SERVER["REMOTE_ADDR"]=="::1" || $_SERVER["REMOTE_ADDR"]=="127.0.0.1" || substr($_SERVER["REMOTE_ADDR"],0,3) =="192")
				{
					$_SERVER["REMOTE_ADDR"]="115.113.182.141";
				}
				
				// -- Request to API to get Country --
				
				$tags = @get_meta_tags('http://www.geobytes.com/IpLocator.htm?GetLocation&template=php3.txt&IpAddress='.$_SERVER["REMOTE_ADDR"]);
				$country = @$tags['country'];
				
				if (is_array($tags)){
					$country = @$tags['country'];
					// -- set the cookies --
					setcookie("toadSquare[shortCountry]", @$tags['iso2'], time()+(3600*24*365));
					setcookie("toadSquare[Country]", @$tags['country'], time()+(3600*24*365));
					setcookie("toadSquare[City]", @$tags['city'], time()+(3600*24*365));			
					
				}
			}
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
				if(($uploaddata['file_ext'] != 'flv') && ($type=='video')){
					$uploaddata['file_name'] =$uploaddata['file_name'].".flv";
					exec("ffmpeg -i ".$directory_path_full." ".$directory_path.$uploaddata['file_name']); 
				}else{
					$uploaddata['file_name'] =$uploaddata['file_name'].$uploaddata['file_ext'];
				}
				$uploaddata['return']= true;
				
			}

			return $uploaddata;
		}
	}
	
	if(! function_exists('getDataFromTabel')){
		function getDataFromTabel($table='', $field='*',  $whereField='', $whereValue='', $orderBy='', $order='ASC', $limit=0 ){
			$CI =& get_instance();
			$res =  $CI->model_common->getDataFromTabel($table, $field,  $whereField, $whereValue, $orderBy, $order, $limit );
			return $res;
		}
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

		if(isset($uploadArray['userfile']['name'])){

			if($promoMediaFieldValues['mediaId']==0 && $uploadArray['userfile']['name'] == ''){
				$message= 'You did not select a file to upload';
				set_global_messages($message, 'error');
				redirect($returnUrl);
			}
			if($uploadArray['userfile']['name'] != ''){

				$uploadedData = $CI->lib_sub_master_media->do_upload($uploadArray,$promoMediaPath,$entityId,$fileType);
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
				$data['fileCreateDate'] = date("Y-m-d H:i:s");
				//Insert data into main mediaFile. get the Id of mediaFile....

				$fileId = $CI->model_common->addDataIntoTabel('MediaFile', $data);

				unset($data['fileId']);
				$dataSetValue = $CI->lib_mastermedia->setValues($data);
				$data= $CI->lib_mastermedia->getValues();
				$promoMedia['data']['fileId'] = $fileId;
			}
		}
		//if($launchEventId>0) $promoMedia['data']['launchEventId']=$launchEventId;

		unset($promoMedia['data']['filePath']);
		unset($promoMedia['data']['fileName']);
		unset($promoMedia['data']['fileSize']);
		unset($promoMedia['data']['fileType']);
		unset($promoMedia['data']['fileCreateDate']);
		unset($promoMedia['data']['entityId']);
		
		if(strcmp($promoMedia['data']['mode'],'edit') == 0) {
			unset($promoMedia['data']['mediaId']);
			unset($promoMedia['data']['mode']);
		}
		//echo '<pre />';print_r($promoMedia['data']);die;
		$savePromoImageQuery = $CI->lib_sub_master_media->savePromoMedia($promoMedia['data'],$tableName);
		//redirect($returnUrl);
	}


	function createMultiThumb($imageStuff,$versionThumbsFolderPath)  //file name passed
	{  	
		$CI =& get_instance();
		if (!file_exists($versionThumbsFolderPath)) {
			if (!mkdir($versionThumbsFolderPath, 0777, true)) {
				die('Failed to create folders...');
			}
		}
		// Use strrpos() & substr() to get the file extension
		$ext = substr($imageStuff['filename'], strrpos($imageStuff['filename'], "."));
		// Then stitch it together with the new string and file's basename
		$orgImageName = $imageStuff['filename'];
		// this thumbnail created
		$config['image_library'] = 'gd2';
		$config['source_image']    = $versionThumbsFolderPath.$orgImageName;
		$config['create_thumb'] = FALSE;   
		$config['maintain_ratio'] = TRUE;
		$config['width']     = $imageStuff['width'];
		$config['height']   = $imageStuff['height'];
		
		// Then stitch it together with the new string and file's basename
		$newImageName = basename($imageStuff['filename'], $ext) . $imageStuff['suffix'] . $ext;

		$config['new_image'] = $versionThumbsFolderPath.$newImageName;
		$CI->load->library('image_lib', $config);
		$CI->image_lib->initialize($config);
		if ( ! $CI->image_lib->resize()){echo $CI->image_lib->display_errors();}

		$CI->image_lib->clear();
		return $newImageName;
	   
	}

	function getSessionTimeAtt($sesTimeId){
		$CI =& get_instance();
		$sessionattribute = $CI->model_common->getSessionTimeAtt($sesTimeId);
		return $sessionattribute;	
	}
	//////////////////////////////// Added By Sapna ///////////////////////
	function getProductImages($localMediaTable,$filedName,$imageId,$productType='',$orderBy=''){
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
	
	function getProductCategoryName($productCategoryId='1'){
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
		@unlink($filePath.$fileName);
	
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

		$toBeupdatedImageId = $result->mediaId;

		$updateData->isMain = 'f';
		$field = 'mediaId';
		$CI->db->where($field,$toBeupdatedImageId);
		$CI->db->update($localMediaTable,$updateData);
		return true;
	}

	function getMediaDetail($fileId)
	{
		$CI =& get_instance();
		$data = $CI->model_common->getDataFromTabel('MediaFile', '*',  'fileId', $fileId, '', 'ASC', 0 );
		return $data;
	}


	//////////////////////// End List By Sapna//////////////////////////////////////////////

	if(! function_exists('addDataIntoLogSummary')){
		function addDataIntoLogSummary($tblName,$elementId)  //file name passed
		{
			$CI =& get_instance();
			$tblLogSummary = $CI->db->dbprefix('LogSummary');
			$entityId = getMasterTableRecord($tblName);	
			$where = 'WHERE "entityId"= '.$entityId.' AND "elementId"= '.$elementId.' ';
			$res = $CI->model_common->getDataFromMixTabel('"'.$tblLogSummary.'"', '"actId"',  $where, '',  'LIMIT 1' );

			if(!$res){
				$dataLogSummary = array(
					'entityId'=>$entityId,
					'elementId	' => $elementId,
					'viewCount' => 1,
					'createDate' => date('Y-m-d h:i:s'),
					'lastViewDate' => date('Y-m-d h:i:s')
				);
				$CI->model_common->addDataIntoTabel('LogSummary', $dataLogSummary);
			}
		}
	}

	if(! function_exists('getUserPackages')){
		function getUserPackages($key='')  //file name passed
		{
			$CI =& get_instance();
			$userPackages=$CI->session->userdata('userPackages');
			
			if($userPackages){
				$userPackages=json_decode($userPackages);
				if(is_numeric($key)){
					$userPackages=$userPackages[$key];
				}
			}
			return $userPackages;
		}
	}

	function insertDataIntoContainer(){
		$containerId=0;
		$CI =& get_instance();
		$key=$CI->session->userdata('userSelectedPackageKey');
		$userPackage=getUserPackages();
		$userSelectedPackage=@$userPackage->$key?@$userPackage->$key:false;
		if($userSelectedPackage){
			$expiryDate= date('Y-m-d h:i:s', (time() + ($userSelectedPackage->validity * 24 * 60 * 60)));
			$entityId=$userSelectedPackage->isFree==1?getMasterTableRecord('UserPackage'):getMasterTableRecord('MasterPackage');
			$container = array(
								'tdsUid'=>isLoginUser(),
								'pkgId'=>$userSelectedPackage->id,
								'entityId'=>$entityId,
								'elementId'=>$userSelectedPackage->id,
								'containerSize'=>$userSelectedPackage->size,
								'createdDate'=>date('Y-m-d h:i:s'),
								'expiryDate'=>$expiryDate,
								'containerStatus'=>'t'
							 );
			$containerId=$CI->model_common->addDataIntoTabel('UserContainer', $container);
			
			if($containerId){
				unset($userPackage[$key]);
				//var_dump($userPackage);
				$CI->session->unset_userdata('userSelectedPackageKey');
				$CI->session->set_userdata('userPackages',json_encode($userPackage));
			}

			
		}
		return $containerId;
		
	}

	function isUserSelectPackag(){
		$CI =& get_instance();
		$key=$CI->session->userdata('userSelectedPackageKey');
		if(is_numeric($key)){
			return true;
		}else{
			set_global_messages($CI->lang->line('selctPackageFirst'),'error');
			if(isset($_SERVER['HTTP_REFERER'])){
					$redirect=$_SERVER['HTTP_REFERER'];
			}else{
				$redirect=$CI->router->fetch_class();
			}
			redirect($redirect);
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
	 
	 function countResult($table='',$field='',$value='')
	 {
		 $CI =& get_instance();
		 return $CI->model_common->countResult($table,$table.'.'.$field,$value);
	 }
	 
	 function userProfileImage($userId=0)
	 {
		$CI =& get_instance();
		$currentClass = $CI->router->class;
		$myShowcase = 0;
		$userFullName = '';
		if(!isset($userId) && $userId<=0 || strcmp($currentClass,'showcase')!=0) {
			$userId = isLoginUser();
			$userFullName = LoginUserDetails('firstName').' '.LoginUserDetails('lastName');
			
			$myShowcase = 1;
		}
		
		$userImage = LoginUserDetails('imagePath');
		
		if($userImage && !empty($userImage) && $myShowcase == 1)
		{
			$username = LoginUserDetails('username');
			$userFullName = LoginUserDetails('firstName').' '.LoginUserDetails('lastName');
			$userInfo['userFullName'] = $userFullName;
			$userInfo['userImage'] = $userImage;
			return $userInfo;
		}
		else
		{
			$userImage='';
			
			$res =  $CI->model_common->getDataFromTabel('UserShowcase', 'profileImageName,stockImageId,optionAreaName', 'tdsUid', $userId, '', '', $limit=1 );
			$res1 =  $CI->model_common->getDataFromTabel('UserProfile', 'firstName,lastName', 'tdsUid', $userId, '', '', $limit=1 );
			$resUserName =  $CI->model_common->getDataFromTabel('UserAuth', 'username', 'tdsUid', $userId, '', '', $limit=1 );
			
			if($res){
				$stockImgId=$res[0]->stockImageId;
				$userFullName = $res1[0]->firstName.' '.$res1[0]->lastName;
				//echo 'User Area:'.$userArea = $res[0]->optionAreaName;
				if($stockImgId){
					$resStockImage =  $CI->model_common->getDataFromTabel('StockImages', $field='stockFilename,stockImgPath', 'stockImgId', $stockImgId, '', '', $limit=1 );
					if($resStockImage){
						$userImage=$resStockImage[0]->stockImgPath.'/'.$resStockImage[0]->stockFilename;
						
					}					
				}else{
					
					$profileImagePath  = 'media/'.$resUserName[0]->username.'/profile_image/';
					$userImage=$profileImagePath.$res[0]->profileImageName;
					
				}
			}
		}
		
		$CI->session->set_userdata('imagePath',$userImage);
		$userInfo['userFullName'] = $userFullName;
		$userInfo['userImage'] = $userImage;
		return $userInfo;
	 }
	//////////////// End ///////////////////////////
	
	if ( ! function_exists('dateFormatView')){           
	/* function for change date format for view
	 * Wriiten By Gurutva 
	*/
		function dateFormatView($time = '',$fmt = 'l, F d  Y')
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
		function showCaseUserDetails()
		{			
			$CI =& get_instance();
			
			$showcaseClass = $CI->router->class;
			
			if(strcmp($showcaseClass,'showcase')==0)
			{
				$showcaseUserId = $CI->uri->segment(4);
				
				if(isset($showcaseUserId) && $showcaseUserId>0)
					$userInfo = userProfileImage($showcaseUserId);
				else
					$userInfo = userProfileImage(isLoginUser());
			}
			else
			{
				$userInfo = userProfileImage(isLoginUser());
			}
			return $userInfo;
		}
	}
	
?>
