<html>
<head>
    <!-- Import FawryPay CSS Library-->
<link rel="stylesheet" href="https://atfawry.fawrystaging.com/atfawry/plugin/assets/payments/css/fawrypay-payments.css">

<!-- Import FawryPay Staging JavaScript Library-->
{{-- <script type="text/javascript" src="https://atfawry.fawrystaging.com/atfawry/plugin/assets/payments/js/fawrypay-payments.js"></script> --}}


<!-- Import FawryPay Production JavaScript Library -->
<script type="text/javascript" src="https://www.atfawry.com/atfawry/plugin/assets/payments/js/fawrypay-payments.js"></script>
</head>

<body onload="javascript:checkout()">

 {{-- @dd($data['merchantCode']) --}}
 <!-- FawryPay Checkout Button -->
{{--<input type="image" onclick="checkout();" src="https://www.atfawry.com/assets/img/FawryPayLogo.jpg"
 alt="pay-using-fawry" id="fawry-payment-btn"/> --}}


 <script src={{ asset('site/js/jquery.min.js') }}></script>
		<script src={{ asset('site/js/bootstrap.min.js') }}></script>
		<script src={{ asset('site/js/slick.min.js') }}></script>
		<script src={{ asset('site/js/nouislider.min.js') }}></script>
		<script src={{ asset('site/js/jquery.zoom.min.js') }}></script>
		<script src={{ asset('site/js/main.js') }}></script>

<script>
 function checkout() {
    const configuration = {
        locale : "en",  //default en
        mode: DISPLAY_MODE.POPUP,  //required, allowed values [POPUP, INSIDE_PAGE, SIDE_PAGE , SEPARATED]
    };
FawryPay.checkout(buildChargeRequest(), configuration);
}

function buildChargeRequest() {
    // alert('here');
    // const chargeRequest = {
    //             "merchantCode" : "siYxylRjSPy1YRVe3ouM6Q==",
    //             "merchantRefNum": "97",
    //             "customerMobile": "01011941903",
    //             "customerEmail" : "example@gmail.com",
    //             "customerName" : "Ahmed Ali",
    //             "customerProfileId":"123",
    //             "paymentExpiry" : 1631138400000,
    //             "chargeItems" : [
    //                 {
    //                                 "itemId" : "8",
    //                                 "description" : "Item Description",
    //                                 "price" : "580.55",
    //                                 "quantity" : "1"
    //                 }
    //                             ],
    //                             "returnUrl": "http://localhost:8000",
    //                             "authCaptureModePayment": false,
    //                             "signature": "22268711259af8e785e8deea9189c26dd22bacae1dcd315b3adc41ae978042c3"
    //             };
    var merchantCode = '<?php echo $data['merchantCode'] ?>';
    // alert(merchantCode);
    var merchantRefNum = "<?php echo $data['merchantRefNum'] ?>";
    var merchant_cust_prof_id = "<?php echo $data['merchant_cust_prof_id'] ?>";
    var item_id = "<?php echo $data['item_id'] ?>";
    var price = "<?php echo $data['price'] ?>";
    var qty = "<?php echo  $data['qty'] ?>";
    var return_url = "<?php echo $data['return_url'] ?>";
    var signature = "<?php echo $data['signature'] ?>";
    const chargeRequest = {
                "merchantCode" : merchantCode,
                "merchantRefNum": merchantRefNum,
                "customerMobile": "<?php echo $data['phone'] ?>",
                "customerEmail" : "<?php echo $data['email'] ?>",
                "customerName" : "<?php echo $data['name'] ?>",
                "customerProfileId":merchant_cust_prof_id,
                // "paymentExpiry" : 1631138400000,
                "chargeItems" : [
                    {
                                    "itemId" : item_id,
                                    "description" : "Item Description",
                                    "price" : price,
                                    "quantity" : qty
                    }
                                ],
                                "returnUrl": return_url,
                                "authCaptureModePayment": false,
                                "signature":signature
                        };
   return chargeRequest;

}
</script>
</body>
</html>
