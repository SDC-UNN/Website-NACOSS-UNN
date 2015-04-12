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
?>
<div>
    <h2>Change Password</h2>
    <div class="padding5">
        <?php if (isset($array["changePasswordForm"])) {
            if ($success) {
                ?>
                <p class="fg-NACOSS-UNN">Password changed</p>
            <?php } else { ?>
                <p class="fg-red"><?= $error_message ?></p>
            <?php
            }
        }
        ?>
        <form method="post" action="profile.php?p=6">
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

            <div class="row no-phone offset2">
                <input class="button default bg-NACOSS-UNN bg-hover-dark" type='submit'
                       name='changePasswordForm' value='Change' tabindex='9'/>
            </div>
            <div class="on-phone no-tablet no-desktop padding20 ntp nbp">
                <input class="button default bg-NACOSS-UNN bg-hover-dark" type='submit'
                       name='changePasswordForm' value='Change' tabindex='9'/>
            </div>
        </form>
    </div>
</div>