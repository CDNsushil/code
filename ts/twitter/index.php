<?php
ini_set('display_errors', 1);
require_once('twitter.php');

/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
    'oauth_access_token' => "1933772281-AjbjbBi48x0HnghJ8Y0tncDzXGEuEldGLXLuiV6",
    'oauth_access_token_secret' => "kaUehup5vN9yajlQVDSKxz0axCIjU4BehgLF4cJO2o",
    'consumer_key' => "9AcQqtUQJ22V7bbzt0anw",
    'consumer_secret' => "WKytSb2RTjDTOYwFHDycrqLhZrDVCNFJAtq9XD3pcgo"
);

/** URL for REST request, see: https://dev.twitter.com/docs/api/1.1/ **/
/*$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
$requestMethod = 'POST';

// POST fields required by the URL above. See relevant docs as above 
$postfields = array(
    'screen_name' => 'saulrudnick', 
    'skip_status' => '1'
);

// Perform a POST request and echo the response 
$twitter = new twitter($settings);
echo $twitter->buildOauth($url, $requestMethod)
             ->setPostfields($postfields)
             ->performRequest(); */

/** Perform a GET request and echo the response **/
/** Note: Set the GET field BEFORE calling buildOauth(); **/
$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
$getfield = '?screen_name=saulrudnick';
$requestMethod = 'GET';
$twitter = new twitter($settings);
echo $twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();
