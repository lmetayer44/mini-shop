<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;

    // Autoriser l’assignation en masse (selon tes besoins)
    protected $fillable = [
        'title',
        'description',
        // 'url_token' sera généré automatiquement,
        // inutile de le mettre dans les $fillable
    ];

    // Génération d'un token unique de 40 caractères lors de la création
    protected static function booted()
    {
        static::creating(function ($order) {
            $order->url_token = Str::random(40);
        });
    }
}
