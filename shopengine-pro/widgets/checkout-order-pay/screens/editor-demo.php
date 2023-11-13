<?php ?>
<div class='shopengine-checkout-order-pay'>
	<table class="shop_table">
		<thead>
			<tr>
				<th class="product-name">Product</th>
				<th class="product-quantity">Qty</th>
				<th class="product-total">Totals</th>
			</tr>
		</thead>
		<tbody>
			<tr class="order_item">
				<td class="product-name">T-Shirt with Logo
					<ul class="wc-item-meta">
						<li>
							<strong class="wc-item-meta-label">
								<span class="shopengine-partial-payment-product-badge">Partial Payment </span>:
							</strong>
							<p>yes</p>
						</li>
						<li>
							<strong class="wc-item-meta-label">Amount: </strong>
							60%
						</li>
					</ul>
				</td>
				<td class="product-quantity"> <strong class="product-quantity">×&nbsp;1</strong></td>
				<td class="product-subtotal"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>18.00</bdi></span></td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<th scope="row" colspan="2">Subtotal:</th>
				<td class="product-total"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>18.00</bdi></span></td>
			</tr>
			<tr>
				<th scope="row" colspan="2">Total:</th>
				<td class="product-total"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>18.00</bdi></span></td>
			</tr>
			<tr>
				<th scope="row" colspan="2">First Installment</th>
				<td class="product-total"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>10.80</bdi></span></td>
			</tr>
			<tr>
				<th scope="row" colspan="2">Second Installment</th>
				<td class="product-total"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>7.20</bdi></span></td>
			</tr>
			<tr>
				<th scope="row" colspan="2">Due:</th>
				<td class="product-total"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>18.00</bdi></span></td>
			</tr>
		</tfoot>
	</table>
	<div id="payment">
		<ul class="wc_payment_methods payment_methods methods">
			<li class="wc_payment_method payment_method_bacs">
				<input id="payment_method_bacs" type="radio" class="input-radio" name="payment_method" value="bacs" checked="checked" data-order_button_text="">

				<label for="payment_method_bacs">
					Direct bank transfer </label>
				<div class="payment_box payment_method_bacs" style="">
					<p>Make your payment directly into our bank account. Please use your Order ID as the payment reference. Your order will not be shipped until the funds have cleared in our account.</p>
				</div>
			</li>
			<li class="wc_payment_method payment_method_cheque">
				<input id="payment_method_cheque" type="radio" class="input-radio" name="payment_method" value="cheque" data-order_button_text="">

				<label for="payment_method_cheque">
					Check payments </label>
				<div class="payment_box payment_method_cheque" style="display: none;">
					<p>Please send a check to Store Name, Store Street, Store Town, Store State / County, Store Postcode.</p>
				</div>
			</li>
			<li class="wc_payment_method payment_method_cod">
				<input id="payment_method_cod" type="radio" class="input-radio" name="payment_method" value="cod" data-order_button_text="">

				<label for="payment_method_cod">
					Cash on delivery </label>
				<div class="payment_box payment_method_cod" style="display: none;">
					<p>Pay with cash upon delivery.</p>
				</div>
			</li>
		</ul>
		<div class="form-row">
			<input type="hidden" name="woocommerce_pay" value="1">
			<div class="woocommerce-terms-and-conditions-wrapper">
				<div class="woocommerce-privacy-policy-text">
					<p>Your personal data will be used to process your order, support your experience throughout this website, and for other purposes described in our <a href="https://shopengine.test/?page_id=3" class="woocommerce-privacy-policy-link" target="_blank">privacy policy</a>.</p>
				</div>
			</div>
			<button type="submit" class="button alt wp-element-button" id="place_order" value="Pay for order" data-value="Pay for order">Pay for order</button>
			<input type="hidden" id="woocommerce-pay-nonce" name="woocommerce-pay-nonce" value="624549f9b6"><input type="hidden" name="_wp_http_referer" value="/checkout/order-pay/61/?pay_for_order=true&amp;key=wc_order_W5GJKRTlwYypU">
		</div>
	</div>
</div>
