<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'about'
    ];

    public function rules(){
        return [
            'about' => ['required', 'max:255'],
            'file' => ['required', 'file'],
            'event_id' => ['required', 'exists:events,id']
        ];
    }

    public function people(){
        return $this->hasMany(People::class);
    }

    public function people_event(){
        return $this->hasMany(People_event::class);
    }

}
