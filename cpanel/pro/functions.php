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


        const SORT_POST_TYPE_TIME_OF_POST = "time_of_post";
        const SORT_POST_TYPE_LAST_MODIFIED = "last_modified";
        const SORT_FAQ_TYPE_QUESTION = "question";
        const SORT_FAQ_TYPE_ANSWER = "answer";
        const ORDER_ASC = "ASC";
        const ORDER_DESC = "DESC";

function getTotalHeadlines() {
    $query = "select * from home_page_images";
    $link = AdminUtility::getDefaultDBConnection();
    $result = mysqli_query($link, $query);
    if ($result) {
        return mysqli_num_rows($result);
    }
    //Log error
    AdminUtility::logMySQLError($link);

    return 0;
}

function getTotalHits() {

    $query = "select sum(hits) as total from news";
    $link = AdminUtility::getDefaultDBConnection();
    $result = mysqli_query($link, $query);
    if ($result) {
        $row = mysqli_fetch_array($result);
        return $row['total'];
    }
    //Log error
    AdminUtility::logMySQLError($link);

    return 0;
}

function getTotalPosts() {
    $query = "select count(id) as total from news where is_deleted = 0";
    $link = AdminUtility::getDefaultDBConnection();
    $result = mysqli_query($link, $query);
    if ($result) {
        $row = mysqli_fetch_array($result);
        return $row['total'];
    }
    //Log error
    AdminUtility::logMySQLError($link);

    return 0;
}

function getFAQs($sort_type, $sort_order) {
    $FAQs = array();
    $query = "select * from faq";
    $link = AdminUtility::getDefaultDBConnection();
    $result = mysqli_query($link, $query);
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            $FAQs[] = $row;
        }
    }
    //Log error
    AdminUtility::logMySQLError($link);

    sortFAQs($FAQs, $sort_type, $sort_order);

    return $FAQs;
}

function getFAQ($id) {
    $query = "select * from faq where id='$id'";
    $link = AdminUtility::getDefaultDBConnection();
    $result = mysqli_query($link, $query);
    if ($result) {
        return mysqli_fetch_assoc($result);
    }
    //Log error
    AdminUtility::logMySQLError($link);

    return array();
}

function searchFAQs($search_query, $sort_type, $sort_order) {
    $link = AdminUtility::getDefaultDBConnection();
    if (empty($search_query)) {
        return getFAQs($sort_type, $sort_order);
    } else {
        $FAQs = array();
        //process query
        $fields = explode(" ", $search_query);
        $query = "select * from faq where ";

        for ($count = 0; $count < count($fields); $count++) {
            $query .= "question like '%$fields[$count]%' or "
                    . "answer like '%$fields[$count]%'";
            if ($count !== (count($fields) - 1)) {
                $query .= " or ";
            }
        }
        //Search
        $result = mysqli_query($link, $query);
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                array_push($FAQs, $row);
            }
        }

        sortFAQs($FAQs, $sort_type, $sort_order);
        //Log error
        AdminUtility::logMySQLError($link);

        return $FAQs;
    }
}

function sortFAQs(array &$FAQs, $sort_type, $sort_order) {
    if (empty($FAQs) || empty($sort_type) || empty($sort_order)) {
        return;
    }

    foreach ($FAQs as $key => $row) {
        $question[$key] = $row['question'];
        $answer[$key] = $row['answer'];
    }

    switch ($sort_type) {
        case SORT_FAQ_TYPE_ANSWER:
            array_multisort($answer, ($sort_order == ORDER_DESC ? SORT_DESC : SORT_ASC), $question, SORT_ASC, $FAQs);
            break;
        case SORT_FAQ_TYPE_QUESTION:
            array_multisort($question, ($sort_order == ORDER_DESC ? SORT_DESC : SORT_ASC), $answer, SORT_ASC, $FAQs);
            break;
        default :
            throw new Exception("Invalid sort type");
    }
}

function getPosts($sort_type, $sort_order) {
    $posts = array();
    $query = "select * from news where is_deleted = 0 order by time_of_post DESC";
    $link = AdminUtility::getDefaultDBConnection();
    $result = mysqli_query($link, $query);
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            $posts[] = $row;
        }
    }
    //Log error
    AdminUtility::logMySQLError($link);

    sortPosts($posts, $sort_type, $sort_order);

    return $posts;
}

function getPost($id) {
    $query = "select * from news where id='$id' and is_deleted = 0";
    $link = AdminUtility::getDefaultDBConnection();
    $result = mysqli_query($link, $query);
    if ($result) {
        return mysqli_fetch_assoc($result);
    }
    //Log error
    AdminUtility::logMySQLError($link);

    return array();
}

function searchPosts($search_query, $sort_type, $sort_order) {
    $link = AdminUtility::getDefaultDBConnection();
    if (empty($search_query)) {
        return getPosts($sort_type, $sort_order);
    } else {
        $posts = array();
        //process query
        $fields = explode(" ", $search_query);
        $query = "select * from news where is_deleted = 0 and (";

        for ($count = 0; $count < count($fields); $count++) {
            $query .= "title like '%$fields[$count]%'";
            if ($count !== (count($fields) - 1)) {
                $query .= " or ";
            } else {
                $query .= ")";
            }
        }
        //Search
        $result = mysqli_query($link, $query);
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                array_push($posts, $row);
            }
        }

        sortPosts($posts, $sort_type, $sort_order);
        //Log error
        AdminUtility::logMySQLError($link);

        return $posts;
    }
}

function sortPosts(array &$posts, $sort_type, $sort_order) {
    if (empty($posts) || empty($sort_type) || empty($sort_order)) {
        return;
    }

    foreach ($posts as $key => $row) {
        $time_of_post[$key] = $row['time_of_post'];
        $last_modified[$key] = $row['last_modified'];
    }

    switch ($sort_type) {
        case SORT_POST_TYPE_TIME_OF_POST:
            array_multisort($time_of_post, ($sort_order == ORDER_DESC ? SORT_DESC : SORT_ASC), $last_modified, SORT_DESC, $posts);
            break;
        case SORT_POST_TYPE_LAST_MODIFIED:
            array_multisort($last_modified, ($sort_order == ORDER_DESC ? SORT_DESC : SORT_ASC), $time_of_post, SORT_DESC, $posts);
            break;
        default :
            throw new Exception("Invalid sort type");
    }
}

function getLargeHomePageImages() {
    $array = array();
    $query = "select * from home_page_images where size = 'LARGE'";
    $link = AdminUtility::getDefaultDBConnection();
    $result = mysqli_query($link, $query);
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            array_push($array, $row);
        }
    } else {
        //Log error            
        AdminUtility::logMySQLError($link);
    }
    return $array;
}

function getSmallHomePageImages() {
    $array = array();
    $query = "select * from home_page_images where size = 'SMALL'";
    $link = AdminUtility::getDefaultDBConnection();
    $result = mysqli_query($link, $query);
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            array_push($array, $row);
        }
    } else {
        //Log error            
        AdminUtility::logMySQLError($link);
    }
    return $array;
}

function createThumbnail($img_url) {
    ############ Configuration ##############
    $max_image_size = 100; //Maximum image size (height and width)
    $thumb_prefix = "thumb_"; //Normal thumb Prefix
    $relative_destination_folder = "/uploads/news/images/";
    $destination_folder = filter_input(INPUT_SERVER, "DOCUMENT_ROOT") . SITE_FOLDER . $relative_destination_folder;
    $jpeg_quality = 90; //jpeg quality
    ##########################################

    $image_temp = filter_input(INPUT_SERVER, "DOCUMENT_ROOT") . $img_url;
    $image_size_info = getimagesize($image_temp); //get image size

    if (!empty($img_url)) {
        if ($image_size_info) {
            $image_width = $image_size_info[0]; //image width
            $image_height = $image_size_info[1]; //image height
            $image_type = $image_size_info['mime']; //image type
        } else {
            throw new Exception("Make sure image file is valid!");
        }
    } else {
        throw new Exception("No image url specified");
    }

    //switch statement below checks allowed image type 
    //as well as creates new image from given file 
    switch ($image_type) {
        case 'image/png':
            $image_res = imagecreatefrompng($image_temp);
            break;
        case 'image/gif':
            $image_res = imagecreatefromgif($image_temp);
            break;
        case 'image/jpeg': case 'image/pjpeg':
            $image_res = imagecreatefromjpeg($image_temp);
            break;
        default:
            $image_res = false;
    }

    if ($image_res) {
        //Get file extension and name to construct new file name 
        $image_info = pathinfo($image_temp);
        $image_extension = strtolower($image_info["extension"]); //image extension
        $image_name_only = strtolower($image_info["filename"]); //file name only, no extension
        //create a name for new image (Eg: thumbPrefix_fileName.jpg) ;
        $new_file_name = $thumb_prefix . $image_name_only . '.' . $image_extension;

        //folder path to save thumbnails
        $thumb_save_folder = $destination_folder . $new_file_name;

        //call normal_resize_image() function to proportionally resize image
        normal_resize_image($image_res, $thumb_save_folder, $image_type, $max_image_size, $image_width, $image_height, $jpeg_quality);


        imagedestroy($image_res); //freeup memory
        //Return http url for reading image
        return $relative_destination_folder . $new_file_name;
    }

    return "#";
}

function checkDimension($img_url, $size) {
    $image_temp = filter_input(INPUT_SERVER, "DOCUMENT_ROOT") . $img_url;
    if (!empty($img_url)) {
        $image_size_info = getimagesize($image_temp); //get image size

        if ($image_size_info) {
            $image_width = $image_size_info[0]; //image width
            $image_height = $image_size_info[1]; //image height
        } else {
            throw new Exception("Make sure image file is valid!");
        }
    } else {
        throw new Exception("No image url specified");
    }

    switch ($size) {
        case "SMALL" :
            if ($image_width === $image_height) { //Square image
                return $image_width >= 230; //Minimum of 230px
            }
        case "LARGE":
            if ($image_width > $image_height + 100) { //Landscape image
                return $image_width >= 700 && $image_height >= 400; //Minimum width 700 and height 400
            }
        default :
            throw new Exception("Invalid size");
    }

    return false;
}

#####  This function will proportionally resize image ##### 

function normal_resize_image($source, $destination, $image_type, $max_size, $image_width, $image_height, $quality) {

    if ($image_width <= 0 || $image_height <= 0) {
        return false;
    } //return false if nothing to resize
    //do not resize if image is smaller than max size
    if ($image_width <= $max_size && $image_height <= $max_size) {
        if (save_image($source, $destination, $image_type, $quality)) {
            return true;
        }
    }

    //Construct a proportional size of new image
    $image_scale = min($max_size / $image_width, $max_size / $image_height);
    $new_width = ceil($image_scale * $image_width);
    $new_height = ceil($image_scale * $image_height);

    $new_canvas = imagecreatetruecolor($new_width, $new_height); //Create a new true color image
    //Copy and resize part of an image with resampling
    if (imagecopyresampled($new_canvas, $source, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height)) {
        save_image($new_canvas, $destination, $image_type, $quality); //save resized image
    }

    return true;
}

##### Saves image resource to file ##### 

function save_image($source, $destination, $image_type, $quality) {
    switch (strtolower($image_type)) {//determine mime type
        case 'image/png':
            imagepng($source, $destination);
            return true; //save png file
        case 'image/gif':
            imagegif($source, $destination);
            return true; //save gif file
        case 'image/jpeg':
        case 'image/pjpeg':
            imagejpeg($source, $destination, $quality);
            return true; //save jpeg file
        default: return false;
    }
}
