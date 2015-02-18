<div class="contentcontainer">
	<div class="headings altheading">
		<h2><?php echo $this->lang->line('manage_email_template'); ?> </h2>
	</div>
	<form name="update_email" method="post" action="admin_manage_email_templates/update_email_template/<?php echo $result[0]->key ?>">
	<div class="contentbox">
			<?php echo $this->session->flashdata('error_message'); ?>

		<table width="100%">
			<input type="hidden" name="emailId" id="emailId" value="<?php echo $result[0]->emailId ?>" />
			<thead>
				<tr>
					<td><?php echo $this->lang->line('manage_email_language_id'); ?><td>
					<td><input type="text" name="language_id" id="language_id" value="<?php echo $result[0]->language_id; ?>" /></td>
				</tr>
				<tr>
					<td><?php echo $this->lang->line('manage_email_templates_key'); ?><td>
					<td><input type="text" name="key" id="key" value="<?php echo $result[0]->key; ?>" /></td>

				</tr>
                <tr>
                    <td><?php echo $this->lang->line('manage_email_templates_resend_period'); ?></td><td></td>
                    <td>
                        <input style="float: left" type="text" name="resend_period" id="resend_period" value="<?php echo $result[0]->resend_period; ?>" />
                        <p style="padding-top: 5px">days</p>
                    </td>

                </tr>
                <tr>
                    <td><?php echo $this->lang->line('manage_email_templates_resend_limit'); ?></td><td></td>
                    <td>
                        <input style="float: left" type="text" name="resend_limit" id="resend_limit" value="<?php echo $result[0]->resend_limit; ?>" />
                        <p style="padding-top: 5px">times</p>
                    </td>

                </tr>
                <tr>
                    <td><?php echo $this->lang->line('manage_email_templates_preferred_method'); ?></td><td></td>
                    <td>
                        <select name="preferred_method" id="preferred_method">
                            <option <?php echo $result[0]->preferred_method == 'SES' ? 'selected="selected"' :''; ?> value="SES">SES</option>
                            <option <?php echo $result[0]->preferred_method == 'SMTP' ? 'selected="selected"' :''; ?> value="SMTP">SMTP</option>
                        </select>
                    <td>
                </tr>
				<tr>
					<td><?php echo $this->lang->line('manage_email_templates_subject'); ?><td>
					<td><input type="text" name="subject" id="subject" value="<?php echo $result[0]->subject; ?>" /></td>

				</tr>
				<tr>
					<td><?php echo $this->lang->line('manage_email_templates_html_body'); ?><td>
                    <td><?php $this->fckeditor->Create();?></td>
				</tr>
                <tr>
                    <td><?php echo $this->lang->line('manage_email_templates_text_body'); ?><td>
                    <td> <textarea name="body_text" rows="10" cols="60"> <?php echo $result[0]->body_text;?></textarea></td>
                </tr>
				<tr>
					<td><?php echo $this->lang->line('manage_email_templates_from_name'); ?><td>
					<td><input type="text" name="from_name" id="from_name" value="<?php echo $result[0]->
from_name; ?>" /></td>

				</tr>

				<tr>
					<td><?php echo $this->lang->line('manage_email_templates_from_email'); ?><td>
					<td><input type="text" name="from_email" id="from_email" value="<?php echo $result[0]->from_email; ?>" /></td>

				</tr>
				<tr>
					<td colspan="2">
					</td>
					<td>				
						<button class="botton" name="edit"  >
							<span class="button next_bt"><span><?php echo $this->lang->line('update_button')?></span></span>
						</button>
						<button class="button" onClick="triggerClose();">
							<span class="button next_bt"><span><?php echo $this->lang->line('cancel_button')?></span></span>
						</button>
					</td>
				</tr>		

				
			</thead>
			
			
		</table>
	
	</div>
	
	</form>
</div>
