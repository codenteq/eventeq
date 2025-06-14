<?php

namespace App\Exports;

use App\Models\EventApplication;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EventApplicationExport implements FromCollection, WithMapping, WithHeadings
{

    private int $rowNumber = 0;

    public function __construct(private readonly int $eventId)
    {
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection(): \Illuminate\Support\Collection
    {
        $applications = EventApplication::query()
            ->where('event_id', $this->eventId)
            ->with(['city', 'user', 'children'])
            ->get();

        $result = collect();

        foreach ($applications as $application) {
            $result->push([
                'type' => 'applicant',
                'data' => $application
            ]);

            foreach ($application->children as $child) {
                $result->push([
                    'type' => 'child',
                    'data' => $child,
                    'parent' => $application
                ]);
            }
        }

        return $result;
    }

    public function headings(): array
    {
        return [
            '#',
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

    public function map($row): array
    {
        $this->rowNumber++;

        if ($row['type'] === 'applicant') {
            $application = $row['data'];
            return [
                $this->rowNumber,
                $application->id,
                $application->user->name,
                \Carbon\Carbon::parse($application->user->birth_date)->age,
                $application->user->gender,
                $application->user->email,
                $application->user->phone,
                $application->city->name,
                $application->job,
                $application->bring_telescope ? 'Evet' : 'Hayır',
                $application->share_telescope ? 'Evet' : 'Hayır',
                $application->arrival_date,
                $application->departure_date,
            ];
        } else {
            // This is a child
            $child = $row['data'];
            $parent = $row['parent'];

            return [
                $this->rowNumber,
                '',
                $child->full_name,
                \Carbon\Carbon::parse($child->birth_date)->age,
                $child->gender,
                '', // Email
                '', // Phone
                $parent->city->name,
                '', // Job
                '', // Telescope
                '', // Share
                '',
                '',
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
}

