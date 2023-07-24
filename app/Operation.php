<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    protected $table = 'operations';
    protected $fillable = [
		'optype_id',
		'opsum',
		'comment',
		'is_accrued',
	];
	protected $dates = [
		'created_at',
		'updated_at',
	];
}
