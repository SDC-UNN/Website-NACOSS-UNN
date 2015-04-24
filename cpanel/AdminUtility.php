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
        $trace = mysqli_escape_string($link, html_entity_decode($exc->getTraceAsString()));
        //Check if error has been logged previously
        $query = "select * from error_log where message = '$message' and trace='$trace'";
        $result = mysqli_query($link, $query);
        if ($result) {
            $row = mysqli_fetch_array($result);
        }
        //If previously logged, update time and set is-fixed = 0 else insert new log
        if ($result && $row) {
            $query = "update error_log set time_of_error = now(), is_fixed = 0 where id = '" . $row['id'] . "'";
        } else {
            $query = "insert into error_log set message = '$message', "
                    . "file=' $file', trace='$trace', line='$line', time_of_error = now()";
        }
        //Log error
        AdminUtility::logMySQLError($link);

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
    
    public static function uploadDocument(string $input_name, $output_file_name, string $upload_directory) {
        $file_url = "";
        // implementation

        return $file_url;
    }

    /*
      to resize image and create with imageUploader():
      set $resize = array('resize'=>true, 'width'=>200, 'height'=>400, 'jpeg_quality'=>90 );
      set $thumb_nail = array('create_thumb_nail'=>true, 'width'=>120, 'height'=>120, 'jpeg_quality'=>90 );
      call AdminUtility::uploadImage('input_name', 'output_name', 'upload_dir', $resize, $thumb_nail)
     */

    public static function uploadImage(string $input_name, $output_file_name, string $upload_directory, array $resize = array('resize' => false, 'width' => 0, 'height' => 0, 'jpeg_quality' => 90), array $thumb_nail = array('create_thumb_nail' => false, 'width' => 0, 'height' => 0, 'jpeg_quality' => 90)
    ) {
        $file_url = "";
        // implementation
        return $file_url;
    }

    public static function uploadVideo(string $input_name, $output_file_name, string $upload_directory) {
        $file_url = "";
        // implementation

        return $file_url;
    }

}
