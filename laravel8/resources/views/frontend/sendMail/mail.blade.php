<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        
        <style type="text/css">
        	div.demo {
        		width: 50px;
        		height: 50px;
        		display: inline-block;
        		background: blue;
        	}
        	table {
			  font-family: arial, sans-serif;
			  border-collapse: collapse;
			  width: 100%;
			}

			td, th {
			  border: 1px solid #dddddd;
			  text-align: left;
			  padding: 8px;
			}
        	p {

        	}
        </style>
    </head>
    <body>
       <div class="demo"></div>
        <p>Thông tin khách hàng:</p>
        <p>Họ và tên: {{ $data['getRequest']['name'] }}</p>
        <p>Số điện thoại: {{ $data['getRequest']['phone'] }}</p>
        <p>Địa chỉ: {{ $data['getRequest']['address'] }}</p>
    	<p></p>
    	<p></p>
    	<p>Thông tin giỏ hàng:</p>
        <table class="table table-condensed">
				<thead>
					<tr class="cart_menu" id="">
						<td class="image">Item</td>
						<td class="description">Name</td>
						<td class="price">Price</td>
						<td class="quantity">Quantity</td>
						<td class="total">Total</td>
						
					</tr>
				</thead>
				<tbody>
					@foreach($data['product'] as $key => $product)
					<?php
		                $getArrImage = json_decode($product['image'],true);
		            ?>
						<tr>
							<td class="cart_product">
								<a href=""><img src="{{ URL::to('upload/product/'.$product['id_user'].'/small_'.$getArrImage[0]) }}" alt=""></a>
							</td>
							<td class="cart_description">
								<h4><a href="">{{ $product['name'] }}</a></h4>
								
							</td>
							<td class="cart_price">
								<span class="price_product">{{ $product['price'] }}</span>
							</td>
							<td class="cart_quantity">
								<div class="cart_quantity_button">
									
									{{ $product['qty'] }}
									
								</div>
							</td>
							<td class="cart_total">
								<span class="product_total_price">{{ $product['price'] *  $product['qty']}}</span>
							</td>
							
						</tr>

					@endforeach

					
						<td colspan="3">&nbsp;</td>
						<td colspan="2">
							<table class="table table-condensed total-result">
								
								<tr class="shipping-cost">
									<td>Shipping Cost</td>
									<td>Free</td>										
								</tr>
								<tr>
									<td>Total</td>
									<td><span class="cart_total_price">{{ $data['sum'] }}</span></td>
								</tr>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
    </body>
</html>