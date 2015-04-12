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

//If request was sent to settings$1.php
if (isset($array['settings$1'])) {
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
}
?>
<div>
    <h4>CHANGE PASSWORD</h4>

    <div class="row">
        <a href="index.php?p=7" class="link place-right"><i class="icon-arrow-left-2"></i> Back</a>
    </div>

    <div class="padding5 grid">
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
        <form method="post" action="index.php?p=8">
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
                <input class="button bg-blue bg-hover-dark fg-white" type='submit' name='settings$1' value='Change' tabindex='9'/>
            </div>
        </form>
    </div>
</div>