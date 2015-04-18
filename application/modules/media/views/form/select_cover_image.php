<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$formAttributes = array(
    'name'=>'selectImageForm',
    'id'=>'selectImageForm',
);
// set base url
$baseUrl = formBaseUrl();  
// set cancle url
$cancleUrl = '#';
if(!empty($industry)) {
    $cancleUrl = $baseUrl.'/editproject/'.$projectId;
}
// set back url
$backUrl = $baseUrl.'/uploadfile/'.$projectId;
if(isset($isStage2)) {
    $backUrl = $baseUrl.'/nextnewsreviewoptions/'.$projectId.'/'.$elementId;
}

// set user's profile image
$userProfileImage = getProjectImage(getMasterTableRecord('UserShowcase'),LoginUserDetails('showcaseId'),0,'','_m');

// project element id
$elementId = (isset($elementId))?$elementId:'';
?>  
<div class="TabbedPanelsContent  width_730 TabbedPanelsContentVisible">
    <h3 class="red fs21 fnt_mouse width_730 bb_aeaeae"> <?php echo $coverTitle;?></h3>
    <?php echo form_open($baseUrl.'/setselectedimage/'.$projectId.'/'.$elementId,$formAttributes); ?>
        <div class="edit_wrap width758 m_auto ">
            <ul class="edit_album mt20 defaultP">
                <!-- User's profile image as Cover option -->
                <?php
                $nextBtnDisplay = 'dn';
                $profileChecked = '';
                $activeProfileClass = '';
                if($projData->isProfileCoverImage == 't') {
                    $profileChecked = 'checked';
                    $activeProfileClass = 'active_img';
                    $nextBtnDisplay = '';
                }
                if(!empty($userProfileImage)) {
                ?>
                    <li class="<?php echo $activeProfileClass;?>"> 
                        <img src="<?php echo $userProfileImage;?>" alt="" class="img_1"/>
                        <div class="thum_text">
                            <div class="rate_wrap">
                                <label>
                                    <input  type="radio" name="album_image"  class="check_img" id="profileImg" value="userImg" <?php echo $profileChecked;?> >
                                </label>
                            </div>
                        </div>
                    </li>
                <?php
                }
                
                for($i=0;$i<count($projElements);$i++) {
                    $imagePath = '';
                    
                    if($industry!='photographyNart'){
                        if($projElements[$i]['displayImageType'] == 1 && !empty($projElements[$i]['imagePath']) && file_exists(ROOTPATH.$projElements[$i]['imagePath'])) {
                            // set uploaded element image
                            $imagePath = base_url().$projElements[$i]['imagePath'];
                        } else if($projElements[$i]['displayImageType'] == 2) {
                             // set embedd Image
                            $imagePath = $projElements[$i]['imagePath'];
                        } else if($projElements[$i]['displayImageType'] == 3) {
                            // set project's default Image 
                            $imagePath = getImage('',$this->config->item($industry.'Image_m'));
                        }
                    }else{
                        //this condition for photography & art
                        if( file_exists(ROOTPATH.$projElements[$i]['filePath'].$projElements[$i]['fileName'])){ 
                            $imagePath = $projElements[$i]['filePath'].$projElements[$i]['fileName'];
                        }
                    }
                   
                    if(!empty($imagePath)) {
                        $checked = '';
                        $activeClass = '';
                        if($projElements[$i]['elementId'] == $projData->elementImageId) {
                            $checked = 'checked';
                            $activeClass = 'active_img';
                            $nextBtnDisplay = '';
                        }
                    ?>
                        <!-- Project elements image as Cover option -->
                        <li class="<?php echo $activeClass;?>"> 
                            <img src="<?php echo $imagePath;?>" alt="" class="img_1"/>
                            <div class="thum_text">
                                <div class="rate_wrap">
                                    <label>
                                        <input  type="radio" name="album_image"  class="check_img" id="img_<?php echo $projElements[$i]['elementId'];?>" value="<?php echo $projElements[$i]['elementId'];?>" <?php echo $checked;?> >
                                        <?php
                                         if(!empty($projElements[$i]['downloadPrice'])) { ?>
                                            <span >Download <b>€ <?php echo $projElements[$i]['downloadPrice'];?></b></span>
                                        <?php }?>
                                    </label>
                                </div>
                            </div>
                        </li>
                <?php } } ?>
            </ul>
        </div>
    <?php echo form_close(); ?>
    <div class="fr btn_wrap display_block font_weight">
        <a href="<?php echo $cancleUrl;?>">
            <button class="bg_ededed bdr_b1b1b1 mr5">Cancel</button>
        </a>
        <!--<button class="bdr_b1b1b1 mr5">Pause</button>-->
        <a href="<?php echo $backUrl;?>">
            <button class=" back back_tab bdr_b1b1b1 mr5" >Back</button>
        </a>
       <button id="nextBtn" name="nextButton" class="b_F1592A next_click3 bdr_F1592A <?php echo $nextBtnDisplay;?>" onclick="$('#selectImageForm').submit();"> Next </button>
    </div>   
</div>

<script>
    $(function(){
        $('input[type="radio"]').click(function(){
            if ($(this).is(':checked')) {
                $('#nextBtn').show();
            }
        });
    });
</script>
