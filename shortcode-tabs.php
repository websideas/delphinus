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
                            <li class="active">Message Box</li>
                        </ol>
                    </div>
                    <div class="col-md-8 text-right">
                        <h1>Tabs</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="main">

        <div class="section-info">
            <h3 class="section-title">Simple Tabs</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="tab-container full-width style1 box">
                        <ul class="tabs clearfix">
                            <li class="active"><a href="#tab1-1" data-toggle="tab">Retina Ready</a></li>
                            <li><a href="#tab1-2" data-toggle="tab">Customer Support</a></li>
                            <li><a href="#tab1-3" data-toggle="tab">Web Design</a></li>
                            <li><a href="#tab1-4" data-toggle="tab">Branding</a></li>
                        </ul>
                        <div id="tab1-1" class="tab-content in active">
                            <div class="tab-pane">
                                <div class="image-box-style1 pull-left">
                                    <img src="images/logo-white.png" alt="">
                                </div>
                                <p>Ut cursus massa at urnaaculis estie. Sed aliquamellus vitae ultrs condmentum leo massa mollis estiegittis miristum nulla sed fringilla Donec vitae orci dignissim, faucibus tellus volutpat, rhoncus leo.</p>
                                <p>Mauris in quam tristique, dignissim urna in, molestie felis. Fusce tristique, elit nec vehicula imperdiet, eros est egestas odio, at aliquet elit nulla sed massa. Ut cursus massa at urnaaculis estie. Sed aliquamellus vitae ultrices condimentum, leo massa mollis estiegittis miristum nulla.</p>
                            </div>
                        </div>
                        <div id="tab1-2" class="tab-content">
                            <div class="tab-pane">
                                <div class="image-box-style1 pull-left">
                                    <img src="images/logo-white.png" alt="">
                                </div>
                                <p>Lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim.</p>
                                <p>Mauris in quam tristique, dignissim urna in, molestie felis. Fusce tristique, elit nec vehicula imperdiet, eros est egestas odio, at aliquet elit nulla sed massa. Ut cursus massa at urnaaculis estie. Sed aliquamellus vitae ultrices condimentum, leo massa mollis estiegittis miristum nulla.</p>
                            </div>
                        </div>
                        <div id="tab1-3" class="tab-content">
                            <div class="tab-pane">
                                <div class="image-box-style1 pull-left">
                                    <img src="images/logo-white.png" alt="">
                                </div>
                                <p>Ut cursus massa at urnaaculis estie. Sed aliquamellus vitae ultrs condmentum leo massa mollis estiegittis miristum nulla sed fringilla Donec vitae orci dignissim, faucibus tellus volutpat, rhoncus leo.</p>
                                <p>Mauris in quam tristique, dignissim urna in, molestie felis. Fusce tristique, elit nec vehicula imperdiet, eros est egestas odio, at aliquet elit nulla sed massa. Ut cursus massa at urnaaculis estie. Sed aliquamellus vitae ultrices condimentum, leo massa mollis estiegittis miristum nulla.</p>
                            </div>
                        </div>
                        <div id="tab1-4" class="tab-content">
                            <div class="tab-pane">
                                <div class="image-box-style1 pull-left">
                                    <img src="images/logo-white.png" alt="">
                                </div>
                                <p>Lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim.</p>
                                <p>Mauris in quam tristique, dignissim urna in, molestie felis. Fusce tristique, elit nec vehicula imperdiet, eros est egestas odio, at aliquet elit nulla sed massa. Ut cursus massa at urnaaculis estie. Sed aliquamellus vitae ultrices condimentum, leo massa mollis estiegittis miristum nulla.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="tab-container full-width style2">
                        <ul class="tabs clearfix">
                            <li class="active"><a href="#tab2-1" data-toggle="tab">Retina Ready</a></li>
                            <li><a href="#tab2-2" data-toggle="tab">Customer Support</a></li>
                            <li><a href="#tab2-3" data-toggle="tab">Web Design</a></li>
                            <li><a href="#tab2-4" data-toggle="tab">Branding</a></li>
                        </ul>
                        <div id="tab2-1" class="tab-content in active">
                            <div class="tab-pane">
                                <p>Ut cursus massa at urnaaculis estie. Sed aliquamellus vitae ultrs condmentum leo massa mollis estiegittis miristum nulla sed fringilla Donec vitae orci dignissim, faucibus tellus volutpat, rhoncus leo.</p>
                                <p>Mauris in quam tristique, dignissim urna in, molestie felis. Fusce tristique, elit nec vehicula imperdiet, eros est egestas odio, at aliquet elit nulla sed massa. Ut cursus massa at urnaaculis estie. Sed aliquamellus vitae ultrices condimentum, leo massa mollis estiegittis miristum nulla.</p>
                            </div>
                        </div>
                        <div id="tab2-2" class="tab-content">
                            <div class="tab-pane">
                                <p>Lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim.</p>
                                <p>Mauris in quam tristique, dignissim urna in, molestie felis. Fusce tristique, elit nec vehicula imperdiet, eros est egestas odio, at aliquet elit nulla sed massa. Ut cursus massa at urnaaculis estie. Sed aliquamellus vitae ultrices condimentum, leo massa mollis estiegittis miristum nulla.</p>
                            </div>
                        </div>
                        <div id="tab2-3" class="tab-content">
                            <div class="tab-pane">
                                <p>Ut cursus massa at urnaaculis estie. Sed aliquamellus vitae ultrs condmentum leo massa mollis estiegittis miristum nulla sed fringilla Donec vitae orci dignissim, faucibus tellus volutpat, rhoncus leo.</p>
                                <p>Mauris in quam tristique, dignissim urna in, molestie felis. Fusce tristique, elit nec vehicula imperdiet, eros est egestas odio, at aliquet elit nulla sed massa. Ut cursus massa at urnaaculis estie. Sed aliquamellus vitae ultrices condimentum, leo massa mollis estiegittis miristum nulla.</p>
                            </div>
                        </div>
                        <div id="tab2-4" class="tab-content">
                            <div class="tab-pane">
                                <p>Lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim.</p>
                                <p>Mauris in quam tristique, dignissim urna in, molestie felis. Fusce tristique, elit nec vehicula imperdiet, eros est egestas odio, at aliquet elit nulla sed massa. Ut cursus massa at urnaaculis estie. Sed aliquamellus vitae ultrices condimentum, leo massa mollis estiegittis miristum nulla.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-info">
            <h3 class="section-title">Fullwidth Tabs</h3>
            <div class="tab-container vertical-tab">
                <ul class="tabs">
                    <li><a href="#tab3-1" data-toggle="tab">Website Design</a></li>
                    <li><a href="#tab3-2" data-toggle="tab">Branding</a></li>
                    <li class="active"><a href="#tab3-3" data-toggle="tab">Retina Ready Display</a></li>
                    <li><a href="#tab3-4" data-toggle="tab">Customer Support</a></li>
                    <li><a href="#tab3-5" data-toggle="tab">User Interface</a></li>
                    <li><a href="#tab3-6" data-toggle="tab">Web Development</a></li>
                </ul>
                <div id="tab3-1" class="tab-content">
                    <div class="tab-pane">
                        <img src="http://placehold.it/270x237" alt="" class="pull-left">
                        <p>Nulla mattis rsitmet dolor sollicitudi aliquamquae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explica aborem ipsum dolor sit amet gravida sagittis lacus. Morbi sit amet mauris mi. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit.</p>
                        <p>Lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim.</p>
                    </div>
                </div>
                <div id="tab3-2" class="tab-content">
                    <div class="tab-pane">
                        <img src="http://placehold.it/270x237" alt="" class="pull-left">
                        <p>Nulla mattis rsitmet dolor sollicitudi aliquamquae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explica aborem ipsum dolor sit amet gravida sagittis lacus. Morbi sit amet mauris mi. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit.</p>
                        <p>Lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim.</p>
                    </div>
                </div>
                <div id="tab3-3" class="tab-content in active">
                    <div class="tab-pane">
                        <img src="http://placehold.it/270x237" alt="" class="pull-left">
                        <p>Nulla mattis rsitmet dolor sollicitudi aliquamquae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explica aborem ipsum dolor sit amet gravida sagittis lacus. Morbi sit amet mauris mi. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit.</p>
                        <p>Lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim.</p>
                    </div>
                </div>
                <div id="tab3-4" class="tab-content">
                    <div class="tab-pane">
                        <img src="http://placehold.it/270x237" alt="" class="pull-left">
                        <p>Nulla mattis rsitmet dolor sollicitudi aliquamquae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explica aborem ipsum dolor sit amet gravida sagittis lacus. Morbi sit amet mauris mi. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit.</p>
                        <p>Lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim.</p>
                    </div>
                </div>
                <div id="tab3-5" class="tab-content">
                    <div class="tab-pane">
                        <img src="http://placehold.it/270x237" alt="" class="pull-left">
                        <p>Nulla mattis rsitmet dolor sollicitudi aliquamquae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explica aborem ipsum dolor sit amet gravida sagittis lacus. Morbi sit amet mauris mi. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit.</p>
                        <p>Lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim.</p>
                    </div>
                </div>
                <div id="tab3-6" class="tab-content">
                    <div class="tab-pane">
                        <img src="http://placehold.it/270x237" alt="" class="pull-left">
                        <p>Nulla mattis rsitmet dolor sollicitudi aliquamquae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explica aborem ipsum dolor sit amet gravida sagittis lacus. Morbi sit amet mauris mi. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit.</p>
                        <p>Lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-info">
            <h3 class="section-title">Transparent Tabs</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="image-container">
                        <img src="http://placehold.it/570x230" alt="">
                    </div>
                    <div class="tab-container transparent-tab full-width box">
                        <ul class="tabs">
                            <li><a href="#tab4-1" data-toggle="tab"><i class="fa fa-rocket"></i>Web Design</a></li>
                            <li class="active"><a href="#tab4-2" data-toggle="tab"><i class="fa fa-microphone"></i>Retina Ready</a></li>
                            <li><a href="#tab4-3" data-toggle="tab"><i class="fa fa-lightbulb-o"></i>Branding</a></li>
                            <li><a href="#tab4-4" data-toggle="tab"><i class="fa fa-bolt"></i>photoshop</a></li>
                        </ul>
                        <div id="tab4-1" class="tab-content">
                            <div class="tab-pane">
                                <p>Ut cursus massa at urnaaculis estie. Sed aliquamellus vitae ultrs condmentum leo massa mollis estiegittis miristum nulla sed fringilla Donec vitae orci dignissim faucibus tellus volutpat.</p>
                                <p>Honcus leomassa at urnaaculis estie. Sed aliquamellus vitae ultrices condimentum, leo massa mollis estiegittis miristum nulla.</p>
                            </div>
                        </div>
                        <div id="tab4-2" class="tab-content in active">
                            <div class="tab-pane">
                                <p>Lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim.</p>
                                <p>Honcus leomassa at urnaaculis estie. Sed aliquamellus vitae ultrices condimentum, leo massa mollis estiegittis miristum nulla.</p>
                            </div>
                        </div>
                        <div id="tab4-3" class="tab-content">
                            <div class="tab-pane">
                                <p>Ut cursus massa at urnaaculis estie. Sed aliquamellus vitae ultrs condmentum leo massa mollis estiegittis miristum nulla sed fringilla Donec vitae orci dignissim faucibus tellus volutpat.</p>
                                <p>Honcus leomassa at urnaaculis estie. Sed aliquamellus vitae ultrices condimentum, leo massa mollis estiegittis miristum nulla.</p>
                            </div>
                        </div>
                        <div id="tab4-4" class="tab-content">
                            <div class="tab-pane">
                                <p>Lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim.</p>
                                <p>Honcus leomassa at urnaaculis estie. Sed aliquamellus vitae ultrices condimentum, leo massa mollis estiegittis miristum nulla.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="image-container">
                        <img src="http://placehold.it/570x230" alt="">
                    </div>
                    <div class="tab-container transparent-tab">
                        <ul class="tabs clearfix">
                            <li><a href="#tab5-1" data-toggle="tab">Web Design</a></li>
                            <li class="active"><a href="#tab5-2" data-toggle="tab">Retina Ready Display</a></li>
                            <li><a href="#tab5-3" data-toggle="tab">Branding</a></li>
                            <li><a href="#tab5-4" data-toggle="tab">photoshop</a></li>
                        </ul>
                        <div id="tab5-1" class="tab-content">
                            <div class="tab-pane">
                                <p>Lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim.</p>
                                <p>Honcus leomassa at urnaaculis estie. Sed aliquamellus vitae ultrices condimentum, leo massa mollis estiegittis miristum nulla.</p>
                            </div>
                        </div>
                        <div id="tab5-2" class="tab-content in active">
                            <div class="tab-pane">
                                <p>Ut cursus massa at urnaaculis estie. Sed aliquamellus vitae ultrs condmentum leo massa mollis estiegittis miristum nulla sed fringilla Donec vitae orci dignissim faucibus tellus volutpat.</p>
                                <p>Honcus leomassa at urnaaculis estie. Sed aliquamellus vitae ultrices condimentum, leo massa mollis estiegittis miristum nulla.</p>
                            </div>
                        </div>
                        <div id="tab5-3" class="tab-content">
                            <div class="tab-pane">
                                <p>Lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim.</p>
                                <p>Honcus leomassa at urnaaculis estie. Sed aliquamellus vitae ultrices condimentum, leo massa mollis estiegittis miristum nulla.</p>
                            </div>
                        </div>
                        <div id="tab5-4" class="tab-content">
                            <div class="tab-pane">
                                <p>Ut cursus massa at urnaaculis estie. Sed aliquamellus vitae ultrs condmentum leo massa mollis estiegittis miristum nulla sed fringilla Donec vitae orci dignissim faucibus tellus volutpat.</p>
                                <p>Honcus leomassa at urnaaculis estie. Sed aliquamellus vitae ultrices condimentum, leo massa mollis estiegittis miristum nulla.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div><!-- #main -->
<?php

include_once('templates/footers/footer3.php');
include_once('templates/footers/footer.php');


