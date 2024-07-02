<?php

namespace App\Filament\Resources\EventApplicationResource\Widgets;

use App\Models\Event;
use App\Models\EventApplication;
use Filament\Widgets\ChartWidget;

class JobEventApplicationChart extends ChartWidget
{
    protected static ?string $heading = 'Meslek Bazlı Başvurular';

    protected array $colors = [
        '#FF5733', '#33FF57', '#5733FF', '#FF33A5', '#33FFF5', '#FF8333', '#33FF83', '#FF3383', '#83FF33',
    ];

    protected function getData(): array
    {
        $event = Event::query()->latest()->first();

        $activeFilter = $this->filter == null ? $event->id : $this->filter;

        $eventApplication = EventApplication::query()
            ->groupBy('job')
            ->where('event_id', $activeFilter);

        $jobCounts = $eventApplication
            ->selectRaw('job, count(*) as total')
            ->pluck('total');

        return [
            'labels' => $eventApplication->pluck('job'),
            'datasets' => [
                [
                    'label' => 'Etkinlik Başvuru Sayısı',
                    'data' => $jobCounts,
                    'backgroundColor' => $this->colors,
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }

    protected function getFilters(): ?array
    {
        return Event::query()->latest()->pluck('name', 'id')->toArray();
    }
}
