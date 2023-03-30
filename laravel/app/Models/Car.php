<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Car extends Model
{
    use HasFactory;
    use Notifiable;

    protected $table = 'cars';
    protected $fillable = ["client_id", "name"];
}
