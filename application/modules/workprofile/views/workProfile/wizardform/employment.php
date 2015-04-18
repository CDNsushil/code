<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
// set base url
$baseUrl = base_url_lang('workprofile');

$employmentForm = array(
    'name'=>'employmentForm',
    'id'=>'employmentForm'
);

$compNameInput = array(
    'name'	=> 'compName',
    'id'	=> 'compName',
    'class'	=> 'font_wN fl required',
    'value'	=> '',
    'placeholder' => $this->lang->line('company'),
    'onblur' => "placeHoderHideShow(this,'".$this->lang->line('company')."','show')",
    'onclick' => "placeHoderHideShow(this,'".$this->lang->line('company')."','hide')" 
);

$compCityInput = array(
    'name'	=> 'compCity',
    'id'	=> 'compCity',
    'class'	=> 'font_wN fl required',
    'value'	=> '',
    'placeholder'	=> $this->lang->line('townOrCity'),
    'onblur'=>"placeHoderHideShow(this,'".$this->lang->line('townOrCity')."','show')",
    'onclick'=>"placeHoderHideShow(this,'".$this->lang->line('townOrCity')."','hide')" 
);

$empDesignationInput = array(
    'name'	=> 'empDesignation',
    'id'	=> 'empDesignation',
    'class'	=> 'font_wN fl required',
    'value'	=> '',
    'placeholder'	=> $this->lang->line('role'),
    'onblur'=>"placeHoderHideShow(this,'".$this->lang->line('role')."','show')",
    'onclick'=>"placeHoderHideShow(this,'".$this->lang->line('role')."','hide')" 
);

$empStartDateInput = array(
    'name'	=> 'empStartDate',
    'value'	=> '',
    'id'	=> 'empStartDate',
    'type'	=> 'text',
    'class'=>'calendar_picker required',
    /*"placeHolder"=>date('d F Y'),
    "onclick"=>"placeHoderHideShow(this,'".date('d F Y')."','hide')",
    "onblur"=>"placeHoderHideShow(this,'".date('d F Y')."','show')",*/
    "readonly"=>true
);

$empEndDateInput = array(
    'name'	=> 'empEndDate',
    'value'	=> '',
    'id'	=> 'empEndDate',
    'type'	=> 'text',
    'monthYearGreaterThan'=>'#empStartDate',
    'class'=>'calendar_picker required',
    /*"placeHolder"=>date('d F Y'),
    "onclick"=>"placeHoderHideShow(this,'".date('d F Y')."','hide')",
    "onblur"=>"placeHoderHideShow(this,'".date('d F Y')."','show')",*/
    "readonly"=>true
);

$empDesignationInput = array(
    'name'	=> 'empDesignation',
    'id'	=> 'empDesignation',
    'class'	=> 'font_wN required',
    'value'	=> '',
    'placeholder'	=> $this->lang->line('role'),
    'onblur'=>"placeHoderHideShow(this,'".$this->lang->line('role')."','show')",
    'onclick'=>"placeHoderHideShow(this,'".$this->lang->line('role')."','hide')" 
);

$empAchivmentsInput = array(
    'name'        =>  'empAchivments',
    'id'          =>  'empAchivments',
    'class'       =>  'ckeditor',
    'value'       =>  '',
    'tabindex'    =>  "1",
    'cols'        =>  "80",
    'rows'        =>  "10"
);

$empHistIdInput = array(
    'name'	=> 'empHistId',
    'id'	=> 'empHistId',
    'value'	=> 0,
    'type'	=> 'hidden'
);
?>
<div class="content display_table  TabbedPanelsContent m_auto">
	<div class=" clearb">
		<h3 class="width635 fr"><?php echo  $this->lang->line('employment');?></h3>
		 <div class="sap_30"></div>
		<?php echo form_open($baseUrl.'/education',$employmentForm); ?>
			<ul class=" billing_form form1">
				  <li>
					<label class="employe_label"><?php echo $this->lang->line('company');?></label>
					<?php echo form_input($compNameInput); ?>
				 </li>
				
				<li>
					 <label class="employe_label"><?php echo $this->lang->line('townOrCity');?></label>
					<?php echo form_input($compCityInput); ?>
				</li>
				
				<li>
					 <label class="employe_label">Country</label>
					 <span class=" width_258 select select_2 fl">
						<?php
						$countries = getCountryList();
						echo form_dropdown('compCountry', $countries, '','id="compCountry" class=" main_SELECT countriesList selectBox required"');
						?>
					</span>
				</li>
				
				<li>
					<label class="employe_label"><?php echo $this->lang->line('role');?></label>
					<?php echo form_input($empDesignationInput); ?>
				</li>
				
				<li>
					<label class="employe_label"> Start Date </label>
					<span class="width_190 position_relative fl ">
						<?php echo form_input($empStartDateInput);?>
						<img class="ui-datepicker-trigger ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#empStartDate").focus();' alt="..." title="...">
					</span> 
				</li>
				
				<li>
					<label class="employe_label"> End Date </label>
					<span class="width_190 position_relative fl ">
						<?php echo form_input($empEndDateInput);?>
						<img class="ui-datepicker-trigger ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#empEndDate").focus();' alt="..." title="...">
					</span> 
                  
					<span class="pl25 pr25 fl pt8"> OR</span>
					<span class="defaultP fl lineH22  mt6"> 
						<input type="checkbox" name="tillDate" id="tillDate" value="1" />to present
					</span>
				</li>
				<!--
				<li class="work_sort"> 
					<span class="pl210 ml40  fl">   
						<label class="employe_label clr_444"> Notice Period</label> 
					</span>
                    <span class="add_select position_relative fl">
						<p>
							<input class="spinner" name="value" value="1" />
						</p> 
					</span>
					<span class="fl ml10 mt2 position_relative">
						<select class="width126">
							<option>Weeks</option> 
							<option>Months</option>
						</select> 
					</span>
				</li>
				-->
				
				<li class="mt30">
					<label class="employe_label"> Role </label>
					<div class="editor_wrap fl width635">
						<?php echo form_textarea($empAchivmentsInput); ?>
					</div>
				</li>
			</ul>	
			<?php 
			echo form_input($empHistIdInput);
		echo form_close();?>
		
		<div class="width635  fr">	
			<div class="fr mt20">
				<input class="red p10 bdr_a0a0a0 fshel_bold min_width_79" value="Save" type="button" onclick = "$('#employmentForm').submit();" />
				<input id="cancelBtn" class="red p10 bdr_a0a0a0 fshel_bold min_width_79 dn" value="Cancel" type="button" onclick = "resetForm();" />
			</div>
			<div class="sap_30 bb_c2c2" ></div>
			<div class="sap_20"></div>
			<div class="mb10 pl30">
				<span class=" width100_per lineH21">
					<span class="red fl pl15 width_130 ">Role</span>
					<span class="red fl pl15 width210 ">Solutions Architect</span>
					<span class="red mr20 fr"></span> 
				</span>
			</div>
		
			<ul class="list_box  clearb" id="employmentData">
				<?php
				if( is_array($employmentHistory) && count($employmentHistory) > 0 ) {
					//$i = 1;
					$resultcount = count($employmentHistory);
					//$employment = $employmentHistory;
					
					for($i=1;$i <= $resultcount; $i++) { ?>
						<li id="profileEmployment_<?php echo $employmentHistory[$i]['empHistId'];?>" class="mb10 pl30">
							<span class="bg_f9f9f9 width605 lineH21">
								<span class=" fl pl15 width_130 "><?php echo $employmentHistory[$i]['compName'];?></span>
								<span class=" fl pl15 width210 "><?php echo $employmentHistory[$i]['empDesignation'];?></span>
								<span class=" mr10 fr ">
									<span class="fl red mr10">
										<a title="<?php echo $this->lang->line('edit')?>" href="javascript:void(0)" onclick="editEmployment(this)" empHistId="<?php echo $employmentHistory[$i]['empHistId'];?>" compName="<?php echo $employmentHistory[$i]['compName'];?>" compCity="<?php echo $employmentHistory[$i]['compCity'];?>" compCountry="<?php echo $employmentHistory[$i]['compCountry'];?>" empDesignation="<?php echo $employment[$i]['empDesignation'];?>" empStartDate="<?php echo $employmentHistory[$i]['empStartDate'];?>" empEndDate="<?php echo $employmentHistory[$i]['empEndDate'];?>" empAchivments="<?php echo $employmentHistory[$i]['empAchivments'];?>">Edit</a>
										/ 
										<a href="javascript:void(0)" onclick="deleteEmployment('<?php echo $employmentHistory[$i]['empHistId'];?>');" >Delete </a>
									</span>
									
									<?php
									if($resultcount != $i) { ?>
										<span class="down_arrow comm_arow ptr <?php echo $opacitydownDisable;?>" onclick="managePosition('<?php echo  encode($employmentHistory[$i]['empHistId']);?>','<?php echo encode($employmentHistory[$i+1]['empHistId'])?>','<?php echo $employmentHistory[$i]['position'];?>','<?php echo $employmentHistory[$i+1]['position'];?>')"></span>
									<?php } else { ?>
										<span class="down_arrow comm_arow ptr opacity_3" ></span>
									<?php }
									if($i > 1) { ?>	
										<span class="up_arrow comm_arow ptr " onclick="managePosition('<?php echo  encode($employmentHistory[$i]['empHistId']);?>','<?php echo encode($employmentHistory[$i-1]['empHistId'])?>','<?php echo $employmentHistory[$i]['position'];?>','<?php echo $employmentHistory[$i-1]['position'];?>')"></span>
									<?php 
									} else { ?>
										<span class="up_arrow comm_arow ptr opacity_3" ></span>
									<?php
									} ?>
								</span> 
							</span> 
						</li>
					<?php 
					} 
				} ?>
			</ul>
		</div>	
		<!-- Form buttons -->
        <?php 
        // set back url
        $data['backPage'] = '/workprofile/education';
        // set next form name
        $data['nextPage'] = '/workprofile/refrences';
        $data['isNextstep'] = 1;
		$this->load->view('workProfile/wizardform/common_buttons',$data);
        ?>
	</div>
</div>

<script>
	 /**
    * Set Editor's instance for data management
    */
    CKEDITOR.on('instanceReady', function(){
       $.each( CKEDITOR.instances, function(instance) {
        CKEDITOR.instances[instance].on("change", function(e) {
            for ( instance in CKEDITOR.instances )
            CKEDITOR.instances[instance].updateElement();
        });
       });
    });
    
	$(function () {
	  $('#empEndDate').monthpicker({selectedYear: <?php echo date('Y')?>, startYear: 1925, finalYear: <?php echo date('Y')?>});
  });
  
  $(function () {
	  $('#empStartDate').monthpicker({selectedYear: <?php echo date('Y')?>, startYear: 1925, finalYear: <?php echo date('Y')?>});
  });
	
    $(document).ready(function() {
        // manage employment submit form 
        $("#employmentForm").validate({
            submitHandler: function() {
                var fromData=$("#employmentForm").serialize();
				//loader();
                $.post('<?php echo $baseUrl.'/addprofileemployment/';?>',fromData, function(data) {
                    if(data) {
						refreshPge();
						//parent show div
						/*$("#popup_box").parent().hide();
                        if(data.editId > 0) {
                            $('#profileEmployment_'+data.editId).html(data.employmentHtml);
                        } else {
                            $('#employmentData').prepend(data.employmentHtml);
                        }
                        // append form values as blank
                        resetForm();*/
                    }
                },'json');
            }
        });
    });
    
    // employment manage workrprofile
    function editEmployment(obj) {
        var empHistId = $(obj).attr('empHistId');
        var compName = $(obj).attr('compName');
        var compCity = $(obj).attr('compCity');
        var compCountry = $(obj).attr('compCountry');
		var empDesignation = $(obj).attr('empDesignation');
		var empStartDate = $(obj).attr('empStartDate');
		var empEndDate = $(obj).attr('empEndDate');
		var empAchivments = $(obj).attr('empAchivments');
			
        // set form values in fields
        $('#empHistId').val(empHistId);     
		$('#compName').val(compName);  
		$('#compCity').val(compCity);  
        setSeletedValueOnDropDown( 'compCountry',compCountry );
        $('#empDesignation').val(empDesignation);  
		$('#empStartDate').val(empStartDate);  
		$('#empEndDate').val(empEndDate);  
		$('#empAchivments').val(empAchivments);   
     
        // manage buttons
        $('#cancelBtn').show();
    }
    
    // reset employment form values
    function resetForm() {
        $('#empHistId').val(0);
       	$('#compName').val('');  
		$('#compCity').val('');  
        setSeletedValueOnDropDown( 'compCountry','' );
        $('#empDesignation').val('');  
		$('#empStartDate').val('');  
		$('#empEndDate').val('');  
		$('#empArchived').val('');  
        $('#cancelBtn').hide();
    }
    
    // remove employment entry from workrprofile
    function deleteEmployment(empHistId) {
        confirmBox("If you delete this, it will be deleted immediately.", function () {
             var fromData = 'empHistId='+empHistId;
             $.post('<?php echo $baseUrl.'/deleteprofileemployment/';?>',fromData, function(data) {
                if(data.deleted == 1 && data.countResult == 0) {
                    $("#profileEmployment_"+empHistId).fadeOut("normal", function() {
                        $(this).remove();
                    });
                }
            },'json');
        });
    }	
    
    // check employment year diffrences
    function checkDate() {
		
		var toYear = $('#educationYear').val();
		var fromYear =$('#educationYearTo').val();
		
		if(fromYear <= toYear) {
			alert("To must be greater ");
			setSeletedValueOnDropDown('educationYearTo','To');
		}
	}
	
	function managePosition(currentId,swapId,currentPosition,swapPosition) {
 
		 var fromData = 'currentId='+currentId+'&swapId='+swapId+'&currentPosition='+currentPosition+'&swapPosition='+swapPosition;
		 $.post('<?php echo $baseUrl.'/moveempposition/';?>',fromData, function(data) {
			refreshPge();
		});
	}

</script>
