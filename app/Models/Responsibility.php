<?php

namespace App\Models;

use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Responsibility extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name', 'role_id'];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

}
