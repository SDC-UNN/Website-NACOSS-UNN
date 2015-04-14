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

        const SORT_USER_TYPE_REGNO = "regno";
        const SORT_USER_TYPE_FIRSTNAME = "first_name";
        const SORT_USER_TYPE_LASTNAME = "last_name";
        const SORT_USER_TYPE_LEVEL = "level";
        const ORDER_USER_ASC = "ASC";
        const ORDER_USER_DESC = "DESC";

function getNumberOfActiveUsers() {
    $query = "select * from users where is_deleted != 1 and is_suspended != 1";
    $link = AdminUtility::getDefaultDBConnection();
    $result = mysqli_query($link, $query);
    if ($result) {
        return mysqli_num_rows($result);
    }
    //Log error
    AdminUtility::logMySQLError($link);

    return 0;
}

function getActiveUsers() {
    $users = array();
    $query = "select * from users where is_deleted != 1 and is_suspended != 1";
    $link = AdminUtility::getDefaultDBConnection();
    $result = mysqli_query($link, $query);
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            $users[] = $row;
        }
        sortUser($users, SORT_USER_TYPE_LASTNAME, ORDER_USER_ASC);
    }
    //Log error
    AdminUtility::logMySQLError($link);

    return $users;
}

function getNumberOfSuspendedUsers() {
    $query = "select * from users where is_suspended = 1";
    $link = AdminUtility::getDefaultDBConnection();
    $result = mysqli_query($link, $query);
    if ($result) {
        return mysqli_num_rows($result);
    }
    //Log error
    AdminUtility::logMySQLError($link);

    return 0;
}

function getSuspendedUsers() {
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

function getNumberOfDeletedUsers() {
    $query = "select * from users where is_deleted = 1";
    $link = AdminUtility::getDefaultDBConnection();
    $result = mysqli_query($link, $query);
    if ($result) {
        return mysqli_num_rows($result);
    }
    //Log error
    AdminUtility::logMySQLError($link);
    return 0;
}

function getDeletedUsers() {
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

function getUserInfo($id) {
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

function getNumberOfUnseenErrorReports() {
    $query = "select * from error_reports where seen = 0";
    $link = AdminUtility::getDefaultDBConnection();
    $result = mysqli_query($link, $query);
    if ($result) {
        return mysqli_num_rows($result);
    }
    //Log error
    AdminUtility::logMySQLError($link);
    return 0;
}

function getNumberOfUnfixedError() {
    $query = "select * from error_log where is_fixed = 0";
    $link = AdminUtility::getDefaultDBConnection();
    $result = mysqli_query($link, $query);
    if ($result) {
        return mysqli_num_rows($result);
    }
    //Log error
    AdminUtility::logMySQLError($link);
    return 0;
}

function getAllErrorReports() {
    $array = array();
    $query = "select * from error_reports order by time_of_report DESC";
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

function getAllErrorLogs() {
    $array = array();
    $query = "select * from error_log order by time_of_error DESC";
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

function getSettings() {
    $settings = array();
    $query = "select * from settings";
    $link = AdminUtility::getDefaultDBConnection();
    $result = mysqli_query($link, $query);
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            $settings[] = $row;
        }
    }
    //Log error
    AdminUtility::logMySQLError($link);

    return $settings;
}

function updateSettingsTable(array $array) {
    if (count($array) > 0) {
        $link = AdminUtility::getDefaultDBConnection();
        mysqli_autocommit($link, false);
        $ok = true;
        foreach ($array as $key => $value) {
            if (strcasecmp($key, "help_lines") === 0) {
                validateNumbers($value);
            }

            $query = "update settings set value = '$value' where name = '$key'";
            //$ok remains true if all statements was sucessfully executed
            $ok = $ok and mysqli_query($link, $query);
        }
        if ($ok) {
            mysqli_commit($link);
            //Log error
            AdminUtility::logMySQLError($link);

            return true;
        } else {
            throw new Exception("Error occured while updating settings table");
        }
    } else {
        throw new Exception("No parameter was set");
    }
}

function updateLogTable(array $array) {
    if (count($array) > 0) {
        $link = AdminUtility::getDefaultDBConnection();
        mysqli_autocommit($link, false);
        $ok = true;
        foreach ($array as $key => $value) {
            $query = "update error_log set is_fixed = '$value' where id = '$key'";
            //$ok remains true if all statements was sucessfully executed
            $ok = $ok and mysqli_query($link, $query);
        }
        if ($ok) {
            mysqli_commit($link);
            //Log error
            AdminUtility::logMySQLError($link);
            return true;
        } else {
            throw new Exception("Error occured while updating log table");
        }
    } else {
        throw new Exception("No parameter was set");
    }
}

function updateReportsTable(array $array) {
    if (count($array) > 0) {
        $link = AdminUtility::getDefaultDBConnection();
        mysqli_autocommit($link, false);
        $ok = true;
        foreach ($array as $key => $value) {
            $query = "update error_reports set seen = '$value' where id = '$key'";
            //$ok remains true if all statements was sucessfully executed
            $ok = $ok and mysqli_query($link, $query);
        }
        if ($ok) {
            mysqli_commit($link);
            //Log error
            AdminUtility::logMySQLError($link);
            return true;
        } else {
            throw new Exception("Error occured while updating reports table");
        }
    } else {
        throw new Exception("No parameter was set");
    }
}

function validateNumbers($numbers) {
    $numbers_in_array = explode(",", $numbers);
    foreach ($numbers_in_array as $num) {
        $num = trim($num);
        if (strlen($num) == 14) { //10 digits and +234
            if (strrpos($num, "+234") !== 0) {
                throw new Exception("Invalid number $num");
            }
        } elseif (strlen($num) !== 11) {
            throw new Exception("Invalid number $num");
        }
    }
}

function getClassReps() {
    $class_reps = array();
    $query = "select u.first_name, u.last_name, u.regno, u.level from admins a "
            . "join users u on u.regno = a.username "
            . "where a.type = '" . Admin::CLASS_REP . "' ";
    $link = AdminUtility::getDefaultDBConnection();
    $result = mysqli_query($link, $query);
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            array_push($class_reps, $row);
        }
    }
    //Log error
    AdminUtility::logMySQLError($link);

    return $class_reps;
}

/**
 * 
 * @param type $search_query
 * @param type $sort_type
 * @param type $sort_order
 * @return array
 */
function searchUsers($search_query, $is_deleted = false, $is_suspended = false, $sort_type = null, $sort_order = null) {
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
    sortUser($users, $sort_type, $sort_order);
    //Log error
    AdminUtility::logMySQLError($link);

    return $users;
}

function sortUser(array &$users, $sort_type, $sort_order) {
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
        case SORT_USER_TYPE_FIRSTNAME:
            array_multisort($first_name, ($sort_order == ORDER_USER_DESC ? SORT_DESC : SORT_ASC), $last_name, SORT_ASC, $level, SORT_DESC, $users);
            break;
        case SORT_USER_TYPE_LASTNAME:
            array_multisort($last_name, ($sort_order == ORDER_USER_DESC ? SORT_DESC : SORT_ASC), $first_name, SORT_ASC, $level, SORT_DESC, $users);
            break;
        case SORT_USER_TYPE_REGNO:
            array_multisort($regno, ($sort_order == ORDER_USER_DESC ? SORT_DESC : SORT_ASC), $last_name, SORT_ASC, $first_name, SORT_DESC, $users);
            break;
        case SORT_USER_TYPE_LEVEL:
            array_multisort($level, ($sort_order == ORDER_USER_DESC ? SORT_DESC : SORT_ASC), $last_name, SORT_ASC, $first_name, SORT_DESC, $users);
            break;
        default :
            throw new Exception("Invalid sort type");
    }
}

function deleteUsers(array $regno) {
    $link = AdminUtility::getDefaultDBConnection();
    mysqli_autocommit($link, false);
    foreach ($regno as $value) {
        $query = "update users set is_deleted = 1, is_suspended = 0 where regno = '$value'";
        $ok = mysqli_query($link, $query);
        if (!$ok) {
            //Log error
            AdminUtility::logMySQLError($link);
            return FALSE;
        }
    }
    return mysqli_commit($link);
}

function suspendUsers(array $regno) {
    $link = AdminUtility::getDefaultDBConnection();
    mysqli_autocommit($link, false);
    foreach ($regno as $value) {
        $query = "update users set is_suspended = 1, is_deleted = 0 where regno = '$value'";
        $ok = mysqli_query($link, $query);
        if (!$ok) {
            //Log error
            AdminUtility::logMySQLError($link);
            return FALSE;
        }
    }
    return mysqli_commit($link);
}

function activateUsers(array $regno) {
    $link = AdminUtility::getDefaultDBConnection();
    mysqli_autocommit($link, false);
    foreach ($regno as $value) {
        $query = "update users set is_suspended = 0, is_deleted = 0  where regno = '$value'";
        $ok = mysqli_query($link, $query);
        if (!$ok) {
            //Log error
            AdminUtility::logMySQLError($link);
            return FALSE;
        }
    }
    return mysqli_commit($link);
}

/**
 * @Param int $min_ms Minimum amount of time in milliseconds that it should take
 * to calculate the hashes
 */
function getOptimalCryptCostParameter($min_ms = 250) {
    for ($i = 4; $i < 31; $i++) {
        $options = [ 'cost' => $i, 'salt' => 'usingsomesillystringforsalt'];
        $time_start = microtime(true);
        password_hash("ndg_unn_foo_password12345", PASSWORD_DEFAULT, $options);
        $time_end = microtime(true);
        if (($time_end - $time_start) * 1000 > $min_ms) {
            return $i;
        }
    }
}
