<?php
require_once 'class_lib.php';
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
        <?php require_once 'default_head_tags.php'; ?>
        <!-- Page Title -->
        <title>NACOSS University of Nigeria, Nsukka</title>        
    </head>
    <body class="metro" style="background-image: url(img/bg.jpg); background-repeat: repeat;">
        <div class="container bg-white" id="wrapper">            
            <?php
            require_once './header.php';
            //Detect browser type
            require_once 'detect.php';
            if (!empty($slides) && $browser_t !== "mobile") {
                ?>
                <!--large home page images-->
                <div class="bg-dark" >
                    <div class="carousel">
                        <div class="bg-transparent no-overflow" id="carousel">
                            <?php
                            foreach ($slides as $value) {
                                ?>
                                <a class="slide image-container" href="<?= $value['href'] ?>">
                                    <img src="<?= HOSTNAME . $value['img_url'] ?>" alt="" class="image"/>
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
                <script>
                    $(function () {
                        $("#carousel").carousel({
                            period: 5000,
                            duration: 1000,
                            effect: 'fade',
                            height: <?= $browser_t === "web" ? 400 : 240 ?>,
                            controls: true,
                            markers: {
                                show: true,
                                type: "default",
                                position: "bottom-right"
                            }
                        });
                    });
                </script>
            <?php } ?>
            <div class="padding10">
                <div class="grid fluid">
                    <div class="row ntm">
                        <!--smaller home page images-->
                        <div class="span9">
                            <?php
                            //Add default images
                            array_push($links, array("href" => "prospectus.php", "caption" => "Prospectus", "img_url" => "img/prospectus.jpg"));
                            array_push($links, array("href" => "library.php", "caption" => "Visit Library", "img_url" => "img/library-icon.png"));
                            array_push($links, array("href" => ALUMNI_HOMEPAGE, "caption" => "Our Alumni", "img_url" => "img/alumni.jpg"));
                            //Dispay
                            for ($i = 0; $i < count($links); $i++) {
                                if ($i % 3 === 0) {
                                    if ($i !== 0) {
                                        echo '</div>';
                                    }
                                    echo '<div class="row">';
                                }
                                ?>

                                <div class="span3 image-container bg-transparent">
                                    <a href="<?= $links[$i]['href'] ?>">
                                        <img class="image" src="<?= HOSTNAME . $links[$i]['img_url'] ?>" alt=""/>
                                    </a>
                                    <div class="overlay-fluid"><?= $links[$i]['caption'] ?></div>
                                </div>

                                <?php
                            }
                            echo '</div>';
                            ?>
                        </div>
                        <div class="span3">
                            <div class="row">
                                <div class="image-container bg-orange span1"  >
                                    <a href="news.php">
                                        <img class="image" src="img/social10.png" alt=""/>
                                    </a>
                                    <div class="overlay-fluid"><a class="fg-white" href="news.php">News and Events</a></div>
                                </div>
                                <div class="image-container bg-green span1"  >
                                    <a href="faq.php">
                                        <img class="image" src="img/question3.png" alt=""/>
                                    </a>
                                    <div class="overlay-fluid"><a class="fg-white" href="faq.php">Get Help</a></div>
                                </div>
                                <div class="image-container bg-lightRed span1">
                                    <a href="login.php?s=2">
                                        <img class="image" src="img/locked59.png" alt=""/>
                                    </a>
                                    <div class="overlay-fluid"><a class="fg-white" href="login.php?s=2">Register</a></div>
                                </div>
                                <div class="image-container bg-blue span1">
                                    <a href="contact.php">
                                        <img class="image" src="img/telephone1.png" alt=""/>
                                    </a>
                                    <div class="overlay-fluid"><a class="fg-white" href="contact.php">Contact</a></div>
                                </div>
                            </div>
                            <div  class="row listview-outlook">
                                <h4 class="padding5 bg-NACOSS-UNN fg-white">Latest Stories</h4>
                                <?php
                                $allNews = $news->getAllNews();
                                if (!empty($allNews)) {
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
                                } else {
                                    ?>
                                    <a href="#" class="list">
                                        <div class="list-content">
                                            <span class="list-title fg-lightBlue">No latest stories</span>
                                        </div>
                                    </a>
                                    <?php
                                }
                                ?>
                                <h4 class="padding5 bg-NACOSS-UNN fg-white">Top Stories</h4>
                                <?php
                                $topNews = $news->getTopNews();
                                if (!empty($topNews)) {
                                    foreach ($topNews as $value) {
                                        ?>
                                        <a href="news_post.php?id=<?= $value['id'] ?>" class="list">
                                            <div class="list-content">
                                                <span class="list-title fg-lightBlue"><?= $value['title'] ?></span>
                                            </div>
                                        </a>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <a href="#" class="list">
                                        <div class="list-content">
                                            <span class="list-title fg-lightBlue">No top stories</span>
                                        </div>
                                    </a>
                                    <?php
                                }
                                ?>
                            </div>  
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
                                <a href="http://www.ispon.org/" target="_blank">
                                    <img src="img/sponsors/ispon.jpg" alt="" style="height: 50px; width: 50px"/>
                                </a>
                            </div>
                            <div class="span1">
                                <a href="http://cpn.gov.ng/" target="_blank">
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
