<?php

namespace App\Modules\User\Endpoints;

use App\Modules\Common\Endpoints\Endpoint;
use App\Modules\User\Enums\SettingKey;
use App\Modules\User\User;
use Illuminate\Http\Request;

class UpdateUserSetting extends Endpoint
{
    public function __invoke(Request $request, User $user, string $key)
    {
        $this->authorize('update', $user);

        $key = SettingKey::tryFrom($key);

        if (empty($key)) {
            abort(422, '无效的设置');
        }

        $this->validate($request, [
            'value' => [
                ...$key->rules(),
                'required',
            ],
        ]);

        return $user->settings()->updateOrCreate([
            'key' => $key,
        ], [
            'value' => $request->input('value'),
        ]);
    }
}
