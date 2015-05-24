<?php
//Initializing variables with default values
$defaultPage = "index.php?p=1";
$request = false;
?>
<script>
    function warn() {
//        var ok = confirm("Are you sure?");
//        if(ok === false){
//            //Cancel request
//            window.stop();
//        }
    }
    ;
</script>
<div>
    <h4>COMPOSE MESSAGE: E-Mail</h4>
    <div class="row">
        <div class="span10">
            <a href="index.php?p=21" class="button disabled place-right">E-Mail</a>
            <a href="index.php?p=2" class="button bg-blue bg-hover-dark fg-white place-right"> SMS </a>
        </div>
    </div>
    <div class="row" id="requestResponse"></div>
    <form method='post' enctype='multipart/form-data' action='?p=26'>
        <input type="hidden" name="type" value="email"/>
        <input type="hidden" name="next" value="1"/>
        <div class="grid" >
            <div class="row" >
                <div class="span10">
                    <input name='senders_name' required style="width: inherit" type='text' tabindex='1' placeholder="From: ..."/>
                </div>
            </div>
            <div class="row" >
                <div class="span10">
                    <input name='reply_to' required style="width: inherit" type="email" tabindex='2' placeholder="Reply To: ..."/>
                </div>
            </div>
            <div class="row" >
                <div class="span10">
                    <input name='subject' required style="width: inherit" type='text' tabindex='3' placeholder="Subject: ..."/>
                </div>
            </div>
            <div class="row" >
                <div class="span10">
                    <textarea name='message_body' style="width: inherit; min-height:100px" tabindex='4' placeholder="Message goes here..." required="required"></textarea>
                </div>
            </div>

            <div class="row no-phone text-left">
                <input class="button default bg-NACOSS-UNN bg-hover-dark" type='reset' value='Reset' tabindex='5'/>
                <input class="button default bg-NACOSS-UNN bg-hover-dark" type='submit' value='Next' tabindex='6'/>
            </div>

            <div class="row on-phone no-tablet no-desktop padding20 ntp nbp">
                <input class="button default bg-NACOSS-UNN bg-hover-dark"  type='reset' value='Reset' tabindex='5'/>
                <input class="button default bg-NACOSS-UNN bg-hover-dark" type='submit' value='Next' tabindex='6'/>
            </div>
        </div>
    </form>
</div>