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

require_once 'UserUtility.php';

class NewsFeeds {

    private $news;

    function NewsFeeds() {
        $this->setNews();
    }

    public function getHeadLines() {
        if (isset($this->news)) {
            return array();
        }
        return array();
    }

    public static function getLargeHomePageImages() {
        $array = array();
        $query = "select * from home_page_images where size = 'LARGE'";
        $link = UserUtility::getDefaultDBConnection();
        $result = mysqli_query($link, $query);
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                array_push($array, $row);
            }
        } else {
            //Log error            
            UserUtility::logMySQLError($link);
        }
        return $array;
    }

    public static function getSmallHomePageImages() {
        $array = array();
        $query = "select * from home_page_images where size = 'SMALL'";
        $link = UserUtility::getDefaultDBConnection();
        $result = mysqli_query($link, $query);
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                array_push($array, $row);
            }
        } else {
            //Log error            
            UserUtility::logMySQLError($link);
        }
        return $array;
    }

    private function setNews() {
        $array = array();
        $query = "select * from news where is_deleted = 0 and expire_time >= now() order by time_of_post DESC limit 30";
        $link = UserUtility::getDefaultDBConnection();
        $result = mysqli_query($link, $query);
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                array_push($array, $row);
            }
        } else {
            //Log error
            UserUtility::logMySQLError($link);
        }
        $this->news = $array;
    }

    public function getAllNews() {
        return $this->news;
    }

    /**
     * Get first 5 news with highest hits
     * @return type
     */
    public function getTopNews() {
        $sortedNews = $this->news;
        $topHits = array();
        foreach ($sortedNews as $key => $row) {
            $hits[$key] = $row['hits'];
        }
        array_multisort($hits, SORT_DESC, $sortedNews);

        $length = min(array(5, count($sortedNews)));
        for ($index = 0; $index < $length; $index++) {
            $topHits[] = $sortedNews[$index];
        }
        return $topHits;
    }

    public function getNews($id) {
        foreach ($this->news as $news) {
            if (strcmp($news["id"], $id) === 0) {
                return $news;
            }
        }
    }

    public function plusOneHit($id) {
        $query = "update news set hits = hits + 1 where id = '$id'";
        $link = UserUtility::getDefaultDBConnection();
        $result = mysqli_query($link, $query);
        //Log error            
        UserUtility::logMySQLError($link);
        return $result;
    }

}
