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
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="description" content="NACOSS UNN official website">
        <meta name="author" content="NACOSS UNN Developers">
        <meta name="keywords" content=" metro ui, NDG, NACOSS UNN">
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

        <link href="css/metro-bootstrap.css" rel="stylesheet">
        <link href="css/metro-bootstrap-responsive.css" rel="stylesheet">
        <link href="css/iconFont.css" rel="stylesheet">
        <link href="js/prettify/prettify.css" rel="stylesheet">

        <script src="js/metro/metro.min.js"></script>

        <!-- Load JavaScript Libraries -->
        <script src="js/jquery/jquery.min.js"></script>
        <script src="js/jquery/jquery.widget.min.js"></script>
        <script src="js/jquery/jquery.mousewheel.js"></script>
        <script src="js/prettify/prettify.js"></script>

        <!-- Metro UI CSS JavaScript plugins -->
        <script src="js/load-metro.js"></script>

        <!-- Local JavaScript -->
        <script src="js/docs.js"></script>
        <script src="js/github.info.js"></script>

        <!-- Page Title -->
        <title><?= $news['title'] ?></title>        
    </head>
    <body class="metro" style="background-image: url(img/bg.jpg); background-repeat: repeat;">
        <div class="container bg-white">            
            <?php require_once './header.php'; ?>
            <br/>
            <div class="padding20">
                <h2><?= $news['title']; ?></h2>
                <h5><?= "Posted on: " . $news['time_of_post']; ?></h5>
                <hr>
                <h6 style="text-align: center;"><a href="news.php">
                        -Back to news page</a>&nbsp;&nbsp;||&nbsp;&nbsp;<a href="index.php">Return to Home-</a>
                </h6>
                <div style='text-align:justify'>
                    <?= $news['content']; ?>
                </div>
                <h6 style="text-align: center;"><a href="news.php">-Back to news page</a>&nbsp;&nbsp;||&nbsp;&nbsp;<a href="index.php">Return to Home-</a></h6>

            </div>
            <br/>
            <?php require_once './footer.php'; ?>
        </div>
    </body>
</html>
