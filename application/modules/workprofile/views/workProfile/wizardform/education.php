<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
// set base url
$baseUrl = base_url_lang('/workprofile');

$educationForm = array(
    'name'=>'educationForm',
    'id'=>'educationForm'
);

$universityInput = array(
    'name'	=> 'university',
    'id'	=> 'university',
    'class'	=> 'width170 required',
    'value'	=> '',
    'placeholder' => $this->lang->line('institution'),
    'onblur' => "placeHoderHideShow(this,'".$this->lang->line('institution')."','show')",
    'onclick' => "placeHoderHideShow(this,'".$this->lang->line('institution')."','hide')" 
);

$degreeInput = array(
    'name'	=> 'degree',
    'id'	=> 'degree',
    'class'	=> 'font_wN width170 required',
    'value'	=> '',
    'placeholder'	=> $this->lang->line('qualification'),
    'onblur'=>"placeHoderHideShow(this,'".$this->lang->line('qualification')."','show')",
    'onclick'=>"placeHoderHideShow(this,'".$this->lang->line('qualification')."','hide')" 
);

$educationIdInput = array(
    'name'	=> 'educationId',
    'id'	=> 'educationId',
    'value'	=> 0,
    'type'	=> 'hidden'
);

$yearArr = array();
for($i=1962;$i <= date("Y");$i++)
{
	$year[$i] = $i;
}

?>
<div class="content display_table  TabbedPanelsContent width635 m_auto">
	<div class="c_1 clearb">
		<h3><?php echo  $this->lang->line('education');?></h3>
		<div class="sap_30"></div>
		<?php echo form_open($baseUrl.'/education',$educationForm); ?>
			<div class="clearbox">
				<div class="position_relative fl mr10 width86 height30 select select_1">
					<select id="educationYear" name="educationYear" class="width86 required" onchange ="checkYear();" >
						<option value=""><?php echo $this->lang->line('yearFrom');?></option>
						<?php foreach($year as $y) {
						$selected = "Selected";
						?>
						<option value="<?php echo $y;?>"><?php echo $y?></option>
						<?php } ?>
					</select>
				</div>
				
				<div class="position_relative height30 mr10 width86 fl">
					<select id="educationYear" name="educationYear" class="width86 required" onchange ="checkYear();" >
						<option value=""><?php echo $this->lang->line('yearTo');?></option>
						<?php foreach($year as $y) {
						$selected = "Selected";
						?>
						<option value="<?php echo $y;?>"><?php echo $y?></option>
						<?php } ?>
					</select>
				</div>
				
				<div class="fl mr10">
					 <?php echo form_input($universityInput); ?>
				</div>
				
				<div class="fl mr10">
					 <?php echo form_input($degreeInput); ?>
				</div>
			</div>
				
			
			<div class="fr mt15">
				<input class="red p10 bdr_a0a0a0 fshel_bold min_width_79" value="Save" type="button" onclick = "$('#educationForm').submit();" />
				<input id="cancelBtn" class="red p10 bdr_a0a0a0 fshel_bold min_width_79 dn" value="Cancel" type="button" onclick = "resetForm();" />
			</div>
			<?php 
			echo form_input($educationIdInput);
		echo form_close();?>
		<ul class="list_box pt20 clearb" id="educationData">
			<?php
			if( is_array($educationValues) && count($educationValues) > 0 ) {
				foreach($educationValues as $education) { ?>
					<li id="profileEducation_<?php echo $education->educationId;?>" class="mb10 pl30">
						<span class="bg_f9f9f9 width100_per lineH21"> 
							<span class=" fl width176 pl23"><?php echo $education->university;?> </span> 
							<?php echo $education->degree;?>
							<span class="red mr20 fr">
								<a title="<?php echo $this->lang->line('edit')?>" href="javascript:void(0)" onclick="editEducation(this)" year_from="<?php echo $education->year_from;?>" year_to="<?php echo $education->year_to;?>" university="<?php echo $education->university;?>" degree="<?php echo $education->degree;?>" educationId="<?php echo $education->educationId;?>">Edit</a>
								/ 
								<a href="javascript:void(0)" onclick="deleteEducation('<?php echo $education->educationId;?>');" >Delete </a>
							</span> 
						</span>
					</li>
				<?php 	
				} 
			} ?>
		</ul>
		<!-- Form buttons -->
        <?php 
        // set back url
        $data['backPage'] =  '/workprofile/worklocation';
        // set next form name
        $data['nextPage'] = '/workprofile/employment';
        $data['isNextstep'] = 1;
		$this->load->view('workProfile/wizardform/common_buttons',$data);
        ?>
	</div>
</div>

<script>
    $(document).ready(function() {
        // manage visa submit form 
        $("#educationForm").validate({
            submitHandler: function() {
                var fromData=$("#educationForm").serialize();
				loader();
                $.post('<?php echo $baseUrl.'/addprofileeducation/';?>',fromData, function(data) {
                    if(data) {
                        if(data.editId > 0) {
                            $('#profileEducation_'+data.editId).html(data.educationHtml);
                        } else {
                            $('#educationData').prepend(data.educationHtml);
                        }
                        // append form values as blank
                        resetForm();
                    }
                },'json');
            }
        });
    });
    
    // education manage workrprofile
    function editEducation(obj) {
        var educationId = $(obj).attr('educationId');
        var yearFrom = $(obj).attr('year_from');
        var yearTo = $(obj).attr('year_to');
        var university = $(obj).attr('university');
		var degree = $(obj).attr('degree');
			
        // set form values in fields
        $('#educationId').val(educationId);     
        setSeletedValueOnDropDown( 'educationYear',yearFrom );
        setSeletedValueOnDropDown( 'educationYearTo',yearTo );
        $('#university').val(university);  
		$('#degree').val(degree);   
     
        // manage buttons
        $('#cancelBtn').show();
    }
    
    // reset visa form values
    function resetForm() {
        $('#educationId').val(0);
        setSeletedValueOnDropDown( 'educationYear','' );
        setSeletedValueOnDropDown( 'educationYearTo','' );
        $('#university').val('');  
        $('#degree').val('');  
        $('#cancelBtn').hide();
    }
    
    // remove education entry from workrprofile
    function deleteEducation(educationId) {
        confirmBox("If you delete this, it will be deleted immediately.", function () {
             var fromData = 'educationId='+educationId;
             $.post('<?php echo $baseUrl.'/deleteprofileeducation/';?>',fromData, function(data) {
                if(data.deleted == 1 && data.countResult == 0) {
                    $("#profileEducation_"+educationId).fadeOut("normal", function() {
                        $(this).remove();
                    });
                }
            },'json');
        });
    }	
    
    // check education year diffrences
    function checkDate() {
		
		var toYear = $('#educationYear').val();
		var fromYear =$('#educationYearTo').val();
		
		if(fromYear <= toYear) {
			alert("To must be greater ");
			setSeletedValueOnDropDown('educationYearTo','To');
		}
	}

</script>
