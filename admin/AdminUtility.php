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

class AdminUtility {

    const SORT_USER_TYPE_REGNO = "regno";
    const SORT_USER_TYPE_FIRSTNAME = "first_name";
    const SORT_USER_TYPE_LASTNAME = "last_name";
    const SORT_USER_TYPE_LEVEL = "level";
    const ORDER_ASC = "ASC";
    const ORDER_DESC = "DESC";

    public static function getContactEmail() {
        $query = "select value from settings where name = 'email'";
        $link = AdminUtility::getDefaultDBConnection();
        $result = mysqli_query($link, $query);
        if ($result) {
            $row = mysqli_fetch_array($result);
            return $row['value'];
        }
        //Log error
        AdminUtility::logMySQLError($link);

        return "";
    }

    public static function getContactNumbers() {
        $query = "select value from settings where name = 'help_lines'";
        $link = AdminUtility::getDefaultDBConnection();
        $result = mysqli_query($link, $query);
        if ($result) {
            $row = mysqli_fetch_array($result);
            return empty($row['value']) ? array() : explode(",", $row['value']);
        }
        //Log error
        AdminUtility::logMySQLError($link);

        return array();
    }

    public static function getNews() {
        $array = array();
        $query = "select * from news";
        $link = AdminUtility::getDefaultDBConnection();
        $result = mysqli_query($link, $query);
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                array_push($array, $row);
            }
        }
        //Log error
        AdminUtility::logMySQLError($link);

        return $array;
    }

    public static function getFAQs() {
        $array = array();
        $query = "select * from faq";
        $link = AdminUtility::getDefaultDBConnection();
        $result = mysqli_query($link, $query);
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                array_push($array, $row);
            }
        }
        //Log error
        AdminUtility::logMySQLError($link);

        return $array;
    }

    /**
     * 
     * @return connection to default database
     */
    public static function getDefaultDBConnection() {
        $link = AdminUtility::getConnection();
        if ($link) {
            $successful = mysqli_select_db($link, DEFAULT_DB_NAME);
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
        $link = mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD);
        return $link;
    }

    /**
     * Writes exception to log file
     * @param type $exc exception
     */
    public static function writeToLog(Exception $exc) {
        $link = AdminUtility::getDefaultDBConnection();
        $line = $exc->getLine();
        $file = mysqli_escape_string($link, $exc->getFile());
        $message = mysqli_escape_string($link, $exc->getMessage());
        $trace = mysqli_escape_string($link, $exc->getTraceAsString());
        //Check if error has been logged previously
        $query = "select * from error_log where message = '$message' and file='$file' and line='$line'";
        $result = mysqli_query($link, $query);
        if ($result) {
            $row = mysqli_fetch_array($result);
        }
        //If previously logged, update time and set is-fixed = 0 else insert new log
        if ($result && $row) {
            $query = "update error_log set time_of_error = now(), is_fixed = 0 where id = '" . $row['id'] . "'";
        } else {
            $query = "insert into error_log set message = '$message', "
                    . "file='$file', "
                    . "trace='$trace', line='$line', time_of_error = now()";
        }
        return mysqli_query($link, $query);
    }

    public static function getHashCost() {
        $query = "select value from settings where name = 'hash_algo_cost'";
        $link = AdminUtility::getDefaultDBConnection();
        $result = mysqli_query($link, $query);
        if ($result) {
            $row = mysqli_fetch_array($result);
            return $row['value'];
        }
        //Log error
        AdminUtility::logMySQLError($link);

        return 10;
    }

    /**
     * Log database error
     * @param type $link
     */
    public static function logMySQLError($link) {
        $error = mysqli_error($link);
        if (!empty($error)) {
            AdminUtility::writeToLog(new Exception($error));
        }
    }

    public static function getDeletedUsers() {
        $deleted_users = array();
        $query = "select * from users where is_deleted = 1";
        $link = AdminUtility::getDefaultDBConnection();
        $result = mysqli_query($link, $query);
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                $deleted_users[] = $row;
            }
        }
        //Log error
        AdminUtility::logMySQLError($link);
        return $deleted_users;
    }

    public static function getSuspendedUsers() {
        $suspended_users = array();
        $query = "select * from users where is_suspended = 1";
        $link = AdminUtility::getDefaultDBConnection();
        $result = mysqli_query($link, $query);
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                $suspended_users[] = $row;
            }
        }
        //Log error
        AdminUtility::logMySQLError($link);

        return $suspended_users;
    }

    public static function getActiveUsers() {
        $users = array();
        $query = "select * from users where is_deleted != 1 and is_suspended != 1";
        $link = AdminUtility::getDefaultDBConnection();
        $result = mysqli_query($link, $query);
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                $users[] = $row;
            }
            AdminUtility::sortUser($users, AdminUtility::SORT_USER_TYPE_LASTNAME, AdminUtility::ORDER_ASC);
        }
        //Log error
        AdminUtility::logMySQLError($link);

        return $users;
    }

    public static function getUserInfo($id) {
        $query = "select * from users where regno = '$id'";
        $link = AdminUtility::getDefaultDBConnection();
        $result = mysqli_query($link, $query);
        if ($result) {
            $row = mysqli_fetch_array($result);
            return $row;
        }
        //Log error
        AdminUtility::logMySQLError($link);
        return array();
    }

    /**
     * 
     * @param type $search_query
     * @param type $sort_type
     * @param type $sort_order
     * @return array
     */
    public static function searchUsers($search_query, $is_deleted = false, $is_suspended = false, $sort_type = null, $sort_order = null) {
        $users = array();
        $link = AdminUtility::getDefaultDBConnection();
        //process query
        $fields = explode(" ", $search_query);
        $query = "select * from users where (is_deleted = " . ( $is_deleted ? "1" : "0" ) . " and "
                . "is_suspended = " . ( $is_suspended ? "1" : "0" ) . ") and "
                . "(";
        for ($count = 0; $count < count($fields); $count++) {
            $query .= "regno = '$fields[$count]' or "
                    . "last_name like '%$fields[$count]%' or "
                    . "level = '$fields[$count]' or "
                    . "first_name like '%$fields[$count]%'";
            if ($count !== (count($fields) - 1)) {
                $query .= " or ";
            } else {
                $query .= ")";
            }
        }
        //Search
        $result = mysqli_query($link, $query);
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                array_push($users, $row);
            }
        }
        AdminUtility::sortUser($users, $sort_type, $sort_order);
        //Log error
        AdminUtility::logMySQLError($link);

        return $users;
    }

    private static function sortUser(array &$users, $sort_type, $sort_order) {
        if (empty($users) || empty($sort_type) || empty($sort_order)) {
            return;
        }

        foreach ($users as $key => $row) {
            $last_name[$key] = $row['last_name'];
            $first_name[$key] = $row['first_name'];
            $regno[$key] = $row['regno'];
            $level[$key] = $row['level'];
        }

        switch ($sort_type) {
            case AdminUtility::SORT_USER_TYPE_FIRSTNAME:
                array_multisort($first_name, ($sort_order == AdminUtility::ORDER_DESC ? SORT_DESC : SORT_ASC), $last_name, SORT_ASC, $level, SORT_DESC, $users);
                break;
            case AdminUtility::SORT_USER_TYPE_LASTNAME:
                array_multisort($last_name, ($sort_order == AdminUtility::ORDER_DESC ? SORT_DESC : SORT_ASC), $first_name, SORT_ASC, $level, SORT_DESC, $users);
                break;
            case AdminUtility::SORT_USER_TYPE_REGNO:
                array_multisort($regno, ($sort_order == AdminUtility::ORDER_DESC ? SORT_DESC : SORT_ASC), $last_name, SORT_ASC, $first_name, SORT_DESC, $users);
                break;
            case AdminUtility::SORT_USER_TYPE_LEVEL:
                array_multisort($level, ($sort_order == AdminUtility::ORDER_DESC ? SORT_DESC : SORT_ASC), $last_name, SORT_ASC, $first_name, SORT_DESC, $users);
                break;
            default :
                throw new Exception("Invalid sort type");
        }
    }

}
