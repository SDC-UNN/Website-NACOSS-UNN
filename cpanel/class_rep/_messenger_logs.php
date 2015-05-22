<?php
//Initializing variables with default values
$defaultPage = "index.php?p=1";
$message_log_sent = $admin->messageLog('sms', 1);
//$message_log_draft = $admin->messageLog('sms', 0);
?>
<div>
   <h4>MESSENGER: MESSAGE LOGS >> SMS</h4>
   <div class="row">
      <div class="span10">
        <a href="index.php?p=21" class="button bg-blue bg-hover-dark fg-white place-right">E-Mail LOG</a>
        <a href="index.php?p=2" class="button disabled place-right"> SMS LOG </a>
      </div>
   </div>
   <?php if(isset($_GET['success']) ){ ?>
   <div class="row"><strong class="span9" style="color:green">Message Delivered Successfully.</strong></div>
   <?php } ?>
	
    <br/>
        <div class="row ntm">
                <div class="panel no-border bg-transparent" data-role="panel">
                    <p class="panel-header"><b>Sent Messages</b></p>
                    <div class="panel-content bg-grayLighter">
                    <table class="table hovered bordered">
                        <thead>
                            <tr>
                                <th class="text-left">SN</th>
                                <th class="text-left">Message</th>
                                <th class="text-left">Recipients</th>
                                <th class="text-left">Created&hellip;</th>
                                <th class="text-left">Sent&hellip;</th>
                                <th class="text-left">&hellip;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            for ($index = 0; $index < count($message_log_sent); $index++) {
                                $row = $message_log_sent[$index];
                                if ($index != 0 && $index % 20 === 0) {
                                    echo '<tr><td></td><td colspan="6"><a href="#top">back to top</a></td></tr>';
                                }
                                ?>
                                <tr>                            
                                    <td class="text-left"><?= $index + 1 ?></td>
                                    <td class="text-left" title="<?= $row['message']; ?>"><?= substr($row['message'],0,50); ?></td>
                                    <td class="text-left"><?= str_replace(',','<br/>',$row['recipients']); ?></td>
                                    <td class="text-left" nowrap><?= date('Y-m-d h-i-s', $row['time_created']); ?></td>
                                    <td class="text-left" nowrap><?= date('Y-m-d h-i-s', $row['time_sent']); ?></td>
                                    <td class="text-left"><input type="checkbox" name="logs[]" value="<?= $row['id'] ?>"/></td>
                                </tr>
                                <?php
                            }
                            echo '<tr><td></td><td colspan="6"><a href="#top">back to top</a></td></tr>';
                            ?>
                        </tbody>
                    </table>
                    </div>
                </div>
                <br/>
    
                <div class="panel no-border bg-transparent" data-role="panel">
                    <p class="panel-header"><b>Draft Messages</b></p>
                    <div class="panel-content bg-grayLighter">
						<strong>This Feature is currently not supported</strong>
                	</div>
             	</div>
        	</div>
</div>