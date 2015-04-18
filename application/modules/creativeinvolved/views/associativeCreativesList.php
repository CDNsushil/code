<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 


if(!empty($associCreatList)){
?>
     <div class="box_wrap fl ">
        <h4 class=" mb16 red "><?php echo $this->lang->line($industryType.'_collection_key_cast'); ?></h4>
        <div id="associativecreativesslider" class="slider vertical_slide width250">
           <a class="buttons prev" href="javascript:void(0)"><img src="<?php echo $imgPath; ?>arrow_top.png" alt="" /> </a>
           <div class="viewport  height140 ">
              <ul class="img_box overview  width_270 ">
                   <?php
                        foreach($associCreatList as $associCreat){
                            
                        $stockImgId             =    $associCreat['stockImageId'];    
                        $creativeName           =    $associCreat['crtName'];
                        $creativeDesignation    =    $associCreat['crtDesignation'];
                        if(!empty($stockImgId)){
                            $userImage=$res[0]->stockImgPath.DIRECTORY_SEPARATOR.$associCreat['stockFilename'];					
                        }else{
                            $profileImagePath  = 'media/'.$associCreat['username'].'/profile_image/';
                            $userImage=$profileImagePath.$associCreat['profileImageName'];	
                        }
                        
                        if(!empty($associCreat['creative']) || !empty($associCreat['associatedProfessional']) || !empty($associCreat['enterprise'])){ 
                            $userDefaultImage=($associCreat['enterprise']=='t')?$this->config->item('defaultEnterpriseImg_xxs'):($associCreat['associatedProfessional']=='t'?$this->config->item('defaultAssProfImg_xxs'):$this->config->item('defaultCreativeImg_xxs'));
                        }else{
                            $userDefaultImage=$this->config->item('defaultMemberImg_xxs');
                        }

                        $userTemplateThumbImage = addThumbFolder($associCreat['userImage'],'_xxs');	
                        $userImage = getImage($userTemplateThumbImage,$userDefaultImage);
                            
                    ?>
                     <li>
                            <div class="table_cell img_thum <?php echo ($associCreat['enterprise']=='f')?"creative_show_rds":""; ?> "><img src="<?php echo $userImage; ?>" alt="" /></div> 
                            <div class="ml28"><h4> <?php echo $creativeName; ?></h4>
                            <p><?php echo $creativeDesignation; ?></p></div> 
                     </li>
                 <?php } ?>    
              </ul>
           </div>
           <a class="buttons next" href="javascript:void(0)"><img src="<?php echo $imgPath; ?>arrow_bottom.png" alt="" /></a> 
        </div>
     </div>
    
    <script type="text/javascript">
        $(document).ready(function(){
            $('#associativecreativesslider').tinycarousel({ axis: 'y', display: 1});	
        });
    </script> 


<?php } ?>
