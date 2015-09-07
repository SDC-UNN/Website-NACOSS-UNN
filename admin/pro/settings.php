<?php
/*
 * Copyright 2015 NACOSS UNN Developers Group (NDG).
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

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
}
$email = $admin->getAdminEmail();
?>
<div>
    <h4>SETTINGS</h4>
    <br/>
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
                <form class="row" method="post" action="index.php?p=71">
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
                <form class="row" method="post" action="index.php?p=71">
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
    </div>
</div>