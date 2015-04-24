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

if (isset($array['faq_edit_button'])) {

    //URL for back link
    $url = $array["url"];
    $id = $array["id"];

    try {
        $success = $admin->modifyFAQ($id, $array['question'], $array['answer']);
        if (!$success) {
            $error_message = "Oops! something went wrong";
        }
    } catch (Exception $exc) {
        $success = FALSE;
        $error_message = $exc->getMessage();
    }
} else {

    $id = urldecode(filter_input(INPUT_GET, "id"));
//URL for back link
    $url = urldecode(filter_input(INPUT_GET, "url"));

    $array = getFAQ($id);
}

if (empty($array)) {
    ?>
    <p>FAQ not available</p>
    <a href="<?= $url ?>">
        <i class="icon-arrow-left-2"></i> Back
    </a>
    <?php
} else {
    ?>
    <div>
        <h4>MODIFY FAQ</h4>
        <div class="row">
            <a href="<?= $url ?>">
                <i class="icon-arrow-left-2"></i> Back
            </a>
        </div>
        <div class="grid">
            <?php
            if (isset($success)) {
                if ($success) {
                    ?>
                    <p class="fg-green">Update saved</p>
                <?php } else { ?>
                    <p class="fg-red"><?= $error_message ?></p>
                    <?php
                }
            }
            ?>
            <form method="post" action="index.php?p=42">
                <input name="url" hidden value="<?= $url ?>"/>
                <input name="id" hidden value="<?= $id ?>"/>
                <div class="row ntm">
                    <label class="span1">Question</label>
                    <div class="span7">
                        <textarea class="text" name='question' style="width: inherit; height: 100px" required tabindex='1'><?= isset($array['question']) ? $array['question'] : "" ?></textarea>
                    </div>
                </div>
                <div class="row">
                    <label class="span1">Answer</label>
                    <div class="span7">
                        <textarea class="" name='answer' style="width: inherit; height: 200px" required tabindex='2' ><?= isset($array['answer']) ? $array['answer'] : "" ?></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="">
                        <input class="offset1 button bg-blue bg-hover-dark fg-white" name='faq_edit_button' type='submit' tabindex='3' value="Update" />
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
}?>