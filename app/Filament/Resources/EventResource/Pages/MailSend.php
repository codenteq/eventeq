<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Filament\Resources\EventResource;
use App\Notifications\CustomNotification;
use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Support\Exceptions\Halt;
use Illuminate\Validation\ValidationException;


class MailSend extends Page implements HasForms
{
    use InteractsWithRecord, InteractsWithForms;

    public ?array $data = [];

    protected static string $resource = EventResource::class;

    protected static string $view = 'filament.resources.event-resource.pages.mail-send';

    protected static ?string $title = 'Mail Gönder';

    public function getHeading(): string
    {
        return $this?->record?->name;
    }

    public function mount(int | string $record): void
    {
        $this->form->fill();
        $this->record = $this->resolveRecord($record);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('subject')
                    ->required()
                    ->label('Mail Konusu'),
                RichEditor::make('content')
                    ->required()
                    ->columnSpanFull()
                    ->label('Mail İçeriği')
            ])
            ->statePath('data')
            ->model($this->record);
    }

    public function getFormActions(): array
    {
        return [
            Action::make('Gönder')
                ->submit('submit'),
        ];
    }

    /**
     * @throws ValidationException
     */
    public function submit(): void
    {
        try {
            $data = $this->form->getState();

            $this->form->validate();

            // Send mail
            $this->record->applications()->each(function ($application) use(&$data) {
                $application->user->notify((new CustomNotification($data['subject'], $data['content']))->delay(now()->addSeconds(10)));
            });

        } catch (Halt $exception) {
            return;
        }

        Notification::make()
            ->success()
            ->title("Mail başarıyla gönderildi")
            ->send();
    }
}
