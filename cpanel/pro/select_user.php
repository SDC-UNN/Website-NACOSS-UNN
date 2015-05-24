<?php
//Initializing variables with default values
$defaultPage = "index.php?p=6";
$sort_type = AdminUtility::SORT_USER_TYPE_LASTNAME;
$order = AdminUtility::ORDER_ASC;

$searchQuery = "";

if (isset($array['search_button'])) { //$array from index.php
    //process POST requests
    $searchQuery = html_entity_decode(filter_input(INPUT_POST, "search"));
    $sort_type = html_entity_decode(filter_input(INPUT_POST, "sort_type"));
    $order = html_entity_decode(filter_input(INPUT_POST, "sort_order"));

    $users = AdminUtility::searchUsers($searchQuery, false, false, $sort_type, $order);

    //Get back url
    $url = urldecode(filter_input(INPUT_POST, "url"));
} else {
    //Get back url
    $url = urldecode(filter_input(INPUT_GET, "url"));
    $users = AdminUtility::getActiveUsers();
}
?>

<!DOCTYPE html>
<!--
Copyright 2015 NACOSS UNN Developers Group (NDG).

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

     http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
-->
<div>
    <h4>SELECT USER</h4>
    <div class="row">
        <a href="<?= $url ?>">
            <i class="icon-arrow-left-2"></i> Back
        </a>
    </div>
    <div class="row">
        <?php
        if (empty($users) and ! isset($array['search_button'])) {
            echo '<p>No active user</p>';
        } else {
            ?>
            <div class="bg-grayLighter padding5">
                <form method="post" action="<?= $defaultPage ?>">
                    <div class="input-control text" data-role="input-control">
                        <input type="text" value="<?= $searchQuery ?>" placeholder="Search Users" name="search"/>
                        <button class="btn-search" name="search_button" type="submit"></button>
                    </div>

                    <div class="row ntm">
                        <div class="span5">
                            <label class="span1">Sort by: </label>
                            <div class="span4">
                                <input type="radio" name="sort_type" 
                                <?=
                                isset($sort_type) ?
                                        ($sort_type == AdminUtility::SORT_USER_TYPE_REGNO ? "checked" : "") :
                                        "checked"
                                ?>
                                       value="<?= AdminUtility::SORT_USER_TYPE_REGNO ?>"/> Reg. no
                                <input type="radio" name="sort_type"
                                <?=
                                isset($sort_type) ?
                                        ($sort_type == AdminUtility::SORT_USER_TYPE_LASTNAME ? "checked" : "") :
                                        ""
                                ?>
                                       value="<?= AdminUtility::SORT_USER_TYPE_LASTNAME ?>"/> Last Name
                                <input type="radio" name="sort_type"
                                <?=
                                isset($sort_type) ?
                                        ($sort_type == AdminUtility::SORT_USER_TYPE_LEVEL ? "checked" : "") :
                                        ""
                                ?>
                                       value="<?= AdminUtility::SORT_USER_TYPE_LEVEL ?>"/> Level
                            </div>
                        </div>
                        <div class="span3">
                            <label class="span1">Order: </label>
                            <div class="span2">
                                <input type="radio" name="sort_order"
                                <?= isset($order) ? ($order == AdminUtility::ORDER_ASC ? "checked" : "") : "checked" ?>
                                       value="<?= AdminUtility::ORDER_ASC ?>"/> Asc
                                <input type="radio" name="sort_order"
                                <?= isset($order) ? ($order == AdminUtility::ORDER_DESC ? "checked" : "") : "" ?>
                                       value="<?= AdminUtility::ORDER_DESC ?>"/> Desc
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div id="top">
                <form action="<?= $defaultPage ?>" method="post">
                    <input class="span1" name="search" hidden value="<?= $searchQuery ?>"/>
                    <input class="span1" name="sort_type" hidden value="<?= $sort_type ?>"/>
                    <input class="span1" name="sort_order" hidden value="<?= $order ?>"/>
                    <input class="span1" name="url" hidden value="<?= urlencode($url) ?>"/>
                    <div class="row ntm">
                        <table class="table hovered bordered">
                            <thead>
                                <tr>
                                    <th class="text-left">Reg. No</th>
                                    <th class="text-left">Name</th>
                                    <th class="text-left">Department</th>
                                    <th class="text-left">Level</th>
                                    <th class="text-left"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                for ($index = 0; $index < count($users); $index++) {
                                    if ($index != 0 && $index % 20 === 0) {
                                        echo '<tr><td></td><td><a href="#top">back to top</a></td></tr>';
                                    }
                                    ?>
                                    <tr>                            
                                        <td class="text-left"><?= $users[$index]['regno'] ?></td>
                                        <td class="text-left">
                                            <a href="index.php?p=31&user_id=<?= $users[$index]['regno'] ?>">
                                                <?=
                                                $users[$index]['last_name']
                                                . " " . $users[$index]['first_name']
                                                . " " . $users[$index]['other_names']
                                                ?>
                                            </a>
                                        </td>
                                        <td class="text-left"><?= $users[$index]['department'] ?></td>
                                        <td class="text-left"><?= $users[$index]['level'] ?></td>
                                        <td class="text-left">
                                            <a href="index.php?p=31&user_id=<?= $users[$index]['regno'] ?>">
                                                select
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
                </form>
            <?php } ?>
        </div>
    </div>
</div>