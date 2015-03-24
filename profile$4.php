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

$array = Utility::getPayments($user->getUserID());

?>
<div>
    <h2>Payments</h2>
    <div class="row">
        <a class="place-right button default bg-NACOSS-UNN bg-hover-dark fg-hover-white" href="pay.php">
            Pay
        </a>
    </div>
    <div class="row bg-grayLighter">
        <div class="padding5">
            <?php if (empty($array)) { ?>
                <h3>No payments have been made.</h3>
                <?php
            } else {
                ?>
                <table class="striped bordered hovered">
                    <thead>
                        <tr>
                            <th class="text-left">Payment ID</th>
                            <th class="text-left">description</th>
                            <th class="text-left">Date of Payment</th>
                            <th class="text-left"></th>
                        </tr>
                    </thead>
                    <?php
                    foreach ($array as $result) {
                        echo '<tr>';
                        echo '<td>' . $result['id'] . '</td>';
                        echo '<td>' . $result['description'] . '</td>';
                        echo '<td>' . $result['time_of_payment'] . '</td>';
                        echo '<td><a href="printReciept.php?id=' . $result['id'] . '">print</a></td>';
                        echo '</tr>';
                    }
                    ?>                    
                </table>
                <?php
            }
            ?>
        </div>
    </div>
</div>