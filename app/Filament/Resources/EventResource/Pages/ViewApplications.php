<?php

namespace App\Filament\Resources\EventResource\Pages;

use App\Exports\EventApplicationExport;
use App\Filament\Resources\EventResource;
use App\Models\Event;
use App\Models\EventApplication;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Tables;
use Filament\Forms;

class ViewApplications extends ViewRecord implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = EventResource::class;

    protected static string $view = 'filament.resources.event-resource.pages.view-applications';

    protected static ?string $title = 'Etkinlik Başvuruları';

    protected static ?string $navigationLabel = 'Başvurular';

    public function getHeading(): string
    {
        return $this->record->name . ' - Başvurular';
    }

    public function table(Table $table): Table
    {
        return $table
            ->poll('10s')
            ->headerActions([
                Tables\Actions\Action::make('download')
                    ->label('Excel Olarak İndir')
                    ->color('gray')
                    ->action(fn(): \Symfony\Component\HttpFoundation\BinaryFileResponse => Excel::download(new EventApplicationExport($this->record->id), 'etkinlik-başvurulari.xlsx')),
                Tables\Actions\Action::make('create')
                    ->label('Başvuru Oluştur')
                    ->url(fn(): string => route('application.index', $this->record->id))
                    ->openUrlInNewTab(),
            ])
            ->query(
                EventApplication::query()->where('event_id', $this->record->id)
                    ->with(['user', 'city', 'group', 'children'])
            )
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Katılımcı')
                    ->searchable(),
                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable(),
                TextColumn::make('city.name')
                    ->label('Şehir')
                    ->searchable(),
                TextColumn::make('children_count')
                    ->label('Çocuk Sayısı')
                    ->getStateUsing(fn (EventApplication $record) => $record->children->count()),
                TextColumn::make('check_in')
                    ->label('Check-in')
                    ->formatStateUsing(fn ($state) => $state ? 'Yapıldı' : 'Yapılmadı')
                    ->badge()
                    ->color(fn ($state) => $state ? 'success' : 'danger'),
                TextColumn::make('created_at')
                    ->label('Başvuru Tarihi')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make('Düzenle / Check-in')
                    ->form([
                        Forms\Components\TextInput::make('user.name')
                            ->label('Adı Soyadı'),
                        Forms\Components\TextInput::make('user.email')
                            ->label('E-Posta'),
                        Forms\Components\TextInput::make('user.phone')
                            ->label('Telefon'),
                        Forms\Components\DateTimePicker::make('user.birth_date')
                            ->label('Doğum Tarihi'),
                        Forms\Components\TextInput::make('job')
                            ->label('Meslek'),
                        Forms\Components\TextInput::make('transportation')
                            ->label('Ulaşım'),
                    ])
                    ->mutateRecordDataUsing(function (array $data, EventApplication $record): array {
                        $data['user'] = [
                            'name' => $record->user->name,
                            'email' => $record->user->email,
                            'phone' => $record->user->phone,
                            'birth_date' => $record->user->birth_date,
                        ];

                        return $data;
                    })
                    ->using(function (EventApplication $record, array $data): EventApplication {
                        $record->update([
                            'job' => $data['job'] ?? $record->job,
                            'transportation' => $data['transportation'] ?? $record->transportation,
                        ]);

                        if (isset($data['user'])) {
                            $record->user()->update([
                                'name' => $data['user']['name'],
                                'email' => $data['user']['email'],
                                'phone' => $data['user']['phone'],
                                'birth_date' => $data['user']['birth_date'],
                            ]);
                        }

                        return $record;
                    }),
                Tables\Actions\DeleteAction::make('delete')
                    ->modalHeading('Başvuruyu Sil'),
                Tables\Actions\ViewAction::make()
                    ->mutateRecordDataUsing(function (array $data): array {
                        $user = User::find($data['user_id']);

                        $data['full_name'] = $user->name;
                        $data['email'] = $user->email;
                        $data['phone'] = $user->phone;
                        $data['birth_date'] = $user->birth_date;

                        return $data;
                    })
                    ->form([
                        Forms\Components\TextInput::make('full_name')
                            ->label('Adı Soyadı')
                            ->disabled(),
                        Forms\Components\TextInput::make('email')
                            ->label('E-Posta')
                            ->disabled(),
                        Forms\Components\TextInput::make('phone')
                            ->label('Telefon')
                            ->disabled(),
                        Forms\Components\DateTimePicker::make('birth_date')
                            ->label('Doğum Tarihi')
                            ->required(),
                        Forms\Components\TextInput::make('job')
                            ->label('Meslek')
                            ->disabled(),
                        Forms\Components\TextInput::make('transportation')
                            ->label('Etkinlik alanına ulaşımı nasıl sağlayacaksınız?')
                            ->disabled(),
                        Forms\Components\Section::make()
                            ->columns([
                                'sm' => 3,
                                'xl' => 6,
                                '2xl' => 8,
                            ])
                            ->schema([
                                Forms\Components\Section::make('Katılımcılar')
                                    ->schema([
                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\Repeater::make('Katılımcılar')
                                                    ->relationship('children')
                                                    ->schema([
                                                        Forms\Components\TextInput::make('full_name')
                                                            ->label('Adı Soyadı'),
                                                        Forms\Components\DateTimePicker::make('birth_date')
                                                            ->label('Doğum Tarihi')
                                                            ->required(),
                                                        Forms\Components\TextInput::make('gender')
                                                            ->label('Cinsiyet')
                                                    ]),
                                            ])
                                    ])->collapsed(),
                               /* Forms\Components\Section::make('Kamp Malzemesi İstekleri')
                                    ->schema([
                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\TextInput::make('tent')
                                                    ->label('Çadır Sayısı'),
                                                Forms\Components\TextInput::make('sleeping_bag')
                                                    ->label('Uyku Tulumu Sayısı'),
                                                Forms\Components\TextInput::make('mat')
                                                    ->label('Mat Sayısı'),
                                                Forms\Components\TextInput::make('chair')
                                                    ->label('Sandalye Sayısı'),
                                                Forms\Components\Checkbox::make('dont_camping_equipment')
                                                    ->label('Kamp Ekipmanı Temin Edilecek Mi?')
                                            ])
                                    ])->collapsed(),*/
                                Forms\Components\Section::make('Getirilecek Ekipmanlar')
                                    ->schema([
                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\Checkbox::make('bring_telescope')
                                                    ->label('Teleskop Getirme'),
                                                Forms\Components\Checkbox::make('share_telescope')
                                                    ->label('Teleskop Paylaşımı'),
             /*                                   Forms\Components\TextInput::make('telescope')
                                                    ->label('Teleskop Sayısı'),
                                                Forms\Components\TextInput::make('telescope_brand')
                                                    ->label('Teleskop Markası'),
                                                Forms\Components\TextInput::make('swaddling')
                                                    ->label('Kundak Sayısı'),
                                                Forms\Components\TextInput::make('swaddling_brand')
                                                    ->label('Kundak Markası'),
                                                Forms\Components\TextInput::make('binocular')
                                                    ->label('Dürbün Sayısı'),
                                                Forms\Components\TextInput::make('camera')
                                                    ->label('Kamera Sayısı'),
                                                Forms\Components\TextInput::make('tripod')
                                                    ->label('Tripod Sayısı'),
                                                Forms\Components\TextInput::make('walkie_talkie')
                                                    ->label('Telsiz Sayısı'),
                                                Forms\Components\TextInput::make('computer')
                                                    ->label('Bilgisayar Sayısı'),*/
                                            ])
                                    ])->collapsed(),
                            ]),
                        Forms\Components\DateTimePicker::make('arrival_date')
                            ->label('Geliş Tarihi'),
                        Forms\Components\DateTimePicker::make('departure_date')
                            ->label('Ayrılış Tarihi'),
                        Forms\Components\DateTimePicker::make('check_in')
                            ->label('Giriş Yapılma Tarihi')
                    ])
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
