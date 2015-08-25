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
$defaultPage = "index.php?p=8";


//Set page number
$p = filter_input(INPUT_GET, "pg");
if ($p != null && $p != FALSE) {
    $page = $p;
}

//Set fixed and unfixed log
$feedbacks = getAllFeedBacks();
$unseen = array();
$seen = array();
foreach ($feedbacks as $value) {
    if (strcmp($value["seen"], "0") === 0) {
        array_push($unseen, $value);
    } else {
        array_push($seen, $value);
    }
}

//Compute total number of pages
if (count($unseen) > $max_view_length) {
    $total_pages = count($unseen) % $max_view_length === 0 ?
            count($unseen) / $max_view_length :
            floor(count($unseen) / $max_view_length) + 1;
}
?>
<div>
    <h4>FEEDBACKS</h4>
    <br/>
    <h2 class="padding5 bg-grayLighter">Unseen</h2>
    <?php include '../pagination.php'; ?>


    <table class="table hovered bordered">
        <?php
        if (empty($unseen)) {
            echo '<tr class="text-center">';
            echo '<td>No new feedback</td>';
            echo '</tr>';
        } else {
            $start = ($page - 1) * $max_view_length;
            $remainingItems = count($unseen) - $start;
            $stop = $start + min(array($remainingItems, $max_view_length));
            ?>
            <thead>
                <tr>
                    <th class="text-left">Time</th>
                    <th class="text-left">Message</th>
                    <th class="text-left">IP Address</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($index = $start; $index < $stop; $index++) {
                    ?>
                    <tr class="">
                        <td class="">  
                            <?= $unseen[$index]['time_of_post'] ?>
                        </td>
                        <td class="">
                            <?= $unseen[$index]['message'] ?>
                        </td>
                        <td class="">
                            <?= $unseen[$index]['ip_address'] ?>
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
    <?php include '../pagination.php'; ?>
    <br/>
    <?php if (!empty($seen)) { ?>
        <div class="" id="top">
            <h2 class="padding5 bg-grayLighter">Seen</h2>
            <table class="table hovered">
                <thead>
                    <tr>
                        <th class="text-left">Time</th>
                        <th class="text-left">Message</th>
                        <th class="text-left">IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    for ($count = 0; $count < count($seen); $count++) {
                        if ($count != 0 && $count % 20 === 0) {
                            echo '<tr><td></td><td><a href="#top">back to top</a></td></tr>';
                        }
                        ?>
                        <tr class="">
                            <td class="">  
                                <?= $seen[$count]['time_of_post'] ?>
                            </td>
                            <td class="">
                                <?= $seen[$count]['message'] ?>
                            </td>
                            <td class="">
                                <?= $seen[$count]['ip_address'] ?>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
            <a href="#top">back to top</a>
        </div>
    <?php } ?>
</div>