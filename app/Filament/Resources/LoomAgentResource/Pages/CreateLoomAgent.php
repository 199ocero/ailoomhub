<?php

namespace App\Filament\Resources\LoomAgentResource\Pages;

use App\Filament\Resources\LoomAgentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLoomAgent extends CreateRecord
{
    protected static string $resource = LoomAgentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
