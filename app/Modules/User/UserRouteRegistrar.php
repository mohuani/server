<?php

namespace App\Modules\User;

use App\Modules\User\Endpoints\ActivateUser;
use App\Modules\User\Endpoints\GetUser;
use App\Modules\User\Endpoints\ListUserAvailableQuotas;
use App\Modules\User\Endpoints\ListUserChatConversations;
use App\Modules\User\Endpoints\ListUserPayments;
use App\Modules\User\Endpoints\ListUserQuotas;
use App\Modules\User\Endpoints\ListUserSettings;
use App\Modules\User\Endpoints\UpdateUserSetting;
use Illuminate\Support\Facades\Route;

class UserRouteRegistrar
{
    public static function all(): void
    {
        Route::group([
            'middleware' => ['api', 'auth', 'limiter'],
            'prefix' => 'api',
        ], function () {
            Route::post('/users/{user}:activate', ActivateUser::class)->middleware('throttle:2,1');
            Route::get('/user', GetUser::class);
            Route::get('/users/{user}/quotas', ListUserQuotas::class);
            Route::get('/users/{user}/available-quotas', ListUserAvailableQuotas::class);
            Route::get('/users/{user}/payments', ListUserPayments::class);
            Route::get('/users/{user}/settings', ListUserSettings::class);
            Route::put('/users/{user}/settings/{key}', UpdateUserSetting::class)->middleware('throttle:20,1');

            Route::get('/users/{user}/chat/conversations', ListUserChatConversations::class);
        });
    }
}
