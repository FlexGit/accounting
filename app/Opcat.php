<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Opcat extends Model
{
    protected $table = 'operation_categories';
    protected $fillable = [
    	'name',
	];
	protected $dates = [
		'created_at',
		'updated_at'
	];
}
