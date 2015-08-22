<?php
require_once 'class_lib.php';
$news = new NewsFeeds();
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
        <title>NACOSS UNN : News</title>      

    </head>
    <body class="metro" style="background-image: url(img/bg.jpg); background-repeat: repeat;">
        <div class="container bg-white" id="wrapper">            
            <?php require_once 'header.php'; ?>
            <div class="padding20">
                <div class="grid fluid">
                    <h1>News / Events</h1>
                    <?php
                    $allNews = $news->getAllNews();
                    $topNews = $news->getTopNews();
                    if (empty($allNews)) {
                        ?>
                        <p>no post</p>
                        <?php
                    } else {
                        ?>
                        <div class="row ntm">
                            <div class="span8 ntm listview-outlook">
                                <?php
                                foreach ($allNews as $value) {
                                    ?>
                                    <a href="news_post.php?id=<?= $value['id'] ?>" class="list">
                                        <div class="list-content text-left">
                                            <h4 class="fg-lightBlue"><?= $value['title'] ?></h4>
                                            <small class="">
                                                <?php
                                                $plain = strip_tags($value['content']); //get plain text
                                                $preview = str_split($plain, 80)[0]; //get first 80 characters
                                                echo $preview . "...";
                                                ?>
                                                <br/>
                                                <strong>Posted: <?= $value['time_of_post'] ?></strong>
                                            </small>
                                        </div>
                                    </a>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="span4 listview-outlook">
                                <h4 class="padding5 bg-NACOSS-UNN fg-white">Top Stories</h4>
                                <?php
                                foreach ($topNews as $value) {
                                    ?>
                                    <a href="news_post.php?id=<?= $value['id'] ?>" class="list">
                                        <div class="list-content">
                                            <span class="list-title fg-lightBlue"><?= $value['title'] ?></span>
                                        </div>
                                    </a>
                                    <?php
                                }
                                ?>
                            </div> 
                        </div>

                        <?php
                    }
                    ?></div>
            </div>
            <?php require_once 'footer.php'; ?>
        </div>

    </body>
</html>
