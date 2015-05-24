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

class NewsAdmin extends Admin {

    public function deletePosts($postIds) {
        $link = AdminUtility::getDefaultDBConnection();
        mysqli_autocommit($link, false);
        foreach ($postIds as $value) {
            $query = "update news set is_deleted = 1 where id='$value'";
            $ok = mysqli_query($link, $query);
            if (!$ok) {
                //Log error
                AdminUtility::logMySQLError($link);
                return FALSE;
            }
        }
        return mysqli_commit($link);
    }

    public function newPost($title, $content, $expire_time) {
        $link = AdminUtility::getDefaultDBConnection();
        $check_query = "select * from news where title='$title' and expire_time='$expire_time'";
        $check_result = mysqli_query($link, $check_query);
        if (!$check_result) {
            //Log error
            AdminUtility::logMySQLError($link);
            throw new Exception("Oops! Something went wrong");
        }
        if (mysqli_num_rows($check_result) > 0) {
            throw new Exception("Post already exists");
        }

        $query = "insert into news set title='" . mysqli_escape_string($link, $title) . "', "
                . "content='" . mysqli_escape_string($link, $content) . "', "
                . "last_modified = now(), expire_time='$expire_time'";
        $result = mysqli_query($link, $query);
        //Log error
        AdminUtility::logMySQLError($link);

        return $result;
    }

    public function modifyPost($id, $title, $content, $expire_time) {
        $link = AdminUtility::getDefaultDBConnection();
        $query = "update news set title='" . mysqli_escape_string($link, $title) . "', "
                . "content='" . mysqli_escape_string($link, $content) . "', "
                . "expire_time='" . mysqli_escape_string($link, $expire_time) . "', "
                . "last_modified=now() "
                . "where id = '$id'";
        $result = mysqli_query($link, $query);
        //Log error
        AdminUtility::logMySQLError($link);

        return $result;
    }

    public function deleteFAQs($faqIds) {
        $link = AdminUtility::getDefaultDBConnection();
        mysqli_autocommit($link, false);
        foreach ($faqIds as $value) {
            $query = "delete from faq where id='$value'";
            $ok = mysqli_query($link, $query);
            if (!$ok) {
                //Log error
                AdminUtility::logMySQLError($link);
                return FALSE;
            }
        }
        return mysqli_commit($link);
    }

    public function newFAQ($question, $answer) {
        $link = AdminUtility::getDefaultDBConnection();
        $check_query = "select * from faq where question='" . mysqli_escape_string($link, $question) . "'";
        $check_result = mysqli_query($link, $check_query);
        if (!$check_result) {
            //Log error
            AdminUtility::logMySQLError($link);
            throw new Exception("Oops! Something went wrong");
        }
        if (mysqli_num_rows($check_result) > 0) {
            throw new Exception("Question already exists");
        }

        $query = "insert into faq set question='" . mysqli_escape_string($link, $question) . "', "
                . "answer='" . mysqli_escape_string($link, $answer) . "'";
        $result = mysqli_query($link, $query);
        //Log error
        AdminUtility::logMySQLError($link);

        return $result;
    }

    public function modifyFAQ($id, $question, $answer) {
        $link = AdminUtility::getDefaultDBConnection();
        $query = "update faq set question='" . mysqli_escape_string($link, $question) . "', "
                . "answer='" . mysqli_escape_string($link, $answer) . "' where id = '$id'";
        $result = mysqli_query($link, $query);
        //Log error
        AdminUtility::logMySQLError($link);

        return $result;
    }

    public function deleteHomePageImages($imageIds) {
        $link = AdminUtility::getDefaultDBConnection();
        mysqli_autocommit($link, false);
        foreach ($imageIds as $value) {
            //Delete image in file system
            $check_query = "select * from home_page_images where id='$value'";
            $check_result = mysqli_query($link, $check_query);
            if ($check_result) {
                $row = mysqli_fetch_array($check_result);
                $thumb_url = filter_input(INPUT_SERVER, "DOCUMENT_ROOT") . SITE_FOLDER . $row["thumb_url"];
                if (is_file($thumb_url)) {
                    $deleted = unlink($thumb_url);
                    if (!$deleted) {
                        throw new Exception("Home page image thumbnail with id = $value could not be deleted");
                    }
                }
            }
            //Log error
            AdminUtility::logMySQLError($link);

            //Delete from database
            $query = "delete from home_page_images where id='$value'";
            $ok = mysqli_query($link, $query);
            if (!$ok) {
                //Log error
                AdminUtility::logMySQLError($link);
                return FALSE;
            }
        }
        return mysqli_commit($link);
    }

    public function newHomePageImage($img, $href, $caption, $size) {
        $img_url = "http://" . filter_input(INPUT_SERVER, 'HTTP_HOST') . "/$img";
        $link = AdminUtility::getDefaultDBConnection();
        //Check if exists
        $check_query = "select * from home_page_images where img_url='" . mysqli_escape_string($link, $img_url) . "' "
                . "and caption = '" . mysqli_escape_string($link, $caption) . "'";
        $check_result = mysqli_query($link, $check_query);
        if (!$check_result) {
            //Log error
            AdminUtility::logMySQLError($link);
            throw new Exception("Oops! Something went wrong");
        } elseif (mysqli_num_rows($check_result) > 0) {
            throw new Exception("Image already exists");
        }

        //Validate news 
        if (empty($href) || empty($caption)) {
            throw new Exception("Link or caption is empty");
        }

        //Check image dimension
        $size_ok = checkDimension($img, $size);
        if (!$size_ok) {
            throw new Exception("Image do not meet the specifications for $size");
        }
        //Create thumbnail
        $thumb_url = createThumbnail($img);

        $query = "insert into home_page_images set "
                . "img_url='" . mysqli_escape_string($link, $img_url) . "', "
                . "href='" . mysqli_escape_string($link, $href) . "', "
                . "thumb_url='" . mysqli_escape_string($link, $thumb_url) . "', "
                . "caption='" . mysqli_escape_string($link, $caption) . "', "
                . "size='" . mysqli_escape_string($link, $size) . "'";
        $result = mysqli_query($link, $query);
        //Log error
        AdminUtility::logMySQLError($link);

        return $result;
    }

    function addExecutive($post, $session, $userID) {
        if (empty($post) || empty($session) || empty($userID)) {
            throw new Exception("Invalid parameter");
        }

        $match = preg_match("#\d{4}/\d{4}#", $session);
        if ($match === 1) {
            $years = explode("/", $session);
            if ($years[0] > date("Y")) {
                throw new Exception("Invalid Session");
            }
        } else {
            throw new Exception("Invalid Session");
        }

        $link = AdminUtility::getDefaultDBConnection();
        $confrimQuery = "select * from executives where post = '$post' and session = '$session'";
        $result = mysqli_query($link, $confrimQuery);
        $num_rows = mysqli_num_rows($result);
        if (empty($num_rows)) {
            $query = "insert into executives set post = '$post', session = '$session', user_id='$userID'";
            mysqli_query($link, $query);
        } else {
            throw new Exception("$post already exists for $session");
        }
        //Log error
        AdminUtility::logMySQLError($link);
    }

    function modifyExecutive($ID, $post, $session) {
        if (empty($post) || empty($session) || empty($ID)) {
            throw new Exception("Invalid parameter");
        }
        
        $match = preg_match("#\d{4}/\d{4}#", $session);
        if ($match === 1) {
            $years = explode("/", $session);
            if ($years[0] > date("Y")) {
                throw new Exception("Invalid Session");
            }
        } else {
            throw new Exception("Invalid Session");
        }

        $link = AdminUtility::getDefaultDBConnection();
        $confrimQuery = "select * from executives where post = '$post' and session = '$session'";
        $result = mysqli_query($link, $confrimQuery);
        $num_rows = mysqli_num_rows($result);
        if (empty($num_rows)) {
            $query = "update executives set post = '$post', session = '$session' where id='$ID'";
            mysqli_query($link, $query);
        } else {
            throw new Exception("$post already exists for $session");
        }
        //Log error
        AdminUtility::logMySQLError($link);
    }

    function removeExecutives(array $executiveIDs) {
        $link = AdminUtility::getDefaultDBConnection();
        mysqli_autocommit($link, false);
        foreach ($executiveIDs as $ID) {
            $this->removeExecutive($ID, $link);
        }
        mysqli_commit($link);
    }

    function removeExecutive($executiveID, $link = null) {
        $query = "delete from executives where id = '$executiveID'";
        if (empty($link)) {
            $link = AdminUtility::getDefaultDBConnection();
        }
        mysqli_query($link, $query);
        //Log error
        AdminUtility::logMySQLError($link);
    }

}
