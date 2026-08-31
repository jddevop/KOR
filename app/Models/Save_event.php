<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Save_event extends Model
{
    use HasFactory;
    
    protected $table = 'save_event';
    
    public function event()
    {
      return $this->belongsTo(Event::class,'event_id');
    }
    public function user()
    {
      return $this->belongsTo(User::class,'user_id');
    }
}
