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

//Check if request was sent to settings.php

if (isset($array['settings'])) {
    //Handle request
    $isUpdateSettingsFormRequest = true;
    try {
        $admin->updateSettingsTable($array);
        $success = true;
        $error_message = "";
    } catch (Exception $exc) {
        $success = false;
        $error_message = $exc->getMessage();
    }
}

$settings = $admin->getLibrarySettings();
?>

<div>
    <h4>SETTINGS</h4>
    <div>
        <div class="row">
            <a href="index.php?p=41" class="span4 button bg-blue bg-hover-dark fg-white">Change Password or Email</a>
        </div>
    </div>
    <br/>
    <br/>
    <p>CHANGE SETTINGS</p>
    <?php
    if (isset($isUpdateSettingsFormRequest)) {
        if ($success) {
            ?>
            <p class="fg-NACOSS-UNN">Settings was successfully updated.</p>
        <?php } else { ?>
            <p class="fg-red"><?= $error_message ?></p>
            <?php
        }
    }
    ?>
    <form method="post" enctype="multipart/form-data" action="index.php?p=4">
        <table class="table bordered hovered">
            <?php
            if (count($settings) > 0) {
                ?>
                <thead>
                    <tr>
                        <th class="text-left">Variable Name</th>
                        <th class="text-left">Value</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($settings as $row) {
                        ?>
                        <tr title="<?= $row['description'] ?>">
                            <td><?= $row['name'] ?></td>

                            <?php
                            if (strcasecmp($row['name'], "hash_algo_cost") === 0) {
                                ?>
                                <td>
                                    <?= $row['value'] ?>
                                    <a class="place-right" href="compute_cost.php">recalculate</a>
                                </td>
                                <?php
                            } else {
                                ?>
                                <td>
                                    <input style="width: 100%" name="<?= $row['name'] ?>" value="<?= $row['value'] ?>" type="text"/>
                                </td>
                                <?php
                            }
                            ?>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
                <?php
            } else {
                echo '<tr><td>No settings available</td></tr>';
            }
            ?>
        </table>

        <?php
        if (count($settings) > 0) {
            ?>
            <input class="button  bg-blue bg-hover-dark fg-white" name="settings" type="submit" value="Update Settings"/>
        <?php } ?>

    </form>
</div>