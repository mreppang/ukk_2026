<?php

namespace App\Filament\Siswa\Pages;

use App\Models\Aspirasi as AspirasiModel;
use App\Models\Category;
use App\Models\Siswa;
use Filament\Actions\Action;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Schema;

class Aspirasi extends Page
{
    protected string $view = 'filament.siswa.pages.aspirasi';

    /**
     * @var array<string, mixed> | null
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'status' => 'menunggu',
            'feedback' => '',
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->required(),
                TextInput::make('tempat')
                    ->required(),
                Textarea::make('deskripsi')
                    ->required()
                    ->columnSpanFull(),
                Hidden::make('feedback')
                    ->default(''),
                Hidden::make('status')
                    ->default('menunggu'),
                Select::make('siswa_id')
                    ->label('Siswa')
                    ->options(Siswa::query()->pluck('nama', 'id'))
                    ->searchable()
                    ->required(),
                Select::make('category_id')
                    ->label('Kategori')
                    ->options(Category::query()->pluck('nama', 'id'))
                    ->searchable()
                    ->required(),
            ])
            ->statePath('data');
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Form::make([
                    EmbeddedSchema::make('form'),
                ])
                    ->id('form')
                    ->livewireSubmitHandler('save')
                    ->footer([
                        Actions::make([
                            Action::make('save')
                                ->label('Simpan')
                                ->submit('save'),
                        ]),
                    ]),
            ]);
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $data['status'] = 'menunggu';
        $data['feedback'] = '';

        AspirasiModel::create($data);

        $this->form->fill([
            'status' => 'menunggu',
            'feedback' => '',
        ]);

        Notification::make()
            ->success()
            ->title('Aspirasi berhasil dikirim')
            ->send();
    }
}
