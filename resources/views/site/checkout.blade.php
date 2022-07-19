	@extends('site.master')
    @section('content')
    @include('admin.includes.messages')

    <!-- SECTION -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">

                <div class="col-md-7">
                    <!-- Billing Details -->
                    <div class="billing-details">
                        <div class="section-title">
                            <h3 class="title">اطلب الان</h3>
                        </div>
                        <form action='{{route("pay3")}}' method='post'>
                            @csrf

                        <div class="form-group">
                            <input class="input" type="text" name="name" placeholder="الاسم" value='{{old("name")}}' required>
                        </div>

                        <div class="form-group">
                            <input class="input" type="email" name="email" placeholder="البريد الاكتروني" value='{{old("email")}}' required>
                        </div>
                        <div class="form-group">
                            <input class="input" type="text" name="phone" placeholder="التليفون" value='{{old("phone")}}' required>
                        </div>
                        <div class="form-group">
                            <input class="input" type="text" name="address" placeholder="العنوان" value='{{old("address")}}' required>
                        </div>
                        {{-- <div class="form-group">
                            <input class="input" type="text" name="code" placeholder="الكود الشخصي" value='{{old("code")}}' required>
                        </div> --}}
                        <input  type='hidden' name='product_id' value='{{$product->id}}'>

                    </div>
                    <!-- /Billing Details -->

                </div>

                <!-- Order Details -->
                <div class="col-md-5 order-details">
                    <div class="section-title text-center">
                        <h3 class="title">طلبك</h3>
                    </div>
                    <div class="order-summary">
                        <div class="order-col">
                            <div><strong>المنتج</strong></div>
                            <div><strong>الاجمالي</strong></div>
                        </div>
                        <div class="order-products">
                            <div class="order-col">
                                <div>{{$product->name}}</div>
                                <div>ج.م {{$product->price}} </div>
                            </div>

                        </div>
                        {{-- <div class="order-col">
                            <div>Shiping</div>
                            <div><strong>FREE</strong></div>
                        </div> --}}
                        <div class="order-col">
                            <div><strong>الاجمالي</strong></div>
                            <div><strong class="order-total">ج.م {{$product->price}} </strong></div>
                        </div>
                    </div>
                    {{-- <div class="payment-method">
                        <div class="input-radio">
                            <input type="radio" name="payment" id="payment-1">
                            <label for="payment-1">
                                <span></span>
                                Direct Bank Transfer
                            </label>
                            <div class="caption">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            </div>
                        </div>
                        <div class="input-radio">
                            <input type="radio" name="payment" id="payment-2">
                            <label for="payment-2">
                                <span></span>
                                Cheque Payment
                            </label>
                            <div class="caption">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            </div>
                        </div>
                        <div class="input-radio">
                            <input type="radio" name="payment" id="payment-3">
                            <label for="payment-3">
                                <span></span>
                                Paypal System
                            </label>
                            <div class="caption">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            </div>
                        </div>
                    </div> --}}
                    {{-- <div class="input-checkbox">
                        <input type="checkbox" id="terms">
                        <label for="terms">
                            <span></span>
                            I've read and accept the <a href="#">terms & conditions</a>
                        </label>
                    </div> --}}
                    <button href="#" class="primary-btn order-submit">تابع الشراء</button>
                </div>
                <!-- /Order Details -->
                </form>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /SECTION -->
    @stop
