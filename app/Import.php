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
        'about' => ['required', 'max:255'],
        'file' => ['required', 'file']
    ];

    public function people(){
        return $this->hasMany(People::class);
    }

    public function people_event(){
        return $this->hasMany(People_event::class);
    }

}
