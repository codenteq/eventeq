<?php

namespace App\Filament\Resources\EventResource\Widgets;

use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Infolists\Components\Component;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;


class EventStatsOverview extends BaseWidget
{
    use InteractsWithRecord, InteractsWithInfolists;

    protected function getStats(): array
    {
        return [
            Stat::make('Etkinlik Başvuru Sayısı', $this->record->applications()->count()),
            Stat::make('Toplam Katılımcı Sayısı',
                $this->record->applications()->withCount('children')->get()->sum('children_count') + $this->record->applications()->count()),
            Stat::make('Check In Yapan Katılımcı Sayısı', $this->record->applications()->whereNotNull('check_in')->count()),

            Stat::make('0-6 Yaş Katılımcı Sayısı', $this->getAgeGroupCount(0, 6)),
            Stat::make('7-10 Yaş Katılımcı Sayısı', $this->getAgeGroupCount(7, 10)),
            Stat::make('11-13 Yaş Katılımcı Sayısı', $this->getAgeGroupCount(11, 13)),
            Stat::make('14-18 Yaş Katılımcı Sayısı', $this->getAgeGroupCount(14, 18)),
            Stat::make('18 Yaş Üstü Katılımcı Sayısı', $this->getAgeGroupCount(19, 100)),

            Stat::make('Tahmini Araç Sayısı', $this->record->applications()->where('transportation', 'Özel Araçla')->count()),
            Stat::make('Teleskop Sayısı', $this->record->applications()->sum('bring_telescope')),
            Stat::make('Teleskop Paylaşımı', $this->record->applications()->sum('share_telescope')),
        ];
    }


    protected function getAgeGroupCount(int $startAge, int $endAge): int
    {
        $childrenCount = $this->record->applications()->whereHas('children', function ($query) use ($startAge, $endAge) {
            $query->whereRaw("TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN $startAge AND $endAge");
        })->withCount(['children' => function ($query) use ($startAge, $endAge) {
            $query->whereRaw("TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN $startAge AND $endAge");
        }])->get()->sum('children_count');

        $userCount = $this->record->applications()->whereHas('user', function ($query) use ($startAge, $endAge) {
            $query->whereRaw("TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) BETWEEN $startAge AND $endAge");
        })->count();

        return $childrenCount + $userCount;
    }
}
