<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$config['search_section'] = array(
    0=>'All',
    'member'=>'Member Showcases',
    'media'=>'Media Showcases',
    /*9=>'Performances & Events',*/
    13=>'Blogs',
    /*16=>'Competitions',
    12=>'Classifieds',*/
    35=>'Event Notices',
    36=>'Favourite Sites'
);

$config['search_section_id'] = array(1,2,3,4);

$config['showcase_section'] = array(
    'member'=>'All Member Showcases',
    '6'=>array(
        '6-news'=>'News about Creatives',
        '6-reviews'=>'Reviews of Creatives',
        '6-top10craved'=>'Top-10-Craved Creatives',
    ),
    '7'=>array(
        '7-news'=>'News about Professionals',
        '7-reviews'=>'Reviews of Professionals',
        '7-top10craved'=>'Top-10-Craved Professionals',
    ),
    '8'=>array(
        '8-news'=>'News about Businesses',
        '8-reviews'=>'Reviews of Businesses',
        '8-top10craved'=>'Top-10-Craved Businesses',
    ),
    '34'=>array(),
);

$config['media_section'] = array(
    'media'=>'All Media',
    '1'=>'Films & Videos',
    '2'=>'Music & Audio',
    '4'=>'Photos & Artworks',
    '3'=>'Writings',
    '10'=>'Creative-Industry Educational Media',
);

$config['fv_section'] = array(
    1=>'All',
    '1-1-elements'=>array(
        '1-1'=>'Film & Video Collections',
        '1-1-free'=>'Free Film & Video Collections',
    ),
    'non'=>array(
        '1-upcoming'=>'Upcoming Films & Videos',
        '1-news'=>'News about Films & Videos',
        '1-reviews'=>'Reviews of Films & Videos',
        '1-top10craved'=>'Top-10-Craved Films & Videos',
    ),
);

$config['ma_section'] = array(
    2=>'All',
    '2-5-12-elements'=>array(
        '2-5'=>'Music Albums',
        '2-5-free'=>'Free Music Albums',
        
    ),
    '2-3-10-elements'=>array(
        '2-3'=>'Audio Collections',
        '2-3-free'=>'Free Audio Collections',
        
    ),
    'non'=>array(
        '2-upcoming'=>'Upcoming Music & Audio',
        '2-news'=>'News about Music & Audio',
        '2-reviews'=>'Reviews of Music & Audio',
        '2-top10craved'=>'Top-10-Craved Music & Audio',
    ),
);

$config['wp_section'] = array(
    3=>'All',
    '3-6-elements'=>array(
        '3-6'=>'Writing Collections',
        '3-6-free'=>'Free Writing Collections',
        
    ),
    'non'=>array(
        '3-upcoming'=>'Upcoming Writings',
        '3-news'=>'News about Writings',
        '3-reviews'=>'Reviews of Writings',
        '3-top10craved'=>'Top-10-Craved Writings',
    ),
);

$config['pa_section'] = array(
    4=>'All',
    '4-7-21-elements'=>array(
        '4-7'=>'Photography Albums',
        '4-7-free'=>'Free Photography Albums',
        
    ),
    '4-9-22-elements'=>array(
        '4-9'=>'Artwork Collections',
        '4-9-free'=>'Free Artwork Collections',
        
    ),
    'non'=>array(
        '4-upcoming'=>'Upcoming Photos &Artworks',
        '4-news'=>'News about Photos &Artworks',
        '4-reviews'=>'Reviews of Photos &Artworks',
        '4-top10craved'=>'Top-10-Craved Photos &Artworks',
    ),
);

$config['em_section'] = array(
    10=>'All',
    '10-12-elements'=>array(
        '10-12'=>'Educational Media Collections',
        '10-12-free'=>'Free Educational Media Collections',
    ),
    'non'=>array(
        '10-upcoming'=>'Upcoming Educational Media',
        '10-news'=>'News about Educational Media',
        '10-reviews'=>'Reviews of Educational Media',
        '10-top10craved'=>'Top-10-Craved Educational Media',
    ),
);

$config['event_section'] = array(
    9=>'All',
    '9-industry'=>array(
        '9-industry-free'=>'Free Events',
    ),
    'non'=>array(
        '9-upcoming'=>'Upcoming Events',
        '9-news'=>'News about Events',
        '9-reviews'=>'Reviews of Events',
        '9-top10craved'=>'Top-10-Craved Events',
    ),
);

$config['showcase_industry'] = array(
    'showcase_industry'=>'All Creative Industries',
    '1'=>'The Film & Video Industries',
    '2'=>'The Music & Audio Industries',
    '5'=>'The Performing Arts Industries',
    '4'=>'The Photography & Art Industries',
    '3'=>'The Writing & Publishing Industries',
    '10'=>'Creative-Industry Educational'
);

$config['em_industry'] = array(
    'em_industry'=>'All Creative Industries',
    '1'=>'The Film & Video Industries',
    '2'=>'The Music & Audio Industries',
    '5'=>'The Performing Arts Industries',
    '4'=>'The Photography & Art Industries',
    '3'=>'The Writing & Publishing Industries',
    '10'=>'Creative-Industry Educational '
);

$config['blog_industry'] = array(
    '13'=>'All Creative Industries',
    '1'=>'The Film & Video Industries',
    '2'=>'The Music & Audio Industries',
    '5'=>'The Performing Arts Industries',
    '4'=>'The Photography & Art Industries',
    '3'=>'The Writing & Publishing Industries',
    '10'=>'Creative-Industry Educational',
    'others'=>'Everything Else',
);


$config['event_industry'] = array(
    '9-industry'=>'All',
    '1'=>'The Film & Video Events',
    '2'=>'The Music & Audio Events',
    '5'=>'The Performing Arts Events',
    '4'=>'The Photography & Art Events',
    '3'=>'The Writing & Publishing Events',
    '10'=>'Creative-Industry Educational Events',
);

$config['upcoming_events_industry'] = array(
    '9-upcoming'=>'All Upcoming Events',
    '1'=>'Upcoming Film & Video Events',
    '2'=>'Upcoming Music & Audio Events',
    '5'=>'Upcoming Performing Arts Events',
    '4'=>'Upcoming Photography & Art Events',
    '3'=>'Upcoming Writing & Publishing Events',
    '10'=>'Upcoming Creative-Industry Educational Events',
);

$config['event_notices_industry'] = array(
    '35'=>'All Creative Industries',
    '1'=>'The Film & Video Industries',
    '2'=>'The Music & Audio Industries',
    '5'=>'The Performing Arts Industries',
    '4'=>'The Photography & Art Industries',
    '3'=>'The Writing & Publishing Industries',
    '10'=>'Creative-Industry Education',
    'others'=>'Everything Else',
);


$config['favourite_sites_industry'] = array(
    '36'=>'All Creative Industries',
    '1'=>'The Film & Video Industries',
    '2'=>'The Music & Audio Industries',
    '5'=>'The Performing Arts Industries',
    '4'=>'The Photography & Art Industries',
    '3'=>'The Writing & Publishing Industries',
    '10'=>'Creative-Industry Education',
    'others'=>'Everything Else',
);



$config['crave_section'] = array(
    '0'=>'Select Type',
    'member'=>'Member Showcases',
    'media'=>'Media Showcases',
    'blog'=>'Blogs',
    'news'=>'News Articles',
    'reviews'=>'Reviews',
);

$config['crave_sub_section'] = array(
    'member'=>array(
        '0'=>'Select Member Showcase',
        'creatives'=>'Creatives',
        'associatedprofessionals'=>'Professionals',
        'enterprises'=>'Businesses',
        'fans'=>'Fans',
    ),
    'media'=>array(
        '0'=>'Select Media Showcase',
        'filmNvideo'=>'Films & Videos',
        'musicNaudio'=>'Music & Audio',
        'photographyNart'=>'Photos & Artworks',
        'writingNpublishing'=>'Writings',
        'educationMaterial'=>'Creative-Industry Educational Collections',
    ),
);

$config['crave_me_section'] = array(
    '0'=>'Select Type',
    'creative'=>'Creatives',
    'associatedProfessional'=>'Professionals',
    'enterprise'=>'Businesses',
    'fans'=>'Fans',
);


