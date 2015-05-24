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

$defaultPage = "index.php?p=3";
if (isset($array["switchSession"])) {
    $session = $array["session"];
} else if (isset($array["delete_button"])) {
    $deletePerformed = true;
    try {
        $admin->removeExecutives($array['checkbox']);
        $success = true;
    } catch (Exception $exc) {
        $success = FALSE;
        $error_message = $exc->getMessage();
    }
    $session = $array["session"];
} else {
    $session = filter_input(INPUT_GET, "session");
}
$executives = getExecutives($session);
?>

<script>
    function warn() {
//        var ok = confirm("Are you sure?");
//        if (ok === false) {
//            //Cancel request
//        }
    }
    ;
</script>

<div>
    <h4>EXECUTIVES</h4>
    <div class="row">
        <a class="place-right button default bg-lightBlue fg-white" href="index.php?p=31">
            <i class="icon-plus"></i> New Executive
        </a>
    </div>
    <br/>
    <?php if (empty($executives) && empty($array["switchSession"])) { ?>
        <p>Not available at the moment</p>
    <?php } else { ?>
        <div>
            <div class="bg-grayLighter padding5">
                <form method="post" action="<?= $defaultPage ?>">
                    <div class="row">
                        <select name="session" class="span4">
                            <option></option>
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
                        <input class="btn-search span2" name="switchSession" type="submit" value="View Session"/>
                    </div>
                </form>
            </div>

            <?php
            if (isset($deletePerformed)) {
                if ($success) {
                    ?>
                    <p class="fg-NACOSS-UNN">Action successful</p>
                <?php } else { ?>
                    <p class="fg-red"><?= $error_message ?></p>
                    <?php
                }
            }
            ?>
            <div id="top">
                <form action="<?= $defaultPage ?>" method="post">
                    <input class="" name="session" hidden value="<?= $session ?>"/>   
                    <div class="row">
                        <input class="" onclick="warn()" name="delete_button" type="submit" value="Delete"/>
                    </div>
                    <div class="row ntm">
                        <table class="table hovered bordered">
                            <thead>
                                <tr>
                                    <th class="text-left"></th>
                                    <th class="text-left">Reg. No</th>
                                    <th class="text-left">Last Name</th>
                                    <th class="text-left">First Name</th>
                                    <th class="text-left">Other Names</th>
                                    <th class="text-left">Department</th>
                                    <th class="text-left">Post</th>
                                    <th class="text-left">Session</th>
                                    <th class="text-left"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                for ($index = 0; $index < count($executives); $index++) {
                                    if ($index != 0 && $index % 20 === 0) {
                                        echo '<tr><td></td><td><a href="#top">back to top</a></td></tr>';
                                    }
                                    ?>
                                    <tr>                            
                                        <td class="text-left"><input type="checkbox" name="checkbox[]" value="<?= $executives[$index]['id'] ?>"/></td>
                                        <td class="text-left"><?= $executives[$index]['regno'] ?></td>
                                        <td class="text-left"><?= $executives[$index]['last_name'] ?></td>
                                        <td class="text-left"><?= $executives[$index]['first_name'] ?></td>
                                        <td class="text-left"><?= $executives[$index]['other_names'] ?></td>
                                        <td class="text-left"><?= $executives[$index]['department'] ?></td>
                                        <td class="text-left"><?= $executives[$index]['post'] ?></td>
                                        <td class="text-left"><?= $executives[$index]['session'] ?></td>
                                        <td class="text-left">
                                            <a href="index.php?p=32&url=<?= urlencode(CPANEL_URL . 'pro/?p=3&session=' . $session) ?>&id=<?= $executives[$index]['id'] ?>">
                                                modify
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                echo '<tr><td></td><td><a href="#top">back to top</a></td></tr>';
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row ntm">
                        <input class="" onclick="warn()" name="delete_button" type="submit" value="Delete"/>
                    </div>
                </form>
            </div>
        </div>
    <?php } ?>
</div>