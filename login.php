<?php
require_once './class_lib.php';
$user = new User();

if ($user->isLoggedIn()) {
    header("location: profile.php");
} else {
    $isFormRequest = filter_input(INPUT_POST, "submit");

    if ($isFormRequest) {
        //Handle a post request from form
        $isRegister = filter_input(INPUT_POST, "type") === "2";
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
                header("location: profile.php");
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

        <script>
            $(function () {
                $("#carousel").carousel({
                    period: 10000,
                    duration: 2500,
                    effect: 'fade',
                    height: 400,
                    markers: {
                        show: false
                    }
                });
            });
        </script>

        <!-- Page Title -->
        <title>NACOSS UNN : <?= $showLoginPage ? "Login" : "Register" ?></title>        
    </head>
    <body class="metro" style="background-image: url(img/bg.jpg); background-repeat: repeat;">
        <div class="container bg-white">            
            <?php require_once './header.php'; ?>
            <br/>

            <div class="padding20">
                <div class="grid">
                    <div class="row">

                        <!--Tablet or Desktop view-->
                        <div class="no-phone no-tablet on-desktop span7">
                            <div class="bg-dark" style="height: 400px">
                                <div class="carousel">
                                    <div class="bg-transparent no-overflow" id="carousel">
                                        <div class="slide" style="background: url(img/b1.jpg) top left no-repeat; background-size: cover; height: 400px;">
                                            <div class="container" style="padding: 200px 50px">
                                                <div class="panel span5 no-border text-center" style="background-color: rgba(0,0,0,0.35)">
                                                    <div class="panel-content">
                                                        <h2 class="fg-white text-left">Scientists with a difference</h2>
                                                        <a href="<?= NDG_HOMEPAGE ?>" target="_blank" 
                                                           class="button large bg-lightOlive bg-hover-dark fg-white">join NDG today</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="slide" style="background: url(img/b2.jpg) top left no-repeat; background-size: cover; height: 400px;">
                                            <div class="container" style="padding: 250px 50px">
                                                <div class="panel span5 no-border text-center" style="background-color: rgba(0,0,0,0.35)">
                                                    <div class="panel-content">
                                                        <h2 class="fg-white text-left">NACOSS</h2>
                                                        <h4 class="fg-white text-left">...networking the world.</h4>
                                                        <br/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="span7 panel shadow">
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
                                    <?php if ($showLoginPage) { ?>
                                        <!--Login form-->
                                        <div class="grid">
                                            <input name="type" value="1" hidden=""/>
                                            <div class="row ntm">
                                                <label class="span1">ID <i title="Registration number" class="icon-help fg-blue"></i></label>
                                                <div class="span4">
                                                    <input class="text" name='id' maxlength="11" style="width: inherit" required type='text' 
                                                           <?= $isFormRequest ? "value='$id'" : ""; ?> tabindex='1' />
                                                </div>
                                            </div>
                                            <div class="row" >
                                                <label class="span1">Password</label>
                                                <div class="span4">
                                                    <input class="password" name='password' style="width: inherit" type='password' tabindex='2' />
                                                </div>
                                            </div>
                                            <div class="no-phone" style="padding-left: 80px">
                                                <input class="button default bg-NACOSS-UNN bg-hover-dark" style="width: 300px" type='submit'
                                                       name='submit' value='Login' tabindex='3'/>
                                                <br/>
                                                <a href="login.php?s=2" class=""> &nbsp;&nbsp;create account?</a>
                                                <a href="reset_password.php" class=""> &nbsp;&nbsp;forgot password?</a>
                                            </div>
                                            <div class="on-phone no-tablet no-desktop padding20 ntp nbp">
                                                <input class="button default bg-NACOSS-UNN bg-hover-dark" type='submit'
                                                       name='submit' value='Login' tabindex='3'/>
                                                <br/>
                                                <a href="login.php?s=2" class="">create account?</a>
                                                <a href="reset_password.php" class=""> &nbsp;&nbsp;forgot password?</a>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <!--Registration form-->
                                        <div class="grid">
                                            <input name="type" value="2" hidden=""/>
                                            <div class="row ntm">
                                                <label class="span2">Name<span class="fg-red">*</span></label>
                                                <div class="span4">
                                                    <input type='text' required maxlength="30" placeholder="Last name" name='last_name'
                                                           <?= $isFormRequest && isset($array['last_name']) ? "value='" . $array['last_name'] . "'" : ""; ?> tabindex='1' />
                                                    <input type='text' required maxlength="30" placeholder="First name" name='first_name'
                                                           <?= $isFormRequest && isset($array['first_name']) ? "value='" . $array['first_name'] . "'" : ""; ?> tabindex='2' />
                                                </div>
                                            </div>
                                            <div class="row" >
                                                <label class="span2">Reg. Number<span class="fg-red">*</span></label>
                                                <div class="span4">
                                                    <input name='regno' required style="width: inherit" maxlength="11" type='text' 
                                                           <?= $isFormRequest && isset($array['regno']) ? "value='" . $array['regno'] . "'" : ""; ?>  tabindex='3'  />
                                                </div>
                                            </div>
                                            <div class="row" >
                                                <label class="span2">Password<span class="fg-red">*</span></label>
                                                <div class="span4">
                                                    <input class="password" required name='password1' style="width: inherit" type='password' tabindex='4' />
                                                    <label class="fg-lime">
                                                        <small>Should be up to 8 characters long and contain both upper and lower cases</small>
                                                    </label> 
                                                </div>                                                                                                
                                            </div>
                                            <div class="row" >
                                                <label class="span2">Confirm Password<span class="fg-red">*</span></label>
                                                <div class="span4">
                                                    <input class="password" required name='password2' style="width: inherit" type='password' tabindex='5' />
                                                </div>
                                            </div>
                                            <div class="row" >
                                                <label class="span2">Phone<span class="fg-red">*</span></label>
                                                <div class="span4">
                                                    <input name='phone' required style="width: inherit" type='tel' 
                                                           <?= $isFormRequest && isset($array['phone']) ? "value='" . $array['phone'] . "'" : ""; ?> tabindex='6'/>
                                                </div>
                                            </div>
                                            <div class="row" >
                                                <label class="span2">Email<span class="fg-red">*</span>
                                                </label>
                                                <div class="span4">
                                                    <input name='email' style="width: inherit" required type='email' 
                                                           <?= $isFormRequest && isset($array['email']) ? "value='" . $array['email'] . "'" : ""; ?>  tabindex='7'   />

                                                    <label class="fg-lime">
                                                        <small>This will be used for password recovery and account verification</small>
                                                    </label> 
                                                </div>
                                            </div>
                                            <div class="no-phone offset2">
                                                <input class="button default bg-NACOSS-UNN bg-hover-dark" type='submit'
                                                       name='submit' value='Register' tabindex='9'/>
                                                <a href="login.php?s=1" class=""> &nbsp;&nbsp;already a user?</a>
                                            </div>
                                            <div class="on-phone no-tablet no-desktop padding20 ntp nbp">
                                                <input class="button default bg-NACOSS-UNN bg-hover-dark" type='submit'
                                                       name='submit' value='Register' tabindex='9'/>
                                                <a href="login.php?s=1" class=""> &nbsp;&nbsp;already a user?</a>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <br/>
            <?php require_once './footer.php'; ?>
        </div>
    </body>
</html>
