<?php

namespace App\Services;

use App\Jobs\AccessCardGenerate;
use App\Models\EventApplication;
use App\Models\Group;
use App\Models\GroupChild;
use App\Models\User;
use App\Notifications\EventApplicationNotification;
use App\Notifications\EventCheckInNotification;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EventApplicationService
{
    public function create(array $data, int $eventId): Model|Builder|null
    {
        $user = User::query()->where('email', $data['email'])->first();

        $application = null;
        $group = null;

        DB::transaction(function () use ($data, $eventId, &$user, &$application, &$group) {
            if (!$user) {
                $user = User::query()->create([
                    'name' => $data['full_name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'password' => bcrypt(rand(100000, 999999)),
                    'gender' => $data['gender'],
                    'birth_date' => Carbon::createFromDate($data['birth_date'], 6, 1),
                ]);
            }

            if (!empty($data['participants'])) {
                $group = Group::query()->create([
                    'user_id' => $user->id,
                    'event_id' => $eventId,
                ]);

                foreach ($data['participants'] as $participant) {
                    GroupChild::query()->create([
                        'group_id' => $group->id,
                        'full_name' => $participant['full_name'],
                        'birth_date' => Carbon::createFromDate($participant['birth_date'], 6, 1),
                        'gender' => $participant['gender']
                    ]);
                }
            }

            $application = EventApplication::query()->create([
                'job' => $data['job'],
                'transportation' => $data['transportation'],
                'tent' => $data['tent'],
                'sleeping_bag' => $data['sleeping_bag'],
                'mat' => $data['mat'],
                'chair' => $data['chair'],
                'dont_camping_equipment' => $data['dont_camping_equipment'],
                'share_telescope' => $data['share_telescope'],
                'bring_telescope' => $data['bring_telescope'],
                'telescope' => $data['telescope'],
                'telescope_brand' => $data['telescope_brand'],
                'swaddling' => $data['swaddling'],
                'swaddling_brand' => $data['swaddling_brand'],
                'binocular' => $data['binocular'],
                'camera' => $data['camera'],
                'tripod' => $data['tripod'],
                'walkie_talkie' => $data['walkie_talkie'],
                'computer' => $data['computer'],
                'arrival_date' => $data['arrival_date'],
                'departure_date' => $data['departure_date'],
                'city_id' => $data['city_id'],
                'user_id' => $user['id'],
                'event_id' => $eventId,
                'group_id' => $group?->id,
            ]);
        });

        $user->notify(new EventApplicationNotification(
                $application->id,
                $application->event->id,
                $user->name,
                $application?->event?->name
            )
        );

        return $application;
    }

    public function update(array $data, EventApplication $application): void
    {
        $application->update([
            'job' => $data['job'],
            'transportation' => $data['transportation'],
            'tent' => $data['tent'],
            'sleeping_bag' => $data['sleeping_bag'],
            'mat' => $data['mat'],
            'chair' => $data['chair'],
            'dont_camping_equipment' => $data['dont_camping_equipment'],
            'share_telescope' => $data['share_telescope'],
            'bring_telescope' => $data['bring_telescope'],
            'telescope' => $data['telescope'],
            'telescope_brand' => $data['telescope_brand'],
            'swaddling' => $data['swaddling'],
            'swaddling_brand' => $data['swaddling_brand'],
            'binocular' => $data['binocular'],
            'camera' => $data['camera'],
            'tripod' => $data['tripod'],
            'walkie_talkie' => $data['walkie_talkie'],
            'computer' => $data['computer'],
            'arrival_date' => $data['arrival_date'],
            'departure_date' => $data['departure_date'],
            'city_id' => $data['city_id'],
            'check_in' => now()
        ]);

        $application->children()->delete();

        $application->user()->update([
            'name' => $data['full_name'],
            'phone' => $data['phone'],
            'gender' => $data['gender'],
            'birth_date' => Carbon::createFromDate($data['birth_date'], 6, 1),
        ]);

        foreach ($data['participants'] as $participant) {
            GroupChild::query()->create([
                'group_id' => $application->group_id,
                'full_name' => $participant['full_name'],
                'birth_date' => Carbon::createFromDate($participant['birth_date'], 6, 1),
                'gender' => $participant['gender']
            ]);
        }

        AccessCardGenerate::dispatch($application->id);
    }

    public function checkIn(int $eventId): void
    {
        $applications = EventApplication::query()
            ->where('event_id', $eventId)
            ->where('check_in', null)
            ->with('user')
            ->get();

        foreach ($applications as $application) {
            $application->user->notify(new EventCheckInNotification($application->id, $application->event->name));
        }
    }
}
