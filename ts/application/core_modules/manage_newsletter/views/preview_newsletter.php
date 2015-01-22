<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* while we don't remove restriction (username, password) in .htacess file  from live site*/
$image_base_url = site_base_url().$this->config->item('template_new_images');
$crave_url = $this->config->item('crave_us');
/* Set Follow us link*/
$facebook_url = $this->config->item('facebook_follow_url');
$linkedin_url = $this->config->item('linkedin_follow_url');
$twitter_url = $this->config->item('twitter_follow_url');
$gPlus_url = $this->config->item('google_follow_url');
$site_email = 'info@toadsquare.com';
$site_link = 'www.toadsquare.com';
$message_date =   $newsletterDate;
$view_online  =   base_url('en/home/viewonline/'.base64_encode($newsletterId));
// get template content
$adminTemplate = $adminTemplateRes->templates;
// prepare array of template field names
$searchArray = array("{view_online}","{message_date}","{mailBody}","{image_base_url}","{crave_us}","{facebook_url}","{linkedin_url}","{site_email}","{site_link}","{twitter_url}","{gPlus_url}");
// prepare array of template field values
$replaceArray = array($view_online,$message_date,$content,$image_base_url,$crave_url,$facebook_url,$linkedin_url,$site_email,$site_link,$twitter_url,$gPlus_url);
// replace field values
$newsletterTemplate = str_replace($searchArray, $replaceArray, $adminTemplate);
// display newsletter template
echo $newsletterTemplate;
?>

