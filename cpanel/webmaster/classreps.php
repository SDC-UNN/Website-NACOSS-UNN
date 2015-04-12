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

if (isset($array['addClassRep'])) {
    try {
        $admin->addClassRep($array['regno']);
        $success = true;
        $error_message = "";
    } catch (Exception $exc) {
        $success = false;
        $error_message = $exc->getMessage();
    }
}

if (isset($array['remove_button'])) {
    try {
        $admin->removeClassRep($array['remove_button']);
        $success = true;
        $error_message = "";
    } catch (Exception $exc) {
        $success = false;
        $error_message = $exc->getMessage();
    }
}

$classReps = getClassReps();
?>

<script>
    function warn() {
        var ok = confirm("Do you want to delete?");
        if(!ok){
            //Cancel request
            window.stop();
        }
    }
    ;
</script>
<div>
    <h4>CLASS REPRESENTATIVES</h4>
    <br/>
    <div>
        <?php if (empty($classReps)) { ?>
            <p>No class representative has been added</p>
            <?php
        } else {
            if (isset($array['remove_button'])) {
                if (!$success) {
                    ?>
                    <p class="fg-red"><?= $error_message ?></p>
                    <?php
                }
            }
            ?>
            <form action="index.php?p=2" method="post">
                <table class="table hovered">
                    <tbody>
                        <?php
                        foreach ($classReps as $class_rep) {
                            ?>
                            <tr>
                                <td><?= $class_rep['last_name'] . " " . $class_rep['first_name'] ?></td>
                                <td>
                                    <?= $class_rep['regno'] ?>
                                </td>
                                <td>
                                    <?= empty($class_rep['level']) ? "" : $class_rep['level'] . " Level" ?>
                                </td>
                                <td>
                                    <button class="link" onclick="warn()" type="url" name="remove_button" value="<?= $class_rep['regno'] ?>">remove</button>
                                </td>
                                <td class="text-left">
                                    <a class="link" href="index.php?p=13&url=<?= urlencode(CPANEL_URL . 'webmaster/?p=2') ?>&id=<?= $class_rep['regno'] ?>">
                                        preview
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        <?php } ?>
        <br/>
        <br/>
        <?php
        if (count($classReps) < 4) {
            ?>
            <div class="panel">
                <div class="panel-header">Add New</div>
                <div class="panel-content">
                    <?php
                    if (isset($array['addClassRep'])) {
                        if (!$success) {
                            ?>
                            <p class="fg-red"><?= $error_message ?></p>
                            <?php
                        }
                    }
                    ?>
                    <form action="index.php?p=2" method="post">
                        <label>Registration Number</label>
                        <input type="text" maxlength="11" name="regno" value="<?= isset($array['regno']) ? $array['regno'] : "" ?>"/>
                        <input type="submit"  class="button bg-blue bg-hover-dark fg-white" name="addClassRep" value="Add"/>
                    </form>
                </div>

            <?php } ?>
        </div>
    </div>
</div>