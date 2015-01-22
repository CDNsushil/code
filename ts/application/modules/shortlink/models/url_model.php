<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * @description: This modal is use to manage short link data
 * @medified by: lokendra meena
 * @modified date: 5-nov-2014 
 * @package: model
 * @link: http://toadsquare.com
 */ 

class Url_model extends CI_Model {
    
    private $Shortlink = 'Shortlinks'; // defined table name

    
    /**
    * constructor of modal
    */ 
    
    function __construct()
    {
        parent::__construct(); 
    }
    
    //---------------------------------------------------------------------
    
    /*
    * @access: public
    * @description: This method is use to add short link data
    * @return: void 
    */
      
    function addShortLink($short,$long,$ip, $user_id)
    {
        //Collect the data
        $data = array(
        'user_id' => $user_id,
        'short_url' => $short,
        'user_ip' => $ip,
        'url' => $long,                
        );        

        $this->db->insert($this->Shortlink, $data);
    }   
    
    //---------------------------------------------------------------------
    
    /*
    * Function to check is genertaed url unique or not
    */
    
    function is_url_unique($short_url)
    {
        $this->db->where('short_url', $short_url);
        $q = $this->db->get($this->Shortlink);			
        
        if($q->num_rows() > 0){
                
                return FALSE;
        } else {
                
                return TRUE;
        }
    }
    
    //---------------------------------------------------------------------

    /* Function to get url */
    
    function get_full_url($short){
               
    $this->db->where('short_url', $short);			
    $query= $this->db->get($this->Shortlink);       
    $res =  $query->result();

        if($res[0]->url)
        {
            $hitCount=$res[0]->hits;
            $this->updateHits($short,$hitCount);      
        }
        return $res[0];        
    }
    
    //---------------------------------------------------------------------
  
    /* Function to update hits */

    function updateHits($short,$count) {
      
        $count=$count+1;
        $data = array('hits'=>$count); 
        $this->db->where('short_url', $short); 
        $this->db->update($this->Shortlink,$data);
    }
       
        
}	 // END CLASS
