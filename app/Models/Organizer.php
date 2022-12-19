<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organizer extends Model
{
    use HasFactory;

    protected $fillable = [
        'namaOrganizer',
        'deskripsiOrganizer',
        'alamatOrganizer'
    ];

    public static $rules = [
        "namaOrganizer" => "required",
        "alamatOrganizer" => "required",
    ];

}