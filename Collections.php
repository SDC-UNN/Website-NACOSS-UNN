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

class Collections {

    private $books;

    const SORT_TYPE_TITLE = 10;
    const SORT_TYPE_AUTHOR = 11;
    const SORT_TYPE_DATE_ADDED = 12;
    const ORDER_ASC = 1;
    const ORDER_DESC = 0;

    function Collections() {
        $array = array();
        $query = "select * from library order by title ASC";
        $link = Utility::getDefaultDBConnection();
        $result = mysqli_query($link, $query);
        if ($result) {
            while ($row = mysqli_fetch_array($result)) {
                array_push($array, $row);
            }
        }
        $this->books = $array;
    }

    /**
     * 
     * @return array
     */
    public function getBooks() {
        return $this->books;
    }

    /**
     * Returns books in a particular order
     * @param type $sort_type
     * @param type $order
     * @return type
     */
    public function sortBooks($sort_type, $order) {
        // Obtain a list of columns
        foreach ($this->books as $key => $row) {
            $title[$key] = $row['title'];
            $author[$key] = $row['author'];
            $date_added[$key] = $row['date_added'];
        }

        // Sort the data with volume descending, edition ascending
        // Add $data as the last parameter, to sort by the common key
        switch ($sort_type) {
            case Collections::SORT_TYPE_TITLE:
                array_multisort($title, ($order == SORT_DESC ? SORT_DESC : SORT_ASC), $author, SORT_ASC, $date_added, SORT_DESC, $this->books);
                break;
            case Collections::SORT_TYPE_AUTHOR:
                array_multisort($author, ($order == SORT_DESC ? SORT_DESC : SORT_ASC), $title, SORT_ASC, $date_added, SORT_DESC, $this->books);
                break;
            case Collections::SORT_TYPE_DATE_ADDED:
                array_multisort($date_added, ($order == SORT_DESC ? SORT_DESC : SORT_ASC), $title, SORT_ASC, $author, SORT_ASC, $this->books);
                break;
            default :
                throw new Exception("Invalid sort type");
        }

        return $this->books;
    }

    /**
     * Linear search of query. Only Title, Author and Keywords fields are searched
     * @return array
     */
    public function searchBooks($query) {
        if (strlen($query) > 0) {
            $array = array();
            foreach ($this->books as $value) {
                if(stripos($value['title'], $query) !== FALSE ||
                        stripos($value['author'], $query) !== FALSE ||
                        stripos($value['keywords'], $query) !== FALSE){
                    array_push($array, $value);
                        }
            }
            return $array;
        }
        return $this->books;
    }

}
