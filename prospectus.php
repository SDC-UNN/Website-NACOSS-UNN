<?php
require_once 'class_lib.php';
//Set page number
$page = filter_input(INPUT_GET, "p");
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
        <title>NACOSS UNN : Prospectus</title>        
    </head>
    <body class="metro" style="background-image: url(img/bg.jpg); background-repeat: repeat;">
        <div class="container bg-white" id="wrapper">            
            <?php require_once 'header.php'; ?>
            <div class="padding20">
                <h1 class="fg-dark">Prospectus</h1>
                <div class="grid">
                    <div class="row">
                        <div class="span3">
                            <nav class="sidebar">
                                <ul class="">
                                    <li class="<?= empty($page) || $page == 1 ? "stick bg-NACOSS-UNN" : "" ?>">
                                        <a href="prospectus.php?p=1"></i>1<sup>st</sup> year</a>
                                    </li>
                                    <li class="<?= $page == 2 ? "stick bg-NACOSS-UNN" : "" ?>">
                                        <a href="prospectus.php?p=2">2<sup>nd</sup> year</a>
                                    </li>
                                    <li class="<?= $page == 3 ? "stick bg-NACOSS-UNN" : "" ?>">
                                        <a href="prospectus.php?p=3">3<sup>rd</sup> year</a>
                                    </li>
                                    <li class="<?= $page == 4 ? "stick bg-NACOSS-UNN" : "" ?>">
                                        <a href="prospectus.php?p=4">4<sup>th</sup> year</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>

                        <div class="span9">
                            <?php
                            switch ($page) {
                                case 1: require_once 'prospectus$1.php';
                                    break;
                                case 2: require_once 'prospectus$2.php';
                                    break;
                                case 3: require_once 'prospectus$3.php';
                                    break;
                                case 4: require_once 'prospectus$4.php';
                                    break;
                                default :
                                    require_once 'prospectus$1.php';
                                    break;
                            }
                            ?>
                        </div>
                    </div>
                </div>

            </div>

            <?php require_once './footer.php'; ?>
        </div>
    </body>
</html>
