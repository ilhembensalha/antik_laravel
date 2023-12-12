<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = ['sender_id', 'receiver_id', 'content', 'created_at'];

    // Ajoutez ces lignes
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
    protected $appends = ['formatted_date'];

    // ... autres fonctions

    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('Y-m-d H:i:s'); // ajustez le format selon vos besoins
    }
}
