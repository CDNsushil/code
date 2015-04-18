<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Toadsquare load player class
 * @author Mayank Kanungo
 * @ this calss only check for the file indatabse and laod required player  
 * 
 */


class getMedia{
	/***
	* create properties
	* private variables for internal use only 	*
	*
	* */
	
	 private $fileId ;
	 private $filePath ;
	 private $fileName ;
	 private $fileLength ;
	 private $fileType ;
	 private $fileCreateDate ;
	 private $tdsUid ;
	 private $isExternal ;
	 private $fileSize ;
	 private $rawFileName ;
	 private $jobStsatus ;
	 private $statusDetail ;
	 private $tableMediaFile = 'MediaFile';
	 private $tableFields=" fileId,filePath,fileName,fileLength,fileType,fileCreateDate,tdsUid,isExternal,fileSize,rawFileName,jobStsatus,statusDetail";
	
	 //Class private variabl for itnernal use only
	 private $CI ;	
	 private $coverImage;
	 private $container;
	 private $playMode;
	// private $defaultMedia = '';
	 
	 /***
	  *  $media will use to return player object code
	  *  coantin an string of javascript code for all type of media
	  *  Video, Audio, PDF 
	  *  or error status if fails to get media files
	  * */
	static $media;
 
	private function __construct($fileId = 0,$container,$playMode) {
	
			$this->fieldId = $fileId;
			$this->container = $container;
			$this->playMode = $playMode;
			$this->now = time();
			$this->coverImage = base_url('images/no_images.png');
			$this->CI =& get_instance();
			//load libraries
			//$this->CI->load->database();
			$this->getMediaPlayer();
			
	}
	/***
	 * Static fucntioln this is only the entry poin of this calss all ohter fucntion must must be private.
	 * @fileId ==> database id of requirested file
	 * @$container ==> div Id where the player will be load in to html page
	 * @$playMode  ==> play mode the file can be play in to two mode 1 priview and 2 full mode
	 * 
	 * */
	static function getPlayer($fileId = 0,$container = 'videoFile',$playMode = 'clip') {
       if($fileId != 0 && is_numeric($fileId))
			 return new getMedia($fileId,$container,$playMode);
    }
	
	private function getMediaPlayer(){
		$mediaPathNoMediaFound = 0;
		if($this->setFileds()){
			$this->filePath = (substr($this->filePath,-1) == '/')  ? $this->filePath : $this->filePath.'/';
			
			switch($this->fileType){
			
				case 1:
				case 'image':
				case 'IMAGES':
				break;
				
				case 2:	
				case 'video':
				case 'VIDEO':
						$file_name = explode('.',$this->fileName);
						$file_name[count($file_name)-1] = 'mp4';
						$this->fileName = implode('.',$file_name);
						
						//prepair media url
						$this->perpairMediaPath();
					if($this->playMode == 'clip'){
						$this->fileName = str_replace('.mp4','_preview.mp4',$this->fileName);
					}
					if(!is_file('media'.$this->filePath.'/'.$this->fileName)){
						//getMedia::$media = '<div>'.getImage($this->CI->config->item('defaultNoMediaImg')).'</div>';
						getMedia::$media = $mediaPathNoMediaFound;
					}else{
						$this->getVideo();
					}
				break;
				
				case 3:
				case 'audio':
				case 'AUDIO':
						$file_name = explode('.',$this->fileName);
						$file_name[count($file_name)-1] = 'mp3';
						$this->fileName = implode('.',$file_name);
						//prepair media url
						$this->perpairMediaPath();
						
					if($this->playMode == 'clip'){
						$get_file_ext = explode('.',$this->fileName);
						$getFileExt ='.'.$get_file_ext[1];
						$this->fileName = str_replace($getFileExt,'_preview.mp3',$this->fileName);
						if(!is_file('media'.$this->filePath.'/'.$this->fileName)){
							//getMedia::$media = '<div>'.getImage($this->CI->config->item('defaultNoMediaImg')).'</div>';
							getMedia::$media = $mediaPathNoMediaFound;
						}else{
							$this->getAudioClip();
						}
					}else{	
						if(!is_file('media'.$this->filePath.'/'.$this->fileName)){
							//getMedia::$media = '<div>'.getImage($this->CI->config->item('defaultNoMediaImg')).'</div>';
							getMedia::$media = $mediaPathNoMediaFound;
						}else{
							$this->getAudio();
						}
					}
				break;
				
				case 4:
				case 'text':
				case 'TEXT':
						
					//set pdf file name and path
					
					$this->pdfFileName  = $this->fileName;
					$this->pdfFilePath  = $this->filePath;
						
					$file_name = explode('.',$this->fileName);
					$file_name[count($file_name)-1] = 'swf';
					$this->fileName = implode('.',$file_name);
						
					//prepair media url
						$this->perpairMediaPath();
						
					if($this->playMode == 'clip'){
						$this->fileName = str_replace('.swf','_preview.swf',$this->fileName);
					}
					if(!is_file('media'.$this->filePath.'/'.$this->fileName)){
						//getMedia::$media = '<div>'.getImage($this->CI->config->item('defaultNoMediaImg')).'</div>';
						getMedia::$media = $mediaPathNoMediaFound;
					}else{
						$this->getPDF();
					}
					
				break;		
			}
			
		}else {
			//getMedia::$media = '<div>'.getImage($this->CI->config->item('defaultNoMediaImg')).'</div>';
			getMedia::$media = $mediaPathNoMediaFound;
		}
	}
	// manuplate Media path for secure url
	// toadsquare will never display orignal file it only allow user to see converted files 
	private function perpairMediaPath()
	{	
		// remove /media form file path
		$filePath = explode('/',$this->filePath); 
		unset($filePath[0]);
	
		// add new fodler name for converted media files 
		$filePath[] = 'converted';
	
		foreach($filePath as $key => $value) if($value =='') {unset($filePath[$key]);}
		 $this->filePath = '/'.implode('/',$filePath);
			
	}
	
	//Get recrod form database
	// and set calss variables
	private function setFileds(){
	
		$this->CI->db->select($this->tableFields);		
		$this->CI->db->from($this->tableMediaFile);	
		$this->CI->db->where('fileId',$this->fieldId);
			
		$query = $this->CI->db->get();
		//echo $this->db->last_query();
		$result=$query->result();
		if(isset($result) && !empty($result)){
			foreach($result[0] as $key => $value){
				$this->$key = $value;
			}
			return true;
		}else{
			return false;	
		}
	}
    
    //------------------------------------------------------------------------
    
    /*
    *  @access: private
    *  @description: This method is use to show video media file player for 
    *   desktop and mobile compitible 
    *  @modified by: lokendra meena
    *  @return: void
    */ 
    
	private function getVideo(){
        getMedia::$media = base_url().'media/'.$this->filePath.'/'.$this->fileName;
	}



	private function getAudio(){
		
	
	// This code for mobile device	
	if(getOsName()=="mobile")
			{
				
					getMedia::$media = '
				
					<link href="'.base_url().'player/html5_audio_player/skin/blue.monday/jplayer.blue.monday.css" rel="stylesheet" type="text/css" />
					<script type="text/javascript" src="'.base_url().'/templates/system/javascript/jquery-lib/jquery.js"></script>
					<script type="text/javascript" src="'.base_url().'player/html5_audio_player/js/jquery.jplayer.min.js"></script>

					<script type="text/javascript">
					//<![CDATA[
				
					var jPlayerAndroidFix = (function($) {
					var fix = function(id, media, options) {
						this.playFix = false;
						this.init(id, media, options);
					};
					fix.prototype = {
						init: function(id, media, options) {
							var self = this;

							// Store the params
							this.id = id;
							this.media = media;
							this.options = options;

							// Make a jQuery selector of the id, for use by the jPlayer instance.
							this.player = $(this.id);

							// Make the ready event to set the media to initiate.
							this.player.bind($.jPlayer.event.ready, function(event) {
								// Use this fix"s setMedia() method.
								self.setMedia(self.media);
							});

							// Apply Android fixes
							if($.jPlayer.platform.android) {

								// Fix playing new media immediately after setMedia.
								this.player.bind($.jPlayer.event.progress, function(event) {
									if(self.playFixRequired) {
										self.playFixRequired = false;

										// Enable the contols again
										// self.player.jPlayer("option", "cssSelectorAncestor", self.cssSelectorAncestor);

										// Play if required, otherwise it will wait for the normal GUI input.
										if(self.playFix) {
											self.playFix = false;
											$(this).jPlayer("play");
										}
									}
								});
								// Fix missing ended events.
								this.player.bind($.jPlayer.event.ended, function(event) {
									if(self.endedFix) {
										self.endedFix = false;
										setTimeout(function() {
											self.setMedia(self.media);
										},0);
										// what if it was looping?
									}
								});
								this.player.bind($.jPlayer.event.pause, function(event) {
									if(self.endedFix) {
										var remaining = event.jPlayer.status.duration - event.jPlayer.status.currentTime;
										if(event.jPlayer.status.currentTime === 0 || remaining < 1) {
											// Trigger the ended event from inside jplayer instance.
											setTimeout(function() {
												self.jPlayer._trigger($.jPlayer.event.ended);
											},0);
										}
									}
								});
							}

							// Instance jPlayer
							this.player.jPlayer(this.options);

							// Store a local copy of the jPlayer instance"s object
							this.jPlayer = this.player.data("jPlayer");

							// Store the real cssSelectorAncestor being used.
							this.cssSelectorAncestor = this.player.jPlayer("option", "cssSelectorAncestor");

							// Apply Android fixes
							this.resetAndroid();

							return this;
						},
						setMedia: function(media) {
							this.media = media;

							// Apply Android fixes
							this.resetAndroid();

							// Set the media
							this.player.jPlayer("setMedia", this.media);
							return this;
						},
						play: function() {
							// Apply Android fixes
							if($.jPlayer.platform.android && this.playFixRequired) {
								// Apply Android play fix, if it is required.
								this.playFix = true;
							} else {
								// Other browsers play it, as does Android if the fix is no longer required.
								this.player.jPlayer("play");
							}
						},
						resetAndroid: function() {
							// Apply Android fixes
							if($.jPlayer.platform.android) {
								this.playFix = false;
								this.playFixRequired = true;
								this.endedFix = true;
								// Disable the controls
								// this.player.jPlayer("option", "cssSelectorAncestor", "#NeverFoundDisabled");
							}
						}
					};
					return fix;
				})(jQuery);
				
				
					$(document).ready(function() {

					var id = "#jquery_jplayer_1";

					var bubble = {
						mp3:"'.base_url().'player/html5_video_player/secure/'.rand().'/'.time().'/'.base64_encode($this->filePath.'/'.$this->fileName).'"
					};
					
					var options = {
						swfPath: "js",
						supplied: "mp3",
						wmode: "window"
					};

					var myAndroidFix = new jPlayerAndroidFix(id, bubble, options);

					$("#setMedia-Bubble").click(function() {
						myAndroidFix.setMedia(bubble);
						$(".jp-title ul li").text("Bubble");
					});
					$("#setMedia-Bubble-play").click(function() {
						myAndroidFix.setMedia(bubble).play();
						$(".jp-title ul li").text("Bubble");
					});

				});
					
					
					//]]>
					</script>
					 
					 
					<div id="jquery_jplayer_1" class="jp-jplayer"></div>

					<div id="jp_container_1" class="jp-audio">
						<div class="jp-type-single">
							<div class="jp-gui jp-interface">
								<ul class="jp-controls">
									<li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
									<li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
									<li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
									<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
									<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
								</ul>
								<div class="jp-progress">
									<div class="jp-seek-bar">
										<div class="jp-play-bar"></div>
									</div>
								</div>
								<div class="jp-volume-bar">
									<div class="jp-volume-bar-value"></div>
								</div>
								<div class="jp-time-holder">
									<div class="jp-current-time clr_f15921"></div>
									<div class="jp-duration"></div>
								</div>
							</div>
						
						</div>
					</div>';
				
				
			}else
			{		
				// This code for desktop
			
				getMedia::$media = '<script type="text/javascript" charset="utf-8">
					function playMediaFile(){ 
					
					//audio player
								$f("'.$this->container.'", "'.base_url().'player/flowplayer/flowplayer.commercial-3.2.16.swf", {
							
							key: "#$943a9847a4c436aa438",	
							
							canvas: {backgroundColor: "transparent"},
							
									
							plugins: {
								secure: {
									url: "'.base_url().'player/flowplayer/flowplayer.securestreaming-3.2.8.swf",
									timestampUrl: "'.base_url().'player/flowplayer/sectimestamp.php"
								},
								audio: {
									url: "'.base_url().'player/flowplayer/flowplayer.audio-3.2.9.swf"
								},
								
								controls: null,
								
							},
							 clip: {
								onStart: function() {
								 // alert(commanplayertoggal+"=="+tortalplayer);
								}},
							
							playlist: [
								 {
										 url: "'.base_url().'images/logo-tod-square.png",
										 scaling: "orig"
								 },
									
								 {
										 // these two settings will make the first frame visible
										autoPlay:false,	
										autoBuffering: true,
										baseUrl: "'.base_url().'player/flowplayer/secure", // /media/
										url: "'.base64_encode($this->filePath.'/'.$this->fileName).'",
										urlResolvers: "secure",
										provider: "audio"
								 }
							],
								 
							}).controls("audioPlayer", {duration: 0,trackTitle:"track title"});		
					
					
					
					
					}
					playMediaFile();
					</script>';
	
		}
	
	}
	
	static function getAudioClip(){
		
		
		// This code for mobile device	
			if(getOsName()=="mobile")
			{
				getMedia::$media = '
				
				<script type="text/javascript">
					//<![CDATA[
				
				function playMediaClipFile(myMusic,obj)
					{
						
						$("#Player2").jPlayer("destroy");
						var audioUrl = "'.base_url().'player/html5_video_player/secure/698605436/'.time().'/"+myMusic;
						$("#Player2").jPlayer({
							ready: function () {
								$(this).jPlayer("setMedia", {
									mp3:audioUrl
								}).jPlayer("play");
							},
							play: function() { // To avoid multiple jPlayers playing together.
								$(this).jPlayer("pauseOthers");
							},
							play: function() { // To avoid multiple jPlayers playing together.
								$(this).jPlayer("pauseOthers");
							},
							swfPath: "js",
							supplied: "mp3",
							cssSelectorAncestor: "#jp_container_2",
							wmode: "window"
						});
						
					}	
					
					//]]>
					</script>
				';
				
				
			}else
			{	
				getMedia::$media = '
				<script type="text/javascript" charset="utf-8">
				
						var commanplayertoggal=null;
						var tortalplayer=null;
						var onfinesh=0;
						var loadindiv="";
						
				function playMediaClipFile(clipFileUrl,obj){ 
					loadindiv="loadertxt_"+String(obj.id).split("_")[1];
					
					
					//alert(loadindiv);
							if(commanplayertoggal==obj)
							{
								if(tortalplayer!=null)
								{
									tortalplayer.stop();
									tortalplayer=null;
									return;
								}
								
							}
							else
							{
								commanplayertoggal=obj;
							}
							$f("Player2", "'.base_url().'player/flowplayer/flowplayer.commercial-3.2.16.swf", {
						
						key: "#$943a9847a4c436aa438",	
						
						
								
						plugins: {
							secure: {
								url: "'.base_url().'player/flowplayer/flowplayer.securestreaming-3.2.8.swf",
								timestampUrl: "'.base_url().'player/flowplayer/sectimestamp.php"
							},
							audio: {
								url: "'.base_url().'player/flowplayer/flowplayer.audio-3.2.9.swf"
							},
							 controls: {
							height: 28,
							fullscreen: false,
							autoHide: false,
							autoPlay:true,
							},	
							
						},
						
						playlist: [
							 {
									 url: "'.base_url().'images/logo-tod-square.png",
									 scaling: "orig"
							 },
								
							 {
									 // these two settings will make the first frame visible
									//autoPlay: false,
									autoBuffering: true,
									baseUrl: "'.base_url().'player/flowplayer/secure", // /media/
									url: clipFileUrl,
									urlResolvers: "secure",
									provider: "audio"
							 }
						],
						 onLoad: function() {
							// alert(commanplayertoggal);
						tortalplayer=this;
						$("#"+loadindiv).show();
						if(commanplayertoggal!=null)
							{
							var idd=commanplayertoggal.id;
							$("#"+idd).removeClass();
							$("#"+idd).addClass("status_bar_play_btn_hover ptr Fright mt-3 playAudioIcon");
							}
							onfinesh=0;
							
							if(mainplayer!=null)
							{
								if(mainplayer.isPlaying())
								{
									mainplayer.pause();
								}
								else
								{
									mainplayer.stop();
								}
							}
						},
						onStart: function() {
							
							
							$("#"+loadindiv).hide();
							
							
						},
						 onFinish: function() {
							 var idd=commanplayertoggal.id;
								if(onfinesh==1)
								{
									//alert(tortalplayer+"=="+tortalplayer.isPlaying());
									$("#"+idd).removeClass();
									$("#"+idd).addClass("status_bar_play_btn ptr Fright mt-3 playAudioIcon");
									onfinesh=0;
									tortalplayer=null;
								}
								if(onfinesh==0)
								{
									onfinesh=1;
								}
							}
						});		
				
				}
				//playMediaClipFile(clipFileUrl="");
				</script>';
					
					
			}			
					
	}
	
	/*
	 ******************************* 
	 * This function is used to play audio playlist play
	 ******************************* 
	 */ 
	
	static function playAudioPlaylist($isAutoPlay){
		
		
		// This code for mobile device	
        $isAutoPlay = ($isAutoPlay==1)?'true':'false';
				
				getMedia::$media = '
				<script>
					$(function() {
                    
                         player = $f("playlistPlayer", "'.base_url().'player/flowplayer/flowplayer.commercial-3.2.16.swf", {
                            // dont start automatically
                            clip: {
                                autoPlay: '.$isAutoPlay.',
                                autoBuffering: true,
                                onStart: function(clip) {
                                    $(".playing").each(function(){
                                        playNpaush($(this).attr("playingElementId"))
                                    });
                                    
                                    var ind = clip.index, plength = this.getPlaylist().length;
                                    buttonenable(ind, plength);
                                },
                                onResume:  function(){
                                   // console.log("onResume");
                                }
                            },
                            // disable default controls
                            plugins: {controls: null}
                        // install HTML controls inside element whose id is "hulu"
                        }).controls("audioPlayer", {duration: 0,trackTitle:"Rock Star"}).playlist("#myplaylist", {loop:true});

					});
				</script>';
					
	}
	
	
	
	private function getPDF(){
		
	
    					
		if(getOsName()=="mobile")
			{
				
				$data['pdfFilePath'] = $this->pdfFilePath;
				$data['pdfFileName'] = $this->pdfFileName;
				getMedia::$media = $this->CI->load->view('html5_pdf_viewer',$data,true);
				
			}else
			{	
    
				getMedia::$media = '
			
				 <script type="text/javascript">
				 var BaseURL = "'.base_url().'";
				 
				  </script>
			
				<link rel="stylesheet" type="text/css" href="'. base_url('player/FlexPaper_new_readonly/css/flexpaper.css').'" />
				<script type="text/javascript" src="'. base_url('player/FlexPaper_new_readonly/js/jquery.min.js').'"></script>
				<script type="text/javascript" src="'. base_url('player/FlexPaper_new_readonly/js/jquery.extensions.min.js').'"></script>
				<script type="text/javascript" src="'. base_url('player/FlexPaper_new_readonly/js/flexpaper.js').'"></script>
				<script type="text/javascript" src="'. base_url('player/FlexPaper_new_readonly/js/flexpaper_handlers.js').'"></script>
			
			
				<script type="text/javascript">
				   
					var startDocument = "Paper";

					$("#'.$this->container.'").FlexPaperViewer(
						   { config : {

							 SWFFile : "'.base_url('media').$this->filePath.'/'.$this->fileName.'",
							 Scale : 0.6,
							 key : "$3f2efdc68f03bf1a52c",
							 ZoomTransition : "easeOut",
							 ZoomTime : 0.5,
							 ZoomInterval : 0.1,
							 FitPageOnLoad : true,
							 FitWidthOnLoad : false,
							 FullScreenAsMaxWindow : false,
							 ProgressiveLoading : false,
							 MinZoomSize : 0.2,
							 MaxZoomSize : 5,
							 SearchMatchAll : false,
							 InitViewMode : "Portrait",
							 RenderingOrder : "flash,html",
							 StartAtPage : "",

							 ViewModeToolsVisible : true,
							 ZoomToolsVisible : true,
							 NavToolsVisible : true,
							 CursorToolsVisible : true,
							 SearchToolsVisible : true,
							 WMode : "window",
							 localeChain: "en_US"
						   }}
					);
				</script>';	
			}
          
		    
	}
}
