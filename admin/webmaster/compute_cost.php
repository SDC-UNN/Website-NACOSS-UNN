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

require_once '../class_lib.php';
require_once './WebsiteAdmin.php';
require_once './functions.php';

$admin = new WebsiteAdmin();
$max_hash_time = $admin->getMaxHashTime();
$cost = getOptimalCryptCostParameter($max_hash_time);
$ok = $admin->setHashCost($cost);
if ($ok) {
    header("location: index.php?p=7");
} else {
    ?>
    <div>
        <h2>Something went wrong!</h2>
    </div>
    <?php
}