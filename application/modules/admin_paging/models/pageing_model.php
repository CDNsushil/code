<?php

/**
 * Users Model
 * Manage User record etc
 * @category	Users
 * @author	CDN Solution
 */
class Pageing_model extends CI_Model
{
		//Constructor
		function __construct(){
				parent::__construct();
		}

		/**
		* function for set paging config
		**/
		function get_config_paging()
		{
			$config['per_page'] = 10;
			$config['num_links'] = 2;
			$config['use_page_numbers'] = TRUE;
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="page"><a>';
			$config['cur_tag_close'] = '</a></li>';
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['last_link'] = '>>';
			$config['first_link'] = '<<';
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
			return $config;
		}
		
}
?>
