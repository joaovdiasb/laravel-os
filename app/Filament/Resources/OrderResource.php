<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use App\Models\OrderCategory;
use Filament\Forms\Components\{Card, RichEditor, Select, TextInput};
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-inbox';
    protected static ?string $navigationLabel = 'Chamados';
    protected static ?string $pluralLabel = 'Chamados';
    protected static ?string $modelLabel = 'Chamado';

    public static function canShow(Order $order): bool
    {
        return static::can('show', $order);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                         Card::make(self::getForm())
                             ->columns(1),
                     ]);
    }

    public static function getForm(): array
    {
        return [
            Select::make('order_category_id')
                  ->label('Categoria')
                  ->options(OrderCategory::all()
                                         ->pluck('title', 'id'))
                  ->searchable()
                  ->required(),
            TextInput::make('subject')
                     ->label('Assunto')
                     ->maxLength(258)
                     ->required(),
            RichEditor::make('message')
                      ->label('Mensagem')
                      ->toolbarButtons([
                                           'attachFiles',
                                           'blockquote',
                                           'bold',
                                           'bulletList',
                                           'codeBlock',
                                           'h2',
                                           'h3',
                                           'italic',
                                           'link',
                                           'orderedList',
                                           'redo',
                                           'strike',
                                           'undo',
                                       ])
                      ->fileAttachmentsDirectory('attachments')
                      ->fileAttachmentsVisibility('public')
                      ->maxLength(5120),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                          Tables\Columns\TextColumn::make('orderSituation.title')
                                                   ->label('Situação')
                                                   ->sortable()
                                                   ->searchable(isIndividual: true),
                          Tables\Columns\TextColumn::make('subject')
                                                   ->label('Assunto')
                                                   ->sortable()
                                                   ->searchable(isIndividual: true),
                          Tables\Columns\TextColumn::make('registered.name')
                                                   ->label('Aberto por')
                                                   ->sortable()
                                                   ->searchable(isIndividual: true),
                          Tables\Columns\TextColumn::make('assigned.name')
                                                   ->label('Atribuído para')
                                                   ->sortable()
                                                   ->searchable(isIndividual: true),
                          Tables\Columns\TextColumn::make('orderFlow.created_at')
                                                   ->label('Último andamento em')
                                                   ->date('d/m/Y H:i:s')
                                                   ->sortable()
                                                   ->searchable(isIndividual: true),
                      ])
            ->filters([
                          //
                      ])
            ->actions([
                          Tables\Actions\Action::make('view')
                                               ->label('Visualizar')
                                               ->icon('heroicon-o-eye')
                                               ->url(fn(Order $record) => route('filament.resources.orders.edit', $record)),
                          Tables\Actions\DeleteAction::make(),
                      ])
            ->bulkActions([
                              Tables\Actions\DeleteBulkAction::make(),
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
            'index'  => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit'   => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
