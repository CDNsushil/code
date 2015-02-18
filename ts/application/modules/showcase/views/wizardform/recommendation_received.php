<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$showcaseId=loginUserDetails('showcaseId');
// set base url
$baseUrl = base_url(lang().'/showcase/');
// get received recommendations listing
$recommendationList= Modules::run("recommendations/index",array('to_userid'=>$userId));
//echo "<pre>";
//print_r($recommendationList);
//echo "asdads";?>

<div class=" pl45 pr25  bg_f1f1f1 fl title_head ">
    <h1 class="pt10 mb0  fl">Recommendations Received</h1>
    <ul class="dis_nav fs16 mt25 fr mr3">
        <li class="active"> <a href="javascript:void(0);">Revieved</a> </li>
        <li> <a href="<?php echo $baseUrl.'/givenrecommendations'?>">Given</a> </li>
    </ul> 
</div>

<div class="clearbox wizard_wrap" id="TabbedPanels1">
    <div class="c_1 m_auto width635">
        <h3>Add a Recomendation to your Homepage or Work Profile.</h3>
         <?php 
        if(!empty($recommendationList)) { ?>
            <h4 class="fs16">Another member has given you and your work a recomendation. You can choose
            which recommendations you wish to put on your Showcase Homepage or your
            Work Proflie.</h4>
            <div class="clearbox">
                <div class="recom_head text_alignL pt10"><p class="fs15 width_115 pb10 fr font_bold red">Add to your</p></div>
                <!--   Content box -->
                <?php 
                $countWP=countResult('WorkProfile',array('tdsUid'=>$userId));
                foreach($recommendationList as $recommendation) {
                    // set user's image
                    if(!empty($recommendation->creative) || !empty($recommendation->associatedProfessional) || !empty($recommendation->enterprise)){ 
                    $userDefaultImage=($recommendation->enterprise=='t')?$this->config->item('defaultEnterpriseImg_xxs'):($recommendation->associatedProfessional=='t'?$this->config->item('defaultAssProfImg_xxs'):$this->config->item('defaultCreativeImg_xxs'));
                    }else{
                    $userDefaultImage=$this->config->item('defaultMemberImg_xxs');
                    }

                    $userTemplateThumbImage = addThumbFolder($recommendation->profileImageName,'_xxs');	
                    $userImage = getImage($userTemplateThumbImage,$userDefaultImage);
                    
                    $showcaseLink = base_url(lang().'/showcase/index/'.$recommendation->from_userid);
                    $isShowcaseChecked = $recommendation->is_show_in_showcase=='t'?'checked':'';
                    $isWorkChecked = $recommendation->is_show_in_cv=='t'?'checked':'';
                    ?>
                    <div class="recom_box  mb22 clearb height126 bdrc9c9 bg_f7f7f7 light_sh">
                        <div class="profile_img width126 display_table fl height126"> 
                            <div class="table_cell">
                                <img src="<?php echo $userImage;?>" alt="" />
                            </div>
                        </div>
                        <div class="fl width367 pl15 pr10">
                            <div class="pt10 font_bold red">
                                <?php echo $recommendation->firstName.' '.$recommendation->lastName;?>  
                                <span class="fr clr_444"><?php echo get_timestamp('F Y',$recommendation->created_date)?> </span>
                            </div>
                            <div class="cont_recom fs13 pl7 pr7 pt5 pb10 bdr_cbcbcb mb22 bg_fff">
                                <?php echo nl2br(getSubString($recommendation->recommendations,250));?>
                            </div>
                        </div>

                        <div class="width_115 fl fs13 pt10 defaultP">
                            <div class="fl pb10 ">	
                                <input type="checkbox" name="is_show_in_showcase" id="is_show_in_showcase<?php echo $recommendation->id;?>" value="<?php echo $recommendation->id;?>" <?php echo $isShowcaseChecked;?> onclick="recommendationsUpdate(this);" />
                                 Showcase
                            </div>
                            <div class="fl pb10">
                                <?php 
                                if($countWP > 0){?>
                                    <input type="checkbox" name="is_show_in_cv" id="is_show_in_cv<?php echo $recommendation->id;?>" value="<?php echo $recommendation->id;?>" <?php echo $isWorkChecked;?> onclick="recommendationsUpdate(this);" />
                                    Work Profile
                                <?php 
                                }?>
                            
                            </div>
                            <div class="red fr pr15 pt30" >
                                <a title="Delete" href="javascript:void(0);" onclick="deleteTabelRow('Recommendations','id',<?php echo $recommendation->id;?>,'','','','','','','',1)" title="<?php echo $this->lang->line('delete');?>">
                                    Delete
                                </a>
                            </div>
                        </div>
                    </div>
                <?php 
                }?> 
            </div>
        <?php 
        } else {
            echo '<div class="sap_20"></div>';
            echo "There is no received recommendations in result!";
        }?>
<h3 class="mt25">Ask another member for a recomendation.</h3>
<div class="sap_20"></div>

<div class="position_relative ff_arial font_weight fl ml0">
    <input class="font_wN width_180 pl15 " id="searchKeyword" type="text" name="Search for a Member" placeholder="Search for a Member" value="" onclick="placeHoderHideShow(this,'Search for a Member','hide')" onblur="placeHoderHideShow(this,'Search for a Member','show')">
    <input class="searchbtbbg search_pop" type="submit" value="Search  Members" name="button">
</div>

<div class="sap_25"></div>
<a href="<?php echo $baseUrl.'/editshowcase';?>">
    <button class="bg_f1592a fr "  type="" >Finish</button>
</a>
<div class="sap_25"></div>
</div>
</div>
<!-- End Content wrap  --> 

<script>
	
	function recommendationsUpdate(obj){
		var fieldNmae=obj.name;
		var value = 'f';
		var id = obj.value;
		
		if(obj.checked){
			value = 't';
		}
		
		if(fieldNmae=='is_show_in_showcase'){
			var updateData={"is_show_in_showcase":value};
		}else{
			var updateData={"is_show_in_cv":value};
		}
		
		where={"id":id};
		var returnFlag=false;
		returnFlag=AJAX('<?php echo base_url(lang()."/recommendations/updaterecommendations");?>','',updateData,where);
		if(returnFlag){
			$('#messageSuccessError').html('<div class="successMsg"><?php echo $this->lang->line('msgSuccessfully');?> <?php echo $this->lang->line('updated');?></div>');
			timeout = setTimeout(hideDiv, 5000);
		}
		runTimeCheckBox();
	}
    
      // manage search popup
    $('.search_pop').click(function() {
        var searchKeyword = $('#searchKeyword').val();
        lightBoxWithAjax('popupBoxWp','popup_box','/showcase/searchmembers/',searchKeyword);
        runTimeCheckBox();
    }); 
</script>
