<?php
//Initializing variables with default values
$defaultPage = "index.php?p=1";

$level = $admin->getField('level');
$groups = getStudentsList_contactGroups($admin, 0);
$students = getStudentsList($level);
$link = AdminUtility::getDefaultDBConnection();
$responce = "";

require_once('../class.SMS.php');
//require_once('class.Email.php');

if (isset($array['type']) and ( isset($array['next']) or isset($array['send']) )) {

    $type = $array['type'];

    if ($type == 'sms') {
        $sender_id = $array['sender_id'];
        $message_body = $array['message_body'];
        $num_of_sms_pages = $array['pages'];
    } elseif ($type == 'email') {
        $senders_name = $array['senders_name'];
        $reply_to = $array['reply_to'];
        $subject = $array['subject'];
        $message_body = $array['message_body'];
    }

    if (isset($array['send'])) {
        isset($array['groups']) ? $r_groups = $array['groups'] : $r_groups = array();
        isset($array['contacts']) ? $r_contacts = $array['contacts'] : $r_contacts = array();
        $contacts_ids = array();
        $contacts_ids = array_merge($r_contacts);

        //compile regno's
        foreach ($r_groups as $g) {
            $c = getByCol('messenger_contacts_groups', 'id', $g);
            $contacts_ids = array_merge(explode(',', $c['group_members']));
        }

        //compile contacts
        $q = "select * from users";
        $result = mysqli_query($link, $q);
        $all_contacts = array();
        while ($row = mysqli_fetch_array($result)) {
            $all_contacts[$row['regno']] = array('sms' => $row['phone'], 'email' => $row['email']);
        }

        //pick-out selected contacts
        $required_contacts = array();
        foreach ($contacts_ids as $c) {
            $required_contacts[] = $all_contacts[$c][$type];
        }
        $recipients = implode(',', $required_contacts);

        //send out messages
        if ($type == 'sms') {
            $biller = $admin->getSmsBillStatus();
            $balance = $biller['units_assigned'] - $biller['units_used'];
            $num_of_recipients = count($required_contacts);
            $cost = ($num_of_recipients * $num_of_sms_pages);
            if ($balance > $cost) {
                $settings = $admin->getSettings();
                $gateway = $settings['sms_api_gatewayURL']['value'];
                $username = $settings['sms_api_gatewayUsername']['value'];
                $password = $settings['sms_api_gatewayPassword']['value'];
                $sms = new SMS($gateway, $username, $password, $sender_id, $message_body, $recipients);
                if ($sms->send()) {
                    $units_used = $sms->get_unitsUsed();
                    $q2 = "update messenger_sms_biller set units_used=(units_used + " . $units_used . ") where user_id='" . $admin->getAdminID() . "'";
                    $q3 = "insert into messenger_log values(NULL,'" . $admin->getAdminID() . "','$message_body','$recipients'," . time() . ",1," . time() . "," . $units_used . ")";
                    $result2 = mysqli_query($link, $q2);
                    AdminUtility::logMySQLError($link);
                    $result3 = mysqli_query($link, $q3);
                    AdminUtility::logMySQLError($link);
                }
                $responce = $sms->get_responseText();
            } else {
                $responce = "You do not have enough balance at the moment.<br/>";
                $responce .= "You need additional " . ($cost - $balance) . " units to complete this action.";
            }
        } elseif ($type == 'email') {
            if (mail($recipients, 'Subject: ' . $subject, wordwrap($message, 70, '\r\n'), 'From: ' . $reply_to . '\r\n' .
                            'Reply-To: ' . $contact_email . '\r\n' .
                            'X-Mailer: PHP/' . phpversion())) {
                $responce = "You message has been delievered.";
            }
        } else {
            
        }
    }
    ?>
    <script>
        function warn() {
            var ok = confirm("Are you sure?");
            if (ok === false) {
                //Cancel request
                $("#form").submit(function () {
                    return false;
                });
            }
        }
        ;
    </script>
    <div>
        <?php
        if ($responce == 'Successful') {
            header('Location:index.php?p=24&success=1');
        } else {
            ?>
            <h4>MESSENGER: SELECT RECIPIENTS</h4>
            <div class="row"><strong class="span12" style="color:red"><?= $responce; ?></strong></div>
            <form action="index.php?p=26" method="post" id="form">
                <input name="type" value="<?= $array['type']; ?>" type="hidden"/>
                <input name="send" value="1" type="hidden"/>
                <?php if ($type == 'sms') { ?>
                    <input name="sender_id" value="<?= $sender_id; ?>" type="hidden"/>
                    <input name="message_body" value="<?= $message_body; ?>" type="hidden"/>
                    <input name="pages" value="<?= $num_of_sms_pages; ?>" type="hidden"/>
                <?php } elseif ($type == 'email') { ?>
                    <input name="senders_name" value="<?= $senders_name; ?>" type="hidden"/>
                    <input name="message_body" value="<?= $message_body; ?>" type="hidden"/>
                    <input name="subject" value="<?= $subject; ?>" type="hidden"/>
                    <input name="reply_to" value="<?= $reply_to; ?>" type="hidden"/>
                <?php } ?>
                <div class="row ntm">
                    <div class="panel no-border bg-transparent" data-role="panel">
                        <p class="panel-header">Groups</p>
                        <div class="panel-content bg-grayLighter">
                            <table class="table hovered bordered">
                                <thead>
                                    <tr>
                                        <th class="text-left">SN</th>
                                        <th class="text-left">Name</th>
                                        <th class="text-left">Created&hellip;</th>
                                        <th class="text-left">Modified</th>
                                        <th class="text-left">Contacts</th>
                                        <th class="text-left">&hellip;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for ($index = 0; $index < count($groups); $index++) {
                                        $row = $groups[$index];
                                        if ($index != 0 && $index % 20 === 0) {
                                            echo '<tr><td></td><td colspan="6"><a href="#top">back to top</a></td></tr>';
                                        }
                                        ?>
                                        <tr>                            
                                            <td class="text-left"><?= $index + 1 ?></td>
                                            <td class="text-left"><?= $row['group_name']; ?></td>
                                            <td class="text-left" nowrap><?= date('Y-m-d h-i-s', $row['time_created']); ?></td>
                                            <td class="text-left" nowrap><?= date('Y-m-d h-i-s', $row['modified']); ?></td>
                                            <td class="text-left"><?= sizeof($row['group_members']); ?></td>
                                            <td class="text-left"><input type="checkbox" name="groups[]" value="<?= $row['id'] ?>"/></td>
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
                        <p class="panel-header">Contacts</p>
                        <div class="panel-content bg-grayLighter">
                            <table class="table hovered bordered">
                                <thead>
                                <th class="text-left">SN</th>
                                <th class="text-left">First Name</th>
                                <th class="text-left">Last Name</th>
                                <th class="text-left">Other Names</th>
                                <th class="text-left">Email</th>
                                <th class="text-left">Phone</th>
                                <th class="text-left">&hellip;</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for ($index = 0; $index < count($students); $index++) {
                                        if ($index != 0 && $index % 20 === 0) {
                                            echo '<tr><td></td><td colspan="6"><a href="#top">back to top</a></td></tr>';
                                        }
                                        ?>
                                        <tr>                            
                                            <td class="text-left"><?= $index + 1 ?></td>
                                            <td class="text-left"><?= $students[$index]['first_name']; ?></td>
                                            <td class="text-left"><?= $students[$index]['last_name']; ?></td>
                                            <td class="text-left"><?= $students[$index]['other_names']; ?></td>
                                            <td class="text-left"><?= strtolower($students[$index]['email']); ?></td>
                                            <td class="text-left"><?= $students[$index]['phone']; ?></td> 
                                            <td class="text-left"><input type="checkbox" name="contacts[]" value="<?= $students[$index]['regno'] ?>"/></td>
                                        </tr>
                                        <?php
                                    }
                                    echo '<tr><td></td><td colspan="6"><a href="#top">back to top</a></td></tr>';
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row text-right">
                    <input class="button default bg-NACOSS-UNN bg-hover-dark" type='reset' value='Reset'/>
                    <input class="button default bg-NACOSS-UNN bg-hover-dark" type='submit' name="send1" value='Send'/>
                </div>
            </form>
            <?php
        }
        ?>
    </div>
    <?php
} else {
    echo 'error';
}
?>