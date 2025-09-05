<?php
// app/Models/ContactInformation.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInformation extends Model
{
    use HasFactory;

    protected $table = 'contact_informations'; // Explicit table name

    protected $fillable = [
        'phone_number',
        'email',
        'addresses',
        'social_links',
    ];

    protected $casts = [
        'addresses' => 'array',
        'social_links' => 'array',
    ];
}
