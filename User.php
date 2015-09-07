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

require_once 'constants.php';
require_once 'UserUtility.php';
require_once 'functions.php';

class User {

    private $userInfo;

    function User() {
        $this->userInfo = $this->getUserData();
    }

    /**
     * Validates user cookies against user details in database
     * @return boolean true if user cookies match user details in database, else false
     */
    public function isLoggedIn() {
        if (isset($this->userInfo)) {
            $match = strcasecmp($this->userInfo['password'], $this->getCookiesPassword());
            return empty($this->userInfo['password']) ? false : $match === 0;
        }
        return false;
    }

    public function isUserDeleted() {
        if (isset($this->userInfo)) {
            return $this->userInfo['is_deleted'] == 1;
        }
        return true; //Restrict access if record does not exist
    }

    public function isUserSuspended() {
        if (isset($this->userInfo)) {
            return $this->userInfo['is_suspended'] == 1;
        }
        return false; //Restrict access if record does not exist
    }

    /**
     * @returns user display name
     */
    public function getDisplayName() {
        if ($this->isLoggedIn()) {
            if ($this->userInfo) {
                return $this->userInfo['first_name'] . " " . $this->userInfo['last_name'];
            }
        }
        return "";
    }

    /**
     * Validates user details and set cookies
     * @param type $ID user's registration number
     * @param type $password user's password
     * @return boolean true if user was successfully validated and cookies was sucessfully set, false otherwise
     */
    public function loginUser($ID, $password) {
        if (!(empty($ID) | empty($password))) {
            $query = "select password from users where regno = '$ID'";
            $link = UserUtility::getDefaultDBConnection();
            $result = mysqli_query($link, $query);
            if ($result) {
                $row = mysqli_fetch_array($result);
                $hash = $row['password'];
                // Verify stored hash against plain-text password
                if ($this->verifyPassword($password, $hash)) {
                    //update data
                    $ok = $this->setUserCookies($ID, $hash);
                    $this->userInfo = $this->getUserData();
                    return $ok;
                }
            }
            //Log error
            UserUtility::logMySQLError($link);
        }
        return false;
    }

    /**
     * Update the data of user having the given ID with given values 
     * @param type $array array of fields mapped to values
     * @return boolean returns true if user's data was successfully updated, false otherwise
     */
    public function updateUserInfo(array $array) {
        $link = UserUtility::getDefaultDBConnection();
        foreach ($array as $key => $value) {
            $array[$key] = mysqli_escape_string($link, $value);
        }
        $ok = $this->validateInfo($array["regno"], $array["email"], $array["first_name"], $array["last_name"], $array["phone"]);

        if ($ok) {
            if (!empty($_FILES["pic_url"]['name'])) {
                $url = $this->uploadUserImage("pic_url"); //Throws exception if not successful
                $array['pic_url'] = $url;
            } else {
                $array['pic_url'] = $this->userInfo['pic_url'];
            }

            $query = $this->getUpdateQuery($array);
            $ok = mysqli_query($link, $query);
            //Log error
            UserUtility::logMySQLError($link);

            //Reload
            $this->userInfo = $this->getUserData();
        } else {
            throw new Exception("Oops! Something went wrong, please try again");
        }
    }

    private function uploadUserImage($filename) {

        switch ($_FILES[$filename]["type"]) {
            case "image/gif":
                $file_ext = ".gif";
                break;
            case "image/jpeg":
                $file_ext = ".jpeg";
                break;
            case "image/jpg":
                $file_ext = ".jpg";
                break;
            case "image/pjpeg":
                $file_ext = ".jpeg";
                break;
            case "image/png":
                $file_ext = ".png";
                break;
            default:
                $file_ext = "";
                break;
        }

        if (empty($file_ext)) {
            throw new Exception("Unknown file format");
        }

        if (($_FILES[$filename]["size"] / 1024) > 250) { //250kb
            throw new Exception("File too large");
        }

        if ($_FILES[$filename]["error"] > 0) {
            throw new Exception("Oops! Error occurred while uploading file");
//            echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
        }

        //Delete old profile picture
        if (file_exists($this->userInfo['pic_url'])) {
            unlink($this->userInfo['pic_url']);
        }

        $prefix = str_replace("/", "", $this->getUserID());
        $url = "uploads/userpics/" . $prefix . $file_ext;
        $moved = move_uploaded_file($_FILES[$filename]["tmp_name"], $url);

        if ($moved) {
            return $url;
        } else {
            throw new Exception("Oops! Error occurred while uploading file");
        }
    }

    private function getUpdateQuery(array $array) {
        return "update users set email='" . $array["email"] . "',"
                . "first_name='" . $array["first_name"] . "',last_name='" . $array["last_name"] . "',"
                . "other_names='" . $array["other_names"] . "',department='" . $array["department"] . "',"
                . "level='" . $array["level"] . "',phone='" . $array["phone"] . "',"
                . "address1='" . $array["address1"] . "',address2='" . $array["address2"] . "',"
                . "interests='" . $array["interests"] . "',bio='" . $array["bio"] . "',"
                . "pic_url='" . $array["pic_url"] . "',"
                . "entry_year='" . $array["entry_year"] . "',dob='" . $array["dob"] . "' "
                //Add more field as needed
                . "where regno='" . $array["regno"] . "'";
    }

    public function getUserData() {
        $query = "select * from users where regno = '" . $this->getCookiesID() . "'";
        $link = UserUtility::getDefaultDBConnection();
        $result = mysqli_query($link, $query);
        if ($result) {
            $array = mysqli_fetch_array($result);
            return $array;
        } else {
            //Log error
            UserUtility::logMySQLError($link);
        }
        return array();
    }

    private function validatePassword($password) {
        if (strlen($password) >= 8) {
            $regex = "#(\w*[\s\S]*[A-Z]+)+#";
            if (!preg_match($regex, $password)) {
                throw new Exception("Invalid password: try switching letter cases");
            }
        } else {
            throw new Exception("Password should be up to 8 characters long");
        }
    }

    private function validateInfo($ID, $email, $first_name, $last_name, $phone, $password = null) {
        if (isset($ID) && isset($email) && isset($first_name) &&
                isset($last_name) && isset($phone)) {
            //Check ID
            if (!preg_match("#\d{4}/\d{6}#", $ID)) {
                throw new Exception("Invalid ID");
            }
            //Check email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Invalid email");
            }
            //Check first name
            if (!preg_match("#[[:alpha:]]{2,}#", $first_name)) {
                throw new Exception("Invalid first name");
            }
            //Check last name
            if (!preg_match("#[[:alpha:]]{2,}#", $last_name)) {
                throw new Exception("Invalid last name");
            }
            //Check phone
            if (!preg_match("#\d{11}|(\+234{10})#", $phone)) {
                throw new Exception("Invalid phone number");
            }
            //Check password
            if (isset($password)) {
                $this->validatePassword($password);
            }
            return TRUE;
        }
        throw new Exception("Field not set");
    }

    private function addNewUser($ID, $password, $email, $first_name, $last_name, $phone) {
        $link = UserUtility::getDefaultDBConnection();
        $regno = mysqli_escape_string($link, $ID);
        $hash = crypt($password);
        $pwd = mysqli_escape_string($link, $hash);
        $email_address = mysqli_escape_string($link, $email);
        $fname = mysqli_escape_string($link, $first_name);
        $lname = mysqli_escape_string($link, $last_name);
        $phone_no = mysqli_escape_string($link, $phone);
        $query = "insert into users set regno = '$regno',"
                . "password='$pwd',"
                . "email='$email_address',"
                . "first_name='$fname',"
                . "last_name='$lname',"
                . "phone='$phone_no'";
        $ok = mysqli_query($link, $query);
        return $ok;
    }

    /**
     * Creates a new user with the given infomation
     * @param type $ID user's registration number
     * @param type $password user's password
     * @param type $email user's email address
     * @param type $first_name user's first name
     * @param type $last_name user's last name
     * @param type $phone user's phone number
     * @return boolean returns true if user's data was successfully registered, false otherwise
     */
    public function registerUser($ID, $password, $retypedPassword, $email, $first_name, $last_name, $phone) {
        // Validate details
        $ok = strcmp($password, $retypedPassword) === 0;
        if ($ok) {
            $ok = $this->validateInfo($ID, $email, $first_name, $last_name, $phone, $password);
        } else {
            throw new Exception("Passwords do not match");
        }
        // Add to database
        if ($ok) {
            $ok = $this->addNewUser($ID, $password, $email, $first_name, $last_name, $phone);
        }
        // Mail login id and password to user
        if ($ok) {
            try {
                sendMail($email, "Login Details", UserUtility::getVerificationMessage($ID, $password));
            } catch (Exception $exc) {
                //Mailing failed
                UserUtility::writeToLog($exc);
            }
        }
        return $ok;
    }

    /**
     * @returns students registration number from cookies
     */
    private function getCookiesID() {
        return filter_input(INPUT_COOKIE, "user_id");
    }

    /**
     * @returns students password from cookies
     */
    private function getCookiesPassword() {
        return filter_input(INPUT_COOKIE, "user_pwd");
    }

    public function getUserID() {
        if (isset($this->userInfo)) {
            return $this->userInfo['regno'];
        }
        return "";
    }

    public function getUserPassword() {
        if (isset($this->userInfo)) {
            return $this->userInfo['password'];
        }
        return "";
    }

    /**
     * Sets cookies
     * @param type $id
     * @param type $password
     * @return type
     */
    private function setUserCookies($id, $password) {
        $expire = time() + (60 * 60 * 24 * 7); //1 week i.e 60secs * 60mins * 2hhrs * 7days
        $ok = setcookie("user_id", $id, $expire);
        if ($ok) {
            $ok = setcookie("user_pwd", $password, $expire);
        }
        return $ok;
    }

    public function logoutUser() {
        return $this->clearUserCookies();
    }

    /**
     * Clears all cookies
     * @return type true if all cookies were removed, false otherwise
     */
    private function clearUserCookies() {
        $clearIDOk = setcookie("user_id", "", time() - 3600);
        $clearPwdOk = setcookie("user_pwd", "", time() - 3600);
        return $clearIDOk && $clearPwdOk;
    }

    /**
     * Adds bug report to database
     * @param type $array
     * @return boolean true if report was successfully sent, false otherwise
     */
    public function reportBug(array $array) {
        $link = UserUtility::getDefaultDBConnection();
        //Check if report already exist
        $query = "select * from error_reports where "
                . "user_id = '" . $this->getCookiesID() . "' and "
                . "subject='" . $array['subject'] . "' and "
                . "comment = '" . $array['comment'] . "'";
        $result = mysqli_query($link, $query);
        if ($result) {
            $row = mysqli_fetch_array($result);
        } else {
            //Log error
            UserUtility::logMySQLError($link);
        }

        if ($result && $row) {
            throw new Exception("Already posted");
        } else {
            $query = "insert into error_reports set user_id = '" . $this->getCookiesID() . "', "
                    . "subject='" . $array['subject'] . "', "
                    . "comment = '" . $array['comment'] . "'";
            return mysqli_query($link, $query);
        }
    }

    /**
     * Verifies and changes User's password (This is supported on php version >= 5.5.0)
     * @param type $oldPassword
     * @param type $newPassword1
     * @param type $newPassword2
     * @return type
     * @throws Exception
     */
    public function changePassword($oldPassword, $newPassword1, $newPassword2) {
        if ($this->verifyPassword($oldPassword, $this->getUserPassword())) {
            //Check password
            $this->validatePassword($newPassword1);
            $ok = strcmp($newPassword1, $newPassword2) === 0;
            if ($ok) {
                $link = UserUtility::getDefaultDBConnection();
                $pwd = crypt($newPassword1);
                $query = "update users set password='" . $pwd . "' where regno='" . $this->getUserID() . "'";
                mysqli_query($link, $query);
                //Log error
                UserUtility::logMySQLError($link);

                //Reload
                $this->userInfo = $this->getUserData();
                $ok = $this->setUserCookies($this->userInfo['regno'], $this->userInfo['password']);
                return $ok;
            } else {
                throw new Exception("Passwords do not match");
            }
        } else {
            throw new Exception("Wrong password");
        }
    }

    public function verifyPassword($password, $hash) {
        return crypt($password, $hash) === $hash;
    }

}
