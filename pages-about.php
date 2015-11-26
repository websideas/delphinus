<?php
global $shadow;
$shadow = ' ';


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
                            <li class="active">About us</li>
                        </ol>
                    </div>
                    <div class="col-md-8 text-right">
                        <h1>About us</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="main">
        <div class="page-section pad-bottom-60">
            <div class="container">
                <div class="col-md-6 col-sm-6">
                    <div class="banner">
                        <img src="assets/images/about.png" alt="About" class="img-responsive" />
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="about-left">
                        <h4 class="text-nomal mar-bottom-40" style="line-height: 36px;">We believe our goods are meaningful because of the thoughtfulness of the people behind them</h4>
                        <p>We’re Delphinus Studio, a small design agency based in Southampton. We’ve been crafting beautiful websites, launching stunning brands and making clients happy for years.</p>
                        <p>With our prestigious craftsmanship, remarkable client care and passion for design, you could say we’re the ‘all singing, all dancing’ kind…</p>
                        <p>We think you’ll love working with us.</p>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- #main -->

<?php

include_once('templates/footers/footer3.php');
include_once('templates/footers/foot.php');


