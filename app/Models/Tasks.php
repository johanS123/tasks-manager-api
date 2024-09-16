<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    protected $fillable = [
        'title',
        'description',
        'expirationDate',
        'isActive',
        'isComplete',
        'userCreateId',
        'userAssignId'
    ];

    protected $casts = [
        'isActive' => 'boolean',
        'isComplete' => 'boolean'
    ];
}
