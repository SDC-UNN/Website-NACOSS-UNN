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
require_once('class_lib.php');
require_once('class.uploader.php');

class AnyFileUploader extends Uploader {

    function __construct($input_name, $output_file_name, $upload_directory = LIBRARY_UPLOAD_DIR) {
        parent::__construct($input_name, $output_file_name);
        $this->setUploadDirectory($upload_directory);
        $this->setSupportedMIME_types(AnyFileUploader::MIME());
    }

    public static function MIME() {
        $array = array();
        $query = "select value from settings where name='MIME_ebooks' or name='MIME_videos'";
        $link = AdminUtility::getDefaultDBConnection();
        $result = mysqli_query($link, $query);
        while ($row = mysqli_fetch_array($result)) {
            $value = $row['value'];
            $array = array_merge($array, explode(',', $value));
        }
        return $array;
    }

}
