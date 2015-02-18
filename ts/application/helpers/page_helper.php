<?php
if(! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Function to get carrer detail from cc_carrier table
 */
if(!function_exists('get_page_profile_image'))
{
	function get_page_profile_image($page_id)
	{
        $read_db ='';
		$CI =& get_instance();
        $CI->read_db = $CI->load->database('read',TRUE);
		$CI->read_db->where('page_id',$page_id);
		$CI->read_db->select('profile_picture');
		$result = $CI->read_db->get('page');
		if(count($result->row()) > 0)
		{
			$profile_picture = $result->row()->profile_picture;
			if($profile_picture!="")
			return $profile_picture;
		}
	}
}


/***
	* Function for get Action Category id by page_id
	*Created : 8-6-2012
	*/	
if(!function_exists('get_action_catid'))
{
	function get_action_catid($page_id)
	{       
            $read_db ='';
			$CI =& get_instance();
            $CI->read_db = $CI->load->database('read',TRUE);
			$CI->read_db->select('action_category_id');
			$CI->read_db->where('page_id',$page_id);
		
			$result = $CI->read_db->get('page');
		
		  if($result->num_rows() > 0)
			{
				$cat_id =  $result->result();
				return $cat_id[0]->action_category_id;
			} else {
				return true;
			} 	
	}
}


/***
* Function get count of user product link
*Created : 11-6-2012
*/	
if(!function_exists('get_user_product_click_count'))
{
	function get_user_product_click_count($post_id)
	{
			$read_db ='';
			$CI =& get_instance();
            $CI->read_db = $CI->load->database('read',TRUE);
			$CI->read_db->select('id');
			$CI->read_db->where('post_id',$post_id);		
			$result = $CI->read_db->get('user_product_click');		
		  if($result->num_rows() > 0)
			{
				return $result->num_rows();				
			} else {
				return 0;
			} 	
	}
}

function get_page_profile($page_id)
{
    if($page_id){
       return BASEURL."page/get_page/".$page_id;
    }else{
         return FALSE; 
    }
}

function get_page_name($page_id)
{
    if($page_id){
        $read_db ='';
        $CI =& get_instance();
        $CI->read_db = $CI->load->database('read',TRUE);
        $CI->read_db->select('page_title,chpro_name,action_category_id');
        $CI->read_db->where('page_id',$page_id);		
        $result = $CI->read_db->get('page');
        if($result->num_rows()>0){
            $result_data = $result->row();
            if($result_data->action_category_id==6){
                $page_name = $result_data->chpro_name; 
            }else{
                $page_name = $result_data->page_title;
            }	
            return $page_name;
        }else{
            return FALSE;
        }
    }else{
         return FALSE; 
    }
}	

?>
