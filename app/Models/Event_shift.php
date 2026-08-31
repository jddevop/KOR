<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Event_shift extends Model
{
    use HasFactory;
    
    protected $table = 'event_shift';
    
    public function event()
    {
      return $this->belongsTo(Event::class,'event_id');
    }
}
