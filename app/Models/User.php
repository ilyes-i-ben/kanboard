<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function sendEmailVerificationNotification(): void
    {
        $this->notify(new VerifyEmailNotification());
    }

    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function cards(): BelongsToMany
    {
        return $this->belongsToMany(Card::class, 'card_members')
            ->withTimestamps();
    }

    public function boards(): BelongsToMany
    {
        return $this->belongsToMany(Board::class, 'board_members')
            ->withPivot('created_at')
            ;
    }

    public function createdBoards(): HasMany
    {
        return $this->hasMany(Board::class, 'created_by');
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class, 'email', 'email');
    }

    public function pendingInvitations(): HasMany
    {
        return $this->invitations()->valid()->with(['board', 'inviter']);
    }

    public function normalize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
        ];
    }
}
