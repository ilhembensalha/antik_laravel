<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    use HasFactory;

public function categorie() {
    return $this->belongsTo(Categorie::class);
} 
/**
 * The attributes that are mass assignable.
 *
 * @var array<int, string>
 */
protected $fillable = [
    'titre','description','image','prix','location','statut','nbr_vu','cat_id','accepte'
   
];


}
