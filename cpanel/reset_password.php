<?php

/*
 * Copyright 2015 NACOSS UNN Developers Group (NDG).
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

require_once 'class_lib.php';
require_once '../functions.php';

$id = filter_input(INPUT_GET, "id");
$code = filter_input(INPUT_GET, "c");
$link = AdminUtility::getDefaultDBConnection();
if (empty($code)) {
    //generate code, mail code to admin then redirect to cpanel/index.php to notify admin of "mail"
    //Get email
    $query = "select email from admins where username = '$id'";
    $result = mysqli_query($link, $query);
    if ($result) {
        //Generate code
        $row = mysqli_fetch_array($result);
        $code = uniqid();
        $email = $row["email"];
        $query = "insert into password_reset set "
                . "username = '$id', "
                . "code='$code' "
                . "on duplicate key update "
                . "code='$code', "
                . "time_of_request=now()";
        $result = mysqli_query($link, $query);
        if ($result) {
            //Mail
            $link = $_SERVER["HTTP_HOST"] . "/" . $_SERVER["PHP_SELF"] . "?c=$code&id=$id";
            $subject = "Password Reset";
            $emailContent = "A request was made to reset your password<br/>"
                    . "Click on this link to proceed $link<br/>"
                    . "<br/>"
                    . "Simple ignore this message if the request was not from you.";
            $sent = sendMail($email, $subject, $emailContent);
        } else {
            $sent = false;
        }
    } else {
        $sent = false;
    }
    //Redirect with message
    $msg = $sent ? "A mail was sent to $email" : "Oops! Something went wrong<br>Password reset failed";
    header("location: " . CPANEL_URL . "?reset=true&msg=" . urldecode($msg));
} else {
    //check time_of_request and code then reset password, mail it back to user,
    //and redirect to cpanel/index.php to notify user of "reset" 
    $query = "select email from admins where username = '$id'";
    $result = mysqli_query($link, $query);
    if ($result) {
        $row = mysqli_fetch_array($result);
        $email = $row["email"];
        $query = "select * from password_reset where username = '$id' and code='$code'";
        $result = mysqli_query($link, $query);
        if ($result) {
            $row = mysqli_fetch_array($result);
            if (!empty($row)) {
                $time = strtotime($row["time_of_request"]);
                if ((time() - $time) < (60 * 60 * 24)) { //Difference between current time and time_of_request is less than a day
                    //Generate random 8 character password
                    $u_pass = uniqid();
                    $pass = str_split($u_pass, 8)[0];
                    //Change Password
                    resetAdminPassword($id, $pass);
                    //Mail
                    $subject = "Password Changed";
                    $emailContent = "Your password has been changed."
                            . "<br/><br/>"
                            . "ID: $id<br/>"
                            . "Password: $pass<br/>";
                    $sent = sendMail($email, $subject, $emailContent);
                    if ($sent) {
                        $msg = "Password has been sent to $email";
                        $query = "delete from password_reset where username = '$id' and code='$code'";
                        mysqli_query($link, $query);
                    } else {
                        $msg = "Oops! Something went wrong<br/>We were unable to send a mail to $email. Please try again";
                    }
                } else {
                    $msg = "Link has expired";
                    $query = "delete from password_reset where username = '$id' and code='$code'";
                    mysqli_query($link, $query);
                }
            } else {
                $msg = "Invalid link";
            }
        } else {
            $msg = "Invalid link";
        }
    }
    //Redirect with meassage
    header("location: " . CPANEL_URL . "?reset=true&msg=" . urldecode($msg));
}