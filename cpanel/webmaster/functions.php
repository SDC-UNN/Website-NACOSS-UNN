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
    $query = "select u.first_name, u.last_name, u.regno, u.level, m.user_id, m.units_used, m.units_assigned from admins a "
            . "join (users u, messenger_sms_biller m) on (u.regno = a.username and u.regno = m.user_id) "
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
