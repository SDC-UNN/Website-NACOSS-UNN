<?php
require_once 'class_lib.php';
$user = new User();

if ($user->isLoggedIn()) {
    /* Page 1: View profile page
     * Page 2: Edit profile page
     * Page 3: View Results page
     * Page 4: View payments page
     * Page 5: View Report a Bug page
     * Page 6: Change password page
     */
    $page = 1;

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

    if (isset($array["editProfileForm"])) {
        //Handle a post request from form
        //Validating details and update user
        try {
            $user->updateUserInfo($array);
            $success = true;
            $error_message = "";
        } catch (Exception $exc) {
            $success = false;
            $error_message = $exc->getMessage();
        }

        $page = $success ? 1 : 2;
    } elseif (isset($array["reportBugForm"])) {
        //Further processing will be handled in "Report Bug" page
        $page = 5;
    } elseif (isset($array["changePasswordForm"])) {
        //Handle request from "Change Password" page
        //Validating details and change password
        try {
            $success = $user->changePassword($array['password'], $array['password1'], $array['password2']);
            if (!$success) {
                //Updates failed
                $error_message = "Oops! Something went wrong, please try again.";
            }
        } catch (Exception $exc) {
            $success = false;
            $error_message = $exc->getMessage();
        }
        $page = 6;
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
        <?php require_once 'default_head_tags.php'; ?>

        <!-- Page Title -->
        <title>NACOSS UNN : <?= $user->getDisplayName() ?></title>        
    </head>
    <body class="metro" style="background-image: url(img/bg.jpg); background-repeat: repeat;">
        <div class="container bg-white" id="wrapper">            
            <?php require_once './header.php'; ?>
            <div class="padding20">
                <div class="grid fluid">
                    <div class="row">
                        <div class="span4">
                            <nav class="sidebar">
                                <ul class="">
                                    <li class="<?= $page == 1 || $page == 2 ? "stick bg-NACOSS-UNN" : "" ?>">
                                        <a class="dropdown-toggle" href="#">Profile</a>
                                        <ul class="dropdown-menu" data-role="dropdown">
                                            <li><a href="profile.php?p=1">View Profile</a></li>
                                            <li><a href="profile.php?p=2">Edit Profile</a></li>
                                            <li><a href="profile.php?p=6">Change Password</a></li>
                                            <li><a href="logout.php?url=<?= urlencode($_SERVER["PHP_SELF"]) ?>">Logout</a></li>
                                        </ul>
                                    </li>

                                    <li class="<?= $page == 3 ? "stick bg-NACOSS-UNN" : "" ?>">
                                        <a href="profile.php?p=3">Results</a>
                                    </li>
                                    <li class="<?= $page == 4 ? "stick bg-NACOSS-UNN" : "" ?>">
                                        <a href="profile.php?p=4">Payments</a>
                                    </li>
                                    <?php if (isClassRep($user->getUserID())) {
                                        ?>
                                        <li class="bg-NACOSS-UNN">
                                            <a href="<?= CPANEL_URL ?>" target="_blank">Class Room</a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </nav>
                            <a href="profile.php?p=5">report a bug</a>
                        </div>

                        <div class="span8">
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
                                    case 6:
                                        include_once './profile$6.php';
                                        break;
                                }
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
