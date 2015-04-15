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
class libraryItem{
	private $DB_CON;
	private $id;
	private $title;
	private $author;
	private $publisher;
	private $date_published;
	private $isbn;
	private $category;
	private $sub_category;
	private $keywords;
	private $contributor;
	private $date_added;
	private $file_type;
	private $url;
	private $num_of_downloads;
	private $on_shelf;
	
	function _construct($seed){
		$this->DB_CON = AdminUtility::getDefaultDBConnection();
		$link = $this->DB_CON;
		$query = "select from library where id = '$seed'";
		$result = mysqli_query($link, $query);
		if(mysqli_num_rows($result)){
			$row = mysqli_fetch_array($result);
		}
	}
	
	private function newItem(){
		$link = $this->DB_CON;
		$query = "insert into library(id) values(NULL)";
		$result = mysqli_query($link, $query);
	    if($result){
        	$query2 = "select LAST_INSERT_ID()";
			$result = mysqli_query($link, $query2);
			$row = mysqli_fetch_array($result);
			return $row['LAST_INSERT_ID()'];
    	}
	    //Log error
    	AdminUtility::logMySQLError($link);
    	exit;;
	}
}
?>