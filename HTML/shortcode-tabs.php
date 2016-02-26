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
                            <li class="active">Accordion & Tabs</li>
                        </ol>
                    </div>
                    <div class="col-md-8 text-right">
                        <h1>Accordion & Tabs</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="main">

        <div class="page-section">
            <div class="container">
                <h3 class="gray mar-bottom-50">Style 1</h3>
                <div class="row">
                    <div class="col-md-4">
                        <div class="kt-accordion style1">
                            <h3 class="kt-accortion-title">Section 1</h3>
                            <div class="kt-accordion-content">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dolor nisl, aliquet in ex a, faucibus imperdiet purus. Ut imperdiet orci ex, ut semper
                            </div>
                            <h3 class="kt-accortion-title">Section 2</h3>
                            <div class="kt-accordion-content">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dolor nisl, aliquet in ex a, faucibus imperdiet purus. Ut imperdiet orci ex, ut semper
                                suscipit faucibus urna.
                            </div>
                            <h3 class="kt-accortion-title">Section 3</h3>
                            <div class="kt-accordion-content">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dolor nisl, aliquet in ex a, faucibus imperdiet purus. Ut imperdiet orci ex, ut semper
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="kt-accordion style2">
                            <h3 class="kt-accortion-title">Section 1</h3>
                            <div class="kt-accordion-content">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dolor nisl, aliquet in ex a, faucibus imperdiet purus. Ut imperdiet orci ex, ut semper
                            </div>
                            <h3 class="kt-accortion-title">Section 2</h3>
                            <div class="kt-accordion-content">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dolor nisl, aliquet in ex a, faucibus imperdiet purus. Ut imperdiet orci ex, ut semper
                            </div>
                            <h3 class="kt-accortion-title">Section 3</h3>
                            <div class="kt-accordion-content">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dolor nisl, aliquet in ex a, faucibus imperdiet purus. Ut imperdiet orci ex, ut semper
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="kt-accordion style3">
                            <h3 class="kt-accortion-title">Section 1</h3>
                            <div class="kt-accordion-content">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dolor nisl, aliquet in ex a, faucibus imperdiet purus. Ut imperdiet orci ex, ut semper
                            </div>
                            <h3 class="kt-accortion-title">Section 2</h3>
                            <div class="kt-accordion-content">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dolor nisl, aliquet in ex a, faucibus imperdiet purus. Ut imperdiet orci ex, ut semper
                            </div>
                            <h3 class="kt-accortion-title">Section 3</h3>
                            <div class="kt-accordion-content">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dolor nisl, aliquet in ex a, faucibus imperdiet purus. Ut imperdiet orci ex, ut semper
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-section bg-gray">
            <div class="container">
                <h3 class="gray mar-bottom-50">Style 2</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="kt-accordion style4">
                            <h3 class="kt-accortion-title">Section 1</h3>
                            <div class="kt-accordion-content">
                                Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer
                                ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit
                                amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut
                                odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.
                            </div>
                            <h3 class="kt-accortion-title">Section 2</h3>
                            <div class="kt-accordion-content">
                                Sed non urna. Donec et ante. Phasellus eu ligula. Vestibulum sit amet
                                purus. Vivamus hendrerit, dolor at aliquet laoreet, mauris turpis porttitor
                                velit, faucibus interdum tellus libero ac justo. Vivamus non quam. In
                                suscipit faucibus urna.
                            </div>
                            <h3 class="kt-accortion-title">Section 3</h3>
                            <div class="kt-accordion-content">
                                Nam enim risus, molestie et, porta ac, aliquam ac, risus. Quisque lobortis.
                                Phasellus pellentesque purus in massa. Aenean in pede. Phasellus ac libero
                                ac tellus pellentesque semper. Sed ac felis. Sed commodo, magna quis
                                lacinia ornare, quam ante aliquam nisi, eu iaculis leo purus venenatis dui.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="kt-tab-container">
                            <ul class="tabs clearfix">
                                <li><a href="#tab1-1">Section 1</a></li>
                                <li><a href="#tab1-2">Section 2</a></li>
                                <li><a href="#tab1-3">Section 3</a></li>
                            </ul>
                            <div id="tab1-1" class="kt-tab-content">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed blandit metus erat, quis varius nibh malesuada ut. In et nunc massa. Pellentesque augue dolor, bibendum id leo sit amet, viverra aliquam sapien. Sed vitae tellus facilisis. stra, per inceptos himenaeos. Morbi nec bibendum massa. Curabitur sollicitudin augue odio, at vulputate quam pulvinar nec.</p>
                            </div>
                            <div id="tab1-2" class="kt-tab-content">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed blandit metus erat, quis varius nibh malesuada ut. In et nunc massa. Pellentesque augue dolor, bibendum id leo sit amet, viverra aliquam sapien. Sed vitae tellus facilisis. stra, per inceptos himenaeos. Morbi nec bibendum massa. Curabitur sollicitudin augue odio, at vulputate quam pulvinar nec. Curabitur non congue magna. Etiam mattis, ante non malesuada feugiat, </p>
                            </div>
                            <div id="tab1-3" class="kt-tab-content">
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed blandit metus erat, quis varius nibh malesuada ut. In et nunc massa. Pellentesque augue dolor, bibendum id leo sit amet, viverra aliquam sapien. Sed vitae tellus facilisis. stra, per inceptos himenaeos. Morbi nec bibendum massa. </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- #main -->
<?php

include_once('templates/footers/footer4.php');
include_once('templates/footers/foot.php');


