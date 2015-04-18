<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

$formAttributes = array(
'name'=>'inboxForm',
'id'=>'inboxForm'
); 

?>

<?php echo form_open($this->uri->uri_string()."/compose",$formAttributes); ?> 
<?php if($items_total > 0) {?>
<div class="fr  mb10 "><a href="javascript:void(0)" class="selectall">Select All</a></div>
<?php } ?>

<?php if(!empty($tmailListing)){ 
    foreach($tmailListing as $key => $value){
        
        $userImage=$value['image'];
        $creative=$value['creative'];
        $associatedProfessional=$value['associatedProfessional'];
        $enterprise=$value['enterprise'];
        //echo $creative;
        if($enterprise=="t")
        {
            $name= $value['enterpriseName'];
        }else
        {
            $name= $value['firstName'].'&nbsp;'.$value['lastName'] ;
        }

        $userDefaultImage=($creative=='t')?$this->config->item('defaultCreativeImg'):(($associatedProfessional=='t')?$this->config->item('defaultAssProfImg'):(($enterprise=='t')?$this->config->item('defaultEnterpriseImg'):''));

        if(!isset($userDefaultImage) || $userDefaultImage=='') $userDefaultImage=$this->config->item('defaultMemberImg_m'); 
        //echo $value['profileImageName'];   

        if($value['sender_id']==0)
        {
            //$userDefaultImage = base_url('images/default_thumb/toadsquare_default.jpg');
            $userDefaultImage = $this->config->item('defaultToadsquareImg');
            $name = "Toadsquare";
        }

        if($value['profileImageName']!='') {
         $userImage="media/".$value['username']."/profile_image/".$value['profileImageName'];
          //echo $userImage = addThumbFolder($image,'_s');
        }


        if($value['sender_id']!=0)
        {
            $getUserShowcase	= showCaseUserDetails($value['sender_id']);
            if($getUserShowcase['userImage']!='') {
                $userImage=$getUserShowcase['userImage'];
            }
        }


        //echo $userImage; 
        $userImage=addThumbFolder($userImage,$suffix='_xxs',$thumbFolder ='thumb',$userDefaultImage);  	
        $userImage=getImage($userImage,$userDefaultImage);

        
        $status_id=$value['status_id'];
        $bold="";
        
        if($viewType=='Inbox'){
            $bold=($value['status']==1)? '':'font_bold';
          }
        
          if($value['id'] != ''){
              if($nameString==""){
                $nameString=$name;
                $status_ids=$status_id;
              }
              
             // echo $value['id'];
             //$functionLgtBox = "openLightBox('popupBoxWp','popup_box','/tmail/showTmailPopup/".$value['id']."/Inbox')";
             $functionLgtBox = "";
             
            if($value['type']==9 || $value['type']==10)
                {
                    $url = base_url(lang().'/tmail/viewTmailNew/'.$value['id'].'/'.$viewType);
                }else
                {
                    $url = base_url(lang().'/tmail/viewTmail/'.$value['id'].'/'.$viewType);
                }
             if($value['type']==2)
             $functionLgtBox = "openLightBox('popupBoxWp','popup_box','/tmail/showTmailReplay/".$value['id']."/".$viewType."')";             
?>
 <!-- start wrap 1  --> 
 	
         <div class="tmail_in p10 fs13">
            <a href="<?php echo $url ?>" onclick="<?php //echo  $functionLgtBox; ?>">	
                <div class="fl width710">
                   <div class=" display_table list_thumb">
                      <div class="table_cell"> <img alt="" src="<?php echo $userImage ?>"> </div>
                   </div>
                   <div class="head_list fl pl15 width645 bb_F1592A pb4 lineH15 mb6">
                      <p class="fl mt3  fs13 <?php echo  $bold; ?>"> <?php echo $nameString ; ?></p> 
                      <span class="fr text_alignR ">
                         <p class="red"><?php echo  dateFormatView($value['cdate'],'d F Y') ?>   </p>
                      </span>
                   </div>
                   <p class="fl pl115 <?php echo  $bold; ?>"> <?php echo getSubString($value['subject'],50) ?> </p>
                </div>
             </a>
            <div class="fr mt30 mr-10  defaultP">
               <input type="checkbox"  class="case" name="checkbox[]" id="id_<?php echo $status_ids;?>" value="<?php echo $status_ids;?>" />
            </div>
         </div>
         <?php 
         
            $nameString="";
            $status_ids="";
         }else{
                $nameString=$name ;
                $status_ids=$status_id.','.@$user_inbox[$key+1]['status'] ;
                
            }
         
         
          } ?>
     
 <!-- End wrap 1  --> 
    <?php if($items_total > 0) {?>
        <button type="button" class="fr " onclick="showYesNo();">Delete </button>
    <?php } ?>
    
<?php } ?>

    <input type="hidden" name="isTrash" id="isTrash"   value="<?php echo $isTrash; ?>" />

 <?php echo form_close(); ?>  

    <div class="sap_60"></div>
    <?php
    $url =base_url_lang("tmail/".$methodName);
    if(isset($items_total)  && isset($perPageRecord) && $items_total >  $perPageRecord){?>
         <div class="row">
                <?php $this->load->view('pagination_new',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>$url,"divId"=>"showtmaillisting","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design',"pagingDDDClass"=>'left_site_dropdown m0 new_page_design new_page_design')); ?>
            <div class="clear"></div>
        </div>
    <?php } ?> 

<script type="text/javascript">
    //new rendered checkbox and radio button show
    radioCheckboxRender();

    $(".selectall").click(function () {					
        $('.case').attr('checked', 'checked');
        radioCheckboxRender();
    });
    
    // delete tmail 
    function showYesNo() {
        
        //var n = $("input:checked").length;
            var n =0;
           $('input.case:checked').each(function(index){
                n++
            });
        if(n==0){
            customAlert('<?php echo $this->lang->line('checkMsgAlert') ?>');
            
            return false;
        }
        confirmBox("Are you sure you wish to delete?", function () {
             
            var fromData = $("#inboxForm").serialize();
            $.post('<?php echo base_url_lang('tmail/trashTmailMessage');?>',fromData, function(data) {
                    if(data.isDelete){
                        refreshPge();
                    }
            },'json');
            
        });
    }
    
</script>
     
