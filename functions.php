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

function sendMail($email, $subject, $msg) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $header = "From: NACOSS UNN\r\n"
                . "Content-type: text/html\r\n"
                . "X-Mailer: PHP/" . phpversion();
        return mail($email, $subject, getMessage($msg), $header);
    } else {
        return false;
    }
}

function getMessage($content) {
    return "<html>
        <head>
            <meta charset='utf-8'>
            <meta name='description' content='NACOSS UNN official website'>
            <meta name='author' content='NDG'>
            
            <link href='" . HOSTNAME . "css/metro-bootstrap.css' rel='stylesheet'>
            <link href='" . HOSTNAME . "css/metro-bootstrap-responsive.css' rel='stylesheet'>
            <link href='" . HOSTNAME . "css/iconFont.css' rel='stylesheet'>
            <link href='" . HOSTNAME . "js/prettify/prettify.css' rel='stylesheet'>

            <script src='" . HOSTNAME . "js/metro/metro.min.js'></script>

            <!-- Load JavaScript Libraries -->
            <script src='" . HOSTNAME . "js/jquery/jquery.min.js'></script>
            <script src='" . HOSTNAME . "js/jquery/jquery.widget.min.js'></script>
            <script src='" . HOSTNAME . "js/jquery/jquery.mousewheel.js'></script>
            <script src='" . HOSTNAME . "js/prettify/prettify.js'></script>

            <!-- Metro UI CSS JavaScript plugins -->
            <script src='" . HOSTNAME . "js/metro.min.js'></script>

            <!-- Local JavaScript -->
            <script src='" . HOSTNAME . "js/docs.js'></script>
            <script src='" . HOSTNAME . "js/github.info.js'></script>
        </head>
        <body class='metro'>
            <div class='grid'>
                <div class='bg-NACOSS-UNN row ntm'>
                    <h3 class='span2'> NACOSS UNN </h3>
                </div>
                <br/>
                <div>
                    $content
                </div>
            </div>
            <div class='bg-dark'>
                <div class='container tertiary-text bg-dark fg-white' style='padding: 10px'>
                    &copy; <a href='" . NDG_HOMEPAGE . "' target='_blank' class='fg-white fg-hover-yellow fg-active-amber'>NACOSS UNN Developers Group (NDG)</a>        
                </div>
            </div>
        </body>
    </html>
    ";
}

/**
 * Resets user password, requires UserUtility to be included 
 * @param type $regno
 * @param type $newPassword
 */
function resetUserPassword($regno, $newPassword) {
    //Check password
    $link = UserUtility::getDefaultDBConnection();
    $options = array('cost' => UserUtility::getHashCost());
    $pwd = password_hash($newPassword, PASSWORD_DEFAULT, $options);
    $query = "update users set password='" . $pwd . "' where regno='$regno'";
    mysqli_query($link, $query);
    //Log error
    UserUtility::logMySQLError($link);
}

/**
 * Resets admin password, requires AdminUtility to be included 
 * @param type $id
 * @param type $newPassword
 */
function resetAdminPassword($id, $newPassword) {
    //Check password
    $link = AdminUtility::getDefaultDBConnection();
    $options = array('cost' => AdminUtility::getHashCost());
    $pwd = password_hash($newPassword, PASSWORD_DEFAULT, $options);
    $query = "update admins set password='" . $pwd . "' where username='$id'";
    mysqli_query($link, $query);
    //Log error
    AdminUtility::logMySQLError($link);
}
