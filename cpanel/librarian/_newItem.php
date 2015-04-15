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

require_once('../class.documentUploader.php');
require_once('../class.videoUploader.php');
//Initializing variables with default values
$defaultPage = "index.php?p=3";

$request=false;
$title='';
$author='';
$publisher='';
$date_published='';
$isbn='';
$keywords='';
$category='';
$sub_category='';

if(isset($_FILES["FileInput"]))
{
exit;
}
/*
const MEDIA = "ebook";
$sort_type = SORT_LIBRARY_TYPE_TITLE;
$order = ORDER_LIBRARY_ASC;
$s = filter_input(INPUT_GET, "sh");
$on_shelf = $s=='0' ? 0 : 1;
$searchQuery = "";

if (isset($array['search_button']) || //$array from index.php
        isset($array['restore_button']) ||
        isset($array['suspend_button']) ||
		isset($array['delete_button'])) {

    //process POST requests
    $page = 1;

    $searchQuery = html_entity_decode(filter_input(INPUT_POST, "search"));
    $sort_type = html_entity_decode(filter_input(INPUT_POST, "sort_type"));
    $order = html_entity_decode(filter_input(INPUT_POST, "sort_order"));

    try {
        if (isset($array['restore_button'])) {
            $actionPerformed = true;
            restoreLibraryItems($array['checkbox']);
        } elseif (isset($array['suspend_button'])) {
            $actionPerformed = true;
            suspendLibraryItems($array['checkbox']);
        } elseif (isset($array['delete_button'])) {
            $actionPerformed = true;
            deleteLibraryItems($array['checkbox']);
		}
        $success = true;
        $error_message = "";
    } catch (Exception $exc) {
        $success = false;
        $error_message = $exc->getMessage();
    }
    $books = searchLibraryItems($searchQuery, MEDIA, $on_shelf, $sort_type, $order);
} else {
    //Process GET requests or no requests
    $page = filter_input(INPUT_GET, "pg");
    if (isset($page)) {
        //if switching page, repeat search
        $searchQuery = filter_input(INPUT_GET, "q");
        $sort_type = filter_input(INPUT_GET, "s");
        $order = filter_input(INPUT_GET, "o");

        $books = searchLibraryItems($searchQuery, MEDIA, $on_shelf, $sort_type, $order);
    } else {
        $page = 1;
        $books = getLibraryItems(MEDIA, $on_shelf);
    }
}
*/
?>
<script type="text/javascript" src="<?=HOSTNAME?>js/jquery/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="<?=HOSTNAME?>js/jquery/jquery.form.min.js"></script>

<script type="text/javascript">
$(document).ready(function() { 
	var options = { 
			target:   '#requestResponse',   // target element(s) to be updated with server response 
			beforeSubmit:  beforeSubmit,  // pre-submit callback 
			uploadProgress: OnProgress, //upload progress callback 
			success:       afterSuccess,  // post-submit callback 
			resetForm: true        // reset the form after successful submit 
		};
		
	 $('#newLibItemForm').submit(function() { 
			$(this).ajaxSubmit(options);  			
			// always return false to prevent standard browser submit and page navigation 
			return false; 
		}); 
		
//function to check file size before uploading.
function beforeSubmit(){
    //check whether browser fully supports all File API
   if (window.File && window.FileReader && window.FileList && window.Blob)
	{
		var fsize = $('#FileInput')[0].files[0].size; //get file size
		var ftype = $('#FileInput')[0].files[0].type; // get file type
		var maxFileSize = $('#max_Fsize').val();
		var supportedTypes = $('#supportedFtypes').val().split(',');
//		$.makeArray(supportedTypes);
		

		if( !$('#FileInput').val() && !$('#LinkInput').val()) //check empty input filed
		{
			$("#requestResponse").html("<span class='fg-red'>Please select a file from your hard drive or input a url</span>");
			$('#LinkInput').focus();
			return false
		}else if( $('#FileInput').val()){
			if( fsize > maxFileSize ){
				$("#requestResponse").html("<span class='fg-red'><b>"+bytesToSize(fsize) +"</b> Too big file! <br />File is too big, it should be less than "+bytesToSize(maxFileSize)+"</span>");
				return false;
			}
			if( $.inArray(ftype, supportedTypes ) == -1 ){
				$("#requestResponse").html("<span class='fg-red'><b>"+ftype+"</b> Unsupported file type!</span>");
				return false;
			}
			$('#LinkInput').val('');
			$('#file_source').val('FileInput');
		}
		else if( $('#LinkInput').val() ){
			//add client side cross server file validation
			$('#FileInput').val('');
			$('#file_source').val('LinkInput');
		}
						
		$('#input-file-wrapper').hide(); //hide submit button
		$('#progressbox').show(); //hide submit button
		$("#requestResponse").html("");  
	}
	else
	{
		//Output error to older unsupported browsers that doesn't support HTML5 File API
		$("#requestResponse").html("Please upgrade your browser, because your current browser lacks some new features we need!");
		return false;
	}
}

//function after succesful file upload (when server response)
function afterSuccess()
{
	$('#progressbox').delay( 1000 ).fadeOut(); //hide progress bar
	$('#input-file-wrapper').show(); //hide submit button
}

//progress bar function
function OnProgress(event, position, total, percentComplete)
{
    //Progress bar
	$('#progressbox').show();
    $('#progressbar').width(percentComplete + '%') //update progressbar percent complete
    $('#statustxt').html(percentComplete + '%'); //update status text
    if(percentComplete>50)
        {
            $('#statustxt').css('color','#000'); //change status text to white after 50%
        }
}

//function to format bites bit.ly/19yoIPO
function bytesToSize(bytes) {
   var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
   if (bytes == 0) return '0 Bytes';
   var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
   return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}

}); 
</script>

<style type="text/css">
#upload-wrapper {
	background: #3D91A2;
	padding: 4px;
	border-radius: 4px;
}
#upload-wrapper input[type=file] {
	background: #3D91A2;
	border-radius: 5px;
	border:2px solid #FFFFFF;
	width:100%;
	color:#FFFFFF;
	font-size:0.65em;
}
#progressbox {
	border: 1px solid #FFFFFF;
	padding: 2px; 
	position:relative;
	width:100%;
	border-radius: 5px;
	display:none;
	text-align:left;
}
#progressbar {
	height:1.1em;
	border-radius: 3px;
	background-color: #CAF2FF;
	width:1%;
}
#statustxt {
	top:1px;
	bottom:1px;
	left:50%;
	position:absolute;
	display:inline-block;
	color: #FFFFFF;
}
</style>
<div>
	<h4>New Library Entry</h4>
    <form method="post" enctype="multipart/form-data" action="_processor.newItem.php" id="newLibItemForm">
            	<div class="row" id="requestResponse"></div>
                <div class="row" >
                    <label class="span2">Title: <span class="fg-red">*</span></label>
                    <div class="span7">
                        <input name='title' required style="width: inherit" type='text' 
                               <?= $request ? "value='$title'" : ""; ?> tabindex='1' />
                    </div>
                </div>

                <div class="row" >
                    <label class="span2">Author: <span class="fg-red">*</span></label>
                    <div class="span7">
                        <input name='author' required style="width: inherit" type='text' 
                               <?= $request ? "value='$author'" : ""; ?> tabindex='2' />
                    </div>
                </div>

                <div class="row" >
                    <label class="span2">Publisher: <span class="fg-red">*</span></label>
                    <div class="span7">
                        <input name='publisher' style="width: inherit" type='text' required 
                               <?= $request ? "value='$publisher'" : ""; ?>  tabindex='3'/>
                    </div>
                </div>

                <div class="row" >
                    <label class="span2">Date Published: <span class="fg-red">*</span></label>
                    <div class="span7">
                        <input name='date_published' style="width: inherit" type='number' required placeholder="year" 
                               <?= $request ? "value='$date_published'" : ""; ?>  tabindex='4' maxlength="4"/>
                    </div>
                </div>

                <div class="row" >
                    <label class="span2">ISBM: <span class="fg-red">*</span></label>
                    <div class="span7">
                        <input name='isbn' style="width: inherit" type="text" required 
                               <?= $request ? "value='$isbn'" : ""; ?>  tabindex='5' maxlength="15"/>
                    </div>
                </div>

                <div class="row" >
                    <label class="span2">Keywords: <span class="fg-red">*</span></label>
                    <div class="span7">
                        <input name='keywords' style="width: inherit" type='text' required 
                               <?= $request ? "value='$keywords'" : ""; ?>  tabindex='6' maxlength="40"/>
                    </div>
                </div>

                <div class="row" >
                    <label class="span2">Category: <span class="fg-red">*</span></label>
                    <div class="span7">
                        <input name='category' style="width: inherit" type='text' required 
                               <?= $request ? "value='$category'" : ""; ?>  tabindex='7' maxlength="20"/>
                    </div>
                </div>

                <div class="row" >
                    <label class="span2">Sub-Category: <span class="fg-red">*</span></label>
                    <div class="span7">
                        <input name='sub_category' style="width: inherit" type='text' required 
                               <?= $request ? "value='$sub_category'" : ""; ?>  tabindex='8' maxlength="20"/>
                    </div>
                </div>

                <div class="row">
                    <label class="span2">File Source:[<span class="fg-red">Local*</span>]
                    </label>
                    <div class="span7" id="upload-wrapper">
                        <div id="input-file-wrapper"><input name="FileInput" id="FileInput" type="file" tabindex="9"/></div>
                        <div id="progressbox" ><div id="progressbar"></div ><div id="statustxt">0%</div></div>
                    </div>
                </div>
                <div class="row">
                    <label class="span2"><span class="fg-red">OR</span>: [<span class="fg-red">Web*</span>]
                    </label>
                    <div class="span7">
                        <input name="LinkInput" id="LinkInput" type="url" style="width: inherit" tabindex="10"
                        <?= $request ? "value='$sub_category'" : ""; ?> placeholder="Paste url of file on the web"/>
                    </div>
                </div>
                <div class="row no-phone offset2">
                    <input class="button default bg-NACOSS-UNN bg-hover-dark" type='submit' value='Send Message' tabindex='11'/>
                </div>
                <div class="row on-phone no-tablet no-desktop padding20 ntp nbp">
                    <input class="button default bg-NACOSS-UNN bg-hover-dark" type='submit' value='Send Message' tabindex='11'/>
                </div>
                <input type="hidden" name="file_source_type" value="" id="file_source"/>
                <input type="hidden" name="max_Fsize" value="<?= uploader::uploadLimit(); ?>" id="max_Fsize"/>
                <input type="hidden" name="supportedFtypes" 
                value="<?= implode(',',array_merge(documentUploader::MIME(), videoUploader::MIME())); ?>" id="supportedFtypes"/>
    </form>
</div>