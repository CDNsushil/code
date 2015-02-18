<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
$imageArray = array('ads.png','ads01.jpg','ads02.jpg','ads03.jpg');
$randomImage = array_rand($imageArray);//To Show Random Images

?>

<img src="<?php echo base_url().'images/adv_mid_img/'.$imageArray[$randomImage];?>" class="max_w468_h60" />
