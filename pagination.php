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


/**
 * This file assumes that the following variables has already been created and initialized<br/>
 * $total_pages, $page, $defaultPage<br/>
 * $total_pages inidicates the total number of pages.<br/>
 * $page inicates the current page.<br/>
 * $defaultPage refers to the url to handle get request from this script
 */
if ($total_pages > 1) {
    if (strpos($defaultPage, "?") == FALSE) {
        $defaultPage = $defaultPage . '?';
    }
    ?>
    <div class="pagination">
        <ul>
            <li class="first">
                <a href="<?= $defaultPage ?>&pg=1">
                    <i class="icon-first-2"></i>
                </a>
            </li>
            <li class="prev <?= ($page - 1) < 1 ? "disabled" : "" ?>">
                <a href="<?= $defaultPage . '&pg=' . ($page - 1) ?>">
                    <i class="icon-previous"></i>
                </a>
            </li>
            <?php if ($page - 2 >= 1) { ?>
                <li>
                    <a href="<?= $defaultPage . '&pg=' . ($page - 2) ?>">
                        <?= ($page - 2) ?></a>
                </li>
            <?php } ?>

            <?php if ($page - 1 >= 1) { ?>
                <li>
                    <a href="<?= $defaultPage . '&pg=' . ($page - 1) ?>">
                        <?= ($page - 1) ?>
                    </a>
                </li>
            <?php } ?>

            <li class="active">
                <a href="<?= $defaultPage . '&pg=' . $page ?>">
                    <?= $page ?>
                </a>
            </li>

            <?php if ($page + 1 <= $total_pages) { ?>
                <li>
                    <a href="<?= $defaultPage . '&pg=' . ($page + 1) ?>">
                        <?= ($page + 1) ?>
                    </a>
                </li>
            <?php } ?>

            <?php if ($page + 2 <= $total_pages) { ?>
                <li>
                    <a href="<?= $defaultPage . '&pg=' . ($page + 2) ?>">
                        <?= ($page + 2) ?>
                    </a>
                </li>
            <?php } ?>

            <li class="next <?= ($page + 1) > $total_pages ? "disabled" : "" ?>">
                <a href="<?= $defaultPage . '&pg=' . ($page + 1) ?>">
                    <i class="icon-next"></i>
                </a>
            </li>

            <li class="last">
                <a href="<?= $defaultPage . '&pg=' . $total_pages ?>">
                    <i class="icon-last-2"></i>
                </a>
            </li>
        </ul>
    </div>
<?php } ?>