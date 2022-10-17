<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\{Client, Role, User};
use Filament\Forms\Components\{Hidden, TextInput, Select};
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'Usuários';
    protected static ?string $pluralLabel = 'Usuários';
    protected static ?string $modelLabel = 'Usuário';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                         Hidden::make('has_client')
                               ->dehydrated(false),
                         TextInput::make('name')
                                  ->label('Nome')
                                  ->maxLength(258)
                                  ->required(),
                         TextInput::make('email')
                                  ->label('Email')
                                  ->email()
                                  ->unique(table: User::class, ignoreRecord: true)
                                  ->maxLength(258)
                                  ->required(),
                         Select::make('role_id')
                               ->label('Grupo')
                               ->options(Role::all()->pluck('title', 'id'))
                               ->searchable()
                               ->reactive()
                               ->afterStateUpdated(fn(callable $set, $state) => $set('has_client', Role::find($state)->has_client))
                               ->afterStateHydrated(fn(callable $set, $state) => $state ? $set('has_client', Role::find($state)->has_client) : null)
                               ->required(),
                         Select::make('client_id')
                               ->label('Cliente')
                               ->options(Client::all()->pluck('name', 'id'))
                               ->searchable()
                               ->required(fn(callable $get) => (int) $get('has_client') === 1)
                               ->hidden(fn(callable $get) => (int) $get('has_client') !== 1)
                               ->dehydrated(fn(callable $get) => (int) $get('has_client') === 1),
                         TextInput::make('password')
                                  ->label('Senha')
                                  ->maxLength(64)
                                  ->minLength(8)
                                  ->password()
                                  ->confirmed()
                                  ->dehydrated(fn(callable $get) => $get('password'))
                                  ->disableAutocomplete(),
                         TextInput::make('password_confirmation')
                                  ->label('Confirme sua senha')
                                  ->dehydrated(false)
                                  ->password()
                                  ->disableAutocomplete(),
                     ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                          Tables\Columns\TextColumn::make('name')
                                                   ->label('Nome')
                                                   ->sortable()
                                                   ->searchable(isIndividual: true),
                          Tables\Columns\TextColumn::make('email')
                                                   ->label('Email')
                                                   ->sortable()
                                                   ->searchable(isIndividual: true),
                          Tables\Columns\TextColumn::make('role.title')
                                                   ->label('Grupo')
                                                   ->sortable()
                                                   ->searchable(isIndividual: true),
                          Tables\Columns\TextColumn::make('client.name')
                                                   ->label('Cliente')
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
            'index' => Pages\ManageUsers::route('/'),
        ];
    }
}
