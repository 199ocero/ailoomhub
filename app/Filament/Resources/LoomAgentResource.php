<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\AiModel;
use Filament\Forms\Get;
use App\Models\AiProvider;
use Filament\Forms\Form;
use App\Models\LoomAgent;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\LoomAgentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\LoomAgentResource\RelationManagers;
use App\Models\KnowledgeBase;

class LoomAgentResource extends Resource
{
    protected static ?string $model = LoomAgent::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Loom Agent')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->placeholder('My Loom Agent')
                            ->prefixIcon('heroicon-o-sparkles')
                            ->required()
                            ->string()
                            ->autofocus()
                            ->columnSpanFull(),
                        Forms\Components\Grid::make()
                            ->columns(2)
                            ->schema([
                                Forms\Components\Select::make('ai_provider_id')
                                    ->label('Provider')
                                    ->placeholder('Select a Provider')
                                    ->prefixIcon('heroicon-o-cube')
                                    ->required()
                                    ->options(AiProvider::all()->pluck('name', 'id'))
                                    ->live(),
                                Forms\Components\Select::make('ai_model_id')
                                    ->label('Model')
                                    ->placeholder('Select a Model')
                                    ->prefixIcon('heroicon-o-cube-transparent')
                                    ->required()
                                    ->options(fn (Get $get) => AiModel::where('ai_provider_id', $get('ai_provider_id'))->pluck('name', 'id')),
                            ]),
                        Forms\Components\TextInput::make('token')
                            ->label('API Secret Key')
                            ->placeholder('Your API Secret Key')
                            ->helperText('For security reasons, do not share this with anyone.')
                            ->prefixIcon('heroicon-o-key')
                            ->required()
                            ->password()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('system_message')
                            ->label('System Message')
                            ->placeholder('The system message helps set the behavior of the assistant. For example, you can modify the personality of the assistant or provide specific instructions about how it should behave throughout the conversation.')
                            ->required()
                            ->string(),
                        Forms\Components\Select::make('knowledge_base_id')
                            ->label('Knowledge Base')
                            ->placeholder('Select a Knowledge Base')
                            ->options(KnowledgeBase::all()->pluck('name', 'id'))
                            ->required(),
                        Forms\Components\Toggle::make('status')
                            ->required()
                            ->default(true),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('aiProvider.name')
                    ->label('Provider')
                    ->sortable()
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('aiModel.name')
                    ->label('Model')
                    ->sortable()
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('knowledgeBase.name')
                    ->label('Knowledge Base')
                    ->sortable()
                    ->searchable()
                    ->wrap(),
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('usage_count')
                    ->label('Usage Count')
                    ->numeric()
                    ->sortable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('last_used')
                    ->label('Last Used')
                    ->placeholder('Never used')
                    ->dateTime('F j, Y h:i:s A')
                    ->sortable()
                    ->wrap(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->modalHeading(fn (Model $record): string => __('filament-actions::delete.single.modal.heading', ['label' => $record->name])),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLoomAgents::route('/'),
            'create' => Pages\CreateLoomAgent::route('/create'),
            'edit' => Pages\EditLoomAgent::route('/{record}/edit'),
        ];
    }
}
