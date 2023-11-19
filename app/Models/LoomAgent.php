<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoomAgent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'ai_provider_id',
        'ai_model_id',
        'system_message',
        'knowledge_base_id',
        'status',
        'config_options',
        'usage_count',
        'last_used'
    ];

    protected $casts = [
        'status' => 'boolean',
        'config_options' => 'array',
    ];

    /**
     * Get the user that owns the LoomAgent
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the provider of this LoomAgent
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function aiProvider(): BelongsTo
    {
        return $this->belongsTo(AiProvider::class);
    }

    /**
     * Get the ai model of this LoomAgent
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function aiModel(): BelongsTo
    {
        return $this->belongsTo(AiModel::class);
    }

    /**
     * Get the knowledge base of this LoomAgent.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function knowledgeBase(): BelongsTo
    {
        return $this->belongsTo(KnowledgeBase::class);
    }
}
