<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $table = 'banks';
    // protected $guarded = [];
    protected $fillable = [ 'user' , 'bank_name' , 'bank_iban' , 'bank_swiftcode' , 'user_id' , 'bank_account'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
