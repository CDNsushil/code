<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/**
 * --------------------------
 * Config: CI_version
 * --------------------------
 * Default value:
 * $config['CI_version'] = '2.x';
 * 
 * Option for this config is: 1.x, and 2.x
 */
$config['codeigniter_version'] = '2.x';

/**
 * --------------------------
 * Config: Multi language
 * --------------------------
 * Default value:
 * $config['multilang'] = FALSE;
 * 
 * If TRUE than replacer can be set to another language.
 * Don't forget to load CI language class on your controller, for example: $this->lang->load('breadcrumb', 'indonesian'); 
 * For configuration please refer to $config['replacer'] doc and $config['partial_replace'] doc below.
 */
$config['multilang'] = TRUE;

/**
 * ------------------------
 * Config: set home
 * ------------------------
 * Default value:
 * $config['set_home'] = "Home";
 * 
 * Change initial breadcrumb link. 
 * If set to empty e.g: $config['set_home'] = "";
 * then initial/home breadcrumb will disappear
 * 
 */
$config['set_home'] = "";
//$config['set_home'] = "Home";

/**
 * ------------------------
 * Config: attribute home
 * ------------------------
 * Default value:
 * $config['attr_home'] = array();
 * 
 * Apply attribute to initial or home link, e.g: 
 * $config['attr_home'] = array('style' => 'text-decoration:none', 'class' => 'home_breadcrumb');
 * Only work if unlink_home is set to FALSE
 */
$config['attr_home'] = array('class'=>'speciallink');

/**
 * ------------------------
 * Config: unlink home
 * ------------------------
 * Default value:
 * $config['unlink_home'] = FALSE;
 *
 * If set to TRUE then your home will have no link
 */
$config['unlink_home'] = FALSE;

/**
 * -----------------------
 * Config: Delimiter
 * ------------------------
 * Default value:
 * $config['delimiter'] = ' > ';
 */
$config['delimiter'] = "<label class='breadcrumbDelimiter_arrow_orange'>&nbsp;</label> ";

/**
 * --------------------------
 * Config: Replacer
 * --------------------------
 * Default value:
 * $config['replacer'] = array();
 *
 * Replacer have some usefull function, e.g:
 *
 * 1. Change link label
 * 
 * Example:
 * =======
 * URL = http://localhost/arstock/warehouse/stocks/search_direct
 * $config['replacer'] = array('search_direct' => 'edit');
 * Breadcrumb = Home > Warehouse > Stocks > Edit
 *
 * 2. Hide link
 * 
 * Example:
 * =======
 * URL = http://localhost/arstock/warehouse/stocks/search_direct
 * $config['replacer'] = array('search_direct' => 'edit', 'warehouse' => '');
 * Breadcrumb = Home > Stocks > Edit
 *
 * 3. Change URL (since version 5.10.1)
 * 
 * Example:
 * =======
 * URL = http://localhost/arstock/warehouse/stocks/search_direct
 * $config['replacer'] = array('search_direct' => 'edit', 'warehouse' => array('/dept_warehouse|warehouse department'));
 * Breadcrumb = Home > Warehouse Department > Stocks > Edit
 * Warehouse Department's url = http://localhost/arstock/dept_warehouse/
 *
 * 4. Add new crumbs (since version 5.10.1)
 * 
 * Example:
 * =======
 * URL = http://localhost/arstock/warehouse/stocks/search_direct
 * $config['replacer'] = array('search_direct' => 'edit', 'warehouse' => array('/dept_list|departments', 'warehouse department'), 'stocks' => array('stocks', '/warehouse/action_list|actions'), 'edit' => array('edit', 'item 1', 'item_2|item 2'));
 * Breadcrumb = Home > Departments > Warehouse Department > Stocks > Actions > Edit > Item 1 > Item 2
 * Departments' url 			= http://localhost/arstock/dept_list/
 * Warehouse Department's url 	= http://localhost/arstock/warehouse/
 * Stocks' url 					= http://localhost/arstock/warehouse/stocks
 * Actions' url 				= http://localhost/arstock/warehouse/action_list
 * Edit's url 					= http://localhost/arstock/warehouse/stocks/edit
 * Item 1's url 				= http://localhost/arstock/warehouse/stocks/edit
 * Item 2's url 				= http://localhost/arstock/warehouse/stocks/edit/item_2
 * 
 * 5. Multilanguage support (since version 9.10.1)
 * 
 * Example:
 * ========
 * Let's see an example on feature number 4. If you set $config['multilang'] = TRUE than your replacer should be change to:
 * $config['replacer'] = array('search_direct' => 'edit', 'warehouse' => array('/dept_list|departments', 'warehouse_department'), 'stocks' => array('stocks', '/warehouse/action_list|actions'), 'edit' => array('edit', 'item_1', 'item_2|item_2'));
 * and don't forget to add lang files as well, your breadcrumb_lang.php should contain variable that replace link name depend on language selected. For this example:
 * lang['edit'] = 'some text';
 * lang['departments'] = 'some text'; 
 * lang['warehouse_department'] = 'some text';
 * lang['stocks'] = 'some text';
 * lang['actions'] = 'some text';
 * lang['item_1'] = 'some text';
 * lang['item_2'] = 'some text';
 * Don't forget to load CI language class on your controller, for example: $this->lang->load('breadcrumb', 'indonesian'); 
 * 
 * New since v12.01.1 :
 * Now, we don't have to declare our link name first to use multilanguage, example:
 * URL = http://localhost/arstock/warehouse/stocks/search_direct
 * $config['replacer'] = array();
 * breadcrumb_lang.php :
 * 		lang['warehouse'] = 'Gudang';
 * 		lang['stocks'] = 'Stok';
 * So, your breadcrumb now will be : Home > Gudang > Stok > Search Direct
 */

$config['replacer'] = array(
"home"=>"",
"en"=>"",
"index"=> "",
"showcase"=> "Showcase",
"showcasehomepage"=> "Showcase Homepage",
"mediafrontend"=>"showcase",
"viewelement"=>"View Element",
"searchform"=>"",
"searchresult"=>"",
"writingpublishing"=>"Writing & Publishing",
"filmvideo"=>"Film & Video",
"musicaudio"=>"Music & Audio",
"photographyart"=>"Photography & Art",
"educationmaterial"=>"Educational Material",
"auth"=>"Login",
"media"=>"",
"posts"=>"post",
"galleryimages"=>"Media Gallery",
"filmNvideo"=>"Film & Video",
"uploadMedia"=>"Uploads & Pricing",
"newProject"=>"New Project",
"editProject"=>"Edit Project",
"projectDescription"=>"Project Description",
"furtherDescription"=>"Further Description",
"furtherDescription"=>"Further Description",
"musicNaudio"=>"Music & Audio",
"writingNpublishing"=>"Writing & Publishing",
"photographyNart"=>"Photography & Art",
"deletedItems"=>"Deleted & Expired Tools",
"addMoreReferencesRecommendations"=>"Add References & Recommendations",
"educationMaterial"=>"Educational Material",
"empHistoryListing"=>"Employment History",
"workProfileForm"=>"Personal Details",
"showSocialMediaLinks"=>"Social Media Links",
"addMoreEmpHistory"=>"Add Employment History",
"addMoreInformation"=>"Product Information",
"addMoreSaleImage"=>"Product Promotional Image(s)",
"addMoreSaleVideo"=>"Product Promotional Video",
"sale"=>"Sell",
"freeStuff"=>"Free",
"addMoreSocialLinks"=>"Add Social Media Links",
"addMoreWork"=>"Work Information",
"addMoreImages"=>"Work Promotional Image(s)",
"addMoreVideo"=>"Work Promotional Video",
"workAppliedFor"=>"Applications Sent",
"workProfile"=> "Work Profile",
"showcaseForm"=> "Description",
"additionalInfoForm"=> "PR Material",
"blogForm"=> "About Your Blog",
"postForm"=> "New Post",
"showArchives"=> "Deleted Posts",
"workprofile"=> "Work Profile Index",
"workshowcase"=> "Work Showcase",
"showWorkShowcaseVideos"=> "Videos",
"addMoreVideos"=> "Add Video",
"showWorkShowcaseAudios"=> "Audios",
"addMoreAudios"=> "Add Audio",
"showWorkShowcaseWrittenMaterial"=> "Written Material",
"addMoreWrittenMaterial"=> "Add Written Material",
"showWorkShowcaseImages"=> "Images",
"addMoreImages"=> "Add Image",
"newupcomingprojects"=> "Description",
"upcomingprojects"=> "Upcoming Index",
"addPromotionalImages"=> "Promotional Material",
"addPromotionalVideo"=> " Supported Media",
"workApplicationsReceived"=> "Applications Received",
"projectPromotionalImages"=> "Promotional Images",
"additionalInformation"=> "PR Material",
"eventform"=> "Event Description",
"eventFurtherDesc"=> "Promotional Material",
"eventAdditionalInfoForm"=> "PR Material",
"postchild"=> "New Post",
"eventwithlaunch"=> "Events with Launch",
"eventLaunchList"=> "Events with Launch", 
"frontpost"=> "Post",
"launchwithevent"=> "Events with Launch",
"eventwithlaunchdetail"=> "",
"eventlaunchdetail"=> "Launch",
"eventNotifications"=> "Event Notifications",
"eventnotifications"=> "Event Notifications Index",
"eventsindex"=> "Event Index",
"launchesindex"=> "Launch Index",
"eventwithlaunchindex"=> "Event with Launch Index",
"notificationslist"=> "",
"launchlist" =>"",
"eventlaunchlist"=>"",
"eventlist"=>"",
"eventdetail"=> "",
"event"=> "",
"eventprmaterial"=> "PR Material",
"eventsession"=> "Ticket & Session Details",
"events"=> "Event",
"launchpostprimg"=> "Post&#8211;Launch PR",
"launchdetail"=> "",
"launch"=> "Launch",
"product"=> "Products",
"launcheventform"=> "Launch Description",
"upcomingfrontend"=> "Showcase",
"blogshowcase"=> "Showcase",
"productshowcase"=> "Showcase",
"frontBlogSummary"=> "Blog",
"blogs"=> "Blog",
"frontArchivesPost"=> "Posts",
"frontcatposts"=> "Posts",
"frontPostDetail"=> "Post",
"childposts"=> "Child Posts",
"workshowcase"=> "Portfolio",
"viewproject"=> "View Project",
"launchpromomaterial"=> "Promotional Material",
"launchprmaterial"=> "PR Material",
"launchsession"=> "Ticket & Session Details",
"aboutme"=> "About Me",
"introductoryvideo"=> "Introductory Video",
"developementpath"=> "Developement Path",
"recommendationsgiven"=> "Recommendations Given",
"recommendations"=> "Recommendations Received",
"eventfrontend"=> "Showcase",
"eventnotification"=> "Event Notifications",
"userpckgstouser"=> "User Packages",
"usermeetingpoint"=> "Performances & Events",
"performancesnevents"=> "Performances & Events",
"sessionTickets"=> "Session Time & Tickets",
"Sell" => "For Sale",
"craveslist"=> "My Craves",
"package"=> "Membership",
"packageinformation"=> "Information",
"buytools"=> "Buy Tools",
"externalnews"=> "External Site",
"frontblog"=> "Blog",
"information"=> "Information",
"messagecenter"=> "Message Centre",
"notifications"=> "Notifications",
"socialMedia"=> "Social Media Links",
"educationalmaterial"=> "Educational Material",
"loadPage"=> "",
"containers"=> "",
"welcome_showcase"=> "Showcase Homepage",
"welcome_workprofile"=> "Work Profile",
"welcome_upcoming"=> "Upcoming",
"welcome_blog"=> "Blog",
"welcome_filmvideo"=> "Film & Video",
"welcome_musicaudio"=> "Music & Audio",
"welcome_photographyart"=> "Photography & Art",	
"welcome_writingpublishing"=> " Writing & Publishing",	
"welcome_performancesevents"=> "Performances & Events",	
"welcome_educationMaterial"=> "Educational Material",	
"welcome_work"=> "Work",	
"welcome_products"=> "Products",	
"purchasedsession"=> "Purchased Tickets",	
"meetingpoint"=> "Meeting Point",	
"globalsettings"=> "Global Settings",
"report_a_problem"=> "Report a Problem",	
"downloadfile"=> "Download File",
"ppvfile"=> "View",
"multilingaul_showcase_form"=>"Description",
"buyer_comment"=>"Buyers' Comments",	
"associatedmembers"=>"Associated Members",	
"downloadtandc"=>"Download Terms & Conditions",	
"offered"=>"Offered Index",	
"wanted"=>"Wanted Index",	
"cravingme"=>"Craving Me",	
"cravingmefrontend"=>"Craving Me",	
"competitionlist"=>"Competitions",	
"competition"=>"Competitions",	
"competitionentry"=>"Competition Entry",	
"competitionentrylist"=>"Competition Entries",	
"competitionentryedit"=>"",	
"competitiondeleteditems"=>"Deleted & Expired Tools",	
"entrydeleteditems"=>"Deleted & Expired Tools",	
"competitiongroups"=>"Competitions Group",	
"eventfurtherdescription"=>"Further Description",	
"launchfurtherdescription"=>"Further Description",	
"language1"=>"Language 1",	
"language2"=>"Language 2",	
"criterialang1"=>"Language 1",	
"criterialang2"=>"Language 2",	
"associatedcompetition"=>"Associated Competitions",	
"competitionMedia"=>"Required Media",	
"myplaylist"=>"My Playlist",	
"language1"=>"",	
"language2"=>"",	
"taskDetails"=>"Task Details",
"communicationsDetails"=>"Communications",
"a"=> "",
"b"=> "",
"c"=> "",
"d"=> "",
"e"=> "",
"f"=> "",
"g"=> "",
"h"=> "",
"i"=> "",
"j"=> "",
"k"=> "",
"l"=> "",
"m"=> "",
"n"=> "",
"o"=> "",
"p"=> "",
"q"=> "",
"r"=> "",
"s"=> "",
"t"=> "",
"u"=> "",
"v"=> "",
"w"=> "",
"x"=> "",
"y"=> "",
"z"=> "",
"competitionShortList"=>"Competition Shortlist"
);
$CI = get_instance();
$module=$CI->router->fetch_class();
$moduleMethod=$CI->router->fetch_method();
if($module=='event'){
	if($moduleMethod=='launch' || $moduleMethod=='eventwithlaunch')
		$config['replacer']['event']='Performances & Events';
	else
		$config['replacer']['event']='Event Index';
	$config['replacer']['eventwithlaunch']='Event with Launch Index';
	$config['replacer']['launchwithevent']='Event with Launch Index';
	$config['replacer']['launch']='Launch Index';
	$config['replacer']['events']='';
	$config['replacer']['eventlaunch']='Launch';
}

if($module=='package'){
	$config['replacer']['purchases']='Purchases';
}
if($module=='eventfrontend'){
	$config['replacer']['event']='Event';
	$config['replacer']['events']='';
	$config['replacer']['eventlaunch']='Launch';
}
if($module=='product'){
	$config['replacer']['sell']='For Sale Index';
	$config['replacer']['freeStuff']='Free Index';
}
if($module=='upcomingfrontend'){
	$config['replacer']['viewproject']='Upcoming';
}
if($module=='workshowcase'){
	$config['replacer']['viewproject']='Work';
}
if($module=='productshowcase'){
	$config['replacer']['viewproject']='Product';
}
if($module=='productshowcase'){
	$config['replacer']['product']='Products';
}

/* Change view element to piece,image etc......*/

if($module=='blog'){
	$config['replacer']['blog']='Blog Index';
}

if($module=='mediafrontend' && $moduleMethod=='photographyart'){
	$config['replacer']['viewelement']='image';
}

if($module=='mediafrontend' && $moduleMethod=='musicaudio'){
	$config['replacer']['viewelement']='piece';
}

if($module=='mediafrontend' && $moduleMethod=='filmvideo'){
	$config['replacer']['viewelement']='piece';
}

if($module=='mediafrontend' && $moduleMethod=='writingpublishing'){
	$config['replacer']['viewelement']='piece';
}

if($module=='mediafrontend' && $moduleMethod=='educationmaterial'){
	$config['replacer']['viewelement']='lesson';
}

if($module=='mediafrontend' && $moduleMethod=='news'){
	
	$config['replacer']['viewelement']='Piece';
}

if($module=='mediafrontend' && $moduleMethod=='reviews'){
	$config['replacer']['viewelement']='Piece';
}

if($module=='mediafrontend' && $moduleMethod=='searchresult'){
	$config['replacer']['filmNvideo']='';
}

if($module=='mediafrontend' && $moduleMethod=='searchresult'){
	$config['replacer']['writingNpublishing']='';
}

if($module=='mediafrontend' && $moduleMethod=='searchresult'){
	$config['replacer']['musicNaudio']='';
}

if($module=='mediafrontend' && $moduleMethod=='searchresult'){
	$config['replacer']['photographyNart']='';
}

if($module=='mediafrontend' && $moduleMethod=='searchresult'){
	$config['replacer']['performancesnevents']='';
}

if($module=='mediafrontend' && $moduleMethod=='searchresult'){
	$config['replacer']['educationMaterial']='';
}

if($module=='mediafrontend' && $moduleMethod=='searchresult'){
	$config['replacer']['productNshowcase']='';
}

if($module=='media' && $moduleMethod=='educationMaterial'){
	$config['replacer']['educationMaterial']='Educational Material Index';
}

if($module=='media' && $moduleMethod=='writingNpublishing'){
	$config['replacer']['writingNpublishing']='Writing & Publishing Index';
}

if($module=='media' && $moduleMethod=='photographyNart'){
	$config['replacer']['photographyNart']='Photography & Art Index';
}

if($module=='media' && $moduleMethod=='musicNaudio'){
	$config['replacer']['musicNaudio']='Music & Audio Index';
}

if($module=='media' && $moduleMethod=='filmNvideo'){
	$config['replacer']['filmNvideo']='Film & Video Index';
}

if($module=='media' && $moduleMethod=='photographyNart'){
	$config['replacer']['projectDescription']='Album Description';
}

if($module=='media' && $moduleMethod=='reviews'){
	$config['replacer']['uploadMedia']='Uploads';
}

if($module=='media' && ($moduleMethod=='news' || $moduleMethod=='reviews')){
	$config['replacer']['uploadMedia']='Uploads';
	$config['replacer']['reviews']='Reviews Collection Index';
	$config['replacer']['news']='News Collection Index';
}
if($module=='dashboard' && $moduleMethod=='showcase'){
	$config['replacer']['showcase']='Showcase Homepage';
}
if($module=='showcase'){
	$config['replacer']['showcase']='';
}
if($module=='showcase'  && $moduleMethod=='multilingaul_showcase_form'){
	$config['replacer']['showcase']='Multilingual Showcase';
}

if($module=='cms'){
	$config['replacer']['cms']='';
	$config['replacer']['termsncondition']='Terms & Conditions';
	$config['replacer']['descofservices']='Description of Services';
	$config['replacer']['apps']='Apps';
}
  
/**
 * ------------------------
 * Config: partial replace
 * ------------------------
 * Default value:
 * $config['partial_replace'] = array();
 * 
 * Your link contain acronym? And you feel wasting time by writing replacer one by one? Then this config can save your time.
 * Example: If you have named your controller like: read_tr, delete_tr, edit_tr, post_tr then just write this config
 * $config['partial_replace'] = array('_tr' => 'transaction');
 * Then you will get autocrumb like: read transaction, delete transaction, etc.
 * 
 * New since v12.01.1 :
 * Support multilanguage too. Example:
 * --First please refer to $config['multilang'] for enabling multilanguage feature--
 * For link name read_tr, you can use this config
 * $config['partial_replace'] = array('_tr' => 'transaction', 'read_'=>'read');
 * Your breadcrumb_lang.php should have these variables:
 * $lang['transaction'] = 'Transaksi';
 * $lang['read'] = 'Baca';
 */
$config['partial_replace'] = array();

/**
 * --------------------------
 * Config: Exclude
 * --------------------------
 * Default value:
 * $config['exclude'] = array('');
 *
 * Can hide links that written in array
 * 
 * Example:
 * =======
 * If we set $config['exclude'] = array('stocks', 'warehouse') then from this URL "http://localhost/arstock/warehouse/stocks/insert"
 * we get breadcrumb: Home > Insert
 */
$config['exclude'] = array('');

/**
 * ------------------------------------
 * Config: Exclude Segment
 * ------------------------------------
 * Default value:
 * $config['exclude_segment'] = array();
 *
 * Can hide segments
 * 
 * Example:
 * =======
 * Look at this example URL:
 * http://mysite.com/en/search/results
 * http://mysite.com/fr/search/results
 * If we set $config['exclude'] = array(1) then everything in segment 1 which are 'en' & 'fr' will be hide. We get breadcrumb:
 * Home > Search > Results
 */
$config['exclude_segment'] = array();

/**
 * --------------------------
 * Config: Wrapper
 * --------------------------
 * Default value:
 * $config['use_wrapper'] = FALSE;
 * $config['wrapper'] = '<ul>|</ul>';
 * $config['wrapper_inline'] = '<li>|</li>';
 *
 * We set this if we want to make breadcrumb have it's own style.
 * it possible to return the breadcrumb in a list (<ul><li></li></ul>) or something else as configure below.
 * Set use_wrapper to TRUE to use this feature.
 */
$config['use_wrapper'] = FALSE;
$config['wrapper'] = '<ul>|</ul>';
$config['wrapper_inline'] = '<li>|</li>';

/**
 * ---------------------
 * Config: Unlink
 * ---------------------
 * Default value:
 * $config['unlink_last_segment'] = FALSE;
 *
 * If set to TRUE then the last segment in breadcrumb will not have a link.
 */
$config['unlink_last_segment'] = FALSE;

/**
 * ---------------------
 * Config: Hide number
 * ---------------------
 * Default value:
 * $config['hide_number'] = TRUE;
 * $config['hide_number_on_last_segment'] = TRUE;
 *
 * If set to TRUE then any number without a word in a segment will be hide.
 * 
 * Example:
 * =======
 * http://mysite.com/blog/2009/08/7-habbits/
 * will have breadcrumbs: Home > Blog > 7 Habbits
 * Otherwise if set to FALSE it will produce: Home > Blog > 2009 > 08 > 7 Habbits
 * Notes: If the last segment is a number then it always shown whether this config
 * set to TRUE or FALSE
 */
$config['hide_number'] = TRUE;

$config['hide_number_on_last_segment'] = TRUE;

/**
 * -------------------------
 * Config: Strip characters
 * -------------------------
 * Default value:
 * $config['strip_characters'] =  array('_', '-', '.html', '.php', '.htm');
 *
 * All characters in the array will be stripped from breadcrumbs
 * 
 * Example:
 * =======
 * http://mysite.com/blog/7-habbits/request.html
 * will have breadcrumbs: Home > Blog > 7 Habbits > Request
 */
$config['strip_characters'] = array('_', '.html', '.php', '.htm');

/**
 * ------------------------------------
 * Config: Strip by Regular Expression
 * ------------------------------------
 * Default value:
 * $config['strip_regexp'] =  array();
 *
 * All regular expression in the array will be stripped from breadcrumbs
 * 
 * Example:
 * =======
 * http://mysite.com/blog/7-habbits/request-300.html
 * set config to: $config['strip_regexp'] =  array ('/-[0-9]+.html/');
 * then we will have breadcrumbs: Home > Blog > 7 Habbits > Request
 */
$config['strip_regexp'] = array();

/* End of file breadcrumb.php */
/* Location: ./system/application/config/breadcrumb.php */
