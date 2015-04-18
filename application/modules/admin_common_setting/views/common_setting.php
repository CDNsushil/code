<div class="contentcontainer">
	<div class="headings altheading">
		<h2>Cache Management</h2>
	</div>
	<div class="contentbox">
		<table width="100%">
			<thead>
				<tr>
					<th width="40%">Option</th>
					<th width="60%">Action</th>
				</tr>
			</thead>
			<tr>
				<td colspan="2"><span style="color:#0a0;"><?php echo $this->session->flashdata('global_setting_saved');?></span></td>
			</tr>
			<?php /* ?>
			<tr class="dividerRow">
				<td width="40%"><b>Clear Template Cache</b></td>
				<td width="60%">
					<div class="user_section_box">
						<div class="fLeft">
							<button id="clear_template_cache" class="reset" type="button" onClick="common_settings('clearCC','clear_template_cache','clear_template_cache_status','loading');">
								<span class="button next_bt text_caseL">
									<span class="width_85px" id="save_image">Clear</span>
								</span>
							</button>
							<div class="loading" style="display:none;"></div>
						</div>
						<div class="clear"></div>
					</div>
					<div id="clear_template_cache_status" style="display:none;font-weight:bold;font-size:10px;"></div>
				</td>
			</tr>	
			
			<tr class="dividerRow">
				<td width="40%"><b>Upload Template Cache to S3</b></td>
				<td width="60%">
					<div class="user_section_box">
						<div class="fLeft">
							<button id="upload_template_cache" class="reset" type="button" onClick="common_settings('uploadCC','upload_template_cache','upload_template_cache_status','loading1');">
								<span class="button next_bt text_caseL">
									<span class="width_85px" id="save_image">Upload</span>
								</span>
							</button>
							<div class="loading1" style="display:none;"></div>
						</div>
						<div class="clear"></div>
					</div>
					<div id="upload_template_cache_status" class="common_settings_status"></div>
				</td>
			</tr>	
			<?php */ ?>
			<tr class="dividerRow">
				<td width="40%"><b>Flush Memcache</b></td>
				<td width="60%">
					<div class="user_section_box">
						<div class="fLeft">
							<button id="flush_memcache_template_cache" class="reset" type="button" onClick="common_settings('flush_memcache','flush_memcache_template_cache','flush_memcache_template_cache_status','loading2');">
								<span class="button next_bt text_caseL">
									<span class="width_85px" id="save_image">Flush</span>
								</span>
							</button>
							<div class="loading2" style="display:none;"></div>
						</div>
						<div class="clear"></div>
					</div>
					<div id="flush_memcache_template_cache_status" class="common_settings_status"></div>
				</td>
			</tr>

			<tr class="dividerRow">
				<td width="40%"><b>Clear App Cache</b></td>
				<td width="60%">
					<div class="user_section_box" style="width:auto; margin-right:10px;">
						<div class="fLeft">
							<button id="clear_app_cache_template_cache" class="reset" type="button" onClick="common_settings('clear_app_cache','clear_app_cache_template_cache','clear_app_cache_template_cache_status','loading3');">
								<span class="button text_caseL" style="width:144px;">
									<span class="width_85px" id="save_image">Clear App Cache</span>
								</span>
							</button>
							<div class="loading3" style="display:none;"></div>
						</div>
						<div class="clear"></div>
					</div>
					<div id="clear_app_cache_template_cache_status" class="common_settings_status"></div>
				</td>
			</tr>			
		</table>
	</div>
</div>
<script language="javascript">
// function to perform different actions
function common_settings(action,main_div,response_div,loading_div) {
	var getLoader="<div class='ajaxLoading' id='ajaxLoading'></div>";
	//var key = "S7MyMrZSKqgsykstyCsoLdIrKM1LLygtSyzRy0pTsgYA";
	var key = "<?php echo encode($this->config->item('SITE_CACHE_CLEAR'));?>";
	$.ajax({
		url:BASEPATH+'home/'+action+'/'+key,
		type:'get',
		data:{},
		beforeSend : function(){
			$("#"+main_div).hide();
			$("."+loading_div).show();
			$("."+loading_div).html(getLoader);
		},
		success:function(response){
			if(response){
				$("."+loading_div).hide();
				$("#"+main_div).show();
				$("#"+response_div).show();
				$("#"+response_div).html(response);
			}
		},
		failure:function(err){}
	});
}
</script>