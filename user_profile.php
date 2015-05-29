<?php
require_once 'class_lib.php';
/*
 * Copyright 2015 NACOSS UNN Developers Group (NDG).
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

$id = filter_input(INPUT_GET, "id");
//URL for back link
$url = filter_input(INPUT_GET, "url");

$array = UserUtility::getUserInfo($id);
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
        <title>NACOSS UNN : <?= empty($array) ? "" : $array['last_name'] . " " . $array['first_name'] ?></title>        
    </head>
    <body class="metro" style="background-image: url(img/bg.jpg); background-repeat: repeat;">
        <div class="container bg-white" id="wrapper">            
            <?php require_once './header.php'; ?>
            <br/>
            <div class="padding20">

                <?php
                if (empty($array)) {
                    ?>
                    <p>User information is not available</p>
                    <a href="<?= $url ?>">
                        <i class="icon-arrow-left-2"></i> Back
                    </a>
                    <?php
                } else {
                    ?>
                    <div>
                        <h2><?= $array['last_name'] . " " . $array['first_name'] ?>'s Profile</h2>
                        <div class="row">
                            <a href="<?= $url ?>">
                                <i class="icon-arrow-left-2"></i> Back
                            </a>
                        </div>
                        <?php
                        if ($array['is_deleted'] == 1) {
                            ?>
                            <p>This account no longer exist, please contact site admin if this is an error</p>
                            <?php
                        } else if ($array['is_suspended'] == 1) {
                            ?>
                            <p>This account has been suspended, contact site admin to resolve this</p>
                            <?php
                        } else {
                            ?>
                            <div class="row ntp ntm">
                                <div class="">
                                    <div class="grid">
                                        <div class="row">
                                            <div class="span2 no-phone no-tablet bg-grayLighter">
                                                <img class="image shadow padding5" src="<?=
                                                isset($array['pic_url']) && !empty($array['pic_url']) ?
                                                        HOSTNAME . $array['pic_url'] :
                                                        HOSTNAME . "img/picture5.png"
                                                ?>" alt=""/>
                                            </div>
                                            <!--For phones and tablets-->
                                            <div style="height: 100px; width: 100px" class="on-phone on-tablet no-desktop bg-grayLighter">
                                                <img style="height: inherit; width: inherit" class="image padding5" src="<?=
                                                isset($array['pic_url']) && !empty($array['pic_url']) ?
                                                        HOSTNAME . $array['pic_url'] :
                                                        HOSTNAME . "img/picture5.png"
                                                ?>" alt=""/>
                                            </div>
                                            <div class="span7 bg-grayLighter shadow">
                                                <div class="padding10">
                                                    <!--Name-->
                                                    <h2>
                                                        <?php
                                                        echo strtoupper($array['first_name']) . " ";
                                                        echo empty($array['last_name']) ? "" : strtoupper($array['other_names']) . " ";
                                                        echo strtoupper($array['last_name'])
                                                        ?>
                                                    </h2>
                                                    <!--Registration number-->
                                                    <p><?= $array['regno'] ?> 
                                                        <!--Show verification status-->
                                                        <?php
                                                        if (isset($array['verified']) && $array['verified'] == 1) {
                                                            echo '<i title="Verified" class="icon-checkmark fg-NACOSS-UNN"></i>';
                                                        }
                                                        ?>
                                                    </p>
                                                    <!--Department and level-->
                                                    <?php
                                                    if (isset($array['department']) && !empty($array['department'])) {
                                                        echo "Department of " . ucwords($array['department']);
                                                        echo '<br/>';
                                                        echo ucwords($array['level']) . " Level, ";
                                                        echo 'Class of ' . $array['entry_year'];
                                                        echo '<br/>';
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row ntm">
                                <div class="">
                                    <div class="panel no-border bg-transparent" data-role="panel">
                                        <p class="panel-header">Personal Information</p>
                                        <div class="panel-content bg-grayLighter">
                                            <p><strong>Date of Birth:</strong> 
                                                <!--Displays date in the format: Saturday, 29 July-->
                                                <?= empty($array['dob']) ? "" : strftime("%A, %#d %B", strtotime($array['dob'])) ?>
                                            </p>
                                            <p><strong>Bio:</strong>
                                                <?php
                                                if (isset($array['bio']) && !empty($array['bio'])) {
                                                    echo $array['bio'];
                                                }
                                                ?>
                                            </p>
                                        </div>                    
                                    </div>
                                    <br/>
                                    <div class="panel no-border bg-transparent" data-role="panel">
                                        <p class="panel-header">Contact Information</p>
                                        <div class="panel-content bg-grayLighter">
                                            <p><strong>Phone:</strong> <?= $array['phone'] ?></p>
                                            <p><strong>Email:</strong> <?= $array['email'] ?></p>
                                            <p><strong>Address 1:</strong> <?= $array['address1'] ?></p>
                                            <p><strong>Address 2:</strong> <?= $array['address2'] ?></p>                    
                                        </div>
                                    </div>
                                    <br/>
                                    <div class="panel no-border bg-transparent" data-role="panel">
                                        <p class="panel-header">Interests/Activities</p>
                                        <div class="panel-content bg-grayLighter">
                                            <p><strong>Interest:</strong> <?= $array['interests'] ?></p>                    
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
            <br/>
            <?php require_once './footer.php'; ?>
        </div>
    </body>
</html>
