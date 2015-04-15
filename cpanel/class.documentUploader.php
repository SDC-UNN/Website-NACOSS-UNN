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
require_once('class.uploader.php');

class documentUploader extends uploader{
	/*
	This class extends the uploader abstract class and adapts it for general documents
	ASSUMPTIONS
	1. MIME types in the array (below) are not exhaustive
		This can be made up for by calling setSupportedMIME_types() this way:
		setSupportedMIME_types(array_merge(getSupportedMIME_types(), $new_array_of_types)) to add more types
	*/
	function _construct(string $input_name, string $output_file_name, string $upload_directory){
		parent::_construct($input_name, $output_file_name);
		$this->setUploadDirectory($upload_directory);
		$this->setSupportedMIME_types(documentUploader::MIME());
	}
	public static function MIME(){
		return array(
			'text/plain',
			'text/html',
			'application/x-zip-compressed',
			'application/zip',
			'application/pdf',
			'application/msword',
			'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
			'application/vnd.ms-excel',
			'application/x-forcedownload'
			);
	}
}
?>