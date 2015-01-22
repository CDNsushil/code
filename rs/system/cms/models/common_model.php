<?php if (!defined('BASEPATH')) { exit('No direct script access allowed');}
/*
====================================================================================================
	* 
	* @description: This model is use to common functin use like insert, update, delete, select etc 
	* @auther: Rajendra Patidar
	* @email: rajendrapatidar@cdnsol.com
	* @create date: 02-Sept-2014
	* 
	* 
====================================================================================================*/

class Common_model extends CI_Model { 
	
	
	
	function __construct()
	{
		parent::__construct();
		
	}
	
	/*
	 * @description: This function is used getSum
	 * 
	 */ 
	 
	function getMax($table='',$field='',$where=''){
		$table='default_'.$table;
		$this->db->select_max($field);
		if(is_array($where) && count($where) > 0){
			$this->db->where($where);
		}
		$query = $this->db->get($table);
		$result=$query->result();
		return $result;
	}
	
	/*
	 * @description: This function is used getSum
	 * 
	 */ 
	
	function getSum($table='',$field='',$where=''){
		
		$result = false;
		if($table != '' && $field !=''){
			$table='default_'.$table;
			$this->db->select_sum($field);
			if(is_array($where) && count($where) > 0){
				$this->db->where($where);
			}
			$query = $this->db->get($table);
			$result=$query->result();
		}
		return $result;
	}
	
	/*
	 * @description: This function is used countResult
	 * 
	 */ 
	
	function countResult($table='',$field='',$value='', $limit=0){
		$table='default_'.$table;
		if(is_array($field)){
				$this->db->where($field);
		}
		elseif($field!='' && $value!=''){
			$this->db->where($field, $value);
		}
		$this->db->from($table);
		
		if($limit >0){
			$this->db->limit($limit);
		}
		
		 $res= $this->db->count_all_results();
		// echo $this->db->last_query();
		 return $res;
		 
	}
	
	/*
	 * @description: This function is used countResultFirstInsert
	 * 
	 */ 
	
	function countResultFirstInsert($table,$field){
		$table='default_'.$table;
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($field);
		$query = $this->db->get();
		if ($query->num_rows()) 
		{
			$result = $query->row();
		}else
		{
			$result = 0;
		}
		 return $result;
	}
	
	
	/*
	 * @description: This function is used getDataFromMixTabel
	 * 
	 */ 
	 
	function getDataFromMixTabel($table='', $field='*',  $where="", $orderBy='', $limit='',$retrunRow=false ){
		$table='default_'.$table;
		$sql = 'SELECT '.$field.' FROM '.$table.'  '.$where.' '.$orderBy.' '.$limit.' ' ;
		$query = $this->db->query($sql);
		//echo $this->db->last_query();
		if($retrunRow)
			return $query->num_rows();
		else 
			return $query->result();
	}
	
	function runQuery($sql=''){
		if($sql!=''){
			$result = $this->db->query($sql);
			//echo $this->db->last_query();
			return $result;
		}
		return false;
	}
	
	
	/*
	 * @description: This function is used getDataFromTabelWhereIn
	 * 
	 */ 
	
	function getDataFromTabelWhereIn($table='', $field='*',  $whereField='', $whereValue='', $orderBy='', $order='ASC', $whereNotIn=0){
		 $table='default_'.$table;
		 $this->db->select($field);
		 $this->db->from($table);
		 
		if($whereNotIn > 0){
			$this->db->where_not_in($whereField, $whereValue);
		}else{
			$this->db->where_in($whereField, $whereValue);
		}
		
		if(is_array($orderBy) && count($orderBy)){
			/* $orderBy treat as where condition if $orderBy is array  */
			$this->db->where($orderBy);
		}
		elseif(!empty($orderBy)){  
			$this->db->order_by($orderBy, $order);
		}
		
		$query = $this->db->get();
		
		$result = $query->result_array();
		if(!empty($result)){
			return 	$result;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	 * @description: This function is used getDataFromTabelWhereWhereIn
	 * 
	 */
	
	function getDataFromTabelWhereWhereIn($table='', $field='*',  $where='',  $whereinField='', $whereinValue='', $orderBy='', $whereNotIn=0){
		 $table='default_'.$table;
		 $this->db->select($field);
		 $this->db->from($table);
		 
		if(is_array($where)){
			$this->db->where($where);
		}
		
		if($whereNotIn > 0){
			$this->db->where_not_in($whereinField, $whereinValue);
		}else{
			$this->db->where_in($whereinField, $whereinValue);
		}
		
		if(!empty($orderBy)){  
			$this->db->order_by($orderBy);
		}
		
		$query = $this->db->get();
		//echo $this->db->last_query();
		$result = $query->result();
		print_r($result ); die;
		if(!empty($result)){
			return 	$result;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	 * @description: This function is used getDataFromTabel
	 * @return :array 
	 */
	
	function getDataFromTabel($table='', $field='*',  $whereField='', $whereValue='', $orderBy='', $order='DESC', $limit=0, $offset=0, $resultInArray=false  ){
		
		 $table='default_'.$table;
		// $this->db->order_by('id', 'desc');
		 $this->db->select($field);
		 $this->db->from($table);
		 
		if(is_array($whereField)){
			$this->db->where($whereField);
		}elseif(!empty($whereField) && $whereValue != ''){
			$this->db->where($whereField, $whereValue);
		}
	
		if(!empty($orderBy)){  
		
			$this->db->order_by($orderBy, $order);
		}
		if($limit > 0){
			$this->db->limit($limit,$offset);
		}
		$query = $this->db->get();
	
		if($resultInArray){
			$result = $query->result_array();
		}else{
			$result = $query->result();
		}
		//echo $this->db->last_query();
		//die;
		if(!empty($result)){
			return 	$result;
		}
		else{
			return FALSE;
		}
	}
	
	
	/*
	 * @description: This function is used getLikeDataFromTabel
	 * 
	 */
	
	function getLikeDataFromTabel($table='', $field='*',  $like='', $where='', $orderBy='', $order='ASC', $limit=0 ){
		
		 $table='default_'.$table;
		 $this->db->select($field);
		 $this->db->from($table);
		 
		if(is_array($like)){
			$this->db->like($like);
		}elseif(is_array($where)){
			$this->db->where($where);
		}
		if(!empty($orderBy)){  
			$this->db->order_by($orderBy, $order);
		}
		if($limit >0){
			$this->db->limit($limit);
		}
		$query = $this->db->get();
		
		$result = $query->result();
		if(!empty($result)){
			return 	$result;
		}
		else{
			return FALSE;
		}
	}
	
	/*
	 * @description: This function is used addDataIntoTabel
	 * 
	 */
	
	function addDataIntoTabel($table='', $data=array()){
			
		if($table=='' || !count($data)){
			return false;
		}
		else{ 
			$table='default_'.$table;
			$inserted = $this->db->insert($table , $data);
			//echo $this->db->last_query();
			if($inserted){
				$ID = $this->db->insert_id();
				//echo "done with insert_id ". $ID."pre";
				//$ID =0;
				if(!($ID > 0)){
					$sql='SELECT LASTVAL() as ins_id';
					$res = $this->db->query($sql);
					$res =$res->result_array();
					$ID=$res[0]['ins_id'];
				}
			}
			$ID=($ID>0)?$ID:0;
			return $ID;
		}
	}
	
	/*
	 * @description: This function is used updateDataFromTabel
	 * 
	 */
	 
	function updateDataFromTabel($table='', $data=array(), $field='', $ID=0){
		
		if(empty($table) || !count($data)){
			return false;
		}
		else{
			$table='default_'.$table;
			if(is_array($field)){
				
				$this->db->where($field);
			}else{
				$this->db->where($field , $ID);
				
			}
			return $this->db->update($table , $data);
		}
	}
	
	
	
	
	
	/*
	 * @description: This function is used updateDataFromTabelWhereIn
	 * 
	 */
	
	function updateDataFromTabelWhereIn($table='', $data=array(), $where=array(), $whereInField='', $whereIn=array(), $whereNotIn=false){
		
		if(empty($table) || !count($data)){
			return false;
		}
		else{
			$table='default_'.$table;
			if(is_array($where) && count($where) > 0){
				
				$this->db->where($where);
			}
			
			if(is_array($whereIn) && count($whereIn) > 0 && $whereInField != ''){
				if($whereNotIn){
					$this->db->where_not_in($whereInField,$whereIn);
				}else{
					$this->db->where_in($whereInField,$whereIn);
				}
			}
			return $this->db->update($table , $data);
		}
	}
	
	
	
	/*
	 * @description: This function is used insertBatch
	 * 
	 */
	 
	 
	function insertBatch($table='', $data=array()){
		if($table=='' || !count($data)>0){
			return false;
		}
		
		else{ 
			$table='default_'.$table;
			$this->db->insert_batch($table, $data); 
			return $this->db->insert_id();
		}
	}
	
	
	/*
	 * @description: This function is used deleteRowFromTabel
	 * 
	 */
	 
	function deleteRowFromTabel($table='', $field='', $ID=0, $limit=0){
		$Flag=false;
		if($table!='' && $field!=''){
			$table='default_'.$table;
			if(is_array($ID) && count($ID)){
				$this->db->where_in($field ,$ID);
			}elseif(is_array($field) && count($field) > 0){
				$this->db->where($field);
			}else{
				$this->db->where($field , $ID);
			}
			if($limit >0){
				$this->db->limit($limit);
			}
			if($this->db->delete($table)){
				$Flag=true;
			}
		}
		//echo $this->db->last_query();
		return $Flag;
	}
	
	/*
	 * @description: This function is used for multiple delete
	 * 
	 */
	 
	 
	function deletelWhereWhereIn($table='', $where='',  $whereinField='', $whereinValue='', $whereNotIn=0){
		$table='default_'.$table;
		if(is_array($where)){
			$this->db->where($where);
		}
		
		if($whereNotIn > 0){
			$this->db->where_not_in($whereinField, $whereNotIn);
		}else{
			$this->db->where_in($whereinField, $whereinValue);
		}
		
		if($this->db->delete($table)){
				return true;
		}else{
			return false;
		}
	}
	
	/*
	 * @description: This function is used row
	 * 
	 */
	 
	 
	function deleteDataFromTabel($table='', $where=''){
		$table='default_'.$table;
		$SQl='DELETE FROM "'.$table.'" '.$where;
		$result = $this->db->query($SQl);
	}
	
	/*
	 * @description: This function is used deleteRow
	 * 
	 */

	function deleteRow($table,$where)
	{
		$table='default_'.$table;
		$this->db->delete($table, $where);
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
	
	/*
	 * @description: This function is used executeQuery
	 * 
	 */
	 
	function executeQuery($qureyForexection){
		$query = $this->db->query($qureyForexection);
		$result = $query->result_array();
		if(!empty($result)){
			return $result[0];	
		}else{
			return FALSE;
		}
	}
	
	/**
	 * @Description : Generate random number.
	 * @Return		: RanNumber string
	 * *@Author:  Rajendra patidar
	 */ 
    
    function generateRandomString($length = 8) {
		$characters = '0123456789@!ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}
	
	/**
	 * @Desc  :  add pagination in table 
	 * @Author:  Rajendra patidar
	 * @param :  total_rows ,uri
	 * @Return:  Message
	 */
	function getPagination($total_rows,$url,$perPage='8')
	{

		$this->load->library("pagination");
		$config = array();
		$config["base_url"] = $url;
		$config["total_rows"] = $total_rows;
		$config["per_page"] = $perPage;
		$config["uri_segment"] = 3;
		$this->pagination->initialize($config);
		$choice = $config["total_rows"] / $config["per_page"];
		$config["num_links"] = round($choice);
		$config['use_page_numbers']  = TRUE;

		return $config;
	}
	
	/**
	 * Desc  :Resize image
	 * Param :Image Details
	 * return:True/False
	 * */
	public function resizeImage($imageData=array())
	{
		$imageData=array('image_path'=>'captcha/1409899669.3228.jpg','width'=>'338','height'=>'115');
		print_r($imageData);
		//$image=$this->resizeImage($imageData);
	
		if(!empty($imageData))
		{
				$this->load->library('image_lib');
				$config['image_library'] = 'gd2';
				$config['source_image'] = $imageData['image_path'];
				$config['create_thumb'] = TRUE;
				$config['maintain_ratio'] = TRUE;
				$config['width']     = $imageData['width'];
				$config['height']   = $imageData['height'];
			
				$this->image_lib->clear();
				$this->image_lib->initialize($config);
				//echo $this->image_lib->display_errors(); die;
				echo  $this->image_lib->resize(); die;
		}
		return false;
	}

	function affiLogin_form()
	{	
		echo  $this->load->view('direct_deposit');
		echo  $this->load->view('affiliate_login');
		echo  $this->load->view('term_condi');
		
	}
	/**
	 * Desc  :Get contact email template
	 * Param :data array
	 * return:True/False
	 * */
	function getContactEmailTemplate($param)
	{
		$data['message']=$param['message'];
		$data['email_id']=$param['email_id'];
		$data['name']=$param['name'];
		$data['url']=base_url();
		return  $this->load->view('contact_email',$data,true);
	}
		/**
	 * @Descr  :array of currency
	 * @param  :void
	 * @return :array
	 */	
	function getCorrencies()
	{
		return array('USD'=>'USD','AUD'=>'AUD','BRL'=>'BRL','GBP'=>'GBP','CAD'=>'CAD','CZK'=>'CZK',
			'DKK'=>'DKK','EUR'=>'EUR','HKD'=>'HKD','HUF'=>'HUF','ILS'=>'ILS','JPY'=>'JPY','MXN'=>'MXN','TWD'=>'TWD',
			'NZD'=>'NZD','NOK'=>'NOK','PHP'=>'PHP','PLN'=>'PLN','RUB'=>'RUB','SGD'=>'SGD','SEK'=>'SEK','CHF'=>'CHF','THB'=>'THB',
		);
	}
	
		/*
	 * @description: This function is used to get day listing between two dates
	 * @param1: $startDate (date)
	 * @param2: $endDate  (date)
	 * @return $aryRange
	 * @author:rajenda patidar
	 **/ 
	
	function datedaydifference($startDate,$endDate)
	{	
		$aryRange=array();

		$iDateFrom=mktime(1,0,0,substr($startDate,5,2), substr($startDate,8,2),substr($startDate,0,4));
		$iDateTo=mktime(1,0,0,substr($endDate,5,2),  substr($endDate,8,2),substr($endDate,0,4));

		if ($iDateTo>=$iDateFrom)
		{	
			$day=1;
			//array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
			$aryRange[$day]['day'] = $day; // first entry
			$aryRange[$day]['date'] = date('Y-m-d',$iDateFrom); // first entry
			while ($iDateFrom<$iDateTo)
			{ 
				$day++;
				$iDateFrom+=86400; // add 24 hours
				$aryRange[$day]['day'] = $day;
				$aryRange[$day]['date'] = date('Y-m-d',$iDateFrom);
				
			}
		}
		
		return $aryRange;
	}

	/*
	 * @description: get admin email fron configuration tabel
	 * @return email
	 * @param:void
	 **/ 
	function getAdminEmail()
	{
		$email=$this->getDataFromTabel('admin_configuration','email');
		if(!empty($email)){
			$emailAdmin=$email[0];
			return $emailAdmin->email;
		}
		return false;
	}
	/*
	 * @description: get admin paypal Id
	 * @return paypalId
	 * @param:void
	 **/ 
	function getAdminPaypalId()
	{
		$paypalId=$this->getDataFromTabel('admin_configuration','paypal_id');
		if(!empty($paypalId)){
			return $paypalId[0]->paypal_id;
		}
		return false;
	}
	

	function getSiteLogo()
	{
        $this->db->select('value');
        $this->db->from('default_settings');
        $this->db->where(array('slug'=>'site_logo'));
        $this->db->limit(1);
        $query = $this->db->get();
        if($query){
            return $query->result_array();
        }
        return false;
	}

	/*
	* @Function : To calculate referral amt 
	* @Params   : BannerId
	* @Output   : Referral Commission array
	**/
	function getReferralPointCommisssion($bannerId)
	{
		//set default currency
		$commission=array('commission'=>0,'currency'=>'USD');
		$this->db->select('dmb.referral_point');
		$this->db->from('default_merchant_banner as dmb');
		$this->db->where('dmb.banner_id',$bannerId);
		$query = $this->db->get();
		$products=$query->row();
		
		$adminConfig=$this->getDataFromMixTabel('admin_configuration','*');
		if(!empty($products) && !empty($adminConfig)){
			
			$commission['commission']=$adminConfig[0]->referral_point_amt*$products->referral_point;
			$commission['currency']=$adminConfig[0]->currency;
		}
		return 	$commission;
	}
    
	function getPageContents($slug='')
	{
		$result = false;
        
        if(!empty($slug)){
            $this->db->select('c.id, c.body');
            $this->db->from('pages as p');
            $this->db->join('def_page_fields as c',"c.id = p.id");
            $this->db->where('p.slug',$slug);
            $this->db->limit(1);
            $query = $this->db->get();
            if($query){
                return $query->result();
            }
            
          }
		return 	$result;
	}
	function savePageContents($data)
	{
		$result = false;
        if(!empty($data) && is_array($data)){
            $this->db->where('id',$data['id']);
            return $this->db->update('def_page_fields' , array('body'=>$data['description']));
        }
		return 	$result;
	}
	
/* END  */
	
}
