<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
                    ->visibleOn('create')
                    ->required(),
                Select::make('roles')->multiple()->relationship('roles', 'name')
                    ->preload()
                    ->relationship(
                        'roles',
                        'name',
                        modifyQueryUsing: fn($query) => $query->where('name', '!=', 'super admin')
                    )   
            ]);
    }
}
