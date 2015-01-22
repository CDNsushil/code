<style>
    .contentbox p {
        color: red;
        padding-bottom: 5px;
    }
    .contentbox p.success1 {
        color: green;
    }
</style>
<div class="contentcontainer">
    <div class="headings altheading">
        <h2><?php echo $this->lang->line('admin_settings'); ?></h2>
    </div>

    <div class="contentbox">
        <div class="clear"></div>

        <h2>Change password</h2>
        
        <?php if ($success): ?>
            <p class="success1">Password have changed successfully</p>
        <?php endif; ?>
        
        <?php echo validation_errors(); ?>

        <form method="post" action="<?php echo site_url('admin/admin/settings'); ?>">
            <label for="old_password">Old password</label>
            <input type="password" name="old_password" id="old_password" value="<?php echo set_value('old_password'); ?>"/>

            <label for="new_password">New password</label>
            <input type="password" name="new_password" id="new_password" value="<?php echo set_value('new_password'); ?>"/>

            <label for="repeat_password">Repeat password</label>
            <input type="password" name="repeat_password" id="repeat_password" value="<?php echo set_value('repeat_password'); ?>"/>
            <br/>
            <input type="submit" value="Save" />
        </form>
    </div>
    <div class="fRight"></div>
</div>

