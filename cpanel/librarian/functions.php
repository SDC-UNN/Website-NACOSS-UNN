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

	  const SORT_LIBRARY_TYPE_TITLE = "title";
	  const SORT_LIBRARY_TYPE_AUTHOR = "author";
	  const SORT_LIBRARY_TYPE_KEYWORD = "keywords";
	  const SORT_LIBRARY_TYPE_DATE_ADDED = "date_added";
	  const SORT_LIBRARY_TYPE_FILE_TYPE = "file_type";
	  const ORDER_LIBRARY_ASC = "ASC";
	  const ORDER_LIBRARY_DESC = "DESC";

	  const SETTINGS_FILE_TYPES_VIDEOS = "fileTypes_video";
	  const SETTINGS_FILE_TYPES_EBOOKS = "fileTypes_ebook";

function getNumberOfLibraryItems($media='ebook'){
	$supported_media_types = getFileTypes($media);
    $query = "select * from library ";
	if(sizeof($supported_media_types)){$query .= "where (file_type = '".implode("' or file_type = '", $supported_media_types)."')";}
    $link = AdminUtility::getDefaultDBConnection();
    $result = mysqli_query($link, $query);
    if ($result) {
        return mysqli_num_rows($result);
    }
    //Log error
    AdminUtility::logMySQLError($link);

    return 0;
}

function getNumberOfLibraryItemsDownloaded($media='ebook',$file_ID = null){
	$supported_media_types = getFileTypes($media);
    $query = "select num_of_downloads from library ";
	if(sizeof($supported_media_types)){$query .= " where(file_type = '".implode("' or file_type = '", $supported_media_types)."')";}
	if($file_ID !== null){$query .= " and id=".$file_ID;}
    $link = AdminUtility::getDefaultDBConnection();
    $result = mysqli_query($link, $query);
    if ($result) {
		$downloads = 0;
		while($row = mysqli_fetch_array($result)){ $downloads += (int)$row['num_of_downloads']; } 
        return $downloads;
    }
    //Log error
    AdminUtility::logMySQLError($link);

    return 0;
}


function getLibraryItems($media='ebook', $on_shelf=1) {
	$supported_media_types = getFileTypes($media);
    $items = array();
    $query = "select * from library where on_shelf = $on_shelf ";
	if(sizeof($supported_media_types)){$query .= "and (file_type = '".implode("' or file_type = '", $supported_media_types)."')";}
    $link = AdminUtility::getDefaultDBConnection();
    $result = mysqli_query($link, $query);
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            $items[] = $row;
        }
        sortLibraryItems($items, SORT_LIBRARY_TYPE_TITLE, ORDER_LIBRARY_ASC);
    }
    //Log error
    AdminUtility::logMySQLError($link);

    return $items;
}

/**
 * 
 * @param type $search_query
 * @param type $sort_type
 * @param type $sort_order
 * @return array
 */
function searchLibraryItems($search_query, $media='ebook',  $on_shelf=1, $sort_type = null, $sort_order = null){
	$supported_media_types = getFileTypes($media);
    $items = array();
    $link = AdminUtility::getDefaultDBConnection();
    //process query
    $fields = explode(" ", $search_query);
    $query = "select * from library where on_shelf = $on_shelf and (";
    for ($count = 0; $count < count($fields); $count++) {
        $query .= "title like '%$fields[$count]%' or "
                . "author like '%$fields[$count]%' or "
                . "keywords like '%$fields[$count]%'";
        if ($count !== (count($fields) - 1)) {
            $query .= " or ";
        }
    }
	$query .= ")";
	if(sizeof($supported_media_types)){$query .= " and (file_type = '".implode("' or file_type = '", $supported_media_types)."')";}
	//Search
    $result = mysqli_query($link, $query);
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            array_push($items, $row);
        }
        sortLibraryItems($items, $sort_type, $sort_order);
    }
    //Log error
    AdminUtility::logMySQLError($link);

    return $items;
}

function sortLibraryItems(array &$items, $sort_type, $sort_order) {
    if (empty($items)) {
        return;
    }

    foreach ($items as $key => $row) {
        $id[$key] = $row['id'];
        $title[$key] = $row['title'];
        $author[$key] = $row['author'];
        $keywords[$key] = $row['keywords'];
        $date_added[$key] = $row['date_added'];
        $link[$key] = $row['link'];
        $file_type[$key] = $row['file_type'];
    }

    switch ($sort_type) {
        case SORT_LIBRARY_TYPE_TITLE:
            array_multisort($title, ($sort_order == ORDER_LIBRARY_DESC ? SORT_DESC : SORT_ASC), $items);
            break;
        case SORT_LIBRARY_TYPE_AUTHOR:
            array_multisort($author, ($sort_order == ORDER_LIBRARY_DESC ? SORT_DESC : SORT_ASC), $title, SORT_ASC, $items);
            break;
        case SORT_LIBRARY_TYPE_FILE_TYPE:
            array_multisort($file_type, ($sort_order == ORDER_LIBRARY_DESC ? SORT_DESC : SORT_ASC), $title, SORT_ASC, $author, SORT_ASC, $items);
            break;
        default :
            throw new Exception("Invalid sort type");
    }
}

function getFileTypes($media = 'ebook'){
	$name = ($media == 'ebook')? SETTINGS_FILE_TYPES_EBOOKS : SETTINGS_FILE_TYPES_VIDEOS;
    $types = array();
    $query = "select value from settings where name ='$name'";
    $link = AdminUtility::getDefaultDBConnection();
    $result = mysqli_query($link, $query);
    if ($result) {
        $row = mysqli_fetch_array($result);
		$field = $row['value'];
        $types = explode(',', $field);
        }
    //Log error
    AdminUtility::logMySQLError($link);

    return $types;
}

function suspendLibraryItems(array $IDs) {
    $link = AdminUtility::getDefaultDBConnection();
    mysqli_autocommit($link, false);
    foreach ($IDs as $value) {
        $query = "update library set on_shelf = 0 where id = $value";
        $ok = mysqli_query($link, $query);
        if (!$ok) {
            //Log error
            AdminUtility::logMySQLError($link);
            return FALSE;
        }
    }
    return mysqli_commit($link);
}

function restoreLibraryItems(array $IDs) {
    $link = AdminUtility::getDefaultDBConnection();
    mysqli_autocommit($link, false);
    foreach ($IDs as $value) {
        $query = "update library set on_shelf = 1 where id = $value";
        $ok = mysqli_query($link, $query);
        if (!$ok) {
            //Log error
            AdminUtility::logMySQLError($link);
            return FALSE;
        }
    }
    return mysqli_commit($link);
}

function deleteLibraryItems(array $IDs) {
    $link = AdminUtility::getDefaultDBConnection();
    mysqli_autocommit($link, false);
    foreach ($IDs as $value) {
        $query = "delete from library where id=$value";
        $ok = mysqli_query($link, $query);
        if (!$ok) {
            //Log error
            AdminUtility::logMySQLError($link);
            return FALSE;
        }else{
			//delete file from local server
		}
    }
    return mysqli_commit($link);
}

?>