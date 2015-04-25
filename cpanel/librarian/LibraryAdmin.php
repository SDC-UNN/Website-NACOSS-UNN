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
require_once('../Admin.php');
require_once('../class.DocumentUploader.php');
require_once('../class.VideoUploader.php');
require_once('class.LibraryItem.php');

class LibraryAdmin extends Admin{
	
	public function addLibraryItem($array){
  	////process form input
	  if(strlen($array['file_source_type']) and strlen($array['media'])){
		  //handle the event of link input for file source
		  if($array['file_source_type'] == 'LinkInput' and strlen($array['LinkInput'])){
			  if(is_file($array['LinkInput'])){
				  $var = explode('.', $array['LinkInput']);
				  $extension = $var[sizeof($var)-1];
				  //create library item with link field = $array['LinkInput']
				  $array['contributor'] = new LibraryAdmin();
				  $array['date_added'] = mktime();
				  $array['file_type'] = $extension;
				  $array['link'] = $array['LinkInput'];
				  //$array['num_of_downloads'] = 0; implicitly determined
				  $array['on_shelf'] = 1; //yes place on shelf
				  $libraryItem = new LibraryItem($array);
				  $libraryItem->saveItem();
				  echo('<b style="color:green">New Library Item Created</b>');
				  exit;
			  }
		  }elseif($array['file_source_type'] == 'FileInput' and isset($_FILES['FileInput']) ){
			  $upload_dir = '../../uploads/';
			  $file = in_array($array['media'], DocumentUploader::MIME() ) ?
			  new DocumentUploader('FileInput', uniqid(mktime()), $upload_dir) :
			  new VideoUploader('FileInput', uniqid(mktime()), $upload_dir);
  
			  $array['contributor'] = new Admin();
			  $array['date_added'] = mktime();
			  $array['file_type'] = $file->getExtension();
			  $array['link'] = $file->getFileLink();
			  //$array['num_of_downloads'] = 0; implicitly determined
			  $array['on_shelf'] = 1; //yes place on shelf
			  if($file->upload()){
				  $libraryItem = new LibraryItem($array);
				  if($libraryItem->saveItem())
				  echo '<b style="color:green">New Library Item Created</b>';
			  }
			  else{
				  echo '<b style="color:red">An Error Occured: Item was not created</b>';
				  }
		  }else{
			  echo '<b style="color:red">No file selected.</b>';
		  }
	  }
		
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
	
	*/            $query = "update settings set value = '$value' where name = '$key'";
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