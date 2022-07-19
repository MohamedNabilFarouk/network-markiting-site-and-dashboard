<?php

return [

    /*
    |--------------------------------------------------------------------------
    | FawryPay Enviroment
    |--------------------------------------------------------------------------
    |
    | should be on of this ('TEST','LIVE').
    |
    */

    'enviroment' => 'TEST',

    /*
    |--------------------------------------------------------------------------
    | FawryPay Credentials (Test)
    |--------------------------------------------------------------------------
    |
    | use your fawrypay test credentials
    |
    */
    'merchant_code_test' => 'siYxylRjSPy1YRVe3ouM6Q==',
    'secure_key_test' => '72f6f149-6cb5-425d-8afe-5e34b5534ce7',
   
    //hotels
    // 'merchant_code_test' => '1tSa6uxz2nRJRdVmo0mNVw==',
    // 'secure_key_test' => 'e6fd80887c4941cda6f7488d59e79878',

    /*
    |--------------------------------------------------------------------------
    | FawryPay Credentials (LIVE)
    |--------------------------------------------------------------------------
    |
    | use your fawrypay live credentials
    |
    */
    'merchant_code' => '',
    'secure_key' => '',

    /*
    |--------------------------------------------------------------------------
    | FawryPay Expiry
    |--------------------------------------------------------------------------
    |
    | use 1 for one hour, 24 for one day, 72 for 3 days and etc
    |
    */
    'expiry_in_hours' => '72',
];
