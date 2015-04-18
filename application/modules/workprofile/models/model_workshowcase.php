<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	 Description:
	 * The model_workshowcase class is meant to handle the processing of the WorkShowcase Of Work Profile section
	 * It include functionality to fetch/add/edit Videos,Images,Written Material and Audios 
	 Author Name: Gurutva Singh
	 Date Created: 7 Februray 2012
	 Date Modified: 8 Februray 2012 
	
*/

Class model_workshowcase extends CI_Model {
	
	
	protected $tableName = 'ProfileMedia';//Table name to fetch records
	protected $fieldType = 'mediaType';//fieldType name to fetch records according to this field name's value match from Table
	
	// Constructor
	function __construct()
	{
		parent::__construct();
	}
	

/**
	* showWorkShowcaseVideos method fetches the records form Profile Media of Type Videos
	* giving the values in the options array priority.
	*
	* @param int $workProfileId
	* @return array
*/
	function showWorkShowcaseMedia($workProfileId=0,$fieldTypeValue)
	{
		//$fieldTypeValue = 'Videos';
		//$fieldTypeValue = 2;
		/*$this->db->where($this->fieldType,$fieldTypeValue);
		$this->db->where('workProfileId',$workProfileId);*/
		
		/*$this->db->from($table);
		$this->db->join('MediaFile','MediaFile.fileId = '.$tableName.'.fileId');
		$this->db->where($whereField,$whereValue);*/
		
		$whereinfield = $this->tableName.'.'.$this->fieldType;
		$this->db->from($this->tableName);
		$this->db->join('MediaFile','MediaFile.fileId = '.$this->tableName.'.fileId');
		$this->db->where($this->tableName.'.workProfileId',$workProfileId);
		$this->db->where_in($whereinfield,"$fieldTypeValue");
		$dataShowcaseMedia = $this->db->get();
		//echo 'Last Query'.$this->db->last_query();
		//die;
		if(count($dataShowcaseMedia)>0)
			$dataShowcaseMedia = $dataShowcaseMedia->result_array();
		else
			$dataShowcaseMedia = 0;
			
			 //print_r($dataShowcaseMedia);
		return $dataShowcaseMedia;		
	}
	
	function videosRecordSet($mediaId)
	{
		if($mediaId > 0){
			$table = 'ProfileMedia';
			$field = 'mediaId';
			$this->db->where($field,$mediaId);
			$dataVideos = $this->db->get($table);
		//	echo "<pre>"; print_r($dataVideos);
			return $dataVideos->row();
		}
	}
/**
 *  Commented by vikas on 23 aug to remove multiple functions
	* showWorkShowcaseImages method fetches the records form Profile Media of Type Images
	* giving the values in the options array priority. 
	*
	* @param int $workProfileId
	* @return array
*/
	/*function showWorkShowcaseImages($workProfileId=0)
	{	
		//$fieldTypeValue = 'Images';
		$fieldTypeValue = 1;
		$this->db->where($this->fieldType,$fieldTypeValue);
		$this->db->where('workProfileId',$workProfileId);
		$dataShowcaseImages = $this->db->get($this->tableName);	
					
		if(count($dataShowcaseImages)>0)
			$dataShowcaseImages = $dataShowcaseImages->result_array();
		else
			$dataShowcaseImages = 0;
			
		return $dataShowcaseImages;		
	}
	
/**
	* showWorkShowcaseImages method fetches the records form Profile Media of Type WriteMaterial
	* giving the values in the options array priority. 
	*
	* @param int $workProfileId
	* @return array
*/
	
	/*function showWorkShowcaseWrittenMaterial($workProfileId=0)
	{	
		//$fieldTypeValue = 'WrittenMaterial';
		$fieldTypeValue = 4;
		$this->db->where($this->fieldType,$fieldTypeValue);
		$this->db->where('workProfileId',$workProfileId);
		$dataShowcaseWriteMaterials = $this->db->get($this->tableName);	
					
		if(count($dataShowcaseWriteMaterials)>0)
			$dataShowcaseWriteMaterials = $dataShowcaseWriteMaterials->result_array();
		else
			$dataShowcaseWriteMaterials = 0;
			
		return $dataShowcaseWriteMaterials;		
	}
	
/**
	* showWorkShowcaseAudios method fetches the records form Profile Media of Type Audios
	* giving the values in the options array priority. 
	*
	* @param int $workProfileId
	* @return array
*/	
	/*function showWorkShowcaseAudios($workProfileId=0)
	{	
		$fieldTypeValue = 'Audios';
		$this->db->where($this->fieldType,$fieldTypeValue);
		$this->db->where('workProfileId',$workProfileId);
		$dataShowcaseAudios = $this->db->get($this->tableName);	
					
		if(count($dataShowcaseAudios)>0)
			$dataShowcaseAudios = $dataShowcaseAudios->result_array();
		else
			$dataShowcaseAudios = 0;
			
		return $dataShowcaseAudios;		
	}	
	
/**
	* EntryRecord method Inserts/Update a record in the ProfileMedia table having Type as "Video/Audio/Image/WrittingMaterial".
	*
	* data: Values
	* --------------
	* workProfileId            (required)
	* showcaseTitle			   (required)
	* showcaseDesc			   (required)
	* showcaseSetPath  
	* mediaType		      		(hidden)
	*
	* @param array $data
*/
/*	function EntryRecord($data,$uploadedData)
	{
		$field = 'mediaId';
		if(!empty($data))
		{
			foreach($data['workShowcaseMediaId'] as $id =>$stats) {		
			//	print_r($uploadedData[$id]); 
				//echo $uploadedData[$id]['error'].'<br />';
				if(!isset($uploadedData[$id]['error'])){
					$image_type = $uploadedData[$id]['upload_data']['file_type'];
					$image_name = $uploadedData[$id]['upload_data']['file_name'];
					$image_size = $uploadedData[$id]['upload_data']['file_size'];
					
					$workShowcaseMedia['workProfileId']   = $data['workProfileId']; 
					$workShowcaseMedia['mediaTitle']      = $data['showcaseTitle'][$id];
					$workShowcaseMedia['mediaDesc']       = $data['showcaseDesc'][$id];
					$workShowcaseMedia['mediaType']       = $data['mediaType'];

					$workShowcaseMedia['mediaName'] = $image_name;
					$workShowcaseMedia['mediaSize'] = $image_size;
				}else
				{
					$workShowcaseMedia['workProfileId']   = $data['workProfileId']; 
					$workShowcaseMedia['mediaTitle']      = $data['showcaseTitle'][$id];
					$workShowcaseMedia['mediaDesc']       = $data['showcaseDesc'][$id];
					$workShowcaseMedia['mediaType']       = $data['mediaType'];
				}				
				if( $data['workShowcaseMediaId'][$id] == 0) {				
					// Insert new row
					$this->db->insert($this->tableName , $workShowcaseMedia);// Execute the query
				}
				else{
			
					// otherwise Update existing record
					$this->mediaId = $data['workShowcaseMediaId'][$id]; //Setting the mediaId (Primary Id) to update the record
					$this->db->where($field,$this->mediaId);//Where clause
					$this->db->update($this->tableName,$workShowcaseMedia);// Execute the query
				}
			}
		}
		else
		{
			$this->error = 'No valid data was provided to save row.';
			return FALSE;
		}
		return $workShowcaseMedia['workProfileId'];
	}
	
*/	
	function EntryRecord($data,$mediafile,$workProfileId,$mediaType)
	{
		$data['mediaType']= $mediaType;
		$field = 'mediaId';
		if($mediafile['mediaName']!='')
		{
			$workShowcaseMedia= array();
			$workShowcaseMedia['workProfileId']   = $workProfileId; 
			$workShowcaseMedia['mediaTitle']      = $data['showcaseTitle'];
			$workShowcaseMedia['mediaDesc']       = $data['showcaseDesc'];
			$workShowcaseMedia['mediaType']       = $data['mediaType'];
			$workShowcaseMedia['mediaName'] 	= $mediafile['mediaName'];
			$workShowcaseMedia['mediaSize'] 	= $mediafile['mediaSize'];
		}else
		{
			$workShowcaseMedia['workProfileId']   = $workProfileId; 
			$workShowcaseMedia['mediaTitle']      = $data['showcaseTitle'];
			$workShowcaseMedia['mediaDesc']       = $data['showcaseDesc'];
			$workShowcaseMedia['mediaType']       = $data['mediaType'];
		}
		if( $data['mediaId']== 0) {
			$this->db->insert($this->tableName , $workShowcaseMedia);// Execute the query
		}
		else{
			$this->db->where($field,$data['mediaId']);
			$this->db->update($this->tableName,$workShowcaseMedia);
		}
		return true;		
	}
	
	function deleteMediaType($mediaId)
	{
		$fieldmediaType = 'mediaId';
		$this->db->where($fieldmediaType,$mediaId);
		$this->db->delete($this->tableName); 
		return true;
	}
	
	/**
	 * Get profile media detail from database
	 *
	 * @access	public
	 * @param	string
	 * @return	Object
	 */
	public function getproflemediainfo($mediaId=0,$workProfileId=0) {
		$this->db->select($this->tableName.'.*');
		$this->db->select('MediaFile.*');
		$this->db->from($this->tableName);
		$this->db->join('MediaFile','MediaFile.fileId = '.$this->tableName.'.fileId');
		$this->db->where($this->tableName.'.mediaId',$mediaId);
		$this->db->where($this->tableName.'.workProfileId',$workProfileId);
		$query = $this->db->get();
		return $result = $query->result();		
	}
	
	
}//End Class
?>
