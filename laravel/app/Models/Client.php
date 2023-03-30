<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Client extends Model
{
    use HasFactory;
    use Notifiable;
    public function cars()
    {
        return $this->belongsToMany(Car::class);
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }
    protected $table = 'clients';
    protected $fillable = ["employee_id", "name"];
}
