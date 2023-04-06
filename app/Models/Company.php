<?php

namespace App\Models;

use App\Models\Role;
use App\Models\Team;
use Illuminate\Support\Str;
use BaconQrCode\Renderer\Path\Path;
use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'logo'];
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }
    public function roles(): HasMany
    {
        return $this->hasMany(Role::class);
    }

    public $appends = ['url_image'];

    public function getUrlImageAttribute()
    {
        return [
            'url_image' => url(Storage::url($this->logo)),
            'image' => Str::replace('logo/', '', $this->logo),
        ];
    }
}
