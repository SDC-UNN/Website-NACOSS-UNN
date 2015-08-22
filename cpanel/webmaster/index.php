<?php
require_once '../class_lib.php';
require_once 'WebsiteAdmin.php';
require_once './functions.php';

$admin = new WebsiteAdmin();
if ($admin->activateLogin()) {
    //Redirect to appropriate page if not webmaster
    switch ($admin->getAdminType()) {
        case Admin::WEBMASTER:
            //Do nothing
            break;
        case Admin::LIBRARIAN:
            header("location: ../librarian");
            break;
        case Admin::TREASURER:
            header("location: ../treasurer");
            break;
        case Admin::PRO:
            header("location: ../pro");
            break;
        case Admin::CLASS_REP:
            header("location: ../class_rep");
            break;
        default:
            $admin->logoutAdmin();
            break;
    }

    //Set page number
    $page = filter_input(INPUT_GET, "p");
    if (empty($page)) {
        $page = 1;
    }

    //Check for post request
    $array = filter_input_array(INPUT_POST);
    if ($array !== FALSE && $array !== null) {
        foreach ($array as $key => $value) {
            if (is_array($array[$key])) {
                foreach ($array[$key] as $subkey => $subvalue) {
//                    $subvalue[$subkey] = html_entity_decode($subvalue[$subkey]);
                    $array[$key][$subkey] = html_entity_decode($array[$key][$subkey]);
                }
            } else {
                $array[$key] = html_entity_decode($array[$key]);
            }
        }
        //Further processing is done in the page to which the request was directed to
    }
} else {
    //Set page number
    $page = filter_input(INPUT_GET, "p");
    if (empty($page)) {
        $page = 1;
    }
    $url = urlencode(CPANEL_URL . "webmaster/?p=" . $page);
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
                    <h2>Web Master</h2>
                    <div class="grid">
                        <div class="row">
                            <div class="span3">
                                <nav class="sidebar light">
                                    <ul class="">
                                        <li class="<?= $page == 1 || $page == 11 || $page == 12 ? "stick bg-darkBlue" : "" ?>">
                                            <a href="?p=1">Users</a>
                                        </li>
                                        <li class="<?= $page == 2 ? "stick bg-darkBlue" : "" ?>">
                                            <a href="?p=2">Class Representatives</a>
                                        </li>
                                        <li class="<?= $page == 3 ? "stick bg-darkBlue" : "" ?>">
                                            <a href="?p=3">Results</a>
                                        </li>
                                        <li class="<?= $page == 5 ? "stick bg-darkBlue" : "" ?>">
                                            <?php
                                            $numberOfUnseenErrorReports = getNumberOfUnseenErrorReports();
                                            if ($numberOfUnseenErrorReports > 0) {
                                                ?>
                                                <a href="?p=5">Error Reports 
                                                    <small class="bg-red fg-white" style="padding: 2px">
                                                        <?= $numberOfUnseenErrorReports ?>
                                                    </small>
                                                </a>
                                                <?php
                                            } else {
                                                ?>
                                                <a href="?p=5">Error Reports</a>
                                                <?php
                                            }
                                            ?>
                                        </li>
                                        <li class="<?= $page == 6 ? "stick bg-darkBlue" : "" ?>">
                                            <?php
                                            $numberOfUnfixedError = getNumberOfUnfixedError();
                                            if ($numberOfUnfixedError > 0) {
                                                ?>
                                                <a href="?p=6">Log 
                                                    <small class="bg-red fg-white" style="padding: 2px">
                                                        <?= $numberOfUnfixedError ?>
                                                    </small>
                                                </a>
                                                <?php
                                            } else {
                                                ?>
                                                <a href="?p=6">Log</a>
                                                <?php
                                            }
                                            ?>
                                        </li>
                                        <li class="<?= $page == 7 || $page == 71 ? "stick bg-darkBlue" : "" ?>">
                                            <a href="?p=7">Settings</a>
                                        </li>
                                    </ul>
                                    <br/>
                                    <div class="panel no-border">
                                        <div class="panel-header">Statistics</div>
                                        <div class="panel-content">
                                            <p>Active Users</p>
                                            <p><?= getNumberOfActiveUsers() ?></p>
                                            <p>Suspended Users</p>
                                            <p><?= getNumberOfSuspendedUsers() ?></p>
                                            <p>Deleted Users</p>
                                            <p><?= getNumberOfDeletedUsers() ?></p>                                        
                                        </div>
                                    </div>
                                </nav>
                            </div>

                            <div class="span12">
                                <?php
                                switch ($page) {
                                    case 1:
                                        include_once './users.php';
                                        break;
                                    case 11:
                                        include_once './users$1.php';
                                        break;
                                    case 12:
                                        include_once './users$2.php';
                                        break;
                                    case 13:
                                        include_once '../user_profile.php';
                                        break;
                                    case 2:
                                        include_once './classreps.php';
                                        break;
                                    case 3:
                                        include_once './results.php';
                                        break;
                                    case 5:
                                        include_once './error_reports.php';
                                        break;
                                    case 6:
                                        include_once './error_logs.php';
                                        break;
                                    case 7:
                                        include_once './settings.php';
                                        break;
                                    case 71:
                                        include_once './settings$1.php';
                                        break;
                                    default :
                                        include_once './users.php';
                                        break;
                                }
                                ?>
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
