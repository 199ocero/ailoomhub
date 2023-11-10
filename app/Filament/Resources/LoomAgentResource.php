<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LoomAgentResource\Pages;
use App\Filament\Resources\LoomAgentResource\RelationManagers;
use App\Models\AiModel;
use App\Models\LoomAgent;
use App\Models\Provider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                                Forms\Components\Select::make('provider')
                                    ->placeholder('Select a Provider')
                                    ->prefixIcon('heroicon-o-cube')
                                    ->required()
                                    ->options(Provider::all()->pluck('name', 'id'))
                                    ->live(),
                                Forms\Components\Select::make('model')
                                    ->placeholder('Select a Model')
                                    ->prefixIcon('heroicon-o-cube-transparent')
                                    ->required()
                                    ->options(fn (Get $get) => AiModel::where('provider_id', $get('provider'))->pluck('name', 'id')),
                            ]),
                        Forms\Components\TextInput::make('token')
                            ->label('API Secret Key')
                            ->placeholder('Your API Secret Key')
                            ->prefixIcon('heroicon-o-key')
                            ->required()
                            ->password()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('system_message')
                            ->label('System Message')
                            ->default('You are a helpful assistant.')
                            ->placeholder('The system message helps set the behavior of the assistant. For example, you can modify the personality of the assistant or provide specific instructions about how it should behave throughout the conversation.')
                            ->required()
                            ->string(),
                        Forms\Components\TextInput::make('knowledge_base')
                            ->label('Knowledge Base')
                            ->placeholder('https://example.com/knowledge-base.pdf')
                            ->prefixIcon('heroicon-o-book-open')
                            ->required()
                            ->url(),
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
                    ->searchable(),
                Tables\Columns\TextColumn::make('provider')
                    ->searchable(),
                Tables\Columns\TextColumn::make('model')
                    ->searchable(),
                Tables\Columns\TextColumn::make('system_message')
                    ->searchable(),
                Tables\Columns\TextColumn::make('knowledge_base')
                    ->searchable(),
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('usage_count')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_used')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
