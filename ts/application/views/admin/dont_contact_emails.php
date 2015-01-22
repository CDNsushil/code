<div class="contentcontainer">
    <div class="headings altheading">
        <h2>Don't Contact Email </h2>
    </div>
    <form name="update_email" method="post" action="/admin/admin/dont_contact_emails">
        <div class="contentbox">
            <?php echo $this->session->flashdata('error_message'); ?>
            <input type="hidden" name="id" id="id" value="<?php echo @$emails[0]->id ?>" />
            <table width="100%">
                <tr>
                    <td>Emails<td>
                    <td>
                        <textarea rows="20" cols="100" name="emails"><?php echo @$emails[0]->emails ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td>
                        <button class="botton" name="edit"  >
                            <span class="button next_bt"><span><?php echo $this->lang->line('update_button')?></span></span>
                        </button>
                    </td>
                </tr>
            </table>
        </div>
    </form>
</div>