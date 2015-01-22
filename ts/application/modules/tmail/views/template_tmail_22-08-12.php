<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
$selectedTmailMenu=$tmailHeading;
$$selectedTmailMenu='TmailselectedMenu';
$location2 = $this->uri->segment(2);
//echo $location2;
$selectedClass = 'selectTmailMenu style4';
$class = 'TmailMenu style4';
?>
<div class="tmailBlock">
		<div class="block-header"><?php echo $label['messageCenter']?></div>

          <div class="block-main" id="block-form" style="padding-left:5px; padding-right:5px; ">
            <table border="0" cellpadding="0" cellspacing="5"  id="submenu">
              <tr>
                <td width="108" height="40"  class="<?php if($location2=='tmail'){ echo $selectedClass; } else { echo $class; }?>"><div align="center"><strong><a href="<?php echo base_url('tmail/inbox');?>"><?php echo $label['tmail']?></a></strong></div></td>
                <td width="108" class="<?php if($location2=='messagecenter'){ echo $selectedClass; } else { echo $class; }?>">
					<div align="center">
						<strong>
							<a href="<?php echo base_url().'messagecenter/contacts';?>">
							<?php echo $label['contacts']?>
							</a>
						</strong>
					</div>
				</td>
				
                <!--<td width="108" class="TmailMenu style4"><div align="center"><strong><a href="#"><?php //echo $label['socialMedia']?></a></strong></div></td>-->
              
              </tr>
            </table>
			
            <table width="100%"  style="border:1px solid #CCCCCC;">
              <tr>
                <td valign="top" >
					<?php echo $tmailContent;?>
				</td>
				
				<?php if($location2 !='messagecenter'){?>

                <td width="180" valign="top" ><table width="100%" border="0" cellspacing="5">
                  <tr>
                    <td><div class="button" style="float:right; "><a href="<?php echo base_url('tmail/compose');?>"><?php echo $label['compose']?></a></div></td>
                  </tr>
                  <tr>
                    <td height="30" class="borderBottom <?php echo @$Inbox;?>"><a href="<?php echo base_url('tmail/inbox');?>"><img src="<?php echo base_url();?>images/icons/icon-right.png" width="6" height="8" style="padding-right:5px;"/> <?php echo $label['inbox']?></a></td>
                  </tr>
                  <tr>
                    <td height="30" class="borderBottom <?php echo @$Sent;?>"><a href="<?php echo base_url('tmail/sent');?>"><img src="<?php echo base_url();?>images/icons/icon-right.png" width="6" height="8" style="padding-right:5px;"/> <?php echo $label['sent']?></a></td>
                  </tr>
                  <tr>
                    <td height="30" class="borderBottom <?php echo @$Trash;?>"><a href="<?php echo base_url('tmail/trash');?>"><img src="<?php echo base_url();?>images/icons/icon-right.png" width="6" height="8" style="padding-right:5px;"/> <?php echo $label['trash']?></a></td>
                  </tr>
                </table></td>
                
                  <?php }?>
                  
              </tr>
            </table>
          
      </div>
</div>
