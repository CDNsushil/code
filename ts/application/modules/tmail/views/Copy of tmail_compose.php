<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

$LabelAttributes = array(
'class'=>'orng width90px'
);

$formAttributes = array(
'name'=>'customForm',
'id'=>'customForm',
);
?>
<table width="100%" border="1" style="border-collapse:collapse; border-color:#CCCCCC;" cellpadding="4" cellspacing="4">
	<tr>
		<td style="padding:10px;"><a href="<?php echo base_url('tmail/index');?>">Inbox</a>&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url('tmail/sent');?>">Sent</a>&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url('tmail/trashed');?>">Trashed</a>&nbsp;&nbsp;&nbsp;<a href="<?php echo base_url('tmail/compose');?>">Compose</a></td>
	</tr>
</table>
<script type="text/javascript">
var d = new Date()
var gmtHours = -d.getTimezoneOffset()/60;
document.write("The local time zone is: GMT " + gmtHours);
</script> 
<br />
<?php echo form_open($this->uri->uri_string(),$formAttributes); ?>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
		<td colspan="3" align="left" valign="top" style="font-weight:bold; background:#F2F2F2; padding:4px;">Compose Mail</td>
	  </tr>
	  <tr>
		<td align="left" valign="top" style="font-weight:bold; background:#F2F2F2; padding:4px;">To:</td>
		<td align="left" valign="top" style="font-weight:bold; background:#F2F2F2; padding:4px;"><input class="required" type="text" name="recipientsId" id="recipientsId" value="" /></td>
		<td style="font-weight:bold; background:#F2F2F2; padding:4px;" class="red" id="emailMsg"><?php echo form_error('recipientsId'); ?><?php echo isset($errors['recipientsId'])?$errors['recipientsId']:''; ?></td>
	  </tr>
	  <tr>
		<td align="left" valign="top" style="font-weight:bold; background:#F2F2F2; padding:4px;">From:</td>
		<td colspan="2" align="left" valign="top" style="font-weight:bold; background:#F2F2F2; padding:4px;"><?php echo $result[0]['username']." ".$result[0]['email']; ?></td>
	  </tr>
	  <tr>
		<td align="left" valign="top" style="font-weight:bold; background:#F2F2F2; padding:4px;">Subject:</td>
		<td align="left" valign="top" style="font-weight:bold; background:#F2F2F2; padding:4px;"><input class="required" type="text" name="subject" id="subject" /></td>
		<td style="font-weight:bold; background:#F2F2F2; padding:4px;" class="red" id="emailMsg"><?php echo form_error('subject'); ?><?php echo isset($errors['subject'])?$errors['subject']:''; ?></td>
	  </tr>
	  <tr>
		<td align="left" valign="top" style="font-weight:bold; background:#F2F2F2; padding:4px;">Body:</td>
		<td align="left" valign="top" style="font-weight:bold; background:#F2F2F2; padding:4px;"><textarea class="required" name="body" id="body"></textarea></td>
		<td  style="font-weight:bold; background:#F2F2F2; padding:4px;" class="red" id="emailMsg"><?php echo form_error('body'); ?><?php echo isset($errors['body'])?$errors['body']:''; ?></td>
	  </tr>
	  <tr>
		<td align="left" valign="top" style="font-weight:bold; background:#F2F2F2; padding:4px;"></td>
		<td align="left" valign="top" style="font-weight:bold; background:#F2F2F2; padding:4px;">
		<div class="btn_wp">
				<div class="button_left">
					<div class="button_right">
							<div class="button_text signin">
		<input type="submit" name="send" id="send" value="send">
		</div>
					</div>
				</div>
			</div>
		</td>
		<td style="font-weight:bold; background:#F2F2F2; padding:4px;">&nbsp;</td>
	  </tr>
	  <tr>
		<td colspan="3" align="left" valign="top" style="height:10px;"></td>
	  </tr>
	</table>  
<?php echo form_close(); ?>

	<div class="block">
		<div class="block-header">MESSAGE CENTER</div>

          <div class="block-main" id="block-form" style="padding-left:5px; padding-right:5px; ">
            <table border="0" cellpadding="0" cellspacing="5"  id="submenu">
              <tr>
                <td width="108" height="40" background="images/background-left-nav-hover.jpg" class="style4"><div align="center"><strong><a href="toadsquare_tmail.html">Tmail</a></strong></div></td>
                <td width="108" background="images/background.jpg" class="style4"><div align="center"><strong><a href="toadsquare_manage_contacts.html">Contacts</a></strong></div></td>
                <td width="108" background="images/background.jpg" class="style4"><div align="center"><strong><a href="toadsquare_settings_socialmedia.html">Social Media</a></strong></div></td>
              
              </tr>
            </table>
            <table width="100%"  style="border:1px solid #CCCCCC;">
              <tr>
                <td valign="top" ><table width="100%" border="0" cellpadding="0" cellspacing="5" >
          <tr>
                          <td height="25" bgcolor="#09728F" class="fildsetHeading style4">Compose</td>
                  </tr>

                  <tr>
                    <td >
                    
                    <div style="border:1px solid #CCCCCC; background-color:#FFFFFF">
                         <table width="100%" border="0" cellpadding="0" cellspacing="5" >
                          <tr>
                            <td>Search by Name:
                              <input name="input9" type="text" class="form-input"/>
                                <img src="images/icons/search.gif" alt="" width="16" /></td>
                            <td><em>Below are list of my craved memebers to send Tmail.</em></td>
                          </tr>
                        </table>
                        
                        
                         <div style="height:180px; overflow:auto;">
                            <table width="100%" border="0" cellpadding="0" cellspacing="2" class="friendTable">
                              <tr>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                              </tr>
                              <tr>
                                <td><img src="images/People/49148_1841749135_356_q.jpg" width="50" height="50" /></td>
                                <td><img src="images/People/49309_557542801_4137836_q.jpg" width="50" height="50" /></td>
                                <td><img src="images/People/186722_100001568612505_8165991_q.jpg" width="50" height="50" /></td>
                                <td><img src="images/People/195309_1046679351_2680547_q.jpg" width="50" height="50" /></td>
                                <td><img src="images/People/202977_685847424_5054547_q.jpg" width="50" height="50" /></td>
                                <td><img src="images/People/211385_1070496897_2824570_q.jpg" width="50" height="50" /></td>
                                <td><img src="images/People/261032_620242677_2323210_q.jpg" width="50" height="50" /></td>
                                <td><img src="images/People/274146_100001261692932_2067611_q.jpg" width="50" height="50" /></td>
                              </tr>
                              <tr>
                                <td><table border="0" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td width="15"><input type="checkbox" /></td>
                                    <td>John Ray</td>
                                  </tr>
                                </table></td>
                                <td> <strong class="alreadyShared">
                                  <table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td width="15"><input type="checkbox" /></td>
                                      <td>John Ray</td>
                                    </tr>
                                  </table></td>
                                <td><table border="0" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td width="15"><input type="checkbox" /></td>
                                    <td>John Ray</td>
                                  </tr>
                                </table></td>
                                <td><table border="0" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td width="15"><input type="checkbox" /></td>
                                    <td>John Ray</td>
                                  </tr>
                                </table></td>
                                <td><table border="0" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td width="15"><input type="checkbox" /></td>
                                    <td>John Ray</td>
                                  </tr>
                                </table></td>
                                <td ><table border="0" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td width="15"><input type="checkbox" /></td>
                                    <td>John Ray</td>
                                  </tr>
                                </table></td>
                                <td><table border="0" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td width="15"><input type="checkbox" /></td>
                                    <td>John Ray</td>
                                  </tr>
                                </table></td>
                                <td><table border="0" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td width="15"><input type="checkbox" /></td>
                                    <td>John Ray</td>
                                  </tr>
                                </table></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td><img src="images/People/49148_1841749135_356_q.jpg" width="50" height="50" /></td>
                                <td><img src="images/People/49309_557542801_4137836_q.jpg" width="50" height="50" /></td>
                                <td><img src="images/People/186722_100001568612505_8165991_q.jpg" width="50" height="50" /></td>
                                <td><img src="images/People/195309_1046679351_2680547_q.jpg" width="50" height="50" /></td>
                                <td><img src="images/People/202977_685847424_5054547_q.jpg" width="50" height="50" /></td>
                                <td><img src="images/People/211385_1070496897_2824570_q.jpg" width="50" height="50" /></td>
                                <td><img src="images/People/261032_620242677_2323210_q.jpg" width="50" height="50" /></td>
                                <td><img src="images/People/274146_100001261692932_2067611_q.jpg" width="50" height="50" /></td>
                              </tr>
                              <tr>
                                <td><table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td width="15"><input type="checkbox" /></td>
                                      <td>John Ray</td>
                                    </tr>
                                </table></td>
                                <td><strong class="alreadyShared">
                                    <table border="0" cellpadding="0" cellspacing="0">
                                      <tr>
                                        <td width="15"><input type="checkbox" /></td>
                                        <td>John Ray</td>
                                      </tr>
                                  </table></td>
                                <td><table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td width="15"><input type="checkbox" /></td>
                                      <td>John Ray</td>
                                    </tr>
                                </table></td>
                                <td><table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td width="15"><input type="checkbox" /></td>
                                      <td>John Ray</td>
                                    </tr>
                                </table></td>
                                <td><table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td width="15"><input type="checkbox" /></td>
                                      <td>John Ray</td>
                                    </tr>
                                </table></td>
                                <td ><table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td width="15"><input type="checkbox" /></td>
                                      <td>John Ray</td>
                                    </tr>
                                </table></td>
                                <td><table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td width="15"><input type="checkbox" /></td>
                                      <td>John Ray</td>
                                    </tr>
                                </table></td>
                                <td><table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td width="15"><input type="checkbox" /></td>
                                      <td>John Ray</td>
                                    </tr>
                                </table></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              
                              <tr>
                                <td><img src="images/People/49148_1841749135_356_q.jpg" width="50" height="50" /></td>
                                <td><img src="images/People/49309_557542801_4137836_q.jpg" width="50" height="50" /></td>
                                <td><img src="images/People/186722_100001568612505_8165991_q.jpg" width="50" height="50" /></td>
                                <td><img src="images/People/195309_1046679351_2680547_q.jpg" width="50" height="50" /></td>
                                <td><img src="images/People/202977_685847424_5054547_q.jpg" width="50" height="50" /></td>
                                <td><img src="images/People/211385_1070496897_2824570_q.jpg" width="50" height="50" /></td>
                                <td><img src="images/People/261032_620242677_2323210_q.jpg" width="50" height="50" /></td>
                                <td><img src="images/People/274146_100001261692932_2067611_q.jpg" width="50" height="50" /></td>
                              </tr>
                              <tr>
                                <td><table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td width="15"><input type="checkbox" /></td>
                                      <td>John Ray</td>
                                    </tr>
                                </table></td>
                                <td><strong class="alreadyShared">
                                    <table border="0" cellpadding="0" cellspacing="0">
                                      <tr>
                                        <td width="15"><input type="checkbox" /></td>
                                        <td>John Ray</td>
                                      </tr>
                                  </table></td>
                                <td><table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td width="15"><input type="checkbox" /></td>
                                      <td>John Ray</td>
                                    </tr>
                                </table></td>
                                <td><table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td width="15"><input type="checkbox" /></td>
                                      <td>John Ray</td>
                                    </tr>
                                </table></td>
                                <td><table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td width="15"><input type="checkbox" /></td>
                                      <td>John Ray</td>
                                    </tr>
                                </table></td>
                                <td ><table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td width="15"><input type="checkbox" /></td>
                                      <td>John Ray</td>
                                    </tr>
                                </table></td>
                                <td><table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td width="15"><input type="checkbox" /></td>
                                      <td>John Ray</td>
                                    </tr>
                                </table></td>
                                <td><table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td width="15"><input type="checkbox" /></td>
                                      <td>John Ray</td>
                                    </tr>
                                </table></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              
                              <tr>
                                <td><img src="images/People/49148_1841749135_356_q.jpg" width="50" height="50" /></td>
                                <td><img src="images/People/49309_557542801_4137836_q.jpg" width="50" height="50" /></td>
                                <td><img src="images/People/186722_100001568612505_8165991_q.jpg" width="50" height="50" /></td>
                                <td><img src="images/People/195309_1046679351_2680547_q.jpg" width="50" height="50" /></td>
                                <td><img src="images/People/202977_685847424_5054547_q.jpg" width="50" height="50" /></td>
                                <td><img src="images/People/211385_1070496897_2824570_q.jpg" width="50" height="50" /></td>
                                <td><img src="images/People/261032_620242677_2323210_q.jpg" width="50" height="50" /></td>
                                <td><img src="images/People/274146_100001261692932_2067611_q.jpg" width="50" height="50" /></td>
                              </tr>
                              <tr>
                                <td><table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td width="15"><input type="checkbox" /></td>
                                      <td>John Ray</td>
                                    </tr>
                                </table></td>
                                <td><strong class="alreadyShared">
                                    <table border="0" cellpadding="0" cellspacing="0">
                                      <tr>
                                        <td width="15"><input type="checkbox" /></td>
                                        <td>John Ray</td>
                                      </tr>
                                  </table></td>
                                <td><table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td width="15"><input type="checkbox" /></td>
                                      <td>John Ray</td>
                                    </tr>
                                </table></td>
                                <td><table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td width="15"><input type="checkbox" /></td>
                                      <td>John Ray</td>
                                    </tr>
                                </table></td>
                                <td><table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td width="15"><input type="checkbox" /></td>
                                      <td>John Ray</td>
                                    </tr>
                                </table></td>
                                <td ><table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td width="15"><input type="checkbox" /></td>
                                      <td>John Ray</td>
                                    </tr>
                                </table></td>
                                <td><table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td width="15"><input type="checkbox" /></td>
                                      <td>John Ray</td>
                                    </tr>
                                </table></td>
                                <td><table border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td width="15"><input type="checkbox" /></td>
                                      <td>John Ray</td>
                                    </tr>
                                </table></td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                            </table>
                         </div>
                         
                         <br/>
                         <div style="height:55px; overflow:auto; border-top:1px solid #CCCCCC; font-size:11px;">
                           <table  border="0" align="left" cellpadding="0" cellspacing="5">
                             <tr>
                               <td><img src="images/icons/1316427345_delete.png" width="12" /></td>
                               <td>John Ray</td>
                             </tr>
                           </table>
                           <table  border="0" align="left" cellpadding="0" cellspacing="5">
                             <tr>
                               <td><img src="images/icons/1316427345_delete.png" width="12" /></td>
                               <td>User name will come</td>
                             </tr>
                           </table>
                           <table  border="0" align="left" cellpadding="0" cellspacing="5">
                             <tr>
                               <td><img src="images/icons/1316427345_delete.png" width="12" /></td>
                               <td>John Ray</td>
                             </tr>
                           </table>
                           <table  border="0" align="left" cellpadding="0" cellspacing="5">
                             <tr>
                               <td><img src="images/icons/1316427345_delete.png" width="12" /></td>
                               <td>John Ray</td>
                             </tr>
                           </table>
                           <table  border="0" align="left" cellpadding="0" cellspacing="5">
                             <tr>
                               <td><img src="images/icons/1316427345_delete.png" width="12" /></td>
                               <td>John Ray</td>
                             </tr>
                           </table>
                           <table  border="0" align="left" cellpadding="0" cellspacing="5">
                             <tr>
                               <td><img src="images/icons/1316427345_delete.png" width="12" /></td>
                               <td>John Ray</td>
                             </tr>
                           </table>
                           <table  border="0" align="left" cellpadding="0" cellspacing="5">
                             <tr>
                               <td><img src="images/icons/1316427345_delete.png" width="12" /></td>
                               <td>User name will come</td>
                             </tr>
                           </table>
                           <table  border="0" cellpadding="0" cellspacing="5">
      <tr>
        <td><img src="images/icons/1316427345_delete.png" width="12" /></td>
        <td>John Ray</td>
      </tr>
    </table>
                           <table  border="0" align="left" cellpadding="0" cellspacing="5">
                              <tr>
                                <td><img src="images/icons/1316427345_delete.png" width="12" /></td>
                                <td>John Ray</td>
                              </tr>
                            </table>
                           <table  border="0" align="left" cellpadding="0" cellspacing="5">
                           <tr>
                             <td><img src="images/icons/1316427345_delete.png" width="12" /></td>
                             <td>John Ray</td>
                           </tr>
                         </table>
                           <table  border="0" align="left" cellpadding="0" cellspacing="5">
                           <tr>
                             <td><img src="images/icons/1316427345_delete.png" width="12" /></td>
                             <td>John Ray</td>
                           </tr>
                         </table>
                        </div>
                     </div>
                     
                     <br />
                     Subject:<br />
                     <input type="text" name="textfield" id="textfield" style="width:100%" />
                     <br />
                     <br/>
                     Message:
                     <textarea name="" cols="" rows=""></textarea>                     </td>
                  </tr>
                  <tr>
                    <td ><div class="button" style="float:right; "> Send</div></td>
                  </tr>

                </table>
                </td>
                <td width="180" valign="top" ><table width="100%" border="0" cellspacing="5">
                  <tr>
                    <td><div class="button" style="float:right; "> Compose</div></td>
                  </tr>
                  <tr>
                    <td height="30" class="borderBottom" style="border-right:5px #FF6666 solid; border-color:#FF6666;"><a href="#"><img src="images/icon-right.png" width="6" height="8" style="padding-right:5px;"/> Inbox</a></td>
                  </tr>
                  <tr>
                    <td height="30" class="borderBottom"><a href="#"><img src="images/icon-right.png" width="6" height="8" style="padding-right:5px;"/> Sent</a></td>
                  </tr>
                  <tr>
                    <td height="30" class="borderBottom"><a href="#"><img src="images/icon-right.png" width="6" height="8" style="padding-right:5px;"/> Trash</a></td>
                  </tr>
                </table></td>
              </tr>
            </table>
            <br />
            <div class="block-navigation"><a href="#">First</a><a href="#">Previous</a><a href="#" class="page current">1</a><a href="#" class="page">2</a><a href="#" class="page">3</a><a href="#" class="page">4</a><a href="#" class="page">5</a><a href="#">Next</a><a href="#">Last</a></div>
          </div>
      </div>
