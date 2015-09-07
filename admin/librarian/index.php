<?php
require_once '../class_lib.php';
require_once 'LibraryAdmin.php';
require_once './functions.php';

$admin = new LibraryAdmin();
if ($admin->activateLogin()) {
    //Redirect to appropriate page if not Librarian or webmaster
    switch ($admin->getAdminType()) {
        case Admin::WEBMASTER:
        case Admin::LIBRARIAN:
            //Do not
            break;
        case Admin::PRO:
            header("location: ../pro");
            break;
        case Admin::TREASURER:
            header("location: ../treasurer");
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
    $url = urlencode(CPANEL_URL . "librarian/?p=" . $page);
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
            <div class=" bg-white">            
                <?php require_once '../header.php'; ?>
                <div class="padding20">
                    <h2>Librarian</h2>
                    <div class="grid fluid">
                        <div class="row">
                            <div class="span3">
                                <nav class="sidebar light">
                                    <ul class="">
                                        <li class="<?= $page == 1 ? "stick bg-darkBlue active" : "" ?>">
                                            <a href="?p=1"><i class="icon-book"></i>View Ebooks</a>
                                        </li>
                                        <li class="<?= $page == 2 ? "stick bg-darkBlue active" : "" ?>">
                                            <a href="?p=2"><i class="icon-image"></i>Video Gallery</a>
                                        </li>
                                        <li class="<?= $page == 3 ? "stick bg-darkBlue active" : "" ?>">
                                            <a href="?p=3"><i class="icon-new"></i>New Library Entry</a>
                                        </li>
                                        <li class="<?= $page == 4 || $page == 41 ? "stick bg-darkBlue active" : "" ?>">
                                            <a href="?p=4"><i class="icon-tools"></i>Settings</a>
                                        </li>
                                    </ul>
                                    <br/>
                                    <div class="panel no-border">
                                        <div class="panel-header">Statistics</div>
                                        <div class="panel-content">
                                            <p>Total Books</p>
                                            <p><?= getNumberOfLibraryItems('ebook'); ?></p>
                                            <p>Total Videos</p> 
                                            <p><?= getNumberOfLibraryItems('video'); ?></p>
                                            <p>Total Video Downloads</p>
                                            <p><?= getNumberOfLibraryItemsDownloaded('video'); ?></p>                                          
                                            <p>Total Books Downloads</p>
                                            <p><?= getNumberOfLibraryItemsDownloaded('ebook'); ?></p>                                          
                                        </div>
                                    </div>
                                </nav>
                            </div>

                            <div class="span9">
                                <?php
                                switch ($page) {
                                    case 1:
                                        include_once('_viewEbooks.php');
                                        break;
                                    case 2:
                                        include_once('_viewVideos.php');
                                        break;
                                    case 3:
                                        include_once('_newItem.php');
                                        break;
                                    case 4:
                                        include_once('_settings.php');
                                        break;
                                    case 41:
                                        include_once('_settings_changePassword.php');
                                        break;
                                    default :
                                        include_once('_viewEbooks.php');
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
