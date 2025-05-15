<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Board
 *
 * @property int $id
 * @property string $title
 * @property string $background_color
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Collection|ListModel[] $lists
 *
 * @package App\Models
 */
class Board extends Model
{
	protected $table = 'boards';

	protected $fillable = [
		'title',
		'background_color'
	];

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'board_members')
            ->withPivot('role', 'created_at')
            ->withTimestamps();
    }

	public function lists(): HasMany
	{
		return $this->hasMany(ListModel::class);
	}
}
