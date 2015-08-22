<?php
require_once 'class_lib.php';
$user = new User();
$library = new Collections();
//Initializing fields with default values
$max_view_length = 10;
$page = 1;
$total_pages = 1;
$sort_type = Collections::SORT_TYPE_TITLE;
$order = SORT_ASC;

if (!$user->isLoggedIn()) {
    //This page is for registered users only
    header("Location: login.php");
} else {
    $searchQuery = "";
    $searchRequest = filter_input(INPUT_POST, "submit");
    if (isset($searchRequest)) {

        //Process search query
        $searchQuery = html_entity_decode(filter_input(INPUT_POST, "search"));
        $sort_type = html_entity_decode(filter_input(INPUT_POST, "sort_type"));
        $order = html_entity_decode(filter_input(INPUT_POST, "sort_order"));

        $library->sortBooks($sort_type, $order);

        $array = $library->searchBooks($searchQuery);
    } else {
        $page = filter_input(INPUT_GET, "p");
        if (isset($page)) {
            //if switching page, repeat search
            $searchQuery = filter_input(INPUT_GET, "q");
            $sort_type = filter_input(INPUT_GET, "s");
            $order = filter_input(INPUT_GET, "o");

            $library->sortBooks($sort_type, $order);
            $array = $library->searchBooks($searchQuery);
        } else {
            $page = 1;
            $array = $library->getBooks();
        }
    }


    if (count($array) > $max_view_length) {
        $total_pages = count($array) % $max_view_length === 0 ?
                count($array) / $max_view_length :
                floor(count($array) / $max_view_length) + 1;
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

<html>
    <head>
        <?php require_once 'default_head_tags.php'; ?>

        <!-- Page Title -->
        <title>NACOSS UNN : Library</title>        
    </head>
    <body class="metro" style="background-image: url(img/bg.jpg); background-repeat: repeat;">
        <div class="container bg-white" id="wrapper">            
            <?php require_once 'header.php'; ?>
            <div class="padding20 grid fluid">
                <h1 class="fg-dark">Library</h1>
                <form method="post" action="library.php" class="bg-grayLighter padding5 row ntm">
                    <div class="input-control text" data-role="input-control">
                        <input type="text" value="<?= $searchQuery ?>" placeholder="Search Library" name="search"/>
                        <button class="btn-search" name="submit" type="submit"></button>
                    </div>

                    <div class="row ntm">
                        <!--                        <div class="input-control radio">
                                                        <label>
                                                            <input type="radio" />
                                                            <span class="check"></span>
                                                            Check me out
                                                        </label>
                                                    </div>-->

                        <div class="row ntm">
                            <label class="span2">Sort by: </label>
                            <div class="input-control radio span3">
                                <label>
                                    <input type="radio" name="sort_type" 
                                    <?=
                                    isset($sort_type) ?
                                            ($sort_type == Collections::SORT_TYPE_TITLE ? "checked" : "") :
                                            "checked"
                                    ?> value="<?= Collections::SORT_TYPE_TITLE ?>"/>
                                    <span class="check"></span>
                                    Title
                                </label>
                            </div>
                            <div class="input-control radio span3">
                                <label>
                                    <input type="radio" name="sort_type"
                                    <?=
                                    isset($sort_type) ?
                                            ($sort_type == Collections::SORT_TYPE_AUTHOR ? "checked" : "") :
                                            ""
                                    ?> value="<?= Collections::SORT_TYPE_AUTHOR ?>"/>
                                    <span class="check"></span>
                                    Author
                                </label>
                            </div>
                            <div class="input-control radio span3">
                                <label>
                                    <input class="span1" type="radio" name="sort_type"
                                    <?=
                                    isset($sort_type) ?
                                            ($sort_type == Collections::SORT_TYPE_DATE_ADDED ? "checked" : "") :
                                            ""
                                    ?> value="<?= Collections::SORT_TYPE_DATE_ADDED ?>"/>
                                    <span class="check"></span>
                                    Date Added
                                </label>
                            </div>
                        </div>

                        <div class="row ntm">
                            <label class="span2">Order: </label>
                            <div class="input-control radio span3">
                                <label>
                                    <input type="radio" name="sort_order"
                                    <?= isset($order) ? ($order == SORT_ASC ? "checked" : "") : "checked" ?>
                                           value="<?= SORT_ASC ?>"/>
                                    <span class="check"></span>
                                    Ascending
                                </label>
                            </div>
                            <div class="input-control radio span3">
                                <label>
                                    <input type="radio" name="sort_order"
                                    <?= isset($order) ? ($order == SORT_DESC ? "checked" : "") : "" ?>
                                           value="<?= SORT_DESC ?>"/>
                                    <span class="check"></span>
                                    Descending
                                </label>
                            </div>                                      
                        </div>

                    </div>
                </form>

                <?php include 'library_pagination.php'; ?>

                <table class="table hovered striped">
                    <?php
                    if (empty($array)) {
                        echo '<div class="text-center">';
                        echo '<h2>Nothing found</h2>';
                        echo '</div>';
                    } else {
                        $start = ($page - 1) * $max_view_length;
                        $remainingItems = count($array) - $start;
                        $stop = $start + min(array($remainingItems, $max_view_length));
                        for ($index = $start; $index < $stop; $index++) {
                            ?>
                            <tr class="">
                                <td class="">
                                    <div class="row ntm nbm">
                                        <div class="span1">
                                            <?php
                                            if (file_exists("img/file_types/" . $array[$index]['file_type'] . ".png")) {
                                                ?>
                                                <img src="img/file_types/<?= $array[$index]['file_type'] ?>.png" alt="Icon"/>
                                                <?php
                                            } else {
                                                ?>
                                                <img src="img/file_types/nil.png" alt="Icon"/>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="span11">
                                            <h4>
                                                <?= $array[$index]['title'] ?> 
                                                <?= empty($array[$index]['file_type']) ? "" : "[" . $array[$index]['file_type'] . "]" ?>
                                            </h4>
                                            <p>
                                                by <?= $array[$index]['author'] ?>
                                                <a class="button link" target="_blank" href="download.php?id=<?= $array[$index]['id'] ?>">Download</a>
                                                <br/>
                                                <?= $array[$index]['num_of_downloads'] ?> download(s)
                                            </p>   
                                        </div>
                                    </div>

                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </table>

                <?php include 'library_pagination.php'; ?>
            </div>
            <?php require_once 'footer.php'; ?>
        </div>
    </body>
</html>
