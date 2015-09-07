<?php
require_once 'class_lib.php';
$user = new User();

if ($user->isLoggedIn()) {
    header("location: profile.php");
} else {
    $url = html_entity_decode(filter_input(INPUT_GET, "url"));
    $isFormRequest = filter_input(INPUT_POST, "submit");

    if ($isFormRequest) {
        //Handle a post request from form
        $isRegister = filter_input(INPUT_POST, "type") === "2";
        $url = html_entity_decode(filter_input(INPUT_POST, "url"));
        if ($isRegister) {
            //handle request from registration form
            $showLoginPage = false;

            $array = filter_input_array(INPUT_POST);
            if ($array !== FALSE && $array !== null) {
                foreach ($array as $key => $value) {
                    $array[$key] = html_entity_decode($array[$key]);
                }
                $ok = true;
            } else {
                $ok = false;
                $error_message = "Oops! Something went wrong, parameters are invalid.";
            }
            //register user
            if ($ok) {
                try {
                    $success = $user->
                            registerUser($array['regno'], $array['password1'], $array['password2'], $array['email'], $array['first_name'], $array['last_name'], $array['phone']);
                    if ($success and $user->loginUser($array['regno'], $array['password1'])) {
                        header("location: profile.php");
                    } else {
                        $success = FALSE;
                        $error_message = "Oops! Something went wrong, please try again.";
                    }
                } catch (Exception $exc) {
                    //login unsuccessful
                    $success = FALSE;
                    $error_message = $exc->getMessage();
                }
            } else {
                $success = false;
                $error_message = "No request recieved";
            }
        } else {
            //handle request from login form
            $showLoginPage = true;
            $error_message = "";
            $id = html_entity_decode(filter_input(INPUT_POST, "id"));
            $password = html_entity_decode(filter_input(INPUT_POST, "password"));
            $success = $user->loginUser($id, $password);
            if ($success) {
                if (!empty($url)) {
                    header("location: " . $url);
                } else {
                    header("location: profile.php");
                }
            } else {
                //login unsuccessful
                $error_message = "Wrong ID or password";
            }
        }
    } else {
        //Check if switch request
        $switchRequest = filter_input(INPUT_GET, "s");
        if (!empty($switchRequest)) {
            //switch form
            if ($switchRequest === '1') {
                $showLoginPage = true;
            } else {
                $showLoginPage = false;
            }
        } else {
            $showLoginPage = true;
        }
    }
}

//Handle pssword reset request
$reset = filter_input(INPUT_GET, "reset");
if ($reset) {
    $passwordResetMessage = filter_input(INPUT_GET, "msg");
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

        <script>
            $(function () {
                $(".requestRegnoButton").on('click', function () {
                    $.Dialog({
                        overlay: true,
                        shadow: true,
                        flat: true,
                        icon: '<img src="favicon.ico">',
                        title: 'Forgot Password',
                        content: '<form class="span3" action="reset_password.php" method="GET">' +
                                '<label>Registration Number</label>' +
                                '<div class="input-control text"><input type="text" maxlength="11" required name="regno">' +
                                '<button class = "btn-clear" > </button></div > ' +
                                '<div class="form-actions">' +
                                '<button class="button bg-NACOSS-UNN">Reset Password</button></div>' +
                                '</form>',
                        padding: 10
                    });
                });
            });
        </script>
        <!-- Page Title -->
        <title>NACOSS UNN : <?= $showLoginPage ? "Login" : "Register" ?></title>        
    </head>
    <body class="metro" style="background-image: url(img/bg.jpg); background-repeat: repeat;">
        <div class="container bg-white" id="wrapper">            
            <?php require_once 'header.php'; ?>
            <div class="padding20">
                <?php if (isset($passwordResetMessage)) { ?>
                    <div class="panel bg-amber text-center shadow">
                        <p class="padding5"><?= $passwordResetMessage ?></p>
                    </div>
                <?php } ?>
                <div class="grid fluid">
                    <div class="row">
                        <div class="panel shadow" style="margin-left: auto; margin-right: auto; width: 80%">
                            <h2 class="panel-header bg-grayDark fg-white">
                                <?= $showLoginPage ? "Login" : "Register" ?>
                            </h2>
                            <?php if ($isFormRequest && !$success) { ?>
                                <div class="panel-content">
                                    <p class="fg-red"><?= $error_message ?></p>
                                </div>
                            <?php } ?>
                            <div  class="panel-content">                                
                                <form method='post' action='login.php'>
                                    <input hidden="" name="url" value="<?= empty($url) ? "" : urldecode($url) ?>"/>
                                    <?php if ($showLoginPage) { ?>
                                        <!--Login form-->

                                        <input name="type" value="1" hidden=""/>
                                        <div class="row ntm">
                                            <label class="span3">ID <i title="Registration number" class="icon-help fg-blue"></i></label>
                                            <div class="span9">
                                                <input class="text span12" placeholder="Registration Number" name='id' maxlength="11" required type='text' 
                                                       <?= $isFormRequest ? "value='$id'" : ""; ?> tabindex='1' />
                                            </div>
                                        </div>
                                        <div class="row ntm" >
                                            <label class="span3">Password</label>
                                            <div class="span9">
                                                <input class="password span12" name='password'  type='password' tabindex='2' />
                                            </div>
                                        </div>
                                        <div class="row ntm">
                                            <input class="offset3 button default bg-NACOSS-UNN bg-hover-dark span9" type='submit'
                                                   name='submit' value='Login' tabindex='3'/>                                            
                                        </div>
                                        <div class="row ntm">
                                            <a href="login.php?s=2" class="button small offset3 span4 bg-transparent fg-lightBlue">create account?</a>
                                            <a class="button small requestRegnoButton span4 bg-transparent fg-lightBlue">forgot password?</a>
                                        </div>

                                    <?php } else { ?>
                                        <!--Registration form-->
                                        <input name="type" value="2" hidden=""/>
                                        <div class="row ntm">
                                            <label class="span2">Name<span class="fg-red">*</span></label>
                                            <div class="span10">
                                                <input type='text' required maxlength="30" placeholder="Last name" name='last_name'
                                                       <?= $isFormRequest && isset($array['last_name']) ? "value='" . $array['last_name'] . "'" : ""; ?> tabindex='1' />
                                                <input type='text' required maxlength="30" placeholder="First name" name='first_name'
                                                       <?= $isFormRequest && isset($array['first_name']) ? "value='" . $array['first_name'] . "'" : ""; ?> tabindex='2' />
                                            </div>
                                        </div>
                                        <div class="row ntm" >
                                            <label class="span2">Reg. Number<span class="fg-red">*</span></label>
                                            <div class="span10">
                                                <input name='regno' required style="width: inherit" maxlength="11" type='text' 
                                                       <?= $isFormRequest && isset($array['regno']) ? "value='" . $array['regno'] . "'" : ""; ?>  tabindex='3'  />
                                            </div>
                                        </div>
                                        <div class="row ntm" >
                                            <label class="span2">Password<span class="fg-red">*</span></label>
                                            <div class="span10">
                                                <input class="password" required name='password1' style="width: inherit" type='password' tabindex='4' />
                                                <label class="fg-lime">
                                                    <small>Should be up to 8 characters long and contain both upper and lower cases</small>
                                                </label> 
                                            </div>                                                                                                
                                        </div>
                                        <div class="row ntm" >
                                            <label class="span2">Confirm Password<span class="fg-red">*</span></label>
                                            <div class="span10">
                                                <input class="password" required name='password2' style="width: inherit" type='password' tabindex='5' />
                                            </div>
                                        </div>
                                        <div class="row ntm" >
                                            <label class="span2">Phone<span class="fg-red">*</span></label>
                                            <div class="span10">
                                                <input name='phone' required style="width: inherit" type='tel' 
                                                       <?= $isFormRequest && isset($array['phone']) ? "value='" . $array['phone'] . "'" : ""; ?> tabindex='6'/>
                                            </div>
                                        </div>
                                        <div class="row ntm" >
                                            <label class="span2">Email<span class="fg-red">*</span>
                                            </label>
                                            <div class="span10">
                                                <input name='email' style="width: inherit" required type='email' 
                                                       <?= $isFormRequest && isset($array['email']) ? "value='" . $array['email'] . "'" : ""; ?>  tabindex='7'   />

                                                <label class="fg-lime">
                                                    <small>This will be used for password recovery and account verification</small>
                                                </label> 
                                            </div>
                                        </div>
                                        <div class="row">
                                            <input class="offset2 button default bg-NACOSS-UNN bg-hover-dark span5" type='submit'
                                                   name='submit' value='Register' tabindex='9'/>
                                            <a href="login.php?s=1" class="button span5 bg-transparent fg-lightBlue">already a user?</a>
                                        </div>
                                    <?php } ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <br/>
            <?php require_once 'footer.php'; ?>
        </div>
    </body>
</html>
