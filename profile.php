<?php
require_once './class_lib.php';
$user = new User();

if ($user->isLoggedIn()) {
    /* Page 1: View profile page
     * Page 2: Edit profile page
     * Page 3: View Results page
     * Page 4: View payments page
     * Page 5: View Report a Bug page
     */
    $page = 1;
    $array = array();

    $isEditFormRequest = filter_input(INPUT_POST, "editProfileForm");
    if ($isEditFormRequest) {
        //Handle a post request from form
        $array = filter_input_array(INPUT_POST);
        if ($array !== FALSE || $array !== null) {
            foreach ($array as $key => $value) {
                $array[$key] = html_entity_decode($array[$key]);
            }

            //Validating details
            $error_message = Utility::getInvalidParameters($array);
            $ok = empty($error_message);
        } else {
            $ok = false;
            $error_message = "Oops! Something went wrong, parameters are invalid.";
        }

        //update user
        if ($ok) {
            $success = $user->updateUserInfo($array);
            if (!$success) {
                //update unsuccessful
                $error_message = "Oops! Something went wrong, please try again.";
            }
        } else {
            $success = false;
        }
        $page = $success ? 1 : 2;
    } else {
        $isreportBugRequest = filter_input(INPUT_POST, "reportBugForm");
        if ($isreportBugRequest) {
            //Handle request from "Report a Bug" page
            $array = filter_input_array(INPUT_POST);
            if ($array !== FALSE || $array !== null) {
                foreach ($array as $key => $value) {
                    $array[$key] = html_entity_decode($array[$key]);
                }

                //Validating details
                if (empty(filter_input(INPUT_POST, "subject"))) {
                    $error_message = "Please specify a subject";
                } elseif (empty(filter_input(INPUT_POST, "comment"))) {
                    $error_message = "Please add a description of the bug";
                }

                $ok = empty($error_message);
            } else {
                $ok = false;
                $error_message = "Oops! Something went wrong, parameters are invalid.";
            }

            //Send bug report
            if ($ok) {
                $success = $user->reportBug($array);
                if (!$success) {
                    //Sending failed
                    $error_message = "Oops! Something went wrong, please try again.";
                }
            } else {
                $success = false;
            }
            $page = 5;
        } else {
            //Check if switch request
            $switchRequest = filter_input(INPUT_GET, "p");
            if (!empty($switchRequest)) {
                //switch form
                $page = $switchRequest;
            } else {
                //show page 1 (profile page)
                $page = 1;
            }
        }
    }
} else {
    header("Location: login.php");
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
        <title>NACOSS UNN : <?= $user->getDisplayName() ?></title>        
    </head>
    <body class="metro" style="background-image: url(img/bg.jpg); background-repeat: repeat;">
        <div class="container bg-white">            
            <?php require_once './header.php'; ?>
            <br/>
            <div class="padding20">

                <div class="grid">
                    <div class="row">
                        <div class="span3">
                            <nav class="sidebar">
                                <ul class="">
                                    <li class="<?= $page == 1 || $page == 2 ? "stick bg-NACOSS-UNN" : "" ?>">
                                        <a href="profile.php?p=1">Profile</a>
                                    </li>
                                    <li class="<?= $page == 3 ? "stick bg-NACOSS-UNN" : "" ?>">
                                        <a href="profile.php?p=3">Results</a>
                                    </li>
                                    <li class="<?= $page == 4 ? "stick bg-NACOSS-UNN" : "" ?>">
                                        <a href="profile.php?p=4">Payments</a>
                                    </li>
                                </ul>
                            </nav>
                            <a href="profile.php?p=5">report a bug</a>
                        </div>

                        <div class="span9">
                            <?php if ($user->isUserDeleted()) { ?>
                                <h2>This account no longer exist, please contact site admin if this is an error</h2>
                            <?php } else if ($user->isUserSuspended()) {
                                ?>
                                <h2>This account has been suspended, contact site admin to resolve this</h2>
                                <?php
                            } else {
                                switch ($page) {
                                    case 1:
                                        include_once './profile$1.php';
                                        break;
                                    case 2:
                                        include_once './profile$2.php';
                                        break;
                                    case 3:
                                        include_once './profile$3.php';
                                        break;
                                    case 4:
                                        include_once './profile$4.php';
                                        break;
                                    case 5:
                                        include_once './profile$5.php';
                                        break;
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <br/>
            <?php require_once './footer.php'; ?>
        </div>
    </body>
</html>
