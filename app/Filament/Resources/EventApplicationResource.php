<?php

namespace App\Filament\Resources;

use App\Exports\EventApplicationExport;
use App\Filament\Resources\EventApplicationResource\Pages;
use App\Filament\Resources\EventApplicationResource\RelationManagers;
use App\Models\Event;
use App\Models\EventApplication;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use FontLib\TrueType\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Facades\Excel;

class EventApplicationResource extends Resource
{
    protected static ?string $model = EventApplication::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $title = 'Etkinlik Başvuruları';

    protected static ?string $navigationLabel = 'Etkinlik Başvuruları';

    protected static ?string $label = 'Etkinlik Başvuru';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->relationship('user')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Adı Soyadı'),
                        Forms\Components\TextInput::make('email')
                            ->label('E-Posta'),
                        Forms\Components\TextInput::make('phone')
                            ->label('Telefon'),
                        Forms\Components\DateTimePicker::make('birth_date')
                            ->label('Doğum Tarihi'),
                    ]),
                Forms\Components\TextInput::make('job')
                    ->label('Meslek'),
                Forms\Components\Select::make('transportation')
                    ->label('Etkinlik alanına ulaşımı nasıl sağlayacaksınız?')
                    ->options([
                        'Özel Araçla' => 'Özel Araçla',
                        'Toplu Taşıma' => 'Toplu Taşıma',
                    ]),
                Forms\Components\Section::make()
                    ->columns([
                        'sm' => 3,
                        'xl' => 6,
                        '2xl' => 8,
                    ])
                    ->schema([
                        Forms\Components\Section::make('Kamp Malzemesi İstekleri')
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
                            ])->collapsed(),
                        Forms\Components\Section::make('Getirilecek Ekipmanlar')
                            ->schema([
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('telescope')
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
                                            ->label('Bilgisayar Sayısı'),
                                    ])
                            ])->collapsed(),
                    ]),
                Forms\Components\DateTimePicker::make('arrival_date')
                    ->label('Geliş Tarihi'),
                Forms\Components\DateTimePicker::make('departure_date')
                    ->label('Ayrılış Tarihi'),
                Forms\Components\Checkbox::make('check_in'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                Tables\Actions\Action::make('download')
                    ->label('Excel Olarak İndir')
                    ->color('gray')
                    ->action(fn(): \Symfony\Component\HttpFoundation\BinaryFileResponse => Excel::download(new EventApplicationExport(), 'etkinlik-başvurulari.xlsx')),
                Tables\Actions\Action::make('create')
                    ->label('Başvuru Oluştur')
                    ->url(fn(): string => route('application.index', Event::first()->id))
                    ->openUrlInNewTab(),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Başvuru ID')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Başvuran')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('city.name')
                    ->label('Şehir')
                    ->sortable(),
                Tables\Columns\TextColumn::make('children_count')
                    ->counts('children')
                    ->formatStateUsing(function (int $state): string {
                        return $state + 1;
                    })
                    ->label('Katılımcı Sayısı')
                    ->sortable(),
                Tables\Columns\TextColumn::make('check_in')
                    ->label('Giriş Yapılma Tarihi')
                    ->sortable(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('event_id')
                    ->options(fn() => Event::pluck('name', 'id')->all())
                    ->searchable()
                    ->label('Etkinlik Adı'),
                Tables\Filters\Filter::make('check_in')
                    ->query(function (Builder $query) {
                        $query->whereNotNull('check_in');
                    })
                    ->label('Giriş Yapılma Tarihi'),
                Tables\Filters\Filter::make('dont_camping_equipment')
                    ->query(function (Builder $query) {
                        $query->where('dont_camping_equipment', true);
                    })
                    ->label('Kamp Ekipmanı Temin Edilecek Mi?'),
            ])
            ->actions([
                Tables\Actions\EditAction::make('Düzenle / Check-in')
                    ->mutateFormDataUsing(function (array $data): array {
                        if ($data['check_in'] === true) {
                            $data['check_in'] = now();
                        } else {
                            $data['check_in'] = null;
                        }

                        return $data;
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
                                                    ]),
                                            ])
                                    ])->collapsed(),
                                Forms\Components\Section::make('Kamp Malzemesi İstekleri')
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
                                    ])->collapsed(),
                                Forms\Components\Section::make('Getirilecek Ekipmanlar')
                                    ->schema([
                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\TextInput::make('telescope')
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
                                                    ->label('Bilgisayar Sayısı'),
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
                Tables\Actions\BulkActionGroup::make([
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [

        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canViewAny(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEventApplications::route('/'),
        ];
    }
}
