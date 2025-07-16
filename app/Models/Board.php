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

        static::created(function ($model) {
            $lists = [
                ['title' => 'To do', 'position' => 0, 'is_terminal' => false],
                ['title' => 'In Progress', 'position' => 1, 'is_terminal' => false],
                ['title' => 'Done', 'position' => 2, 'is_terminal' => true],
                ['title' => 'Cancelled', 'position' => 3, 'is_terminal' => false],
            ];
            foreach ($lists as $list) {
                $model->lists()->create([
                    'title' => $list['title'],
                    'position' => $list['position'],
                    'is_terminal' => $list['is_terminal'],
                    'created_by' => $model->created_by,
                ]);
            }
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
