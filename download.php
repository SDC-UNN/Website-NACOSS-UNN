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

$id = filter_input(INPUT_GET, "id"); //Material id
$link = UserUtility::getDefaultDBConnection();
$query = "select link from library where id = '$id'";
$result = mysqli_query($link, $query);
if ($result) {
    $row = mysqli_fetch_array($result);
    $link = $row['link'];
    
    //Redirect to download
    header("location: $link");
} else {
            //Log error
            $error = mysqli_error($link);
            if (!empty($error)) {
                UserUtility::writeToLog(new Exception($error));
            }
        }
?>
<!--if not successful-->
<div>
    <h2>Sorry, error occurred while fetching file</h2>
</div>