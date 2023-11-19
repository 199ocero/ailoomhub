<?php

namespace App\Console\Commands;

use App\Models\KnowledgeBase;
use Illuminate\Console\Command;

use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\text;

class KnowledgeBaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:knowledge-base';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a knowledge base';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = text(
            label: 'What is the name of the knowledge base?',
            placeholder: 'E.g. Notion',
            required: 'Name is required.'
        );

        $provider = KnowledgeBase::where('name', $name)->first();

        if ($provider) {
            error($name . ' knowledge base already exists!');
            return;
        }

        KnowledgeBase::query()->create([
            'name' => $name,
        ]);

        info($name . ' knowledge base created successfully!');
    }
}
