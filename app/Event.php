<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'name',
        'date',
        'place',
        'city'
    ];

    protected $rules = [
        'name' => ['required', 'max:255'],
        'date' => ['required', 'date'],
        'place' => ['required', 'max:255'],
        'city' => ['required', 'max:255']
    ];
}
