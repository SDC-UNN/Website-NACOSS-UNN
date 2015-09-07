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
$defaultPage = "index.php?p=31";

if (isset($array["addExecutive"])) {
    $addPerformed = true;
    try {
        $admin->addExecutive($array["post"], $array["session"], $array["user_id"]);
        $array = "";
        $success = true;
    } catch (Exception $exc) {
        $user_id = $array["user_id"];
        $success = FALSE;
        $error_message = $exc->getMessage();
    }
} else {
    $user_id = filter_input(INPUT_GET, "user_id");
}
?>
<div>
    <h4>ADD EXECUTIVE</h4>
    <br/>
    <div  class="">
        <?php
        if (isset($addPerformed)) {
            if (!$success) {
                ?>
                <p class="fg-red"><?= $error_message ?></p>
                <?php
            } else {
                ?>
                <p class="fg-NACOSS-UNN">Executive was successfully added</p>
                <?php
            }
        }

        if (!empty($user_id)) {
            $user = AdminUtility::getUserInfo($user_id);
            if (!empty($user)) {
                $name = $user["last_name"] . " " . $user["first_name"];
                $regno = $user["regno"];
            }
        }
        ?>
        <form action="<?= $defaultPage ?>" method="post">

            <a  class="button" href="index.php?p=6&url=<?= urlencode($defaultPage) ?>">
                Select Student
            </a>                       
            <div class="row">
                <label class="">Name</label>
                <label class=""><small><?= empty($name) ? "No user selected. Select a user" : $name ?></small></label>
            </div>
            <div class="row">
                <label class="">Reg. Number</label>
                <label class=""><small><?= empty($regno) ? "No user selected. Select a user" : $regno ?></small></label>
                <input name="user_id" hidden="" value="<?= empty($regno) ? "" : $regno ?>" required="" type="text"/> 
            </div>
            <div class="row">
                <label class="span2">Post</label>
                <select name="post" required="" class="span8">
                    <option></option>
                    <?php
                    $posts = getExecutivePosts();
                    foreach ($posts as $value) {
                        echo "<option "
                        . (isset($array["post"]) && strcasecmp($array["post"], $value['name']) === 0 ? "checked" : "")
                        . ">"
                        . $value['name']
                        . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="row">
                <label class="span2">Session</label>
                <select name="session" required="" class="span8">
                    <option></option>
                    <?php
                    $year = date("Y") + 1;
                    $endYear = "2014";
                    while ($year >= $endYear) {
                        $session = ($year - 1) . "/" . ($year);
                        echo "<option "
                        . (strcasecmp($array["session"], $session) === 0 ? "checked" : "")
                        . ">"
                        . $session
                        . "</option>";
                        $year--;
                    }
                    ?>
                </select>
            </div>
            <div class="row">
                <input type="submit"  class="button bg-blue bg-hover-dark fg-white" name="addExecutive" value="Add Executive"/>
            </div>
        </form>
    </div>
</div>