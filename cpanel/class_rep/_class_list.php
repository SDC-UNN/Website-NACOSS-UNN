<?php
//Initializing variables with default values
$defaultPage = "index.php?p=1";
$sort_type = SORT_STUDENTS_TYPE_FIRSTNAME;
$order = ORDER_STUDENTS_ASC;
$level = $admin->getField('level');
/*
  $s = filter_input(INPUT_GET, "sh");
  $on_shelf = $s=='0' ? 0 : 1;
 */
$searchQuery = "";

if (isset($array['search_button'])) {
    //process POST requests
    $page = 1;
    $searchQuery = html_entity_decode(filter_input(INPUT_POST, "search"));
    $sort_type = html_entity_decode(filter_input(INPUT_POST, "sort_type"));
    $order = html_entity_decode(filter_input(INPUT_POST, "sort_order"));
    $students = searchStudentsList($searchQuery, $level, $gender = 'all', $sort_type, $order);
} else {
    //Process GET requests or no requests
    $page = filter_input(INPUT_GET, "pg");
    if (isset($page)) {
        //if switching page, repeat search
        $searchQuery = filter_input(INPUT_GET, "q");
        $sort_type = filter_input(INPUT_GET, "s");
        $order = filter_input(INPUT_GET, "o");
        $students = searchStudentsList($searchQuery, $level, $gender = 'all', $sort_type, $order);
    } else {
        $page = 1;
        $students = getStudentsList($level);
    }
}
?>

<!DOCTYPE html>
<!--
Copyright 2015 NACOSS UNN Developers Group (NDG).

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

     http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
-->
<script>
    function warn() {
//        var ok = confirm("Are you sure?");
//        if(ok === false){
//            //Cancel request
//            window.stop();
//        }
    }
    ;
</script>
<div>
    <h4>CLASS LIST</h4>

    <?php
    if (empty($students) and ! isset($array['search_button'])) {
        echo '<p>No students in this class</p>';
    } else {
        ?>
        <div class="bg-grayLighter padding5 row ntm">
            <form method="post" action="index.php?p=1">
                <div class="row ntm input-control text" data-role="input-control">
                    <input type="text" value="<?= $searchQuery ?>" placeholder="Search Class List" name="search"/>
                    <button class="btn-search" name="search_button" type="submit"></button>
                </div>
                <div class="row ntm">
                    <div class="span6">
                        <label class="">Sort by: </label>
                        <div class="input-control radio">
                            <label>
                                <input type="radio" name="sort_type" 
                                <?=
                                isset($sort_type) ?
                                        ($sort_type == SORT_STUDENTS_TYPE_FIRSTNAME ? "checked='checked'" : "") :
                                        "checked"
                                ?>
                                       value="<?= SORT_STUDENTS_TYPE_FIRSTNAME ?>"/>
                                <span class="check"></span>
                                First name
                            </label>
                        </div>
                        <div class="input-control radio">
                            <label>
                                <input type="radio" name="sort_type"
                                <?=
                                isset($sort_type) ?
                                        ($sort_type == SORT_STUDENTS_TYPE_LASTNAME ? "checked='checked'" : "") :
                                        ""
                                ?>
                                       value="<?= SORT_STUDENTS_TYPE_LASTNAME ?>"/>
                                <span class="check"></span>
                                Last name
                            </label>
                        </div>
                        <div class="input-control radio">
                            <label>
                                <input type="radio" name="sort_type"
                                <?=
                                isset($sort_type) ?
                                        ($sort_type == SORT_STUDENTS_TYPE_OTHERNAMES ? "checked='checked'" : "") :
                                        ""
                                ?>
                                       value="<?= SORT_STUDENTS_TYPE_OTHERNAMES ?>"/>
                                <span class="check"></span>
                                Other names
                            </label>
                        </div>

                    </div>
                    <div class="span3">
                        <label class="">Order: </label>
                        <div class="input-control radio">
                            <label>
                                <input type="radio" name="sort_order"
                                <?= isset($order) ? ($order == ORDER_STUDENTS_ASC ? "checked" : "") : "checked" ?>
                                       value="<?= ORDER_STUDENTS_ASC ?>"/>
                                <span class="check"></span>
                                Asc
                            </label>
                        </div>
                        <div class="input-control radio">
                            <label>
                                <input type="radio" name="sort_order"
                                <?= isset($order) ? ($order == ORDER_STUDENTS_DESC ? "checked" : "") : "" ?>
                                       value="<?= ORDER_STUDENTS_DESC ?>"/>
                                <span class="check"></span>
                                Desc
                            </label>
                        </div>

                    </div>
                </div>
            </form>
        </div>

        <div id="top" class="row ntm" >

            <?php
            if (isset($actionPerformed)) {
                if ($success) {
                    ?>
                    <p class="fg-NACOSS-UNN">Action successful</p>
                <?php } else { ?>
                    <p class="fg-red"><?= $error_message ?></p>
                    <?php
                }
            }
            ?>
            <form action="index.php?p=1" method="post">
                <input name="search" hidden value="<?= $searchQuery ?>"/>
                <input name="sort_type" hidden value="<?= $sort_type ?>"/>
                <input name="sort_order" hidden value="<?= $order ?>"/>

                <table class="table hovered bordered">
                    <thead>
                        <tr>
                            <th class="text-left">SN</th>
                            <th class="text-left">Reg. No.</th>
                            <th class="text-left">First Name</th>
                            <th class="text-left">Last Name</th>
                            <th class="text-left">Other Names</th>
                            <th class="text-left">Gender</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($index = 0; $index < count($students); $index++) {
                            if ($index != 0 && $index % 20 === 0) {
                                echo '<tr><td></td><td colspan="5"><a href="#top">back to top</a></td></tr>';
                            }
                            ?>
                            <tr>                            
                                <td class="text-left"><?= $index + 1 ?></td>
                                <td class="text-left"><?= $students[$index]['regno']; ?></td>
                                <td class="text-left"><?= $students[$index]['first_name']; ?></td>
                                <td class="text-left"><?= $students[$index]['last_name']; ?></td>
                                <td class="text-left"><?= $students[$index]['other_names']; ?></td>
                                <td class="text-left"><?= strtoupper($students[$index]['gender']); ?></td> 
                            </tr>
                            <?php
                        }
                        echo '<tr><td></td><td colspan="5"><a href="#top">back to top</a></td></tr>';
                        ?>
                    </tbody>
                </table>
            </form>
        <?php } ?>
    </div>

</div>