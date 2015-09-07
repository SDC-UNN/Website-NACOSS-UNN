<?php
//Initializing variables with default values
$defaultPage = "index.php?p=21";
$sort_type = SORT_POST_TYPE_TIME_OF_POST;
$order = ORDER_DESC;

$searchQuery = "";

if (isset($array['search_button'])) {  //$array from index.php
    //process POST requests
    $page = 1;

    $searchQuery = html_entity_decode(filter_input(INPUT_POST, "search"));
    $sort_type = html_entity_decode(filter_input(INPUT_POST, "sort_type"));
    $order = html_entity_decode(filter_input(INPUT_POST, "sort_order"));
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

//URL for back link
$caption = urldecode(filter_input(INPUT_GET, "caption"));
$size = urldecode(filter_input(INPUT_GET, "size"));
$href = urldecode(filter_input(INPUT_GET, "href"));
?>

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
    <h4>SELECT POST</h4>
    <div class="row">
        <a href="index.php?p=2?size=<?= $size ?>&href=<?= urlencode($href) ?>&caption=<?= urlencode($caption) ?>#new">
            <i class="icon-arrow-left-2"></i> Back
        </a>
    </div>
    <div class="row">
        <?php
        if (empty($posts) and ! isset($array['search_button'])) {
            ?>
            <p>No Post</p>
            <?php
        } else {
            ?>
            <div class="bg-grayLighter padding5">
                <form method="post" action="index.php?p=21">
                    <div class="input-control text" data-role="input-control">
                        <input type="text" value="<?= $searchQuery ?>" placeholder="Search Title" name="search"/>
                        <button class="btn-search" name="search_button" type="submit"></button>
                    </div>

                    <div class="row ntm">
                        <div class="span8">
                            <label class="">Sort by: </label>
                            <div class="input-control radio">
                                <label>
                                    <input type="radio" name="sort_type" 
                                    <?=
                                    isset($sort_type) ?
                                            ($sort_type == SORT_POST_TYPE_TIME_OF_POST ? "checked" : "") :
                                            "checked"
                                    ?>
                                           value="<?= SORT_POST_TYPE_TIME_OF_POST ?>"/>
                                    <span class="check"></span>
                                    Time of Post
                                </label>
                            </div>
                            <div class="input-control radio">
                                <label>
                                    <input type="radio" name="sort_type"
                                    <?=
                                    isset($sort_type) ?
                                            ($sort_type == SORT_POST_TYPE_LAST_MODIFIED ? "checked" : "") :
                                            ""
                                    ?>
                                           value="<?= SORT_POST_TYPE_LAST_MODIFIED ?>"/>
                                    <span class="check"></span>
                                    Modification Date
                                </label>
                            </div>
                        </div>
                        <div class="span4">
                            <label class="">Order: </label>
                            <div class="input-control radio">
                                <label>
                                    <input type="radio" name="sort_order"
                                    <?= isset($order) ? ($order == ORDER_ASC ? "checked" : "") : "checked" ?>
                                           value="<?= ORDER_ASC ?>"/>
                                    <span class="check"></span>
                                    Asc
                                </label>
                            </div>
                            <div class="input-control radio">
                                <label>
                                    <input type="radio" name="sort_order"
                                    <?= isset($order) ? ($order == ORDER_DESC ? "checked" : "") : "" ?>
                                           value="<?= ORDER_DESC ?>"/>
                                    <span class="check"></span>
                                    Desc
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div id="top">
                <div class="row ntm">
                    <table class="table hovered bordered">
                        <thead>
                            <tr>
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
                                    <td class="text-left"><?= $posts[$index]['time_of_post'] ?></td>
                                    <td class="text-left">
                                        <a href="index.php?p=2?size=<?= $size ?>&id=<?= $posts[$index]['id'] ?>#new">
                                            <?= $posts[$index]['title'] ?>
                                        </a>
                                    </td>
                                    <td class="text-left"><?= $posts[$index]['last_modified'] ?></td>
                                    <td class="text-left"><?= $posts[$index]['expire_time'] ?></td>
                                    <td class="text-left"><?= $posts[$index]['hits'] ?></td>
                                    <td class="text-left">
                                        <a href="index.php?p=2?size=<?= $size ?>&id=<?= $posts[$index]['id'] ?>#new">
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
            <?php } ?>
        </div>
    </div>
</div>