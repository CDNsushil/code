<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
$veticalImgArr = array('advert_img.jpg','adobe_add.jpg');
$ranVeticalImage = array_rand($veticalImgArr);//To Show Random Images

?>
<img src="<?php echo base_url().'images/adv_ver_img/'.$veticalImgArr[$ranVeticalImage];?>" class="max_w159_h593" />

