<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\AiModel;
use Filament\Forms\Get;
use Filament\Forms\Form;
use App\Models\LoomAgent;
use App\Models\AiProvider;
use Filament\Tables\Table;
use App\Models\KnowledgeBase;
use Filament\Resources\Resource;
use Filament\Support\Enums\ActionSize;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\LoomAgentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\LoomAgentResource\RelationManagers;

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
                                    ->placeholder('Select Provider')
                                    ->prefixIcon('heroicon-o-cube')
                                    ->required()
                                    ->options(AiProvider::all()->pluck('name', 'id'))
                                    ->live(),
                                Forms\Components\Select::make('ai_model_id')
                                    ->label('Model')
                                    ->placeholder('Select Model')
                                    ->prefixIcon('heroicon-o-cube-transparent')
                                    ->required()
                                    ->options(fn (Get $get) => AiModel::where('ai_provider_id', $get('ai_provider_id'))->pluck('name', 'id')),
                            ]),
                        Forms\Components\TextInput::make('ai_provider_token')
                            ->label('Secret Key')
                            ->placeholder('Secret Key')
                            ->helperText('This will be used to access the selected AI provider.')
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
                            ->placeholder('Select Knowledge Base')
                            ->prefixIcon('heroicon-o-book-open')
                            ->options(KnowledgeBase::all()->pluck('name', 'id'))
                            ->live()
                            ->required(),
                        Forms\Components\TextInput::make('knowledge_base_token')
                            ->label('Secret Key')
                            ->placeholder('Secret Key')
                            ->helperText('This will be used to access the selected knowledge base.')
                            ->prefixIcon('heroicon-o-key')
                            ->hidden(fn (Get $get) => $get('knowledge_base_id') == null ? true : false)
                            ->required()
                            ->password(),
                        Forms\Components\Toggle::make('status')
                            ->label('Active')
                            ->required()
                            ->default(true)
                            ->onColor('success')
                            ->offColor('danger'),
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
                Tables\Columns\ToggleColumn::make('status')
                    ->onColor('success')
                    ->offColor('danger'),
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
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('page_retriever')
                        ->label('Page Retriever')
                        ->icon('heroicon-o-document-arrow-down'),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()
                        ->modalHeading(fn (Model $record): string => __('filament-actions::delete.single.modal.heading', ['label' => $record->name])),
                ])
                    ->label('Actions')
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->size(ActionSize::Small)
                    ->color('primary')
                    ->button()
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
