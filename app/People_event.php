<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class People_event extends Model
{
    public $timestamps = true;

    protected $table = 'people_event';

    protected $fillable = [
        'event_id',
        'people_id',
        'registration_order',
        'ticket_hash',
        'ticket_type',
        'ticket_value',
        'purchase_date',
        'order_hash',
        'payment_status',
        'check_in',
        'check_in_date',
        'discount_code',
        'payment_method',
        'import_id',
    ];

    protected $rules = [
        'event_id'              => ['required', 'exists:events,id'],
        'people_id'             => ['required', 'exists:people,id'],
        'registration_order'    => ['required', 'integer'],
        'ticket_hash'           => ['required', 'max:255'],
        'ticket_type'           => ['required', 'max:255'],
        'ticket_value'          => ['required', 'decimal'],
        'purchase_date'         => ['required', 'date'],
        'order_hash'            => ['required', 'max:255'],
        'payment_status'        => ['required', 'in:Aprovado,Não pago,Cancelado'],
        'check_in'              => ['required', 'boolean'],
        'check_in_date'         => ['required', 'date'],
        'discount_code'         => ['required', 'max:255'],
        'payment_method'        => ['required', 'in:grátis,cartão de crédito,boleto bancário,adicionado manualmente'],
        'import_id'             => ['required', 'exists:imports,id'],
    ];

    public function import(){
        return $this->belongsTo(Import::class);
    }

    public function event(){
        return $this->belongsTo(Event::class);
    }

    public function people(){
        return $this->belongsTo(People::class);
    }

}
