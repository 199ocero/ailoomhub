<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'loom_agent_id',
        'name',
        'url'
    ];

    /**
     * Get the Loom agent associated with the page.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function loomAgent(): BelongsTo
    {
        return $this->belongsTo(LoomAgent::class);
    }
}
