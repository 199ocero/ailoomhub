<?php

namespace App\Console\Commands;

use App\Models\AiModel;
use App\Models\AiProvider;
use Illuminate\Console\Command;

use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\text;
use function Laravel\Prompts\select;

class AiModelCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:ai-model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make an AI model';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $provider = select(
            label: 'Select a Provider',
            options: AiProvider::query()->pluck('name', 'id'),
            required: 'Provider is required.',
            scroll: 10
        );

        $name = text(
            label: 'What is the name of the AI model?',
            placeholder: 'E.g. gpt-3.5-turbo',
            required: 'Name is required.'
        );

        $aiName = AiModel::query()->where('name', $name)->first();

        if ($aiName) {
            error($name . ' model already exists!');
            return;
        }

        $model = AiModel::query()
            ->where('ai_provider_id', $provider)
            ->where('name', $name)
            ->first();

        if ($model) {
            error($name . ' provider and model already exists!');
            return;
        }

        AiModel::query()->create([
            'ai_provider_id' => $provider,
            'name' => $name,
        ]);

        info($name . ' model created successfully!');
    }
}
