<?php
require_once 'class_lib.php';

$id = filter_input(INPUT_GET, "id");
if (!empty($id)) {
    $all_news = new NewsFeeds();
    $news = $all_news->getNews($id);
    if (empty($news)) {
        header("location: news.php");
    } else {
        $all_news->plusOneHit($id);
    }
} else {
    header("location: news.php");
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
        <title><?= $news['title'] ?></title>        
    </head>
    <body class="metro" style="background-image: url(img/bg.jpg); background-repeat: repeat;">
        <div class="container bg-white" id="wrapper">            
            <?php require_once './header.php'; ?>
            <div class="padding20">
                <div class="grid fluid">
                    <h2><?= $news['title']; ?></h2>
                    <h5><?= strftime("Posted on %A %#d, %B %Y by %H:%M ", strtotime($news['time_of_post'])) ?></h5>
                    <hr>
                    <div class="row">
                        <a class="link span2" href="news.php">Back</a>
                        <a class="link span2" href="index.php">Home</a>
                    </div>
                    <div class="row">
                        <?= $news['content']; ?>
                    </div>
                    <div class="row">
                        <a class="link span2" href="news.php">Back</a>
                        <a class="link span2" href="index.php">Home</a>
                    </div>
                </div>
            </div>
            <?php require_once './footer.php'; ?>
        </div>
    </body>
</html>
