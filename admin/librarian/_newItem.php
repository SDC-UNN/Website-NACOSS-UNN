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

//Initializing variables with default values
$defaultPage = "index.php?p=3";
require_once '../class_lib.php';
require_once('./LibraryAdmin.php');


$message2 = "";
if (!empty($array["zipSubmit"])) {
    try {
        $files = $admin->uploadZip();
        if ($files) {
            $message2 = "<p class='padding15 bg-green'>Files Uploaded</p>"
                    . "<div>"
                    . "<ul>";
            foreach ($files as $file) {
                $message2 .= "<li>$file</li>";
            }
            $message2.= "</ul>"
                    . "</div>";
        } else {
            $message2 = "<p class='padding15 bg-amber'>No File Uploaded</p>";
        }
    } catch (Exception $exc) {
        $message2 = "<p class='padding5' style='background: pink'>" . $exc->getMessage() . "</p>";
    }
}

$message1 = "";
if (!empty($array["fileSubmit"])) {
    try {
        $message1 = $admin->uploadFile($array);
    } catch (Exception $exc) {
        $message1 = "<p class='padding5' style='background: pink'>" . $exc->getMessage() . "</p>";
    }
}
?>
<div>
    <h4>New Library Entry</h4>
    <div id="progressbox" hidden class="span8 bg-NACOSS-UNN" >
        <div id="progressbar" class="padding5 ribbed-dark text-center">0%</div >
        <div class="row" id="requestResponse"></div>            
    </div>
    <div class="panel" >
        <div class="panel-header">Upload a File</div>
        <form method="post" enctype="multipart/form-data" action="<?= $defaultPage ?>" class="panel-content">
            <div class="padding15"><?= $message1 ?></div>
            <div class="row ntm" >
                <label class="span2">Title: <span class="fg-red">*</span></label>
                <div class="span10">
                    <input name='title' required style="width: inherit" type='text' tabindex='1' />
                </div>
            </div>

            <div class="row ntm" >
                <label class="span2">Author:</label>
                <div class="span10">
                    <input name='author' style="width: inherit" type='text' tabindex='2' />
                </div>
            </div>

            <div class="row ntm" >
                <label class="span2">Publisher:</label>
                <div class="span10">
                    <input name='publisher' style="width: inherit" type='text' tabindex='3'/>
                </div>
            </div>

            <div class="row ntm" >
                <label class="span2">Date Published:</label>
                <div class="span10">
                    <input name='date_published' style="width: inherit" type="date" placeholder="year" tabindex='4' maxlength="4"/>
                </div>
            </div>

            <div class="row ntm" >
                <label class="span2">ISBN: </label>
                <div class="span10">
                    <input name='isbn' style="width: inherit" type="text" tabindex='5' maxlength="15"/>
                </div>
            </div>

            <div class="row ntm" >
                <label class="span2">Category:</label>
                <div class="span10">
                    <input name='category' style="width: inherit" type='text' tabindex='7' maxlength="50"/>
                </div>
            </div>

            <div class="row ntm" >
                <label class="span2">Sub-Category:</label>
                <div class="span10">
                    <input name='sub_category' style="width: inherit" type='text' tabindex='8' maxlength="50"/>
                </div>
            </div>

            <div class="row ntm" >
                <label class="span2">Contributor:</label>
                <div class="span10">
                    <input name='contributor' style="width: inherit" type='text' tabindex='8' maxlength="20"/>
                </div>
            </div>

            <div class="row ntm" >
                <label class="span2">Keywords:</label>
                <div class="span10">
                    <input name='keywords' style="width: inherit" type='text' tabindex='6' maxlength="40"/>
                </div>
            </div>
            <div class="row ntm bg-grayLighter">
                <div class="padding5">
                    <div class="span12 fg-red">Select one option</div>
                    <div class="row ntm">
                        <label class="span2">File Source: </label>
                        <div class="span10">
                            <input name="FileInput" style="width: inherit" type="file" tabindex="9"/>
                        </div>
                    </div>
                    <div class="row ntm">
                        <label class="span2">OR Link: </label>
                        <div class="span10">
                            <input name="LinkInput" type="url" style="width: inherit" tabindex="10" placeholder="Enter or Paste url"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row offset2">
                <input class="button default bg-NACOSS-UNN bg-hover-dark" type='reset' value='Clear' tabindex='11'/>
                <input class="button default bg-NACOSS-UNN bg-hover-dark" name="fileSubmit" type='submit' value='Upload File' tabindex='12'/>
            </div>
        </form>
    </div>
    <br/>
    <div class="panel" id="zip">
        <div class="panel-header">Upload Zip</div>
        <div class="panel-content">
            <div class="">
                <strong>Instructions</strong><br/>
                All materials should be in the root folder of the zip file and their filenames should be in the format [title of material]-by-[name of author].extension<br/>
                e.g. A pdf document with title &apos;Programming&apos; and Author &apos;Some Author&apos; should
                have the filename Programming-by-Some Author.pdf<br/>
                Note that folders in the root of the zip file will be ignored.<br/>
            </div>
            <div>
                <div class="padding15"><?= $message2 ?></div>
                <form action="<?= $defaultPage ?>#zip" method="post" enctype="multipart/form-data" class="">
                    <label class="label">Select zip file</label><br/>
                    <input type="file" required name="zipFile" class="FileInput" accept=".zip"/>
                    <input type="reset" class="button default bg-NACOSS-UNN bg-hover-dark" value="Clear"/>
                    <input type="submit" class="button default bg-NACOSS-UNN bg-hover-dark" name="zipSubmit" value="Upload Zip"/>
                </form>
            </div>
        </div>
    </div>
</div>