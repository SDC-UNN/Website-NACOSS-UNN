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
require_once('../Admin.php');

class StudentAdmin extends Admin {

    ///variables
    private $classRepInfo = array();

    ///methods
    function __construct() {
        parent::__construct();
        $userInfo = $this->getUserData();
        $this->classRepInfo = array_merge($this->getAdminInfo(), $userInfo);
    }

    private function getUserData() {
        $query = "select * from users where regno = '" . $this->getAdminID() . "'";
        $link = AdminUtility::getDefaultDBConnection();
        $result = mysqli_query($link, $query);
        if ($result) {
            $array = mysqli_fetch_array($result);
            return $array;
        } else {
            //Log error
            AdminUtility::logMySQLError($link);
        }
        return array();
    }

    public function getField($index = 'regno') {
        return $this->classRepInfo[$index];
    }

    public function getSettings() {
        $settings = array();
        $query = "select * from settings where name LIKE '%sms_api_%'";
        $link = AdminUtility::getDefaultDBConnection();
        $result = mysqli_query($link, $query);
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                $settings[$row['name']] = $row;
            }
        }
        //Log error
        AdminUtility::logMySQLError($link);

        return $settings;
    }

    public function getSmsBillStatus() {
        $bill = array();
        $query = "select * from messenger_sms_biller where user_id = '" . $this->getAdminID() . "'";
        $link = AdminUtility::getDefaultDBConnection();
        $result = mysqli_query($link, $query);
        if ($result) {
            $row = mysqli_fetch_array($result);
        }
        //Log error
        AdminUtility::logMySQLError($link);
        return $row;
    }

    public function messageLog($type, $is_sent) {
        $rows = array();
        $query = "select * from messenger_log where user_id='" . $this->getAdminID() . "' and type='" . $type . "' and is_sent=" . $is_sent . " order by time_sent desc";
        $link = AdminUtility::getDefaultDBConnection();
        $result = mysqli_query($link, $query);
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                $rows[] = $row;
            }
        }
        //Log error
        AdminUtility::logMySQLError($link);
        return $rows;
    }

    public function createGroup($group_name, $group_members, $is_temp = 0) {
        if (strlen($group_name) and is_array($group_members) and sizeof($group_members) > 1) {
            $query = "insert into messenger_contacts_groups values(NULL,'" . $this->getAdminID() . "','" . $group_name . "','" . implode(',', $group_members) . "'," . time() . "," . time() . "," . $is_temp . ")";
            $link = AdminUtility::getDefaultDBConnection();
            $result = mysqli_query($link, $query);
            if ($result) {
                return true;
            }
            //Log error
            AdminUtility::logMySQLError($link);
            return false;
        } else {
            die('invalid input for function createGroup(String name, String[] members)');
        }
    }

    public function addToGroup($group_id, $new_members) {
        $row = getByCol('messenger_contacts_groups', 'id', $group_id);
        if (is_array($row) and is_array($new_members) and sizeof($new_members) > 0) {
            $group_members = explode(',', $row['group_members']);
            foreach ($new_members as $n) {
                if (!in_array($n, $group_members)) {
                    $group_members[] = $n;
                }
            }
            $query = "update messenger_contacts_groups set group_members = '" . implode(',', $group_members) . "', modified = " . time() . " where id=" . $group_id;
            $link = AdminUtility::getDefaultDBConnection();
            $result = mysqli_query($link, $query);
            if ($result) {
                return true;
            }
            //Log error
            AdminUtility::logMySQLError($link);
            return false;
        } else {
            die('invalid input for function addToGroup(Integer name, String[] new_members)');
        }
    }

    public function removeFromGroup($group_id, $del_members) {
        $row = getByCol('messenger_contacts_groups', 'id', $group_id);
        if (is_array($row) and is_array($del_members) and sizeof($del_members) > 0) {
            $old_members = explode(',', $row['group_members']);
            $new_members = array();
            foreach ($old_members as $n) {
                if (!in_array($n, $del_members)) {
                    $new_members[] = $n;
                }
            }
            $query = "update messenger_contacts_groups set group_members = '" . implode(',', $new_members) . "', modified = " . time() . " where id=" . $group_id;
            $link = AdminUtility::getDefaultDBConnection();
            $result = mysqli_query($link, $query);
            if ($result) {
                return true;
            }
            //Log error
            AdminUtility::logMySQLError($link);
            return false;
        } else {
            die('invalid input for function removeFromGroup(Integer name, String[] new_members)');
        }
    }

    public function renameGroup($group_id, $new_name) {
        $query = "update messenger_contacts_groups set group_name = '" . $new_name . "', modified = " . time() . " where id=" . $group_id;
        $link = AdminUtility::getDefaultDBConnection();
        $result = mysqli_query($link, $query);
        if ($result) {
            return true;
        }
        //Log error
        AdminUtility::logMySQLError($link);
        return false;
    }

    public function deleteGroup($group_id) {
        $query = "delete from messenger_contacts_groups where id=" . $group_id;
        $link = AdminUtility::getDefaultDBConnection();
        $result = mysqli_query($link, $query);
        if ($result) {
            return true;
        }
        //Log error
        AdminUtility::logMySQLError($link);
        return false;
    }

    public function changeSenderID($new_id) {
        $link = AdminUtility::getDefaultDBConnection();
        $query = "update messenger_sms_biller set default_sender_id='" . $new_id . "' where user_id='" . $this->getAdminID() . "'";
        if (mysqli_query($link, $query)) {
            return true;
        }
        //Log error
        AdminUtility::logMySQLError($link);
        return false;
    }

}
