<?php
require_once './class_lib.php';
$news = new NewsFeeds();
$slides = NewsFeeds::getLargeHomePageImages();
$links = NewsFeeds::getSmallHomePageImages();
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
        <title>NACOSS UNN : Home</title>        
    </head>
    <body class="metro" style="background-image: url(img/bg.jpg); background-repeat: repeat;">
        <div class="container bg-white" id="wrapper">            
            <?php require_once './header.php'; ?>
            <div class=" bg-dark" style="height: 400px">

                <div class="on-phone no-desktop no-tablet" style="background: url(img/b5.jpg) top left no-repeat; background-size: cover; height: 400px;">
                    <div class="container" style="padding: 50px 20px">
                        <div class="panel no-border" style="background-color: rgba(0,0,0,0.7)">
                            <div class="panel-content">
                                <?php
                                foreach ($slides as $value) {
                                    ?>
                                    <h2 class="fg-white">
                                        <i class="icon-arrow-right-5"></i>
                                        <a class="fg-white fg-hover-NACOSS-UNN" href="<?= $value['href'] ?>">
                                            <?= $value['caption'] ?>
                                        </a>
                                    </h2>
                                    <?php
                                }
                                ?> 
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-dark no-phone" style="height: 400px">
                    <div class="carousel">
                        <div class="bg-transparent no-overflow" id="carousel">
                            <?php
                            foreach ($slides as $value) {
                                ?>
                                <a class="slide image-container" href="<?= $value['href'] ?>">
                                    <img src="<?= $value['img_url'] ?>" alt="" class="image"/>
                                    <div class="overlay">
                                        <h2 class="fg-white">
                                            <?= $value['caption'] ?> 
                                        </h2>
                                    </div>
                                </a>
                                <?php
                            }
                            ?> 
                            <a class="controls left fg-white"><i class="icon-arrow-left-5"></i></a>
                            <a class="controls right  fg-white"><i class="icon-arrow-right-5"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                $(function () {
                    $("#carousel").carousel({
                        period: 5000,
                        duration: 1000,
                        effect: 'fade',
                        height: 400,
                        controls: true,
                        markers: {
                            show: true,
                            type: "default",
                            position: "bottom-right"
                        }
                    });
                });
            </script>

            <div class="grid">
                <div class="row">
                    <div class="span10 no-phone"  style="padding-left: 50px">
                        <?php
                        for ($i = 0; $i < count($links); $i++) {
                            if ($i % 3 === 0) {
                                if ($i === 0) {
                                    echo '<div class="row">';
                                } else {
                                    echo '</div>';
                                    echo '<div class="row">';
                                }
                            }
                            ?>
                            <div class="span3">
                                <div class="image-container"  style="height: 230px; width: 230px">
                                    <a href="<?= $links[$i]['href'] ?>">
                                        <img class="image" style="height: 100%; width: 100%" src="<?= $links[$i]['img_url'] ?>" alt=""/>
                                    </a>
                                    <div class="overlay-fluid"><?= $links[$i]['caption'] ?></div>
                                </div>
                            </div>
                            <?php
                        }
                        echo '</div>';
                        ?>
                    </div>
                    <div class="span4">
                        <div  class="listview-outlook">
                            <?php
                            $allNews = $news->getAllNews();
                            if (!empty($allNews)) {
                                ?>
                                <h4 class="padding5 bg-NACOSS-UNN fg-white">Latest Stories</h4>
                                <?php
                                $length = min(array(5, count($allNews)));
                                for ($index = 0; $index < $length; $index++) {
                                    ?>
                                    <a href="news_post.php?id=<?= $allNews[$index]['id'] ?>" class="list">
                                        <div class="list-content">
                                            <span class="list-title fg-lightBlue"><?= $allNews[$index]['title'] ?></span>
                                        </div>
                                    </a>
                                    <?php
                                }
                                ?>
                                <br/>
                                <?php
                            }

                            $topNews = $news->getTopNews();
                            if (!empty($topNews)) {
                                ?>
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
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-grayLighter">
                <div class="padding5 grid">
                    <div class="row">
                        <small class="span1" style="padding-top: 15px">Sponsors</small>
                        <div class="span11">
                            <div class="span1">
                                <a href="http://unn.edu.ng" target="_blank">
                                    <img src="img/sponsors/UNN_Logo.png" alt="" style="height: 50px; width: 50px"/>
                                </a>
                            </div>
                            <div class="span1">
                                <a href="http://ncs.org.ng" target="_blank">
                                    <img src="img/sponsors/ncs.jpg" alt="" style="height: 50px; width: 50px"/>
                                </a>
                            </div>
                            <div class="span1">
                                <a href="#" target="_blank">
                                    <img src="img/sponsors/ispon.jpg" alt="" style="height: 50px; width: 50px"/>
                                </a>
                            </div>
                            <div class="span1">
                                <a href="#" target="_blank">
                                    <img src="img/sponsors/cpn.jpg" alt="" style="height: 50px; width: 50px"/>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
            </div>
            <?php require_once './footer.php'; ?>
        </div>
    </body>
</html>
