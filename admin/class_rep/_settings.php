<?php
if (isset($array['settings$pwd'])) {
    //Handle request
    $isPasswordChangeRequest = true;
    try {
        $admin->changePassword($array['password'], $array['password1'], $array['password2']);
        $success = true;
        $error_message = "";
    } catch (Exception $exc) {
        $success = false;
        $error_message = $exc->getMessage();
    }
} else if (isset($array['settings$email'])) {
    //Handle request
    $isEmailChangeRequest = true;
    try {
        $admin->changeEmail($array['email']);
        $success = true;
        $error_message = "";
    } catch (Exception $exc) {
        $success = false;
        $error_message = $exc->getMessage();
    }
} else if (isset($array['change_senderID'])) {
    //Handle request
    $isIDChangeRequest = true;
    if ($admin->changeSenderID($array['sender_id'])) {
        $success = true;
    } else {
        $success = false;
        $error_message2 = '';
    }
}

$email = $admin->getAdminEmail();
$bills = getByCol('messenger_sms_biller', 'user_id', $admin->getAdminID());
?>
<div>
    <h4>SETTINGS</h4>

    <div class="padding5 grid">
        <div class="panel">
            <div class="panel-header">Change Password</div>
            <div class="panel-content">
                <?php
                if (isset($isPasswordChangeRequest)) {
                    if ($success) {
                        ?>
                        <p class="fg-NACOSS-UNN">Password changed</p>
                    <?php } else { ?>
                        <p class="fg-red"><?= $error_message ?></p>
                        <?php
                    }
                }
                ?>
                <form class="row" method="post" action="index.php?p=3">
                    <div class="row" >
                        <label class="span2">Old Password<span class="fg-red">*</span></label>
                        <div class="span4">
                            <input class="password" name='password' style="width: inherit" type='password' tabindex='2' />
                        </div>
                    </div>
                    <div class="row" >
                        <label class="span2">New Password<span class="fg-red">*</span></label>
                        <div class="span4">
                            <input class="password" name='password1' style="width: inherit" type='password' tabindex='2' />
                        </div>
                    </div>
                    <div class="row" >
                        <label class="span2">Confirm Password<span class="fg-red">*</span></label>
                        <div class="span4">
                            <input class="password" name='password2' style="width: inherit" type='password' tabindex='2' />
                        </div>
                    </div>

                    <div class="row">
                        <input class="button bg-blue bg-hover-dark fg-white" type='submit' name='settings$pwd' value='Change Password' tabindex='9'/>
                    </div>
                </form>
            </div>
        </div>

        <div class="panel">
            <div class="panel-header">Change Email</div>
            <div class="panel-content">
                <?php
                if (isset($isEmailChangeRequest)) {
                    if ($success) {
                        ?>
                        <p class="fg-NACOSS-UNN">Email changed</p>
                    <?php } else { ?>
                        <p class="fg-red"><?= $error_message ?></p>
                        <?php
                    }
                }
                ?>
                <form class="row" method="post" action="index.php?p=3">
                    <div class="row" >
                        <label class="">Current email: <?= $email ?></label>
                    </div>
                    <div class="row" >
                        <label class="span2">Email<span class="fg-red">*</span></label>
                        <div class="span4">
                            <input class="email" placeholder="example@domain.com" value="<?= isset($array['email']) ? $array['email'] : "" ?>" name='email' style="width: inherit" type='email' tabindex='2' />
                        </div>
                    </div>

                    <div class="row">
                        <input class="button bg-blue bg-hover-dark fg-white" type='submit' name='settings$email' value='Change Email' tabindex='9'/>
                    </div>
                </form>
            </div>
        </div>

        <div class="panel">
            <div class="panel-header">Change Default Sender ID</div>
            <div class="panel-content">
                <?php
                if (isset($isIDChangeRequest)) {
                    if ($success) {
                        ?>
                        <p class="fg-NACOSS-UNN">Default Sender ID changed</p>
                    <?php } else { ?>
                        <p class="fg-red"><?= $error_message2 ?></p>
                        <?php
                    }
                }
                ?>
                <form method="post" action="index.php?p=3">
                    <div class="row" >
                        <label class="span2">Sender ID<span class="fg-red">*</span></label>
                        <div class="span4">
                            <input name='sender_id' style="width: inherit" type='text' tabindex='5' maxlength="11" value="<?= $bills['default_sender_id']; ?>"/>
                        </div>
                    </div>

                    <div class="row">
                        <input class="button bg-blue bg-hover-dark fg-white" type='submit' name='change_senderID' value='Change ID' tabindex='6'/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>