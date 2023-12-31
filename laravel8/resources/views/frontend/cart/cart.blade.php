@extends('frontend.layouts.app')

@section('content')

    <section id="cart_items">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">Check out</li>
            </ol>
        </div><!--/breadcrums-->
        @if (!empty($status))
        @if ($status == 1)
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Thông báo!</h4>
                <ul>
                    Thanh Toán Thành Công
                </ul>
            </div>
        @elseif ($status == 2)
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Thông báo!</h4>
            <ul>
                Thanh Toán Thất bại
            </ul>
        </div>
        @endif
        @endif
        @if (!empty($product))


            <div class="shopper-informations">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="shopper-info">
                            <p>Shopper Information</p>

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h4><i class="icon fa fa-check"></i> Thông báo!</h4>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="">
                                @csrf
                                <?php
								if(Auth::check()){

							?>
                                <input type="hidden" placeholder="Email" name="email" value="{{ Auth::user()->email }}">
                                <input type="hidden" placeholder="User Name" name="name"
                                    value="{{ Auth::user()->name }}">
                                <input type="hidden" placeholder="Phone" name="phone" value="{{ Auth::user()->phone }}">
                                <input type="hidden" placeholder="Address" name="address"
                                    value="{{ Auth::user()->address }}">
                                    <input type="hidden" id="user_id" value="{{ Auth::user()->id }}">
                                <button type="submit" class="btn btn-primary">Continue</button>
                                <?php
								}else{
							?>
                                <p>
                                    <a href="{{ url('/member-login') }}">Vui lòng click vào đây đăng nhập để mua hang!</a>
                                </p>

                                <?php
								}
							?>


                            </form>


                        </div>
                    </div>
                    <!-- <div class="col-sm-5 clearfix">
             <div class="bill-to">
              <p>Bill To</p>
              <div class="form-one">
               <form>
                <input type="text" placeholder="Email*">
                <input type="text" placeholder="First Name *">
                <input type="text" placeholder="Last Name *">

               </form>
              </div>
              <div class="form-two">
               <form>
                <input type="text" placeholder="Address *">
                <input type="text" placeholder="Phone *">
                <select>
                 <option>-- Country --</option>
                 <option>United States</option>
                 <option>Bangladesh</option>
                 <option>UK</option>
                 <option>India</option>
                 <option>Pakistan</option>
                 <option>Ucrane</option>
                 <option>Canada</option>
                 <option>Dubai</option>
                </select>
               </form>
              </div>
             </div>
            </div>
            <div class="col-sm-4">
             <div class="order-message">
              <p>Shipping Order</p>
              <textarea name="message" placeholder="Notes about your order, Special Notes for Delivery" rows="16"></textarea>
              <label><input type="checkbox"> Shipping to bill address</label>
             </div>
            </div> -->
                </div>
            </div>
            <div class="review-payment">
                <h2>Review & Payment</h2>
            </div>

            <div class="table-responsive cart_info">
                <table class="table table-condensed">
                    <thead>
                        <tr class="cart_menu" id="">
                            <td class="image">Item</td>
                            <td class="description"></td>
                            <td class="price">Price</td>
                            <td class="quantity">Quantity</td>
                            <td class="total">Total</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product as $key => $product)
                            <?php
                            $getArrImage = json_decode($product['image'], true);
                            ?>
                            <tr>
                                <td class="cart_product">
                                    <a href=""><img
                                            src="{{ URL::to('upload/product/' . $product['id_user'] . '/small_' . $getArrImage[0]) }}"
                                            alt=""></a>
                                </td>
                                <td class="cart_description">
                                    <h4><a href="">{{ $product['name'] }}</a></h4>
                                    <p>Web ID: {{ $product['web_id'] }}</p>
                                </td>
                                <td class="cart_price">
                                    $<span class="price_product">{{ $product['price'] }}</span>
                                </td>
                                <td class="cart_quantity">
                                    <div class="cart_quantity_button">
                                        <a class="cart_quantity_down"> - </a>
                                        <input class="cart_quantity_input" type="text" name="quantity"
                                            value="{{ $product['qty'] }}" autocomplete="off" size="2" min="0">
                                        <a class="cart_quantity_up"> + </a>
                                    </div>
                                </td>
                                <td class="cart_total">
                                    $<span class="product_total_price">{{ $product['price'] * $product['qty'] }}</span>
                                </td>
                                <td class="cart_delete">
                                    <a class="cart_quantity_delete"
                                        href="{{ url('/cart-qty-delete/' . $product['id']) }}"><i
                                            class="fa fa-times"></i></a>
                                </td>
                            </tr>
                        @endforeach


                        <td colspan="4">&nbsp;</td>
                        <td colspan="2">
                            <table class="table table-condensed total-result">

                                <tr class="shipping-cost">
                                    <td>Shipping Cost</td>
                                    <td>Free</td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td >$<span class="cart_total_price" id="sumId">{{ $sum }}</span></td>
                                </tr>
                            </table>
                        </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="payment-options">
                <div class="row">
                    <div class="col-md-10"></div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-primary" id="checkoutPaypal">Checkout Paypal</button>
                    </div>
                </div>
            </div>
        @else
            <h3 id="val1">You don't have any product in your cart.</h3>
        @endif
    </section>
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.product_total_price').each(function() {
                $(this).text($(this).parent().prev().find('.cart_quantity_input').val() * $(this).parent()
                    .prev().prev().find('span.price_product').text());
            });

            $('.cart_quantity_up').click(function() {
                $(this).prev().val(+$(this).prev().val() + 1);


                $(this).parent().parent().next().find('span.product_total_price').text($(this).prev()
                    .val() * $(this).parent().parent().prev().find('span.price_product').text());

                var sum = 0;
                $('.product_total_price').each(function() {
                    sum += Number($(this).text());

                });

                $('.cart_total_price').text(sum);
            })
            $('.cart_quantity_down').click(function() {
                $(this).next().val(+$(this).next().val() - 1);


                $(this).parent().parent().next().find('span.product_total_price').text($(this).next()
                    .val() * $(this).parent().parent().prev().find('span.price_product').text());

                var sum = 0;
                $('.product_total_price').each(function() {
                    sum += Number($(this).text());
                });

                $(this).parents().find('.cart_total_price').text(sum);
            })
            $('#checkoutPaypal').click(function() {
                $.ajax({
                    url: '{{ url('/process-paypal')}}',
                    data: {
                        price: $("#sumId").text(),
                        user_id: $("#user_id").val()
                    },
                    type: 'post',
                    success: function(res) {
                        if (res.status) {
                            window.location = res.link
                        }
                    },
                });
            })
        })
    </script>
@endsection
