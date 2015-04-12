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

    public function addClassRep($regno) {
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
            $query = "insert into admins set username = '$regno', "
                    . "password = '" . $row['password'] . "', "
                    . "type = '" . Admin::CLASS_REP . "', "
                    . "email = '" . $row['email'] . "'";
            $result = mysqli_query($link, $query);
            //Log error
            AdminUtility::logMySQLError($link);
            return $result;
        }
        //Log error
        AdminUtility::logMySQLError($link);
        throw new Exception("Failed to add $regno");
    }

    public function removeClassRep($regno) {
        $link = AdminUtility::getDefaultDBConnection();
        $query = "delete from admins where username = '$regno'";
        $result = mysqli_query($link, $query);
        if ($result) {
            return $result;
        }
        //Log error
        AdminUtility::logMySQLError($link);
        throw new Exception("Failed to remove $regno");
    }

}
