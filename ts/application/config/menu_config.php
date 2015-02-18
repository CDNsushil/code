<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//menu config define for showcase menu, your toadsquare, user member info header



//This config for which module and method you do not want to show member info header
$config['member_user_info'] =   array(
    'home'              =>  array(),
    'package'           =>  array(
        'freejoined'        => 'freejoined',
        'packagestageone'   => 'packagestageone',
        'promocodejoined'       => 'promocodejoined',
        'index'             => 'index',
        'freejoined'        => 'freejoined'
    ),
    'creatives'         =>  array(),
    'associateprofessional'=>  array(),
    'enterprises'       =>  array(),
    'fans'              =>  array(),
    'filmnvideo'        =>  array(),
    'photographynart'   =>  array(),
    'musicnaudio'       =>  array(),
    'writingnpublishing'=>  array(),
    'educationnmaterial'=>  array(),
    'performancesnevents'=>  array(),
    'blogs'         =>  array(),
    'products'      =>  array(),
    'my404'         =>  array(),
    'cms'           =>  array(),
    'pressRelease'  =>  array(),
    'news'          =>  array(),
    'search'        =>  array(),
    'showcase'        =>  array('index','developementpath','aboutme','videos','mycraves','cravingme','mypaylist'),
   
);

//This config for which module and method you want to show  showcase info header
$config['showcase_user_info'] =   array(
    'showcase'        =>  array('index','developementpath','aboutme','videos','mycraves','cravingme','mypaylist'),
);


//This config for which module and method you do not want to show showcase menu
$config['showcase_menu'] =   array(
    'home'              =>  array(),
    'package'           =>  array(
        'freejoined'            => 'freejoined',
        'packagestageone'       => 'packagestageone',
        'packagestagetwo'       => 'packagestagetwo',
        'packagestagethree'     => 'packagestagethree',
        'membershipselected'    => 'membershipselected',
        'billingdetails'        => 'billingdetails',
        'packagesummary'        => 'packagesummary',
        'index'                 => 'index',
        'freejoined'            => 'freejoined',
        'promocodejoined'       => 'promocodejoined',
        'paidjoined'            => 'paidjoined',
        'paymenterror'          => 'paymenterror',
    ),
    'creatives'         =>  array(),
    'associateprofessional'=>  array(),
    'enterprises'       =>  array(),
    'fans'              =>  array(),
    'filmnvideo'        =>  array(),
    'photographynart'   =>  array(),
    'musicnaudio'       =>  array(),
    'writingnpublishing'=>  array(),
    'educationnmaterial'=>  array(),
    'performancesnevents'=>  array(),
    'blogs'         =>  array(),
    'products'      =>  array(),
    'my404'         =>  array(),
    'cms'           =>  array(),
    'pressRelease'  =>  array(),
    'news'          =>  array(),
    'search'        =>  array(),
   
);


