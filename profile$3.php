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

$array = UserUtility::getResults($user->getUserID());
?>
<div>
    <h2>Results</h2>
    <div class="row bg-grayLighter">
        <div class="padding5">
            <?php if (empty($array)) { ?>
                <h3>No results available.</h3>
                <?php
            } else {
                $course = "";
                foreach ($array as $result) {
                    if (strcasecmp($course, $array['course_code']) !== 0) {
                        if (!empty($course)) {
                            //If not the first course dispayed, close a div
                            echo '</div>';
                        }
                        //Display header
                        echo '<h3>' . $array['course_code'] . ', '
                        . 'Semester: ' . $array['semester'] . ', '
                        . 'Year: ' . $array['year'] . '</h3>';
                        //Open a row for images
                        echo '<div class="row">';
                        $course = $array['course_code'];
                    }
                    ?>
                    <!--Display Image-->
                    <div class="image-container">
                        <img class="image" src="<?= $array['img_url'] ?>" alt=""/>
                        <div class="overlay-fluid">page <?= $array['page_no'] ?></div>
                    </div>
                    <?php
                }
                echo '</div>';
            }
            ?>
        </div>
    </div>
</div>
