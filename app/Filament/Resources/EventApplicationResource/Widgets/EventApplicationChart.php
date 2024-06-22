<?php

namespace App\Filament\Resources\EventApplicationResource\Widgets;

use App\Models\Event;
use App\Models\EventApplication;
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
                'data' => [$event->applications()->count() + $event->applications()->get()->reduce(function ($carry, $application) {
                        return $carry + $application->loadCount('children')['children_count'];
                    }, 0)],
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
