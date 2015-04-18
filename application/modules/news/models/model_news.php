<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Model for CodeIgniter pressRelease files editor.
 *
 */
class model_news extends CI_Model {
	function __construct(){
		parent::__construct();
	}
	
	function PressReleaseNewsMaterial($newsId=0){
		 $this->db->select('*');
		 $this->db->from('PressReleaseNewsMaterial');
		 $this->db->join('MediaFile','MediaFile.fileId = PressReleaseNewsMaterial.fileId');
		 $this->db->where('pressReleaseNewsId', $newsId);
		 $query = $this->db->get();
		 return $query->result_array();
	}
	
	
	function get_press_news_list()
	{
		$tablePressReleaseNews = "TDS_PressReleaseNews";
		$type = "2"; 
		$sql = 'SELECT 
		date_trunc(\'month\',date),  
		COUNT(date) from   
		"'.$tablePressReleaseNews.'" where type='."$type".' group by date_trunc(\'month\',date) order by date_trunc(\'month\',date) DESC';
       
        //select date_trunc('month',date), count(*) from "TDS_PressReleaseNews" group by date_trunc('month',date) 
        $query = $this->db->query($sql); 
        
        $result['get_num_rows'] = $query->num_rows();
		$result['get_result'] = $query->result();
		return $result;
	}
	
	function press_news_list_month($date=0){
		$end_date = date("Y-m-30 00:00:00",strtotime($date));
		$type = "2";
		$this->db->select('*');
		$this->db->from('PressReleaseNews');
		$this->db->where('CAST("TDS_PressReleaseNews"."date" as DATE) >=',$date);	
		$this->db->where('CAST("TDS_PressReleaseNews"."date" as DATE) <=',$end_date);	
		$this->db->where('type', $type);
		$this->db->order_by('CAST("TDS_PressReleaseNews"."date" as DATE)','DESC');	
		$query = $this->db->get();
		$result['get_num_rows'] = $query->num_rows();
		$result['get_result'] = $query->result_array();
		return $result;
	}
	
	
}
