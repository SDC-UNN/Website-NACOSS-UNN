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

if (isset($array['post_button'])) {
    try {
        $array['expire_time'] = $array['exp_date'] . " " . $array['exp_time'];
        $success = $admin->newPost($array['title'], $array['content'], $array['expire_time']);
        if ($success) {
            unset($array);
        } else {
            $error_message = "Oops! something went wrong";
        }
    } catch (Exception $exc) {
        $success = FALSE;
        $error_message = $exc->getMessage();
    }
}
?>

<div>
    <h4>NEW POST</h4>
    <div class="grid">
        <?php
        if (isset($success)) {
            if ($success) {
                ?>
                <p class="fg-green">News was posted</p>
            <?php } else { ?>
                <p class="fg-red"><?= $error_message ?></p>
                <?php
            }
        }
        ?>
        <form method="post" enctype="multipart/post-data" action="index.php?p=11">
            <div class="row ntm">
                <label class="span1">Title</label>
                <div class="span7">
                    <input class="text" name='title' required value="<?= isset($array['title']) ? $array['title'] : "" ?>" maxlength="60" style="width: inherit" required type='text' tabindex='1' />
                </div>
            </div>
            <?php
            if (empty($array['expire_time'])) {
                $time = array(strftime("%Y-%m-%#d", time() + (60 * 60 * 24)), //Current time + 1 day
                    "00:00:00");
            } else {
                $time = explode(" ", $array['expire_time']);
            }
            ?>
            <div class="row" >
                <label class="span1">Expire Date</label>
                <div class="span7">
                    <!--old data-format="dddd, mmmm d, yyyy"-->
                    <div class="input-control text span2" data-role="datepicker"
                         data-date="<?= $time[0] ?>"
                         data-format="yyyy-mm-dd"
                         data-position="bottom"
                         data-effect="slide">
                        <input type="text" required name="exp_date">
                        <button type="button" class="btn-date"></button>
                    </div>
                    <div class="span5">
                        <label class="span2">Expire Time <small>(hh:mm:ss)</small></label>
                        <input type="time" required="" placeholder="hh:mm:ss" value="<?= $time[1] ?>" name="exp_time">
                    </div>
                </div>
            </div>
            <br/>
            <?php
            //Cute editor Settings
            $editor = new CuteEditor();
            $editor->ID = "content";
            $editor->Text = isset($array['content']) ? $array['content'] : "";
            $editor->EditorBodyStyle = "font:normal 12px arial;";
            $editor->EditorWysiwygModeCss = "php.css";
//            $editor->AutoConfigure = "Simple";
            $editor->Height = 560;
            $editor->Width = 960;
            $editor->MaxImageSize = "200";
            $editor->ImageGalleryPath = HOSTNAME_REL . "/uploads/news/images/";
            $editor->FilesGalleryPath = HOSTNAME_REL . "/uploads/news/files/";
            $editor->FlashGalleryPath = HOSTNAME_REL . "/uploads/news/flash/";
            $editor->MediaGalleryPath = HOSTNAME_REL . "/uploads/news/media/";
            $editor->TemplateGalleryPath = HOSTNAME_REL . "/uploads/news/templates/";
            $editor->Draw();
            $editor = null;
            ?>
            <div class="row ">
                <div class="">
                    <input class="button bg-blue bg-hover-dark fg-white" name='post_button' type='submit' tabindex='4' value="Post" />
                </div>
            </div>

        </form>
    </div>
</div>