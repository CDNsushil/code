<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author : Anoop singh
 * Email  : anoop@cdnsol.com
 * Timestamp : Aug-29 06:11PM
 * Copyright : www.cdnsol.com
 *
 */
final class config
{
    /// -- Hold Static class object --
    private static $ref;
    /// -- Hold Static private class members variables --
    private static $_config=array();
	
	/**
    * @method __construct
    * @see private constructor to protect beign inherited
    * @access private
    * @return void
    */
    private function __construct()
    {
	
		/*
		|--------------------------------------------------------------------------
		| Media Format type
		|--------------------------------------------------------------------------
		|
		| Typically this will be your Media config array, unless you've renamed it to
		| something else. If queue find this file in folder it will set/put this file in
		| queue to convert this.
		|
		*/
		$this::$_config['media_queue_inqueue']= dirname(dirname(__FILE__))."/queueTask/inqueue/";
		
		
		/*
		|--------------------------------------------------------------------------
		| Media Format type
		|--------------------------------------------------------------------------
		|
		| Typically this will be your Media config array, unless you've renamed it to
		| something else. If queue find this file in folder it will set/put this file in
		| queue to convert this.
		|
		*/
		$this::$_config['media_queue_trash']= dirname(dirname(__FILE__))."/queueTask/trash/";
		
		/*
		|--------------------------------------------------------------------------
		| Root Path of server
		|--------------------------------------------------------------------------
		|
		| Typically this will be your root folder path of server, unless you've renamed it to
		| something else. This path is use to search media file path and save new job file at location 
		| //'/opt/lampp/htdocs/toadsquare/temp/toadsquare/dev/' at cdn server and /var/www at live server
		*/
		$this::$_config['root_path']= dirname(dirname(dirname(__FILE__))).'/';
		
		
		/*
		|--------------------------------------------------------------------------
		| Media Format type
		|--------------------------------------------------------------------------
		|
		| Typically this will be your Media config array, unless you've renamed it to
		| something else. If queue find this file in folder it will set/put this file in
		| queue to convert this.
		|
		*/
		//$this::$_config['media_format_queue']=array("mov","avi","wma","dat","mp4","mp3","divx","3gp","asf","f4v","mpg","vob","wmv");
		$this::$_config['media_format_queue']=array("3gp","mp2","aac","m4a","asf","avi","wma","dat","mp3","wmv","mp4","f4v","flv","wav","mov","m2ts","mp2t","mkv","mpg","ts","divx","ogv","m2v","m4v","vob","pdf");
		/*
		|--------------------------------------------------------------------------
		| Audio Format type
		|--------------------------------------------------------------------------
		|
		| Typically this will be your Audio config array, This in usage while passing the audio file in 
		| conversion queue.
		|
		*/
		$this::$_config['audio_format_queue']=array("m4a","mp2","mp3","aac","wma","wav");
		
		/*
		|--------------------------------------------------------------------------
		| Video Format type
		|--------------------------------------------------------------------------
		|
		| Typically this will be your Video config array, This in usage while passing the video file in 
		| conversion queue.
		|	** CURRENTLY IT IS COMMENTED AND JUST NEED TO UNCOMMENT IF WE WOULD NEED THIS IN FUTURE
		*/
		//$this::$_config['video_format_queue']=array("3gp","asf","avi","wma","dat","wmv","mp4","f4v","flv","wav","mov","m2ts","mp2t","mkv","mpg","ts","divx","m2v","m4v","vob");
		/*
		|--------------------------------------------------------------------------
		| Render Job File
		|--------------------------------------------------------------------------
		|
		| Typically this will be your XXXX.renderjob file, unless you've renamed it to
		| something else. If queue find this file in folder it will set/put this file in
		| queue to convert this.
		|
		*/
		$this::$_config['renderjob'] = '.renderjob';

		/*
		|--------------------------------------------------------------------------
		| DOne Job File
		|--------------------------------------------------------------------------
		|
		| Typically this will be your XXXX.done file, unless you've renamed it to
		| something else. If queue find this file in folder it will leave actual media in
		| folder and did not convert anything.
		|
		*/
		$this::$_config['done'] = '.done';
		
		
		/*
		|--------------------------------------------------------------------------
		| Lock Job File
		|--------------------------------------------------------------------------
		|
		| Typically this will be your XXXX.done file, unless you've renamed it to
		| something else. If queue find this file in folder it will leave actual media in
		| folder and did not convert anything.
		|
		*/
		$this::$_config['lockjob'] = '.lock';

		/*
		|--------------------------------------------------------------------------
		| relock Job File
		|--------------------------------------------------------------------------
		|
		| Typically this will be your XXXX.done file, unless you've renamed it to
		| something else. If queue find this file in folder it will leave actual media in
		| folder and did not convert anything.
		|
		*/
		$this::$_config['relockjob'] = '.relockjob';
		
		/*
		|--------------------------------------------------------------------------
		| Error Logging Threshold
		|--------------------------------------------------------------------------
		|
		| If you have enabled error logging, you can set an error threshold to
		| determine what gets logged. Threshold options are:
		| You can enable error logging by setting a threshold over zero. The
		| threshold determines what gets logged. Threshold options are:
		|
		|	0 = Disables logging, Error logging TURNED OFF
		|	1 = Error Messages (including PHP errors)
		|	2 = Debug Messages
		|	3 = Informational Messages
		|	4 = All Messages
		|
		| For a live site you'll usually only enable Errors (1) to be logged otherwise
		| your log files will fill up very fast.
		|
		*/
		$this::$_config['log_threshold'] = 3;

		/*
		|--------------------------------------------------------------------------
		| Error Logging Directory Path
		|--------------------------------------------------------------------------
		|
		| Leave this BLANK unless you would like to set something other than the default
		| application/logs/ folder. Use a full server path with trailing slash.
		|
		*/
		$this::$_config['log_path'] = '';

		/*
		|--------------------------------------------------------------------------
		| Date Format for Logs
		|--------------------------------------------------------------------------
		|
		| Each item that is logged has an associated date. You can use PHP date
		| codes to set your own date formatting
		|
		*/
		$this::$_config['log_date_format'] = 'Y-m-d H:i:s';

		/*
		|--------------------------------------------------------------------------
		| Encryption Key
		|--------------------------------------------------------------------------
		|
		| If you use the Encryption class or the Session class you
		| MUST set an encryption key.  See the user guide for info.
		|
		*/
		$this::$_config['encryption_key'] = '2T1o6A9!dSq3$4Ua#re.C@56om!';

		/*
		|--------------------------------------------------------------------------
		| Output Compression
		|--------------------------------------------------------------------------
		|
		| Enables Gzip output compression for faster page loads.  When enabled,
		| the output class will test whether your server supports Gzip.
		| Even if it does, however, not all browsers support compression
		| so enable only if you are reasonably sure your visitors can handle it.
		|
		| VERY IMPORTANT:  If you are getting a blank page when compression is enabled it
		| means you are prematurely outputting something to your browser. It could
		| even be a line of whitespace at the end of one of your scripts.  For
		| compression to work, nothing can be sent before the output buffer is called
		| by the output class.  Do not 'echo' any values with compression enabled.
		|
		*/
		$this::$_config['compress_output'] = FALSE;

		/*
		|--------------------------------------------------------------------------
		| Master Time Reference
		|--------------------------------------------------------------------------
		|
		| Options are 'local' or 'gmt'.  This pref tells the system whether to use
		| your server's local time as the master 'now' reference, or convert it to
		| GMT.  See the 'date helper' page of the user guide for information
		| regarding date handling.
		|
		*/
		$this::$_config['time_reference'] = 'local';
		
		/*
		|--------------------------------------------------------------------------
		| Sample clip duration in HH:MM:SS 
		|--------------------------------------------------------------------------
		|
		| Sample clips genrated by the code is of limited time interval of this
		| config vairable of format: h:m:i
		|
		*/
		$this::$_config['sample_clip_duration'] = '0:00:10';
		
		/*
		|--------------------------------------------------------------------------
		| CURL URL PATH
		|--------------------------------------------------------------------------
		|
		| path or URL  of the page conatn code to udpate the databse status.
		| URL never be blank
		|
		*/
		$this::$_config['curl_url'] = 'http://';
		
		/*
		|--------------------------------------------------------------------------
		| DB CREADENTIAL TO CREATE RENDER JOB FILES 
		|--------------------------------------------------------------------------
		|
		| Databse credentail to get read postgress databse create job files.
		| 
		*/
		
		$SERVERNAME=exec("hostname -f");
		$SERVERADDR=exec("hostname -i");
		
		//$_SERVER['SERVER_NAME']=exec("hostname -f");
		//$_SERVER['SERVER_ADDR']=exec("hostname -i");
		
		
		if($SERVERADDR=='94.242.251.14'){ 	// Staging K119.server.lu, 94.242.251.14
		
			$this::$_config['db_hostname'] = 'localhost'; 
			$this::$_config['base_url'] = 'http://www.staging.toadsquare.com/'; 
			
		}
		elseif($SERVERADDR == '94.242.254.30'){ //Live L221.server.lu 94.242.254.30
			
			$this::$_config['db_hostname'] = 'localhost'; 
			$this::$_config['base_url'] = 'http://www.toadsquare.com'; 
		}
		elseif($SERVERADDR == '10.10.10.2' || $SERVERADDR == '127.0.1.1'){ //Developement
			$this::$_config['db_hostname'] = '10.10.10.2'; //'10.10.10.5';			
			$this::$_config['base_url'] = 'http://115.113.182.141/toadsquare_branch/dev/';  
		}
		else{ //
			$this::$_config['db_hostname'] = 'localhost'; 
			$this::$_config['base_url'] = 'http://www.toadsquare.com/';
			
		}

		$this::$_config['db_port'] 	= '5432';
	    $this::$_config['db_username'] = 'postgres';
	    $this::$_config['db_password'] = '8899-hijk';
	    $this::$_config['db_name'] = 'toadsquare';
	}
	final public static function getInst()
    {
      if(!is_object(config::$ref)){
          config::$ref=new config();
      }
      return config::$ref;
    }
    /**
    *  Config::getConfig Array()
    *	 @Param Void
    *  @RETURN Array of Settings
    */
    final public function getSettings()
    {
        return $this::$_config;
    }

    /**
    *  config::getKeyValue Array()
    *	 @Param key STRING
    *  @RETURN Array of Settings
    */
    final public function getKeyValue($key)
    {
        if(array_key_exists($key,$this::$_config))
        {
          return $this::$_config[$key];
        }
    }

}
$configPay=array();
$configPay['crave_url'] = 'http://www.toadsquare.com/en/showcase/index/4';
$configPay['facebook_follow_url'] = 'http://www.facebook.com/pages/Toadsquare/121921117888970';
$configPay['linkedin_follow_url'] = 'http://www.linkedin.com/company/toadsquare?trk=hb_tab_compy_id_3001132';
$configPay['crave_us'] = 'http://www.toadsquare.com/en/showcase/index/4';

$configPay['setExpiryDays'] = 7;
$configPay['toadsquare_email'] = 'sushilmishra@cdnsol.com';

/* End of file config.php */
/* Location: ./inc/config.php */


