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
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="description" content="NACOSS UNN official website">
        <meta name="author" content="NACOSS UNN Developers">
        <meta name="keywords" content=" metro ui, NDG, NACOSS UNN">
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />

        <link href="css/metro-bootstrap.css" rel="stylesheet">
        <link href="css/metro-bootstrap-responsive.css" rel="stylesheet">
        <link href="css/iconFont.css" rel="stylesheet">
        <link href="js/prettify/prettify.css" rel="stylesheet">

        <script src="js/metro/metro.min.js"></script>

        <!-- Load JavaScript Libraries -->
        <script src="js/jquery/jquery.min.js"></script>
        <script src="js/jquery/jquery.widget.min.js"></script>
        <script src="js/jquery/jquery.mousewheel.js"></script>
        <script src="js/prettify/prettify.js"></script>

        <!-- Metro UI CSS JavaScript plugins -->
        <script src="js/load-metro.js"></script>

        <!-- Local JavaScript -->
        <script src="js/docs.js"></script>
        <script src="js/github.info.js"></script>

        <!-- Page Title -->
        <title>NACOSS UNN : Executives</title>        
    </head>
    <body class="metro" style="background-image: url(img/bg.jpg); background-repeat: repeat;">
        <div class="container bg-white">            
            <?php require_once './header.php'; ?>
            <div class="padding20">
                <h1>Executives</h1>
                <?php if (empty($executives) && empty($session)) { ?>
                    <br/>
                    <p>Not available at the moment</p>
                <?php } else { ?>
                    <div>
                        <div class="place-right">
                            <form class="grid" method="post" action="executives.php">
                                <div class="row">
                                    <p class="span1">Session</p>
                                    <select name="session" class="span4">
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
                                    <input class="bg-NACOSS-UNN fg-white bg-hover-dark span2" name="switchSession" type="submit" value="View Session"/>
                                </div>
                            </form>
                        </div>
                        <br/>
                        <div class="">
                            <?php include './pagination.php'; ?>
                            <table class="table grid hovered striped">
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
                                                        if (file_exists($executives[$index]['pic_url'])) {
                                                            ?>
                                                            <img src="<?= $executives[$index]['pic_url'] ?>" alt="Icon"/>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <img src="img/picture5.png" alt="Icon"/>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="span4">
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
                            <?php include './pagination.php'; ?>
                        </div>
                    </div>
                <?php } ?>

            </div>
            <br/>
            <?php require_once './footer.php'; ?>
        </div>
    </body>
</html>
