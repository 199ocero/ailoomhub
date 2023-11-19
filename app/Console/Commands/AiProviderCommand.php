<?php

namespace App\Console\Commands;

use App\Models\AiProvider;
use Illuminate\Console\Command;
use function Laravel\Prompts\info;
use function Laravel\Prompts\text;

class AiProviderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:ai-provider';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make an AI provider';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = text(
            label: 'What is the name of the AI provider?',
            placeholder: 'E.g. OpenAI',
            required: 'Name is required.'
        );

        $provider = AiProvider::where('name', $name)->first();

        if ($provider) {
            info($name . ' provider already exists!');
            return;
        }

        AiProvider::query()->create([
            'name' => $name,
        ]);

        info($name . ' provider created successfully!');
    }
}
