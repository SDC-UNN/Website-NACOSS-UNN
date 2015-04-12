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
$defaultPage = "index.php?p=5";

//Check if request was recieved for this error_reports.php
if (isset($array['reports'])) {
    //Handle request
    $isUpdateReportFormRequest = true;
    try {
        updateReportsTable($array);
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

//Set seen and unseen reports
$reports = getAllErrorReports();
$unseen = array();
foreach ($reports as $value) {
    if (strcmp($value["seen"], "0") === 0) {
        array_push($unseen, $value);
    }
}
$seen = array();
foreach ($reports as $value) {
    if (strcmp($value["seen"], "1") === 0) {
        array_push($seen, $value);
    }
}

//Calculate total pages
if (count($unseen) > $max_view_length) {
    $total_pages = count($unseen) % $max_view_length === 0 ?
            count($unseen) / $max_view_length :
            floor(count($unseen) / $max_view_length) + 1;
}
?>

<div>
    <h4>ERROR REPORTS</h4>
    <br/>
    <h2 class="padding5 bg-grayLighter">Unseen</h2>
    <?php include '../pagination.php'; ?>

    <?php
    if (isset($isUpdateReportFormRequest)) {
        if ($success) {
            ?>
            <p class="fg-NACOSS-UNN">Update successful</p>
        <?php } else { ?>
            <p class="fg-red"><?= $error_message ?></p>
            <?php
        }
    }
    ?>
    <form action="index.php?p=5" method="post">
        <table class="table hovered bordered">
            <?php
            if (empty($unseen)) {
                echo '<tr class="text-center">';
                echo '<td>No new report</td>';
                echo '</tr>';
            } else {
                $start = ($page - 1) * $max_view_length;
                $remainingItems = count($unseen) - $start;
                $stop = $start + min(array($remainingItems, $max_view_length));
                ?>
                <thead>
                    <tr>
                        <th class="text-left">Time</th>
                        <th class="text-left">Subject</th>
                        <th class="text-left">Message</th>
                        <th class="text-left">User</th>
                        <th class="text-left">Seen</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for ($index = $start; $index < $stop; $index++) {
                        ?>
                        <tr class="">
                            <td class="">  
                                <?= $unseen[$index]['time_of_report'] ?>
                            </td>
                            <td class="">
                                <?= $unseen[$index]['subject'] ?>
                            </td>
                            <td class="">
                                <?= $unseen[$index]['comment'] ?>
                            </td>
                            <td class="">
                                <?= $unseen[$index]['user_id'] ?>
                            </td>
                            <td class="">
                                <input value="1" name="<?= $unseen[$index]['id'] ?>" type="checkbox"/>
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
        <?php if (!empty($unseen)) { ?>
            <input class="button bg-blue bg-hover-dark fg-white" value="Update" name="reports" type="submit"/>
        <?php } ?>
    </form>

    <?php include '../pagination.php'; ?>

    <br/>
    <div class="" id="top">
        <h2 class="padding5 bg-grayLighter">Seen</h2>
        <div>
            <?php
            if (empty($seen)) {
                echo '<p>No Bug report has been read</p>';
            } else {
                ?>
                <table class="table hovered bordered">            
                    <thead>
                        <tr>
                            <th class="text-left">Time</th>
                            <th class="text-left">Subject</th>
                            <th class="text-left">Message</th>
                            <th class="text-left">User</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($count = 0; $count < count($seen); $count++) {
                            if ($count != 0 && $count % 20 === 0) {
                                echo '<tr><td></td><td><a href="#top">back to top</a></td></tr>';
                            }
                            if ($seen[$count]['seen'] == 1) {
                                ?>
                                <tr class="">
                                    <td class="">  
                                        <?= $seen[$count]['time_of_report'] ?>
                                    </td>
                                    <td class="">
                                        <?= $seen[$count]['subject'] ?>
                                    </td>
                                    <td class="">
                                        <?= $seen[$count]['comment'] ?>
                                    </td>
                                    <td class="">
                                        <?= $seen[$count]['user_id'] ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <?php
            }
            ?>
        </div>
        <br/>
        <a href="#top">back to top</a>
    </div>
</div>