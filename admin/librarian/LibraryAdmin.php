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

require_once('../class_lib.php');
require_once('../class.anyFileUploader.php');

class LibraryAdmin extends Admin {

    public function uploadFile($array) {
        if (!empty($array["title"])) {

            //Detect type
            if (empty($_FILES["FileInput"]['size']) && empty($array["LinkInput"])) {
                throw new Exception("Set either a file source or link");
            } elseif (empty($_FILES["FileInput"]['size'])) {
                $is_link = true;
            } elseif (empty($array["LinkInput"])) {
                $is_link = false;
            } else {
                //Both set
                throw new Exception("Set either a file source or link not both");
            }

            //Upload
            if (!$is_link) {
                $uploader = new AnyFileUploader("FileInput", $array["title"]);
                $ok = $uploader->upload();
                $error = $ok ? "" : "Oops! Something went wrong! Upload failed";
            } else {
                $ok = filter_var($array["LinkInput"], FILTER_VALIDATE_URL);
                $error = $ok ? "" : "Invalid link";
            }

            if ($error) {
                throw new Exception($error);
            }

            //Save meta data
            $link = AdminUtility::getDefaultDBConnection();
            $query = "insert into library set "
                    . "title = '{$array['title']}', "
                    . "author = '{$array['author']}', "
                    . "publisher = '{$array['publisher']}', "
                    . "date_published = '{$array['date_published']}', "
                    . "isbn = '{$array['isbn']}', "
                    . "category = '{$array['category']}', "
                    . "sub_category = '{$array['sub_category']}', "
                    . "keywords = '{$array['keywords']}', "
                    . "contributor = '{$array['contributor']}', "
                    . "file_type = '" . (isset($uploader) ? $uploader->getExtension() : 'link') . "', "
                    . "link = '" . (isset($uploader) ? $uploader->getFileLink() : $array['LinkInput']) . "'";
            $res = mysqli_query($link, $query);
            AdminUtility::logMySQLError($link);
            return $res ? "Upload Successful!" : "Oops! Something went wrong. Database didn't respond very well";
        } else {
            throw new Exception("Title not set");
        }
    }

    public function uploadZip() {
        $form_name = "zipFile";
        $uploaded_files = array();
        $path = $_FILES[$form_name]["tmp_name"];
        $zip = new ZipArchive;
        if ($zip->open($path) === true) {
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $fname = $zip->getNameIndex($i);
                $finfo = pathinfo($fname);
                $uploded = false;
                if (isset($finfo['extension'])) { //If its a file
                    $name = str_replace("_", " ", $finfo['filename']);
                    $fileinfo = explode("-by-", $name);
                    if (!file_exists(ROOT . LIBRARY_UPLOAD_DIR . $finfo['basename'])) {
                        $link = AdminUtility::getDefaultDBConnection();
                        $query = "insert into library set "
                                . "title='{$fileinfo[0]}', "
                                . (isset($fileinfo[1]) ? "author='{$fileinfo[1]}', " : "")
                                . "file_type='{$finfo['extension']}', "
                                . "link ='" . (LIBRARY_UPLOAD_DIR . $finfo['basename']) . "'";
                        mysqli_query($link, $query);
                        AdminUtility::logMySQLError($link);
                        $uploded = copy("zip://" . $path . "#" . $fname, ROOT . LIBRARY_UPLOAD_DIR . $finfo['basename']);
                        $message = $uploded ? "sucessful" : "failed";
                    } else {
                        $message = "already exists";
                    }
                } else {
                    $message = "not a file";
                }
                array_push($uploaded_files, ($fname . " : " . $message));
            }
            $zip->close();
        } else {
            throw new Exception("Failed to open file");
        }
        return $uploaded_files;
    }

    public function getLibrarySettings() {
        $settings = array();
        $query = "select * from settings where name LIKE '%video%' or name LIKE '%ebook%'";
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

    public function updateSettingsTable(array $array) {
        if (count($array) > 0) {
            $link = AdminUtility::getDefaultDBConnection();
            mysqli_autocommit($link, false);
            $ok = true;
            foreach ($array as $key => $value) {
                /*            if (strcasecmp($key, "help_lines") === 0) {
                  validateNumbers($value);
                  }

                 */ $query = "update settings set value = '$value' where name = '$key'";
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

}
