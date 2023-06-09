<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    use HasFactory;
    use Notifiable;
    public function clients()
    {
        return $this->belongsToMany(Client::class);
    }
    protected $table = "orders";
    protected $fillable = ["client_id","name", "price"];
}
