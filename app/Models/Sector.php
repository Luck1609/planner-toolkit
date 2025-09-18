<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sector extends Model
{
  use HasUuids;

  protected $keyType = 'string';
  public $incrementing = false;

  protected $fillable = [
    'name',
    'initials',
    'blocks',
    'locality_id',
  ];

  protected $casts = [
    'blocks' => 'array',
  ];

  #[Scope]
  protected function sectors(Builder $query, string | null $id) : void {
    if ($id) $query->where('locality_id', $id);
  }

  // relationships
  public function locality() : BelongsTo {
    return $this->belongsTo(Locality::class);
  }
}
