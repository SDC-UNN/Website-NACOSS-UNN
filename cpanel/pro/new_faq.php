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

if (isset($array['faq_button'])) {
    try {
        $success = $admin->newFAQ($array['question'], $array['answer']);
        if ($success) {
            unset($array);
        } else {
            $error_message = "Oops! something went wrong";
        }
    } catch (Exception $exc) {
        $success = FALSE;
        $error_message = $exc->getMessage();
    }
}
?>

<div>
    <h4>NEW FAQ</h4>
    <div class="">
        <?php
        if (isset($success)) {
            if ($success) {
                ?>
                <p class="fg-green">FAQ was posted</p>
            <?php } else { ?>
                <p class="fg-red"><?= $error_message ?></p>
                <?php
            }
        }
        ?>
        <form method="post" action="index.php?p=41">
            <div class="row ntm">
                <label class="span2">Question</label>
                <div class="span10">
                    <textarea class="text" name='question' style="width: inherit; height: 100px" required tabindex='1'><?= isset($array['question']) ? $array['question'] : "" ?></textarea>
                </div>
            </div>
            <div class="row">
                <label class="span2">Answer</label>
                <div class="span10">
                    <textarea class="" name='answer' style="width: inherit; height: 200px" required tabindex='2' ><?= isset($array['answer']) ? $array['answer'] : "" ?></textarea>
                </div>
            </div>
            <div class="row">
                <div class="">
                    <input class="offset2 button bg-blue bg-hover-dark fg-white" name='faq_button' type='submit' tabindex='3' value="Post" />
                </div>
            </div>
        </form>
    </div>
</div>