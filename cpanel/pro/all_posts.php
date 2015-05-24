<?php
//Initializing variables with default values
$defaultPage = "index.php?p=4";
$sort_type = SORT_POST_TYPE_TIME_OF_POST;
$order = ORDER_DESC;

$searchQuery = "";

if (isset($array['search_button']) || //$array from index.php
        isset($array['delete_button'])) {

    //process POST requests
    $page = 1;

    $searchQuery = html_entity_decode(filter_input(INPUT_POST, "search"));
    $sort_type = html_entity_decode(filter_input(INPUT_POST, "sort_type"));
    $order = html_entity_decode(filter_input(INPUT_POST, "sort_order"));

    try {
        if (isset($array['delete_button']) && isset($array['checkbox'])) {
            $actionPerformed = true;
            $success = $admin->deletePosts($array['checkbox']);
            if (!$success) {
                $error_message = "Oops! Something went wrong";
            }
        }
    } catch (Exception $exc) {
        $success = false;
        $error_message = $exc->getMessage();
    }

    $posts = searchPosts($searchQuery, $sort_type, $order);
} else {
    //Process GET requests or no requests
    $page = filter_input(INPUT_GET, "pg");
    if (isset($page)) {
        //if switching page, repeat search
        $searchQuery = filter_input(INPUT_GET, "q");
        $sort_type = filter_input(INPUT_GET, "s");
        $order = filter_input(INPUT_GET, "o");

        $posts = searchPosts($searchQuery, $sort_type, $order);
    } else {
        $page = 1;
        $posts = getPosts($sort_type, $order);
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
//        var ok = confirm("Are you sure?");
//        if (ok === false) {
//            //Cancel request
//            window.stop();
//        }
    }
    ;
</script>

<div>
    <h4>NEWS POSTS</h4>
    <div class="row">
        <a class="place-right button default bg-lightBlue fg-white" href="index.php?p=11">
            <i class="icon-plus"></i> New Post
        </a>
    </div>

    <div class="row">
        <?php
        if (empty($posts) and ! isset($array['search_button'])) {
            echo '<p>No post</p>';
        } else {
            ?>
            <div class="bg-grayLighter padding5">
                <form method="post" action="index.php?p=1">
                    <div class="input-control text" data-role="input-control">
                        <input type="text" value="<?= $searchQuery ?>" placeholder="Search Title" name="search"/>
                        <button class="btn-search" name="search_button" type="submit"></button>
                    </div>

                    <div class="row ntm">
                        <div class="span5">
                            <label class="span1">Sort by: </label>
                            <div class="span4">
                                <input type="radio" name="sort_type" 
                                <?=
                                isset($sort_type) ?
                                        ($sort_type == SORT_POST_TYPE_TIME_OF_POST ? "checked" : "") :
                                        "checked"
                                ?>
                                       value="<?= SORT_POST_TYPE_TIME_OF_POST ?>"/> Time of Post
                                <input type="radio" name="sort_type"
                                <?=
                                isset($sort_type) ?
                                        ($sort_type == SORT_POST_TYPE_LAST_MODIFIED ? "checked" : "") :
                                        ""
                                ?>
                                       value="<?= SORT_POST_TYPE_LAST_MODIFIED ?>"/> Modification Date
                            </div>
                        </div>
                        <div class="span3">
                            <label class="span1">Order: </label>
                            <div class="span2">
                                <input type="radio" name="sort_order"
                                <?= isset($order) ? ($order == ORDER_ASC ? "checked" : "") : "checked" ?>
                                       value="<?= ORDER_ASC ?>"/> Asc
                                <input type="radio" name="sort_order"
                                <?= isset($order) ? ($order == ORDER_DESC ? "checked" : "") : "" ?>
                                       value="<?= ORDER_DESC ?>"/> Desc
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
                <form action="index.php?p=1" method="post">
                    <input class="span1" name="search" hidden value="<?= $searchQuery ?>"/>
                    <input class="span1" name="sort_type" hidden value="<?= $sort_type ?>"/>
                    <input class="span1" name="sort_order" hidden value="<?= $order ?>"/>
                    <div class="row">
                        <input class="" onclick="warn()" name="delete_button" type="submit" value="Delete"/>
                    </div>
                    <div class="row ntm">
                        <table class="table hovered bordered">
                            <thead>
                                <tr>
                                    <th class="text-left"></th>
                                    <th class="text-left">Time Posted</th>
                                    <th class="text-left">Title</th>
                                    <th class="text-left">Modification Date</th>
                                    <th class="text-left">Expire Date</th>
                                    <th class="text-left">Hits</th>
                                    <th class="text-left"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                for ($index = 0; $index < count($posts); $index++) {
                                    if ($index != 0 && $index % 20 === 0) {
                                        echo '<tr><td></td><td><a href="#top">back to top</a></td></tr>';
                                    }
                                    ?>
                                    <tr>                            
                                        <td class="text-left"><input type="checkbox" name="checkbox[]" value="<?= $posts[$index]['id'] ?>"/></td>
                                        <td class="text-left"><?= $posts[$index]['time_of_post'] ?></td>
                                        <td class="text-left">
                                            <a title="Preview" href="<?= HOSTNAME ?>news_post.php?id=<?= $posts[$index]['id'] ?>" target="_blank">
                                                <?= $posts[$index]['title'] ?>
                                            </a>                                            
                                        </td>
                                        <td class="text-left"><?= $posts[$index]['last_modified'] ?></td>
                                        <td class="text-left"><?= $posts[$index]['expire_time'] ?></td>
                                        <td class="text-left"><?= $posts[$index]['hits'] ?></td>
                                        <td class="text-left">
                                            <a href="index.php?p=12&url=<?= urlencode(CPANEL_URL . 'pro/?p=1&pg=' . $page . '&q=' . urlencode($searchQuery) . '&s=' . $sort_type . '&o=' . $order) ?>&id=<?= $posts[$index]['id'] ?>">
                                                Modify
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
            <?php } ?>
        </div>
    </div>
</div>