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

$id = filter_input(INPUT_GET, "id"); //Material id
$link = UserUtility::getDefaultDBConnection();
$query = "select * from library where id = '$id'";
$result = mysqli_query($link, $query);
if ($result) {
    $row = mysqli_fetch_array($result);
    $dlink = $row['link'];
    $is_link = $row['file_type'] === "link";
    //count downloads
    $update_q = "update library set num_of_downloads = num_of_downloads + 1 where id = '$id'";
    $result = mysqli_query($link, $update_q);
    if ($result == FALSE) {
        //Log MySQL Error
        UserUtility::logMySQLError($link);
    } else {
        //Redirect to download
        $url = ($is_link ? "" : HOSTNAME) . $dlink;
        header("location: " . $url);
    }
} else {
    //Log MySQL Error
    UserUtility::logMySQLError($link);
}
?>
<!--if not successful-->
<div>
    <h2>Sorry, error occurred while fetching file</h2>
    <p>This error have been noted and will be fixed soon</p>
</div>