<?php
require_once './class_lib.php';
$user = new User();
?>

<div class="">
    <div class="navigation-bar bg-NACOSS-UNN">
        <div class="container">
            <div class="navigation-bar-content">
                <a class="element  bg-hover-dark" href="index.php">NACOSS UNN</a>
                <span class="element-divider"></span>
                <a class="element1 pull-menu" href="#"></a>
                <ul class="element-menu">
                    <li class="on-phone on-tablet no-desktop">
                        <?php if ($user->isLoggedIn()) { ?>
                            <a class="bg-hover-dark" href="profile.php">Profile</a>
                        <?php } else { ?>
                            <a class="bg-hover-dark" href="login.php">Login | Register</a>
                        <?php } ?>
                    </li>
                    <li>
                        <a class="bg-hover-dark" target="_blank" href="#">Forum</a>
                    </li>
                    <li>
                        <a class="bg-hover-dark" href="prospectus.php">Prospectus</a>
                    </li>
                    <?php if ($user->isLoggedIn()) { ?>
                        <li>
                            <a class="bg-hover-dark" href="library.php">Library</a>
                        </li>
                    <?php } ?>
                    <li>
                        <a class="bg-hover-dark" href="news.php">News</a>
                    </li>
                    <li>
                        <a class="bg-hover-dark" target="_blank" href="#">Alumni</a>
                    </li>
                    <li>
                        <a class="bg-hover-dark" href="contact.php">Contact</a>
                    </li>
                    <li>
                        <a class="bg-hover-dark" href="about.php">About Us</a>
                    </li>

                </ul>

                <div class="no-phone no-tablet">

                    <span class="element-divider place-right"></span>
                    <?php if ($user->isLoggedIn()) { ?>
                        <a href="profile.php" title="Profile" class="element bg-transparent bg-hover-dark place-right">
                            <i class="icon-user"></i> &nbsp <?= $user->getDisplayName() ?>
                        </a>
                    <?php } else { ?>
                        <a href="login.php" title="Login or Register" class="element bg-transparent bg-hover-dark place-right">
                            Login | Register
                        </a>
                    <?php } ?>

                    <!--
                                        <span class="element-divider place-right"></span>
                    
                                        <a class="element place-right fg-lightRed bg-hover-lightRed fg-hover-white" href="#" target="_blank">
                                            <i class="icon-google-plus"></i>
                                        </a>
                                        <a class="element place-right fg-darkBlue bg-hover-darkBlue fg-hover-white" href="#" target="_blank">
                                            <i class="icon-facebook"></i>
                                        </a>-->
                </div>
            </div>
        </div>
    </div>
</div>
