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

if (isset($array["reportBugForm"])) {
    //Handle request from "Report a Bug" page
    //Validating details
    if (empty($array["subject"])) {
        $error_message = "Please specify a subject";
    } elseif (empty($array["comment"])) {
        $error_message = "Please add a description of the bug";
    }

    $ok = empty($error_message);

    //Send bug report
    if ($ok) {
        try {
            $success = $user->reportBug($array);
            if ($success) {
                $array = "";
            } else {
                //Sending failed
                $error_message = "Oops! Something went wrong, please try again.";
            }
        } catch (Exception $exc) {
            $success = FALSE;
            $error_message = $exc->getMessage();
        }
    } else {
        $success = false;
    }
}
?>

<div>
    <h2>Report a Bug</h2>
    <div class="padding5">
        <?php if (isset($success)) { ?>
            <div class="row container">
                <div class="label">
                    <?php if ($success) { ?>
                        <h2 class="fg-green">Thank You!</h2>
                        <p>Your report has been sent, our Tech team will be on it soon.</p>
                    <?php } else { ?>
                        <p class="fg-red">
                            <?= $error_message ?>
                        </p>
                    <?php } ?>
                </div>
            </div>
        <?php }
        ?>
        <form method="post" action="profile.php?p=2">

            <div class="row" >
                <label class="span2">Subject<span class="fg-red">*</span></label>
                <div class="span6">
                    <input name='subject' required="" style="width: inherit" type='text' 
                           <?= isset($array['subject']) ? "value='" . $array['subject'] . "'" : ""; ?>  tabindex='6'  />
                </div>
            </div>
            <div class="row" >
                <label class="span2">Comment<span class="fg-red">*</span></label>
                <div class="span6">
                    <textarea name='comment' required="" style="width: inherit; height: 200px"
                              tabindex='6'><?= isset($array['comment']) ? $array['comment'] : ""; ?></textarea>
                </div>
            </div>
            <div class="row no-phone offset2">
                <input class="button default bg-NACOSS-UNN bg-hover-dark" type='submit'
                       name='reportBugForm' value='Send' tabindex='9'/>
            </div>
            <div class="on-phone no-tablet no-desktop padding20 ntp nbp">
                <input class="button default bg-NACOSS-UNN bg-hover-dark" type='submit'
                       name='reportBugForm' value='Send' tabindex='9'/>
            </div>
        </form>


        <div class="panel">
            <div class="panel-header">Reports By you</div>
            <div class="panel-content">
                <?php
                $array = UserUtility::getErrorReports($user->getUserID());
                if (empty($array)) {
                    echo '<p>No previous reports</p>';
                } else {
                    for ($index = 0; $index < count($array); $index++) {
                        ?>
                        <div class="listview-outlook" data-role="listview">
                            <div class="list-group collapsed">
                                <a href="#" class="group-title">
                                    <?= "[" . $array[$index]['time_of_report'] . "] " . $array[$index]['subject'] ?>
                                </a>
                                <div class="group-content">
                                    <div class="list-content"><?= $array[$index]['comment'] ?></div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>