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
require_once('../class.Uploader.php');
require_once('../class.DocumentUploader.php');
require_once('../class.VideoUploader.php');
?>
<script type="text/javascript" src="<?= HOSTNAME ?>js/jquery/jquery.min.js"></script>
<script type="text/javascript" src="<?= HOSTNAME ?>js/jquery/jquery.form.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        var options = {
            target: '#requestResponse', // target element(s) to be updated with server response 
            beforeSubmit: beforeSubmit, // pre-submit callback 
            uploadProgress: OnProgress, //upload progress callback 
            success: afterSuccess, // post-submit callback 
            resetForm: false        // reset the form after successful submit 
        };

        $('#newLibItemForm').submit(function () {
            $(this).ajaxSubmit(options);
            // always return false to prevent standard browser submit and page navigation 
            return false;
        });

//function to check file size before uploading.
        function beforeSubmit() {
            //check whether browser fully supports all File API
            if (window.File && window.FileReader && window.FileList && window.Blob)
            {
                var fsize = $('#FileInput')[0].files[0].size; //get file size
                var ftype = $('#FileInput')[0].files[0].type; // get file type
                $('#media').val(ftype);
                var maxFileSize = $('#max_Fsize').val();
                var supportedTypes = $('#supportedFtypes').val().split(',');
//		$.makeArray(supportedTypes);


                if (!$('#FileInput').val() && !$('#LinkInput').val()) //check empty input filed
                {
                    $("#requestResponse").html("<span class='fg-red'>Please select a file from your hard drive or input a url</span>");
                    $('#LinkInput').focus();
                    return false
                } else if ($('#FileInput').val()) {
                    if (fsize > maxFileSize) {
                        $("#requestResponse").html("<span class='fg-red'><b>" + bytesToSize(fsize) + "</b>File is too big, it should be less than " + bytesToSize(maxFileSize) + "</span>");
                        return false;
                    }
                    if ($.inArray(ftype, supportedTypes) == -1) {
                        $("#requestResponse").html("<span class='fg-red'><b>" + ftype + "</b> Unsupported file type!</span>");
                        return false;
                    }
                    $('#LinkInput').val('');
                    $('#file_source').val('FileInput');
                }
                else if ($('#LinkInput').val()) {
                    //add client side cross server file validation
                    $('#FileInput').val('');
                    $('#file_source').val('LinkInput');
                }

                //$('#input-file-wrapper').hide(); //hide submit button
                $("#requestResponse").html("");
                $('#progressbox').show(); //hide submit button
            }
            else
            {
                //Output error to older unsupported browsers that doesn't support HTML5 File API
                $("#requestResponse").html("Please upgrade your browser, because your current browser lacks some new features we need!");
                return false;
            }
        }

//progress bar function
        function OnProgress(event, position, total, percentComplete)
        {
            //Progress bar
            $('#progressbox').show();
            $('#progressbar').width(percentComplete + '%') //update progressbar percent complete
            $('#statustxt').html(percentComplete + '%'); //update status text
            if (percentComplete > 50)
            {
                $('#statustxt').css('color', '#FFFFFF'); //change status text to white after 50%
            }
        }

//function after succesful file upload (when server response)
        function afterSuccess()
        {
            $('#statustxt').html('Complete'); //update status text
            $('#progressbox').delay(4000).fadeOut();
            //$('#input-file-wrapper').delay(5000).fadeIn(); //hide submit button
        }

//function to format bites bit.ly/19yoIPO
        function bytesToSize(bytes) {
            var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
            if (bytes === 0)
                return '0 Bytes';
            var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
            return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
        }

    });
</script>

<style type="text/css">
    #upload-wrapper {
        padding: 4px;
        border-radius: 4px;
    }
    #upload-wrapper input[type=file] {
        border:2px solid #06F;
        width:100%;
        color:#06F;
        font-size:0.65em;
    }
    #progressbox {
        border: 1px solid #06F;
        padding: 2px; 
        position:relative;
        width:100%;
        display:none;
        text-align:left;
    }
    #progressbar {
        height:1.1em;
        background-color: #093;
        width:1%;
    }
    #statustxt {
        top:1px;
        bottom:1px;
        left:50%;
        position:absolute;
        display:inline-block;
        color: #000000;
    }
</style>
<div>
    <h4>New Library Entry</h4>
    <div id="progressbox" ><div id="progressbar"></div ><div id="statustxt">0%</div></div>
    <form method="post" enctype="multipart/form-data" action="_processor.library.php" id="newLibItemForm" onreset='$("#requestResponse").html()'>
        <input type="hidden" value="<?= Uploader::uploadLimit(); ?>" id="max_Fsize"/>
        <input type="hidden" value="<?= implode(',', array_merge(DocumentUploader::MIME(), VideoUploader::MIME())); ?>" id="supportedFtypes"/>

        <input type="hidden" name="file_source_type" id="file_source" value=""/>
        <input type="hidden" name="media" id="media" value=""/>

        <div class="row" id="requestResponse"></div>
        <div class="row ntm" >
            <label class="span2">Title: <span class="fg-red">*</span></label>
            <div class="span10">
                <input name='title' required style="width: inherit" type='text' tabindex='1' />
            </div>
        </div>

        <div class="row ntm" >
            <label class="span2">Author: <span class="fg-red">*</span></label>
            <div class="span10">
                <input name='author' required style="width: inherit" type='text' tabindex='2' />
            </div>
        </div>

        <div class="row ntm" >
            <label class="span2">Publisher: <span class="fg-red">*</span></label>
            <div class="span10">
                <input name='publisher' style="width: inherit" type='text' required tabindex='3'/>
            </div>
        </div>

        <div class="row ntm" >
            <label class="span2">Date Published: <span class="fg-red">*</span></label>
            <div class="span10">
                <input name='date_published' style="width: inherit" type="date" required placeholder="year" tabindex='4' maxlength="4"/>
            </div>
        </div>

        <div class="row ntm" >
            <label class="span2">ISBN: </label>
            <div class="span10">
                <input name='isbn' style="width: inherit" type="text" tabindex='5' maxlength="15"/>
            </div>
        </div>

        <div class="row ntm" >
            <label class="span2">Category: <span class="fg-red">*</span></label>
            <div class="span10">
                <input name='category' style="width: inherit" type='text' required tabindex='7' maxlength="20"/>
            </div>
        </div>

        <div class="row ntm" >
            <label class="span2">Sub-Category: <span class="fg-red">*</span></label>
            <div class="span10">
                <input name='sub_category' style="width: inherit" type='text' required tabindex='8' maxlength="20"/>
            </div>
        </div>

        <div class="row ntm" >
            <label class="span2">Keywords: <span class="fg-red">*</span></label>
            <div class="span10">
                <input name='keywords' style="width: inherit" type='text' required tabindex='6' maxlength="40"/>
            </div>
        </div>

        <div class="row ntm">
            <label class="span2">File Source:[<span class="fg-red">Local*</span>]
            </label>
            <div class="span10" id="upload-wrapper">
                <div id="input-file-wrapper"><input name="FileInput" id="FileInput" type="file" tabindex="9"/></div>
            </div>
        </div>
        <div class="row ntm">
            <label class="span2"><span class="fg-red">OR</span>: [<span class="fg-red">Web*</span>]
            </label>
            <div class="span10">
                <input name="LinkInput" id="LinkInput" type="url" style="width: inherit" tabindex="10" placeholder="Paste url of file"/>
            </div>
        </div>
        <div class="row offset2">
            <input class="button default bg-NACOSS-UNN bg-hover-dark" type='reset' value='Reset' tabindex='11'/>
            <input class="button default bg-NACOSS-UNN bg-hover-dark" type='submit' value='Add New Entry' tabindex='12'/>
        </div>
    </form>
</div>