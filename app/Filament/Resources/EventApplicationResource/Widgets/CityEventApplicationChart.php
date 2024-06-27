<?php

namespace App\Filament\Resources\EventApplicationResource\Widgets;

use App\Models\City;
use App\Models\Event;
use App\Models\EventApplication;
use Filament\Widgets\ChartWidget;

class CityEventApplicationChart extends ChartWidget
{
    protected static ?string $heading = 'Şehir Bazlı Başvurular';

    protected array $colors = [
        '#FF5733', '#33FF57', '#5733FF', '#FF33A5', '#33FFF5', '#FF8333', '#33FF83', '#FF3383', '#83FF33',
        '#3383FF', '#FF3383', '#83FF33', '#3383FF', '#FF5733', '#33FF57', '#5733FF', '#FF33A5', '#33FFF5',
        '#FF8333', '#33FF83', '#FF3383', '#83FF33', '#3383FF', '#FF3383', '#83FF33', '#3383FF', '#FF5733',
        '#33FF57', '#5733FF', '#FF33A5', '#33FFF5', '#FF8333', '#33FF83', '#FF3383', '#83FF33', '#3383FF',
        '#FF3383', '#83FF33', '#3383FF', '#FF5733', '#33FF57', '#5733FF', '#FF33A5', '#33FFF5', '#FF8333',
        '#33FF83', '#FF3383', '#83FF33', '#3383FF', '#FF3383', '#83FF33', '#3383FF', '#FF5733', '#33FF57',
        '#5733FF', '#FF33A5', '#33FFF5', '#FF8333', '#33FF83', '#FF3383', '#83FF33', '#3383FF', '#FF3383',
        '#83FF33', '#3383FF', '#FF5733', '#33FF57', '#5733FF', '#FF33A5', '#33FFF5', '#FF8333', '#33FF83',
        '#FF3383', '#83FF33', '#3383FF', '#FF3383', '#83FF33', '#3383FF', '#FF5733', '#33FF57', '#5733FF',
        '#FF33A5', '#33FFF5', '#FF8333', '#33FF83', '#FF3383'
    ];

    protected function getData(): array
    {
        $event = Event::query()->latest()->first();

        $activeFilter = $this->filter == null ? $event->id : $this->filter;

        $eventApplication = EventApplication::query()
            ->where('event_id', $activeFilter);

        $cities = $eventApplication->with('city')
            ->get()
            ->groupBy('city_id')
            ->map(function ($group) {
                return $group->first()->city->name;
            })
            ->values()
            ->toArray();

        info($cities);

        return [
            'labels' => $cities,
            'datasets' => [
                [
                    'label' => 'Etkinlik Başvuru Sayısı',
                    'data' => $eventApplication->selectRaw('city_id, COUNT(*) as count')
                        ->groupBy('city_id')->pluck('count')->toArray(),
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
