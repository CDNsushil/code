<div class="contentcontainer">
    <div class="headings altheading">
        <h2><?php echo $this->lang->line('manage_consulting_agreement'); ?></h2>
    </div>

    <div class="contentbox">
        <div class="clear"></div>
        
        <table width="100%">
            <thead>
                <tr>
                    <th><?php echo $this->lang->line('admin_srno'); ?></th>
                    <th><?php echo $this->lang->line('user_name'); ?></th>
                    <th><?php echo $this->lang->line('admin_email'); ?></th>
                    <th><?php echo $this->lang->line('admin_status'); ?></th>
                    <th><?php echo $this->lang->line('admin_registration_date'); ?></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($users as $user): ?>
                    <?php if ($user->is_register_for_points != '0'): ?>
                        <tr>
                            <th><?php echo $user->user_id ?></th>
                            <th><?php echo $user->username ?></th>
                            <th><?php echo $user->email ?></th>

                            <th>
                                <?php if ($user->is_register_for_points): ?>
                                    <?php echo $this->lang->line('admin_is_signed'); ?>
                                <?php else: ?>
                                    <?php echo $this->lang->line('admin_not_signed'); ?>
                                <?php endif; ?>
                            </th>

                            <th><?php echo $user->created_at ?></th>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        
    </div>
    <div class="fRight"></div>
</div>

