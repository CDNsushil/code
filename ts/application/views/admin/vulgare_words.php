<div class="contentcontainer">
    <div class="headings altheading">
        <h2><?php echo $this->lang->line('manage_vulgar') ?></h2>
    </div>

    <div class="contentbox">
        <div class="fRight"></div>
        <div class="clear"></div>

        <form action="" method="post">
            <select name="new_list_lang_id" >
                <option value="0"><?php echo $this->lang->line('admin_new_list_vulgare') ?></option>
                <?php foreach ($all_languages as $lang): ?>
                    <option value="<?php echo $lang->language_id ?>">
                        <?php echo $lang->language ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="submit" value="Create" style="font-size: 16px;"/>		
        </form>
        
        <?php if (count($list)): ?>
            <h3><?php echo $this->lang->line('admin_new_list_vulgare_title') ?></h3>
        <?php endif; ?>
        
        <ul>
            <?php foreach ($list as $row): ?>
                <li>
                    <a href="<?php echo BASEURL?>admin/admin/admin_vulgar/<?php echo $row->id; ?>">
                        <?php echo $row->language ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

    </div>
    <div class="fRight"></div>
</div>

