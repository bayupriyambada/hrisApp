<?php

namespace App\Models;

use App\Models\Role;
use App\Models\Team;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'email', 'gender', 'age', 'phone', 'photo', 'team_id', 'role_id', 'is_verified', 'verified_at'];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}
