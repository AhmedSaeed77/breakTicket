<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CopouneEvents extends Model
{
    use HasFactory;
    
    protected $table = 'copoune_events';
    protected $guarded = [];
}
