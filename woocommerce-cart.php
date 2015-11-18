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
                            <li class="active">My Cart</li>
                        </ol>
                    </div>
                    <div class="col-md-8 text-right">
                        <h1>My Cart</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="main">
        <div class="page-section">
            <div class="container">
                <div class="woocommerce">
                    <form class="table-cart-form">
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
                                        <a href="#" class="attachment-shop_thumbnail wp-post-image"><img src="http://placehold.it/100x100" alt=""></a>
                                    </td>
                                    <td class="product-name">
                                        <a href="#">Sample Product 01</a>
                                    </td>
                                    <td class="product-quantity">
                                        <input type="text" size="4" class="input-text qty text" title="Qty" value="1" name="">
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
                                        <a href="#" class="attachment-shop_thumbnail wp-post-image"><img src="http://placehold.it/100x100" alt=""></a>
                                    </td>
                                    <td class="product-name">
                                        <a href="#">Sample Product 02</a>
                                    </td>
                                    <td class="product-quantity">
                                        <input type="text" size="4" class="input-text qty text" title="Qty" value="1" name="">
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
                                <tr>
                                    <td class="actions" colspan="6">
                                        <button class="btn btn-dark-b">Update Cart</button>
                                        <button class="btn btn-gray">Proceed to Checkout</button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                    <div class="cart-collaterals row">
                        <form class="coupon-form col-sm-4 col-md-4">
                            <h5>Promotional Code</h5>
                            <div class="cart-collaterals-inner">
                                <div class="coupon">
                                    <p>Enter your coupon code if you have one</p>
                                    <input placeholder="Enter coupon code" type="text" name="coupon_code">
                                    <button name="apply_coupon" class="btn btn-gray">apply Coupon</button>
                                </div>
                            </div>
                        </form>
                        <form class="shipping_calculator col-sm-4 col-md-4">
                            <h5>Calculate Shipping</h5>
                            <div class="cart-collaterals-inner">
                                <p>Enter your destination to get a shipping estimate</p>
                                <div class="form-group dropdown">
                                    <select class="selector full-width">
                                        <option value="">Select a Country</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="input-text" placeholder="State/County">
                                </div>
                                <div class="form-group row remove-mar-bottom">
                                    <div class="col-md-5">
                                        <input type="text" class="input-text" placeholder="Post Code / Zip">
                                    </div>
                                    <div class="col-md-7">
                                        <button type="submit" class="btn btn-medium">Update Totals</button>
                                    </div>

                                </div>
                            </div>
                        </form>
                        <div class="cart_totals col-md-4 col-sm-4">
                            <h5>Cart Totals</h5>
                            <div class="cart-collaterals-inner remove-mar-bottom">
                                <table>
                                    <tbody>
                                    <tr class="cart-subtotal">
                                        <th>Cart Subtotal</th>
                                        <td class="text-right"><span class="amount">$2000.00</span></td>
                                    </tr>
                                    <tr class="shipping">
                                        <th>Shipping</th>
                                        <td class="text-right">
                                            Free Shipping
                                            <input type="hidden" class="shipping_method" value="free_shipping" id="shipping_method_0" data-index="0" name="shipping_method[0]">
                                        </td>
                                    </tr>
                                    <tr class="order-total">
                                        <th>Order Total</th>
                                        <td class="text-right"><span class="amount">$2000.00</span></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="button-checkout"><button class="btn btn-default">proceed to checkout</button></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- #main -->
<?php

include_once('templates/footers/footer1.php');
include_once('templates/footers/footer.php');


