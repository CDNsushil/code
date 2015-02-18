<div class="contentcontainer">
    <div class="headings altheading">
        <h2><?php echo $this->lang->line('admin_unsubscribed_list'); ?></h2>
    </div>

    <div class="contentbox">
        <div class="clear"></div>
        
        <table width="100%">
            <thead>
                <tr>
                    <th><?php echo $this->lang->line('admin_srno'); ?></th>
                    <th><?php echo $this->lang->line('admin_email'); ?></th>
                    <th><?php echo $this->lang->line('admin_unsubscribed_at'); ?></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($unsubscribe_list as $row): ?>
                    <tr>
                        <th><?php echo $row->id ?></th>
                        <th><?php echo $row->email ?></th>
                        <th><?php echo $row->created ?></th>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
    </div>
    <div class="fRight"></div>
</div>

