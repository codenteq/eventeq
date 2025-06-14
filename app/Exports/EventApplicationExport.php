<?php

namespace App\Exports;

use App\Models\EventApplication;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EventApplicationExport implements FromCollection, WithMapping, WithHeadings
{

    public function __construct(private readonly int $eventId)
    {
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection(): \Illuminate\Support\Collection
    {
            return EventApplication::query()->where('event_id', $this->eventId)->with(['city', 'user'])->get();
    }

    public function headings(): array
    {
        return [
            'Başvuru ID',
            'Adı Soyadı',
            'Yaş',
            'Cinsiyet',
            'E-Posta',
            'Telefon',
            'Şehir',
            'İş',
            'Teleskop Getirme',
            'Teleskop Paylaşımı',
            'Geliş Tarihi',
            'Ayrılış Tarihi',
            /* 'Çadır',
            'Uyku Tulumu',
            'Mat',
            'Sandalye',
            'Teleskop',
            'Teleskop Markası',
            'Dürbün',
            'Kamera',
            'Tripod',
            'Telsiz',
            'Bilgisayar',*/
        ];
    }

    public function map($eventApplication): array
    {
        return [
            $eventApplication->id,
            $eventApplication->user->name,
            $eventApplication->user->birth_date ? now()->diffInYears($eventApplication->user->birth_date) : 'Bilinmiyor',
            $eventApplication->user->gender,
            $eventApplication->user->email,
            $eventApplication->user->phone,
            $eventApplication->city->name,
            $eventApplication->job,
            $eventApplication->bring_telescope ? 'Evet' : 'Hayır',
            $eventApplication->share_telescope ? 'Evet' : 'Hayır',
            $eventApplication->arrival_date,
            $eventApplication->departure_date,
            /* $eventApplication->tent,
           $eventApplication->sleeping_bag,
           $eventApplication->mat,
           $eventApplication->chair,
           $eventApplication->telescope,
           $eventApplication->telescope_brand,
           $eventApplication->binocular,
           $eventApplication->camera,
           $eventApplication->tripod,
           $eventApplication->walkie_talkie,
           $eventApplication->computer,*/
        ];
    }
}
