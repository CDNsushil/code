<div style="width:0px;height:0px;visibility:hidden">
    <img class="tooltipClass" src="<?php echo ADMINIMG?>icons/active-icon.jpg"/>
    <img class="tooltipClass" src="<?php echo ADMINIMG?>icon_cross_sml.png"/>
    <img class="tooltipClass" src="<?php echo ADMINIMG?>loading.gif"/>
</div>
<div class="contentcontainer">
	<div class="headings altheading">
		<h2>Charity pages</h2>
	</div>
	<div class="contentbox">
		<table width="100%">
			<thead>
				<tr>
                    <th>Sr. No.</th>
					<th>Page Name</th>
					<th>Page Title</th>
					<th>Page City</th>
                    <th>Page Status</th>
                    
				</tr>
			</thead>
			
			<tbody>
				<?php $i=1; 
				foreach($page_data as $page){?>
					<tr>
						<td><?php echo $i;?></td>
						<td><?php echo $page->chpro_name ?></td>
						<td><?php echo $page->page_title ?></td>
						<td><?php echo $page->page_city ?></td>
                        <?php 
                            if($page->page_status == 0)
                            {
                                $icon    = 'icon_cross_sml.png';
                                $approve = 1;    
                            }
                            else if($page->page_status == 1)
                            {
                                $icon    = 'active-icon.jpg'; 
                                $approve = 0;
                            }  
                        ?>                 
                        <td>
                            <a status="<?php echo $approve?>" page_id="<?php echo $page->page_id;?>" class="page_action" href="javascript:void(0);">
                                <img class="tooltipClass" src="<?php echo ADMINIMG?>icons/<?php echo $icon;?>"/>
                            </a>
                        </td>
					</tr>
				<?php $i++; } ?>
			</tbody>
		</table>
	</div>
</div>
