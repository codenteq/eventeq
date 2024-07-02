<?php

namespace App\Jobs;

use App\Models\EventApplication;
use App\Notifications\EventAccessCardNotification;
use App\Notifications\EventApplicationNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class AccessCardGenerate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly int $applicationId)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $application = EventApplication::query()
            ->with(['user', 'event', 'city', 'children'])
            ->find($this->applicationId);

        $user = $application->user;

        $qrcode = base64_encode(QrCode::format('png')->size(600)->generate(route('application.success', $this->applicationId)));

        $fileName = str()->slug($application->user->name) . '-' . $this->applicationId . '.pdf';

        $attachments = collect();

        if (!Storage::exists('app/public/access-card')) {
            Storage::makeDirectory('public/access-card');
        }

        $data = [
            'applicationId' => $application->id,
            'name' => $application?->user?->name,
            'eventName' => $application?->event?->name,
            'eventLocation' => $application?->city?->name,
            'eventStartDate' => Carbon::parse($application?->event?->start_date)->format('d.m.Y'),
            'eventEndDate' => Carbon::parse($application?->event?->end_date)->format('d.m.Y'),
            'qrcode' => $qrcode,

        ];
        $pdf = Pdf::loadView('access-card', $data)->setPaper([0, 0, 1063, 1417]);

        $pdf->save(storage_path('app/public/access-card/' . $fileName));
        $attachments->push(public_path('storage/access-card/' . $fileName));

        $application?->children?->each(function ($child) use (&$application, &$data, &$attachments, $fileName) {
            $data['name'] = $child->full_name;
            $fileName = str()->slug($child->full_name) . '-' . $this->applicationId . '.pdf';
            $pdf = Pdf::loadView('access-card', $data)->setPaper([0, 0, 1063, 1417]);
            $pdf->save(storage_path('app/public/access-card/' . $fileName));
            $attachments->push(public_path('storage/access-card/' . $fileName));
        });

        $user->notify(new EventAccessCardNotification(
                $application->id,
                $user->name,
                $application?->event?->name,
                $attachments->toArray()
            )
        );
    }
}
