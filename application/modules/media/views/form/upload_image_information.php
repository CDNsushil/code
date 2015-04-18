<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$lang=lang();
$formAttributes =   array(
    'name' =>  'elementInformation',
    'id'   =>  'elementInformation'
);

// set released date formates
$releasedDate = '';
$releaseMonth = '';
$releaseYear  = '';
if(isset($elementData->projReleaseDate) && $elementData->projReleaseDate!='') {
    $releasedDate = set_value('projReleaseDate')?set_value('projReleaseDate'):@substr(@$elementData->projReleaseDate, 0,-8);
    $releasedDate = date('F Y',strtotime($releasedDate));
    $releaseMonth = date('F',strtotime($releasedDate));
    $releaseYear = date('Y',strtotime($releasedDate));
}

// set Subgenre of element
$projGenreFreeValue = set_value('projGenreFree')?set_value('projGenreFree'):string_decode($elementData->projGenreFree);
$subGenreInput = array(
    'name'        =>  'projGenreFree',
    'id'          =>  'projGenreFree',
    'class'       =>  'font_wN width_325 fs13 pb6',
    'title'       =>  'Subgenre',
    'value'       =>  $projGenreFreeValue,
    'wordlength'  =>  "0,5",
    'onkeyup'     =>  "checkWordLen(this,5,'subgenreLimit')",
    'placeholder' =>  "Subgenre",
    'onBlur'      =>  "placeHoderHideShow(this,'Subgenre','show')",
    'onClick'     =>  "placeHoderHideShow(this,'Subgenre','hide')"
);

// set Subgenre of element
$productionHouseValue = set_value('productionHouse')?set_value('productionHouse'):string_decode($elementData->productionHouse);
$productionHouseInput = array(
    'name'        =>  'productionHouse',
    'id'          =>  'productionHouse',
    'class'       =>  'font_wN width_325 fs13 pb6',
    'title'       =>  'Publisher',
    'value'       =>  $productionHouseValue,
    'wordlength'  =>  "0,5",
    'onkeyup'     =>  "checkWordLen(this,5,'publisherLimit')",
    'placeholder' =>  "Publisher",
    'onBlur'      =>  "placeHoderHideShow(this,'Publisher','show')",
    'onClick'     =>  "placeHoderHideShow(this,'Publisher','hide')"
);

// set Exhibited of element
$classificationValue = set_value('classification')?set_value('classification'):string_decode($elementData->classification);
$exhibitedInput = array(
    'name'        =>  'classification',
    'id'          =>  'classification',
    'class'       =>  'font_wN width_325 fs13 pb6',
    'title'       =>  'Exhibited',
    'value'       =>  $classificationValue,
    'wordlength'  =>  "0,10",
    'onkeyup'     =>  "checkWordLen(this,10,'exhibitedLimit')",
    'placeholder' =>  "Copyright Notes",
    'onBlur'      =>  "placeHoderHideShow(this,'Copyright Notes','show')",
    'onClick'     =>  "placeHoderHideShow(this,'Copyright Notes','hide')"
);

// set word Count of element
$wordCountValue = set_value('wordCount')?set_value('wordCount'): $elementData->wordCount;
$wordInput = array(
    'name'        =>  'wordCount',
    'id'          =>  'wordCount',
    'class'       =>  'font_wN width_325 fs13 pb6 number',
    'title'       =>  'Word Count',
    'value'       =>  $wordCountValue,
    'placeholder' =>  "Word Count",
    'onBlur'      =>  "placeHoderHideShow(this,'Word Count','show')",
    'onClick'     =>  "placeHoderHideShow(this,'Word Count','hide')"
);

// set project id
$projectIdInput = array(
    'name'  => 'projectId',
    'id'    => 'projectId',
    'value' => $projectId,
    'type'  => 'hidden'
);
// set element id
$elementIdInput = array(
    'name'  => 'elementId',
    'id'    => 'elementId',
    'value' => $elementId,
    'type'  => 'hidden'
);
// set entity id
$entityIdInput = array(
    'name'  => 'entityId',
    'id'    => 'entityId',
    'value' => $entityId,
    'type'  => 'hidden'
);
// set base url
$baseUrl = formBaseUrl();
// set current year
$currentYear = date("Y");
// set back url
$backUrl = '/uploadtitle/'.$projectId.'/'.$elementId;
if($ispriceShippingCharge == 1) {
    $backUrl = '/priceshippingcharge/'.$projectId.'/'.$elementId;
} else if($ispriceShippingCharge == 2 || $ispriceShippingCharge == 3) {
    $backUrl = '/shippingcharge/'.$projectId.'/'.$elementId;
}
$isGenreCurrent = 'current';
// set copy from text
$copyFromTxt = $this->lang->line('copyInformationFrom');
if($elementData->projCategory == 3 || $elementData->projCategory == 7) {
	$copyFromTxt = $this->lang->line('copyInformationFrom1');
}


$generIdFlag = 0;// To check div exist
$typeVideoCheck = 0;//Type video exist

?>
    <div class="TabbedPanelsContent member creative_wrap  width635 m_auto clearb">
        
        <?php if($elementData->projGenre == 0 && count($otherElementRes) > 0) { 
			 
			?>
            <div class="c_1">
                <h3 class="fs21  fl red fnt_mouse bd_none"> <?php echo $this->lang->line('copy'); ?> </h3>
                <div class="fr mt52 ml40 display_table width_216">
                    <ul class="billing_form date mt5 pl10 clearb fl">
                        <li class="select width_69 min-height_29">
                            <select name="teamElements" id="teamElements" class="main_SELECT"  >
                                <?php
                                $i = 1;
                                foreach($otherElementRes as $otherElementRes) { ?>
                                    <option value="<?php echo $otherElementRes->elementId;?>" ><?php echo $i;?></option>
                                <?php $i++;} ?>
                            </select>
                        </li>
                    </ul>
                    <div class="ml40">
                        <input class="red fr p10 bdr_a0a0a0 fshel_bold" value="Copy" id="copyElementInfo" type="button" />
                    </div>
                </div>
            </div>
            <p class=" font_helLight fs23 clearb  mt15 mb15 text_alighL" > OR</p>
        <?php 
        
        } else {
            echo '<div class="sap_35"></div>';
        } ?>
        <div class="c_1 clearb mb15">
            <?php echo form_open($baseUrl.'/settitlendescription/'.$elementId,$formAttributes); ?>
                <h4 class="red fs21 bb_aeaeae"><?php echo $this->lang->line('uploadStage_information'.$projCategory)?></h3>
                <div class="pannel7 Image_Info ">
                    <!--========================== Step 3  innertab==============================-->
                    <ul id="tabs_nav" class=" mt60  pt4 width_200 pr3 fl bdr_right_666 fshel_midum">
                        <?php if(isset($projTypes) && !empty($projTypes)) { ?>
                            <li><a href="#" name="#typetab" class="typetab" id="current"><?php echo $this->lang->line('selectProjType');?>*</a></li>
                        <?php 
                            $isGenreCurrent = '';
                        } 
                        
						if($indusrtyName == 'educationMaterial') { ?>
							<li><a href="#" name="#tabindustry"><?php echo $this->lang->line('industry');?> *</a></li>
							<li><a href="#" name="#tabwordCount"><?php echo $this->lang->line('wordCount');?></a></li>
						<?php } 
						
						
						if($indusrtyName != 'educationMaterial') {  ?>
						
							<li id="genreLi"><a href="#" name="#tab1" class="tab1" id="<?php echo $isGenreCurrent;?>"><?php echo $this->lang->line('genre');?></a></li>
                        
							<li><a href="#" name="#tab2"><?php echo $this->lang->line('subgenre');?></a></li>
						<?php } 
                        
						 if($indusrtyName != 'photographyNart') { ?>
                            <li><a href="#" name="#tablang"><?php echo $this->lang->line('language');?></a></li>
						<?php } ?>
                        <li><a href="#" name="#tab3"><?php echo $this->lang->line('dateTaken');?></a></li>
                        
						<?php if($indusrtyName != 'photographyNart') { ?>
							<li><a href="#" name="#tabpublisher"><?php echo $this->lang->line('publisher');?></a></li>
						<?php } ?>
                        <li><a href="#" name="#tab4"><?php echo $this->lang->line('countryOrigin');?></a></li>
                        <li><a href="#" name="#tab5"><?php echo $this->lang->line('exhibited');?></a></li>
                    </ul>
                    <!--=========== Step 3  inner tab content ========-->
                    <div id="content_tabs" class="fl pl70 width_360 mt10">
                        <?php if(isset($projTypes) && !empty($projTypes)) { 
                                $typeVideoCheck = 1;//Type video exist
                            ?>
                            <div id="typetab">
                                <h4 class="fs21 fnt_mouse bb_e7e7e7 pl15 mb25"><?php echo $this->lang->line('selectProjType')?></h4>
                                <ul class="billing_form width169 mt2 pl10 fl">
                                    <li class="select">
                                        <?php 
                                        $projType=set_value('projType')?set_value('projType'):@$elementData->projType;
                                        if( ! $projType > 0) {
                                            $projType = '';
                                        }
                                        $typeList = getTypeList($sectionId,lang(),'selectProjectType',$projCategory);
                                        echo form_dropdown('projType', $typeList, $projType,'id="projType" class="required" ');
                                        ?>
                                    </li>
                                </ul>
                            </div>
                        <?php }?>
                        
                        <?php if($indusrtyName == 'educationMaterial') { ?>
							  <div id="tabindustry">
                                <h4 class="fs21 fnt_mouse bb_e7e7e7 pl15 mb25"><?php echo $this->lang->line('industry') ?></h4>
                                <ul class="billing_form width169 mt2 pl10 fl">
                                    <li class="select">
                                        <?php 
                                        $industryId = set_value('industryId')?set_value('industryId'):@$elementData->industryId;
                                        if( ! $industryId > 0) {
                                            $industryId = '';
                                        }
										$industryList = getIndustryList();
                                        echo form_dropdown('industryId', $industryList, $industryId,'id="industryId" class="required" ');
                                        ?>
                                    </li>
                                </ul>
                            </div>
                        
							<div id="tabwordCount">
								<h4 class="fs21 fnt_mouse bb_e7e7e7 pl15 mb25"><?php echo $this->lang->line('wordCount');?></h4>
								<div class="input_wrap pl10 mt3 pl10 fl">
									<?php echo form_input($wordInput);?>
								</div>
							</div>
						<?php } ?>
                        <?php if($indusrtyName != 'educationMaterial') {
                            $generIdFlag = 1;// To check div exist
                             ?>
							<div id="tab1">
                                <h4 class="fs21 fnt_mouse bb_e7e7e7 pl15 mb25"><?php echo $this->lang->line('genre');?></h4>
								<ul class="billing_form width169 mt2 pl10 fl">
									<li class="select" id="genreResult">
										<?php 
										$projGenre=set_value('projGenre')?set_value('projGenre'):@$elementData->projGenre;
										if( ! $projGenre > 0) {
											$projGenre = '';
										}
										
										if(!empty($elementData->projType) && $elementData->projType > 0) {
											$subgenre = getGenerList($elementData->projType,'selectGenre');
										} else {
											$subgenre = getMediaGenerList($projCategory,'selectGenre');
										}
										echo form_dropdown('projGenre', $subgenre, $projGenre,'id="projGenre" class="required" ');
										?>
									</li>
								</ul>
							</div>
							<div id="tab2">
								<h4 class="fs21 fnt_mouse bb_e7e7e7 pl15 mb25"><?php echo $this->lang->line('subgenre');?></h4>
								<div class="input_wrap pl10 mt3 pl10 fl">
									<?php echo form_input($subGenreInput);?>
								</div>
								<div class="pl20 fl width_333 mt1 pt15"> 
									<span class="red fs13 fshel_midum">
										<?php echo '0 - 5' .$this->lang->line('words');?> 
									</span>
									<span id="word_counter" class="red fr fs13 fshel_midum wordcounter">
										<?php echo form_error($subGenreInput['projGenreFree']); ?>
										<span class="five_words" > 
											<span id="subgenreLimit">
												<?php echo str_word_count($projGenreFreeValue);?>
											</span>
											<span>
												<?php echo $this->lang->line('words');?>
											</span>
										</span>
									</span>
								</div>
							</div>
						<?php 
						}
						if($indusrtyName != 'photographyNart') { ?>
							<div id="tablang">
								<h4 class="fs21 fnt_mouse bb_e7e7e7 pl15 mb25"><?php echo $this->lang->line('language');?></h4>
								<ul class="billing_form width169 mt2 pl10 fl">
									<li class="select">
										<?php 
										$projLanguage=set_value('projLanguage')?set_value('projLanguage'):@$elementData->projLanguage;
										if( ! $projLanguage > 0) {
											$projLanguage = '';
										}
										$languageList = getlanguageList();
										echo form_dropdown('projLanguage', $languageList, $projLanguage,'id="projLanguage" class=" main_SELECT "');
									?>
									</li>
								</ul>
							</div>
                        <?php } ?>
                        <div id="tab3">
                            <h4 class="fs21 fnt_mouse  bb_e7e7e7 pl15 mb25"><?php echo $this->lang->line('dateTaken');?></h4>
                            <div class="date_wrap  fl clearb display_table pl20 pb7 fs15 "> 
                                <span class="">
                                    <?php echo $releasedDate;?>
                                </span>
                            </div>
                            <ul class="billing_form date mt2 clearb pl10 fl">
                                <li class="select fl mr9 width169">
                                    <select  name="releaseMonth" class="main_SELECT" id="releaseMonth" >
                                        <option selected="selected"> Select Month </option>
                                        <?php for($monthNum=1;$monthNum <= 12;$monthNum++) {
                                            // convert number to month name
                                            $monthName = date("F", mktime(0, 0, 0, $monthNum, 10));
        
                                            $selectedMonth = '';
                                            if($monthName == $releaseMonth) {
                                                $selectedMonth = "selected";
                                            }
                                            ?>
                                            <option value="<?php echo $monthName;?>" <?php echo $selectedMonth ;?>><?php echo $monthName;?></option>
                                        <?php } ?>  
                                    </select>
                                </li>
                                <li class="select fl width169">
                                    <select name="releaseYear" class="main_SELECT" id="releaseYear" >
                                        <option selected="selected"> Select Year </option>
                                        <?php for($i=$currentYear;$i >= ($currentYear-10);$i--) {
                                            $selected = '';
                                            if($i==$releaseYear) {
                                                $selected = "selected";
                                            }
                                            ?>
                                            <option value="<?php echo $i;?>" <?php echo $selected ;?>><?php echo $i;?></option>
                                        <?php } ?>
                                    </select>
                                </li>
                            </ul>
                        </div>
                        <?php if($indusrtyName != 'photographyNart') { ?>
							 <div id="tabpublisher">
								<h4 class="fs21 fnt_mouse bb_e7e7e7 pl15 mb25"><?php echo $this->lang->line('publisher');?></h4>
								<div class="input_wrap pl10 mt3 pl10 fl">
									<?php echo form_input($productionHouseInput);?>
								</div>
								<div class="pl20 fl width_333 mt1 pt15"> 
									<span class="red fs13 fshel_midum">
										<?php echo '0 - 5' .$this->lang->line('words');?> 
									</span>
									<span id="word_counter" class="red fr fs13 fshel_midum wordcounter">
										<?php echo form_error($productionHouseInput['productionHouse']); ?>
										<span class="five_words" > 
											<span id="publisherLimit">
												<?php echo str_word_count($productionHouseValue);?>
											</span>
											<span>
												<?php echo $this->lang->line('words');?>
											</span>
										</span>
									</span>
								</div>
							</div>
                        <?php } ?>
                        
                        <div id="tab4" class="origin">
                            <h4 class="fs21 fnt_mouse bb_e7e7e7 pl15 mb25"><?php echo $this->lang->line('countryOrigin');?></h4>
                            <!--<div class="date_wrap clearb display_table pl20 pb7 pt10 mb12 fs14"> Country of Origin </div>-->
                            <ul class="billing_form width166 mt2 pl10 fl">
                                <li class="select">
                                    <?php 
                                    $producedInCountry=set_value('producedInCountry')?set_value('producedInCountry'):@$elementData->producedInCountry;
                                    $producedInCountryList = getCountryList();
                                    echo form_dropdown('producedInCountry', $producedInCountryList, $producedInCountry,'id="producedInCountry" class=" main_SELECT "');
                                    ?> 
                                </li>
                            </ul>
                        </div>
                        <div id="tab5">
                            <h4 class="fs21 fnt_mouse bb_e7e7e7 pl15 mb25"><?php echo $this->lang->line('exhibited');?></h4>
                            <div class="input_wrap pl10 mt3 pl10 fl">
                                <?php echo form_input($exhibitedInput);?>
                            </div>
                             <div class="pl20 fl width_333 mt1 pt15"> 
                                <span class="red fs13 fshel_midum">
                                    <?php echo '0 - 10' .$this->lang->line('words');?> 
                                </span>
                                <span id="word_counter" class="red fr fs13 fshel_midum wordcounter">
                                    <?php echo form_error($exhibitedInput['classification']); ?>
                                    <span class="five_words" > 
                                        <span id="exhibitedLimit">
                                            <?php echo str_word_count($classificationValue);?>
                                        </span>
                                        <span>
                                            <?php echo $this->lang->line('words');?>
                                        </span>
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
                echo form_input($elementIdInput);
                echo form_input($entityIdInput);
                echo form_input($projectIdInput);
            echo form_close();?>
        </div>
        <!-- Form buttons -->
        <?php 
        // set back page
        $data['backPage'] = $backUrl;
        // set skip page
        //$data['skipPage'] = '/uploadcreativeteam/'.$projectId.'/'.$elementId;
        $data['isSkipstep'] = 1;
        // set next form name
        $data['formName'] = 'elementInformation';
        
        $this->load->view('common_view/upload_buttons',$data);
        ?>
    </div>


<script type="text/javascript">
    $(document).ready(function() {
        $("#elementInformation").validate({
            submitHandler: function() {
                
                var generIdFlag = parseInt('<?php echo $generIdFlag; ?>');
                var typeVideoCheck = parseInt('<?php echo $typeVideoCheck; ?>');
                var projT = 'ProjT';
                var projG = 'ProG';
                if(typeVideoCheck > 0) {
                    projT = $('#projType').val(); 
                }
                
                 if(generIdFlag > 0) {                 
                     projG = $('#projGenre').val();
                }     
                
                if(projT == "" || projG == ""){
                    customAlert('Please fill all mandatory filled');
                    return false;
                }
                
                var fromData=$("#elementInformation").serialize();
                $.post('<?php echo $baseUrl.'/setimageinformation/';?>',fromData, function(data) {
                    if(data){
                        window.location.href = '<?php echo $baseUrl;?>'+data.nextStep;
                    }
                }, "json");
            }
        });
        
    
        
        // manage elements information copy functionality  
        $('#copyElementInfo').click(function() {
            var teamElementId = $('#teamElements').val();
            confirmBox("Do you really want to copy Information.", function () {
                var fromData = 'teamElementId='+teamElementId+'&elementId='+'<?php echo $elementId;?>'+'&entityId='+'<?php echo $entityId;?>';
                $.post('<?php echo $baseUrl.'/copyElementInfo/';?>',fromData, function(data) {
                    window.location.href = window.location.href;
                },'json');
            });
        });
        
        // manage project type on genre selection
        <?php if(isset($projTypes) && !empty($projTypes)) { ?>
            $('#genreLi').click(function() {
                var projType = $('#projType').val();
                if(projType == '') {
                    alert('Please select Type first!');
                    $('#typetab').show();
                    $('#tab1').hide();
                    $('.typetab').attr('id', 'current');
                    $('.tab1').attr('id', '');
                }
            });
        <?php } ?>
        
        // change genre list on project type selection
        $('#projType').change(function() {
            var projType = $('#projType').val();
            var fromData = 'projType='+projType;
            $.post('<?php echo $baseUrl.'/getgenreselectbox/';?>',fromData, function(data) {
               $('#genreResult').html(data);
            });
        });
        
    });
</script>
