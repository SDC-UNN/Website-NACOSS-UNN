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


class Utility {

    public static function getContactEmail() {
        $query = "select value from settings where name = 'email'";
        $link = Utility::getDefaultDBConnection();
        $result = mysqli_query($link, $query);
        if ($result) {
            $row = mysqli_fetch_array($result);
            return $row['value'];
        }
        return "";
    }

    public static function getContactNumbers() {
        $query = "select value from settings where name = 'help_lines'";
        $link = Utility::getDefaultDBConnection();
        $result = mysqli_query($link, $query);
        if ($result) {
            $row = mysqli_fetch_array($result);
            return empty($row['value']) ? array() : explode(",", $row['value']);
        }
        return array();
    }

    public static function getNews() {
        $array = array();
        $query = "select * from news limit 30";
        $link = Utility::getDefaultDBConnection();
        $result = mysqli_query($link, $query);
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                array_push($array, $row);
            }
        }
        return $array;
    }

    public static function getFAQs() {
        $array = array();
        $query = "select * from faq limit 20";
        $link = Utility::getDefaultDBConnection();
        $result = mysqli_query($link, $query);
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                array_push($array, $row);
            }
        }
        return $array;
    }

    public static function getPayments($ID) {
        $array = array();
        $query = "select * from payments where user_id='" . $ID . "'";
        $link = Utility::getDefaultDBConnection();
        $result = mysqli_query($link, $query);
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                array_push($array, $row);
            }
        }
        return $array;
    }
    
    public static function getErrorReports($ID) {
        $array = array();
        $query = "select * from error_reports where user_id='" . $ID . "'";
        $link = Utility::getDefaultDBConnection();
        $result = mysqli_query($link, $query);
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                array_push($array, $row);
            }
        }
        return $array;
    }

    public static function getResults($ID) {
        $array = array();
        $query = "select entry_year from users where regno='" . $ID . "'";
        $link = Utility::getDefaultDBConnection();
        $result = mysqli_query($link, $query);
        if ($result) {
            $row = mysqli_fetch_array($result);
            $entry_year = $row['entry_year'];
        }

        if (isset($entry_year)) {
            $query = "select * from results where entry_year='$entry_year' order by year,semester,course_code DESC";
            $result = mysqli_query($link, $query);
            if ($result) {
                while ($row = mysqli_fetch_array($result)) {
                    array_push($array, $row);
                }
            }
        }
        return $array;
    }

    /**
     * Returns error messages for parameters with invalid values (from profile or registration form)
     * @param type $array array of fields mapped to values
     * @return string error message in respect to any invalid parameter found, else an empty string
     */
    public static function getInvalidParameters($array) {
        foreach ($array as $key => $value) {
            switch (strtolower($key)) {
                case 'regno':
                    $chunks = explode("/", $value);
                    if (strlen($chunks[0]) != 4 || strlen($chunks[1]) != 6) {
                        return "Invalid registration number";
                    }
                    break;
                case 'first_name':
                    if (strlen($value) < 2) {
                        return "first name must contain atleast 2 characters";
                    }
                    break;
                case 'last_name':
                    if (strlen($value) < 2) {
                        return "last name must contain atleast 2 characters";
                    }
                    break;
                case 'password': //For time passwords
                    if (strlen($value) < 8) {
                        return "Password must contain atleast 8 characters";
                    }
                    break;
                case 'password1': //For passwords with confirmations
                    if (strlen($value) < 8) {
                        return "Password must contain atleast 8 characters";
                    }
                    break;
                case 'password2': //confirmation passwords
                    if (strcmp($value, $array["password1"]) !== 0) {
                        return "Passwords do not match";
                    }
                    break;
                case 'email':
                    if (filter_var($value, FILTER_VALIDATE_EMAIL) === FALSE) {
                        return "Check email address";
                    }
                    break;
                case 'dob':
                    break;
                case 'phone':
                    break;
                //Add more parameter cases as needed
                default :
                    break;
            }
        }
        return "";
    }

    public static function getVerificationMessage($ID, $password) {
        $message = '<html>'
                . '<body">'
                . 'find your login details below:<br/>'
                . '<strong>ID:</strong> ' . $ID . '<br/>'
                . '<strong>Password:</strong> ' . $password . '<br/>'
                . '</body>'
                . '</html>';
        return $message;
    }

    /**
     * 
     * @return connection to default database
     */
    public static function getDefaultDBConnection() {
        require_once './constants.php';
        $link = Utility::getConnection();
        if ($link) {
            $successful = mysqli_select_db($link, $GLOBALS['default_db_name']);
            if (!$successful) {
                die('Unable to select database: ' . mysql_error());
            }
        } else {
            die('Could not connect to database: ' . mysql_error());
        }
        return $link;
    }

    /**
     * creates a connection to the default database
     * @return connection
     */
    private static function getConnection() {
        require_once './constants.php';
        $link = mysqli_connect($GLOBALS['db_hostname'], $GLOBALS['db_username'], $GLOBALS['db_password']);
        return $link;
    }

    /**
     * Writes exception to log file
     * @param type $exc exception
     */
    public static function writeToLog(Exception $exc) {
        $link = getDefaultDBConnection();
        $message = "File: " . $exc->getFile() . " [line " . $exc->getLine() . "]\n"
                . "Message: " . $exc->getMessage();
        $query = "insert into error_log set message = '$message'";
        mysqli_query($link, $query);
    }

}
