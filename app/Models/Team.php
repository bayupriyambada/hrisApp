<?php

namespace App\Models;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name', 'icon', 'company_id'];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }
}
