<?php
//Initializing variables with default values
$defaultPage = "index.php?p=2";
$smsPageLength = 158;
$bills = getByCol('messenger_sms_biller', 'user_id', $admin->getAdminID());
?>
<script type="text/javascript">
    function messageCounter() {
        var pageLength = <?php echo $smsPageLength; ?>;
        var txt_len = document.getElementById('message_body').innerHTML.length;
        var showLen = pageLength - txt_len;
        var numPage = 1;
        while (showLen < 0) {
            showLen = showLen + pageLength;
            numPage++;
        }

        document.getElementById('pg').innerHTML = numPage;
        document.getElementById('pages').setAttribute('value', numPage);
        document.getElementById('len').innerHTML = showLen;
    }
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
    <h4>COMPOSE MESSAGE: SMS</h4>
    <div class="row">
        <div class="span10">
            <a href="index.php?p=21" class="button bg-blue bg-hover-dark fg-white place-right">E-Mail</a>
            <a href="index.php?p=2" class="button disabled place-right"> SMS </a>
        </div>
    </div>
    <form method="post" enctype="multipart/form-data" action="?p=26">
        <input type="hidden" name="type" value="sms"/>
        <input type="hidden" name="pages" id="pages" value="1"/>
        <input type="hidden" name="next" value="1"/>
        <div class="row" >
            <div class="span10">
                <input name="sender_id" required style="width: inherit" type='text' tabindex='1' maxlength="11" placeholder="Sender ID" value="<?= $bills['default_sender_id']; ?>"/>
            </div>
        </div>

        <div class="row" >
            <div class="span10">
                <textarea name='message_body' required style="width: inherit" tabindex='2' onchange="messageCounter()" placeholder="Message body" id="message_body"></textarea>
            </div>
        </div>

        <div class="row" >
            <div class="span1">Page: </div><div class="span1" id="pg">1</div>
            <div class="span1">Length: </div><div class="span2"><span id="len"><?php echo $smsPageLength; ?></span>
                /<?php echo $smsPageLength; ?></div>
        </div>

        <div class="row no-phone text-left">
            <input class="button default bg-NACOSS-UNN bg-hover-dark" type='reset' value='Reset' tabindex='3'/>
            <input class="button default bg-NACOSS-UNN bg-hover-dark" type='submit' value='Next' tabindex='4' name="next1"/>
        </div>

        <div class="row on-phone no-tablet no-desktop padding20 ntp nbp">
            <input class="button default bg-NACOSS-UNN bg-hover-dark"  type='reset' value='Reset' tabindex='3'/>
            <input class="button default bg-NACOSS-UNN bg-hover-dark" type='submit' value='Next' tabindex='4' name="next2"/>
        </div>

    </form>
</div>
</div>