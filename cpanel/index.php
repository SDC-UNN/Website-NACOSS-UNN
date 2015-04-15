<?php
require_once './class_lib.php';

$admin = new Admin();
$isFormRequest = filter_input(INPUT_POST, "submit");
if (isset($isFormRequest)) {
    $type = html_entity_decode(filter_input(INPUT_POST, "admin_type"));
    $id = html_entity_decode(filter_input(INPUT_POST, "id"));
    $password = html_entity_decode(filter_input(INPUT_POST, "password"));

    //Login
    try {
        $success = $admin->loginAdmin($id, $password, $type);
        if ($success) {
            switch ($type) {
                case Admin::WEBMASTER:
                    header("location: webmaster/");
                    break;
                case Admin::TREASURER:
                    header("location: treasurer/");
                    break;
                case Admin::PRO:
                    header("location: pro/");
                    break;
                case Admin::LIBRARIAN:
                    header("location: librarian/");
                    break;
                case Admin::CLASS_REP:
                    header("location: class_rep/");
                    break;
                default:
                    $admin->logoutAdmin();
                    break;
            }
        } else {
            $error_message = "Error occurred while trying to login, please try again";
        }
    } catch (Exception $exc) {
        $success = false;
        $error_message = $exc->getMessage();
    }
}

if ($admin->isLoggedIn()) {
//If session still active
    switch ($admin->getAdminType()) {
        case Admin::WEBMASTER:
            header("location: webmaster/");
            break;
        case Admin::TREASURER:
            header("location: treasurer/");
            break;
        case Admin::PRO:
            header("location: pro/");
            break;
        case Admin::LIBRARIAN:
            header("location: librarian/");
            break;
        case Admin::CLASS_REP:
            header("location: class_rep/");
            break;
        default:
            $admin->logoutAdmin();
            break;
    }
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
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

        <link href="../css/metro-bootstrap.css" rel="stylesheet">
        <link href="../css/metro-bootstrap-responsive.css" rel="stylesheet">
        <link href="../css/iconFont.css" rel="stylesheet">
        <link href="../js/prettify/prettify.css" rel="stylesheet">

        <script src="../js/metro/metro.min.js"></script>

        <!-- Load JavaScript Libraries -->
        <script src="../js/jquery/jquery.min.js"></script>
        <script src="../js/jquery/jquery.widget.min.js"></script>
        <script src="../js/jquery/jquery.mousewheel.js"></script>
        <script src="../js/prettify/prettify.js"></script>

        <!-- Metro UI CSS JavaScript plugins -->
        <script src="../js/metro.min.js"></script>

        <!-- Local JavaScript -->
        <script src="../js/docs.js"></script>
        <script src="../js/github.info.js"></script>

        <!-- Page Title -->
        <title>CPanel</title>      

    </head>
    <body class="metro">
        <div class="">
            <div class="bg-white">            
                <?php require_once './header.php'; ?>
                <div class="padding20 row">
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <div class="offset5 span6 panel shadow">
                        <h2 class="panel-header bg-grayDark fg-white">
                            NACOSS UNN CPanel
                        </h2>
                        <?php if ($isFormRequest && !$success) { ?>
                            <div class="panel-content">
                                <p class="fg-red"><?= $error_message ?></p>
                            </div>
                        <?php } ?>
                        <div  class="panel-content">                                
                            <form method='post' action='index.php'>
                                <!--Login form-->
                                <div class="grid">
                                    <div class="text-center">
                                        <input type="radio" <?= isset($type) ? ($type === Admin::WEBMASTER ? "checked" : "") : "checked" ?> name="admin_type" required value="<?= Admin::WEBMASTER ?>" /> Web Master&nbsp;
                                        <input type="radio" <?= isset($type) ? ($type === Admin::CLASS_REP ? "checked" : "") : "" ?> name="admin_type" required value="<?= Admin::TREASURER ?>"/> Treasurer&nbsp;
                                        <input type="radio" <?= isset($type) ? ($type === Admin::PRO ? "checked" : "") : "" ?> name="admin_type" required value="<?= Admin::PRO ?>"/> PRO &nbsp;
                                        <input type="radio" <?= isset($type) ? ($type === Admin::LIBRARIAN ? "checked" : "") : "" ?> name="admin_type" required value="<?= Admin::LIBRARIAN ?>"/> Librarian&nbsp;
                                        <input type="radio" <?= isset($type) ? ($type === Admin::CLASS_REP ? "checked" : "") : "" ?> name="admin_type" required value="<?= Admin::CLASS_REP ?>"/> Class Rep.
                                    </div>
                                    <br/>
                                    <div class="row ntm">
                                        <label class="span1">ID</label>
                                        <div class="span4">
                                            <input class="text" name='id' maxlength="11" style="width: inherit" required type='text' 
                                                   <?= $isFormRequest ? "value='$id'" : ""; ?> tabindex='1' />
                                        </div>
                                    </div>
                                    <div class="row" >
                                        <label class="span1">Password</label>
                                        <div class="span4">
                                            <input class="password" required name='password' style="width: inherit" type='password' tabindex='2' />
                                        </div>
                                    </div>
                                    <div class="no-phone" style="padding-left: 80px">
                                        <input class="button default bg-NACOSS-UNN bg-hover-dark" style="width: 300px" type='submit'
                                               name='submit' value='Login' tabindex='3'/>
                                        <br/>
                                        <a href="resetPassword.php" class=""> &nbsp;&nbsp;forgot password?</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>                    
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                    <br/>
                </div>
                <br/>
                <?php require_once './footer.php'; ?>
            </div>
        </div>
    </body>
</html>

