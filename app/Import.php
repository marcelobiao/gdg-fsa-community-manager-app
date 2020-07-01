<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'about'
    ];

    protected $rules = [
        'about' => ['required', 'max:255']
    ];
}
