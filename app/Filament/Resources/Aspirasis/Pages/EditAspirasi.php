<?php

namespace App\Filament\Resources\Aspirasis\Pages;

use App\Filament\Resources\Aspirasis\AspirasiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAspirasi extends EditRecord
{
    protected static string $resource = AspirasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
