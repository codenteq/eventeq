<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;

class ViewStatistics extends Page
{
    use InteractsWithRecord;

    protected static string $resource = EventResource::class;

    protected static string $view = 'filament.resources.event-resource.pages.view-statistics';

    protected static ?string $title = 'Etkinlik İstatistikleri';

    public function getHeading(): string
    {
        return $this?->record?->name;
    }


    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

    protected function getHeaderWidgets(): array
    {
        return [
            EventResource\Widgets\EventStatsOverview::class,
            EventResource\Widgets\JobEventApplicationChart::class,
        ];
    }

}
