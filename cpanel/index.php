<?php
require_once './class_lib.php';
$admin = new Admin();
$isFormRequest = filter_input(INPUT_POST, "submit");
$url = html_entity_decode(filter_input(INPUT_GET, "url"));
if (isset($isFormRequest)) {
    $id = html_entity_decode(filter_input(INPUT_POST, "id"));
    $password = html_entity_decode(filter_input(INPUT_POST, "password"));
    $url = html_entity_decode(filter_input(INPUT_POST, "url"));

    //Login
    try {
        $success = $admin->loginAdmin($id, $password);
        if ($success) {
            if (!empty($url)) {
                header("location: " . $url);
            } else {
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
    if (!empty($url)) {
        header("location: " . urldecode($url));
    } else {
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
}

//Handle pssword reset request
$reset = filter_input(INPUT_GET, "reset");
if ($reset) {
    $passwordResetMessage = html_entity_decode(filter_input(INPUT_GET, "msg"));
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
        <title>CPanel</title>      
        <script>
            $(function () {
                $(".requestIDButton").on('click', function () {
                    $.Dialog({
                        overlay: true,
                        shadow: true,
                        flat: true,
                        icon: '<img src="../favicon.ico">',
                        title: 'Forgot Password',
                        content: '<form class="span3" action="reset_password.php" method="GET">' +
                                '<label>Enter ID</label>' +
                                '<div class="input-control text"><input type="text" required name="id">' +
                                '<button class = "btn-clear" > </button></div > ' +
                                '<div class="form-actions">' +
                                '<button class="button bg-NACOSS-UNN">Reset Password</button></div>' +
                                '</form>',
                        padding: 10
                    });
                });
            });
        </script>
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
                    <?php if (isset($passwordResetMessage)) { ?>
                        <div class="panel bg-amber text-center shadow">
                            <p class="padding5"><?= $passwordResetMessage ?></p>
                        </div>
                    <?php } ?>
                    <br/>
                    <div style="margin-left: auto; margin-right: auto;" class="span6 panel shadow">
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
                                    <input hidden="" name="url" value="<?= empty($url) ? "" : urldecode($url) ?>"/>
                                    <div class="row ntm">
                                        <label class="span1">ID</label>
                                        <div class="span4">
                                            <input class="text" name='id' style="width: inherit" required type='text' 
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
                                        <a class="button small span4 bg-transparent fg-lightBlue requestIDButton"> &nbsp;&nbsp;forgot password?</a>
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
                    <br/>
                    <br/>
                </div>
                <br/>
                <?php require_once './footer.php'; ?>
            </div>
        </div>
    </body>
</html>

