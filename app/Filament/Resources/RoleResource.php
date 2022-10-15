<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Filament\Resources\RoleResource\RelationManagers;
use App\Models\Role;
use Filament\Forms\Components\{TextInput, Toggle, Select};
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Grupos';
    protected static ?string $pluralLabel = 'Grupos';
    protected static ?string $modelLabel = 'Grupo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                         TextInput::make('title')
                                  ->label('Nome')
                                  ->maxValue(128)
                                  ->required(),
                         Select::make('permissions')
                               ->label('Permissões')
                               ->searchDebounce(500)
                               ->searchable()
                               ->relationship('permissions', 'title')
                               ->multiple(),
                         Toggle::make('can_be_assigned')
                               ->label('Pode ser atribuído'),
                         Toggle::make('has_client')
                               ->label('Possui cliente'),
                     ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                          Tables\Columns\TextColumn::make('title')
                                                   ->label('Título')
                                                   ->sortable()
                                                   ->searchable(isIndividual: true),
                          Tables\Columns\TextColumn::make('created_at')
                                                   ->label('Cadastrado em')
                                                   ->date('d/m/Y H:i:s')
                                                   ->sortable()
                                                   ->searchable(isIndividual: true),
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
            'index' => Pages\ManageRoles::route('/'),
        ];
    }
}
