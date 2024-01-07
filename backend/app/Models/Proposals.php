<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposals extends Model
{
    use HasFactory;

    protected $table = 'proposals';

    protected $fillable = [
        'position',
        'name',
        'back_number',
        'created_by',
        'processed_by',
        'description',
        'status'
    ];
}
