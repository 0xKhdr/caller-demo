<?php


use Illuminate\Database\Eloquent\Model;

class Caller extends Model
{
    protected $fillable = [
        'external_id',
        'name',
        'username',
        'company_name',
        'address',
        'last_called_at',
    ];

    protected $casts = [
        'address' => 'array',
        'last_called_at' => 'datetime',
    ];
}
