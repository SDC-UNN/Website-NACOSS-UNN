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

abstract class Uploader {
    /*
      This is a base class for file upload; can be extended for various categories of files e.g documents, images, videos, etc.
      ASSUMPTIONS
      1. Max upload size is 50 MB i.e max upload size for most apeche servers
     */

    private $name;
    private $size;
    private $tmp_name;
    private $extension;
    private $MIME_type;
    private $full_output_file_name;
    private $upload_directory;
    private $max_file_size;
    private $supported_MIME_types = array();

    function __construct($input_name, $output_file_name) {
        if ($_FILES[$input_name]["error"] == UPLOAD_ERR_OK) {
            $this->name = $_FILES[$input_name]['name'];
            $this->size = $_FILES[$input_name]['size'];
            $this->tmp_name = $_FILES[$input_name]['tmp_name'];
            $var = explode('.', $this->name);
            $this->extension = $var[sizeof($var) - 1];
            $this->MIME_type = $_FILES[$input_name]['type'];
            $this->setOutputFileName($output_file_name, $this->extension);
            $this->setMaxFileSize(Uploader::uploadLimit());
        } else {
            throw new Exception('Some errors were encountered while uploading file!');
        }
    }

    protected function setOutputFileName($name, $extension) {
        if (strlen($name) and strlen($extension)) {
            $this->full_output_file_name = $name . '.' . $extension;
        } else {
            throw new Exception('Invalid file output filename or invalid extension for input file');
        }
    }

    /**
     * 
     * @param type $dir directory where file will be upoaded, relative to document root
     * @throws Exception
     */
    protected function setUploadDirectory($dir) {
        if (is_dir(ROOT . $dir)) {
            $this->upload_directory = $dir;
        } else {
            throw new Exception($dir . ' is not a directory');
        }
    }

    public function setSupportedMIME_types(array $new_types) {
        if (!empty($new_types)) {
            $this->supported_MIME_types = $new_types;
        } else {
            throw new Exception('MIME Type Not Set');
        }
    }

    public function setMaxFileSize($new_size) {
        if ($new_size > 0 and $new_size <= Uploader::uploadLimit()) {
            $this->max_file_size = $new_size;
        } else {
            throw new Exception('Invalid file size set');
        }
    }

    public function upload() {
        if (!($this->getSize() <= $this->getMaxFileSize())) {
            throw new Exception('File size too large: ' . $this->getSize() . '. Max size allowed: ' . $this->getMaxFileSize());
        } elseif (!in_array($this->getMIME(), $this->getSupportedMIME_types())) {
            throw new Exception('Unsupported file type: ' . $this->getMIME());
        } else {
            return move_uploaded_file($this->tmp_name, (ROOT . $this->upload_directory . $this->full_output_file_name));
        }
    }

    public function getFileLink() {
        return $this->upload_directory . $this->full_output_file_name;
    }

    public function getSupportedMIME_types() {
        return $this->supported_MIME_types;
    }

    public function getMaxFileSize() {
        return $this->max_file_size;
    }

    public function getName() {
        return $this->name;
    }

    public function getSize() {
        return $this->size;
    }

    public function getMIME() {
        return $this->MIME_type;
    }

    public function getExtension() {
        return $this->extension;
    }

    public static function uploadLimit() {
        return (ini_get('post_max_size') * 1024 * 1024) - 1024;
    }

}
