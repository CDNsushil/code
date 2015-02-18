<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Model for CodeIgniter frontend language files editor.
 *
 */

class Model_language extends CI_Model {

	/**
	 * Get list of languages based on /application_folder/languge/
	 * and number of php files in it
	 *
	 * @return	array
	 */
	 
	 private $read_db;   
	function __construct()
	{
		parent::__construct();
        $this->read_db = $this->load->database('read', TRUE);
	}
	
	function get_languages(){
		$dir = APPPATH."language/";
		$dh  = opendir($dir);
		$i=0;
		while (false !== ($filename = readdir($dh))) {
			if($filename!=='.' && $filename!=='..' && is_dir($dir.$filename)){
				$files[$i]['dir'] = $filename;
				$files[$i]['count']=$this->get_count_lfiles($filename);
				$i++;
			}
		}
		return (!empty($files))?$files:FALSE;
	}

	/**
	 * Get list of files from language directory
	 *
	 * @param string
	 * @return	array
	 */
	function get_list_lfiles($dir){
		if(!is_dir(APPPATH."language/$dir/")){
			return FALSE;
		}
		$dir = APPPATH."language/$dir/";
		$dh  = opendir($dir);
		while (false !== ($filename = readdir($dh))) {
			if($filename!=='.' && $filename!=='..' && !is_dir($dir.$filename) && pathinfo($filename, PATHINFO_EXTENSION)=='php' && substr($filename,0,7)!='backup_'){
				$files[] = $filename;
			}
		}
		return (!empty($files))?$files:FALSE;
	}

	/**
	 * Get number of files from language directory
	 *
	 * @param string
	 * @return	int
	 */
	function get_count_lfiles($dir){
		if(!is_dir(APPPATH."language/$dir/")){
			return FALSE;
		}
		$dir = APPPATH."language/$dir/";
		$dh  = opendir($dir);
		$i=0;
		while (false !== ($filename = readdir($dh))) {
			if($filename!=='.' && $filename!=='..' && !is_dir($dir.$filename) && pathinfo($filename, PATHINFO_EXTENSION)=='php' && substr($filename,0,7)!='backup_'){
				$i++;
			}
		}
		return (int)$i;
	}

	/**
	 * Get list of languages where file exist
	 *
	 * @param string
	 * @return	array
	 */
	function file_in_language($file){
		$lang = $this->get_languages();
		if($lang!==FALSE){
			foreach($lang as $l){
				$names = get_filenames(APPPATH."language/{$l['dir']}/");
				if(in_array($file,$names)){
					$in_lang[]=$l['dir'];
				}
			}
			return $in_lang;
		}
		return FALSE;
	}

	/**
	 * Get list of keys for file from database
	 *
	 * @param string
	 * @return	array
	 */
	function get_keys_from_db($file){
		$this->read_db->select('key as keys');
		$r = $this->read_db->get_where('language_keys', array('filename' => $file));
		if($r->num_rows()){
			$result=$r->result();
			foreach($result as $row){
				$tab[]=$row->keys;
			}
		}
		return (!empty($row)) ? $tab : FALSE;
   }

	/**
	 * Get list of keys for file from database
	 *
	 * @param string
	 * @return	array
	 */
	function get_comments_from_db($file){
		$this->read_db->select('key as keys,comment');
		$r = $this->read_db->get_where('language_keys', array('filename' => $file));
		if($r->num_rows()){
			$result=$r->result();
			foreach($result as $row){
				$tab[$row->keys]=$row->comment;
			}
		}
		return (!empty($row)) ? $tab : FALSE;
	}

	/**
	 * Update all keys in database, by removing previous and adding new.
	 *
	 * @param array
	 * @param string
	 * @return	bool
	 */
	function update_all_keys($keys,$file){
		$this->delete_all_keys($file);
		return $this->add_keys($keys,$file);
	}

	/**
	 * Add keys to database
	 *
	 * @param array
	 * @param string
	 * @return	bool
	 */
	function add_keys($keys,$file){
		if(!is_array($keys)){
			return FALSE;
		}
		foreach ($keys as $k){
			$data[] = array(
				'key'=>$k,
				'filename'=>$file
			);
		}
		$this->read_db->insert_batch('language_keys',$data);
		return ($this->read_db->affected_rows()) ? TRUE : FALSE;
	}


	/**
	 * Delete keys from database if file does not exists in any language
	 *
	 * @param string
	 * @return	bool
	 */
	function delete_keys($file){
		$lang = $this->get_languages();
		if($lang!==FALSE){
			foreach($lang as $l){
				$names = get_filenames(APPPATH."language/{$l['dir']}/");
				if(in_array($file,$names)){
					return FALSE;
				}
			}
			if($this->delete_all_keys($file)){
				return TRUE;
			}else{
				return FALSE;
			}
		}
	}

	/**
	 * Delete keys from database
	 *
	 * @param string
	 * @return	bool
	 */
	function delete_all_keys($file){
		$this->read_db->delete('language_keys',array('filename'=>$file));
		return ($this->read_db->affected_rows()) ? TRUE : FALSE;
	}

	function delete_one_key($key,$file){
		$this->read_db->delete('language_keys',array('filename'=>$file,'key'=>$key));
		return ($this->read_db->affected_rows()) ? TRUE : FALSE;
	}

	function add_comments($com,$file){
		if(!is_array($com)){
			return FALSE;
		}
		$this->read_db->trans_start();
		foreach ($com as $k=>$c){
			$this->read_db->where('key', $k);
			$this->read_db->where('filename', $file);
			$this->read_db->update('language_keys',array('comment'=>$c));
		}
		$this->read_db->trans_complete();
		return ($this->read_db->trans_status()) ? TRUE : FALSE;
	}
	function add_new_db_language($language){
		$this->read_db->insert('language', array("language"=>$language));
	}
	function delete_db_language($language){
		$this->read_db->delete('language', array('language'=>$language));
	}

}
/* End of file model_language.php */
