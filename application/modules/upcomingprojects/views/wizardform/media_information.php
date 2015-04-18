<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$lang=lang();
$formAttributes =   array(
    'name' =>  'mediaInformation',
    'id'   =>  'mediaInformation'
);

// set released date formates
$releasedDate = '';
$releaseMonth = '';
$releaseYear  = '';
if(isset($upcomingRes['projReleaseDate']) && $upcomingRes['projReleaseDate']!='') {
    $releasedDate = set_value('projReleaseDate')?set_value('projReleaseDate'):@substr($upcomingRes['projReleaseDate'], 0,-8);
    $releasedDate = date('F Y',strtotime($releasedDate));
    $releaseMonth = date('F',strtotime($releasedDate));
    $releaseYear = date('Y',strtotime($releasedDate));
}

// set project id
$projectIdInput = array(
    'name'  => 'projId',
    'id'    => 'projId',
    'value' => (isset($upcomingRes['projId'])) ? $upcomingRes['projId'] : 0,
    'type'  => 'hidden'
);

// set base url
$baseUrl = base_url(lang().'/upcomingprojects/');
// set current year
$currentYear = date("Y");

?>
    <div class="content TabbedPanelsContent width635 m_auto">
        
        <div class="c_1">
            <?php echo form_open($baseUrl.'/setmediainformation/'.$projId,$formAttributes); ?>
                <h3 class="red fs21 bb_aeaeae"><?php echo $this->lang->line('upcomingMediaInfo')?></h3>
                <div class="sap_10"></div>
                <div class="pannel7 Image_Info blog_info "> 
					<!--========================== Step 3  innertab==============================-->
                    <ul id="tabs_nav" class=" mt60  pt4 width_200 pr3 fl bdr_right_666 fshel_midum">
                        <li><a href="#" name="#tab1" class="tab1" id="current">Planned Release Date</a></li>
                        <li><a href="#" name="#tab2">Language</a></li>                  
                        <li><a href="#" name="#tab3">Country of Origin</a></li>
                        <li><a href="#" name="#tab4">Toadsquare Self Classification</a></li>
                    </ul>
                    
                    <!--=========== Step 3  inner tab content ========-->
                   <div id="content_tabs" class="fl pl30 width_361 ">
                         <div id="tab1">
                            <h4 class="fs21 fnt_mouse  bb_e7e7e7 pl15 mb25">Date Taken</h4>
                            <div class="date_wrap  fl clearb display_table pl20 pb7 fs15 "> 
                                <span class="pt10 pb10">
                                    <?php echo $releasedDate;?>
                                </span>
                            </div>
                            <ul class="billing_form date  clearb  fl">
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
                        
						<div id="tab2">
							<h4 class="fs21 fnt_mouse  bb_e7e7e7 pl15 mb25">Language</h4>
							<ul class="billing_form width169 mt2 pl10 fl">
								<li class="select">
									<?php 
									$projLanguage=set_value('projLanguage')?set_value('projLanguage'): $upcomingRes['projLanguage'];
									$projLanguageList = getlanguageList();
									echo form_dropdown('projLanguage', $projLanguageList, $projLanguage,'id="projLanguage" class=" main_SELECT required"');
									?> 
								</li>
							</ul>
						</div>
                        
                        <div id="tab3" class="origin">
                            <h4 class="fs21 fnt_mouse bb_e7e7e7 pl15 mb25">Country of Origin</h4>
                            <!--<div class="date_wrap clearb display_table pl20 pb7 pt10 mb12 fs14"> Country of Origin </div>-->
                            <ul class="billing_form width166 mt2 pl10 fl">
                                <li class="select">
                                    <?php 
                                    $projCountry=set_value('projCountry')?set_value('projCountry'):$upcomingRes['projCountry'];
                                    $projCountryList = getCountryList();
                                    echo form_dropdown('projCountry', $projCountryList, $projCountry,'id="projCountry" class=" main_SELECT required"');
                                    ?> 
                                </li>
                            </ul>
                        </div>
                        
						<div id="tab4">
							<h4 class="fs21 fnt_mouse  bb_e7e7e7 pl15 mb25">Self-Rating</h4>
							<ul class="billing_form width169 mt2 pl10 fl">
								<li class="select">
									<?php
									$rating=set_value('rating')?set_value('rating'): $upcomingRes['rating'];					
									$ratingList = getRatingList();
									echo form_dropdown('rating', $ratingList,$rating ,'id="rating" class="main_SELECT required" ');?>
								</li>
							</ul>
						</div>
                    </div>
                </div>
            <?php
                echo form_input($projectIdInput);
            echo form_close();?>
        </div>
        <!-- Form buttons -->
        <?php
        // set next form name
        $data['formName'] = 'mediaInformation';
        
		$this->load->view('wizardform/donation_buttons',$data);
        ?>
    </div>


<script type="text/javascript">
    $(document).ready(function() {
        $("#mediaInformation").validate({
            submitHandler: function() {
                var fromData=$("#mediaInformation").serialize();
				$.post('<?php echo $baseUrl.'/setmediainformation/';?>',fromData, function(data) {
                    if(data) {
                        window.location.href = data.nextStep;
                    }
                }, "json");
            }
        });   
    });
</script>
