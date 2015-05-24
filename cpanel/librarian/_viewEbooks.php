<?php
//Initializing variables with default values
$defaultPage = "index.php?p=1";
        const MEDIA = "ebook";
$sort_type = SORT_LIBRARY_TYPE_TITLE;
$order = ORDER_LIBRARY_ASC;
$s = filter_input(INPUT_GET, "sh");
$on_shelf = $s == '0' ? 0 : 1;
$searchQuery = "";

if (isset($array['search_button']) || //$array from index.php
        isset($array['restore_button']) ||
        isset($array['suspend_button']) ||
        isset($array['delete_button'])) {

    //process POST requests
    $page = 1;

    $searchQuery = html_entity_decode(filter_input(INPUT_POST, "search"));
    $sort_type = html_entity_decode(filter_input(INPUT_POST, "sort_type"));
    $order = html_entity_decode(filter_input(INPUT_POST, "sort_order"));

    try {
        if (isset($array['restore_button'])) {
            $actionPerformed = true;
            restoreLibraryItems($array['checkbox']);
        } elseif (isset($array['suspend_button'])) {
            $actionPerformed = true;
            suspendLibraryItems($array['checkbox']);
        } elseif (isset($array['delete_button'])) {
            $actionPerformed = true;
            deleteLibraryItems($array['checkbox']);
        }
        $success = true;
        $error_message = "";
    } catch (Exception $exc) {
        $success = false;
        $error_message = $exc->getMessage();
    }
    $books = searchLibraryItems($searchQuery, MEDIA, $on_shelf, $sort_type, $order);
} else {
    //Process GET requests or no requests
    $page = filter_input(INPUT_GET, "pg");
    if (isset($page)) {
        //if switching page, repeat search
        $searchQuery = filter_input(INPUT_GET, "q");
        $sort_type = filter_input(INPUT_GET, "s");
        $order = filter_input(INPUT_GET, "o");

        $books = searchLibraryItems($searchQuery, MEDIA, $on_shelf, $sort_type, $order);
    } else {
        $page = 1;
        $books = getLibraryItems(MEDIA, $on_shelf);
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
//        if(ok === false){
//            //Cancel request
//            window.stop();
//        }
    }
    ;
</script>
<div>
    <h4>BOOKS: <?= $on_shelf == 1 ? 'ON SHELF' : 'OFF SHELF'; ?></h4>
    <div class="row">
        <a href="index.php?p=1&sh=0" class="<?= $on_shelf == 1 ? 'button bg-blue bg-hover-dark fg-white place-right' : 'button disabled place-right'; ?>">Off Shelf</a>
        <a href="index.php?p=1&sh=1" class="<?= $on_shelf == 0 ? 'button bg-blue bg-hover-dark fg-white place-right' : 'button disabled place-right'; ?>">On Shelf</a>
    </div>
    <div class="row">
        <?php
        if (empty($books) and ! isset($array['search_button'])) {
            echo '<p>No books in this category</p>';
        } else {
            ?>
            <div class="bg-grayLighter padding5">
                <form method="post" action="index.php?p=1&sh=<?= $on_shelf; ?>">
                    <div class="input-control text" data-role="input-control">
                        <input type="text" value="<?= $searchQuery ?>" placeholder="Search Books" name="search"/>
                        <button class="btn-search" name="search_button" type="submit"></button>
                    </div>

                    <div class="row ntm">
                        <div class="span5">
                            <label class="span1">Sort by: </label>
                            <div class="span4">
                                <input type="radio" name="sort_type" 
                                <?=
                                isset($sort_type) ?
                                        ($sort_type == SORT_LIBRARY_TYPE_TITLE ? "checked" : "") :
                                        "checked"
                                ?>
                                       value="<?= SORT_LIBRARY_TYPE_TITLE ?>"/> Title
                                <input type="radio" name="sort_type"
                                <?=
                                isset($sort_type) ?
                                        ($sort_type == SORT_LIBRARY_TYPE_AUTHOR ? "checked" : "") :
                                        ""
                                ?>
                                       value="<?= SORT_LIBRARY_TYPE_AUTHOR ?>"/> Author
                                <input type="radio" name="sort_type"
                                <?=
                                isset($sort_type) ?
                                        ($sort_type == SORT_LIBRARY_TYPE_FILE_TYPE ? "checked" : "") :
                                        ""
                                ?>
                                       value="<?= SORT_LIBRARY_TYPE_FILE_TYPE ?>"/> File Type
                            </div>
                        </div>
                        <div class="span3">
                            <label class="span1">Order: </label>
                            <div class="span2">
                                <input type="radio" name="sort_order"
                                <?= isset($order) ? ($order == ORDER_LIBRARY_ASC ? "checked" : "") : "checked" ?>
                                       value="<?= ORDER_LIBRARY_ASC ?>"/> Asc
                                <input type="radio" name="sort_order"
                                <?= isset($order) ? ($order == ORDER_LIBRARY_DESC ? "checked" : "") : "" ?>
                                       value="<?= ORDER_LIBRARY_DESC ?>"/> Desc
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
                <form action="index.php?p=1&sh=<?= $on_shelf; ?>" method="post">
                    <input class="span1" name="search" hidden value="<?= $searchQuery ?>"/>
                    <input class="span1" name="sort_type" hidden value="<?= $sort_type ?>"/>
                    <input class="span1" name="sort_order" hidden value="<?= $order ?>"/>
                    <div class="row">
                        <?php if ($on_shelf) { ?>
                            <input class="" onclick="warn()" name="suspend_button" type="submit" value="Take Off Shelf"/>
                        <?php } else { ?>
                            <input class="" onclick="warn()" name="restore_button" type="submit" value="Add To Shelf"/>
                        <?php } ?>
                        <input class="" onclick="warn()" name="delete_button" type="submit" value="Delete"/>
                    </div>
                    <div class="row ntm">
                        <table class="table hovered bordered">
                            <thead>
                                <tr>
                                    <th class="text-left">&nbsp;</th>
                                    <th class="text-left">Publication Details</th>
                                    <th class="text-left">&hellip;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                for ($index = 0; $index < count($books); $index++) {
                                    if ($index != 0 && $index % 20 === 0) {
                                        echo '<tr><td></td><td><a href="#top">back to top</a></td></tr>';
                                    }
                                    ?>
                                    <tr>                            
                                        <td class="text-left"><input type="checkbox" name="checkbox[]" value="<?= $books[$index]['id'] ?>"/></td>
                                        <td class="text-left">
                                            <i>Title:</i> <?= $books[$index]['title']; ?><br/>
                                            <i>Author(s):</i> <?= $books[$index]['author']; ?><br/>
                                            <i>Publisher:</i> <?= $books[$index]['publisher']; ?><br/>
                                            <i>Date Published:</i> <?= $books[$index]['date_published']; ?> | 
                                            <i>ISBN:</i> <?= $books[$index]['isbn']; ?><br/>
                                            <i>Keywords:</i> <?= $books[$index]['keywords']; ?><br/><i>
                                                Contributed By: <?= $books[$index]['contributor']; ?> | 
                                                Date: <?= $books[$index]['date_added']; ?></i>
                                        </td>
                                        <td class="text-left">
                                            Downloads: <?= $books[$index]['num_of_downloads'] ?><br/>
                                            <a href="<?= HOSTNAME . 'download.php?id=' . $books[$index]['id'] ?>" target="new">
                                                <?= '<sup>[' . strtoupper($books[$index]['file_type']) . ']</sup> Download'; ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                echo '<tr><td></td><td colspan="4"><a href="#top">back to top</a></td></tr>';
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <a href="index.php?p=1&sh=0" class="<?= $on_shelf == 1 ? 'button bg-blue bg-hover-dark fg-white place-right' : 'button disabled place-right'; ?>">Off Shelf</a>
                        <a href="index.php?p=1&sh=1" class="<?= $on_shelf == 0 ? 'button bg-blue bg-hover-dark fg-white place-right' : 'button disabled place-right'; ?>">On Shelf</a>
                    </div>
                </form>
            <?php } ?>
        </div>
    </div>
</div>