<?php
require_once('../class_lib.php');
require_once('StudentAdmin.php');
require_once('functions.php');

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
                    $subvalue[$subkey] = html_entity_decode($subvalue[$subkey]);
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
    $url = urlencode(CPANEL_URL . "class_rep/?p=" . $page);
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
        <div class="bg-white">            
            <?php require_once '../header.php'; ?>
            <div class="padding20">
                <h2>CLASS REP.</h2>
                <div class="grid fluid">
                    <div class="row">
                        <div class="span3">
                            <nav class="sidebar light">
                                <ul class="">
                                    <li class="<?= $page == 1 ? "stick bg-darkBlue" : "" ?>">
                                        <a href="index.php?p=1"><i class="icon-clipboard-2"></i>Class List</a>
                                    </li>
                                    <li class="<?= $page == 2 || ($page >= 21 and $page <= 25) ? "stick bg-darkBlue " : "" ?>">
                                        <a class="dropdown-toggle" href="#"><i class="icon-broadcast"></i>Messenger</a>
                                        <ul class="dropdown-menu" data-role="dropdown">
                                            <li><a href="index.php?p=2">Compose Message</a></li>
                                            <li><a href="index.php?p=22">Contacts/Group</a></li>
                                            <li><a href="index.php?p=24">Message Logs</a></li>
                                            <li><a href="index.php?p=25">Status</a></li>
                                        </ul>
                                    </li>
                                    <li class="<?= $page == 3 ? "stick bg-darkBlue" : "" ?>">
                                        <a href="index.php?p=3"><i class="icon-tools"></i>Settings</a>
                                    </li>
                                </ul>
                                <br/>
                                <div class="panel no-border">
                                    <div class="panel-header">Statistics</div>
                                    <div class="panel-content">
                                        <p>Number in Class</p>
                                        <p><?= getNumberOfStudents($admin->getField("level")) ?></p>
                                        <p>Males</p>
                                        <p><?= getNumberOfStudents($admin->getField("level"), "M") ?></p>
                                        <p>Females</p>
                                        <p><?= getNumberOfStudents($admin->getField("level"), "F") ?></p>
                                    </div>
                                </div>
                            </nav>
                        </div>

                        <div class="span9">
                            <?php
                            switch ($page) {
                                case 1: require_once '_class_list.php';
                                    break;
                                case 2: require_once '_messenger_new_sms.php';
                                    break;
                                case 21: require_once '_messenger_new_mail.php';
                                    break;
                                case 22: require_once '_messenger_contacts_all.php';
                                    break;
                                case 23: require_once '_messenger_contacts_groups.php';
                                    break;
                                case 24: require_once '_messenger_logs.php';
                                    break;
                                case 25: require_once '_messenger_status.php';
                                    break;
                                case 26: require_once '_messenger_select_recipients.php';
                                    break;
                                case 3: require_once '_settings.php';
                                    break;
                                default : require_once '_class_list.php';
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
    </body>
</html>
