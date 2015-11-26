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
                            <li class="active">My account</li>
                        </ol>
                    </div>
                    <div class="col-md-8 text-right">
                        <h1>My account</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="main">

        <div class="page-section">
            <div class="container">
                <div id="customer_login" class="row">
                    <div class="col-md-6">
                        <h5>Login</h5>
                        <form class="login" method="post">
                            <p class="form-row form-row-wide">
                                <label for="username1">Username or email address <span class="required">*</span></label>
                                <input type="text" id="username1" name="username" class="input-bg" />
                            </p>
                            <p class="form-row form-row-wide">
                                <label for="password1">Password <span class="required">*</span></label>
                                <input type="password" id="password1" name="password" class="input-bg" />
                            </p>
                            <p class="form-row">         
                                <input type="submit" value="Login" name="login" class="btn btn-dark-b" />
                                <label class="inline" for="rememberme1">
                                    <input type="checkbox" value="forever" id="rememberme1" name="rememberme" /> Remember me               
                                </label>
                            </p>
                            <p class="lost_password">
                                <a href="http://kitethemes.com/valorous/main/my-account/lost-password/">Lost your password?</a>
                            </p>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <h5>Register</h5>
                        <form class="register" method="post">
                            <p class="form-row form-row-wide">
                                <label for="reg_email">Email address <span class="required">*</span></label>
                                <input type="email" value="" id="reg_email" name="email" class="input-bg" />
                            </p>
                            <p class="form-row form-row-wide">
                                <label for="reg_password">Password <span class="required">*</span></label>
                                <input type="password" id="reg_password" name="password" class="input-bg" />
                            </p>
                            <p class="form-row no-margin">             
                                <input type="submit" value="Register" name="register" class="btn btn-dark-b" />
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div><!-- #main -->
<?php

include_once('templates/footers/footer3.php');
include_once('templates/footers/foot.php');


