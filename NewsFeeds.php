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

require_once './UserUtility.php';

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

    public static function getHomePageSliderImages() {
        $array = array();
        $query = "select * from home_page_slider limit 10";
        $link = UserUtility::getDefaultDBConnection();
        $result = mysqli_query($link, $query);
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                array_push($array, $row);
            }
        } else {
            //Log error
            $error = mysqli_error($link);
            if (!empty($error)) {
                UserUtility::writeToLog(new Exception($error));
            }
        }
        return $array;
    }

    private function setNews() {
        $array = array();
        $query = "select * from news order by time_of_post DESC";
        $link = UserUtility::getDefaultDBConnection();
        $result = mysqli_query($link, $query);
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                array_push($array, $row);
            }
        } else {
            //Log error
            $error = mysqli_error($link);
            if (!empty($error)) {
                UserUtility::writeToLog(new Exception($error));
            }
        }
        $this->news = $array;
    }

    public function getAllNews() {
        return $this->news;
    }

    public function getNews($id) {
        foreach ($this->news as $news) {
            if (strcmp($news[$id], $id) === 0) {
                return $news;
            }
        }
    }

}
