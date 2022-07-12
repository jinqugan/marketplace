<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // protected $keyType = 'string';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'email',
        'order_no',
        'payment_method_id',
        'stock_id',
        'status_id',
        'details',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'updated_at',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    // protected $table = 'phone_verifies';
    protected $casts = [
        'details' => 'object'
    ];
}
