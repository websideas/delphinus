<?php
global $disableloading, $page404;
$disableloading = true;
$page404 = true;

include_once('templates/headers/head.php');

?>

<div class="wrapper-404">
    <div id="error404">

        <h1>404</h1>
        <h4>Oops, page not found.</h4>
        <p>It looks like nothing was found at this location. <br />Click the link below to return home.</p>
        <p class="no-margin"><a href="index.php">Return home <i class="icon-Right-3"></i></a></p>

    </div><!-- #main -->
</div>


<?php
include_once('templates/footers/foot.php');


