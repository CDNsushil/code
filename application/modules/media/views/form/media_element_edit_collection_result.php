<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$formAttributes =   array(
    'name' =>  'editCollectionForm',
    'id'   =>  'editCollectionForm'
);
// set base url
$baseUrl = formBaseUrl();
?>

<?php echo form_open($baseUrl.'/editproject/',$formAttributes); ?>
        <?php if(!empty($elementRes) && count($elementRes)>0) {
            $i=0;
            $serialNumber = 1;
            foreach($elementRes as $elementData) {
				// set edit element url
				$redirectLink = formBaseUrl().'/uploadform/'.$projectId.'/'.$elementData->elementId;
                if($indusrtyName == 'news' || $indusrtyName == 'reviews') {
					$redirectLink = formBaseUrl().'/'.$projectId.'/'.$elementData->elementId;   
				}
				    
				// get element image
				$elementImage = getElementImage($elementData->displayImageType,$elementData->imagePath,$indusrtyName,'_xs');
				$createdDate = $elementData->createdDate;
				
				$elementDate = date("d F Y",strtotime($createdDate));
				$elementTime = date("H:i",strtotime($createdDate));
				$mediaFileType = (isset($elementData->mediaFileType)) ? $elementData->mediaFileType : '';
				// set file type of element
				$elementfileType = getElementFileType($elementData->isPrice,$elementData->isShippable,$indusrtyName,$mediaFileType);
				?>
            
            <div class="fl bdrbfbfbf shadow_light session_box box_siz">
                   <div class="display_table fl wxh58_58">
                      <div class="table_cell"> <img src="<?php echo $elementImage;?>"  /> </div>
                   </div>
                   <div class="fl pl20 width250 pt4">
                      <div class="font_bold green  "><?php echo $elementfileType; ?></div>
                      <p><?php echo getSubString(html_entity_decode($elementData->title),35);?>
                      </p>
                   </div>
                   <div class="font_bold fr pr3 pt4"> <?php echo $serialNumber; ?> </div>
                   
                    <div class="edit_btnhov ">
						 <span class="display_table width100_per height100per">
							<a href="<?php echo $redirectLink; ?>" class="table_cell text_alignC opens_light">
								<span class="hover_click fs18 lineH22"><?php echo $this->lang->line('editCollection').$elementfileType;?></span>
							</a>
						</span>  
                    </div>
                   
                </div>
                      
            <?php //echo $projectId.'_'.$elementData->elementId;?>
           
        <?php 
        $i++;
        $serialNumber++;
        }  }?>
<?php echo form_close();?>
<?php
if($items_total >  $perPageRecord) { ?>
     <div class="sap_45"></div>
     <div class="sesion_pag">
        <?php $this->load->view('pagination_new',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>base_url(lang().'/media/getmediaelementresult/0/'.$indusrtyName.'/'.$projectId),"divId"=>"searchResultDiv","formId"=>"editCollectionForm","unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design')); ?>
    </div>
<?php } ?>  

<script>
    setTimeout(setClassPagi,1000);
    
    function setClassPagi(){
        $(".selectBox-dropdown-menu").addClass("dropoverwrite"); 
    }
</script>


