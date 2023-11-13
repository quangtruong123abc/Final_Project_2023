<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $table  = 'invoices';
    protected $fillable = [
        'invoice_code',
        'total_money',
        'user_id',
        'name',
        'address',
        'phone',
        'email',
    ];
}//
