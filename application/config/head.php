<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$CI =& get_instance();
$lang=$CI->uri->segment(1,'en');

/* for testing the verification form global setting */
$config['APIVersionCustom'] = '94.0';
$config['APIUsernameCustom'] = 'jb-us-seller_api1.paypal.com';
$config['APIPasswordCustom'] = 'WX4WTU3S8MY44S7F';
$config['APISignatureCustom'] = 'AFcWxV21C7fd0v3bYYYRCpSSRl31A7yDhhsPUU2XhtMoZXsWHFxu-RWy';

$config['IpAPISignature'] = 'b9b2d8563cfe0c5f09e374bf1dd8b0cd0f1ecaef42b090279829085709da0f97';

$config['mediaDir'] = 'media/';
$config['mediaTempDir'] = 'media/temp/';
$config['perPageRecord'] = 10;
$config['perPageRecordMedia'] = 5;
$config['perPageRecordMediaUpload'] = 20;
$config['perPageRecordProduct'] = 5;
$config['perPageRecordWork'] = 5;
$config['perPageRecordUpcoming'] = 5;
$config['perPageRecordPosts'] = 5;
$config['perPageRecordEvents'] = 5;
$config['perPageRecordCraves'] = 10;
$config['perPageRecordReviews'] = 2;  
$config['perPageRecordSales'] = 10;
$config['competitionEntryPerPage'] = 5;
$config['competitionUserPerPage'] = 5;
$config['myPlaylistPerPage'] = 10;
$config['competitionShortlist'] = 10;
$config['competitionReviewlist'] = 5;
$config['perPageRecordPurchase'] = 10;
$config['perPageRecordSalesInfo'] = 10;
$config['perPageRecordInbox'] = 10;
$config['perPageRecordSend'] = 10;
$config['perPageRecordTrash'] = 10;

$config['perPageRecordAdmin'] = 40;
$config['limitPageRecordAdmin'] = 40;
$config['perPageRecordAdminUser'] = 10;
$config['limitPageRecordAdminUser'] = 10;


$config['perPageAdminSalesRecord'] = 20;
$config['perPageAdminInvoice'] = 20;

$config['competitionGroupLimit'] = 5;
$config['competitionMediaLimit'] = 5;

$config['imageAccept'] = 'gif|jpeg|jpg|png|tiff|tif|raw|bmp|ppm|pgm|pmb|pnm|tga';
$config['imageType'] = 'gif,jpeg,jpg,png,tiff,tif,raw,bmp,ppm,pgm,pmb,pnm,tga';

$config['csvFileAccept'] = 'csv|tsv';
$config['csvFileType'] = 'csv,tsv';

$config['imageShowcaseTypeToShow'] = $config['imageTypeToShow'] = 'gif, jpeg, jpg, png, tiff, tif, raw, bmp, ppm, pgm, pmb, pnm, tga';
$config['mediaTypeToShow'] = $config['videoTypeToShow'] = '3gp, avi, wmv, mp4, f4v, flv, mov, mpg, divx, m2v, m4v, vob';
$config['audioTypeToShow'] = 'm4a, mp2, mp3, aac, wav, wma';
$config['imageSize'] = 52428800;
$config['imagemaxSize'] = '2048mb';
$config['imageWidth'] = 2000;
$config['imageHeight'] = 2000;
$config['image5MBSize'] =  52428800; // in 5mb
$config['defaultContainerSize'] =  52428800; // in 50mb

$config['videoAccept'] = '3gp|avi|wmv|mp4|f4v|flv|mov|mpg|divx|ogv|m2v|m4v|vob|mpeg';
$config['videoUploadAccept'] = '3gp|avi|wmv|mp4|f4v|flv|mov|mpg|divx|ogv|m2v|m4v|vob|mpeg';
$config['videoType'] = '3gp,avi,wmv,mp4,f4v,flv,mov,mkv,mpg,divx,m2v,m4v,vob,mpeg';

$config['videoSize'] = 52428800; // in bytes
$config['videoMaxSize'] =  '2048mb'; // in mb

$config['audioAccept'] = 'm4a|mp2|mp3|aac|wav|wma';
$config['audioType'] = 'm4a,mp2,mp3,aac,wav,wma';
$config['audioSize'] = 52428800 ; // in bytes == 50MB
$config['audioMaxSize'] = '2048mb' ; // in bytes == 2GB

$config['writtenMaterialAccept'] = 'pdf';
$config['writtenMaterialType'] = 'pdf';
$config['competitionMediaAcceptText'] = 'pdf,doc,docx';
$config['prNewsAccept'] = 'gif|jpeg|jpg|png|tiff|tif|raw|bmp|ppm|pgm|pmb|pnm|tga|doc|docx|pdf|3gp|avi|wmv|mp4|f4v|flv|mov|mpg|divx|ogv|m2v|m4v|vob|m4a|mp2|mp3|aac|wav|wma';
$config['sampleAccept'] = 'gif|jpeg|jpg|png|pdf|3gp|avi|wmv|mp4|f4v|flv|mov|mpg|divx|m2v|m4v|vob';
$config['docAccept'] = 'txt|odt|text|doc|docx|csv|ods|xls|pdf';
$config['textTypeToShow'] = $config['writMaterTypeToShow'] = 'pdf';
//$config['textType'] = 'txt,odt,text,doc,csv,ods,xls,pdf';
$config['textType'] = 'pdf';
$config['writtenMaterialSize'] = 52428800; // in bytes == 2GB
$config['newsPrifix'] = 'News';
$config['reviewsPrifix'] = 'Reviews';
$config['textMaxSize'] = '2048mb' ; // in bytes == 50MB
$config['eventFreeTickets'] = '6' ; 
$config['maxPurchaseTickets'] = '6' ; 
$config['ticketNumberStartFrom'] = 1100 ; 
$config['thumbFolder'] = 'thumb/' ; 
$config['watermarkFolder'] = 'watermark/' ;
$config['competitionprizeQuantity'] = 5 ;



/* Upload Dir */
$config['filmNvideoUploadMedia'] ='/project/filmNvideo/' ; 
$config['showcaseUploadMedia'] ='/showcase/' ; 
$config['workProfileUploadMedia'] ='/workProfile/' ; 
$config['upcomingProjectsUploadMedia'] ='/upcomingProjects/' ; 
$config['blogUploadMedia'] ='/blog/' ; 
$config['musicNaudioUploadMedia'] ='/project/musicNaudio/' ; 
$config['photographyNartUploadMedia'] ='/project/photographyNart/' ; 
$config['writingNpublishingUploadMedia'] ='/project/writingNpublishing/' ; 
$config['newsUploadMedia'] ='project/news/' ; 
$config['reviewsUploadMedia'] ='/project/reviews/' ; 
$config['educationMaterialUploadMedia'] ='/project/educationMaterial/' ; 
$config['workUploadMedia'] ='/work/' ; 
$config['productUploadMedia'] ='/product/' ; 
$config['productClassfiedUploadMedia'] ='/product/' ; 
$config['eventsUploadMedia'] ='/events/' ; 
$config['launcheventsUploadMedia'] ='/launchevents/' ; 
$config['eventwithlaunchUploadMedia'] ='/launchevents/' ; 
$config['eventnotificationUploadMedia'] ='/events/' ; 

/*End */

$config['convsrsionFileType']=array('video','audio visual','2','audio','3','text','document','writmater','4');

$config['WPTYPE'] =  'writing&publishing';
$config['MATYPE'] =  'music&audio';
$config['PATYPE'] =  'photography&art';
$config['FVTYPE'] =  'film&video';
$config['EMTYPE'] =  'educationalmaterial';
$config['APTYPE'] =  'associatedprofessionals';
$config['PETYPE'] =  'performances&events';
$config['CreativesTYPE'] =  'creatives';
$config['EnterprisesTYPE'] =  'enterprises';
$config['FansTYPE'] =  'fans';
$config['ProductTYPE'] =  'product';
// Promotional Images Upload Limit

 
$config['home_dashboard'] = 'dashboard/showcase'; 
$config['filmnvideo_dashboard'] = 'dashboard/filmNvideo'; 
$config['musicnaudio_dashboard'] = 'dashboard/musicNaudio'; 
$config['photographynart_dashboard'] = 'dashboard/photographyNart'; 
$config['writingnpublishing_dashboard'] = 'dashboard/writingNpublishing'; 
$config['news_dashboard'] = 'dashboard/writingNpublishing'; 
$config['review_dashboard'] = 'dashboard/writingNpublishing'; 
$config['educationnmaterial_dashboard'] = 'dashboard/educationMaterial'; 
$config['works_dashboard'] = 'dashboard/work'; 
$config['products_dashboard'] = 'dashboard/products'; 
$config['creatives_dashboard'] = 'dashboard/showcase'; 
$config['associateprofessional_dashboard'] = 'dashboard/showcase'; 
$config['enterprises_dashboard'] = 'dashboard/showcase'; 
$config['upcoming_dashboard'] = 'dashboard/upcoming'; 
$config['blogs_dashboard'] = 'dashboard/blog'; 
$config['blog_dashboard'] = 'dashboard/blog'; 
$config['performancesnevents_dashboard'] = 'dashboard/performancesevents'; 
$config['ticketCategory'] = array('isCategoryA'=>'Category A','isCategoryB'=>'Category B','isCategoryC'=>'Category C','Free'=>'Free Tickets'); 
$config['competition_dashboard'] = 'dashboard/competition'; 

$config['promo_max_upload'] =10; 
$config['addInfoLimitation'] =10; 
$config['addCreativeInvolvedLimit'] =10; 
$config['maxSupportedMedia'] = 3;
$config['maxUPImages'] = 6; //Maximum images to get shown on upcoming frontend at a time  
$config['maxWorkVideo'] = 1;
$config['maxworkprofileMedia'] = 6;
 
$config['defaultposter'] =  'images/default_thumb/poster_default.jpg'; 
$config['defaultDonateImg'] =  'images/default_thumb/170x113pixel_DONATE.jpg'; 
$config['defaultNoMediaImg'] =  'images/default_thumb/no_multimedia_icon.png'; 
$config['defaultMediaImg'] =  'images/multimedia_icon.png'; 
$config['defaultMediaImg_s'] =  'images/default_thumb/multimedia_icon_s.png'; 
$config['defaultVideoImg'] =  'images/film_icon.png'; 
$config['defaultVideoImg_s'] =  'images/default_thumb/film_icon_s.png'; 
$config['defaultAudioImg'] =  'images/audio_icon.png';
$config['defaultAudioImg_s'] =  'images/default_thumb/audio_icon_s.jpg';
$config['defaultDocImg'] =  'images/writing_icon.png'; 
$config['defaultDocImg_s'] =  'images/default_thumb/writing_icon_s.png';
$config['defaultPromoImg'] = $config['defaultImg'] =  'images/profile_icon.png'; 
$config['defaultPromoImg_s'] = $config['defaultImg_s'] =  'images/default_thumb/profile_icon_s.png';
$config['no_image_73_110'] =  'images/default_thumb/no_image_73x110.jpg';
$config['no_image_40_40'] =  'images/default_thumb/no_image_40x40.jpg';



$config['defaultProductImg'] =  'images/default_thumb/product_wanted.jpg';
$config['defaultProductFree'] =  'images/default_thumb/free_products_s.jpg';
$config['defaultWorkWanted'] =  'images/default_thumb/work wanted.jpg';
$config['defaultWorkOffered'] =  'images/default_thumb/work_offered.jpg';
$config['defaultNewsImg'] =  'images/default_thumb/news.jpg';
$config['defaultUpcomingImg'] =  'images/default_thumb/upcoming.jpg';

$config['defaultWPImg'] =  'images/default_thumb/writing_publishing.jpg';
$config['defaultReviewsImg'] =  'images/default_thumb/reviews.jpg';
$config['defaultEventImg'] =  'images/default_thumb/events.jpg';

$config['defaultToadsquareImg'] =  'images/default_thumb/toadsquare_default.jpg';

$config['defaultCreativeImg'] =  'images/default_thumb/creatives.jpg';
$config['defaultAssProfImg'] =  'images/default_thumb/associated_professionals.jpg';
$config['defaultEnterpriseImg'] =  'images/default_thumb/enterprises.jpg';
$config['defaultcompetitonImage'] =  'images/default_thumb/comptition.jpg';
$config['defaultcollaborationImage'] =  'images/default_thumb/collaboration.jpg';
$config['defaultcompetitonImg73X110'] =  'images/default_thumb/competition_73x110.jpg';
$config['defaultcompetitonImageListing'] =  'images/default_thumb/competionimglisting.jpg';

$config['defaultcompetitonEntryImage'] =  'images/default_thumb/comptitionentry.jpg';
$config['defaultcompetitonEntryImg73X110'] =  'images/default_thumb/competitionentry_73x110.jpg';
$config['defaultcompetitonEntryImg180X210'] =  'images/default_thumb/180x210pixel_Competition-ENTRY.jpg';
$config['defaultcompetitonEntryImg_s'] =  'images/default_thumb/competitionentry_S.jpg';

					/*****************************************/
						 //Default Small Version of Images
					/*****************************************/

$config['defaultWPImg_s'] =  'images/default_thumb/writing_publishing_s.jpg';

$config['defaultEventPosterImg'] =  'images/default_thumb/event_default_bg.jpg';
$config['defaultLaunchPosterImg'] =  'images/default_thumb/lunch_default_bg.jpg';

					/*****************************************/
						 //Default Extra Small Version of Images
					/*****************************************/
$config['defaultProductWanted_xs'] =  'images/default_thumb/product_wanted_xs.jpg';
$config['defaultProductOffered_xs'] =  'images/default_thumb/product_offered_xs.jpg';
$config['defaultProductForSale_xs'] =  'images/default_thumb/product_for_sale_xs.jpg';


$config['defaultWPImg_xs'] =  'images/default_thumb/writing_publishing_xs.jpg';

$config['defaultReviewsImg_xs'] =  'images/default_thumb/reviews_xs.jpg';
$config['defaultEventImg_xs'] =  'images/default_thumb/events_xs.jpg';

					/*****************************************/
						 //Default Extra-Extra Small Version of Images
					/*****************************************/

$config['defaultWPImg_xxs'] =  'images/default_thumb/writing_publishing_xxs.jpg';
					
					/*************** Medium **************/

$config['defaultCreativeImg_152_210'] =  'images/default_thumb/creatives_152_210.jpg';
$config['defaultAssProfImg_152_210'] =  'images/default_thumb/associated_professionals_152_210.jpg';
$config['defaultEnterpriseImg_152_210'] =  'images/default_thumb/enterprises_152_210.jpg';
					
					/*************** Large **************/


$config['defaultWPImg_l'] =  'images/default_thumb/writing_publishing_l.jpg';
$config['defaultWPImg_m'] =  'images/default_thumb/writing_publishing_m.jpg';




//$config['filmNvideoImage'] = 'video.png'; 
$config['filmNvideoImage'] = 'images/default_thumb/film_video_s.jpg'; 
$config['musicNaudioImage'] = 'images/default_thumb/music_audio_s.jpg'; 
$config['photographyNartImage'] = 'images/default_thumb/photography_art_s.jpg'; 
$config['writingNpublishingImage'] = 'images/default_thumb/writing_publishing_s.jpg'; 
$config['educationMaterialImage'] = 'images/default_thumb/education_material_s.jpg'; 
$config['newsImage'] = 'images/default_thumb/news_s.jpg'; 
$config['reviewsImage'] = 'images/default_thumb/reviews_s.jpg';
$config['blogImage'] = 'images/default_thumb/blog_default_image_s.jpg';
$config['blogsImage'] = 'images/default_thumb/blog_default_image_s.jpg';
$config['performances&eventsImage'] = 'images/default_thumb/events_s.jpg';
$config['performanceseventsImage'] = 'images/default_thumb/events_s.jpg';
$config['eventImage'] = 'images/default_thumb/events_s.jpg';
$config['launchImage'] = 'images/default_thumb/events_s.jpg';
$config['notificationImage'] = 'images/default_thumb/events_s.jpg';
$config['associatedprofessionalsImage'] = 'images/default_thumb/associated_professionals_s.jpg';
$config['creativesImage'] = 'images/default_thumb/creatives_s.jpg';
$config['enterprisesImage'] = 'images/default_thumb/enterprises_s.jpg';
$config['upcomingImage'] = 'images/default_thumb/upcoming_s.jpg'; 
$config['productImage'] = 'images/default_thumb/Products_110x73.jpg'; 
$config['productWantedImage'] = 'images/default_thumb/product_wanted_s.jpg'; 
$config['productOfferedImage'] = 'images/default_thumb/product_offered_s.jpg';
$config['workImage'] = 'images/default_thumb/Work_110x73.jpg'; 
$config['workwantedImage'] = 'images/default_thumb/work_offered_s.jpg'; 
$config['workofferedImage'] = 'images/default_thumb/work wanted_s.jpg'; 
$config['defaultBlogImg'] =  'images/default_thumb/blog_default_image.jpg';
$config['defaultPostImg'] =  'images/default_thumb/post_default_image.jpg';
//maximum number of sessions
$config['maxSessions'] = 20;


$config['defaultTime'] = '00:00';  
$config['show_errors'] = FALSE;
$config['meta_author'] = "CDN";
$config['meta_description'] = "Home of the Creative Industries";
$config['site_title'] 	= 'Toadsquare::movie, film';
$config['template'] 	= 'default';
$config['termsncondtion'] 	= "Toadsquare's Terms & Conditions";

/*currency Start  Toadsquare Commision Percentage*/
$config['currency0'] 	= '&euro;';
$config['currency1'] 	= '$';
$config['minimumComission0'] 	=  0.40 ;
$config['minimumComission1'] 	=  0.50 ;
$config['commisionPercentage'] 	=  15;
$config['VATpercentage'] 	=  15;
/*currency End*/

$config['fontCss'] 		= 'templates/'.$config['template'].'/css/openSansFontfacekit/stylesheet.css';
$config['templateCss'] 		= 'templates/'.$config['template'].'/css/allStyle.css';
//
$config['templateJs'] 		= 'templates/'.$config['template'].'/javascript/allJs.js';
$config['templateImages'] 	= 'templates/'.$config['template'].'/images/';

$config['admin_css'] 		= 'templates/admin_template/css/';
$config['system_css'] 		= 'templates/system/css/';
$config['default_css'] 		= 'templates/default/css/';
$config['frontend_css'] 	= 'templates/frontend/css/';
$config['frontend_js'] 		= 'templates/frontend/js/';
$config['player_js'] 		= 'player/flowplayer/';

$config['parallax_css'] 	= 'templates/parallax/css/';
$config['parallax_js'] 		= 'templates/parallax/js/';

$config['projectCSS'] 		= 'templates/system/css/project.css';
$config['commonCSS'] 		= 'templates/system/css/common.css';
$config['system_js'] 		= 'templates/system/javascript/';
$config['default_js'] 		= 'templates/default/javascript/';
$config['admin_system_js'] 	= 'templates/admin_template/js/';
$config['admin_fancybox'] 	= 'templates/default/fancybox/';
$config['system_images'] 	= 'templates/system/images/';

$config['forum_css'] 		= 'templates/assets/css/';
$config['forum_js'] 		= 'templates/assets/js/';

$config['jquery_file'] 		= $config['system_js'].'jquery-lib/jquery.js';
$config['commonJs'] 		= $config['system_js'].'common.js';


$config['html5_player_css'] 		= 'player/html5_video_player/';
$config['html5_player_js'] 		= 'player/html5_video_player/';

$config['html5_audio_player_js'] 		= 'player/html5_audio_player/js/';
$config['html5_audio_player_css'] 		= 'player/html5_audio_player/skin/blue.monday/';

$config['editable_plugins'] 		= 'templates/admin_template/js/editablegrid_plugin/';

/*
|--------------------------------------------------------------------------
| Default elements
|--------------------------------------------------------------------------
|
| Need some files loaded for every page? Put them here. They will be loaded first.
|
*/
/**/
$config['defaults']['css'][] = array($config['parallax_css'].'parallaxIE.css', 'IE 7');
$config['defaults']['js'][] = array($config['system_js'].'IE7.js', 'IE 7');

$config['defaults']['packages'] = array('validation','lightboxme','tipsy','datepicker','nic');

/*
 ************************************
 * Define admin default package array
 ************************************
 */
$config['admin_defaults']['packages'] = array('tipsy','datepicker','nic');

/*
|--------------------------------------------------------------------------
| Packages
|--------------------------------------------------------------------------
|
| Packages work like containers for groups of files needed. For example, the coda slider
| needs several Javascipt files, and a css file.
| 
| Packages can contain references to other packages. Each referenced package will be
| recursively loaded when the main package is loaded.
|
*/

$config['packages']['validation']['jquery']= '';
$config['packages']['validation']['js'] = array(
						$config['system_js'].'jquery-plugin/validate-1.9/jquery.validate.js',	
						$config['system_js'].'jquery-plugin/validate-1.9/additional-methods.js',	
						$config['system_js'].'common/validation-common.js'
						);
						
$config['packages']['lightboxme']['jquery']= '';
$config['packages']['lightboxme']['css'] = array(
						$config['system_js'].'jquery-plugin/lightboxme-2.3/customeAlert.css'
						);		
if($lang != 'admin'){				
	$config['packages']['lightboxme']['js'] = array(
						$config['system_js'].'jquery-plugin/lightboxme-2.3/jquery.lightboxme.js',							
						$config['system_js'].'common/lightboxme-common.js'
						);
}else{
	$config['packages']['lightboxme']['js'] = array(
						$config['system_js'].'jquery-plugin/lightboxme-2.3/jquery.lightboxmev1.js',							
						$config['system_js'].'common/lightboxme-common.js'
						);
}

$config['packages']['wysiwyg']['jquery']= '';
$config['packages']['wysiwyg']['css'] = array(
						$config['system_js'].'jquery-plugin/wysiwyg-0.5/wysiwyg.css',	
						);	
$config['packages']['wysiwyg']['js'] = array(
						$config['system_js'].'jquery-plugin/wysiwyg-0.5/jquery.wysiwyg.js',							
						$config['system_js'].'common/wysiwyg-common.js'
						);
						
//$config['packages']['nic']['jquery']= 'bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });';
$config['packages']['nic']['js'] = array(
						$config['system_js'].'jquery-plugin/niceditor/nicEdit.js',							
						);
	



if($lang != 'admin'){
    
	$config['packages']['datepicker']['js'] = array(
						$config['system_js'].'jquery-plugin/datepicker/js/jq-core.js',							
						$config['system_js'].'jquery-plugin/datepicker/js/jq-widget.js',							
						$config['system_js'].'jquery-plugin/datepicker/js/jq-datepicker.js',
						$config['system_js'].'jquery-plugin/datepicker/js/jq-datepicker_monthyear.js',
						$config['system_js'].'R&D/localization/messages_'.$lang.'.js'					
						);
}else{
    
    $config['packages']['datepicker']['css'] = array(
                            $config['system_js'].'jquery-plugin/datepicker/datepicker.css'		
    );	
    
    //only for admin
    $config['packages']['tipsy']['css'] = array(
                        $config['system_js'].'jquery-plugin/tipsy-1.0/tipsy.css',			
                        );	
    $config['packages']['tipsy']['js'] = array(
                        $config['system_js'].'jquery-plugin/tipsy-1.0/jquery.tipsy.js',							
                        $config['system_js'].'common/tipsy-common.js'
                        );	
    
	$config['packages']['datepicker']['js'] = array(
						$config['system_js'].'jquery-plugin/datepicker/js/jq-core.js',							
						$config['system_js'].'jquery-plugin/datepicker/js/jq-widget.js',							
						$config['system_js'].'jquery-plugin/datepicker/js/jq-datepicker.js',
						$config['system_js'].'jquery-plugin/datepicker/js/jq-datepicker_monthyear.js',
						);
}
												
$config['majorwork'] = array('filmNvideo'=>1,'writingNpublishing'=>6);
$config['eventShownForExtraDays'] = '-1 month';
$config['setExpiryDays'] = 7;
$config['postLaunchNotificationType'] = 'postLaunch';
$config['setExpiryWorkProfile'] = 15;


//media file types
$config['file_type_1'] = 'Image';
$config['file_type_2'] = 'Audio Visual';
$config['file_type_3'] = 'Audio';
$config['file_type_4'] = 'Text';

// set age criteria difference
$config['agedifferenc'] = '5';

//set competition media default icon

$config['defaultAudioIcon'] =  'images/default_thumb/audio_icon.png';
$config['defaultDocxIcon'] =  'images/default_thumb/docx_icon.png';
$config['defaultPdfIcon'] =  'images/default_thumb/pdf_icon.png';

$config['filmNvideoHelpPage'] = 'dashboard/help_filmvideo'; 
$config['musicNaudioHelpPage'] = 'dashboard/help_musicaudio';
$config['photographyNartHelpPage'] = 'dashboard/help_photographyart'; 
$config['writingNpublishingHelpPage'] = 'dashboard/help_writingpublishing'; 
$config['newsHelpPage'] = 'dashboard/help_writingpublishing'; 
$config['reviewsHelpPage'] = 'dashboard/help_writingpublishing';
$config['educationMaterialHelpPage'] = 'dashboard/help_educationalmaterial.php';
$config['competitionHelpPage'] = 'dashboard/help_competition';

//Set Advert upload files
$config['advertFileAccept'] = 'gif|jpeg|jpg|png|swf|mov|rm';
$config['advertFileType'] = 'gif,jpeg,jpg,png,swf,mov,rm';

/*
 **************************************************************************** 
 * New version package config define start 
 **************************************************************************** 
 */ 

//tempalte new directory name
$config['template_new']					= 'new_version';
$config['template_directory']       	= 'templates';

$config['template_new_css'] 			  = 'templates/'.$config['template_new'].'/css/';
$config['template_new_font_css'] 		= 'templates/'.$config['template_new'].'/fonts/';
$config['template_new_js'] 				  = 'templates/'.$config['template_new'] .'/js/';
$config['template_new_images'] 			= 'templates/'.$config['template_new'].'/images/';

$config['template_new_valiation'] 			= 'templates/system/javascript/jquery-plugin/validate-1.9/';
$config['template_new_lightbox'] 			  = 'templates/system/javascript/';



//-------rating image path-----------------------------//

$config['rating_images_path']      =  'templates/new_version/images/rating/';  //set rating image path

//----------your toadsquare crave menu order-----------------//

$config['your_toadsquare_crave_menu'] = array(
    'yourshowcase'                  =>  array('creatives','associatedprofessionals','enterprises'),
    'mediashowcases'                =>  array('filmNvideo','musicNaudio','photographyNart','educationMaterial','news','reviews','upcoming'),
    //'yourhomepage'                =>  array('creatives','associatedprofessionals','enterprises'),
    'performancesevents'            =>  array('performancesevents'),
    'blog'                          =>  array('blog'),
    'competitions'                  =>  array('competitions'),
    'competitionentries'            =>  array('competitionentries'),
    'workofferedclassifieds'        =>  array('11:1'),
    'workwantedclassifieds'         =>  array('11:2'),
    'productforsaleclassifieds'     =>  array('12:1'),
    'productwantedclassifieds'      =>  array('12:2'));


//------------------------//



// 
/* End of file head.php */
/* Location: ./application/config/head.php */
