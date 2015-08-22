<?php
require_once 'class_lib.php';
//Initializing fields with default values
$max_view_length = 10;
$page = 1;
$total_pages = 1;

//Get session from search
$session = filter_input(INPUT_POST, "session");
if (empty($session)) {
    //Get session from other sources
    $session = filter_input(INPUT_GET, "session");
    $page = filter_input(INPUT_GET, "pg");
    if (empty($page)) {
        $page = 1;
    }
}

$defaultPage = "executives.php?session=$session";
$executives = UserUtility::getExecutives($session);


if (count($executives) > $max_view_length) {
    $total_pages = count($executives) % $max_view_length === 0 ?
            count($executives) / $max_view_length :
            floor(count($executives) / $max_view_length) + 1;
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

<html>
    <head>
        <?php require_once 'default_head_tags.php'; ?>

        <!-- Page Title -->
        <title>NACOSS UNN : Executives</title>        
    </head>
    <body class="metro" style="background-image: url(img/bg.jpg); background-repeat: repeat;">
        <div class="container bg-white" id="wrapper">            
            <?php require_once 'header.php'; ?>
            <div class="padding20">
                <div class="grid fluid">
                    <h1>Executives</h1>
                    <?php if (empty($executives) && empty($session)) { ?>
                        <div class="row">
                            <p>Not available at the moment</p>
                        </div>
                    <?php } else { ?>

                        <form class="row" method="post" action="executives.php">
                            <p class="span2">Session</p>
                            <select name="session" class="select span3">
                                <option></option>
                                <?php
                                $year = date("Y");
                                $endYear = "2014";
                                while ($year >= $endYear) {
                                    $nextSession = ($year - 1) . "/" . ($year);
                                    echo "<option "
                                    . (strcasecmp($session, $nextSession) === 0 ? "selected" : "")
                                    . ">"
                                    . $nextSession
                                    . "</option>";
                                    $year--;
                                }
                                ?>
                            </select>
                            <input class="span4 bg-NACOSS-UNN fg-white bg-hover-dark" name="switchSession" type="submit" value="View Session"/>
                        </form>
                        <div class="row">
                            <?php include 'pagination.php'; ?>
                            <table class="table hovered striped">
                                <?php
                                if (empty($executives)) {
                                    echo '<tr class="">
                                            <td class="">
                                            <div class="text-center">';
                                    echo '<h2>Nothing found</h2>';
                                    echo '</div>
                                        </td>
                                        </tr>';
                                } else {
                                    $start = ($page - 1) * $max_view_length;
                                    $remainingItems = count($executives) - $start;
                                    $stop = $start + min(array($remainingItems, $max_view_length));
                                    for ($index = $start; $index < $stop; $index++) {
                                        ?>
                                        <tr class="">
                                            <td class="">
                                                <div class="row ntm nbm">
                                                    <div class="span2 shadow">
                                                        <?php
                                                        if (file_exists(ROOT . $executives[$index]['pic_url'])) {
                                                            ?>
                                                            <img src="<?= HOSTNAME . $executives[$index]['pic_url'] ?>" alt="Icon"/>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <img src="img/picture5.png" alt="Icon"/>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="span10">
                                                        <h4>
                                                            <a class="" href="user_profile.php?id=<?= $executives[$index]['regno'] ?>&url=<?= $defaultPage ?>">
                                                                <?=
                                                                $executives[$index]['last_name']
                                                                . " "
                                                                . $executives[$index]['first_name']
                                                                . " "
                                                                . $executives[$index]['other_names']
                                                                ?> 
                                                            </a>
                                                        </h4>
                                                        <p>
                                                            <?= $executives[$index]['post'] ?>
                                                            <br/>
                                                            <?= $executives[$index]['session'] ?>
                                                            <br/>
                                                            <?= $executives[$index]['department'] ?>
                                                        </p>   
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </table>
                            <?php include 'pagination.php'; ?>
                        </div>

                    <?php } ?>

                </div>
            </div>
            <?php require_once 'footer.php'; ?>
        </div>
    </body>
</html>
