<?php
if (isset($array['delete_button']) && isset($array['checkbox'])) {
    try {
        $deletePerformed = true;
        $success = $admin->deleteHomePageImages($array['checkbox']);
        if (!$success) {
            $error_message = "Oops! Something went wrong";
        }
    } catch (Exception $exc) {
        $success = false;
        $error_message = $exc->getMessage();
    }
} elseif (isset($array['addImage'])) {
    try {
        $addPerformed = true;
        $success = $admin->createNewHomePageImage('image', $array['href'], $array['caption'], $array['size']);
        if (!$success) {
            $error_message = "Oops! Something went wrong";
        }
    } catch (Exception $exc) {
        $success = false;
        $error_message = $exc->getMessage();

        $caption = $array['caption'];
        $size = $array['size'];
        $href = $array['href'];
    }
} else {
//Get post id, image, caption, href, size if set
    $id = urldecode(filter_input(INPUT_GET, "id"));
    $caption = urldecode(filter_input(INPUT_GET, "caption"));
    $size = urldecode(filter_input(INPUT_GET, "size"));
    $href = urldecode(filter_input(INPUT_GET, "href"));
}
//Get large and small home page images
$smallImages = getSmallHomePageImages();
$largeImages = getLargeHomePageImages();
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
<Script Language="javascript">
    function warn() {
//        var ok = confirm("Are you sure?");
//        if (ok === false) {
//            //Cancel request
//            window.stop();
//        }
    }
</script>

<div>
    <h4>HOME PAGE IMAGES</h4>
    <div class="row">
        <a class="place-right button default bg-lightBlue fg-white" href="#new">
            <i class="icon-plus"></i> New Image
        </a>
    </div>
    <div class="row ntm">
        <?php
        if (empty($smallImages) and empty($largeImages)) {
            echo '<p>No image has been to homepage</p>';
        } else {
            if (isset($deletePerformed)) {
                if ($success) {
                    ?>
                    <p class="fg-NACOSS-UNN">Action successful</p>
                <?php } else { ?>
                    <p class="fg-red"><?= $error_message ?></p>
                    <?php
                }
            }
            ?>
            <div id="top">
                <form action="index.php?p=2" method="post">
                    <div class="row">
                        <input class="" onclick="warn()" name="delete_button" type="submit" value="Delete"/>
                    </div>
                    <div class="row ntm">
                        <table class="table hovered bordered">
                            <thead>
                                <tr>
                                    <th class="text-left"></th>
                                    <th class="text-left">ID</th>
                                    <th class="text-left">IMAGE URL</th>
                                    <th class="text-left">HREF</th>
                                    <th class="text-left">Caption</th>
                                    <th class="text-left">Size</th>
                                    <th class="text-left"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($largeImages as $value) {
                                    ?>
                                    <tr>                            
                                        <td class="text-left"><input type="checkbox" name="checkbox[]" value="<?= $value['id'] ?>"/></td>
                                        <td class="text-left"><?= $value['id'] ?></td>
                                        <td class="text-left">
                                            <a href="<?= HOSTNAME . $value['img_url'] ?>" target="_blank">
                                                <?= $value['img_url'] ?>
                                            </a>
                                        </td>
                                        <td class="text-left">
                                            <a href="<?= $value['href'] ?>" target="_blank">
                                                <?= $value['href'] ?>
                                            </a>
                                        </td>
                                        <td class="text-left"><?= $value['caption'] ?></td>
                                        <td class="text-left"><?= $value['size'] ?></td>
                                        <td class="text-left">
                                            <img src="<?= HOSTNAME . $value['thumb_url'] ?>" alt="thumbnail"/>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                foreach ($smallImages as $value) {
                                    ?>
                                    <tr>                            
                                        <td class="text-left"><input type="checkbox" name="checkbox[]" value="<?= $value['id'] ?>"/></td>
                                        <td class="text-left"><?= $value['id'] ?></td>
                                        <td class="text-left">
                                            <a href="<?= HOSTNAME . $value['img_url'] ?>" target="_blank">
                                                <?= $value['img_url'] ?>
                                            </a>
                                        </td>
                                        <td class="text-left">
                                            <a href="<?= $value['href'] ?>" target="_blank">
                                                <?= $value['href'] ?>
                                            </a>
                                        </td>
                                        <td class="text-left"><?= $value['caption'] ?></td>
                                        <td class="text-left"><?= $value['size'] ?></td>
                                        <td class="text-left">
                                            <img src="<?= HOSTNAME . $value['thumb_url'] ?>" alt="thumbnail"/>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row ntm">
                        <input class="" onclick="warn()" name="delete_button" type="submit" value="Delete"/>
                    </div>
                </form>

            </div>
        <?php } ?>
        <br/>
        <br/>
        <?php
        if ((count($smallImages) + count($largeImages)) < 10) { //max 4 large images and 6 small images  
            ?>
            <div class="panel grid" id="new">
                <div class="panel-header">Add New</div>
                <div class="panel-content">
                    <?php
                    if (isset($addPerformed)) {
                        if (!$success) {
                            ?>
                            <p class="fg-red"><?= $error_message ?></p>
                            <?php
                        } else {
                            ?>
                            <p class="fg-NACOSS-UNN">Image was successfully added</p>
                            <?php
                        }
                    }

                    if (!empty($id)) {
                        $post = getPost($id);
                        if (!empty($post)) {
                            $caption = $post["title"];
                            $href = HOSTNAME . "news_post.php?id=$id";
                        }
                    }
                    ?>
                    <form action="index.php?p=2#new" method="post" enctype="multipart/form-data">
                        <a  class="button default" href="index.php?p=21&size=<?= empty($size) ? "" : $size ?>&href=<?= empty($href) ? "" : urlencode($href) ?>&caption=<?= empty($caption) ? "" : urlencode($caption) ?>">
                            <?= empty($caption) ? "Select a post first!" : "Change post" ?>
                        </a>                       
                        <div class="row">
                            <label class="label">Image Caption</label>
                            <label class=""><small><?= empty($caption) ? "No caption yet. Select a post" : $caption ?></small></label>
                            <input name="caption" hidden="" value="<?= empty($caption) ? "" : $caption ?>" required="" type="text" style="width: 500px"/> 
                        </div>
                        <div class="row ntm">
                            <label class="label">Reference</label>
                            <label class=""><small><?= empty($href) ? "No reference yet. Select a post" : $href ?></small></label>
                            <input name="href" hidden="" value="<?= empty($href) ? "" : $href ?>" required="" type="text" style="width: 500px"/> 
                        </div>
                        <label class="label" >Size</label>
                        <div class="row ntm">
                            <select name="size" required="" class="span2" style="width: 200px">
                                <?php
                                $size = isset($size) ? $size : "";
                                if (count($largeImages) < 4) { //max 4 large images  
                                    ?>
                                    <option id="large" <?= strcasecmp($size, "LARGE") === 0 ? "checked" : "" ?> >LARGE</option>
                                    <?php
                                }
                                if (count($smallImages) < 6) { //max 6 small images  
                                    ?>
                                    <option  id="small" <?= strcasecmp($size, "SMALL") === 0 ? "checked" : "" ?>>SMALL</option>
                                <?php } ?>
                            </select>
                        </div>
                        <Script Language="javascript">
                            $("#large").click(function () {
                                $("#hint").show();
                                $("#hint_text").html('<strong>Description :</strong> This image appears on homepage sliders.<br/>\n\
                         Specification: Landscape, width >= 700px, height >= 400px');
                            });
                            $("#small").click(function () {
                                $("#hint").show();
                                $("#hint_text").html('<strong>Description :</strong> Square, width and height greater or equal to 230px');
                            });
                        </script>
                        <div id="hint" hidden="">
                            <div class="row" >
                                <div class="notice marker-on-top bg-NACOSS-UNN span3">
                                    <small id="hint_text"> </small>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <label class="label">Image</label> 
                        <div class="row ntm">
                            <div class="span4">
                                <input name="image" class="" style="width: inherit" type="file" />
                            </div>
                        </div>
                        <div class="row">
                            <input type="submit"  class="button bg-blue bg-hover-dark fg-white" name="addImage" value="Add Image"/>
                        </div>
                    </form>
                </div>
            </div>
        <?php } ?>
    </div>
</div>