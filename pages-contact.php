<?php
global $shadow, $googlemap;
$shadow = ' ';
$googlemap = true;


include_once('templates/headers/head.php');
include_once('templates/headers/header2.php');

?>

    <div class="page-section bg-gray small-section">
        <div class="page-header">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <ol class="breadcrumb">
                            <li><a href="#">Home</a></li>
                            <li class="active">Contact us</li>
                        </ol>
                    </div>
                    <div class="col-md-8 text-right">
                        <h1>Contact us</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="main">
        <div class="page-section pad-bottom-60">
            <div class="container">
                <div class="googlemap mar-bottom-90" style="height:570px;" data-zoom="17" data-scrollwheel="1" data-style="8" data-location="Queen St/Collins St, Melbourne, Victoria, Australia" data-type="roadmap"></div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="contact-details mar-bottom-90">
                            <p>613 8376 6284 <br />121 King Street, Melbourne<br /> Victoria 3000 Australia</p>
                            <ul class="social-nav">
                                <li><a target="_blank" href="#"><i class="fa fa-facebook"></i></a> </li>
                                <li><a target="_blank" href="#"><i class="fa fa-twitter"></i></a> </li>
                                <li><a target="_blank" href="#"><i class="fa fa-instagram"></i></a> </li>
                                <li><a target="_blank" href="#"><i class="fa fa-linkedin"></i></a> </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <form class="contactform">
                            <h4 class="letter-spacing">We would love to hear from you</h4>
                            <div class="row">
                                <div class="col-md-4 col-sm-4">
                                    <p><input type="text" name="name" placeholder="Your Name" /></p>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <p><input type="text" name="email" placeholder="Your Email" /></p>
                                </div>
                                <div class="col-md-4 col-sm-4">
                                    <p><input type="text" name="website" placeholder="Your Website" /></p>
                                </div>
                            </div>
                            <p><input type="text" name="title" placeholder="Title" /></p>
                            <p><textarea name="message" placeholder="Your review"></textarea></p>
                            <p><input type="submit" class="btn btn-dark-b btn-lg" value="Send" /></p>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- #main -->

<?php

include_once('templates/footers/footer3.php');
include_once('templates/footers/foot.php');


