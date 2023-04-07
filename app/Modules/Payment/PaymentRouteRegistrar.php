<?php

namespace App\Modules\Payment;

use App\Modules\Payment\Endpoints\CreatePayment;
use App\Modules\Payment\Endpoints\ProcessPayment;
use Illuminate\Support\Facades\Route;

class PaymentRouteRegistrar
{
    public static function all()
    {
        Route::group([
            'middleware' => ['api'],
            'prefix' => 'api',
        ], function () {
            Route::any('/payments:process', ProcessPayment::class);

            Route::group([
                'middleware' => ['auth'],
            ], function () {
                Route::post('/payments', CreatePayment::class)->middleware('throttle:5,1');
            });
        });
    }
}
