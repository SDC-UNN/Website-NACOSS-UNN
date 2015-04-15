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

$max_view_length = 10;
$page = 1;
$total_pages = 1;
$defaultPage = "index.php?p=6";

//Check if request was recieved for error_logs.php
if (isset($array['logs'])) {
    //Handle request
    $isUpdateLogFormRequest = true;
    try {
        updateLogTable($array);
        $success = true;
        $error_message = "";
    } catch (Exception $exc) {
        $success = false;
        $error_message = $exc->getMessage();
    }
}

//Set page number
$p = filter_input(INPUT_GET, "pg");
if ($p != null && $p != FALSE) {
    $page = $p;
}

//Set fixed and unfixed log
$logs = getAllErrorLogs();
$pending = array();
foreach ($logs as $value) {
    if (strcmp($value["is_fixed"], "0") === 0) {
        array_push($pending, $value);
    }
}
$fixed = array();
foreach ($logs as $value) {
    if (strcmp($value["is_fixed"], "1") === 0) {
        array_push($fixed, $value);
    }
}

//Compute total number of pages
if (count($pending) > $max_view_length) {
    $total_pages = count($pending) % $max_view_length === 0 ?
            count($pending) / $max_view_length :
            floor(count($pending) / $max_view_length) + 1;
}
?>
<div>
    <h4>ERROR LOG</h4>
    <br/>
    <h2 class="padding5 bg-grayLighter">Pending</h2>
    <?php include '../pagination.php'; ?>

    <?php
    if (isset($isUpdateLogFormRequest)) {
        if ($success) {
            ?>
            <p class="fg-NACOSS-UNN">Update successful</p>
        <?php } else { ?>
            <p class="fg-red"><?= $error_message ?></p>
            <?php
        }
    }
    ?>
    <form action="index.php?p=6" method="post">
        <table class="table hovered bordered">
            <?php
            if (empty($pending)) {
                echo '<tr class="text-center">';
                echo '<td>No new error</td>';
                echo '</tr>';
            } else {
                $start = ($page - 1) * $max_view_length;
                $remainingItems = count($pending) - $start;
                $stop = $start + min(array($remainingItems, $max_view_length));
                ?>
                <thead>
                    <tr>
                        <th class="text-left">Time</th>
                        <th class="text-left">Message</th>
                        <th class="text-left">Trace</th>
                        <th class="text-left">File</th>
                        <th class="text-left">Fixed</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for ($index = $start; $index < $stop; $index++) {
                        ?>
                        <tr class="">
                            <td class="">  
                                <?= $pending[$index]['time_of_error'] ?>
                            </td>
                            <td class="">
                                <?= $pending[$index]['message'] ?>
                            </td>
                            <td class="">
                                <?= nl2br($fixed[$index]['trace'], true) ?>
                            </td>
                            <td class="">
                                <?= $pending[$index]['file'] ?> (Line <?= $pending[$index]['line'] ?>)
                            </td>
                            <td class="">
                                <input value="1" name="<?= $pending[$index]['id'] ?>" type="checkbox"/>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
                <?php
            }
            ?>
        </table>
        <?php if (!empty($pending)) { ?>
            <input class="button bg-blue bg-hover-dark fg-white" value="Update" name="logs" type="submit"/>
        <?php } ?>
    </form>

    <?php include '../pagination.php'; ?>
    <br/>
    <div class="" id="top">
        <h2 class="padding5 bg-grayLighter">Fixed</h2>
        <table class="table hovered">
            <thead>
                <tr>
                    <th class="text-left">Time</th>
                    <th class="text-left">Message</th>
                    <th class="text-left">Trace</th>
                    <th class="text-left">File</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (empty($fixed)) {
                    echo '<tr class="text-center">';
                    echo '<td class="text-left">Nothing fixed</td>';
                    echo '</tr>';
                } else {
                    for ($count = 0; $count < count($fixed); $count++) {
                        if ($count != 0 && $count % 20 === 0) {
                            echo '<tr><td></td><td><a href="#top">back to top</a></td></tr>';
                        }
                        if ($fixed[$count]['is_fixed'] == 1) {
                            ?>
                            <tr class="">
                                <td class="">  
                                    <?= $fixed[$count]['time_of_error'] ?>
                                </td>
                                <td class="">
                                    <?= $fixed[$count]['message'] ?>
                                </td>
                                <td class="">
                                    <?= nl2br($fixed[$count]['trace'], true) ?>
                                </td>
                                <td class="">
                                    <?= $fixed[$count]['file'] ?> (Line <?= $fixed[$count]['line'] ?>)
                                </td>
                            </tr>
                            <?php
                        }
                    }
                }
                ?>
            </tbody>
        </table>
        <a href="#top">back to top</a>
    </div>
</div>