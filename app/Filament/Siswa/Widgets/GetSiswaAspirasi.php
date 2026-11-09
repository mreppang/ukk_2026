<?php

namespace App\Filament\Siswa\Widgets;

use App\Models\Aspirasi;
use App\Models\Siswa;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class GetSiswaAspirasi extends StatsOverviewWidget
{
    protected ?string $heading = 'Aspirasi Siswa';

    /**
     * @var array<string, mixed> | null
     */
    public ?array $filters = [];

    public function mount(): void
    {
        $this->filters = [
            'siswa_id' => null,
        ];
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('siswa_id')
                    ->label('Siswa')
                    ->options(Siswa::query()->pluck('nama', 'id'))
                    ->searchable()
                    ->live()
                    ->placeholder('Pilih siswa untuk melihat data'),
                $this->getSectionContentComponent(),
            ])
            ->statePath('filters');
    }

    protected function getStats(): array
    {
        $siswaId = $this->filters['siswa_id'] ?? null;

        if (blank($siswaId)) {
            return [
                Stat::make('Menunggu', 0),
                Stat::make('Proses', 0),
                Stat::make('Selesai', 0),
            ];
        }

        $counts = Aspirasi::query()
            ->where('siswa_id', $siswaId)
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return [
            Stat::make('Menunggu', $counts['menunggu'] ?? 0),
            Stat::make('Proses', $counts['proses'] ?? 0),
            Stat::make('Selesai', $counts['selesai'] ?? 0),
        ];
    }
}
