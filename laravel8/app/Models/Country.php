<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
class Country extends Model
{
    //
    use Notifiable;
    protected $table = "country";
    public $timestamp = false;

    protected $fillable = [
        'name'
    ];

    protected $hidden = [
        'remember_token',
    ];
}
