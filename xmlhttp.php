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
require_once 'class_lib.php';

$array = filter_input_array(INPUT_GET);
if ($array !== FALSE && $array !== null) {
    foreach ($array as $key => $value) {
        if (is_array($array[$key])) {
            foreach ($array[$key] as $subkey => $subvalue) {
                $array[$key][$subkey] = html_entity_decode($array[$key][$subkey]);
            }
        } else {
            $array[$key] = html_entity_decode($array[$key]);
        }
    }
} else {
    die('No data recieved');
}

if (empty($array["op"])) {
    die('Operation not defined');
}

$op = $array["op"];
if ($op == "feedback") {
    $link = UserUtility::getDefaultDBConnection();
    $query = "insert into feedbacks set "
            . "ip_address='{$_SERVER["REMOTE_ADDR"]}', "
            . "message='{$array['msg']}' "
            . "on duplicate key update "
            . "message='{$array['msg']}', "
            . "seen=0";
    echo mysqli_query($link, $query) ? "OK" : "FAILED";
} else {
    echo 'INVALID REQUEST';
}