<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Orchid\Screen\AsSource;
use Illuminate\Database\Eloquent\Model;
use App\Types\AddressType;

class Recipient extends Model
{
    use HasFactory, AsSource;

    protected $casts = [
        'address_type' => AddressType::class,
    ];

    protected $fillable = [
        'name', 'address', 'address_type', 'tg_chat_id',
    ];
}
