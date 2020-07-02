<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class People extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'email',
        'name',
        'about',
        'import_id'
    ];

    public function rules(){
        return [
            'email' => ['required', 'max:255', Rule::unique('people', 'email')->ignore($this->id)],
            'name' => ['required', 'max:255'],
            'about' => ['max:255'],
            'import_id' => ['integer', 'exists:imports,id']
        ];
    }

    //Rule::unique('users')->ignore($id) ,
    public function import(){
        return $this->belongsTo(Import::class);
    }

    public function people_event(){
        return $this->hasMany(People_event::class);
    }
}
