<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ListModel extends Model
{
    use HasFactory;

	protected $table = 'lists';

	protected $casts = [
		'board_id' => 'int',
		'position' => 'float',
        'is_terminal' => 'boolean',
	];

	protected $fillable = [
		'board_id',
		'title',
        'is_terminal',
		'position',
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
