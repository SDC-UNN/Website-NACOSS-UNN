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
abstract class uploader{
	/*
	This is a base class for file upload; can be extended for various categories of files e.g documents, images, videos, etc.
	ASSUMPTIONS
	1. Max upload size is 50 MB i.e max upload size for most apeche servers
	2. MIME types in the array (below) are not exhaustive
		This can be made up for by calling setSupportedMIME_types() this way:
		setSupportedMIME_types(array_merge(getSupportedMIME_types(), $new_array_of_types)) to add more types
	*/
	private $name;
	private $size;
	private $tmp_name;
	private $extension;
	private $MIME_type;
	private $full_output_file_name;
	private $upload_directory;
	private $max_file_size;
	private $supported_MIME_types;
	
	function _construct(string $input_name, string $output_file_name){
		if(strlen($input_name) and ($_FILES[$input_name]["error"]== UPLOAD_ERR_OK)){
			$this->name = $_FILES[$input_name]['name'];
			$this->size = $_FILES[$input_name]['size'];
			$this->tmp_name = $_FILES[$input_name]['tmp_name'];
			$this->extension = substr($this->name, strrpos($this->name, '.') );
			$this->MIME_type = $_FILES[$input_name]['type'];
			$this->setOutputFileName($this->name, $this->extension);
			$this->setMaxFileSize(uploader::uploadLimit());
		}else{
			die('Some errors were encountered while uploading file!');
		}
	}
	protected function setOutputFileName(string $name, string $extension){
		if(strlen($name) and strlen($extension)){
			$this->full_output_file_name = $name.'.'.$extension;
		}else{die('Invalid file output filename or invalid extension for input file');}
	}
	protected function setUploadDirectory(string $dir){
		if(is_dir($dir)){$this->upload_directory = $dir;}else{die($dir.' is not a directory');}
	}
	public function setSupportedMIME_types(array $new_types){
		if(!empty($new_types)){$this->supported_MIME_types = $new_types;}else{die('MIME Type Not Set');}
	}
	public function setMaxFileSize(int $new_size){
		if($new_size>0 and $new_size < uploader::uploadLimit()){$this->max_file_size = $new_size;}else{die('Invalid file size set');}
	}
	public function upload(){
		if(($this->getSize() <= $this->getMaxFileSize()) and in_array($this->getMIME(), $this->getSupportedMIME_types()) ){
			move_uploaded_file($this->tmp_name,($this->upload_directory).($this->full_output_file_name));
		}else{
			die('File size too large or type not supported.');
		}
	}
	public function getSupportedMIME_types(){
		return $this->supported_MIME_types;
	}
	public function getMaxFileSize(){
		return $this->max_file_size;
	}
	public function getName(){
		return $this->name;
	}
	public function getSize(){
		return $this->size;
	}
	public function getMIME(){
		return $this->MIME_type;
	}
	public function getExtension(){
		return $this->extension;
	}
	public static function uploadLimit(){
		return (ini_get('post_max_size') * 1024 * 1024) - 1024;
	}
}
?>