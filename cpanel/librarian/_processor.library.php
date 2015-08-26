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
require_once('LibraryAdmin.php');
$admin = new LibraryAdmin();

$array = filter_input_array(INPUT_POST);
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

    $admin->addLibraryItem($array);
} else {
    echo 'No data recieved.';
}
?>