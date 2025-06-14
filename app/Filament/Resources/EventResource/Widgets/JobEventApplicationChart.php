<?php

namespace App\Filament\Resources\EventResource\Widgets;

use App\Models\Event;
use App\Models\EventApplication;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Widgets\ChartWidget;

class JobEventApplicationChart extends ChartWidget
{
    use InteractsWithRecord, InteractsWithInfolists;

    protected static ?string $heading = 'Meslek Bazlı Başvurular';

    protected array $colors = [
        '#FF5733', '#33FF57', '#5733FF', '#FF33A5', '#33FFF5', '#FF8333', '#33FF83', '#FF3383', '#83FF33', '#3383FF',
        '#FF3383', '#83FF33', '#3383FF', '#FF5733', '#33FF57', '#5733FF', '#FF33A5', '#33FFF5', '#FF8333', '#33FF83',
        '#FF3383', '#83FF33', '#3383FF', '#FF3383', '#83FF33', '#3383FF', '#FF5733', '#33FF57', '#5733FF', '#FF33A5',
        '#33FFF5', '#FF8333', '#33FF83', '#FF3383', '#83FF33', '#3383FF', '#FF3383', '#83FF33', '#3383FF', '#FF5733',
        '#33FF57', '#5733FF', '#FF33A5', '#33FFF5', '#FF8333', '#33FF83', '#FF3383', '#83FF33', '#3383FF', '#FF3383',
        '#83FF33', '#3383FF', '#FF5733', '#33FF57', '#5733FF', '#FF33A5', '#33FFF5', '#FF8333', '#33FF83', '#FF3383',
        '#83FF33', '#3383FF', '#FF3383', '#83FF33', '#3383FF', '#FF5733', '#33FF57', '#5733FF', '#FF33A5', '#33FFF5',
        '#FF8333', '#33FF83', '#FF3383', '#83FF33', '#3383FF', '#FF3383', '#83FF33', '#3383FF', '#FF5733', '#33FF57',
        '#5733FF', '#FF33A5', '#33FFF5', '#FF8333', '#33FF83', '#FF3383', '#83FF33', '#3383FF', '#FF3383', '#83FF33',
        '#3383FF', '#FF5733', '#33FF57', '#5733FF', '#FF33A5', '#33FFF5', '#FF8333', '#33FF83', '#FF3383', '#83FF33',
        '#3383FF', '#FF3383', '#83FF33', '#3383FF', '#FF5733', '#33FF57', '#5733FF', '#FF33A5', '#33FFF5', '#FF8333'
    ];


    protected function getData(): array
    {
        $activeFilter = $this->record->id;

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
}
