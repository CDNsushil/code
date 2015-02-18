<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Toadsquare frontend Library Class
 * @author Mayank Kanungo
 * @ TODO :: This Library must must have to apply check for the paid meida if any.
 * 
 */

include ('getMedia.class.php');
Class lib_player extends getMedia{
	 /**
	 * Constructor
	 */
	function __construct(){
		$this->now = time();
		$this->CI =& get_instance();

		//load libraries
		$this->CI->load->database();
	}
	//function to call core class and get the required palyer for media file
	function loadPlayer($entityId,$container,$playMode){
		/// check for validation.
		getMedia::getPlayer($entityId, $container,$playMode);
		return getMedia::$media;
	}
	
	//This function is used to Play Audio clip 
	function loadCommonPlayer(){
		getMedia::getAudioClip();
		return getMedia::$media;
	}
	
	//This function is used to Play Audio clip 
	function loadAudioPlaylistPlayer(){
		getMedia::playAudioPlaylist();
		return getMedia::$media;
	}

}
