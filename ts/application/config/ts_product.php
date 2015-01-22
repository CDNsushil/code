<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['toadCurrencySgine'] = '&euro;';
$config['toadCurrency'] = 'EUR';
$config['defaultContainerStorageSpace_MB'] = 100;
$config['defaultContainerStorageSpace_Byets'] = 104857600;
$config['defaultContainerStorageSpace'] = '100 MB';
$config['defaultUnitofStorageSpace_freeMember'] = '100 MB';
$config['defaultUnitofStorageSpace_freeMember_MB'] = 100;
$config['defaultPrice_per_unitofStorageSpace_freeMember'] = '&euro;0.80';
$config['defaultPrice_per_unitofStorageSpace_freeMember_EURO'] = 0.80;

$config['defaultStorageSpace_paidMember'] = '50 GB';
$config['defaultStorageSpace_paidMember_GB'] = 50;
$config['defaultStorageSpace_paidMember_Byets'] = '53687091200';
$config['defaultUnitofStorageSpace_paidMember'] = '10 GB';
$config['defaultUnitofStorageSpace_paidMember_GB'] = 10;
$config['defaultPrice_per_unitofStorageSpace_paidMember'] = '&euro;50';
$config['defaultPrice_per_unitofStorageSpace_paidMember_EURO'] = 50;
$config['defaultMediaContainerPrice_EURO'] = 10;
$config['defaultMediaContainerPrice'] = '&euro;10';

$config['defaultContainerLife'] = 12;
$config['MS1Y_ContainerLife'] = 12;
$config['MS3Y_ContainerLife'] = 36;

$config['MSD_PkgeId'] = 1;
$config['MS1Y_PkgeId'] = 16;
$config['MS3Y_PkgeId'] = 17;


$config['tsProductId_MediaShowcase'] = 18;
$config['MSD_PkgeRoleId_MediaShowcase'] = 38;
$config['MS1Y_PkgeRoleId_MediaShowcase'] = 57;
$config['MS3Y_PkgeRoleId_MediaShowcase'] = 81;

/*
*---------------------------------------------------------
*  Toadsquare available package types and its id for static use
*  Already defined in database
*--------------------------------------------------------- 
*/

//packages types in database tables id
$config['package_free_id'] 			= '1';
$config['package_media_id'] 	    = '5';
$config['package_1_year_id'] 		= '16';
$config['package_3_year_id'] 		= '17';

//packages types in package database tables
$config['package_free'] 		  	= '0'; # free id use in dabatabase
$config['package_1_year'] 			= '1'; # 1 year id use in dabatabase
$config['package_3_year'] 			= '3'; # 3 year id use in dabatabase

//packages types we using for our section
$config['package_type_1'] 		 	= '1'; # free package
$config['package_type_2'] 			= '2'; # 1 year package
$config['package_type_3'] 			= '3'; # 3 year package

//membership default space for 1 year and 3 year
$config['package_membership_default_space'] 		 	= '50'; // 50 GB

//packages title
$config['package_title_1'] 		 	= 'Free Toadsquare Membership'; # free package
$config['package_title_2'] 			= 'Annual Toadsquare Membership'; # 1 year package
$config['package_title_3'] 			= '3 Year Toadsquare Membership'; # 3 year package

//packages price
$config['package_1_year_price'] 		=  '99';  # 1 year price
$config['package_3_year_price'] 		=  '199'; # 3 year price
$config['package_vat_percent']          =  '15';  # vat percent

//promo code
$config['master_promo_code'] 		    =  '8sOpBEQ4Pm';  # 1 year price

//-------memerbship renew and downgrade days-----------//
$config['renew_button_before_day']        =  '- 30 day';  # renew button show days before expiry date
$config['downgrade_button_after_day']     =  '+ 15 day';  # donwgrade button show days after purchase 

//---------membership order type------------//
$config['membership_order_type_1']    =  '1';  //New container
$config['membership_order_type_2']    =  '2';  //Refund Container
$config['membership_order_type_3']    =  '3';  //Membership
$config['membership_order_type_4']    =  '4';  //Refund Membership

//---------membership item type----------//
$config['membership_item_type_1'] 		=   '1';  //New container
$config['membership_item_type_2'] 		=   '2';  //Add Space container space/ membership space are same
$config['membership_item_type_3'] 		=   '3';  //Renew container
$config['membership_item_type_4'] 		=   '4';  //New-Membership
$config['membership_item_type_5'] 		=   '5';  //Refund-Membership
$config['membership_item_type_6'] 		=   '6';  //Upgrade-Membership
$config['membership_item_type_7'] 		=   '7';  //Renew-Membership
$config['membership_item_type_8'] 		=   '8';  //Downgrade-Membership
$config['membership_item_type_9'] 		=   '9';  //membership space renew
$config['membership_item_type_10'] 		=   '10'; //add Space In Membership

//---------default campaign impression for 1 year/ 3 year plan selected users-------------//

$config['campagin_impression_count']  =  '1000';  //define default impression count for campagin

$config['package_default_campaign']   =  '5';  //default package campaign 

//--------default container not allow for 1 year/ 3 year plan selected users--------------//

$config['free_user_default_container']   =  array('1','3','4','5','8','9','10','13','14','15','16','17','18','22');  // free user tdProductId 

$config['paid_user_default_container']   =  array('1','3','4','5','8','17','22');  // 1/3 year user tdProductId 

$config['default_container_not_allow']   =  array('9','10','13','14','15','16','18');  // tdProductId 

//-------non actived package not allow in default while register user---------------//

$config['not_activated_package_not_allow']   =  array('2','8');  // tdProductId 

//----- media vat percentage -----------------------//
$config['media_vat_percent']      =  '15';  # vat percent

//----- toadsquare product Ids -----------------------//
$config['ts_product_id_media']      =  '18';  // media showcase
$config['ts_product_id_free_user']  =  '20';  // free subscription
$config['ts_product_id_paid_user']  =  '28';  // paid subscription

$config['FvCollectionCatId'] = 1;
$config['MaAlbumCatId'] = 3;
$config['MaCollectionCatId'] = 5;
$config['WpCollectionCatId'] = 6;
$config['PaAlbumCatId'] = 7;
$config['PaCollectionCatId'] = 9;
$config['EmCorseCatId'] = 12;
$config['launchCatId'] = 12;
$config['launchCatId'] = 13;
$config['eventCatId'] = 14;
$config['newsCatId'] = 15;
$config['reviewsCatId'] = 16;

$config['filmnvideoSectionId'] = $config['filmNvideoSectionId'] = 1; 
$config['musicnaudioSectionId'] = $config['musicNaudioSectionId'] = 2;
$config['writingnpublishingSectionId'] = $config['writingNpublishingSectionId'] = 3;
$config['newsSectionId'] = '3:1';
$config['reviewsSectionId'] = '3:2';
$config['photographynartSectionId'] = $config['photographyNartSectionId'] = 4; 
$config['performingartsSectionId'] = 5; 
$config['creativesSectionId'] = $config['creativeSectionId'] = 6; 
$config['associateprofessionalSectionId'] = $config['professionalSectionId'] = 7; 
$config['enterprisesSectionId'] = $config['businessSectionId'] = 8;
$config['fansSectionId'] =  $config['fanSectionId'] = 34;
$config['performancesneventsSectionId'] = 9; 
$config['eventNotificationsSectionId'] = '9:1';
$config['eventsSectionId'] = '9:2';
$config['launchesSectionId'] = '9:3';
$config['eventswithLaunchSectionId'] = '9:4'; 

$config['sectionIdImage9'] = 'Media1_110x73.jpg'; 
$config['educationmaterialSectionId'] = $config['educationMaterialSectionId'] = 10; 
$config['worksSectionId'] = 11; 
$config['productsSectionId'] = 12;
$config['productsSellSectionId'] = '12:1';
$config['productsWantedSectionId'] = '12:2';
$config['productClassifiedFreeSectionId'] = '12:3';
$config['collaborationSectionId'] = 15;
$config['blogsSectionId'] = 13;
$config['workprofileSectionId'] = 14; 
$config['competitionSectionId'] = 16;  
$config['competitionEntrySectionId'] = '16:1';
$config['upcomingSectionId'] = 17;
$config['advertiseSectionId'] = 24; 
$config['cravesSectionId'] = 25; 
$config['otherProjectsSectionId'] = 26; 
$config['buyersCommentsSectionId'] = 27; 
$config['forumSectionId'] = 28; 
$config['searchSectionId'] = 29; 
$config['reportProblemSectionId'] = 30;
$config['descriptionofServicesSectionId'] = 31;
$config['workProfileAppSectionId'] = 32;
$config['meetingPointAppSectionId'] = 33;

$config['industryForSectionId1'] = 'filmNvideo';
$config['industryForSectionId2'] = 'musicNaudio';
$config['industryForSectionId3'] = 'writingNpublishing'; 
$config['industryForSectionId3_1'] = 'news';
$config['industryForSectionId3_2'] = 'reviews';
$config['industryForSectionId4'] = 'photographyNart'; 
$config['industryForSectionId10'] = 'educationMaterial';

$config['mediaUpcomingTypeId'] = 1;
$config['EmUpcomingTypeId'] = 2;
$config['PeUpcomingTypeId'] = 3;


//---------media file type ----------//
$config['media_type_image']                 =  '1'; // image
$config['media_type_video']                 =  '2'; // video
$config['media_type_audio']                 =  '3'; // audio
$config['media_type_document']              =  '4'; // document

/* End of file head.php */
/* Location: ./application/config/ts_product.php */
