<script>
    $(document).ready(function(){
        $('.delete_name').live('click',function(){
            if (confirm('Delete this reserved name?')) {
                window.location.href = $(this).attr('href');
            }
        });
    });
</script>

<div class="contentcontainer">
    <div class="headings altheading">
        <h2><?php echo $this->lang->line('manage_reserved_names') ?></h2>
    </div>

    <div class="contentbox">
        <div class="fRight"></div>
        <div class="clear"></div>

        <form action="" method="post">
            <?php if ($this->session->userdata('error')): ?>
                <p style="color:red">
                    <?php echo $this->session->userdata('error'); ?>
                </p>
                <input type="text" name="new_name" style="font-size: 16px;" value="<?php echo $this->session->userdata('creating_username'); ?>"/>
                <?php $this->session->unset_userdata('error'); ?>
                <?php $this->session->unset_userdata('creating_username'); ?>
            <?php else: ?>
                <input type="text" name="new_name" style="font-size: 16px;"/>
            <?php endif; ?>
            
            <input type="submit" value="Create" style="font-size: 16px;"/>		
        </form>
        
        <?php if (count($names)): ?>
            <h3><?php echo $this->lang->line('manage_reserved_names_title') ?>:</h3>
        <?php endif; ?>
        
        <ul>
            <?php foreach ($names as $row): ?>
                <li>
                    <?php echo $row->username ?> - 
                    <a class="delete_name" onclick="return false;" href="<?php echo site_url('admin/admin/delete_reserved_name/' . $row->id); ?>" style="float:none;">Delete</a>
                </li>
            <?php endforeach; ?>
        </ul>

    </div>
    <div class="fRight"></div>
</div>

