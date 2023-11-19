<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AiProvider extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * Get the AI models associated with the provider.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function aiModels(): HasMany
    {
        return $this->hasMany(AiModel::class);
    }
}
