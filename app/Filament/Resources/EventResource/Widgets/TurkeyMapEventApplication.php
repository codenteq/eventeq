<?php

namespace App\Filament\Resources\EventResource\Widgets;

use App\Models\Event;
use App\Models\EventApplication;
use Filament\Pages\Dashboard\Concerns\HasFiltersAction;
use Filament\Widgets\Widget;

class TurkeyMapEventApplication extends Widget
{
    use HasFiltersAction;

    protected static string $view = 'filament.resources.event-resource.widgets.turkey-map-event-application';

    protected static ?string $heading = 'Şehir Bazlı Başvurular';

    protected int | string | array $columnSpan = 'full';

    protected static bool $isLazy = false;

    public function getData(): array
    {
        $event = Event::query()->latest()->first();

        $activeFilter = $this->filter ?? $event?->id;

        if (!$activeFilter) {
            return [];
        }

        $cityData = EventApplication::query()
            ->where('event_id', $activeFilter)
            ->with('city')
            ->get()
            ->groupBy('city_id')
            ->map(function ($group) {
                $city = $group->first()->city;
                return [
                    'name' => $city->name,
                    'count' => $group->count(),
                ];
            })
            ->values()
            ->toArray();

        return $cityData;
    }

    protected function getFilters(): ?array
    {
        return Event::query()->latest()->pluck('name', 'id')->toArray();
    }
}
