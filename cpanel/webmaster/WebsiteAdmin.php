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

class WebsiteAdmin extends Admin {

    public function setHashCost($cost) {
        $query = "update settings set value = '$cost' where name = 'hash_algo_cost'";
        $link = AdminUtility::getDefaultDBConnection();
        $result = mysqli_query($link, $query);

        //Log error
        AdminUtility::logMySQLError($link);
        return $result;
    }

    /**
     * se
     * @param type $time
     * @return type resultset object
     */
    public function setMaxHashTime($time) {
        $query = "update settings set value = '$time' where name = 'max_hash_time'";
        $link = AdminUtility::getDefaultDBConnection();
        $result = mysqli_query($link, $query);
        //Log error
        AdminUtility::logMySQLError($link);
        return $result;
    }

    /**
     * 
     * @return type int Maximum allowed time fo hashing in milliseconds
     */
    public function getMaxHashTime() {
        $query = "select value from settings where name = 'max_hash_time'";
        $link = AdminUtility::getDefaultDBConnection();
        $result = mysqli_query($link, $query);
        if ($result) {
            $row = mysqli_fetch_array($result);
            return $row['value'];
        }
        //Log error
        AdminUtility::logMySQLError($link);
        return 250;
    }

    public function addClassRep($regno, $sms_units) {
        $link = AdminUtility::getDefaultDBConnection();

        $q = "select * from admins where username = '$regno'";
        $res = mysqli_query($link, $q);
        if ($res and mysqli_num_rows($res) > 0) {
            throw new Exception("Class representative $regno already exists");
        }

        $query = "select * from users where regno = '$regno'";
        $result = mysqli_query($link, $query);
        if ($result and mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            $query1 = "insert into admins set username = '$regno', "
                    . "password = '" . $row['password'] . "', "
                    . "type = '" . Admin::CLASS_REP . "', "
                    . "email = '" . $row['email'] . "'";
			$query2 = "insert into messenger_sms_biller values(NULL, '$regno', $sms_units, 0, 'Class Rep')";
            $result1 = mysqli_query($link, $query1);
            $result2 = mysqli_query($link, $query2);
            //Log error
            AdminUtility::logMySQLError($link);
            return true;
        }
        //Log error
        AdminUtility::logMySQLError($link);
        throw new Exception("Failed to add $regno");
    }

    public function removeClassRep($regno) {
        $link = AdminUtility::getDefaultDBConnection();
        $query1 = "delete from admins where username = '$regno'";
        $query2 = "delete from messenger_sms_biller where user_id = '$regno'";
        $result1 = mysqli_query($link, $query1);
        $result2 = mysqli_query($link, $query2);
        if ($result1 and $result2) {
            return true;
        }
        //Log error
        AdminUtility::logMySQLError($link);
        throw new Exception("Failed to remove $regno");
    }
	
	public function updateClassRepSMSbalance($user_id, $new_balance){
        $link = AdminUtility::getDefaultDBConnection();
        $query = "update messenger_sms_biller set units_assigned = $new_balance where user_id = '$user_id'";
        $result = mysqli_query($link, $query);
        if ($result) {
            return true;
        }
        //Log error
        AdminUtility::logMySQLError($link);
        throw new Exception("Failed to update balance for $user_id");
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

}
