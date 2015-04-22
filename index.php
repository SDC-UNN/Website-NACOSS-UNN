<?php
require_once './class_lib.php';
$array = NewsFeeds::getLargeHomePageImages();
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
        <div class="container bg-white">            
            <?php require_once './header.php'; ?>
            <div class=" bg-dark" style="height: 400px">

                <div class="on-phone no-desktop no-tablet" style="background: url(img/b5.jpg) top left no-repeat; background-size: cover; height: 400px;">
                    <div class="container" style="padding: 50px 20px">
                        <div class="panel no-border" style="background-color: rgba(0,0,0,0.7)">
                            <div class="panel-content">
                                <?php
                                foreach ($array as $value) {
                                    ?>
                                    <h2 class="fg-white">
                                        <i class="icon-arrow-right-5"></i>
                                        <a class="fg-white fg-hover-NACOSS-UNN" href="<?= $value['link'] ?>">
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
                            foreach ($array as $value) {
                                ?>
                                <a class="slide image-container" target="_blank" href="<?= $value['link'] ?>">
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
            <br/>

            <!--Your code goes here-->
			
				<div style = "margin:0% 10% 0% 10%; ">
				
					<div style = "float:left; clear:right; margin-right:10%">	
						<div class="image-container shadow">
							<img src="img/prosp.jpg">
								<div class="overlay-fluid">
									What do You Know about Your Department? View The NACOSS prospectus to stay informed.
								</div>
						</div>
					</div>
						
					<div style = "float:left; clear:right; margin-right:10%">		
						<div class="image-container shadow">
							<img src="img/lib.jpg">
								<div class="overlay-fluid">
									The NACOSS online library is now available for you. View materials now, or help us grow by submitting e-books for archiving.
								</div>
						</div>
					</div>
					
					<div style = "float:left; clear:right">			
						<div class="image-container shadow">
							<img src="img/ndg.jpg">
								<div class="overlay-fluid">
									Contribute to this and other future projects... <br> Join <a href = "#"> NDG </a> today.
								</div>
						</div>
					</div>
				
				</div>
				
            <!--Your code goes here-->


            <br/>
            <div class="bg-grayLighter style = "clear:left"> <!-- added clear left -->
                <div class="padding5 grid">
                    <div class="row">
                        <small class="span1" style="padding-top: 15px">sponsors</small>
                        <div class="span11">
                            <div class="">
                                <a href="http://unn.edu.ng">
                                    <img src="img/sponsors/UNN_Logo.png" alt="" style="height: 50px; width: 50px"/>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php require_once './footer.php'; ?>
            </div>
        </div>
    </body>
</html>
