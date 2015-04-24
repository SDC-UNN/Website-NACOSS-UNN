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

function createThumbnail(string $img_url, string $size) {
    if (file_exists($img_url)) {
        
    }
    return "";
}

function checkDimension(string $img_url) {
    if (file_exists($img_url)) {
        
    }
    return "";
}
