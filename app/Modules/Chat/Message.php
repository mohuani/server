<?php

namespace App\Modules\Chat;

use App\Modules\Chat\Actions\RefreshConversation;
use App\Modules\Chat\Enums\MessageRole;
use App\Modules\Chat\Filters\MessageFilter;
use App\Modules\Quota\BelongsToQuota;
use App\Modules\Quota\Tokenizable;
use App\Modules\Quota\TokenizableInterface;
use App\Modules\Service\Snowflake\HasSnowflakes;
use App\Modules\User\BelongsToCreator;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Overtrue\LaravelLike\Traits\Likeable;

/**
 * @property \App\Modules\User\User $creator
 */
class Message extends Model implements TokenizableInterface
{
    use HasSnowflakes;
    use HasFactory;
    use SoftDeletes;
    use Filterable;
    use Tokenizable;
    use BelongsToCreator;
    use BelongsToQuota;
    use Likeable;

    protected $fillable = [
        'conversation_id',
        'role',
        'content',
        'raw',
        'tokens_count',
        'creator_id',
        'quota_id',
    ];

    protected $casts = [
        'id' => 'string',
        'conversation_id' => 'string',
        'role' => MessageRole::class,
        'raw' => 'array',
        'creator_id' => 'string',
        'quota_id' => 'string',
    ];

    protected $hidden = [
        'raw',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function (Message $message) {
            if (! empty($message->conversation)) {
                RefreshConversation::run($message->conversation);
            }
        });
    }

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class, 'conversation_id', 'id');
    }

    protected static function newFactory(): MessageFactory
    {
        return MessageFactory::new();
    }

    public function getModelFilterClass(): string
    {
        return MessageFilter::class;
    }

    public function getMorphClass(): string
    {
        return Str::singular($this->getTable());
    }
}
