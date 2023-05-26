<?php

namespace App\Modules\Admin;

use App\Modules\Admin\Middlewares\MustBeAdmin;
use Illuminate\Support\Facades\Route;

class AdminRouteRegistrar
{
    public static function all()
    {
        Route::group([
            'middleware' => ['api', 'auth:api', MustBeAdmin::class],
            'prefix' => 'api/admin/',
            'as' => 'admin.',
        ], function () {
            Route::get('user', Endpoints\GetUser::class);
            Route::get('stats', Endpoints\GetStats::class);
            Route::get('prompts', Endpoints\ListPrompts::class);
            Route::post('prompts', Endpoints\CreatePrompt::class);
            Route::get('users', Endpoints\ListUsers::class);
            Route::get('payments', Endpoints\ListPayments::class);
            Route::get('gift-cards', Endpoints\ListGiftCards::class);
            Route::get('conversations', Endpoints\ListConversations::class);
            Route::get('messages', Endpoints\ListMessages::class);

            Route::patch('users/{user}', Endpoints\UpdateUser::class);
            Route::delete('users/{user}', Endpoints\DeleteUser::class);

            Route::patch('prompts/{prompt}', Endpoints\UpdatePrompt::class);
            Route::delete('prompts/{prompt}', Endpoints\DeletePrompt::class);
        });
    }
}
