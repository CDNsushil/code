<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
	The 'App Area' allows you to specify the base folder used for all of
	the contexts in the app. By default, this is set to '/admin', but this
	does not make sense for all applications.
*/
define('SITE_AREA', 'admin');
define('SITE_AREA_SETTINGS', 'admin/settings/');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

// application's Users table - define your user table and columns here

define('USER_TABLE_TABLENAME', 'UserAuth u');
define('USER_TABLE_ID', 'u.tdsUid');
//define('USER_TABLE_USERNAME', 'CONCAT(u.first_name, " ", u.last_name) as user_name');
define('USER_TABLE_USERNAME', 'username');

// message statuses
define('MSG_STATUS_UNREAD', 0);
define('MSG_STATUS_READ', 1);
define('MSG_STATUS_ARCHIVED', 2);

// priority
define('PRIORITY_LOW', 1);
define('PRIORITY_NORMAL', 2);
define('PRIORITY_HIGH', 3);
define('PRIORITY_URGENT', 4);

// status return message codes
define('MSG_SUCCESS', 0);
define('MSG_ERR_GENERAL', 1);
define('MSG_ERR_INVALID_USER_ID', 2);
define('MSG_ERR_INVALID_MSG_ID', 3);
define('MSG_ERR_INVALID_THREAD_ID', 4);
define('MSG_ERR_INVALID_STATUS_ID', 5);
define('MSG_ERR_INVALID_SENDER_ID', 6); 
define('MSG_ERR_INVALID_RECIPIENTS', 7);
define('MSG_MESSAGE_SENT', 8);
define('MSG_STATUS_UPDATE', 9);
define('MSG_PARTICIPANT_ADDED', 10);
define('MSG_ERR_PARTICIPANT_EXISTS', 11);
define('MSG_ERR_PARTICIPANT_NONSYSTEM', 12);
define('MSG_PARTICIPANT_REMOVED', 13);
define('TEMPLATE_IMG', 'templates/new_version/images/');
$masterTable=array(
    'TDS_AddInfoEventCollabMapping' => 1,
    'TDS_AddInfoInterview' => 2,
    'TDS_AddInfoNews' => 3,
    'TDS_AddInfoReviews' => 4,
    'TDS_AssociativeCreatives' => 5,
    'TDS_EmDocumentType' => 6,
    'TDS_EmElement' => 7,
    'TDS_EventMedia' => 8,
    'TDS_Events' => 9,
    'TDS_EventSessions' => 10,
    'TDS_EventSupportedLinks' => 11,
    'TDS_FvElement' => 12,
    'TDS_FvMediaType' => 13,
    'TDS_Genre' => 14,
    'TDS_LaunchEvent' => 15,
    'TDS_LogCrave' => 16,
    'TDS_login_attempts' => 17,
    'TDS_LogInvite' => 18,
    'TDS_LogSummary' => 19,
    'TDS_LogRating' => 20,
    'TDS_LogShare' => 21,
    'TDS_LogShow' => 22,
    'TDS_LogUserActivity' => 23,
    'TDS_LogViews' => 24,
    'TDS_MaElement' => 25,
    'TDS_MasterCity' => 26,
    'TDS_MasterCountry' => 27,
    'TDS_MasterEmailTemplate' => 28,
    'TDS_MasterEventNature' => 29,
    'TDS_MasterIndustry' => 30,
    'TDS_MasterInitialContainer' => 31,
    'TDS_MasterLang' => 32,
    'TDS_MasterNotification' => 33,
    'TDS_MasterPackage' => 34,
    'TDS_MasterPackgesRole' => 35,
    'TDS_MasterRating' => 36,
    'TDS_MasterSocialMedia' => 37,
    'TDS_MasterSubscription' => 38,
    'TDS_MasterTicketCategories' => 39,
    'TDS_MasterUserRole' => 40,
    'TDS_MasterWorkIndustry' => 41,
    'TDS_MediaFile' => 42,
    'TDS_Notification' => 43,
    'TDS_NotificationSetting' => 44,
    'TDS_Offers' => 45,
    'TDS_PaDocumentType' => 46,
    'TDS_PaElement' => 47,
    'TDS_ProdCategory' => 48,
    'TDS_Product' => 49,
    'TDS_ProductPromotionMedia' => 50,
    'TDS_ProectjRating' => 51,
    'TDS_ProfileEmpHistory' => 52,
    'TDS_ProjCategory' => 53,
    'TDS_Project' => 54,
    'TDS_ProjectPromotion' => 55,
    'TDS_ProjectShipping' => 56,
    'TDS_SalesBasketItem' => 57,
    'TDS_SalesCustomersBasket' => 58,
    'TDS_SalesItemDownload' => 59,
    'TDS_SalesItemShipping' => 60,
    'TDS_SalesOrder' => 61,
    'TDS_SalesOrderItem' => 62,
    'TDS_SettingGlobal' => 63,
    'TDS_SupportLink' => 64,
    'TDS_TicketPriceSchedule' => 65,
    'TDS_Tickets' => 66,
    'TDS_TLabel' => 67,
    'TDS_tmail_threads' => 68,
    'TDS_tmail_messages' => 69,
    'TDS_tmail_attachment' => 70,
    'TDS_UpcomingProject' => 71,
    'TDS_UpcomingProjectMedia' => 72,
    'TDS_UserAuth' => 73,
    'TDS_UserContacts' => 74,
    'TDS_UserContainer' => 75,
    'TDS_UserPackage' => 76,
    'TDS_UserPaymentProfile' => 77,
    'TDS_UserProfile' => 78,
    'TDS_UserSearchProfile' => 79,
    'TDS_UserSocialProfile' => 80,
    'TDS_UserSubscription' => 81,
    'TDS_Work' => 82,
    'TDS_WorkApplication' => 83,
    'TDS_WpElement' => 84,
    'TDS_WpMediaType' => 85,
    'TDS_WorkProfile' => 86,
    'TDS_profileEmpHistory' => 87,
    'TDS_ProfileMedia' => 88,
    'TDS_profileRecommendation' => 89,
    'TDS_profileSocialLink' => 90,
    'TDS_profileSocialMediaIcon' => 91,
    'TDS_workPromotionMedia' => 92,
    'TDS_UserShowcase' => 93,
    'TDS_NewsElement' => 94,
    'TDS_ReviewsElement' => 95, 
    'TDS_Posts' => 96,
    'TDS_Blogs' => 97,
    'TDS_PostGallery' => 98,
    'TDS_WorkProfileUrlRequest' =>99,
    'TDS_UserShowcaseLang' =>100,
    'TDS_PressReleaseNews' =>101,
    'TDS_Competition' =>102,
    'TDS_CompetitionEntry' =>103,
    'tds_ox_campaigns' =>104,
    'TDS_Collaboration' =>105,
    'TDS_CollaborationTasks' =>106,
);

$craveTypeOrder = array('all','creatives','associatedprofessionals','enterprises','blog','filmNvideo','musicNaudio','photographyNart','writingNpublishing','news','reviews','performancesevents','educationMaterial','upcoming','work','product');

$masterMedia = array(''=>'Media Type','2'=>'Video','3'=>'Audio','4'=>'Writing');
/* End of file constants.php */
/* Location: ./application/config/constants.php */
