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

$array = $user->getUserData();
?>
<div class="grid fluid">
    <h2>Profile</h2>
    <!--    <div class="row">
            <a class="span4 button default bg-NACOSS-UNN bg-hover-dark fg-hover-white" href="logout.php?url=<?= urlencode($_SERVER["PHP_SELF"]) ?>">
                Log out
            </a>
            <a class="span6 button default bg-NACOSS-UNN bg-hover-dark fg-hover-white" href="profile.php?p=2">
                Update Profile
            </a>
        </div>-->
    <div class="row ntm">
        <div class="span4 bg-grayLighter">
            <img class="image shadow padding5" src="<?=
            isset($array['pic_url']) && !empty($array['pic_url']) ?
                    HOSTNAME . $array['pic_url'] :
                    "img/picture5.png"
            ?>" alt=""/>
        </div>
        <div class="span8 bg-grayLighter">
            <div class="padding10">
                <!--Name-->
                <p>
                    <?php
                    echo strtoupper($array['first_name']) . " ";
                    echo empty($array['last_name']) ? "" : strtoupper($array['other_names']) . " ";
                    echo strtoupper($array['last_name'])
                    ?>
                </p>
                <!--Registration number-->
                <?= $array['regno'] ?> 
                <!--Show verification status-->
                <?php
                if (isset($array['verified']) && $array['verified'] == 1) {
                    echo '<i title="Verified" class="icon-checkmark fg-NACOSS-UNN"></i>';
                }
                ?>
                <br>
                <!--Department and level-->
                <?php
                if (isset($array['department']) && !empty($array['department'])) {
                    echo "Department of " . ucwords($array['department']);
                    echo '<br/>';
                    echo ucwords($array['level']) . " Level, ";
                    echo 'Class of ' . $array['entry_year'];
                }
                ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="">
            <div class="panel no-border bg-transparent" data-role="panel">
                <p class="panel-header">Personal Information</p>
                <div class="panel-content bg-grayLighter">
                    <p><strong>Date of Birth:</strong> 
                        <!--Displays date in the format: Saturday, 29, July 1995-->
                        <?= empty($array['dob']) ? "" : strftime("%A, %#d, %B %Y", strtotime($array['dob'])) ?>
                    </p>
                    <p><strong>Bio:</strong>
                        <?php
                        if (isset($array['bio']) && !empty($array['bio'])) {
                            echo $array['bio'];
                        }
                        ?>
                    </p>
                </div>                    
            </div>
            <br/>
            <div class="panel no-border bg-transparent" data-role="panel">
                <p class="panel-header">Contact Information</p>
                <div class="panel-content bg-grayLighter">
                    <p><strong>Phone:</strong> <?= $array['phone'] ?></p>
                    <p><strong>Email:</strong> <?= $array['email'] ?></p>
                    <p><strong>Address 1:</strong> <?= $array['address1'] ?></p>
                    <p><strong>Address 2:</strong> <?= $array['address2'] ?></p>                    
                </div>
            </div>
            <br/>
            <div class="panel no-border bg-transparent" data-role="panel">
                <p class="panel-header">Interests/Activities</p>
                <div class="panel-content bg-grayLighter">
                    <p><strong>Interest:</strong> <?= $array['interests'] ?></p>                    
                </div>
            </div>
        </div>
    </div>
</div>