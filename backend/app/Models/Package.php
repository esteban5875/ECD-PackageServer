<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Package extends Model
{
    use HasFactory;
    protected $connection = 'repository';

    protected $table = 'packages';

    protected $fillable = [
        'name',
        'version',
        'description',
        'filename',
        'checksum',
        'size',
        'uploaded_at',
    ];
}