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
$defaultPage = "index.php?p=32";

if (isset($array["modifyExecutive"])) {
    $modifyPerformed = true;
    //Get back url
    $url = urldecode(filter_input(INPUT_POST, "url"));
    $id = $array["id"];
    try {
        $admin->modifyExecutive($array["id"], $array["post"], $array["session"]);
        $success = true;
    } catch (Exception $exc) {
        $success = FALSE;
        $error_message = $exc->getMessage();
    }
} else {
    //Get back url
    $url = urldecode(filter_input(INPUT_GET, "url"));
    $id = filter_input(INPUT_GET, "id");
}
$executive = getExecutive($id);
?>
<div>
    <h4>MODIFY EXECUTIVE POSITION</h4>    
    <div class="row">
        <a href="<?= $url ?>">
            <i class="icon-arrow-left-2"></i> Back
        </a>
    </div>
    <div  class="grid">
        <?php
        if (isset($modifyPerformed)) {
            if (!$success) {
                ?>
                <p class="fg-red"><?= $error_message ?></p>
                <?php
            } else {
                ?>
                <p class="fg-NACOSS-UNN">Executive position was successfully modify</p>
                <?php
            }
        }
        $name = $executive["last_name"] . " " . $executive["first_name"];
        $session = isset($modifyPerformed) ? $array["session"] : $executive["session"];
        $post = isset($modifyPerformed) ? $array["post"] :  $executive["post"];
        ?>
        <form action="<?= $defaultPage ?>" method="post">
            <input class="span1" name="url" hidden value="<?= urlencode($url) ?>"/>                    
            <input class="span1" name="id" hidden value="<?= $id ?>"/>                    
            <div class="row">
                <label class="">Name</label>
                <label class=""><small><?= $name ?></small></label>
            </div>
            <div class="row">
                <label class="">Reg. Number</label>
                <label class=""><small><?= $executive["regno"] ?></small></label>
            </div>
            <div class="row">
                <label class="span1">Post</label>
                <select name="post" required="" class="span4">
                    <option></option>
                    <?php
                    $posts = getExecutivePosts();
                    foreach ($posts as $value) {
                        echo "<option "
                        . (strcasecmp($post, $value['name']) === 0 ? "selected" : "")
                        . ">"
                        . $value['name']
                        . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="row">
                <label class="span1">Session</label>
                <select name="session" required="" class="span4">
                    <option ></option>
                    <?php
                    $year = date("Y");
                    $endYear = "2014";
                    while ($year >= $endYear) {
                        $nextSession = ($year - 1) . "/" . ($year);
                        echo "<option "
                        . (strcasecmp($session, $nextSession) === 0 ? "selected" : "")
                        . ">"
                        . $nextSession
                        . "</option>";
                        $year--;
                    }
                    ?>
                </select>
            </div>
            <div class="row">
                <input type="submit"  class="button bg-blue bg-hover-dark fg-white" name="modifyExecutive" value="Add Executive"/>
            </div>
        </form>
    </div>
</div>