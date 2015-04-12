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
if (!isset($admin)) {
    $admin = new Admin();
}
?>

<div class="">
    <div class="navigation-bar dark">
        <div class="container">
            <div class="navigation-bar-content">
                <a class="element" href="<?= CPANEL_URL ?>">DashBoard</a>
                <span class="element-divider"></span>
                <a class="element1 pull-menu" href="#"></a>
                <ul class="element-menu">
                    <li>
                        <a class="" href="<?= HOSTNAME ?>" >Visit site</a>
                    </li>
                    <?php if ($admin->getAdminType() === Admin::WEBMASTER) { ?>
                        <li>
                            <a class="" href="<?= CPANEL_URL ?>pro" >View As PRO</a>
                        </li>
                        <li>
                            <a class="" href="<?= CPANEL_URL ?>librarian" >View as Librarian</a>
                        </li>
                    <?php } ?>
                </ul>

                <?php if ($admin->isLoggedIn()) { ?>
                    <a href="<?= CPANEL_URL ?>logout.php" title="Logout" class="element place-right">
                        <i class="icon-exit"></i> Logout
                    </a>
                    <a href="#" style="cursor: default" class="bg-hover-dark element place-right">Hi <?= $admin->getAdminID() ?> </a>
                <?php } ?>
            </div>
        </div>
    </div>
</div>