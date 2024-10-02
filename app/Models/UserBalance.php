<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBalance extends Model
{
    // Specify the table associated with the model
    protected $table = 'user_balances';

    // Specify the primary key
    protected $primaryKey = 'user_id'; // Gunakan 'user_id' sebagai primary key

    // Specify if the IDs are auto-incrementing
    public $incrementing = false; // 'user_id' tidak auto-incrementing

    // Specify the data type for the primary key
    protected $keyType = 'bigint'; // 'user_id' adalah bigint

    // Define which attributes can be mass-assigned
    protected $fillable = ['user_id', 'balance'];

    // Disable timestamps if not using them
    public $timestamps = false;

    // Define the relationship to the User model if necessary
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

