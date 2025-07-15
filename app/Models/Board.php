<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Board
 *
 * @property int $id
 * @property string $title
 * @property string $background_color
 * @property int $created_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Collection|ListModel[] $lists
 *
 * @package App\Models
 */
class Board extends Model
{
    use HasFactory;

	protected $table = 'boards';

	protected $fillable = [
		'title',
        'description',
		'background_color',
	];

    // we use this in order to fill automaticlly created_by...
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_by = auth()->id();
        });
    }

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'board_members')
            ->withPivot('created_at');
    }

	public function lists(): HasMany
	{
        return $this->hasMany(ListModel::class);
	}

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function hasMember($user): bool
    {
        $id = $user instanceof User ? $user->id : $user;
        return $this->members()->where('user_id', $id)->exists();
    }
}
