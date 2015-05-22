<?php
//Initializing variables with default values
$defaultPage = "index.php?p=1";
$bills = getByCol('messenger_sms_biller', 'user_id', $admin->getAdminID());
?>
<div>
	<h4>MESSENGER: STATUS</h4>
    <table class="table hovered bordered">
      <thead>
          <tr>
              <th class="text-left" style="width:30%">Item</th>
              <th class="text-left">Status</th>
          </tr>
      </thead>
      <tbody>
          <tr>                            
              <td class="text-left">Total SMS Units</td>
              <td class="text-left"><?= $bills['units_assigned']; ?></td>
          </tr>
          <tr>                            
              <td class="text-left">Total SMS Sent</td>
              <td class="text-left"><?= $bills['units_used']; ?></td>
          </tr>
          <tr>                            
              <td class="text-left">SMS Units Remaining</td>
              <td class="text-left"><?= ($bills['units_assigned']-$bills['units_used']); ?></td>
          </tr>
      </tbody>
    </table>

</div>