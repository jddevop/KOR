<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Users_event_status extends Model
{
    use HasFactory;
    
    protected $table = 'users_event_status';
    
    
    public function user()
    {
      return $this->belongsTo(User::class,'user_id');
    }
    
    public function event()
    {
      return $this->belongsTo(Event::class,'event_id');
    }
    
}
