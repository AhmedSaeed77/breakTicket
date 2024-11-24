<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Copoune extends Model
{
    use HasFactory;

    protected $table = 'copounes';
    protected $fillable = [ 'copoune' , 'counter' , 'presentage' , 'type'];

    public function events()
    {
        return $this->belongsToMany(Event::class,'copoune_events');
    }

    public function orders()
    {
        return $this->hasMany(Order::class,'copoune_id');
    }
}
