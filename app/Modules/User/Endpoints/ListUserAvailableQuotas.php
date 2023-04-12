<?php

namespace App\Modules\User\Endpoints;

use App\Modules\Common\Endpoints\Endpoint;
use App\Modules\Quota\Enums\QuotaType;
use App\Modules\User\User;
use Illuminate\Http\Request;

class ListUserAvailableQuotas extends Endpoint
{
    public function __invoke(Request $request, User $user)
    {
        $this->authorize('get', $user);

        return [
            'chat' => $user->getQuota(QuotaType::CHAT),
        ];
    }
}
