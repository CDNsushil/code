<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="key_Popup ">
 <div class="bg_fbfbfb  popupscrollbar_bg  shiping_csroll poup_bx  shadow shiping_csroll width900imp">
    <div id="popup_close_btn" class="close_btn position_absolute" onclick="$(this).parent().trigger('close');"></div>
    <h3 class="" >Select the item you have a problem with.</h3>
    <div class="sap_35"></div>
    <div class="search_wrap width260 fl">
        <?php
            $formAttributes = array(
            'name'=>'searchontoadsquare',
            'id'=>'searchontoadsquare',
            );
            
            echo form_open($this->uri->uri_string(),$formAttributes);
            //$view='searchontoadsquare_result';
            $view='search_media_result';
            if(!isset($sectionList) || !$sectionList){
                $sectionIdInput = array(
                    'name'	=> 'sectionId',
                    'type'	=> 'hidden',
                    'id'	=> 'sectionId',
                    'value'	=> $sectionId
                );
                echo form_input($sectionIdInput);
            }
            $keyword=(isset($keyword) && $keyword !='' )?$keyword:$this->lang->line('keywordSearch');
            
            if(isset($prosectionId)){
                $projectSectionId = $prosectionId;
            }else{
                $projectSectionId = 0;
            }
        ?>

       <h4 class="fs21 pb10">Search</h4>
       <div class="searchbarbg mb8">
          <input class="font_wN wid220imp" type="text" name="keyWord" placeholder="<?php echo $this->lang->line('keywordSearch');?>" value="<?php echo $keyword;?>" onclick="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','hide')" onblur="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','show')">
          <input class="searchbtbbg" type="submit" value="Submit" name="Submit">
       </div>
        <ul class="clearb mt10 select_shadow height180 defaultP bdr_a1a1a1 clr_666 fs13 width_235 p10 pb0 select_list "  >
          <li >
             <label class="all_click">
             <input  id="sectionIdShow_0" class="sectionlistget" name="sectionIdShow" value="0"  checked type="radio" />
             All </label>
          </li>
          <li>
             <label>
             <input id="sectionIdShow_1" class="checkboxStates ez-hide sectionlistget" value="6,7,8,34"  name="sectionIdShow"  type="radio" />
             <span> Member Showcases</span> </label>
          </li>
          <li>
             <label>
             <input id="sectionIdShow_2" class="checkboxStates ez-hide sectionlistget" value="1,2,3,4,10"  name="sectionIdShow"  type="radio" />
             <span> Media Showcases</span> </label>
          </li>
          <li>
             <label>
             <input id="sectionIdShow_2" class="checkboxStates ez-hide sectionlistget" value="9"  name="sectionIdShow"  type="radio" />
             <span> Performances & Events </span></label>
          </li>
          <li>
             <label>
             <input id="sectionIdShow_3" class="checkboxStates ez-hide sectionlistget" value="13"  name="sectionIdShow"   type="radio" />
             <span> Blogs </span> </label>
          </li>
          <li>
             <label >
             <input id="sectionIdShow_4" class="checkboxStates ez-hide sectionlistget" value="16"  name="sectionIdShow"   type="radio" />
             <span>Competitions </span> </label>
          </li>
          <li>
             <label>
             <input id="sectionIdShow_5" class="checkboxStates ez-hide sectionlistget" value="16"  name="sectionIdShow"   type="radio" />
             <span> Competition Entries </span></label>
          </li>
          <li>
             <label>
             <input id="sectionIdShow_6" class="checkboxStates sectionlistget" value="12"  name="sectionIdShow"   type="radio" />
             <span>Classifieds </span></label>
          </li>
       </ul>
       
       <div class="sap_10"></div>
       <div class="select_1  height30 clearbox  position_relative" id="sectiondiv">
           
           <?php
				if(isset($sectionList) && $sectionList){
					?>
					 <?php echo form_dropdown('sectionId', $sectionList, $sectionId,'id="sectionId" class="width258"');?>
					<?php
					$view='search_media_result';
				}
			?>
       </div>
        <input type="hidden" name="fromSection" id="fromSection" value="<?php echo isset($section)?$section:'';;?>">
       <div class="submint_btn fr">
          <button class=" fr p10 mt15" type="submit">Search </button>
       </div>
       <?php echo form_close(); ?> 
       
    </div>
    <div id="searchontoadsquareResultDiv">
        <?php
			if($searchResult){
				echo $searchResult;
			}else{
				echo '<div class="p15">search result will come here</div>';
			}
        ?>
    </div>
    
 
 </div>
 </div>
 </div>
<script>
	$(document).ready(function(){	
		$("#searchontoadsquare").validate({
			  submitHandler: function() {
				$('html').animate({scrollTop:0}, 'slow');
				$('#searchontoadsquareResultDiv').html('<img  class="ma" id="loadImg" align="absmiddle" src="'+baseUrl+'images/loading_wbg.gif" />');
				var fromData=$("#searchontoadsquare").serialize();
				fromData = fromData+'&viewPage=<?php echo $view;?>'+'&prosectionId=<?php echo $projectSectionId;?>';
				$.post(baseUrl+language+'/search/searchresult',fromData, function(data) {
				  if(data){
					 $('#searchontoadsquareResultDiv').html(data);
				  }
				});
			 }
		});
	});
	runTimeCheckBox();
	selectBox();
    
    $(".sectionlistget").click(function(){
        
        var getvalue = $(this).val();
        var fromData={"sectionValue":getvalue};
        $.post(baseUrl+language+'/search/reportaproblemindustry',fromData, function(data) {
          if(data){
                $('#sectiondiv').html(data);
                    
                selectBox();
            }
        });
    });
    
</script>
