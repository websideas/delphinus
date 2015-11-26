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
                            <li class="active">Wishlist</li>
                        </ol>
                    </div>
                    <div class="col-md-8 text-right">
                        <h1>Wishlist</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="main">
        <div class="page-section">
            <div class="container">
                <div class="woocommerce">
                    <form>
                        <div class="table-responsive">
                            <table class="shop_table cart">
                                <thead>
                                <tr>

                                    <th class="product-thumbnail">Item</th>
                                    <th class="product-name">Description</th>
                                    <th class="product-quantity">Quantity</th>
                                    <th class="product-price">Unit Price</th>
                                    <th class="product-subtotal">Subtotal</th>
                                    <th class="product-remove">&nbsp;</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="cart_item">
                                    <td class="product-thumbnail">
                                        <a href="#" class="attachment-shop_thumbnail wp-post-image"><img src="assets/images/product/product-1.jpg" alt=""></a>
                                    </td>
                                    <td class="product-name">
                                        <a href="#">Sample Product 01</a>
                                    </td>
                                    <td class="product-quantity">
                                        <input type="text" size="4" class="input-text qty text" title="Qty" value="1" name="qty" />
                                    </td>
                                    <td class="product-price">
                                        <span class="amount">$1000.00</span>
                                    </td>
                                    <td class="product-subtotal">
                                        <span class="amount">$1000.00</span>
                                    </td>
                                    <td class="product-remove">
                                        <a href="#"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
                                <tr class="cart_item">
                                    <td class="product-thumbnail">
                                        <a href="#" class="attachment-shop_thumbnail wp-post-image"><img src="assets/images/product/product-6.jpg" alt=""></a>
                                    </td>
                                    <td class="product-name">
                                        <a href="#">Sample Product 02</a>
                                    </td>
                                    <td class="product-quantity">
                                        <input type="text" size="4" class="input-text qty text" title="Qty" value="1" name="qty" />
                                    </td>
                                    <td class="product-price">
                                        <span class="amount">$1000.00</span>
                                    </td>
                                    <td class="product-subtotal">
                                        <span class="amount">$1000.00</span>
                                    </td>
                                    <td class="product-remove">
                                        <a href="#"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!-- #main -->
<?php

include_once('templates/footers/footer3.php');
include_once('templates/footers/foot.php');


