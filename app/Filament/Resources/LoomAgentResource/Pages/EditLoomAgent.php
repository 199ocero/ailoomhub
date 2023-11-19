<?php

namespace App\Filament\Resources\LoomAgentResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Crypt;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\LoomAgentResource;

class EditLoomAgent extends EditRecord
{
    protected static string $resource = LoomAgentResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['ai_provider_token'] = Crypt::decryptString($data['config_options']['ai_provider']['token']);
        $data['knowledge_base_token'] = Crypt::decryptString($data['config_options']['knowledge_base']['token']);
        return $data;
    }

    protected function getCancelFormAction(): Action
    {
        return Action::make('cancel')
            ->label(__('filament-panels::resources/pages/edit-record.form.actions.cancel.label'))
            ->url($this->getRedirectUrl())
            ->color('gray');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
