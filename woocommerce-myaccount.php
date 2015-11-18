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
                            <li class="active">My Account</li>
                        </ol>
                    </div>
                    <div class="col-md-8 text-right">
                        <h1>My Account</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="main">

        <div class="woocommerce">
            <div class="tab-container dashboard row">
                <div class="col-sm-4 col-md-3">
                    <h4>My Account</h4>
                    <ul class="tabs arrow-circle size-medium box">
                        <li class="active"><a href="#account-dashboard" data-toggle="tab">Account Dashboard</a></li>
                        <li><a href="#account-information" data-toggle="tab">Account Information</a></li>
                        <li><a href="#address-book" data-toggle="tab">Address Book</a></li>
                        <li><a href="#my-orders" data-toggle="tab">My Orders</a></li>
                        <li><a href="#my-product-reviews" data-toggle="tab">My Product Reviews</a></li>
                        <li><a href="#my-tags" data-toggle="tab">My Tags</a></li>
                        <li><a href="#my-wishlist" data-toggle="tab">My Wishlist</a></li>
                        <li><a href="#newsletter-subscriptions" data-toggle="tab">Newsletter Subscriptions</a></li>
                    </ul>
                </div>
                <div class="col-sm-8 col-md-9">
                    <div id="account-dashboard" class="tab-content in active">
                        <h4 class="full-name skin-color">Hello, Jesscia Brown!</h4>
                        <div class="description">
                            <p>From your My Account Dashboard you have the ability to view a snapshot of your recent account activity and update your account information. Select a link below to view or edit information.</p>
                        </div>
                        <hr class="color-light1">
                        <h4>Account Information</h4>
                        <div class="row view-account-information same-height add-clearfix">
                            <div class="col-md-6 box">
                                <div class="information">
                                    <a href="#" class="btn btn-sm style4">Modify</a>
                                    <h5>Contact Information</h5>
                                    <div class="description">
                                        <p>
                                            jessica brown
                                            <br>
                                            jessica12brown@yahoo.com
                                            <br>
                                            <a href="#">Change Password</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 box">
                                <div class="information">
                                    <a href="#" class="btn btn-sm style4">Modify</a>
                                    <h5>Newsletters</h5>
                                    <div class="description">
                                        <p>You are currently not subscribed to any newsletter.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 box">
                                <div class="information">
                                    <a href="#" class="btn btn-sm style4">Modify</a>
                                    <h5>Billing Address</h5>
                                    <div class="description">
                                        <p>
                                            Default Billing Address
                                            <br>
                                            You have not set a default billing address.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 box">
                                <div class="information">
                                    <a href="#" class="btn btn-sm style4">Modify</a>
                                    <h5>Shipping Address</h5>
                                    <div class="description">
                                        <p>
                                            Default Shipping Address
                                            <br>
                                            You have not set a default shipping address.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="account-information" class="tab-content">
                        <div class="row">
                            <div class="col-md-10 col-lg-8">
                                <h4>Account Information</h4>
                                <form>
                                    <div class="form-group">
                                        <input type="text" class="input-text full-width" placeholder="First Name">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="input-text full-width" placeholder="Last Name">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="input-text full-width" placeholder="Email Address">
                                    </div>
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label><input type="checkbox">Change Passowrd?</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-medium style1">Save Information</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div id="address-book" class="tab-content">
                        <div class="row">
                            <div class="col-md-10 col-lg-8">
                                <form>
                                    <h4>Billing Address</h4>

                                    <div class="form-group dropdown">
                                        <select class="selector full-width default-style">
                                            <option value="">Select a Country</option>
                                            <option value="US">United States</option>
                                        </select>
                                    </div>
                                    <div class="form-group column-2 no-column-bottom-margin">
                                        <input type="text" placeholder="First name" class="input-text">
                                        <input type="text" placeholder="Last name" class="input-text">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" placeholder="Company name" class="input-text full-width">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" placeholder="Address" class="input-text full-width">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" placeholder="Appartment, unit, etc. (optional)" class="input-text full-width">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" placeholder="Town / City" class="input-text full-width">
                                    </div>
                                    <div class="form-group column-2 no-margin">
                                        <input type="text" placeholder="State / County" class="input-text">
                                        <input type="text" placeholder="Zip code" class="input-text">
                                    </div>
                                    <div class="form-group column-2 no-margin">
                                        <input type="text" placeholder="Email address" class="input-text">
                                        <input type="text" placeholder="Phone" class="input-text">
                                    </div>
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label><input type="checkbox">Create an account?</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-medium style1">Save Information</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div id="my-orders" class="tab-content">
                        <h4>Recent Orders</h4>
                        <table class="shop_table my_account_orders">
                            <thead>
                            <tr>
                                <th class="order-number"><span class="nobr">Order</span></th>
                                <th class="order-date"><span class="nobr">Date</span></th>
                                <th class="order-status"><span class="nobr">Status</span></th>
                                <th class="order-total"><span class="nobr">Total</span></th>
                                <th class="order-actions">&nbsp;</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="order">
                                <td class="order-number">
                                    <a href="#">#7117</a>
                                </td>
                                <td class="order-date">
                                    <time datetime="2014-11-05">November 5, 2014</time>
                                </td>
                                <td class="order-status">
                                    Cancelled
                                </td>
                                <td class="order-total">
                                    <span class="amount">$16.00</span> for 2 items
                                </td>
                                <td class="order-actions">
                                    <a class="btn btn-sm style1 view no-margin" href="#">View</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="my-product-reviews" class="tab-content">
                        <h4>My Product Reviews</h4>
                        <table class="shop_table my_product_reviews">
                            <thead>
                            <tr>
                                <th class="review-date">Created at</th>
                                <th class="product-name">Product Name</th>
                                <th class="product-review">Review</th>
                                <th class="product-comment">Comment</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="review-date"><time datetime="2014-11-05">November 5, 2014</time></td>
                                <td class="product-name">Mesh-Trimmed Dress</td>
                                <td class="product-review"><span class="star-rating" title="4" data-toggle="tooltip"><span data-stars="4"></span></span></td>
                                <td class="product-comment">Aliquam hendrerit a aug insus Pellente sque id erat quis sa sollicitudin.</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div id="my-tags" class="tab-content">
                        <h4>My Tags</h4>
                        <p>Click on a tag to view your corresponding products.</p>
                        <div class="my_tags tags">
                            <a href="#" class="tag">Night Dress</a>
                            <a href="#" class="tag">female tights</a>
                            <a href="#" class="tag">gowns</a>
                            <a href="#" class="tag">shirts</a>
                            <a href="#" class="tag">coats</a>
                        </div>
                    </div>
                    <div id="my-wishlist" class="tab-content">
                        <form>
                            <h4>My Wishlist</h4>
                            <table class="shop_table my-wishlist box">
                                <thead>
                                <tr>
                                    <th>&nbsp;</th>
                                    <th class="product-desc">Product Details and Comment</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="product-img">
                                        <img src="http://placehold.it/58x63" alt="">
                                    </td>
                                    <td class="product-desc">
                                        <h6>Easy Draped Cardigan</h6>
                                        <p>Aliquam hendrerit a augue insuscipit. Etiam aliquam massa quis mauris sollicitudin commodo venenatis ligula commodo. Sed blandit convallis dignissim.Donec vel pellentesque neque. Nulla et quam vitae sapien vestibulum molestie. Cras ac ligula vitae urna suscipit venenatis id quis urnaauris sodales lacinia mauris.</p>
                                        <textarea rows="5" class="input-text full-width" placeholder="write message"></textarea>
                                    </td>
                                    <td class="qty-wrap">
                                        <input type="text" class="input-text" value="1">
                                    </td>
                                    <td class="product-price">
                                        <span>$23.58</span>
                                    </td>
                                    <td class="product-remove">
                                        <a href="#"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <button class="btn btn-medium style1">Update Wishlist</button>
                        </form>
                    </div>
                    <div id="newsletter-subscriptions" class="tab-content">
                        <form>
                            <h4>Newsletter Subscriptions</h4>
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="1" checked>General Subscription
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-medium style1">Save Information</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>


    </div><!-- #main -->
<?php

include_once('templates/footers/footer1.php');
include_once('templates/footers/footer.php');


