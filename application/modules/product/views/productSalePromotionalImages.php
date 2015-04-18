<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


//echo Modules::run("product/productPromotionalVideo",$productId,$entityMediaType); 

if((isset($productId) && $productId>0) ){

echo $this->load->view('mediatheme/promoImgAccordView',$eventPromoImages);

} 
