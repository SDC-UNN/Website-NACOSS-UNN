<?php
require_once '../class_lib.php';
require_once 'StudentAdmin.php';
require_once './functions.php';

$admin = new StudentAdmin();
if ($admin->activateLogin()) {
    //Redirect to appropriate page if not ClassRep
    switch ($admin->getAdminType()) {
        case Admin::CLASS_REP:
            //Do nothing
            break;
        case Admin::WEBMASTER:
            header("location: ../webmaster");
            break;
        case Admin::TREASURER:
            header("location: ../treasurer");
            break;
        case Admin::LIBRARIAN:
            header("location: ../librarian");
            break;
        case Admin::CLASS_REP:
            header("location: ../class_rep");
            break;
        default:
            $admin->logoutAdmin();
            break;
    }
} else {
    header("location: ../index.php");
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
        <link rel="icon" href="<?= HOSTNAME ?>favicon.ico" type="image/x-icon" />
        <link rel="shortcut icon" href="<?= HOSTNAME ?>favicon.ico" type="image/x-icon" />

        <link href="<?=HOSTNAME?>css/metro-bootstrap.css" rel="stylesheet">
        <link href="<?=HOSTNAME?>css/metro-bootstrap-responsive.css" rel="stylesheet">
        <link href="<?=HOSTNAME?>css/iconFont.css" rel="stylesheet">
        <link href="<?=HOSTNAME?>js/prettify/prettify.css" rel="stylesheet">

        <script src="<?=HOSTNAME?>js/metro/metro.min.js"></script>

        <!-- Load JavaScript Libraries -->
        <script src="<?=HOSTNAME?>js/jquery/jquery.min.js"></script>
        <script src="<?=HOSTNAME?>js/jquery/jquery.widget.min.js"></script>
        <script src="<?=HOSTNAME?>js/jquery/jquery.mousewheel.js"></script>
        <script src="<?=HOSTNAME?>js/prettify/prettify.js"></script>

        <!-- Metro UI CSS JavaScript plugins -->
        <script src="<?=HOSTNAME?>js/metro.min.js"></script>

        <!-- Local JavaScript -->
        <script src="<?=HOSTNAME?>js/docs.js"></script>
        <script src="<?=HOSTNAME?>js/github.info.js"></script>

        <!-- Page Title -->
        <title>CPanel</title>        
    </head>
    <body class="metro">
        <div class="">
            <div class="bg-white">            
                <?php require_once '../header.php'; ?>
                <div class="padding20">
                    <h2>Class Representatives</h2>
                    <div class="grid">
                        <div class="row">
                            <div class="span3">
                                <nav class="sidebar light">
                                    <ul class="">
                                        <li class="">
                                            <a href="#">Add New Results</a>
                                        </li>
                                        <li class="">
                                            <a href="#">All Results</a>
                                        </li>
                                        <li class="">
                                            <a href="#">Settings</a>
                                        </li>
                                    </ul>
                                    <br/>
                                    <div class="panel no-border">
                                        <div class="panel-header">Statistics</div>
                                        <div class="panel-content">
                                            
                                        </div>
                                    </div>
                                </nav>
                            </div>

                            <div class="span12">

                            </div>
                        </div>
                    </div>

                </div>
                <br/>
                <?php require_once '../footer.php'; ?>
            </div>
        </div>
    </body>
</html>
