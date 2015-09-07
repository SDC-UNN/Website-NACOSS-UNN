<?php
//Initializing variables with default values
$defaultPage = "index.php?p=2";
        const MEDIA = "video";
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
    $videos = searchLibraryItems($searchQuery, MEDIA, $on_shelf, $sort_type, $order);
} else {
    //Process GET requests or no requests
    $page = filter_input(INPUT_GET, "pg");
    if (isset($page)) {
        //if switching page, repeat search
        $searchQuery = filter_input(INPUT_GET, "q");
        $sort_type = filter_input(INPUT_GET, "s");
        $order = filter_input(INPUT_GET, "o");

        $videos = searchLibraryItems($searchQuery, MEDIA, $on_shelf, $sort_type, $order);
    } else {
        $page = 1;
        $videos = getLibraryItems(MEDIA, $on_shelf);
    }
}
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
<script>
    function warn() {
        var ok = confirm("Are you sure?");
        if (ok === false) {
            //Cancel request
            $("#form").submit(function () {
                return false;
            });
        }
    }
    ;
    function editVideo(id, title, author, publisher, date_pub, keywords, contributor, date_added) {
        console.log("Here");
        $.Dialog({
            overlay: true,
            shadow: true,
            flat: true,
            icon: '<img src="../../favicon.ico">',
            title: 'Edit Video',
            content: '<form class="span7">' +
                    '<div id="message_box" class="row"><p class="padding5">Fill in the boxes</p></div>' +
                    '<input hidden id="_id" value="' + id + '"/>' +
                    '<input hidden id="_date_added" value="' + date_added + '"/>' +
                    '<div class="row">' +
                    '<label class="label span2">Title</label>' +
                    '<input type="text" required id="_title" class="span5" value="' + title + '"/>' +
                    '</div>' +
                    '<div class="row">' +
                    '<label class="label span2">Author</label>' +
                    '<input type="text" id="_author" class="span5" value="' + author + '"/>' +
                    '</div>' +
                    '<div class="row">' +
                    '<label class="label span2">Publisher</label>' +
                    '<input type="text" id="_pub" class="span5" value="' + publisher + '"/>' +
                    '</div>' +
                    '<div class="row">' +
                    '<label class="label span2">Date Published</label>' +
                    '<input type="text" id="_pub_date" class="span5" value="' + date_pub + '"/>' +
                    '</div>' +
                    '<div class="row">' +
                    '<label class="label span2">Keywords</label>' +
                    '<input type="text" id="_keywords" class="span5" value="' + keywords + '"/>' +
                    '</div>' +
                    '<div class="row">' +
                    '<label class="label span2">Contributor</label>' +
                    '<input type="text" id="_contributor" class="span5" value="' + contributor + '"/>' +
                    '</div>' +
                    '<div style="margin-left: 450px" class="button bg-blue bg-hover-dark fg-white" onclick="edit()">' +
                    'Update' +
                    '</div>' +
                    '</div>' +
                    '</form>',
            padding: 10
        });
    }
    ;
    function edit() {
        var id = document.getElementById("_id").value;
        var title = document.getElementById("_title").value;
        var author = document.getElementById("_author").value;
        var pub = document.getElementById("_pub").value;
        var date_pub = document.getElementById("_pub_date").value;
        var keywords = document.getElementById("_keywords").value;
        var contributor = document.getElementById("_contributor").value;
        var date_added = document.getElementById("_date_added").value;
        if (id !== "") {
            var xmlHttp;
            if (window.XMLHttpRequest) {
                xmlHttp = new XMLHttpRequest();
            } else {
                xmlHttp = new ActiveObject("Microsoft.XMLHTTP");
            }
            xmlHttp.onreadystatechange = function () {
                if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
                    switch (xmlHttp.responseText) {
                        case "OK":
                            var msg = document.getElementById("message_box");
                            msg.innerHTML = "<p class='padding5'>Video updated!</p>";
                            msg.setAttribute("style", "background-color:lightgreen;");
                            //Update cell
                            var td = document.getElementById("_" + id);
                            td.innerHTML = "<strong>Title:</strong> " + title + "<br/>" +
                                    "<strong>Author(s):</strong> " + author + "<br/>" +
                                    "<strong>Publisher:</strong> " + pub + "<br/>" +
                                    "<strong>Date Published:</strong> " + date_pub + "<br/>" +
                                    "<strong>Keywords:</strong> " + keywords + "<br/>" +
                                    "<strong>Contributed By:</strong> " + contributor + "<br/>" +
                                    "<strong>Date:</strong> " + date_added;
                            //Update Edit Button                            
                            var eb = document.getElementById("_" + id + "editButton");
                            eb.setAttribute("onclick", "editVideo('" + id + "',"
                                    + "'" + title + "',"
                                    + "'" + author + "',"
                                    + "'" + pub + "',"
                                    + "'" + date_pub + "',"
                                    + "'" + keywords + "',"
                                    + "'" + contributor + "',"
                                    + "'" + date_added + "');");
                            break;
                        case "FAILED":
                            var msg = document.getElementById("message_box");
                            msg.setAttribute("style", "background-color:pink;");
                            msg.innerHTML = "<p class='padding5'>Video update failed</p>";
                            break;
                        case "INVALID REQUEST":
                            var msg = document.getElementById("message_box");
                            msg.setAttribute("style", "background-color:pink;");
                            msg.innerHTML = "<p class='padding5'>Oops! Something went wrong</p>";
                            break;
                        default :
                            var msg = document.getElementById("message_box");
                            msg.setAttribute("style", "background-color:pink;");
                            msg.innerHTML = "<p class='padding5'>Unknown response</p>";
                            break;
                    }
                }
            };
            xmlHttp.open("GET", "xmlhttp.php?"
                    + "op=update_lib"
                    + "&id=" + id
                    + "&title=" + title
                    + "&author=" + author
                    + "&pub=" + pub
                    + "&date_pub=" + date_pub
                    + "&isbn="
                    + "&keywords=" + keywords
                    + "&contributor=" + contributor
                    );
            xmlHttp.send();
        }
    }
</script>
<div>
    <h4>VIDEOS: <?= $on_shelf == 1 ? 'ON SHELF' : 'OFF SHELF'; ?></h4>
    <div class="row">
        <a href="index.php?p=2&sh=0" class="<?= $on_shelf == 1 ? 'button bg-blue bg-hover-dark fg-white place-right' : 'button disabled place-right'; ?>">Off Shelf</a>
        <a href="index.php?p=2&sh=1" class="<?= $on_shelf == 0 ? 'button bg-blue bg-hover-dark fg-white place-right' : 'button disabled place-right'; ?>">On Shelf</a>
    </div>
    <div class="row">
        <?php
        if (empty($videos) and ! isset($array['search_button'])) {
            echo '<p>No videos in this category</p>';
        } else {
            ?>
            <div class="bg-grayLighter padding5">
                <form method="post" action="index.php?p=2&sh=<?= $on_shelf; ?>">
                    <div class="input-control text" data-role="input-control">
                        <input type="text" value="<?= $searchQuery ?>" placeholder="Search Books" name="search"/>
                        <button class="btn-search" name="search_button" type="submit"></button>
                    </div>

                    <div class="row ntm">
                        <div class="span9">
                            <label class="">Sort by: </label>
                            <div class="input-control radio">
                                <label>
                                    <input type="radio" name="sort_type" 
                                    <?=
                                    isset($sort_type) ?
                                            ($sort_type == SORT_LIBRARY_TYPE_TITLE ? "checked" : "") :
                                            "checked"
                                    ?>
                                           value="<?= SORT_LIBRARY_TYPE_TITLE ?>"/>
                                    <span class="check"></span>
                                    Title
                                </label>
                            </div>
                            <div class="input-control radio">
                                <label>
                                    <input type="radio" name="sort_type"
                                    <?=
                                    isset($sort_type) ?
                                            ($sort_type == SORT_LIBRARY_TYPE_AUTHOR ? "checked" : "") :
                                            ""
                                    ?>
                                           value="<?= SORT_LIBRARY_TYPE_AUTHOR ?>"/>
                                    <span class="check"></span>
                                    Author
                                </label>
                            </div>
                            <div class="input-control radio">
                                <label>
                                    <input type="radio" name="sort_type"
                                    <?=
                                    isset($sort_type) ?
                                            ($sort_type == SORT_LIBRARY_TYPE_FILE_TYPE ? "checked" : "") :
                                            ""
                                    ?>
                                           value="<?= SORT_LIBRARY_TYPE_FILE_TYPE ?>"/>
                                    <span class="check"></span>
                                    File Type
                                </label>
                            </div>
                        </div>
                        <div class="span3">
                            <label class="">Order: </label>
                            <div class="input-control radio">
                                <label>
                                    <input type="radio" name="sort_order"
                                    <?= isset($order) ? ($order == ORDER_LIBRARY_ASC ? "checked" : "") : "checked" ?>
                                           value="<?= ORDER_LIBRARY_ASC ?>"/>
                                    <span class="check"></span>
                                    Asc
                                </label>
                            </div>
                            <div class="input-control radio">
                                <label>
                                    <input type="radio" name="sort_order"
                                    <?= isset($order) ? ($order == ORDER_LIBRARY_DESC ? "checked" : "") : "" ?>
                                           value="<?= ORDER_LIBRARY_DESC ?>"/>
                                    <span class="check"></span>
                                    Desc
                                </label>
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
                <form action="index.php?p=2&sh=<?= $on_shelf; ?>" method="post" id="form">
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
                                for ($index = 0; $index < count($videos); $index++) {
                                    if ($index != 0 && $index % 10 === 0) {
                                        echo '<tr><td></td><td colspan="2"><a href="#top">back to top</a></td></tr>';
                                    }
                                    ?>
                                    <tr>                            
                                        <td class="text-left">
                                            <input type="checkbox" name="checkbox[]" value="<?= $videos[$index]['id'] ?>"/>
                                        </td>
                                        <td class="text-left" id="_<?= $videos[$index]['id'] ?>">
                                            <strong>Title:</strong> <?= $videos[$index]['title']; ?><br/>
                                            <strong>Author(s):</strong> <?= $videos[$index]['author']; ?><br/>
                                            <strong>Publisher:</strong> <?= $videos[$index]['publisher']; ?><br/>
                                            <strong>Date Published:</strong> <?= $videos[$index]['date_published']; ?><br/>
                                            <strong>Keywords:</strong> <?= $videos[$index]['keywords']; ?><br/>
                                            <strong>Contributed By:</strong> <?= $videos[$index]['contributor']; ?><br/>
                                            <strong>Date:</strong> <?= $videos[$index]['date_added']; ?>
                                        </td>
                                        <td class="text-left">
                                            Downloads: <?= $videos[$index]['num_of_downloads'] ?><br/>
                                            <br/>
                                            <a href="<?= HOSTNAME . 'download.php?id=' . $videos[$index]['id'] ?>" target="new">
                                                <?= '<sup>[' . strtoupper($videos[$index]['file_type']) . ']</sup> Download'; ?>
                                            </a><br/>
                                            <br/>
                                            <?php
                                            if (is_file(ROOT . $videos[$index]['link'])) {
                                                $size = filesize(ROOT . $videos[$index]['link']);
                                                echo "Size: " . bytesToSize($size);
                                            }
                                            ?><br/>
                                            <br/>
                                            <div class="button" id="_<?= $videos[$index]['id'] ?>editButton" onclick="editVideo('<?= $videos[$index]['id'] ?>',
                                                                    '<?= $videos[$index]['title']; ?>',
                                                                    '<?= $videos[$index]['author']; ?>',
                                                                    '<?= $videos[$index]['publisher']; ?>',
                                                                    '<?= $videos[$index]['date_published']; ?>',
                                                                    '<?= $videos[$index]['keywords']; ?>',
                                                                    '<?= $videos[$index]['contributor']; ?>',
                                                                    '<?= $videos[$index]['date_added']; ?>');">Edit</div>
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
                        <a href="index.php?p=2&sh=0" class="<?= $on_shelf == 1 ? 'button bg-blue bg-hover-dark fg-white place-right' : 'button disabled place-right'; ?>">Off Shelf</a>
                        <a href="index.php?p=2&sh=1" class="<?= $on_shelf == 0 ? 'button bg-blue bg-hover-dark fg-white place-right' : 'button disabled place-right'; ?>">On Shelf</a>
                    </div>
                </form>
            <?php } ?>
        </div>
    </div>
</div>