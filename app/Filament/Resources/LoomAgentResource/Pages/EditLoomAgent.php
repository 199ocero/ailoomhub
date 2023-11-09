<?php

namespace App\Filament\Resources\LoomAgentResource\Pages;

use App\Filament\Resources\LoomAgentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLoomAgent extends EditRecord
{
    protected static string $resource = LoomAgentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}