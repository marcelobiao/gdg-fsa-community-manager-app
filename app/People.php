<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'email',
        'name',
        'about',
        'import_id'
    ];

    protected $rules = [
        'email' => ['required', 'max:255', 'unique:people,email'],
        'name' => ['required', 'max:255'],
        'about' => ['max:255'],
        'import_id' => ['integer', 'exists:imports,id']
    ];

    public function import(){
        return $this->belongsTo('App\Import');
    }
}
