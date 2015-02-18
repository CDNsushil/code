<script>
    $(document).ready(function(){
        $('.change_date').datepicker({
            dateFormat: "yy-mm-dd",
            onSelect: function(dateText, inst) {
                var country_id = $(this).attr('id').split('_');
                $.post('<?php echo site_url('admin/admin/change_country_availible_date') ?>', {id:country_id[1], date:dateText}, function(data){
                    $('#save_' + country_id[1]).html('saved');
                });
            }
        });
    });
</script>

<div class="contentcontainer">
    <div class="headings altheading">
        <h2><?php echo $this->lang->line('availible_countries'); ?></h2>
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
                    <th><?php echo $this->lang->line('admin_availible_country_name'); ?></th>
                    <th><?php echo $this->lang->line('admin_availible_country_iso'); ?></th>
                    <th width="250px"><?php echo $this->lang->line('admin_availible_date'); ?></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($countries as $country): ?>
                    <tr>
                        <th><?php echo $country->country_id ?></th>
                        <th><?php echo $country->country_name ?></th>
                        <th><?php echo $country->ccode ?></th>
                        <th>
                            <input type="text" class="change_date" id="country_<?php echo $country->country_id ?>" value="<?php echo $country->availible_from ?>" />
                            <span id="save_<?php echo $country->country_id ?>" style="color:green"></span>
                        </th>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
    </div>
    <div class="fRight"></div>
</div>

