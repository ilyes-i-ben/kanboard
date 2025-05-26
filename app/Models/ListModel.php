<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class List
 *
 * @property int $id
 * @property int $board_id
 * @property string $title
 * @property float $position
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Board $board
 * @property Collection|Card[] $cards
 *
 */
class ListModel extends Model
{
    use HasFactory;

	protected $table = 'lists';

	protected $casts = [
		'board_id' => 'int',
		'position' => 'float'
	];

	protected $fillable = [
		'board_id',
		'title',
		'position'
	];

	public function board(): BelongsTo
	{
		return $this->belongsTo(Board::class);
	}

	public function cards(): HasMany
	{
		return $this->hasMany(Card::class, 'list_id');
	}
}
