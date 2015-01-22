<div class="contentcontainer">
    <div class="headings altheading">
        <h2><?php echo $this->lang->line('admin_violation_report'); ?></h2>
    </div>

    <div class="contentbox">

        <!--        <div class="fRight">
                    <form name="customform" action="" method="post" > 
                        <div class="fLeft">
                            <input defaultvalue="Enter Member Name" type="text" name="searchTxt"  onfocus="if(this.value==this.defaultvalue){ this.value=''; }" onblur="if(this.value==''){ this.value = this.defaultvalue; }"  value="<?php echo (@$searchTxt == '' ? 'Enter Member Name' : @$searchTxt); ?>" />
                        </div>
                        <div title="Search" class="tooltipClass fLeft">
                            <input type="image" src="<?php echo ADMINIMG . "search.jpg"; ?>"  alt="Search" width="15px" />
                        </div>
                        <div class="clear"></div>
                    </form>
                </div>-->
        <div class="clear"></div>

        <table width="100%">
            <thead>
                <tr>
                    <th><?php echo $this->lang->line('admin_srno'); ?></th>
                    <th><?php echo $this->lang->line('admin_violation_report_user_id'); ?></th>
                    
                    <th><?php echo $this->lang->line('admin_violation_report_first'); ?></th>
                    <th><?php echo $this->lang->line('admin_violation_report_last'); ?></th>
                    <th><?php echo $this->lang->line('admin_violation_report_cc'); ?></th>
                    <th><?php echo $this->lang->line('admin_violation_report_type'); ?></th>
                    <th><?php echo $this->lang->line('admin_violation_report_address'); ?></th>
                    <th><?php echo $this->lang->line('admin_violation_report_text'); ?></th>
                    
                    <th><?php echo $this->lang->line('admin_violation_report_created'); ?></th>
                </tr>
            </thead>

            <tbody>
                <?php if ($reports != false): ?>
                    <?php foreach ($reports as $key => $report): ?>
                        <tr>
                            <th><?php echo $report->id ?></th>
                            <th><?php echo $report->user_id ?></th>
                            <th><?php echo $report->first_name ?></th>
                            <th><?php echo $report->last_name ?></th>
                            <th><?php echo $report->cc_username ?></th>
                            <th><?php echo $report->how_got ?></th>
                            
                            <?php if ($report->how_got == 'email'): ?>
                                <th><?php echo $report->email_address ?></th>
                                <th><?php echo $report->email_copy ?></th>
                            <?php else: ?>
                                <th><?php echo $report->url ?></th>
                                <th><?php echo $report->web_post_message ?></th>
                            <?php endif; ?>
                            
                            <th><?php echo $report->created ?></th>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div class="fRight"><?php echo $pagging; ?></div>
</div>

