<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Optype extends Model
{
    protected $table = 'operation_types';
    protected $fillable = [
    	'name',
		'alias'
	];
	protected $dates = [
		'created_at',
		'updated_at'
	];
}
