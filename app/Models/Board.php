<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
}
