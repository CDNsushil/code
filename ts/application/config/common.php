<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*---------------  activity ---------------------*/
$config['_activity_comment_'] 					= 5;	
$config['_activity_registration_'] 				= 6;
$config['_activity_create_profile_'] 			= 7;
$config['_activity_post_'] 						= 8;
$config['_activity_friend_'] 					= 9;
$config['_activity_like_'] 						= 10;
$config['_activity_donate_'] 					= 11;
$config['_activity_upload_photo_']				= 13;
$config['_send_message_']						= 14;
$config['_receive_message_']					= 15;
$config['_activity_special_friend_']			= 16;
$config['_activity_profile_view_']				= 17;
$config['_activity_view_album_']				= 18;
$config['_activity_recieve_comment_']			= 20;
$config['_activity_send_invitation_']			= 21;
$config['_activity_page_subscribed_']			= 22;
$config['_activity_tag_photo_']					= 23;
$config['_activity_bulk_send_invitation_']		= 24; // send invitation for 50 or more than 50
$config['_activity_bonus_point_']				= 25;
$config['_activity_profile_complete_']			= 26;
$config['_activity_post_comment_album_']		= 27;
$config['_activity_post_comment_album_photo_']	= 28;
$config['_activity_post_on_friend_wall']		= 29;



/*-----------------User parent level---------------*/
$config['_user_level_first_'] 					= 	1;
$config['_user_level_last_']					=	6; // this key is used for point award upto 6 level 

/*-------------------Language--------------------*/
$config['default_language_code'] 			= 'en';
$config['default_language'] 				= 'english';
$config['default_language_id'] 				= '1';
	
/*-------------------album-----------------------*/
$config['_album_perpage_'] 			= 6;
$config['_point_summery_box'] = 2; 
$config['_point_detail_box'] = 1;

/*-------------------notification-----------------------*/
$config['_notification_views_your_profile'] = 18;

/*-------------------No of post in user wall/ Activity stream-----------------------*/
$config['number_of_post_user_wall_and_activity_stream'] = 10;
$config['number_of_post_on_page'] = 10;



/*-------------------action_category-----------------------*/
$config['__group__']             = 2;
$config['__celebrity_page__']    = 3;
$config['__charity_page__']      = 4;
$config['__business_page__']     = 5;
$config['__charity_profile__']   = 6;

/*-------------------action type-----------------------*/
$config['image']             = 1;
$config['status_update']     = 2;
$config['link']              = 3;
$config['video']             = 4;
$config['comment']           = 5;
$config['like']              = 6;
$config['album']             = 7;
$config['donate_points']     = 11;
$config['friendship']        = 12;
$config['subscribe_to_page'] = 13;
$config['join_group']        = 14;
$config['milestone']         = 15;



/******************** Amazon S3 image upload size  *************************/
/******************** User section ************************/
$config['__1024X768__']   	= 1024;
$config['__215X225__']   	= 215;
$config['__78X78__']   		= 78;
$config['__68X68__']   		= 68;
$config['__46X46__']   		= 46;
$config['__40X40__']   		= 40;
$config['__32X31__']   		= 32;
$config['__18X18__']   		= 18;

/******************** Album section ************************/
$config['__92x88__']    = 92;     // wall section thumbnail display
$config['__350x188__']  = 350;    //wall section (top)
$config['__131x94__']   = 131;    //wall section (top)
$config['__190x198__']  = 190;    //album section cover photo thumbnail
$config['__184x200__']  = 184;    //album photo section photo thumbnail
$config['__746x556__']  = 746;    //album photo popup
$config['__56x56__']    = 56;     //edit album popup thumnail
$config['__137x99__']   = 137;    //most recent picture in the bottom of album section
$config['__186x238__']  = 186;    //for right section
$config['__186x132__']  = 186 ;   //for right section
/*----------for page section album----------*/
$config['__275x295__']  = 275 ;   //for right section
$config['__294x178__']  = 294 ;   //for right section

$config['__89x88__']    = 89 ;     //for right section
$config['__118x133__']  = 118 ;  //for right section
$config['__568x205__']  = 568 ;  //for right section
$config['__86x116__']   = 86 ;    //for business page news section
$config['__177x69__']   = 177 ;    //for charity page project section
$config['__183x99__']   = 183 ;    //for celebrity page project section

/*-------------------Auto updater config vaiables -----------------------*/
$config['ticker_index']             = 'ticker';
$config['incomming_msg_index']      = 'incomming_msg';
$config['new_msg_index']            = 'new_msg';
$config['new_msg_user_id_index']    = 'new_msg_user_id';
$config['point_calculation_index']  = 'point_calculation';
$config['new_post_index']  			= 'new_post';
/*------------------- Time zone setting -----------------------*/
$config['ip_info_api_key']  = '1427b4b3fa1d9a60c55027e20e08cd6197921781581dd520773d3fc44aa96453';

/*------------------- my network slider user image count -----------------------*/
$config['my_network_level_user_image_count']  = 12;

/*------------------- auto update DB Detail -----------------------*/
$config['auto_updater_db']='chatching.sqlite';
$config['auto_updater_db_path']  = ABSOLUTE_PATH.'/nodeSys/php/'.$config['auto_updater_db'];

/*secret token for Right Session API*/
$config['right_signature_secure_token'] = 'tbkVy4zzm0kOPapwHG5fG16VdMdvbosWtMKjQ0sX';


/*chatching advertisment image for facebook app  */
$config['cc_adv_img_for_fb'] = 'adventising-facebook.jpg';


