<?php

namespace App\Filament\Resources\Aspirasis\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AspirasiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required(),
                TextInput::make('tempat')
                    ->required(),
                Textarea::make('deskripsi')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('feedback')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('status')
                    ->required()
                    ->default('menunggu'),
                Select::make('siswa_id')
                    ->relationship('siswa', 'id')
                    ->required(),
                Select::make('category_id')
                    ->relationship('category', 'id')
                    ->required(),
            ]);
    }
}
