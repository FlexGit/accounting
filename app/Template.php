<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $table = 'operation_templates';
    protected $fillable = [
    	'optype_id',
		'name',
		'default_value'
	];
	protected $dates = [
		'created_at',
		'updated_at'
	];
}
