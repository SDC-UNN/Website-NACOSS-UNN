<div class="bg-dark">
    <div class="container tertiary-text bg-dark fg-white" style="padding: 10px">
        &copy; <a href="<?= NDG_HOMEPAGE ?>" target="_blank" class="fg-white fg-hover-yellow fg-active-amber">NACOSS UNN Developers Group (NDG)</a>
        <div class="place-right compact">
            <a id="feedBackLink" class="fg-white fg-hover-yellow fg-active-amber"> FeedBack </a>
            &nbsp;|&nbsp;
            <a href="contact.php" class="fg-white fg-hover-yellow fg-active-amber"> Contact Us </a>
            &nbsp;|&nbsp;
            <a href="faq.php" class="fg-white fg-hover-yellow fg-active-amber"> FAQs</a>
        </div>
    </div>
</div>

<script>
    $(function () {
        $("#feedBackLink").on('click', function () {
            $.Dialog({
                overlay: true,
                shadow: true,
                flat: true,
                icon: '<img src="favicon.ico">',
                title: 'Feedback',
                content: '<div class="span5">' +
                        '<label id="feedBackLabel">We appreciate your feedback. What do you want to tell us?</label>' +
                        '<textarea rows="5" id="feedBackMessage" class="span5"></textarea>' +
                        '<div id="feedBackButtonDiv">' +
                        '<button class="bg-NACOSS-UNN bg-hover-amber" onclick="sendFeedBack()">Send FeedBack</button>' +
                        '</div>' +
                        '</div>',
                padding: 10
            });
        });
    });

    function sendFeedBack() {
        var msg = document.getElementById("feedBackMessage").innerHTML;
        alert(msg);
        if (msg !== "") {
            var xmlHttp;
            if (window.XMLHttpRequest) {
                xmlHttp = new XMLHttpRequest();
            } else {
                xmlHttp = new ActiveObject("Microsoft.XMLHTTP");
            }
            xmlHttp.onreadystatechange = function () {
                if (xmlHttp.status === 200 && xmlHttp.readyState === 4 && xmlHttp.responseText === "OK") {
                    document.getElementById("feedBackLabel").setAttribute("class", "padding5 text-center");
                    document.getElementById("feedBackButtonDiv").setAttribute("hidden", "true");
                    document.getElementById("feedBackMessage").setAttribute("hidden", "true");
                    document.getElementById("feedBackLabel").innerHTML = "Thanks for your feedback!<br/>Our team is currently on it";
                }
            };

            xmlHttp.open("GET", "xmlhttp.php?op=feedback&msg=" + msg, true);
            xmlHttp.send();
        } else {
            document.getElementById("feedBackLabel").innerHTML = "Message box is empty!";
            document.getElementById("feedBackLabel").setAttribute("class", "padding5");
            document.getElementById("feedBackLabel").setAttribute("style", "background: pink");
        }
    }
</script>