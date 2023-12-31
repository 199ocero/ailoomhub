<?php

namespace App\Filament\Resources\LoomAgentResource\Pages;

use App\Filament\Resources\LoomAgentResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Crypt;

class CreateLoomAgent extends CreateRecord
{
    protected static string $resource = LoomAgentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        $data['config_options'] = [
            'ai_provider' => [
                'token' => Crypt::encryptString($data['ai_provider_token']),
            ],
            'knowledge_base' => [
                'token' => Crypt::encryptString($data['knowledge_base_token']),
            ]
        ];

        return $data;
    }

    protected function getCancelFormAction(): Action
    {
        return Action::make('cancel')
            ->label(__('filament-panels::resources/pages/create-record.form.actions.cancel.label'))
            ->url($this->getRedirectUrl())
            ->color('gray');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
