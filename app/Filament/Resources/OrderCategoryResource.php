<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderCategoryResource\Pages;
use App\Filament\Resources\OrderCategoryResource\RelationManagers;
use App\Models\OrderCategory;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderCategoryResource extends Resource
{
    protected static ?string $model = OrderCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationLabel = 'Categorias';
    protected static ?string $pluralLabel = 'Categorias';
    protected static ?string $modelLabel = 'Categoria';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageOrderCategories::route('/'),
        ];
    }
}
