<?php
require_once '../class_lib.php';
require_once './TreasurerAdmin.php';
require_once './functions.php';

$admin = new StudentAdmin();
if ($admin->activateLogin()) {
    //Redirect to appropriate page if not ClassRep
    switch ($admin->getAdminType()) {
        case Admin::TREASURER:
            //Do nothing
            break;
        case Admin::CLASS_REP:
            header("location: ../class_rep");
            break;
        case Admin::WEBMASTER:
            header("location: ../webmaster");
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

    //Set page number
    $page = filter_input(INPUT_GET, "p");
    if (empty($page)) {
        $page = 1;
    }
    $url = urlencode(CPANEL_URL . "treasurer/?p=" . $page);
    header("location: ../index.php?url=" . $url);
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
        <?php require_once '../default_head_tags.php'; ?>

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
                                            <a href="#">Payments</a>
                                        </li>
                                        <li class="">
                                            <a href="#">Print List</a>
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

                            <div class="span9">

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
