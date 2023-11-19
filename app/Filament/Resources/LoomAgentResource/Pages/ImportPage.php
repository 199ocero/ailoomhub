<?php

namespace App\Filament\Resources\LoomAgentResource\Pages;

use Filament\Tables;
use Filament\Tables\Table;
use App\Models\Page as PageModel;
use Filament\Resources\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Contracts\HasTable;
use App\Filament\Resources\LoomAgentResource;
use App\Models\LoomAgent;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class ImportPage extends Page implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    protected static string $resource = LoomAgentResource::class;

    protected static string $view = 'filament.resources.loom-agent-resource.pages.import-page';

    public function mount($record)
    {
        $loomAgent = LoomAgent::query()->find($record);
        if (!$loomAgent) {
            abort(404);
        }
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(PageModel::query())
            ->headerActions([
                Tables\Actions\Action::make('import')
                    ->label('Import Page')
                    ->icon('heroicon-o-document-arrow-down')
                    ->requiresConfirmation()
            ])
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                // ...
            ])
            ->bulkActions([
                // ...
            ]);
    }
}
