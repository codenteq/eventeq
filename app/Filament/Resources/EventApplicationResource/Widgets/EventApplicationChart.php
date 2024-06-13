<?php

namespace App\Filament\Resources\EventApplicationResource\Widgets;

use App\Models\Event;
use Filament\Widgets\ChartWidget;

class EventApplicationChart extends ChartWidget
{
    protected static ?string $heading = 'Etkinlik Başvuru İstatistikleri';

    protected function getData(): array
    {
        $applicationStatistics = collect();

        Event::all()->each(function (Event $event) use ($applicationStatistics) {
            $applicationStatistics->push([
                'label' => str()->limit($event->name, 35),
                'data' => [$event->applications()->count()],
            ]);
        });

        $events = Event::query()
            ->pluck('name')
            ->map(function ($name) {
                return str()->limit($name, 35);
            })
            ->toArray();

        return [
            'datasets' => [
                ...$applicationStatistics,
            ],
            'labels' => [
                ...$events
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
