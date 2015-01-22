<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * CMS Settings Model
 *
 * Allows for an easy interface for site settings
 *
 * @author		Dan Horrigan <dan@dhorrigan.com>
 * @author		CDN Team
 * @package		CMS\Core\Modules\Settings\Models
 */

class Settings_m extends MY_Model {
	
	
	public function __construct()
	{
		parent::__construct();
		
		$this->admin_configuration = $this->db->dbprefix('admin_configuration');	
	}

	/**
	 * Get
	 *
	 * Gets a setting based on the $where param.  $where can be either a string
	 * containing a slug name or an array of WHERE options.
	 *
	 * @access	public
	 * @param	mixed	$where
	 * @return	object
	 */
	public function get($where)
	{
		if ( ! is_array($where))
		{
			$where = array('slug' => $where);
		}

		return $this->db
			->select('*, IF(`value` = "", `default`, `value`) as `value`', false)
			->where($where)
			->get($this->_table)
			->row();
	}

	/**
	 * Get Many By
	 *
	 * Gets all settings based on the $where param.  $where can be either a string
	 * containing a module name or an array of WHERE options.
	 *
	 * @access	public
	 * @param	mixed	$where
	 * @return	object
	 */
	public function get_many_by($where = array())
	{
		if ( ! is_array($where))
		{
			$where = array('module' => $where);
		}

		$this->db
			->select('*, IF(`value` = "", `default`, `value`) as `value`', false)
			->where($where)
			->order_by('`order`', 'DESC');
		
		return $this->get_all();
	}

	/**
	 * Update
	 *
	 * Updates a setting for a given $slug.
	 *
	 * @access	public
	 * @param	string	$slug
	 * @param	array	$params
	 * @return	bool
	 */
	public function update($slug = '', $params = array(), $skip_validation = false)
	{
		return $this->db->update($this->_table, $params, array('slug' => $slug));
	}

	/**
	 * Sections
	 *
	 * Gets all the sections (modules) from the settings table.
	 *
	 * @access	public
	 * @return	array
	 */
	public function sections()
	{
		$sections = $this->select('module')
			->distinct()
			->where('module != ""')
			->get_all();

		$result = array();

		foreach ($sections as $section)
		{
			$result[] = $section->module;
		}

		return $result;
	}
	
	/**
	 * Insert admin configuration settings
	 * @access	public
	 * @return	inser id
	 */

	function addConfiguration($input=array(),$config)
	{
		$userId=is_logged_in();
		$data= array(
			'user_id'				=> $userId,
			'email'					=> $input['email'],
			'paypal_id'				=> $input['paypal_id'],
		//	'referral_point'		=> $input['referral_point'],
			'referral_point_amt'	=> $input['referral_point_amt'],
			'currency'				=> $input['currency'],
			'minimum_referral_point' => $input['minimum_referral_point'],
			'created_on'			=> date('Y-m-d H:i:s')
		);
		if(!empty($config)){
				
			//update configuration settings
			$this->db->update($this->admin_configuration,$data);
			return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
		}
		//insert configuration setting 
		$this->db->insert($this->admin_configuration,$data);
		return $this->db->insert_id();
		
	}

}

/* End of file settings_m.php */
