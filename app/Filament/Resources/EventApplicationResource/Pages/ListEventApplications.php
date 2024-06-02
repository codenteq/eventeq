<?php

namespace App\Filament\Resources\EventApplicationResource\Pages;

use App\Filament\Resources\EventApplicationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEventApplications extends ListRecords
{
    protected static string $resource = EventApplicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
