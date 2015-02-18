<?php if (!defined('BASEPATH')) { exit('No direct script access allowed');}?>
<?php
class Feed extends MX_Controller 
{

    function Feed()
    {   
	  $load = array(
			'model'		=> 'blogs/model_blogs',	
			'helper' 	=> 'xml'			
	  );
	  parent::__construct($load);      
    }
   
    // Default feed for blog and posts
    function index($userId=0)
    {
		$this->blog($userId);
    }
    
    // Feed for blog and posts
    function blog($userId=0)
    {
        $data['encoding'] = 'utf-8';    
        if(isset($userId)&&$userId>0)
        {  
			$data = $this->model_blogs->getPostsForFeed($userId);  
			if(count($data['blogDetail'])>0)
			{
				$data['feed_name'] = $data['blogDetail'][0]['blogTitle'];
				$data['feed_url'] = base_url('feed/index/'.$userId);
				$data['page_description'] = $data['blogDetail'][0]['blogOneLineDesc'];
				$data['page_language'] = lang();
				$data['creator_email'] = $data['blogDetail'][0]['email'];  
				header("Content-Type: application/rss+xml");
			   // echo '<pre />';print_r($data);die;
				//$this->load->view('feed/rss', $data);    
				$this->_rss2($data); #generate RSS code  
			}
		}  
    }
    
    function _rss2($data) {		
		header('Content-type: text/xml');
		echo '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">',
		'<channel>',
		'<title>',$data['feed_name'],'</title>',
		'<link>',$data['feed_url'],'</link>',
		'<description>',$data['page_description'],'</description>',
		'<atom:link href="',base_url(),'rss" rel="self" type="application/rss+xml" />';
		foreach($data['posts'] as $entry) echo
		'<item>',
		'<title>',xml_convert($entry['postTitle']),'</title>',
		'<link>',base_url(),'blogshowcase/frontPostDetail/',$entry['custId'].'/'.$entry['postId'],'</link>',
		//'<owner>',xml_convert($entry['firstName'].' '.$entry['lastName']),'</owner>',
		'<description>',xml_convert($entry['postOneLineDesc']),'</description>',   
		'<pubDate>',date(DATE_RSS, strtotime($entry['dateCreated'])),'</pubDate>',
		'<guid>',base_url(),'blogshowcase/frontPostDetail/',$entry['custId'].'/'.$entry['postId'],'</guid>',
		'</item>';
		echo '</channel>',
		'</rss>';
		
    }
}
?> 
