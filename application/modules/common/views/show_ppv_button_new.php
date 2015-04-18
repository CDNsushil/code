<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

if(!empty($isGlobalPriceDownload) && $isGlobalPriceDownload =='t' && !empty($isPerViewPrice) && $isPerViewPrice=="t")//if any donwloadable elemnt is presnet then show the PPV button
{
    
    //check user is loggedIn
    $loggedUserId = (isLoginUser())?isLoginUser():0;
    
    //get element owner id
    $elementOwnerId = (!empty($ownerId)) ? $ownerId : 0;		

    $canNotBuy = $this->lang->line('Youcannotbuyfromyourself');
    
    //show pay per view button 
    if($perViewPrice>0  && $isGlobalPriceDownload=='t') {
        $priceDetails = getDisplayPrice($perViewPrice,$sellerCurrency);
       
        if($loggedUserId > 0){
            
            $where = array(
                'tdsUid'    =>  $loggedUserId,
                'elementId' =>  $elementId,
                'entityId'  =>  $entityId
            );
            
            $entityIdElementId=$entityId.'_'.$elementId;
            if($elementOwnerId != $loggedUserId) {
                $countResult=countResult('Wishlist',$where);
                $beforeBuyProduct = "You must be logged in to buy a product.";
                if($countResult>0){
                    $alreadInWishlist="You have already added this product in your wishlist";
                    $functionBuyProduct="if(checkIsUserLogin('".$beforeBuyProduct."')){customAlert('".$alreadInWishlist."')}";

                }else{	
                    $buyProduct=$this->load->view('cart/buy_product_new',array('productBasePrice' =>$perViewPrice,'price'=>$priceDetails['displayPrice'],'currencySign'=>$priceDetails['currencySign'],'elementId'=>$elementId,'entityId'=>$entityId,'projId'=>$projectId,'sectionId'=>$sectionId,'ownerId'=>$ownerId,'purchaseType'=>3), true);?>
                    <script>
                    var buyProduct<?php echo $entityIdElementId;?>=<?php echo json_encode($buyProduct);?>
                    </script>
                    <?php  $functionBuyProduct="if(checkIsUserLogin('".$beforeBuyProduct."')){loadPopupData('popupBoxWp','popup_box',buyProduct".$entityIdElementId.")}";    
                }
            } else{  
                $beforeBuyProduct = "You must be logged in to buy a product.";
                $canNotBuy = $this->lang->line('Youcannotbuyfromyourself');
                
                 //check preview mode
                if(previewModeActive()){
                    $canNotBuy = $this->lang->line('Youcannotbuyfromyourselfpreview');
                }
                
                $functionBuyProduct="if(checkIsUserLogin('".$beforeBuyProduct."')){customAlert('".$canNotBuy."')}";
            }          

        } else {
            $beforeBuyProduct = "You must be logged in to buy a product.";		
            $functionBuyProduct="openLightBox('popupBoxWp','popup_box','/auth/login','".$beforeBuyProduct."')";
        }

        ?>  
            <button  onclick="<?php echo $functionBuyProduct; ?>" class="pay_button" type="button"><span>
                <?php echo  $this->lang->line($industryType.'_'.$mediaFileType.'_element_payperview');?> </span>
                <span class="red pl5"><?php echo $priceDetails['currencySign'].'&nbsp;'.$priceDetails['displayPrice'];?></span>
            </button>

        <?php 
        
    } 

}
?>
