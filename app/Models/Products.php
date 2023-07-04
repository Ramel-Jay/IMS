<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bar_code',
        'name',
        'brand',
        'discription',
        'price',
        'stack',
        'catigory',
        'img'
    ];

    public function user(){
        return $this->belongsTo(Roles::class, 'user_id', 'id');
    }
}
