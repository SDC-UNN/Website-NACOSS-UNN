<?php
//Initializing variables with default values
$defaultPage = "index.php?p=12";
$sort_type = SORT_USER_TYPE_LASTNAME;
$order = ORDER_USER_ASC;

$searchQuery = "";

if (isset($array['search_button']) || //$array from index.php
        isset($array['activate_button'])) {

    //process POST requests
    $page = 1;

    $searchQuery = html_entity_decode(filter_input(INPUT_POST, "search"));
    $sort_type = html_entity_decode(filter_input(INPUT_POST, "sort_type"));
    $order = html_entity_decode(filter_input(INPUT_POST, "sort_order"));

    try {
        if (isset($array['activate_button'])) {
            $actionPerformed = true;
            activateUsers($array['checkbox']);
        }
        $success = true;
        $error_message = "";
    } catch (Exception $exc) {
        $success = false;
        $error_message = $exc->getMessage();
    }

    $users = searchUsers($searchQuery, true, false, $sort_type, $order);
} else {
    //Process GET requests or no requests
    $page = filter_input(INPUT_GET, "pg");
    if (isset($page)) {
        //if switching page, repeat search
        $searchQuery = filter_input(INPUT_GET, "q");
        $sort_type = filter_input(INPUT_GET, "s");
        $order = filter_input(INPUT_GET, "o");

        $users = searchUsers($searchQuery, true, false, $sort_type, $order);
    } else {
        $page = 1;
        $users = getDeletedUsers();
    }
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
<script>
    function warn() {
        var ok = confirm("Are you sure?");
        if(ok === false){
            //Cancel request
            window.stop();
        }
    }
    ;
</script>

<div>
    <h4>USERS</h4>
    <div class="row">
        <a href="index.php?p=12" class="button disabled place-right">Deleted</a>
        <a href="index.php?p=11" class="button bg-blue bg-hover-dark fg-white place-right">Suspended</a>
        <a href="index.php?p=1" class="button  bg-blue bg-hover-dark fg-white place-right">Active</a>
    </div>
    <div class="row">
        <?php
        if (empty($users) and !isset($array['search_button']) ) {
            echo '<p>No deleted user</p>';
        } else {
            ?>
            <div class="bg-grayLighter padding5">
                <form method="post" action="index.php?p=12">
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
                                        ($sort_type == SORT_USER_TYPE_REGNO ? "checked" : "") :
                                        "checked"
                                ?>
                                       value="<?= SORT_USER_TYPE_REGNO ?>"/> Reg. no
                                <input type="radio" name="sort_type"
                                <?=
                                isset($sort_type) ?
                                        ($sort_type == SORT_USER_TYPE_LASTNAME ? "checked" : "") :
                                        ""
                                ?>
                                       value="<?= SORT_USER_TYPE_LASTNAME ?>"/> Last Name
                                <input type="radio" name="sort_type"
                                <?=
                                isset($sort_type) ?
                                        ($sort_type == SORT_USER_TYPE_LEVEL ? "checked" : "") :
                                        ""
                                ?>
                                       value="<?= SORT_USER_TYPE_LEVEL ?>"/> Level
                            </div>
                        </div>
                        <div class="span3">
                            <label class="span1">Order: </label>
                            <div class="span2">
                                <input type="radio" name="sort_order"
                                <?= isset($order) ? ($order == ORDER_USER_ASC ? "checked" : "") : "checked" ?>
                                       value="<?= ORDER_USER_ASC ?>"/> Asc
                                <input type="radio" name="sort_order"
                                <?= isset($order) ? ($order == ORDER_USER_DESC ? "checked" : "") : "" ?>
                                       value="<?= ORDER_USER_DESC ?>"/> Desc
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <?php
            if (isset($actionPerformed)) {
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
                <form action="index.php?p=12" method="post">
                    <input class="span1" name="search" hidden value="<?= $searchQuery ?>"/>
                    <input class="span1" name="sort_type" hidden value="<?= $sort_type ?>"/>
                    <input class="span1" name="sort_order" hidden value="<?= $order ?>"/>
                    <div class="row">
                        <input class="" onclick="warn()" name="activate_button" type="submit" value="Restore"/>
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
                                        <td class="text-left"><input type="checkbox" name="checkbox[]" value="<?= $users[$index]['regno'] ?>"/></td>
                                        <td class="text-left"><?= $users[$index]['regno'] ?></td>
                                        <td class="text-left"><?= $users[$index]['last_name'] ?></td>
                                        <td class="text-left"><?= $users[$index]['first_name'] ?></td>
                                        <td class="text-left"><?= $users[$index]['other_names'] ?></td>
                                        <td class="text-left"><?= $users[$index]['department'] ?></td>
                                        <td class="text-left"><?= $users[$index]['level'] ?></td>
                                        <td class="text-left">
                                            <a href="index.php?p=13&url=<?= urlencode(CPANEL_URL . 'webmaster/?p=12&pg=' . $page) ?>&id=<?= $users[$index]['regno'] ?>&search=<?= urlencode($searchQuery) ?>&sort_type=<?= $sort_type ?>&sort_order=<?= $order ?>">
                                                preview
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
                        <input class="" onclick="warn()" name="activate_button" type="submit" value="Restore"/>
                    </div>
                </form>
            <?php } ?>
        </div>
    </div>
</div>