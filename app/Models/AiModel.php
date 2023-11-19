<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'ai_provider_id',
        'name',
    ];

    /**
     * Get the provider of this ai model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function aiProvider(): BelongsTo
    {
        return $this->belongsTo(AiProvider::class);
    }
}
