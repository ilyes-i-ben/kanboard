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
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Card
 *
 * @property int $id
 * @property int $list_id
 * @property string $title
 * @property string|null $description
 * @property float $position
 * @property Carbon|null $deadline
 * @property Carbon|null $finished_at
 * @property int $created_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property User $user
 * @property User[] $card_members
 *
 * @package App\Models
 */
class Card extends Model
{
    use HasFactory;

	protected $table = 'cards';

	protected $casts = [
		'list_id' => 'int',
		'position' => 'float',
		'deadline' => 'datetime',
		'finished_at' => 'datetime',
		'created_by' => 'int'
	];

	protected $fillable = [
		'list_id',
		'title',
		'description',
		'position',
		'deadline',
		'finished_at',
		'created_by'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'created_by');
	}

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'card_members')
            ->withTimestamps();
    }

    public function list(): BelongsTo
    {
        return $this->belongsTo(ListModel::class, 'list_id');
    }
}
