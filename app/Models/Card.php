<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Str;

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
        'priority',
		'deadline',
		'finished_at',
        'category_id',
		'created_by',
        'public_token',
	];

	public function user(): BelongsTo
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

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
