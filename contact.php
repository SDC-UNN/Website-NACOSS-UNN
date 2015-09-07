<?php
require_once 'class_lib.php';
$request = filter_input(INPUT_POST, "submit");
if (isset($request)) {
    //Set values
    $contact_email = UserUtility::getContactEmail();

    $user_email = html_entity_decode(filter_input(INPUT_POST, "email"));
    $company = html_entity_decode(filter_input(INPUT_POST, "company"));
    $comment = html_entity_decode(filter_input(INPUT_POST, "message"));
    $name = html_entity_decode(filter_input(INPUT_POST, "name"));
    $address = html_entity_decode(filter_input(INPUT_POST, "address"));
    $city = html_entity_decode(filter_input(INPUT_POST, "city"));
    $region = html_entity_decode(filter_input(INPUT_POST, "region"));
    $phone = html_entity_decode(filter_input(INPUT_POST, "phone"));

    //Message
    $message = "Client name: " . $name;
    $message .= "\r\nCompany: " . $company;
    $message .= "\r\nAddress: " . $address;
    $message .= "\r\nCity: " . $city;
    $message .= "\r\nState/Region: " . $region;
    $message .= "\r\nPhone: " . $phone;
    $message .= "\r\n\n" . $comment;


    if (isset($user_email) && isset($contact_email) && isset($comment)) {
        try {
            if (mail($contact_email, "Subject: Email from Website", wordwrap($message, 70, "\r\n"), "From: " . $user_email . "\r\n" .
                            'Reply-To: ' . $contact_email . "\r\n" .
                            'X-Mailer: PHP/' . phpversion())) {
                $success = true;
                $comment = "";
            } else {
                $success = false;
            }
        } catch (Exception $exc) {
            UserUtility::writeToLog($exc);
            $success = false;
        }
    } else {
        $success = false;
    }
}
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

<html>
    <head>
        <?php require_once 'default_head_tags.php'; ?>

        <!-- Page Title -->
        <title>NACOSS UNN : Contact Us</title>        
    </head>
    <body class="metro" style="background-image: url(img/bg.jpg); background-repeat: repeat;">
        <div class="container bg-white" id="wrapper">            
            <?php require_once 'header.php'; ?>
            <div class="padding20" id="inquiries">
                <div class="grid fluid">
                    <div class="row ntm">
                        <h1 class="fg-dark">Contact Us</h1>
                        <p>If you would like to get in touch with NACOSS UNN Chapter, here’s how you can reach us:</p>
                    </div>
                    <div class="row ntm">
                        <div class="row ntm">
                            <strong>LOCATION <i class="icon-location"></i></strong>
                            <br/>
                            <address class="">
                                Room 425, Department of Computer Science, Abuja Building, University of Nigeria, Nsukka.
                            </address>
                        </div>            
                        <div class="row ntm">
                            <iframe class="span12" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.191598794443!2d7.408535000000007!3d6.8676299999999975!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1044e7defeff9725%3A0xffb8a28c30660e7d!2sUniversity+of+Nigeria+Nsukka!5e0!3m2!1sen!2sng!4v1430176121283"  frameborder="0" style="border:0"></iframe>
                        </div>
                    </div>
                    <div class="row">
                        <strong>CALL <i class="icon-phone-2"></i></strong>
                        <br/>
                        <?php
                        $array = UserUtility::getContactNumbers();
                        for ($index = 0; $index < count($array); $index++) {
                            echo '<span class="fg-lightBlue">' . $array[$index] . '</span>';
                            if ($index < count($array) - 1) {
                                echo ', ';
                            }
                        }
                        ?>
                    </div>
                    <div class="row">
                        <strong>EMAIL <i class="icon-mail-2"></i></strong>
                        <p>If you would prefer to contact us via email, simply fill out the form below.</p>
                        <?php if ($request) { ?>
                            <div class="row container">
                                <div class="label">
                                    <?php if ($success) { ?>
                                        <h2 class="success fg-green">Thank You!</h2>
                                        <p>Your message has been sent, we will reply in a while.</p>
                                    <?php } else { ?>
                                        <h2 class="error fg-red">Sorry, we could not send your message at the moment.</h2>
                                        <p>
                                            please check and make sure your details are correct
                                        </p>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php }
                        ?>
                        <form method='post' enctype='multipart/form-data' action='contact.php#inquiries'>
                            <div class="row ntm" >
                                <label class="span2">Name<span class="fg-red">*</span></label>
                                <div class="span10">
                                    <input name='name' required style="width: inherit" type='text' 
                                           <?= $request ? "value='$name'" : ""; ?> tabindex='1' />
                                </div>
                            </div>
                            <div class="row ntm" >
                                <label class="span2">Company</label>
                                <div class="span10">
                                    <input name='company' style="width: inherit" type='text' 
                                           <?= $request ? "value='$company'" : ""; ?>  tabindex='2'/>
                                </div>
                            </div>
                            <div class="row ntm" >
                                <label class="span2">Address<span class="fg-red">*</span></label>
                                <div class="span10">
                                    <input type='text' required placeholder="Street Address" name='address' style="width: inherit"
                                           <?= $request ? "value='$address'" : ""; ?> tabindex='3' />
                                    <input type='text' required placeholder="City" name='city'
                                           <?= $request ? "value='$city'" : ""; ?> tabindex='4' />
                                    <input type='text' required placeholder="State / Region" name='region' 
                                           <?= $request ? "value='$region'" : ""; ?> tabindex='5'   />
                                </div>
                            </div>
                            <div class="row" >
                                <label class="span2">Phone</label>
                                <div class="span10">
                                    <input name='phone' type='tel' 
                                           <?= $request ? "value='$phone'" : ""; ?>  tabindex='6'  />
                                </div>
                            </div>
                            <div class="row ntm" >
                                <label class="span2">Email Address<span class="fg-red">*</span>
                                </label>
                                <div class="span10">
                                    <input name='email' required style="width: inherit" type='email' 
                                           <?= $request ? "value='$user_email'" : ""; ?>   tabindex='7'   />
                                </div>
                            </div>
                            <div class="row ntm">
                                <label class="span2">Comments<span class="fg-red">*</span>
                                </label>
                                <div class="span10">
                                    <textarea name='message' required style="width: inherit" tabindex='8' rows='10'><?= $request ? $comment : ""; ?></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <input class="offset2 span5 button default bg-NACOSS-UNN bg-hover-dark" type='submit'
                                       name='submit' value='Send Message' tabindex='9'/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php require_once 'footer.php'; ?>
        </div>
    </body>
</html>
