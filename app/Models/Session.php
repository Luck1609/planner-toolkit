<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Session extends Model
{
  use HasUuids;

  protected $table = 'monthly_sessions';
  protected $keyType = 'string';
  public $incrementing = false;

  // protected $fillable = [];
  protected $guarded = [];

  // public function applications(): HasMany
  // {
  //   return $this->hasMany(Application::class);
  // }


  public function session(): BelongsToMany
  {
    return $this->belongsToMany(Application::class)->withPivot('status_id')->withTimestamps();
  }

  public function meeting(): HasMany
  {
    return $this->hasMany(Meeting::class);
  }
}
