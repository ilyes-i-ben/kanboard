<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
	protected $casts = [
		'board_id' => 'int',
		'inviter_id' => 'int',
		'expires_at' => 'datetime'
	];
	protected $fillable = [
		'board_id',
		'email',
		'token',
		'status',
		'inviter_id',
		'expires_at'
	];
}
