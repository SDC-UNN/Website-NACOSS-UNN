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
require_once('AdminUtility.php');
require_once('class.Uploader.php');

class VideoUploader extends Uploader{
	/*
	This class extends the Uploader abstract class and adapts it for general documents
	ASSUMPTIONS
	1. The function MIME() assumes that the query returns some comma-seperated values from settings table
	*/
	function __construct($input_name, $output_file_name, $upload_directory){
		parent::__construct($input_name, $output_file_name);
		$this->setUploadDirectory($upload_directory);
		$this->setSupportedMIME_types(VideoUploader::MIME());
	}
	public static function MIME(){
		$link = AdminUtility::getDefaultDBConnection();
		$query = "select value from settings where name='MIME_videos'";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_array($result);
		$value = $row['value'];
		return explode(',', $value);
	}
}
?>