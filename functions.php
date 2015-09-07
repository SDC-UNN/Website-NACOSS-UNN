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
        $header = "From: no-reply@nacossunn.org\r\n"
                . "Content-type: text/html\r\n"
                . "X-Mailer: PHP/" . phpversion();
        return mail($email, $subject, wordwrap(getMessage($msg), 70), $header);
    } else {
        return false;
    }
}

function getMessage($content) {
    return <<<HTML
    <html>
        <body>
            <table style="width: 100%; background-color: white">
                <thead>
                    <tr style='background-color: #60a917'>
                        <th style='padding: 10px; color: white; height: 30px; text-align: left'> 
							<img src="http://nacossunn.org/favicon.ico" style="height:100%;"/> 
							<span style="font-family: 'Segoe UI Semibold', 'Open Sans Bold', Verdana, Arial, Helvetica, sans-serif; font-size: 30px; margin-left: 10px">NACOSS UNN</span>
						</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding: 10px; font-family: 'Segoe UI', 'Open Sans', Verdana, Arial, Helvetica, sans-serif;">
                            $content
                            <br/>
                            Kind Regards,<br/>
                            The NACOSS UNN Developers Group
                        </td>
                    </tr>
                    <tr style='background-color: #333333'>
                        <td style='color: white; padding: 10px'>
							<p style='color: gray; font-size: 11px'>This email is automatically generated, do not reply.</p>
                            copyright NACOSS UNN
                        </td>
                    </tr>
                </tbody>
            </table>
        </body>
    </html>
HTML;
}

/**
 * Resets user password, requires UserUtility to be included 
 * @param type $regno
 * @param type $newPassword
 */
function resetUserPassword($regno, $newPassword) {
    //Check password
    $link = UserUtility::getDefaultDBConnection();
    $pwd = crypt($newPassword);
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
    $pwd = crypt($newPassword);
    $query = "update admins set password='" . $pwd . "' where username='$id'";
    mysqli_query($link, $query);
    //Log error
    AdminUtility::logMySQLError($link);
}

function isClassRep($regno) {
    $query = "select * from admins where username = '" . $regno . "'";
    $link = UserUtility::getDefaultDBConnection();
    $result = mysqli_query($link, $query);
    if ($result) {
        return mysqli_num_rows($result) > 0;
    } else {
        return false;
    }
}

function bytesToSize($bytes) {
    $sizes = array('Bytes', 'KB', 'MB', 'GB', 'TB');
    if ($bytes === 0) {
        return '0 Bytes';
    }
    $i = intval(floor(log($bytes) / log(1024)));
    return round($bytes / pow(1024, $i), 2) . ' ' . $sizes[$i];
}
