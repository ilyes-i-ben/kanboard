<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    public const string STATUS_PENDING = 'pending';
    public const string STATUS_ACCEPTED = 'accepted';
    public const string STATUS_DECLINED = 'declined';

    protected $casts = [
        'board_id' => 'int',
        'inviter_id' => 'int',
        'expires_at' => 'datetime'
    ];
    protected $fillable = [
        'board_id',
        'email',
        'token',
        'status',
        'inviter_id',
        'expires_at'
    ];

    #[Scope]
    protected function valid(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PENDING)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });
    }
}
