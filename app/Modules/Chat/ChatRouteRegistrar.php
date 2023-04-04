<?php

namespace App\Modules\Chat;

use App\Modules\Chat\Endpoints\CreateConversation;
use App\Modules\Chat\Endpoints\CreateMessage;
use App\Modules\Chat\Endpoints\CreateSmartMessage;
use App\Modules\Chat\Endpoints\DeleteConversation;
use App\Modules\Chat\Endpoints\ListConversationMessages;
use App\Modules\Chat\Endpoints\UpdateConversation;
use Illuminate\Support\Facades\Route;

class ChatRouteRegistrar
{
    public static function all()
    {
        Route::group([
            'middleware' => ['api', 'auth'],
            'prefix' => 'api',
        ], function () {
            Route::post('/conversations/{conversation}/smart-messages', CreateSmartMessage::class)->middleware('throttle:20,1');
            Route::post('/conversations/{conversation}/messages', CreateMessage::class)->middleware('throttle:20,1');
            Route::post('/conversations', CreateConversation::class)->middleware('throttle:10,1');
            Route::get('/conversations/{conversation}/messages', ListConversationMessages::class);
            Route::delete('/conversations/{conversation}', DeleteConversation::class);
            Route::put('/conversations/{conversation}', UpdateConversation::class);
        });
    }
}
