<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>


<?php
//echo "<pre>";
//print_r($section_craved_list);
$isRecord = false;
if(!empty($section_craved_list)){ ?>
        <div class="fr  mb10 "><a href="javascript:void(0)" class="selectall">Select All</a></div>
    <?php		
    $isRecord = true;
foreach($section_craved_list as $i => $notificationDetail){ 
	
    $notifiStatus  =  $notificationDetail['status'];
	
    $notificationProjectType = $notificationDetail['projectType'];

	if(($notificationDetail['entityId'] =='54' || $notificationDetail['entityId'] =='12') && $notificationProjectType==='filmNvideo')
	{
		$linkId=($notificationDetail['elementId'] == $notificationDetail['projectId'])?$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/':$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/'.$notificationDetail['elementId'].'/';
		$notificationDetail['link']=base_url(lang().'/mediafrontend/searchresult/'.$linkId.'filmvideo');
	}
	elseif(($notificationDetail['entityId'] =='54' || $notificationDetail['entityId'] =='25') && $notificationProjectType=='musicNaudio')
	{
		$linkId=($notificationDetail['elementId'] == $notificationDetail['projectId'])?$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/':$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/'.$notificationDetail['elementId'].'/';
		$notificationDetail['link']=base_url(lang().'/mediafrontend/searchresult/'.$linkId.'musicaudio');
	}
	elseif(($notificationDetail['entityId'] =='54' || $notificationDetail['entityId'] =='47') && $notificationProjectType=='photographyNart')
	{
		$linkId=($notificationDetail['elementId'] == $notificationDetail['projectId'])?$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/':$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/'.$notificationDetail['elementId'].'/';
		$notificationDetail['link']=base_url(lang().'/mediafrontend/searchresult/'.$linkId.'photographyart');
	}
	elseif(($notificationDetail['entityId'] =='54' || $notificationDetail['entityId'] =='84') && $notificationProjectType=='writingNpublishing')
	{
		$linkId=($notificationDetail['elementId'] == $notificationDetail['projectId'])?$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/':$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/'.$notificationDetail['elementId'].'/';
		$notificationDetail['link']=base_url(lang().'/mediafrontend/searchresult/'.$linkId.'writingpublishing');
	}
	elseif(($notificationDetail['entityId'] =='54' || $notificationDetail['entityId'] =='7') && $notificationProjectType=='educationMaterial')
	{
		$linkId=($notificationDetail['elementId'] == $notificationDetail['projectId'])?$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/':$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/'.$notificationDetail['elementId'].'/';
		$notificationDetail['link']=base_url(lang().'/mediafrontend/searchresult/'.$linkId.'educationmaterial');
	}
	elseif($notificationDetail['entityId'] =='94')
	{
		$linkId=($notificationDetail['elementId'] == $notificationDetail['projectId'])?$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/':$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/'.$notificationDetail['elementId'].'/';
		$notificationDetail['link']=base_url(lang().'/mediafrontend/searchresult/'.$linkId.'news');
	}
	elseif($notificationDetail['entityId'] =='95')
	{
		$linkId=($notificationDetail['elementId'] == $notificationDetail['projectId'])?$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/':$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/'.$notificationDetail['elementId'].'/';
		$notificationDetail['link']=base_url(lang().'/mediafrontend/searchresult/'.$linkId.'reviews');
	}
	elseif($notificationDetail['entityId'] =='49')
	{
		$linkId=($notificationDetail['elementId'] == $notificationDetail['projectId'])?$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/':$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/'.$notificationDetail['elementId'].'/';
		$notificationDetail['link']=base_url(lang().'/productshowcase/viewproject/'.$linkId);
	}
	elseif($notificationDetail['entityId'] =='82')
	{
		$linkId=($notificationDetail['elementId'] == $notificationDetail['projectId'])?$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/':$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/'.$notificationDetail['elementId'].'/';
		$notificationDetail['link']=base_url(lang().'/workshowcase/viewproject/'.$linkId);
	}
	elseif($notificationDetail['entityId'] =='96')
	{
		$linkId=($notificationDetail['elementId'] == $notificationDetail['projectId'])?$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/':$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'].'/'.$notificationDetail['elementId'].'/';
		$notificationDetail['link']=base_url(lang().'/blogs/frontpost/'.$linkId);
	}
	elseif($notificationDetail['entityId'] =='71')
	{
		$linkId=$notificationDetail['ownerId'].'/'.$notificationDetail['projectId'];
		$notificationDetail['link']=base_url(lang().'/upcomingfrontend/viewproject/'.$linkId);
	}
	elseif($notificationDetail['entityId'] == '9' || $notificationDetail['entityId'] == '15' || $notificationDetail['entityId'] == '10')
	{
		if(isset($notificationDetail['eventnautreid']) && $notificationDetail['eventnautreid']==1)
			$notificationDetail['link']=base_url(lang().'/eventfrontend/events/notification/'.$notificationDetail['ownerId']);
		
		if(isset($notificationDetail['eventnautreid']) && $notificationDetail['eventnautreid']==2)
			$notificationDetail['link']=base_url(lang().'/eventfrontend/events/notification/'.$notificationDetail['ownerId'].'/'.$notificationDetail['projectId']);
		
		if(isset($notificationDetail['launchnautreid']) && $notificationDetail['launchnautreid']==3)
			$notificationDetail['link']=base_url(lang().'/eventfrontend/events/launch/'.$notificationDetail['ownerId'].'/'.$notificationDetail['projectId']);
			
		if(isset($notificationDetail['launchnautreid']) && $notificationDetail['launchnautreid']==4)
			$notificationDetail['link']=base_url(lang().'/eventfrontend/events/launch/'.$notificationDetail['ownerId'].'/'.$notificationDetail['projectId']);
		
		if(isset($notificationDetail['eventnautreid']) && $notificationDetail['eventnautreid']==4)
			$notificationDetail['link']=base_url(lang().'/eventfrontend/events/event/'.$notificationDetail['ownerId'].'/'.$notificationDetail['projectId']);
		
		if(isset($notificationDetail['sessioneventid']) && $notificationDetail['sessioneventid']!='')
			$notificationDetail['link']=base_url(lang().'/eventfrontend/events/eventSession/'.$notificationDetail['ownerId'].'/'.$notificationDetail['sessioneventid']);
		
		if(isset($notificationDetail['sessionlauncheventid']) && $notificationDetail['sessionlauncheventid']!='')
			$notificationDetail['link']=base_url(lang().'/eventfrontend/events/eventSession/'.$notificationDetail['ownerId'].'/'.$notificationDetail['sessioneventid']);
		//echo '<pre />';print_r($notificationDetail);
		//$notificationDetail['link']=base_url(lang().'/eventfrontend/events/'.$notificationDetail['alert_type'].'/'.$linkId);
		//eventfrontend/events/eventSession/21/158
	}
	elseif($notificationDetail['entityId'] == '93')
	{
		$linkId=$notificationDetail['ownerId'];
		$notificationDetail['link']=base_url(lang().'/showcase/index/'.$linkId);
	}
	else{
		$notificationDetail['link']='#';
	}

	$userInfo = userProfileImage($notificationDetail['ownerId']);
	$userDefaultImage = ($userInfo['creative']=='t')?$this->config->item('defaultCreativeImg'):(($userInfo['associatedProfessional']=='t')?$this->config->item('defaultAssProfImg'):(($userInfo['enterprise']=='t')?$this->config->item('defaultEnterpriseImg'):$this->config->item('defaultMemberImg_m')));
										
	$varUserImage = addThumbFolder($userInfo['userImage'],$suffix='_xxs',$thumbFolder ='thumb',$userDefaultImage);  	
	$varUserImage = getImage($varUserImage,$userDefaultImage);

	$mainDivClass='';
	$varLineDividerClass='';


	/* get Project Image */
	$projectImagePath = getProjectImage($notificationDetail['entityId'],$notificationDetail['elementId'],$notificationDetail['projectId'],$notificationProjectType);
	
	if(isset($projectImagePath) && !empty($projectImagePath)){
		$projectImage = $projectImagePath;
	}else{
		$projectImage = $varUserImage;
	}
?>  
        <div class="fl tmail_notice ">
                <a onclick="return changeNotificationStatus('<?php echo $notificationDetail['id'];?>','<?php echo $notificationDetail['status'];?>');" href="<?php echo $notificationDetail['link'];?>" target="_blank">
                    <div class=" display_table fl notice_thumb" >
                          <div class="table_cell"> <img alt="" src="<?php echo $projectImage;?>"> </div>
                       </div>
                        <div class="fl fs13 width320 pl12 pr15 <?php echo ($notifiStatus==0)?"font_bold":""; ?>">
                        <?php
                            echo $message = $notificationDetail['message']; 
                        ?>
                    </div>
                </a> 
               <div class="fr bdrR_a1a1a1 height45 mt3 pl5 width_141 fs13">
                  <p class="pr10 lineH14 text_alignR letter_Spoint2"> 
                  <?php echo dateFormatView($notificationDetail['createdDate'],'d F Y');?>
                  </p>
                  <div class="fr mt10  defaultP">
                     <input type="checkbox" name="month" value="<?php echo $notificationDetail['id']; ?>" id="id_<?php echo $notificationDetail['id']; ?>" class="case"/>
                  </div>
               </div>
            </div>
                   
		
      <?php } //Foreach ?>
                <div class="sap_20"></div>
                <button class="fr " type="button" id="DelTmail" onclick="deleteNotification();" >Delete </button>
                <div class="sap_35"></div>


			  <?php 								  
				 if(isset($items_total) && isset($perPageRecord) && ($items_total >  $perPageRecord)){
					  $paginationArray = array("pagination_links"=>$pagination_links,"perPageRecord"=>$perPageRecord,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"url"=>base_url(lang().'/notifications/notificationslist/'.$section),"divId"=>"showNotification","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,'pagingWpaerClass' => 'pagination_wrapper new_page_design' ,'pagingDDDClass' =>'left_site_dropdown m0 new_page_design');
					  $this->load->view('pagination_new',$paginationArray);
				  }
			       			      
			  ?>
		
      <?php
      
		}else{ ?>
        
        <div class="font_opensansSBold font_size24 clr_f1592a bdrB_878688 width_267 mt22 ml160">
            <?php echo $this->lang->line('noNotificationFound'); ?>
        </div>
        
    <?php    
        }    
		
	?>
    
<script type="text/javascript">
 radioCheckboxRender();
function changeNotificationStatus(id,status){
	if(status==0){
		var updateData={"status":'1'};
		var where={"id":id};
		var returnFlag = AJAX('<?php echo base_url(lang()."/common/editDataFromTabel");?>','',updateData,'NotificationParticipants',where,'');
		if(returnFlag){
			return true;
		}
	}else{
		return true;
	}
}	

$(".selectall").click(function () {
    $('.case').attr('checked', 'checked');
    radioCheckboxRender();
});

function deleteNotification(){
    var isChecked = false;
    
    $(':checkbox:checked').each(function(i){
        isChecked = true;
    });	
    
    //not check return false
    if(!isChecked){
        customAlert('Please select records.','Error');
        return false;
    }
    
    confirmBox("Are you sure you wish to delete?", function () {
        var fromData='';					
        var val = [];
        var section = '<?php echo $selectSection?>';
        
        $(':checkbox:checked').each(function(i){
              val[i] = $(this).val();						  
        });		
        
        fromData = fromData+'&ajaxHit=1&delItems='+val+'&section='+section;
        
        $.post(baseUrl+language+'/notifications/trashNotificationMessage/',fromData, function(data) {
            if(data){
                 refreshPge();
            }
        });	
    });	
}
// END 

</script>
