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
        'created_by' => 'int',
	];

	protected $fillable = [
		'board_id',
		'title',
        'is_terminal',
		'position',
        'created_by',
	];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

	public function board(): BelongsTo
	{
		return $this->belongsTo(Board::class);
	}

	public function cards(): HasMany
	{
		return $this->hasMany(Card::class, 'list_id');
	}
}
