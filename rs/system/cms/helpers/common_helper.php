<?php
/** This helper  user only for frotend for memberhsip modules 
 * * @author:  Rajendra patidar
 * 	 @Descrip: To create common function for frontend
 * **/
	
	/*
	 * @descri: get user group
	 * @param: 	void
	 * @return 	logged in user group id
	 * 
	 **/ 
	if(!function_exists('userGroup'))
	{
		function userGroup()
		{	$CI =& get_instance();
			
			if(is_logged_in()){
				$group=$CI->current_user;
				if(!empty($group)){
					return $group->group_id;;
				}
				return false;
			}
			return false;
		}
	}
	
	// ------------------------------------------------------------------------ 	
	/*
	 * @descri: get user group
	 * @param: 	void
	 * @return 	logged in user group id
	 * 
	 **/ 
	if(!function_exists('affiLogin_form'))
	{
		function affiLogin_form()
		{	$CI =& get_instance();
			 $CI->common_model->affiLogin_form();
		}
	}
	
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
	
	// ------------------------------------------------------------------------ 	
	/*
	 * @descri: check email is valid
	 * @param: 	void
	 * @return 	true/false
	 * 
	 **/ 
	if ( ! function_exists('isEmailValid'))
	{
		function isEmailValid($email)
		{
			$CI =& get_instance();
			$CI->load->helper('email');
			return valid_email($email);
		}
	}
	
	// ------------------------------------------------------------------------ 	
	/*
	 * @descri: get admin email
	 * @param: 	void
	 * @return 	admin email
	 * 
	 **/ 
	
	if ( ! function_exists('getAdminEmail'))
	{
		function getAdminEmail()
		{
			$CI =& get_instance();
			$adminEmail=$CI->common_model->getAdminEmail();
			return $adminEmail;
		}
	}
	
	/*
	 * @descri: get admin email
	 * @param: 	void
	 * @return 	admin email
	 * 
	 **/ 
	
	if ( ! function_exists('getAdminPaypalId'))
	{
		function getAdminPaypalId()
		{
			$CI =& get_instance();
			$adminPaypalId=$CI->common_model->getAdminPaypalId();
			return $adminPaypalId;
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
			
			$str = ''; //defined string message containg variable
			$CI =&get_instance(); // create ci instance object
			$k=''; // count containg varible
			$global_messages = (array)$CI->session->userdata('global_messages');
			
			if($global_messages && is_array($global_messages) &&count($global_messages) > 0) {
				foreach($global_messages as $k => $v) {
				
					foreach((array)$v as $w) {
					
						$str.=$w;
					}
				}
			} 
			
			if($global_messages && !empty($global_messages)){
				$CI->session->unset_userdata('global_messages');
			}
			
			
			return array('msg'=>$str,'type'=>$k);
		}
		
	}
	
	/**
	 * Get Global Messages for all msg single and multiple
	 * Written  Rajenra Patidar 
	 * @access	public
	 * @param	void
	 * @return	msg & msg status array
	 */
	//error_reporting(0);
	if ( ! function_exists('getGlobalMessage'))
	{
		function getGlobalMessage()
		{
			$showMSG='';
			$showType='';
			$CI =&get_instance(); 
			$msg=get_global_messages();
			 if(!empty($msg['msg']) && $msg['type']=="successMsg"){
				$showMSG=$msg['msg'];
				$showType='success';
			 }
			 elseif(!empty($msg['msg']) && $msg['type']=="errorMsg"){ 
				$showMSG=$msg['msg'];
				$showType='error';
			 }
			if($CI->session->flashdata('error')){
				$showMSG=$CI->session->flashdata('error');
				$showType='error';
			}
			if($CI->session->flashdata('success')){
				$showMSG=$CI->session->flashdata('success');
				$showType='success';
			}
			$allMSG= trim(strip_tags($showMSG)); 
			$msgArrays=explode(".",$allMSG);
			$showMSG='';
			if($allMSG!='' && !empty($msgArrays)){
				foreach($msgArrays as $value){
					if($value!=''){
						$showMSG.=trim($value).'.<br>'; 
					}
				}
			}
			
			$msgArray=array('msg'=>$showMSG,'type'=>$showType);
			return $msgArray;
		}
	}
	/**
	 * @Desc  :  add sidebar for merchant & affiliate
	 * @Author:  Rajendra patidar
	 * @param :  void
	 * @Return:  Message
	 */
	if(!function_exists('getSidebar'))
	{
		function getSidebar()
		{	
			
			$user=is_logged_in();
			$CI =& get_instance();
			
			$module=$CI->uri->segment(2); 
			if($user!='' && $module!=''){
				$data['module']=$module;
				$group=$CI->current_user->group_id;	
			
				if($group==3){
					$sidebar=$CI->load->view('merchant_sidebar',$data,true);
					return $sidebar;
				}
				if($group==2){
					$sidebar=$CI->load->view('affliate_sidebar',$data,true);
					return $sidebar;
				}
			}
			return false;
		}
	}
	/**
	 * @Desc  :  get rememberCode for affiliate
	 * @Author:  Rajendra patidar
	 * @param :  void
	 * @Return:  Login Cookie data
	 */
	 if(!function_exists('getRememberAffiliate'))
	 {
		function getRememberAffiliate()
		{
			//check remember me affiliate
			$CI =& get_instance();
			$data=array();
			$rememberCode=get_cookie('ruser');
			$rememberArray=explode('_',$rememberCode);
			
			if(!empty($rememberArray[0])){
				$data['login_email']=decode($rememberArray[0]);
				$data['login_pass']=decode($rememberArray[1]);
			}
			//check for affiliate banner url
			$banner= $CI->uri->segment(2); 
			if($banner=='banner_id'){
				$data['banner_id']=$CI->uri->segment(3); 
			}
			
			return $data;
		}
	}
	
	/**
	 * @Desc  :  to prevent browser back button
	 * @param :  void
	 * @Return:  voif
	 */
	 if(!function_exists('preventBrowserCache'))
	 {
		function preventBrowserCache()
		{
			$CI =& get_instance();
			$CI->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
			$CI->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
			$CI->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
			$CI->output->set_header('Pragma: no-cache');
		}
	}
	
	/**
	 * @Desc  :  check valid url
	 * @param :  url
	 * @Return:  true /false
	 */
	 if(!function_exists('validUrl'))
	 {
		function validUrl($url)
		{
			
			if($url.substr(0,4) != 'http'){
				$url = 'http://'.$url;
			 }
			 $pattern = "/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i";
			if (!preg_match($pattern, $url))
			{
				return false;
			}
			 return true;
			
		}
	}
	/*
	 * @description: check user memberhsip expiry date
	 * @return :redirect or return true
	 * @param:void
	 **/ 
	if(!function_exists('checkExpiryMemberhipDate'))
	{
		function checkExpiryMemberhipDate()
		{
			
			$CI =& get_instance();
			$userGroup=userGroup();
			if($userGroup==3 && $CI->method!='setPaypalPayment')
			{
				if($CI->method!='getPaypalResponse' && $CI->method!='getCancelPaypalResponse')
				{
					$expiryDate=strtotime($CI->current_user->membership_expiry_date);
					$todayDate=strtotime(date('Y-m-d'));
					if($todayDate>$expiryDate){
						set_global_messages(lang('global:membership_expired_msg'),'error');
						if($CI->method!='membership'){
							redirect('users/membership');
						}
					}
				}
					return true;
			}
			return true;
		}
	}
	
	/*
	 * @description: get geroup name
	 * @return group name
	 * @param:void
	 **/ 
	if(!function_exists('getGroupName'))
	{
		function getGroupName()
		{
			$groupId=userGroup();
			$moduleName=module_name();
		
			if($moduleName=='Users'){
				if($groupId==1){
					$moduleName="Admin";
				}
				if($groupId==2){
					$moduleName="Affiliate";
				}
				if($groupId==3){
					$moduleName="Merchant";
				}
			}
			
			if($moduleName=='Services'){
				$moduleName='Buy Now';
			}
			return $moduleName;
		}
	}
	
	if(!function_exists('create_breadcrumb'))
	{
		function create_breadcrumb(){
		 $ci = &get_instance();
		 $i=1;
		 $uri = $ci->uri->segment($i); 
		 $uri=str_replace('-',' ',$uri);
		 
		 $link = '<ol class="breadcrumb">';
		 
		if($uri!=''){
			$link.='<li> <a href="'.site_url('').'" >';
			$link.=ucfirst('home').'</a></li> ';
		}
		
		if($uri!='register'){	
			 while($uri != ''){
				$prep_link = '';
			  for($j=1; $j<=$i;$j++){
				
				$checkId= decode($ci->uri->segment($j+1));
				if($checkId){
					$createId=$ci->uri->segment($j+1);
					checkEncryptId($checkId,$createId,$prep_link);
				}
				$prep_link .= $ci->uri->segment($j).'/';
			  }
			 
			 if($i==3){
				$link.='<li> <a >';
				$link.=ucfirst($ci->uri->segment($i)).'</a></li> ';
				 
			 }else if($i<4){
				 
					if($ci->uri->segment($i+1) == ''){
						$link.='<li><a ><b>';
						$ilink=str_replace('-',' ',$ci->uri->segment($i));
						$link.=ucfirst($ilink).'</b></a></li> ';
					}else{
						if($uri!='users'){
							$link.='<li> <a href="'.site_url($prep_link).'">';
							$link.=ucfirst($ci->uri->segment($i)).'</a></li> ';
						}
					}
				}
			 
			  $i++;
			  $uri = $ci->uri->segment($i);
				
			}
		}else{
				$id=$ci->uri->segment($i+1);
				$encodeId=$ci->uri->segment($i+2);
				$mem_id=decode($encodeId); 
				if($mem_id){
					checkEncryptId($mem_id,$encodeId,$prep_link='register');
				}
				
				$module="merchant";
				if($id=='banner_id' || $encodeId==''){
					$module="affiliate";
				}
				if($encodeId!='' && $mem_id=='')
				{
					redirect('register');
				}
				
				$link.='<li> <a href="'.site_url($module).'">';
				$link.=ucfirst($module).'</a></li> ';
				
				$link.='<li> <a >';
				$link.='Sign-Up</a></li> ';
				$i+=1;
		}
		  
			if($i==1){
				$link.='<li> <a >';
				$link.=ucfirst('home').'</a></li> ';
			}
			//code for forgot password url 
			if($ci->uri->segment(2)=='forgot-password')
			{
				$link='<ol class="breadcrumb"><li> <a href="'.site_url('').'">';
				$link.=ucfirst('home').'</a></li> ';
				$link.='<li> <a >';
				$link.='Forgot Password</a></li> ';	
			}
			$link .= '</ol>';
			
			return $link;
		}
	}
	
	/**
	 * check encypt id
	 *return :true/false 
	 */
	
	 if(!function_exists('checkEncryptId'))
	{   
        function checkEncryptId($id,$createId='',$prep_link='',$msg='')
        {
				$ci = &get_instance();
				$newId=encode($id);
				if($newId!=$createId){
					$ci->session->set_flashdata('error', $msg);
					redirect($prep_link);
					return false;
				}
				return true;
		}
	}
		
    if(!function_exists('getSiteLogo'))
	{   
        function getSiteLogo($w = 200, $h = 70)
        {
            $CI =& get_instance();
            
           $website_logo = $CI->session->userdata('website_logo');
           if(!$website_logo || empty($website_logo) || !is_file('uploads/logo/'.$website_logo)){
               $result = $CI->common_model->getSiteLogo();
               if($result && isset($result[0]['value']) && !empty($result[0]['value']) && is_file('uploads/logo/'.$result[0]['value'])){
                    $website_logo = $result[0]['value'];
                    $CI->session->set_userdata('website_logo', $website_logo);
               }else{
                   $website_logo = false;
               }
            }
            if($website_logo){
                $img = 'uploads/logo/'.$website_logo;
                $w = ($w > 1)?$w : 200;
                $h = ($h > 1)?$h : 70;
                //resize_image($img, $w, $h);
                list($width, $height, $type, $attr) = getimagesize($img);
                $r = $width / $height;
                if ($w/$h > $r) {
                    $newwidth = $h*$r;
                    $newheight = $h;
                } else {
                    $newheight = $w/$r;
                    $newwidth = $w;
                }
                
                $img=base_url($img);
                return '<img width="'.$newwidth.'" height="'.$newheight.'" src="'.$img.'" alt="Logo">';
            }
            return '<h1>LOGO</h1>';
        }
	}
	
     if(!function_exists('resize_image')){
		   
        function resize_image($file, $w, $h) {
            list($width, $height, $type, $attr) = getimagesize($file);
            $r = $width / $height;
            if ($w/$h > $r) {
                $newwidth = $h*$r;
                $newheight = $h;
            } else {
                $newheight = $w/$r;
                $newwidth = $w;
            }
            switch ($type) {
                case 1 :
                    $src = imageCreateFromGif($file);
                break;
                case 2 :
                    $src = imageCreateFromJpeg($file);
                break;
                case 3 :
                    $src = imageCreateFromPng($file);
                break;
                case 6 :
                    $src = imageCreateFromBmp($file);
                break;
            } 
            $dst = imagecreatetruecolor($newwidth, $newheight);
            imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);


            $fileDetails = pathinfo($file);
            $extension = $fileDetails['extension'];

            $prefix = '';
            switch ($extension) {
                    case "jpg":
                    case "jpeg":
                        imagejpeg($dst, $file);
                        break;
                    case "gif":
                        imagegif($dst, $file);
                        break;
                    case "png":
                       imagepng($dst, $file);
                        break;
                    default:
                        exit(1);
                    break;
            }
            imagedestroy($dst);
        }
	}
   
   if(!function_exists('getPageContents')){   
        function getPageContents($slug=''){
            $CI =& get_instance();
            $result = false;
            if(!empty($slug)){
                $data =  $CI->common_model->getPageContents($slug);
                if($data && isset($data[0])){
                    $result = $data[0];
                }
            }
            return 	$result;
        }
    }
    
    
    



