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
class LibraryItem{
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
	
	function __construct($seed){
		$this->DB_CON = AdminUtility::getDefaultDBConnection();
		$link = $this->DB_CON;
		if(is_array($seed)){
			$this->id = $this->newItem();
			//set attributes from input
			$this->setAllFields($seed);
			$this->num_of_downloads = 0;
		}elseif(strlen($seed)){
			$query = "select from library where id = '$seed'";
			$result = mysqli_query($link, $query);
			if(mysqli_num_rows($result)){
				$row = mysqli_fetch_array($result);
				//set attributes from db
				$this->setAllFields($row);
				$this->num_of_downloads = $row['num_of_downloads'];
			}else{
				die('Invalid file id');
			}
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
	
	public function setAllFields(array $row){
		$this->setTitle($row['title']);
		$this->setAuthor($row['author']);
		$this->setPublisher($row['publisher']);
		$this->setDateOfPublication($row['date_published']);
		$this->setISBN($row['isbn']);
		$this->setCategory($row['category']);
		$this->setSubCategory($row['sub_category']);
		$this->setKeywords($row['keywords']);
		$this->setContributor($row['contributor']);
		$this->setDateAdded($row['date_added']);
		$this->setFileType($row['file_type']);
		$this->setURL($row['link']);
		$this->setOnShelf($row['on_shelf']);
	}
	
	public function saveItem(){
		$link = $this->DB_CON;
		$query = "update library set 
			title = '". $this->getTitle() ."',
			author = '". $this->getAuthor() ."',
			publisher = '". $this->getPublisher() ."',
			date_published = '". $this->getDateOfPublication() ."',
			isbn = '". $this->getISBN() ."',
			category = '". $this->getCategory() ."',
			sub_category = '". $this->getSubCategory() ."',
			keywords = '". $this->getKeywords() ."',
			contributor = '". $this->getContributor() ."',
			date_added = '". $this->getDateAdded() ."',
			file_type = '". $this->getFileType() ."',
			link = '". $this->getURL() ."',
			on_shelf = ". $this->is_onShelf() ."
			where id = ". $this->getID();

		$result = mysqli_query($link, $query);
	    if($result){
			return true;
    	}
	    //Log error
    	AdminUtility::logMySQLError($link);
    	exit;;
	}
	
	public function getID(){
		return $this->id;
	}
	
	public function setTitle($title){
		$this->title = strlen($title) ? $title : die('Please supply valid title');
	}
	
	public function getTitle(){
		return $this->title;
	}
	
	public function setAuthor($author){
		$this->author = strlen($author) ? $author : die('Please supply valid author');
	}
	
	public function getAuthor(){
		return $this->author;
	}
	
	public function setPublisher($publisher){
		$this->publisher = strlen($publisher) ? $publisher : die('Please supply valid publisher');
	}
	
	public function getPublisher(){
		return $this->publisher;
	}
	
	public function setDateOfPublication($date_published){
		$this->date_published = strlen((string)$date_published)==4 ? $date_published : die('Please supply 4 digit number for year of publication');
	}
	
	public function getDateOfPublication(){
		return $this->date_published;
	}
	
	public function setISBN($isbn){
		$this->isbn = strlen($isbn) ? $isbn : '';
	}
	
	public function getISBN(){
		return $this->isbn;
	}
	
	public function setCategory($category){
		$this->category = strlen($category) ? $category : die('Please set valid category');
	}
	
	public function getCategory(){
		return $this->category;
	}
	
	public function setSubCategory($sub_category){
		$this->sub_category = strlen($sub_category) ? $sub_category : die('Please set valid sub-category');
	}
	
	public function getSubCategory(){
		return $this->sub_category;
	}
	
	public function setKeywords($keywords){
		$this->keywords = strlen($keywords) ? $keywords : implode(' , ', explode(' ',$this->title) );
	}

	public function getKeywords(){
		return $this->keywords;
	}
	
	public function setContributor(Admin $AdminObj){
		$this->contributor = $AdminObj->getAdminID() !=="" ? $AdminObj->getAdminID() : 'Guest';
	}
	
	public function getContributor(){
		return $this->contributor;
	}
	
	public function setDateAdded($mktime){
		$this->date_added = $mktime > 0 ? date('Y-m-d h-i-s', $mktime) : date('Y-m-d h-i-s', mktime());
	}
	
	public function getDateAdded(){
		return $this->date_added;
	}
	
	public function setFileType($type){
		$this->file_type = $type;
	}
	
	public function getFileType(){
		return $this->file_type;
	}
	
	public function setURL($url){
		if(fopen($url,'r')){ $this->url = $url; return true;}else{die('<span style="color:red">URL does not exist.</span>');}
	}
	
	public function getURL(){
		if(fopen($this->url,'r')){ return $this->url; }else{}
	}
	
	public function download(){
		$link = AdminUtility::getDefaultDBConnection();
		///
	}
		
	public function getNumOfDownloads(){
		return $this->num_of_downloads;
	}
	
	public function setOnShelf($status){
		$status === 0 ? $this->on_shelf = 0 : $this->on_shelf = 1; 
	}
	
	public function is_onShelf(){
		return $this->on_shelf;
	}
	
	function _destruct(){
		$this->saveItem();
	}
}
?>