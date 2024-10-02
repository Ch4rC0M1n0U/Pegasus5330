<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
        protected static ?string $model = User::class;
    
        protected static ?string $navigationIcon = 'heroicon-o-user';
        protected static ?string $navigationLabel = 'Utilisateurs';
        protected static ?string $navigationGroup = 'Configuration';
        protected static ?string $navigationBadgeTooltip = 'Liste des utilisateurs et gestion';
    
        public static function getNavigationBadge(): ?string
        {
            return static::getModel()::count();
        }
    
        public static function form(Form $form): Form
        {
            return $form
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('services')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('telUser')
                        ->tel()
                        ->required()
                        ->maxLength(20)
                        ->default(0),
                    Forms\Components\TextInput::make('Matricule')
                        ->required()
                        ->maxLength(50),
                    Forms\Components\Select::make('roles')
                        ->relationship('roles', 'name')
                        ->multiple()
                        ->preload()
                        ->searchable(),
                    Forms\Components\DateTimePicker::make('email_verified_at')
                        ->hiddenOn('edit'),
                    Forms\Components\TextInput::make('password')
                        ->password()
                        ->hidden()
                        ->maxLength(255),
                    Forms\Components\Textarea::make('two_factor_secret')
                        ->columnSpanFull()
                        ->hidden(),
                    Forms\Components\Textarea::make('two_factor_recovery_codes')
                        ->columnSpanFull()
                        ->disabled()
                        ->hidden(),
                    Forms\Components\DateTimePicker::make('two_factor_confirmed_at')
                        ->hiddenOn('edit'),
                    Forms\Components\TextInput::make('profile_photo_path')
                        ->maxLength(2048)
                        ->disabled(),
    
                ]);
        }
    
        public static function table(Table $table): Table
        {
            return $table
                ->columns([
                    Tables\Columns\TextColumn::make('name')
                        ->searchable()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('email')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('services')
                        ->searchable()
                        ->sortable(),
                    Tables\Columns\TextColumn::make('telUser')
                        ->searchable(),
                    Tables\Columns\TextColumn::make('Matricule')
                        ->searchable()
                        ->sortable(),
                        
                    Tables\Columns\TextColumn::make('created_at')
                        ->dateTime()
                        ->sortable()
                        ->toggleable(isToggledHiddenByDefault: true),
                    Tables\Columns\TextColumn::make('updated_at')
                        ->dateTime()
                        ->sortable()
                        ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
