<?php
global $shadow;
$shadow = ' ';

include_once('templates/headers/head.php');
include_once('templates/headers/header1.php');

?>
    <div class="page-section bg-gray small-section">
        <div class="page-header">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <ol class="breadcrumb">
                            <li><a href="#">Home</a></li>
                            <li class="active">Banner</li>
                        </ol>
                    </div>
                    <div class="col-md-8 text-right">
                        <h1>Banner</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="main">
        <div class="page-section pad-bottom-50">
            <div class="container">
                <h3 class="gray no-margin">Style 1</h3>
            </div>
        </div>
        <div class="page-section pad-xlg bg-dark-alfa-40 parallax-1" style="background-image: url('assets/images/background/bg-01.jpg') ">
            <div class="page-section-inner">
                <div class="container">
                    <h2 class="text-center white">BY US, BY HANDS AT OUR Delphinus STUDIO.</h2>
                </div>
            </div>
        </div>

        <div class="page-section">
            <div class="container">
                <h3 class="gray mar-bottom-50">Style 2</h3>
            </div>
            <div class="row no-gutters">
                <div class="col-md-6">
                    <div class="banner banner-dark no-margin">
                        <img src="assets/images/banner/banner-04.jpg" alt="" />
                        <div class="banner-content">
                            <h3 class="white">20% Sale on all Product</h3>
                        </div>
                        <a class="banner-link" href="#"></a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="banner banner-dark no-margin">
                        <img src="assets/images/banner/banner-05.jpg" alt="" />
                        <div class="banner-content">
                            <h3 class="white">new collection, new sale</h3>
                        </div>
                        <a class="banner-link" href="#"></a>
                    </div>
                </div>
            </div>
        </div>


    </div><!-- #main -->
<?php

include_once('templates/footers/footer4.php');
include_once('templates/footers/foot.php');


